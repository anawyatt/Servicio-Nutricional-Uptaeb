<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use \PDO;
use helpers\JwtHelpers;



class asistenciaModelo extends connectDB
{

    private $id;
    private $idmenu;
    private $horarioComida;

    private $cedula;
    private $nombre;
    private $apellido;
    private $sexo;
    private $nucleo;
    private $carrera;
    private $seccion;
    private $seccion2;
    private $justificativo;
    private $payload;
    private $horarios;
    private $descripcion;



    public function __construct()
    {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }


    public function infoStudy($id)
    {
        if (!preg_match("/^\d{6,10}$/", $id)) {
            return ['error' => 'Ingresar una cédula válida'];
        }

        $this->id = $id;
        return $this->Study();
    }

    private function Study()
    {
        try {
            $this->conectarDB();
            $query = $this->conex->prepare("SELECT * FROM vista_info_estudiante WHERE cedEstudiante = ?");
            $query->bindValue(1, $this->id);
            $query->execute();
            $data = $query->fetchAll();
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function obtenerIdMenu($idmenu)
    {
        $this->idmenu = $idmenu;
        return $this->IdMenu();
    }

    private function IdMenu()
    {
        try {
            $this->conectarDB();
            $query = $this->conex->prepare("SELECT idMenu FROM menu WHERE feMenu = CURRENT_DATE AND horarioComida = ? LIMIT 1;");
            $query->bindValue(1, $this->idmenu);
            $query->execute();
            $data = $query->fetchAll();
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }


    public function platosDisponibles($horarioComida)
    {
        if (!preg_match("/^(Desayuno|Almuerzo|Merienda|Cena)$/", $horarioComida)) {
            $resultado = ['resultado' => 'Horario de comida inválido.'];
            return $resultado;
        }
        $this->horarioComida = $horarioComida;
        return $this->platosDisponibles2($horarioComida);
    }

    private function platosDisponibles2($horarioComida)
    {
        try {
            $this->conectarDB();
            $query = $this->conex->prepare("SELECT (m.cantPlatos - COALESCE(a.asistencia, 0)) AS platosDisponibles FROM menu m
            LEFT JOIN ( SELECT a.idMenu, COUNT(*) as asistencia FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu
            WHERE a.fecha = CURRENT_DATE AND m.horarioComida = ? GROUP BY a.idMenu ) a ON m.idMenu = a.idMenu
            WHERE m.feMenu = CURRENT_DATE AND m.horarioComida = ? AND m.status = 1 LIMIT 1;");

            $query->bindValue(1, $horarioComida);
            $query->bindValue(2, $horarioComida);
            $query->execute();

            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }



    public function verificarAsistenciaEstudiante($horarioComida, $id)
    {
        if (!preg_match("/^(Desayuno|Almuerzo|Merienda|Cena)$/", $horarioComida)) {
            $resultado = ['resultado' => 'Horario de comida inválido.'];
            return $resultado;
        }

        if (!preg_match("/^\d{6,10}$/", $id)) {
            $resultado = ['resultado' => 'Cedula de estudiante inválido.'];
            return $resultado;
        }
        $this->horarioComida = $horarioComida;
        $this->id = $id;
        return $this->verificarAsistenciaEstudiantePrivado($horarioComida, $id);
    }

    private function verificarAsistenciaEstudiantePrivado($horarioComida, $id)
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT a.cedEstudiante FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu 
                                              WHERE a.fecha = CURRENT_DATE AND m.horarioComida = ? AND a.cedEstudiante = ?");
            $mostrar->bindValue(1, $horarioComida);
            $mostrar->bindValue(2, $id);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();

            $mensaje = !empty($data) && isset($data[0]["cedEstudiante"])
                ? ['resultado' => 'ya ingreso al comedor']
                : ['resultado' => 'no ha ingresado al comedor'];
            return $mensaje;
        } catch (\PDOException $error) {
            $mensaje = ["Sistema" => "¡Error en el sistema!"];
            return $mensaje;
        }
    }



    public function verificarPorHorario($id)
    {
        if (!preg_match("/^\d{6,10}$/", $id)) {
            $resultado = ['resultado' => 'cedula de estudiante inválido.'];
            return $resultado;
        }
        $this->id = $id;
        return $this->verificarPorHorarioPrivado($id);
    }

    private function verificarPorHorarioPrivado($id)
    {
        date_default_timezone_set('America/Caracas');
        $fecha = date('Y-m-d');
        $diaSemana = $this->obtenerDiaSemana($fecha);

        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("
                SELECT h.dia 
                FROM estudiante e 
                INNER JOIN estudiante_seccion es ON e.cedEstudiante = es.cedEstudiante 
                INNER JOIN seccion s ON es.idSeccion = s.idSeccion 
                INNER JOIN horario h ON s.idSeccion = h.idSeccion 
                WHERE e.cedEstudiante = ? 
            ");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_ASSOC);
            $this->desconectarDB();

            $puedeComer = false;
            foreach ($data as $horario) {
                if ($horario['dia'] === $diaSemana) {
                    $puedeComer = true;
                    break;
                }
            }

            $mensaje = $puedeComer ? ['resultado' => 'puede comer'] : ['resultado' => 'no puede comer'];
            return $mensaje;
        } catch (\PDOException $error) {
            $mensaje = ["Sistema" => "¡Error en el sistema!"];
            return $mensaje;
        }
    }

    private function obtenerDiaSemana($fecha)
    {
        $diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        $numeroDia = date('w', strtotime($fecha));
        return $diasSemana[$numeroDia];
    }


    // Registrar asistencia

    public function registrarAsistencia($id, $idmenu)
    {
        if (!preg_match("/^\d{6,10}$/", $id)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Cédula inválida'];
            return $resultado;
        }

        if (!preg_match("/^\d+$/", $idmenu)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'ID de menú inválido'];
            return $resultado;
        }

        $this->id = $id;
        $this->idmenu = $idmenu;

        return $this->registrar();
    }

    private function registrar()
    {
        try {
            $this->conectarDB();
            $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $this->conex->beginTransaction();

            $registrar = $this->conex->prepare("INSERT INTO `asistencia` (`cedEstudiante`, `fecha`, `hora`, `idMenu`, `status`) VALUES (?, DEFAULT, DEFAULT, ?, 1)");
            $registrar->bindValue(1, $this->id);
            $registrar->bindValue(2, $this->idmenu);
            $registrar->execute();

            $obtenerConteo = $this->conex->prepare("SELECT COUNT(*) as cantidad FROM asistencia WHERE fecha = CURRENT_DATE");
            $obtenerConteo->execute();
            $conteo = $obtenerConteo->fetchColumn();

            $this->conectarDBSeguridad();
            $verificarBitacora = $this->conex2->prepare("SELECT COUNT(*) FROM bitacora WHERE modulo = 'Asistencia' AND DATE(fecha) = CURRENT_DATE");
            $verificarBitacora->execute();
            $bitacoraHoy = $verificarBitacora->fetchColumn();

            $bitacora = new bitacoraModelo;

            if ($bitacoraHoy > 0) {
                $actualizarBitacora = $this->conex2->prepare("UPDATE bitacora SET acciones = CONCAT('Se han registrado ', ?, ' comensales') WHERE modulo = 'Asistencia' AND DATE(fecha) = CURRENT_DATE");
                $actualizarBitacora->bindValue(1, $conteo);
                $actualizarBitacora->execute();
            } else {
                $bitacora->registrarBitacora('Asistencia', 'Se han registrado ' . $conteo . ' comensales', $this->payload->cedula);
            }

            $this->conex->commit();

            $respuesta = ['resultado' => 'registro exitoso'];
            return $respuesta;
        } catch (\PDOException $error) {
            $this->conex->rollBack();
            $respuesta = ['resultado' => 'error'];
            return $respuesta;
        } finally {
            $this->desconectarDB();
        }
    }



    public function verificarCodigo($codigoIngresado, $codigo)
    {
        if (!preg_match("/^[\p{L}\p{N}\p{P}\s]+$/u", $codigoIngresado)) {
            return ['resultado' => 'El código es invalido'];
        }

        try {
            $data = $this->obtenercodigo($codigo);
            if (isset($data[0]->clave)) {
                return password_verify($codigoIngresado, $data[0]->clave);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return $e;
        }
    }

    protected function obtenercodigo($codigo)
    {
        try {
            $this->conectarDBSeguridad();
            $mostrar = $this->conex2->prepare("SELECT clave FROM usuario WHERE cedula = ? AND status = 1;");
            $mostrar->bindValue(1, $codigo);
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }



    /* ---------------------------------------EXCEPCION 1------------------------------------ */
    public function verificarCedula($cedula)
    {
        if (!preg_match("/^\d{6,10}$/", $cedula)) {
            $resultado = ['resultado' => 'Cédula inválida.'];
            return $resultado;
        }
        $this->cedula = $cedula;
        return $this->verificarCedulaPrivado($cedula);
    }

    private function verificarCedulaPrivado($cedula)
    {
        try {
            $this->conectarDB();
            $new = $this->conex->prepare("SELECT cedEstudiante FROM `estudiante` WHERE cedEstudiante = ? AND status = 1");
            $new->bindValue(1, $this->cedula);
            $new->execute();
            $data = $new->fetchAll();
            $this->desconectarDB();

            if (isset($data[0]["cedEstudiante"])) {
                $mensaje = ['resultado' => 'error Cedula'];
                return $mensaje;
            }

            $mensaje = ['resultado' => 'Cedula no registrada'];
            return $mensaje;
        } catch (\PDOException $e) {
            $mensaje = ['resultado' => '¡Error en el sistema!'];
            return $mensaje;
        }
    }


    public function mostrarNucleo()
    {

        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT nucleo FROM estudiante;");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function mostrarSeciones()
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM `seccion` WHERE status =1");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function mostrarCarreras()
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT carrera FROM estudiante;");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function mostrarHorarios($seccion)
    {
        $this->seccion = $seccion;
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT s.idSeccion, s.seccion, GROUP_CONCAT(DISTINCT h.dia ORDER BY h.dia SEPARATOR ', ') AS horario FROM seccion s JOIN horario h ON s.idSeccion = h.idSeccion WHERE s.status = 1 AND h.status = 1 AND s.idSeccion = ? GROUP BY s.idSeccion, s.seccion;");
            $mostrar->bindValue(1, $this->seccion);
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }


    public function registrarStudyExcepcion1($cedula, $nombre, $apellido, $sexo, $nucleo, $carrera, $seccion, $seccion2, $justificativo)
    {
        if (!preg_match("/^\d{6,10}$/", $cedula)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Cédula inválida'];
            return $resultado;
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Nombre o apellido inválido'];
            return $resultado;
        }

        if (strlen($justificativo) > 1000) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Justificativo demasiado largo'];
            return $resultado;
        }

        $nombre = $this->normalizarTexto($nombre);
        $apellido = $this->normalizarTexto($apellido);
        $justificativo = $this->normalizarTexto($justificativo);

        // Asignar valores
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->sexo = $sexo;
        $this->nucleo = $nucleo;
        $this->carrera = $carrera;
        $this->seccion = $seccion;
        $this->seccion2 = $seccion2;
        $this->justificativo = $justificativo;

        return $this->registrarExcepcion1();
    }

    // Función simple para normalizar texto
    private function normalizarTexto($texto)
    {
        // Quitar espacios al inicio y final
        $texto = trim($texto);

        // Convertir a minúsculas
        $texto = mb_strtolower($texto, 'UTF-8');

        // Capitalizar primera letra de cada palabra
        $texto = mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');

        // Quitar espacios dobles o múltiples
        $texto = preg_replace('/\s+/', ' ', $texto);

        return $texto;
    }

    private function registrarExcepcion1()
    {
        try {
            $this->conectarDB();
            $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $this->conex->beginTransaction();

            // Registrar estudiante
            $registrar = $this->conex->prepare("INSERT INTO estudiante (cedEstudiante, nombre, apellido, sexo, nucleo, carrera, status) VALUES (?, ?, ?, ?, ?, ?, 1)");
            $registrar->bindValue(1, $this->cedula);
            $registrar->bindValue(2, $this->nombre);
            $registrar->bindValue(3, $this->apellido);
            $registrar->bindValue(4, $this->sexo);
            $registrar->bindValue(5, $this->nucleo);
            $registrar->bindValue(6, $this->carrera);
            $registrar->execute();

            // Registrar secciones y justificativo
            $this->registrarSeccionEstudiante();
            $this->registrarJustificativo();

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora(
                'Asistencia',
                'Se Registró un estudiante con Excepción, cédula: ' . $this->cedula . ', nombre: ' . $this->nombre . ', apellido: ' . $this->apellido,
                $this->payload->cedula
            );

            // Confirmar transacción
            $this->conex->commit();

            // Respuesta
            $resultado = ['resultado' => 'registro del Estudiante'];
            return $resultado;
        } catch (\PDOException $error) {
            $this->conex->rollBack();
            $mensaje = ['resultado' => 'error', 'mensaje' => 'Error al registrar la excepción: ' . $error->getMessage()];
            return $mensaje;
        } finally {
            $this->desconectarDB();
        }
    }   


    private function registrarSeccionEstudiante()
    {
        $secciones = [$this->seccion, $this->seccion2];
        try {
            foreach ($secciones as $seccion) {
                if ($seccion != 'Seleccionar' && !empty($seccion)) {

                    $validarSeccion = $this->conex->prepare("SELECT COUNT(*) FROM seccion WHERE idSeccion = ?");
                    $validarSeccion->bindValue(1, $seccion);
                    $validarSeccion->execute();
                    $seccionExistente = $validarSeccion->fetchColumn();

                    if ($seccionExistente > 0) {
                        $registrar = $this->conex->prepare("INSERT INTO estudiante_seccion (idEstudianteSeccion, cedEstudiante, idSeccion) VALUES (DEFAULT, ?, ?)");
                        $registrar->bindValue(1, $this->cedula);
                        $registrar->bindValue(2, $seccion);
                        $registrar->execute();
                    } else {
                        throw new \Exception('La sección ' . $seccion . ' no existe.');
                    }
                }
            }
        } catch (\PDOException $error) {
            die('Error al registrar la sección del estudiante: ' . $error->getMessage());
        }
    }

    private function registrarJustificativo()
    {
        try {
            $registrar = $this->conex->prepare("INSERT INTO excepcion (idExc, descripcion, cedEstudiante, fecha, status) VALUES (DEFAULT, ?, ?, DEFAULT, 1)");
            $registrar->bindValue(1, $this->justificativo);
            $registrar->bindValue(2, $this->cedula);
            $registrar->execute();
        } catch (\PDOException $error) {
            die('Error al registrar el justificativo: ' . $error->getMessage());
        }
    }






    ///------------------ EXCEPCION 2 ----------

    public function verificarExistenciaEstudiante($cedula)
    {
        if (!preg_match("/^\d{6,10}$/", $cedula)) {
            $resultado = ['resultado' => 'Cédula inválida.'];
            return $resultado;
        }
        $this->cedula = $cedula;
        return $this->verificarExistenciaEstudiantePrivado($cedula);
    }

    private function verificarExistenciaEstudiantePrivado($cedula)
    {
        try {
            $this->conectarDB();
            $new = $this->conex->prepare("SELECT cedEstudiante FROM `estudiante` WHERE cedEstudiante = ? AND status = 1");
            $new->bindValue(1, $this->cedula);
            $new->execute();
            $data = $new->fetchAll();
            $this->desconectarDB();

            if (isset($data[0]["cedEstudiante"])) {
                $mensaje = ['resultado' => 'exito'];
            } else {
                $mensaje = ['resultado' => 'error Cedula'];
            }

            return $mensaje;
        } catch (\PDOException $e) {
            $mensaje = ['resultado' => 'Error en el sistema.'];
            return $mensaje;
        }
    }



    public function verificarAsistenciaEstudiante2($horarioComida, $cedula)
    {
        if (!preg_match("/^(Desayuno|Almuerzo|Merienda|Cena)$/", $horarioComida)) {
            $resultado = ['resultado' => 'Horario de comida inválido.'];
            return $resultado;
        }

        if (!preg_match("/^\d{6,10}$/", $cedula)) {
            $resultado = ['resultado' => 'Cédula inválida.'];
            return $resultado;
        }

        $this->horarioComida = $horarioComida;
        $this->cedula = $cedula;

        return $this->verificarAsistenciaEstudiantePrivado2($horarioComida, $cedula);
    }

    private function verificarAsistenciaEstudiantePrivado2($horarioComida, $cedula)
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT a.cedEstudiante FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu WHERE a.fecha = CURRENT_DATE AND m.horarioComida = ? AND a.cedEstudiante = ?");
            $mostrar->bindValue(1, $this->horarioComida);
            $mostrar->bindValue(2, $this->cedula);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();

            if (isset($data[0]["cedEstudiante"])) {
                $mensaje = ['resultado' => 'ya ingreso al comedor2'];
            } else {
                $mensaje = ['resultado' => 'no ingreso al comedor'];
            }
            return $mensaje;
        } catch (\PDOException $error) {
            $mensaje = ['resultado' => 'Error en el sistema.'];
            return $mensaje;
        }
    }


    public function registrarStudyExcepcion2($cedula, $idmenu, $justificativo)
    {
        if (!preg_match("/^\d{6,10}$/", $cedula)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Cédula inválida'];
            return $resultado;
        }

        if (!preg_match("/^[1-9]\d*$/", $idmenu)) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'ID de menú inválido'];
            return $resultado;
        }

        if (strlen($justificativo) > 255) {
            $resultado = ['resultado' => 'error', 'mensaje' => 'Justificativo demasiado largo'];
            return $resultado;
        }

        $this->cedula = $cedula;
        $this->idmenu = $idmenu;
        $this->justificativo = $justificativo;

        return $this->registrarExcepcion2();
    }

    private function registrarExcepcion2()
    {
        try {
            $this->conectarDB();
            $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $this->conex->beginTransaction();

            // Registrar asistencia
            $registrar = $this->conex->prepare("INSERT INTO `asistencia` (`cedEstudiante`, `fecha`, `hora`, `idMenu`, `status`) VALUES (?, DEFAULT, DEFAULT, ?, 1)");
            $registrar->bindValue(1, $this->cedula);
            $registrar->bindValue(2, $this->idmenu);
            $registrar->execute();

            // Registrar justificativo
            $this->registrarJustificativo();

            // Actualizar conteo y bitácora
            $obtenerConteo = $this->conex->prepare("SELECT COUNT(*) as cantidad FROM asistencia WHERE fecha = CURRENT_DATE");
            $obtenerConteo->execute();
            $conteo = $obtenerConteo->fetchColumn();

            // Conectar a la base de datos de seguridad
            $this->conectarDBSeguridad();
            $verificarBitacora = $this->conex2->prepare("SELECT COUNT(*) FROM bitacora WHERE modulo = 'Asistencia' AND DATE(fecha) = CURRENT_DATE");
            $verificarBitacora->execute();
            $bitacoraHoy = $verificarBitacora->fetchColumn();

            $bitacora = new bitacoraModelo;
            if ($bitacoraHoy > 0) {
                $actualizarBitacora = $this->conex2->prepare("UPDATE bitacora SET acciones = CONCAT('Se han registrado ', ?, ' comensales') WHERE modulo = 'Asistencia' AND DATE(fecha) = CURRENT_DATE");
                $actualizarBitacora->bindValue(1, $conteo);
                $actualizarBitacora->execute();
            } else {
                $bitacora->registrarBitacora('Asistencia', 'Se han registrado ' . $conteo . ' comensales', $this->payload->cedula);
            }

            // Confirmar la transacción
            $this->conex->commit();

            $resultado = ['resultado' => 'registro del Estudiante'];
            return $resultado;
        } catch (\PDOException $error) {
            $this->conex->rollBack();
            $mensaje = ['resultado' => 'error', 'mensaje' => 'Error al registrar la excepción: ' . $error->getMessage()];
            return $mensaje;
        } finally {
            $this->desconectarDB();
        }
    }
}
