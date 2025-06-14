<?php 
namespace config\connect;

use config\componentes\configSistema as configSistema;
use \PDO;

class connectDB extends configSistema {

    protected $conex;
    protected $conex2;
    protected $cerrarConex;
    protected $puerto;
    protected $user;
    protected $password;
    protected $local;
    protected $nameDB;
    protected $nameDB2;

    public function __construct(){
        $this->user = $this->_USER_();
        $this->password = $this->_PASS_();
        $this->local = $this->_LOCAL_();
        $this->nameDB = $this->_BD_();
        $this->nameDB2 = $this->_BD2_();
    }

    protected function conectarDB(){
        try {
            $this->conex = new \PDO("mysql:host={$this->local};dbname={$this->nameDB}", $this->user , $this->password);
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log("Error en conectarDB: " . $e->getMessage());
            throw $e;
        }
    }

    protected function conectarDBSeguridad(){
        try {
            $this->conex2 = new \PDO("mysql:host={$this->local};dbname={$this->nameDB2}", $this->user , $this->password);
            $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log("Error en conectarDBSeguridad: " . $e->getMessage());
            throw $e;
        }
    }

    protected function desconectarDB(){
        $this->conex = null;  
        $this->conex2 = null;
    }

    public function getPermisosRol($rol){
        $this->rol = $rol;
        return $this->consultarPermisos();
    }

    private function consultarPermisos(){
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare('SELECT idModulo, nombreModulo FROM modulo');
            $new->execute();
            $modulos = $new->fetchAll(\PDO::FETCH_OBJ);
            $permisos = [];
            foreach ($modulos as $modulo) { $permisos[$modulo->nombreModulo] = ''; }

            $query = 'SELECT modulo.nombreModulo, permiso.nombrePermiso, permiso.status 
                      FROM permiso INNER JOIN modulo ON modulo.idModulo = permiso.idModulo 
                      WHERE permiso.idRol = ? AND modulo.nombreModulo = ? AND permiso.status = 1;';

            foreach ($permisos as $nombre_modulo => $valor) {
                $new = $this->conex2->prepare($query);
                $new->bindValue(1, $this->rol);
                $new->bindValue(2, $nombre_modulo);
                $new->execute();
                $data = $new->fetchAll(\PDO::FETCH_OBJ);

                $acciones = []; 

                foreach($data as $modulo){
                    $acciones[$modulo->nombrePermiso] = $modulo->status;
                }
                $permisos[$nombre_modulo] = $acciones;
            }

            $this->desconectarDB();
            return $permisos;
        } catch (\PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    } 
}

 ?>