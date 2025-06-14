<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use \PDO;
use helpers\encryption;
use PhpOffice\PhpSpreadsheet\IOFactory;
use modelo\EstudianteNormalizer as EstudianteNormalizer;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;



class estudiantesModelo extends connectDB
{

    private $id;
    private $cedula;
    private $nombre;
    private $sexo;
    private $secciones;
    private $horarios;
    private $segNombre;
    private $apellido;
    private $segApellido;
    private $telefono;
    private $nucleo;
    private $carrera;
    private $encryption;
    private $normalizer;



    public function __construct()
    {
        parent::__construct();
        $this->encryption = new encryption();
        $this->normalizer = new EstudianteNormalizer();
    }

    public function mostrarEstudiantes($start = 0, $length = 10, $search = '', $orderBy = 'cedEstudiante', $orderDirection = 'ASC')
    {
        try {
            $this->conectarDB();

            // Query base
            $baseQuery = "FROM vista_estudiantes_con_secciones";

            // Construir WHERE para búsqueda
            $whereClause = "";
            $params = [];

            if (!empty($search)) {
                $whereClause = " WHERE (
                cedEstudiante LIKE :search OR 
                nombre LIKE :search OR 
                apellido LIKE :search OR 
                carrera LIKE :search OR 
                seccion LIKE :search
            )";
                $params[':search'] = "%{$search}%";
            }

            // Validar columna de ordenamiento
            $validColumns = ['cedEstudiante', 'nombre', 'apellido', 'carrera', 'seccion'];
            if (!in_array($orderBy, $validColumns)) {
                $orderBy = 'cedEstudiante';
            }

            // Validar dirección de ordenamiento
            $orderDirection = strtoupper($orderDirection) === 'DESC' ? 'DESC' : 'ASC';

            // Contar total de registros (sin filtros)
            $totalQuery = "SELECT COUNT(*) as total " . $baseQuery;
            $totalStmt = $this->conex->prepare($totalQuery);
            $totalStmt->execute();
            $totalRecords = $totalStmt->fetch(\PDO::FETCH_OBJ)->total;

            // Contar registros filtrados
            $filteredQuery = "SELECT COUNT(*) as filtered " . $baseQuery . $whereClause;
            $filteredStmt = $this->conex->prepare($filteredQuery);
            foreach ($params as $key => $value) {
                $filteredStmt->bindValue($key, $value);
            }
            $filteredStmt->execute();
            $filteredRecords = $filteredStmt->fetch(\PDO::FETCH_OBJ)->filtered;

            // Query principal con paginación
            $dataQuery = "SELECT 
            cedEstudiante,
            nombre,
            apellido,
            carrera,
            seccion 
            " . $baseQuery . $whereClause . "
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT :start, :length";

            $dataStmt = $this->conex->prepare($dataQuery);

            // Bind parámetros de búsqueda
            foreach ($params as $key => $value) {
                $dataStmt->bindValue($key, $value);
            }

            // Bind parámetros de paginación
            $dataStmt->bindValue(':start', $start, \PDO::PARAM_INT);
            $dataStmt->bindValue(':length', $length, \PDO::PARAM_INT);

            $dataStmt->execute();
            $data = $dataStmt->fetchAll(\PDO::FETCH_OBJ);

            // Procesar datos (encriptar cédulas)
            foreach ($data as $item) {
                if (isset($item->cedEstudiante)) {
                    $item->cedulaEncriptada = $this->encryption->encryptData($item->cedEstudiante);
                }
            }

            $this->desconectarDB();

            return [
                'total' => $totalRecords,
                'filtered' => $filteredRecords,
                'data' => $data
            ];
        } catch (\PDOException $e) {
            error_log("Error en mostrarEstudiantesServerSide: " . $e->getMessage());
            $this->desconectarDB();

            return [
                'total' => 0,
                'filtered' => 0,
                'data' => [],
                'error' => 'Error interno al mostrar estudiantes'
            ];
        }
    }




    public function infoStudy($idEncriptado)
    {
        try {
            $this->conectarDB();
            $id = $this->encryption->decryptData($idEncriptado);
            $query = $this->conex->prepare("SELECT * FROM vista_info_estudiante WHERE cedEstudiante = ?");
            $query->bindValue(1, $id);
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            error_log("Error en infoStudy: " . $e->getMessage());
            return false; // o puedes retornar ['error' => true] si prefieres
        }
    }



    public function verificarCodigo($codigoIngresado, $cedula)
    {
        try {
            $data = $this->obtenercodigo($cedula);
            if (isset($data[0]->clave)) {
                return password_verify($codigoIngresado, $data[0]->clave);
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }


    private function obtenercodigo($cedula)
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT clave FROM usuario WHERE cedula = ? AND status = 1;");
            $query->bindValue(1, $cedula);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $result;
        } catch (\PDOException $e) {
            return [];
        }
    }




    public function validarExcel($archivo)
    {
        // Verificar si hay error en la subida
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return [
                'valido' => false,
                'mensaje' => 'Error al subir el archivo. Código de error: ' . $archivo['error']
            ];
        }

        // Verificar que el archivo no esté vacío
        if ($archivo['size'] == 0) {
            return [
                'valido' => false,
                'mensaje' => 'El archivo está vacío.'
            ];
        }

        // Tamaño máximo permitido (7MB)
        $maxSize = 7 * 1024 * 1024;
        if ($archivo['size'] > $maxSize) {
            return [
                'valido' => false,
                'mensaje' => 'El archivo excede el tamaño máximo permitido de 7MB. Tamaño actual: ' . round($archivo['size'] / (1024 * 1024), 2) . 'MB'
            ];
        }

        // Validar extensión del archivo
        $nombreArchivo = $archivo['name'];
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        $extensionesValidas = ['xls', 'xlsx'];

        if (!in_array($extension, $extensionesValidas)) {
            return [
                'valido' => false,
                'mensaje' => 'La extensión del archivo no es válida. Solo se permiten archivos .xls y .xlsx'
            ];
        }

        // Verificar MIME type del archivo
        $tiposValidos = [
            'application/vnd.ms-excel', // .xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
            'application/octet-stream' // Algunos navegadores envían este tipo
        ];

        $tipoMime = mime_content_type($archivo['tmp_name']);
        if (!in_array($tipoMime, $tiposValidos)) {
            return [
                'valido' => false,
                'mensaje' => 'El tipo de archivo no es válido. Solo se permiten archivos Excel (.xls, .xlsx)'
            ];
        }

        // Validar integridad del archivo con PhpSpreadsheet
        try {
            // Intentar crear un reader para el archivo
            $reader = IOFactory::createReaderForFile($archivo['tmp_name']);
            $reader->setReadDataOnly(true); // Solo leer datos, no formato

            // Intentar cargar el archivo
            $spreadsheet = $reader->load($archivo['tmp_name']);

            // Verificar que tenga al menos una hoja
            if ($spreadsheet->getSheetCount() == 0) {
                return [
                    'valido' => false,
                    'mensaje' => 'El archivo Excel no contiene hojas de cálculo.'
                ];
            }

            // Verificar que la primera hoja no esté vacía
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            if ($highestRow < 2) { // Menos de 2 filas (header + al menos 1 dato)
                return [
                    'valido' => false,
                    'mensaje' => 'El archivo Excel debe contener al menos una fila de encabezados y una fila de datos.'
                ];
            }

            // Limpiar memoria
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return [
                'valido' => false,
                'mensaje' => 'El archivo está dañado o no es un archivo Excel válido: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'valido' => false,
                'mensaje' => 'Error al procesar el archivo: ' . $e->getMessage()
            ];
        }

        // Si llegamos aquí, el archivo es válido
        return ['valido' => true];
    }


    private function escanearArchivoMalicioso($rutaArchivo)
    {
        // Patrones sospechosos en archivos
        $patronesSospechosos = [
            'script',
            'javascript',
            'vbscript',
            'onload',
            'onerror',
            'eval(',
            'exec(',
            'system(',
            'shell_exec',
            'base64_decode'
        ];

        // Leer una muestra del archivo para buscar patrones sospechosos
        $contenido = file_get_contents($rutaArchivo, false, null, 0, 8192); // Primeros 8KB
        $contenidoMinuscula = strtolower($contenido);

        foreach ($patronesSospechosos as $patron) {
            if (strpos($contenidoMinuscula, $patron) !== false) {
                return true; // Archivo sospechoso
            }
        }

        return false; // Archivo parece seguro
    }



    private function registrarSeccion($seccion)
    {
        try {

            // Verificar si la sección ya existe

            $query = $this->conex->prepare("SELECT idSeccion FROM seccion WHERE seccion = ?");
            $query->bindValue(1, $seccion);
            $query->execute();
            $idSeccion = $query->fetchColumn();

            // Si no existe, insertar la nueva sección
            if (!$idSeccion) {
                $query = $this->conex->prepare("INSERT INTO seccion (seccion, status) VALUES (?, 1)");
                $query->bindValue(1, $seccion);
                $query->execute();
                $idSeccion = $this->conex->lastInsertId();
            }

            return $idSeccion;
        } catch (\PDOException $e) {
            return $e;
        }
    }


    private function registrarHorario($dia, $idSeccion)
    {

        try {

            // Verificar si el horario ya existe
            $query = $this->conex->prepare("SELECT COUNT(*) FROM horario WHERE dia = ? AND idSeccion = ?");
            $query->bindValue(1, $dia);
            $query->bindValue(2, $idSeccion);
            $query->execute();
            $exists = $query->fetchColumn();

            // Si no existe, insertar el nuevo horario
            if ($exists == 0) {
                $query = $this->conex->prepare("INSERT INTO horario (dia, idSeccion, status) VALUES (?, ?, 1)");
                $query->bindValue(1, $dia);
                $query->bindValue(2, $idSeccion);
                $query->execute();
            }
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function registrarEstudiante($cedula, $nombre, $segNombre, $apellido, $segApellido, $sexo, $telefono, $nucleo, $carrera, $secciones, $horarios)
    {
        // Crear array de datos para normalizar
        $datosOriginales = [
            'Cedula' => $cedula,
            'Nombre' => $nombre,
            'Segundo Nombre' => $segNombre,
            'Apellido' => $apellido,
            'Segundo Apellido' => $segApellido,
            'Sexo' => $sexo,
            'Telefono' => $telefono,
            'Nucleo' => $nucleo,
            'Carrera' => $carrera,
            'Seccion' => is_array($secciones) ? implode(',', $secciones) : $secciones,
            'Horario' => $horarios
        ];

        // Normalizar datos
        $datosNormalizados = $this->normalizer->normalizarDatosEstudiante($datosOriginales);

        // Asignar datos normalizados a propiedades
        $this->cedula = $datosNormalizados['cedula'];
        $this->nombre = $datosNormalizados['nombre'];
        $this->segNombre = $datosNormalizados['segNombre'];
        $this->apellido = $datosNormalizados['apellido'];
        $this->segApellido = $datosNormalizados['segApellido'];
        $this->sexo = $datosNormalizados['sexo'];
        $this->telefono = $datosNormalizados['telefono'];
        $this->nucleo = $datosNormalizados['nucleo'];
        $this->carrera = $datosNormalizados['carrera'];
        $this->secciones = $datosNormalizados['secciones'];
        $this->horarios = $datosNormalizados['horarios'];

        return $this->registrar();
    }


    private function verificarEstudianteExistente($cedula)
    {
        try {
            $query = $this->conex->prepare("SELECT COUNT(*) FROM estudiante WHERE cedEstudiante = ?");
            $query->bindValue(1, $cedula);
            $query->execute();
            return $query->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error al verificar estudiante: " . $e->getMessage());
            return 0;
        }
    }


    private function actualizarEstudiante($cedula, $nombre, $segNombre, $apellido, $segApellido, $sexo, $telefono, $nucleo, $carrera)
    {
        try {
            $query = $this->conex->prepare("UPDATE estudiante SET nombre = ?, segNombre = ?, apellido = ?, segApellido = ?, sexo = ?, telefono = ?, nucleo = ?, carrera = ? WHERE cedEstudiante = ?");
            $query->bindValue(1, $nombre);
            $query->bindValue(2, $segNombre);
            $query->bindValue(3, $apellido);
            $query->bindValue(4, $segApellido);
            $query->bindValue(5, $sexo);
            $query->bindValue(6, $telefono);
            $query->bindValue(7, $nucleo);
            $query->bindValue(8, $carrera);
            $query->bindValue(9, $cedula);
            $query->execute();
            return true;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    private function eliminarSecciones($cedula)
    {
        try {
            $query = $this->conex->prepare("DELETE FROM estudiante_seccion WHERE cedEstudiante = ?");
            $query->bindValue(1, $cedula);
            $query->execute();
        } catch (\PDOException $e) {
            return $e;
        }
    }

    private function registrarNuevoEstudiante($cedula, $nombre, $segNombre, $apellido, $segApellido, $sexo, $telefono, $nucleo, $carrera)
    {
        try {
            $query = $this->conex->prepare("INSERT INTO estudiante (cedEstudiante, nombre, segNombre, apellido, segApellido, sexo, telefono, nucleo, carrera, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
            $query->bindValue(1, $cedula);
            $query->bindValue(2, $nombre);
            $query->bindValue(3, $segNombre);
            $query->bindValue(4, $apellido);
            $query->bindValue(5, $segApellido);
            $query->bindValue(6, $sexo);
            $query->bindValue(7, $telefono);
            $query->bindValue(8, $nucleo);
            $query->bindValue(9, $carrera);
            $query->execute();
            return true;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    private function registrarEstudianteSeccion($cedula, $idSeccion)
    {
        try {
            $query = $this->conex->prepare("INSERT INTO estudiante_seccion (cedEstudiante, idSeccion) VALUES (?, ?)");
            $query->bindValue(1, $cedula);
            $query->bindValue(2, $idSeccion);
            $query->execute();
        } catch (\PDOException $e) {
            return $e;
        }
    }



    private function registrar()
    {
        try {
            $this->conectarDB();
            $this->conex->beginTransaction();

            $exists = $this->verificarEstudianteExistente($this->cedula);
            $esActualizacion = false;

            if ($exists > 0) {
                $this->actualizarEstudiante($this->cedula, $this->nombre, $this->segNombre, $this->apellido, $this->segApellido, $this->sexo, $this->telefono, $this->nucleo, $this->carrera);
                $this->eliminarSecciones($this->cedula);
                $esActualizacion = true;
            } else {
                $this->registrarNuevoEstudiante($this->cedula, $this->nombre, $this->segNombre, $this->apellido, $this->segApellido, $this->sexo, $this->telefono, $this->nucleo, $this->carrera);
            }

            // Procesar secciones y horarios
            foreach ($this->secciones as $seccion) {
                $idSeccion = $this->registrarSeccion($seccion);
                foreach (explode(',', $this->horarios) as $dia) {
                    $this->registrarHorario(trim($dia), $idSeccion);
                }
                $this->registrarEstudianteSeccion($this->cedula, $idSeccion);
            }

            $this->conex->commit();

            if ($esActualizacion) {
                return "La cédula {$this->cedula} ya está actualizada.";
            } else {
                return "Estudiante registrado con éxito.";
            }
        } catch (\PDOException $e) {
            $this->conex->rollBack();
            throw new \Exception('Hubo un problema con el registro: ' . $e->getMessage());
        } finally {
            $this->desconectarDB();
        }
    }
}
