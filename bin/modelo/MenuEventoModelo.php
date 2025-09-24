<?php   

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
use modelo\reporteModelo as reporte;
use helpers\JwtHelpers;

class MenuEventoModelo extends connectDB {

    private $fechaInicio;
    private $fechaFin;

    private $id;
    private $idMenu;
    public $payload;
    private $limit;
    private $offset;

    public function __construct(){
        parent ::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function mostrarM($fechaInicio, $fechaFin, $limit, $offset) {
        if (!preg_match("/^(?:\s*|((19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])))$/", $fechaInicio)) {
            return ['La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía'];
        }

        if (!preg_match("/^(?:\s*|((19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])))$/", $fechaFin)) {
            return ['La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía'];
        }

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->limit = $limit;
        $this->offset = $offset;
        return $this->mostrarMenu();
    }

    private function mostrarMenu() {
        try {
            if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
                return $this->mostrarMConFiltros();
            } else {
                return $this->mostrarMSinFiltros();
            }
        } catch (\Exception $e) {
            return ["Sistema", "¡Error Sistema!"];
        }
    }

    private function mostrarMConFiltros() {
        try {
            $this->conectarDB();
            $info = $this->conex->prepare("SELECT m.idMenu, m.feMenu, m.horarioComida, m.cantPlatos, MAX(sa.descripcion) AS descripcion  
            FROM menu m LEFT JOIN detalleSalidaMenu ds ON m.idMenu = ds.idMenu LEFT JOIN salidaAlimentos sa ON ds.idSalidaA = sa.idSalidaA  
            WHERE m.status = 1 AND m.feMenu BETWEEN ? AND ? AND NOT EXISTS (SELECT 1 FROM evento e WHERE e.idMenu = m.idMenu)  
            GROUP BY m.idMenu, m.feMenu, m.horarioComida, m.cantPlatos ORDER BY m.feMenu ASC, m.horarioComida LIMIT ? OFFSET ?;");

            $info->bindValue(1, $this->fechaInicio);
            $info->bindValue(2, $this->fechaFin);
            $info->bindValue(3, $this->limit, PDO::PARAM_INT);
            $info->bindValue(4, $this->offset, PDO::PARAM_INT);
            $info->execute();
            $resultado = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
            $this->desconectarDB();

            return $resultado;
        } catch (\Exception $error) {
            return ["Sistema", "¡Error Sistema!"];
        }
    }

    private function mostrarMSinFiltros() {
        try {
            $this->conectarDB();
            $info = $this->conex->prepare("SELECT m.idMenu, m.feMenu, m.horarioComida, m.cantPlatos, MAX(sa.descripcion) AS descripcion
            FROM menu m LEFT JOIN detalleSalidaMenu ds ON m.idMenu = ds.idMenu LEFT JOIN salidaAlimentos sa ON ds.idSalidaA = sa.idSalidaA
            WHERE m.status = 1 AND m.feMenu >= CURDATE() AND NOT EXISTS (SELECT 1 FROM evento e WHERE e.idMenu = m.idMenu)
            GROUP BY m.idMenu, m.feMenu, m.horarioComida, m.cantPlatos ORDER BY m.feMenu ASC, m.horarioComida LIMIT ? OFFSET ?;");

            $info->bindValue(1, $this->limit, PDO::PARAM_INT);
            $info->bindValue(2, $this->offset, PDO::PARAM_INT);
            $info->execute();
            $resultado = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
            $this->desconectarDB();

            return $resultado;
        } catch (\Exception $error) {
            return ["Sistema", "¡Error Sistema!"];
        }
    }
        public function infoApp($idMenu) {
            if (!preg_match("/^[0-9]{1,}$/", $idMenu)) {
                return ['Ingresar Menú'];
            }

            $this->idMenu = $idMenu;
            return $this->mostarApp();
        }


        private function mostarApp(){
            try {
                $this->conectarDB();
                $query = $this->conex->prepare("SELECT a.idAlimento, a.imgAlimento,a.nombre, a.marca, a.unidadMedida, 
                dsm.cantidad, ta.idTipoA, ta.tipo, m.idMenu, sa.descripcion, sa.idSalidaA FROM salidaalimentos sa
                INNER JOIN detallesalidamenu dsm ON dsm.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento
                INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA INNER JOIN menu m ON m.idMenu = dsm.idMenu
                WHERE m.idMenu = ? AND m.status = 1 AND sa.status = 1;");

                $query->bindValue(1, $this->idMenu);
                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC); 
                 $this->desconectarDB();
        
                return $resultado;
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }
        

        
    
}

?>



