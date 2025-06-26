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
            $BD1 = $carpeta . 'comedorUptaeb.sql';
            $BD2 = $carpeta . 'seguridad.sql';
            date_default_timezone_set('America/Caracas');

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true); 
            }

            $this->conectarDB();
            $this->conectarDBSeguridad();

            $rutaMysqldump = "C:/xampp/mysql/bin/mysqldump.exe";

            if (!file_exists($rutaMysqldump)) {
                $mensaje = ['resultado' => 'mysqldump no encontrado en la ruta especificada'];
                echo json_encode($mensaje);
                die();
            }

            $comandoExportarBD1 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB > $BD1";
            $comandoExportarBD2 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 > $BD2";

            exec($comandoExportarBD1 . ' 2>&1', $output1, $return_var1); 
            exec($comandoExportarBD2 . ' 2>&1', $output2, $return_var2); 

            if ($return_var1 === 0 && $return_var2 === 0) {
                $fechaHora = date("Y-m-d H:i:s");
                $mensajeBitacora = 'Último  Mantenimiento (Exportación) realizado el ' . $fechaHora;
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Mantenimiento', $mensajeBitacora, $this->payload->cedula);
                
                $mensaje = ['resultado' => 'exportación BD exitosa', 'msj'=>$mensajeBitacora];
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
            $BD1 = $carpeta . 'comedorUptaeb.sql';
            $BD2 = $carpeta . 'seguridad.sql';
            date_default_timezone_set('America/Caracas');

            $this->conectarDB();
            $this->conectarDBSeguridad();

            if (file_exists($BD1) && file_exists($BD2)) {

                $rutaMysql = "C:/xampp/mysql/bin/mysql.exe";
                $comandoImportarBD1 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB < $BD1";
                exec($comandoImportarBD1 . ' 2>&1', $output1, $return_var1);

                $comandoImportarBD2 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 < $BD2";
                exec($comandoImportarBD2 . ' 2>&1', $output2, $return_var2);

                if ($return_var1 === 0 && $return_var2 === 0) {
                    $fechaHora = date("Y-m-d H:i:s");
                    $mensajeBitacora = 'Último Mantenimiento (Importación) realizado el ' . $fechaHora;
                    $bitacora = new bitacoraModelo;
                    $bitacora->registrarBitacora('Mantenimiento', $mensajeBitacora, $this->payload->cedula);
                    
                    $mensaje = ['resultado' => 'importación BD exitosa',  'msj'=>$mensajeBitacora];
                } else {
                    $mensaje = [
                        'resultado' => 'ERROR en la importación',
                        'errorBD1' => implode("\n", $output1),
                        'errorBD2' => implode("\n", $output2)
                    ];
                }

            } else {
                $mensaje = ['resultado' => 'No existen los archivos de respaldo'];
            }

            $this->desconectarDB();
            echo json_encode($mensaje);
            die();

        } catch (PDOException $e) {
            echo json_encode(['resultado' => 'Error de conexión: ' . $e->getMessage()]);
            die();
        }
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
