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

        $comandoExportarBD1 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB > $BD1";

        $comandoExportarBD2 = "$rutaMysqldump --user=$this->user --password=$this->password --host=$this->local $this->nameDB2 > $BD2";

        exec($comandoExportarBD1 . ' 2>&1', $output, $return_var); 
        exec($comandoExportarBD2 . ' 2>&1', $output, $return_var); 

 
        $this->desconectarDB();

         if ($return_var === 0) {
            $mensaje = ['resultado' => 'exportación BD exitosa'];
            echo json_encode($mensaje);
            die();
        } else {
           $mensaje = ['resultado' => 'ERROR exportación BD '];
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

        if (file_exists($BD1) && file_exists($BD2) ) {
            $sql = file_get_contents($BD1);
            $sql2 = file_get_contents($BD2);

            $queries = explode(';', $sql);
            $queries2 = explode(';', $sql2);

            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) { 
                    $this->conex->exec($query);
                }
            }

            foreach ($queries2 as $query2) {
                $query2 = trim($query2);
                if (!empty($query2)) { 
                    $this->conex2->exec($query2);
                }
            }


            $mensaje = ['resultado' => 'importación BD exitosa'];
            echo json_encode($mensaje);
            die();
        } else {
            $mensaje = ['resultado' => 'No existe el archivo '];
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