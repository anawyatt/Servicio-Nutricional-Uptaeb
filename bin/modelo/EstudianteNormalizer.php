<?php  
namespace modelo;

class EstudianteNormalizer 
{
    // Mapeo de días para normalización de acentos
    private static $diasMapa = [
        'lunes' => 'Lunes',
        'martes' => 'Martes',
        'miercoles' => 'Miércoles',
        'miércoles' => 'Miércoles',
        'jueves' => 'Jueves',
        'viernes' => 'Viernes',
        'sabado' => 'Sábado',
        'sábado' => 'Sábado',
        'domingo' => 'Domingo'
    ];

    // Para almacenar errores durante la normalización
    private $errores = [];

    /**
     * Normaliza todos los datos del estudiante antes del registro
     * Ahora también valida y lanza excepciones si encuentra datos inválidos
     */
    public function normalizarDatosEstudiante($data)
    {
        $this->errores = []; // Resetear errores

        $resultado = [
            'cedula' => $this->normalizarCedula($data['Cedula'] ?? ''),
            'nombre' => $this->normalizarNombre($data['Nombre'] ?? ''),
            'segNombre' => $this->normalizarNombre($data['Segundo Nombre'] ?? ''),
            'apellido' => $this->normalizarNombre($data['Apellido'] ?? ''),
            'segApellido' => $this->normalizarNombre($data['Segundo Apellido'] ?? ''),
            'sexo' => $this->normalizarSexo($data['Sexo'] ?? ''),
            'telefono' => $this->normalizarTelefono($data['Telefono'] ?? ''),
            'nucleo' => $this->normalizarTexto($data['Nucleo'] ?? ''),
            'carrera' => $this->normalizarTexto($data['Carrera'] ?? ''),
            'secciones' => $this->normalizarSecciones($data['Seccion'] ?? ''),
            'horarios' => $this->normalizarHorarios($data['Horario'] ?? '')
        ];

        // Si hay errores, lanzar excepción
        if (!empty($this->errores)) {
            // Extraer solo el tipo de error, no el valor original
            $erroresSimplificados = array_map(function($err) {
                if (str_contains($err, 'Cédula')) return "Cédula inválida";
                if (str_contains($err, 'Nombre/Apellido')) return "Nombre o apellido inválido";
                if (str_contains($err, 'Sexo')) return "Sexo inválido";
                if (str_contains($err, 'Teléfono')) return "Teléfono inválido";
                if (str_contains($err, 'Texto')) return "Núcleo o carrera inválida";
                if (str_contains($err, 'Sección')) return "Sección inválida";
                if (str_contains($err, 'Horario')) return "Horario inválido";
                return "Dato inválido";
            }, $this->errores);

            throw new \Exception(implode(', ', array_unique($erroresSimplificados)));
        }


        return $resultado;
    }

    /**
     * Normaliza cédula - solo números
     */
    private function normalizarCedula($cedula)
    {
        $original = $cedula;
        $cedula = preg_replace('/[^0-9]/', '', trim($cedula));
        
        // Validar después de normalizar
        if (empty($cedula)) {
            $this->errores[] = "Cédula vacía";
        } elseif (!preg_match('/^\d+$/', $cedula) || strlen($cedula) < 6 || strlen($cedula) > 12) {
            $this->errores[] = "Cédula inválida (debe tener entre 6-12 números): '$original'";
        }
        
        return $cedula;
    }

    /**
     * Normaliza nombres y apellidos - Primera letra mayúscula, resto minúscula
     */
    private function normalizarNombre($nombre)
    {
        if (empty($nombre)) return '';
        
        $original = $nombre;
        $nombre = trim($nombre);
        
        // Validar ANTES de normalizar para detectar caracteres inválidos
        if (!preg_match("/^[\p{L}\s'-]+$/u", $nombre)) {
            $this->errores[] = "Nombre/Apellido contiene caracteres inválidos: '$original'";
            return $nombre; // Devolver sin normalizar para que se vea el error
        }
        
        if (strlen($nombre) < 2) {
            $this->errores[] = "Nombre/Apellido muy corto: '$original'";
            return $nombre;
        }
        
        // Convertir a minúsculas y luego capitalizar cada palabra
        $nombre = mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8');
        
        // Manejar casos especiales como "de", "del", "la", etc.
        $palabrasMinusculas = ['de', 'del', 'la', 'las', 'el', 'los', 'y'];
        $palabras = explode(' ', $nombre);
        
        for ($i = 1; $i < count($palabras); $i++) {
            if (in_array(mb_strtolower($palabras[$i], 'UTF-8'), $palabrasMinusculas)) {
                $palabras[$i] = mb_strtolower($palabras[$i], 'UTF-8');
            }
        }
        
        return implode(' ', $palabras);
    }

    /**
     * Normaliza texto general - Primera letra mayúscula por palabra
     */
    private function normalizarTexto($texto)
    {
        if (empty($texto)) return '';
        
        $original = $texto;
        $texto = trim($texto);
        
        // Validar caracteres permitidos para núcleo/carrera
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ0-9\s\.\-]+$/u', $texto)) {
            $this->errores[] = "Texto contiene caracteres inválidos: '$original'";
            return $texto;
        }
        
        if (strlen($texto) < 2) {
            $this->errores[] = "Texto muy corto: '$original'";
            return $texto;
        }
        
        return mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Normaliza sexo
     */
    private function normalizarSexo($sexo)
    {
        $original = $sexo;
        $sexo = mb_strtoupper(trim($sexo), 'UTF-8');
        
        if (in_array($sexo, ['M', 'F', 'MASCULINO', 'FEMENINO'])) {
            return in_array($sexo, ['M', 'MASCULINO']) ? 'M' : 'F';
        } else {
            $this->errores[] = "Sexo inválido: '$original' (debe ser M, F, Masculino o Femenino)";
            return $sexo;
        }
    }

    /**
     * Normaliza teléfono - formato 0XXX-XXXXXXX
     */
private function normalizarTelefono($telefono)
{
    if (empty($telefono)) return '';
    
    $original = $telefono;
    $numeros = preg_replace('/[^0-9]/', '', $telefono);

    // Si tiene 11 o 12 dígitos y empieza con 0
    if ((strlen($numeros) === 11 || strlen($numeros) === 12) && $numeros[0] === '0') {
        return substr($numeros, 0, 4) . '-' . substr($numeros, 4);
    }

    // Si tiene 10 dígitos, le agregamos un 0 al inicio
    if (strlen($numeros) === 10) {
        return '0' . substr($numeros, 0, 3) . '-' . substr($numeros, 3);
    }

    // Error
    if (!empty($original)) {
        $this->errores[] = "Teléfono inválido: '$original' (debe tener 10-12 dígitos)";
    }

    return $telefono;
}



    /**
     * Normaliza secciones
     */
    private function normalizarSecciones($secciones)
    {
        if (empty($secciones)) return [];
        
        $original = $secciones;
        $seccionesArray = explode(',', $secciones);
        $seccionesNormalizadas = [];
        
        foreach ($seccionesArray as $seccion) {
            $seccion = trim($seccion);
            if (!empty($seccion)) {
                // Validar formato de sección
                if (!preg_match('/^[A-Za-z0-9\-]+$/', $seccion)) {
                    $this->errores[] = "Sección inválida: '$seccion' en '$original'";
                    continue;
                }
                
                // Convertir a mayúsculas para códigos de sección
                $seccionesNormalizadas[] = mb_strtoupper($seccion, 'UTF-8');
            }
        }
        
        if (empty($seccionesNormalizadas)) {
            $this->errores[] = "No se encontraron secciones válidas en: '$original'";
        }
        
        return array_unique($seccionesNormalizadas);
    }

    /**
     * Normaliza horarios - corrige acentos y formato
     */
    private function normalizarHorarios($horarios)
    {
        if (empty($horarios)) return '';
        
        $original = $horarios;
        $diasArray = explode(',', $horarios);
        $diasNormalizados = [];
        $diasInvalidos = [];
        
        foreach ($diasArray as $dia) {
            $dia = trim($dia);
            if (!empty($dia)) {
                $diaNormalizado = $this->normalizarDia($dia);
                if ($diaNormalizado && $this->esDiaValido($diaNormalizado)) {
                    $diasNormalizados[] = $diaNormalizado;
                } else {
                    $diasInvalidos[] = $dia;
                }
            }
        }
        
        if (!empty($diasInvalidos)) {
            $this->errores[] = "Horarios inválidos";
        }
        
        if (empty($diasNormalizados)) {
            $this->errores[] = "Horarios inválidos";
        }
        
        return implode(', ', array_unique($diasNormalizados));
    }

    /**
     * Normaliza un día específico
     */
    private function normalizarDia($dia)
    {
        $diaLower = mb_strtolower(trim($dia), 'UTF-8');
        return self::$diasMapa[$diaLower] ?? mb_convert_case($dia, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Verifica si un día es válido
     */
    private function esDiaValido($dia)
    {
        $diasValidos = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        return in_array($dia, $diasValidos);
    }
}
?>