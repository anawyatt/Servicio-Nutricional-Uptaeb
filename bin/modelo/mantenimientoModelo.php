<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class mantenimientoModelo extends connectDB {

    private $BD1;
    private $BD2;
    private $payload;

    public function __construct(){
        parent::__construct(); 
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function exportarBD() {
    try {
        $carpeta = 'bin/config/sql/';
        date_default_timezone_set('America/Caracas');
        $fechaHora = date("Y-m-d_H-i-s"); // Formato seguro para nombres de archivo

        $BD1 = $carpeta . "comedorUptaeb_{$fechaHora}.sql";
        $BD2 = $carpeta . "seguridad_{$fechaHora}.sql";

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true); 
        }

        $this->conectarDB();
        $this->conectarDBSeguridad();

        $rutaMysqldump = "C:/xampp/mysql/bin/mysqldump.exe";
        if (!file_exists($rutaMysqldump)) {
            echo json_encode(['resultado' => 'mysqldump no encontrado']);
            die();
        }

        $comandoExportarBD1 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB > \"$BD1\"";
        $comandoExportarBD2 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 > \"$BD2\"";

        exec($comandoExportarBD1 . ' 2>&1', $output1, $return_var1); 
        exec($comandoExportarBD2 . ' 2>&1', $output2, $return_var2); 

        if ($return_var1 === 0 && $return_var2 === 0) {
            $mensajeBitacora = 'Último Mantenimiento (Exportación) realizado el ' . date("Y-m-d H:i:s");
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Mantenimiento', $mensajeBitacora, $this->payload->cedula);

            $mensaje = ['resultado' => 'exportación BD exitosa', 'msj' => $mensajeBitacora];
        } else {
            $mensaje = [
                'resultado' => 'ERROR exportación BD',
                'errorBD1' => implode("\n", $output1),
                'errorBD2' => implode("\n", $output2)
            ];
        }

        $this->desconectarDB();
        echo json_encode($mensaje);
        die();

    } catch (PDOException $e) {
        echo json_encode(['resultado' => 'Error de conexión: ' . $e->getMessage()]);
        die();
    }
}

public function importarBD() {
    try {
        $carpeta = 'bin/config/sql/';
        date_default_timezone_set('America/Caracas');

        $this->conectarDB();
        $this->conectarDBSeguridad();

        // Buscar el último archivo respaldado para cada BD
        $archivosBD1 = glob($carpeta . 'comedorUptaeb_*.sql');
        $archivosBD2 = glob($carpeta . 'seguridad_*.sql');

        $archivosBD1 = self::array_sort_by_mtime($archivosBD1);
        $archivosBD2 = self::array_sort_by_mtime($archivosBD2);

        $BD1 = !empty($archivosBD1) ? end($archivosBD1) : null;
        $BD2 = !empty($archivosBD2) ? end($archivosBD2) : null;

        if ($BD1 && $BD2 && file_exists($BD1) && file_exists($BD2)) {
            $rutaMysql = "C:/xampp/mysql/bin/mysql.exe";

            $comandoImportarBD1 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB < \"$BD1\"";
            exec($comandoImportarBD1 . ' 2>&1', $output1, $return_var1);

            $comandoImportarBD2 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 < \"$BD2\"";
            exec($comandoImportarBD2 . ' 2>&1', $output2, $return_var2);

            if ($return_var1 === 0 && $return_var2 === 0) {
                $mensajeBitacora = 'Último Mantenimiento (Importación) realizado el ' . date("Y-m-d H:i:s");
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Mantenimiento', $mensajeBitacora, $this->payload->cedula);
                $mensaje = ['resultado' => 'importación BD exitosa', 'msj' => $mensajeBitacora];
            } else {
                $mensaje = [
                    'resultado' => 'ERROR en la importación',
                    'errorBD1' => implode("\n", $output1),
                    'errorBD2' => implode("\n", $output2)
                ];
            }

        } else {
            $mensaje = ['resultado' => 'No se encontraron archivos de respaldo válidos'];
        }

        $this->desconectarDB();
        echo json_encode($mensaje);
        die();

    } catch (PDOException $e) {
        echo json_encode(['resultado' => 'Error de conexión: ' . $e->getMessage()]);
        die();
    }
}
private static function array_sort_by_mtime(array $files): array {
    usort($files, function ($a, $b) {
        return filemtime($a) <=> filemtime($b);
    });
    return $files;
}


    public function mostrarMensaje(){
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT acciones, fecha, hora FROM bitacora WHERE modulo = 'Mantenimiento' ORDER BY fecha DESC, hora DESC LIMIT 1;");
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch(PDOException $e) {
            echo json_encode(['resultado' => 'Error de conexión: ' . $e->getMessage()]);
            die();
        }
    }

}

?>
