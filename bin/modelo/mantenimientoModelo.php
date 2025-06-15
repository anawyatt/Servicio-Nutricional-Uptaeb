<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;


class mantenimientoModelo extends connectDB {

    private $BD1;
    private $BD2;


	public function __construct(){
        parent::__construct(); 
    }

	public function exportarBD() { 
    try {
        $carpeta = 'bin/config/sql/';
        $BD1 = $carpeta . 'comedorUptaeb.sql';
        $BD2 = $carpeta . 'seguridad.sql';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true); 
        }

        $this->conectarDB();
        $this->conectarDBSeguridad();

        $rutaMysqldump = "C:/xampp/mysql/bin/mysqldump.exe";

        if (!file_exists($rutaMysqldump)) {
           $mensaje= ['resultado' => 'mysqldump no encontrado en la ruta especificada'];
           echo json_encode($mensaje);
           die();
        }

        $parametrosExtra = "--routines --triggers  --single-transaction --add-drop-database";

        $comandoExportarBD1 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB > $BD1";

        $comandoExportarBD2 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 > $BD2";

        exec($comandoExportarBD1 . ' 2>&1', $output1, $return_var1); 
        exec($comandoExportarBD2 . ' 2>&1', $output2, $return_var2); 

        $this->desconectarDB();

        if ($return_var1 === 0 && $return_var2 === 0) {
           $mensaje= ['resultado' => 'exportación BD exitosa'];
           echo json_encode($mensaje);
           die();
        } else {
           $mensaje= [
                'resultado' => 'ERROR exportación BD',
                'errorBD1' => implode("\n", $output1),
                'errorBD2' => implode("\n", $output2)
            ];
            echo json_encode($mensaje);
           die();
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}

public function importarBD() {
    try {
        $carpeta = 'bin/config/sql/';
        $BD1 = $carpeta . 'comedorUptaeb.sql';
        $BD2 = $carpeta . 'seguridad.sql';

        $this->conectarDB();
        $this->conectarDBSeguridad();

        if (file_exists($BD1) && file_exists($BD2)) {

            $rutaMysql = "C:/xampp/mysql/bin/mysql.exe";
            $comandoImportarBD1 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB < $BD1";
            exec($comandoImportarBD1 . ' 2>&1', $output1, $return_var1);

            $comandoImportarBD2 = "$rutaMysql --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 < $BD2";
            exec($comandoImportarBD2 . ' 2>&1', $output2, $return_var2);

            if ($return_var1 === 0 && $return_var2 === 0) {
                $mensaje = ['resultado' => 'importación BD exitosa'];
                echo json_encode($mensaje);
                die();
            } else {
                $mensaje = [
                    'resultado' => 'ERROR en la importación',
                    'errorBD1' => implode("\n", $output1),
                    'errorBD2' => implode("\n", $output2)
                ];
                echo json_encode($mensaje);
                die();
            }

        } else {
            $mensaje = ['resultado' => 'No existen los archivos de respaldo'];
            echo json_encode($mensaje);
            die();
        }
    } catch (PDOException $e) {
        $mensaje = ['resultado' => 'Error de conexión: ' . $e->getMessage()];
        echo json_encode($mensaje);
        die();
    }
}

}

?>