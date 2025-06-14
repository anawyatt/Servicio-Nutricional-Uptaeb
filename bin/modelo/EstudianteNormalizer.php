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

    /**
     * Normaliza todos los datos del estudiante antes del registro
     */
    public function normalizarDatosEstudiante($data)
    {
        return [
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
    }

    /**
     * Normaliza cédula - solo números
     */
    private function normalizarCedula($cedula)
    {
        return preg_replace('/[^0-9]/', '', trim($cedula));
    }

    /**
     * Normaliza nombres y apellidos - Primera letra mayúscula, resto minúscula
     */
    private function normalizarNombre($nombre)
    {
        if (empty($nombre)) return '';
        
        $nombre = trim($nombre);
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
        return mb_convert_case(trim($texto), MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Normaliza sexo
     */
    private function normalizarSexo($sexo)
    {
        $sexo = mb_strtoupper(trim($sexo), 'UTF-8');
        return in_array($sexo, ['M', 'F', 'MASCULINO', 'FEMENINO']) ? 
               (in_array($sexo, ['M', 'MASCULINO']) ? 'M' : 'F') : $sexo;
    }

    /**
     * Normaliza teléfono - formato 0XXX-XXXXXXX
     */
    private function normalizarTelefono($telefono)
    {
        if (empty($telefono)) return '';
        
        // Extraer solo números
        $numeros = preg_replace('/[^0-9]/', '', $telefono);
        
        // Si tiene 11 dígitos, formatear como 0XXX-XXXXXXX
        if (strlen($numeros) === 11 && $numeros[0] === '0') {
            return substr($numeros, 0, 4) . '-' . substr($numeros, 4);
        }
        
        // Si tiene 10 dígitos, agregar 0 al inicio
        if (strlen($numeros) === 10) {
            return '0' . substr($numeros, 0, 3) . '-' . substr($numeros, 3);
        }
        
        return $telefono; // Devolver original si no cumple formato esperado
    }

    /**
     * Normaliza secciones
     */
    private function normalizarSecciones($secciones)
    {
        if (empty($secciones)) return [];
        
        $seccionesArray = explode(',', $secciones);
        $seccionesNormalizadas = [];
        
        foreach ($seccionesArray as $seccion) {
            $seccion = trim($seccion);
            if (!empty($seccion)) {
                // Convertir a mayúsculas para códigos de sección
                $seccionesNormalizadas[] = mb_strtoupper($seccion, 'UTF-8');
            }
        }
        
        return array_unique($seccionesNormalizadas);
    }

    /**
     * Normaliza horarios - corrige acentos y formato
     */
    private function normalizarHorarios($horarios)
    {
        if (empty($horarios)) return '';
        
        $diasArray = explode(',', $horarios);
        $diasNormalizados = [];
        
        foreach ($diasArray as $dia) {
            $dia = trim($dia);
            if (!empty($dia)) {
                $diaNormalizado = $this->normalizarDia($dia);
                if ($diaNormalizado) {
                    $diasNormalizados[] = $diaNormalizado;
                }
            }
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
}

?>