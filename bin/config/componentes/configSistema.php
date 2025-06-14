<?php 
namespace config\componentes;

class configSistema{

    public function _int(){
        if(!file_exists("bin/controlador/frontControlador.php")){
            return "Error configSistema";
        }
    }

    public function _URL_(){
        return $_ENV['APP_URL'] ?? null;
    }

    public function _BD_(){
        return $_ENV['DB_NAME1'] ?? null; 
    }

    public function _BD2_(){
        return $_ENV['DB_NAME2'] ?? null; 
    }

    public function _USER_(){
        return $_ENV['DB_USER'] ?? null;
    }

    public function _PASS_(){
        return $_ENV['DB_PASS'] ?? null;
    }

    public function _LOCAL_(){
        return $_ENV['DB_HOST'] ?? null; 
    }

    public function _Dir_(){
        return "bin/controlador/";  
    }

    public function _MODEL_(){
        return "modelo/";  
    }

    public function _Control_(){
        return "Controlador.php";  
    }
}

?>
