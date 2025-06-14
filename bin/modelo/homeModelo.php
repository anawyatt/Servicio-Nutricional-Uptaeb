<?php
namespace modelo;
use config\connect\connectDB as connectDB;

class homeModelo extends connectDB {

    private $horario;

    public function __construct() {
        parent::__construct();
    }

    // Método para recibir el horario desde el controlador y hacer la consulta
    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function cantEstudiantes() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT COUNT(*) as cantidad FROM `estudiante` WHERE status = 1;");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function cantAsistencias() {
        try {
            $this->conectarDB();

            // Verifica si el horario fue establecido
            if ($this->horario) {
                $mostrar = $this->conex->prepare("SELECT COUNT(a.idAsistencia) as cantidad 
                                                  FROM asistencia a 
                                                  INNER JOIN menu m ON a.idMenu = m.idMenu 
                                                  WHERE a.status = 1 AND a.fecha = CURDATE() AND m.horarioComida = ?");
                $mostrar->bindValue(1, $this->horario);
                $mostrar->execute();
            } else {
                $mostrar = $this->conex->prepare("SELECT COUNT(a.idAsistencia) as cantidad 
                                                  FROM asistencia a 
                                                  INNER JOIN menu m ON a.idMenu = m.idMenu 
                                                  WHERE a.status = 1 AND a.fecha = CURDATE()");
                $mostrar->execute();
            }
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function cantMenus() {
        try {
            $this->conectarDB();
            
            if ($this->horario) {
                $mostrar = $this->conex->prepare("SELECT COUNT(idMenu) as cantidad 
                                                  FROM menu WHERE status = 1 AND horarioComida = ?");
                $mostrar->bindValue(1, $this->horario);
                $mostrar->execute();
            } else {
                $mostrar = $this->conex->prepare("SELECT COUNT(idMenu) as cantidad FROM menu WHERE status = 1");
                $mostrar->execute();
            }
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function cantEventos() {
        try {
            $this->conectarDB();
            
            if ($this->horario) {
                $mostrar = $this->conex->prepare("SELECT COUNT(e.idEvento) as cantidad 
                                                  FROM evento e 
                                                  INNER JOIN menu m ON e.idMenu = m.idMenu 
                                                  WHERE e.status = 1 AND m.horarioComida = ?");
                $mostrar->bindValue(1, $this->horario);
                $mostrar->execute();
            } else {
                $mostrar = $this->conex->prepare("SELECT COUNT(e.idEvento) as cantidad 
                                                  FROM evento e 
                                                  INNER JOIN menu m ON e.idMenu = m.idMenu 
                                                  WHERE e.status = 1");
                $mostrar->execute();
            }
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function cantAlimentos() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT COUNT(*) as cantidad FROM alimento WHERE status = 1 AND stock > 0 OR reservado > 0");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function cantUtensilios() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT COUNT(*) as cantidad FROM utensilios WHERE status = 1 AND stock > 0;");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    // Método para trabajar con los gráficos de asistencia
    public function asistencias() {
        try {
            $this->conectarDB();
            
            if ($this->horario) {
                $mostrar = $this->conex->prepare("SELECT m.horarioComida, a.fecha, COUNT(a.idAsistencia) AS cantidad 
                                                  FROM asistencia a 
                                                  INNER JOIN menu m ON a.idMenu = m.idMenu 
                                                  WHERE a.status = 1 AND a.fecha >= CURDATE() - INTERVAL 7 DAY 
                                                  AND m.horarioComida = ? 
                                                  GROUP BY m.horarioComida, a.fecha 
                                                  ORDER BY a.fecha;");
                $mostrar->bindValue(1, $this->horario);
                $mostrar->execute();
            } else {
                $mostrar = $this->conex->prepare("SELECT m.horarioComida, a.fecha, COUNT(a.idAsistencia) AS cantidad 
                                                  FROM asistencia a 
                                                  INNER JOIN menu m ON a.idMenu = m.idMenu 
                                                  WHERE a.status = 1 AND a.fecha >= CURDATE() - INTERVAL 7 DAY 
                                                  GROUP BY m.horarioComida, a.fecha 
                                                  ORDER BY a.fecha;");
                $mostrar->execute();
            }
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function alimentos() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT ta.tipo, COUNT(a.idAlimento) AS cantidad 
                                              FROM tipoalimento ta 
                                              INNER JOIN alimento a ON ta.idTipoA = a.idTipoA 
                                              WHERE a.stock > 0 
                                              GROUP BY ta.tipo;");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }

    public function menus() {
        try {
            $this->conectarDB();

            if ($this->horario) {
                $mostrar = $this->conex->prepare("SELECT m.feMenu, m.cantPlatos, sa.descripcion, m.horarioComida 
                                                  FROM menu m 
                                                  INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu 
                                                  INNER JOIN salidaalimentos sa ON dsm.idSalidaA = sa.idSalidaA 
                                                  WHERE m.status = 1 AND sa.status = 1 AND m.horarioComida = ? 
                                                  GROUP BY m.idMenu;");
                $mostrar->bindValue(1, $this->horario);
                $mostrar->execute();
            } else {
                $mostrar = $this->conex->prepare("SELECT m.feMenu, m.cantPlatos, sa.descripcion, m.horarioComida 
                                                  FROM menu m 
                                                  INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu 
                                                  INNER JOIN salidaalimentos sa ON dsm.idSalidaA = sa.idSalidaA 
                                                  WHERE m.status = 1 AND sa.status = 1 
                                                  GROUP BY m.idMenu;");
                $mostrar->execute();
            }
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch(\PDOException $e) {
            return $e;
        }
    }
}

?>