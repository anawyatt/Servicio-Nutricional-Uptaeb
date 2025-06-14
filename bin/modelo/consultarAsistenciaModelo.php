<?php 
namespace modelo;

use config\connect\connectDB as connectDB;
use modelo\reporteModelo as reporte; 
use helpers\JwtHelpers;

class consultarAsistenciaModelo extends connectDB{
    private $fecha;
    private $horario;
    private $payload; 
    private $horarioComida;
    public function __construct(){ 
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }
        public function mostrarFechas() {
            try {
                $this->conectarDB();

                $sql = "
                    SELECT DISTINCT a.fecha 
                    FROM asistencia a
                    INNER JOIN menu m ON m.idMenu = a.idMenu
                    WHERE a.status = 1
                ";

                $params = [];

                if (isset($this->payload->horario_comida)) {
                    $this->horario = $this->payload->horario_comida ?? null;
                    $sql .= " AND m.horarioComida = ?";
                    $params[] = $this->horario;
                }

                $sql .= " ORDER BY a.fecha DESC";

                $mostrar = $this->conex->prepare($sql);

                foreach ($params as $i => $param) {
                    $mostrar->bindValue($i + 1, $param);
                }

                $mostrar->execute();
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                $this->desconectarDB();

                return $data;

            } catch (\PDOException $e) {
                return ['error' => $e->getMessage()];
            }
        }

    public function mostrarHorarios($fecha) {
       
        if ($fecha !== 'Seleccionar' && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
            return ['resultado' => 'Fecha inválida.'];
        }
        
        $this->fecha = $fecha;
        return $this->mostrarHorarios2($fecha);
    }
    
        private function mostrarHorarios2($fecha) {
            try {
                $this->conectarDB();

                $sql = "
                    SELECT DISTINCT m.horarioComida 
                    FROM asistencia a 
                    INNER JOIN menu m ON a.idMenu = m.idMenu 
                    WHERE a.status = 1
                ";

                $params = [];

                if ($fecha !== 'Seleccionar') {
                    $sql .= " AND a.fecha = ?";
                    $params[] = $fecha;
                }

                $sql .= " ORDER BY m.horarioComida";

                $query = $this->conex->prepare($sql);

            
                foreach ($params as $i => $param) {
                    $query->bindValue($i + 1, $param);
                }

                $query->execute();
                $data = $query->fetchAll(\PDO::FETCH_ASSOC);
                $this->desconectarDB();

                return $data;
            } catch (\PDOException $e) {
                return ['error' => $e->getMessage()];
            }
        }
                
            public function mostrarAsistencia($fecha, $horarioComida) {
                if ($fecha !== 'Seleccionar' && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
                    return ['resultado' => 'Fecha inválida'];
                }

                if ($horarioComida !== 'Seleccionar' && !preg_match("/^(Desayuno|Almuerzo|Merienda|Cena)$/", $horarioComida)) {
                    return ['resultado' => 'Horario de comida inválido'];
                }

                $this->fecha = $fecha;
                $this->horarioComida = $horarioComida;

                return $this->mostrarAsistencia2();
            }

            private function mostrarAsistencia2() {
                try {
                    $this->conectarDB();

                    $fecha = ($this->fecha !== 'Seleccionar') ? $this->fecha : null;
                    $horario = ($this->payload->horario_comida ?? $this->horarioComida);
                    $horario = ($horario !== 'Seleccionar') ? $horario : null;

                    $query = $this->conex->prepare("CALL sp_mostrar_asistencia(?, ?)");
                    $query->bindValue(1, $fecha);
                    $query->bindValue(2, $horario);
                    $query->execute();

                    $data = $query->fetchAll(\PDO::FETCH_OBJ);
                    $query->closeCursor();

                    $this->desconectarDB();
                    return $data;

                } catch (\PDOException $e) {
                    return ['error' => $e->getMessage()];
                }
            }

            public function mostrarUltimaVez() {
                try {
                    $this->conectarDB();
                    $horario = $this->payload->horario_comida ?? null;
                    $stmt = $this->conex->prepare("CALL sp_mostrar_ultima_asistencia(?)");
                    $stmt->bindValue(1, $horario);
                    $stmt->execute();
                    $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
                    $stmt->closeCursor();

                    $this->desconectarDB();

                    return $data;

                } catch (\PDOException $e) {
                    return ['resultado' => 'Error en el sistema.'];
                }
            }

        public function fpdf($fecha, $horario){
            $this->fecha=$fecha;
            $this->horario=$horario;
                try {

                    $detalle = $this->mostrarAsistencia($this->fecha,  $this->horario, true);
                    $data = [
                    'fecha'=> $this->fecha,
                    'horario'=> $this->horario,
                    'detalle' => $detalle
                    ];
                    $reporte = new reporte;
                    $reporte->AddPage();
                    $reporte->asistencia($data);
                    $reporte->Output();
                } catch (\PDOException $e) {
                    return $e;
                }
        }

    public function fpdf2(){
        try {
            $detalle = $this->mostrarUltimaVez(true);
            $data = [
                'detalle' => $detalle
            ];
            $reporte = new reporte;
            $reporte->AddPage();
            $reporte->asistencia2($data);
            $reporte->Output();
        } catch (\PDOException $e) {
            return $e;
        }
    }

}
?>