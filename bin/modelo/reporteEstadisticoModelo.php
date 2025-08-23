<?php 

  namespace modelo;
  use config\connect\connectDB as connectDB;
  use modelo\reporteModelo as reporte; 
  use helpers\JwtHelpers;

class reporteEstadisticoModelo extends connectDB{
	      
	   private $fecha;
     private $payload;

     public function __construct(){
     parent::__construct();
     $token = $_COOKIE['jwt'];
     $this->payload = JwtHelpers::validarToken($token);

	}


  public function verificarAsistenciasEstudiantes(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare("SELECT idAsistencia FROM asistencia  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["idAsistencia"])) {
          $mensaje = ['resultado' => 'existe'];
        }
        else{
          $mensaje = ['resultado' => 'no existe'];
        }
        echo json_encode($mensaje);
          die();

    }catch(\PDOException $e){
        return $e;
     }

  }

  public function verificarMenus(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare("SELECT idMenu FROM menu  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["idMenu"])) {
          $mensaje = ['resultado' => 'existe menu'];
        }
        else{
          $mensaje = ['resultado' => 'no existe menu'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }

  public function verificarEventos(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare("SELECT idEvento FROM evento  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["idEvento"])) {
          $mensaje = ['resultado' => 'existe evento'];
        }
        else{
          $mensaje = ['resultado' => 'no existe evento'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }


  public function verificarEntradaAlimentos(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare("SELECT idEntradaA FROM entradaalimento  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["idEntradaA"])) {
          $mensaje = ['resultado' => 'existe entrada'];
        }
        else{
          $mensaje = ['resultado' => 'no existe entrada'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }

  public function verificarSalidaAlimentos(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare(" SELECT idSalidaA FROM salidaalimentos  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
        if (isset( $data[0]["idSalidaA"])) {
          $mensaje = ['resultado' => 'existe salida'];
        }
        else{
          $mensaje = ['resultado' => 'no existe salida'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }

  public function verificarEntradaUtensilios(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare("SELECT idEntradaU FROM entradau  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["idEntradaU"])) {
          $mensaje = ['resultado' => 'existe entrada'];
        }
        else{
          $mensaje = ['resultado' => 'no existe entrada'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }

  public function verificarSalidaUtensilios(){
    try{
      $this->conectarDB();
        $verificar = $this->conex->prepare(" SELECT idSalidaU FROM salidautensilios  WHERE status = 1 ");
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
        if (isset( $data[0]["idSalidaU"])) {
          $mensaje = ['resultado' => 'existe salida'];
        }
        else{
          $mensaje = ['resultado' => 'no existe salida'];
        }
        echo json_encode($mensaje);
          die();
    }catch(\PDOException $e){
        return $e;
     }

  }


  //---------- SELECTS  FECHAS -----------------------------------

    public function mostrarFechasAsistencia(){
        try{
          $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT fecha FROM asistencia  WHERE status = 1 ORDER BY fecha DESC ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            echo json_encode($data);
            $this->desconectarDB();
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }

     public function mostrarFechasAsistenciaJustificativo(){
      try{
        $this->conectarDB();
          $mostrar = $this->conex->prepare("SELECT DISTINCT a.fecha FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante= e.cedEstudiante INNER JOIN excepcion ex ON e.cedEstudiante ex.cedEstudiante WHERE a.status=1 and ex.status=1 and a.fecha = ex.fecha ORDER BY a.fecha DESC");
          $mostrar->execute();
          $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
          echo json_encode($data);
          $this->desconectarDB();
          die();

      }catch(\PDOException $e){
          return $e;
       }
   }

     public function mostrarFechasMenus(){
        try{
          $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT feMenu FROM menu  WHERE status = 1 ORDER BY feMenu DESC ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            echo json_encode($data);
            $this->desconectarDB();
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }

     public function mostrarFechasEventos(){
      try{
        $this->conectarDB();
          $mostrar = $this->conex->prepare("SELECT DISTINCT m.feMenu FROM menu m INNER JOIN evento e on m.idMenu = e.idMenu WHERE e.status = 1 ORDER BY feMenu DESC; ");
          $mostrar->execute();
          $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
          echo json_encode($data);
          $this->desconectarDB();
          die();

      }catch(\PDOException $e){
          return $e;
       }
   }


      public function mostrarFechasEntradaAlimentos(){
        try{
          $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT fecha FROM entradaalimento WHERE status = 1 and fecha != '0000-00-00' ORDER BY fecha DESC; ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            echo json_encode($data);
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }


     public function mostrarFechasSalidaAlimentos(){
      try{
        $this->conectarDB();
          $mostrar = $this->conex->prepare("SELECT DISTINCT fecha FROM salidaalimentos WHERE status = 1 and fecha != '0000-00-00' ORDER BY fecha DESC; ");
          $mostrar->execute();
          $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
          echo json_encode($data);
          die();

      }catch(\PDOException $e){
          return $e;
       }
   }


     public function mostrarFechasEntradaUtensilios(){
        try{
          $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT DISTINCT fecha FROM entradau WHERE status = 1 and fecha != '0000-00-00'  ORDER BY fecha DESC; ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            echo json_encode($data);
            $this->desconectarDB();
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }

     public function mostrarFechasSalidaUtensilios(){
      try{
        $this->conectarDB();
          $mostrar = $this->conex->prepare("SELECT DISTINCT fecha FROM salidautensilios WHERE status = 1 and fecha != '0000-00-00' ORDER BY fecha DESC; ");
          $mostrar->execute();
          $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
          echo json_encode($data);
          $this->desconectarDB();
          die();

      }catch(\PDOException $e){
          return $e;
       }
   }





  
  //------------- ASISTENCIAS Y ESTUDIANTES -------------------

public function asistenciasEstudiantes( $fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT m.horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu INNER JOIN ( SELECT COUNT(*) AS total_count FROM asistencia WHERE status = 1 AND fecha = ? ) AS total ON 1=1 WHERE a.status = 1 AND a.fecha = ? GROUP BY m.horarioComida ORDER BY m.horarioComida DESC;");
      $grafico->bindValue(1, $this->fecha);
      $grafico->bindValue(2, $this->fecha);
      $grafico->execute();
    }
    else{
      $grafico = $this->conex->prepare("SELECT m.horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asistencia WHERE status = 1)), 2) AS porcentaje FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu WHERE a.status = 1 GROUP BY m.horarioComida ORDER BY m.horarioComida DESC;");
       $grafico->execute();
    }

       $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
       $bitacora = new bitacoraModelo;
       $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de asistencias por horario de Menu', $this->payload->cedula);
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function asistenciasPorSexo( $fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT e.sexo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante INNER JOIN ( SELECT COUNT(*) AS total_count FROM asistencia WHERE status = 1 AND fecha = ? ) AS total ON 1=1 WHERE a.status = 1 AND a.fecha = ? GROUP BY e.sexo ORDER BY e.sexo DESC;");
      $grafico->bindValue(1, $this->fecha);
      $grafico->bindValue(2, $this->fecha);
      $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT e.sexo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asistencia WHERE status = 1)), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante WHERE a.status = 1 GROUP BY e.sexo ORDER BY e.sexo DESC;");
       $grafico->execute();
    }
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de asistencias por Sexo', $this->payload->cedula);
     
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            } 
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function asistenciasPorNucleo( $fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT e.nucleo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante INNER JOIN ( SELECT COUNT(*) AS total_count FROM asistencia WHERE status = 1 AND fecha = ? ) AS total ON 1=1 WHERE a.status = 1 AND a.fecha = ? GROUP BY e.nucleo ORDER BY e.nucleo DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT e.nucleo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asistencia WHERE status = 1)), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante WHERE a.status = 1 GROUP BY e.nucleo ORDER BY e.nucleo DESC;");
       $grafico->execute();

    }     
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de asistencias por Núcleo', $this->payload->cedula);
    
       $this->desconectarDB();
       if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }; 
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function asistenciasPorPNF( $fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

     if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT e.carrera AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante INNER JOIN ( SELECT COUNT(*) AS total_count FROM asistencia WHERE status = 1 AND fecha = ? ) AS total ON 1=1 WHERE a.status = 1 AND a.fecha = ? GROUP BY e.carrera ORDER BY e.carrera DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT e.carrera AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM asistencia WHERE status = 1)), 2) AS porcentaje FROM asistencia a INNER JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante WHERE a.status = 1 GROUP BY e.carrera ORDER BY e.carrera DESC;");
       $grafico->execute();

    }
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de asistencias por PNF', $this->payload->cedula);
         
          $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function asistenciasPorJustificativo($fecha, $returnData = false){

    $this->fecha=$fecha;

  try {
    $this->conectarDB();
     if ($this->fecha !='Seleccionar') {
        $grafico = $this->conex->prepare("SELECT cantidad, porcentaje FROM ( SELECT COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM excepcion INNER JOIN ( SELECT COUNT(*) AS total_count FROM excepcion WHERE status = 1 AND fecha = ? ) AS total ON 1=1 WHERE status = 1 AND fecha = ? ) subquery WHERE cantidad > 0;");
          $grafico->bindValue(1, $this->fecha);
          $grafico->execute();
     }else{
       $grafico = $this->conex->prepare("SELECT cantidad, porcentaje FROM (SELECT COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM excepcion WHERE status = 1)), 2) AS porcentaje FROM excepcion WHERE status = 1 ) subquery WHERE cantidad > 0;");
          $grafico->execute();
     }
       $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
       $bitacora = new bitacoraModelo;
       $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de asistencias por Justificativo', $this->payload->cedula);
       $this->desconectarDB();
      if ($returnData === false) {
              echo json_encode($data);
              die();
      }
     else{
      return $data;
      }
   } catch (\PDOException $e) {
       return $e;
   }
 }

  //------------------- MENUS Y EVENTOS -------------------

public function menus($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM menu INNER JOIN ( SELECT COUNT(*) AS total_count FROM menu WHERE status = 1 AND feMenu = ? ) AS total ON 1=1 WHERE status = 1 AND feMenu =? GROUP BY horarioComida ORDER BY horarioComida DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM menu WHERE status = 1)), 2) AS porcentaje FROM menu WHERE status = 1 GROUP BY horarioComida ORDER BY horarioComida DESC;");

       $grafico->execute();
    }     
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de menus por horario ', $this->payload->cedula);

       
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            } 
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function eventos($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT m.horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM menu m INNER JOIN evento e ON m.idMenu = e.idMenu INNER JOIN ( SELECT COUNT(*) AS total_count FROM menu m INNER JOIN evento e ON m.idMenu = e.idMenu WHERE e.status = 1 AND m.feMenu = ? ) AS total ON 1=1 WHERE e.status = 1 AND m.feMenu = ? GROUP BY m.horarioComida ORDER BY m.horarioComida DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT m.horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM menu m INNER JOIN evento e ON m.idMenu = e.idMenu WHERE e.status = 1)), 2) AS porcentaje FROM menu m INNER JOIN evento e ON m.idMenu = e.idMenu WHERE e.status = 1 GROUP BY m.horarioComida ORDER BY m.horarioComida DESC;");

       $grafico->execute();
    }     
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de eventos por horario de Menu', $this->payload->cedula);
      
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function cantidadMenuActivos($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
       $grafico = $this->conex->prepare("SELECT horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM menu INNER JOIN ( SELECT COUNT(*) AS total_count FROM menu WHERE status = 1 AND feMenu = ? ) AS total ON 1=1 WHERE status = 1 AND feMenu = ? GROUP BY horarioComida ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT horarioComida AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM menu WHERE status = 1)), 2) AS porcentaje FROM menu WHERE status = 1 GROUP BY horarioComida ORDER BY cantidad DESC;");
       $grafico->execute();

    }
       $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
       $bitacora = new bitacoraModelo;
       $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de Menus Activos', $this->payload->cedula);
       $this->desconectarDB();
             if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            } 
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function alimentosMasUtilizados($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
       $grafico = $this->conex->prepare("SELECT a.nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM alimento a JOIN detalleSalidaMenu dsm ON a.idAlimento = dsm.idAlimento INNER JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA INNER JOIN ( SELECT COUNT(*) AS total_count FROM detalleSalidaMenu dsm INNER JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA WHERE sa.fecha = ? ) AS total ON 1=1 WHERE sa.fecha = ? GROUP BY a.nombre ORDER BY cantidad DESC LIMIT 5;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT a.nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detalleSalidaMenu)), 2) AS porcentaje FROM alimento a JOIN detalleSalidaMenu dsm ON a.idAlimento = dsm.idAlimento GROUP BY a.nombre HAVING COUNT(*) > 0;");
       $grafico->execute();
     }    

          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó los alimentos mas utilizados en los menus', $this->payload->cedula);
      
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function eventosConMayorAlimentos($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
     if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT e.nomEvent AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM evento e JOIN menu m ON e.idMenu = m.idMenu JOIN detalleSalidaMenu dsm ON m.idMenu = dsm.idMenu JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA INNER JOIN ( SELECT COUNT(*) AS total_count FROM evento e JOIN menu m ON e.idMenu = m.idMenu JOIN detalleSalidaMenu dsm ON m.idMenu = dsm.idMenu JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA WHERE e.status = 1 AND sa.fecha = ? ) AS total ON 1=1 WHERE e.status = 1 AND sa.fecha = ? GROUP BY e.idEvento ORDER BY cantidad DESC LIMIT 5;");
      $grafico->bindValue(1, $this->fecha);
      $grafico->bindValue(2, $this->fecha);
      $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT e.nomEvent as nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM evento e JOIN menu m ON e.idMenu = m.idMenu JOIN detalleSalidaMenu dsm ON m.idMenu = dsm.idMenu JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA WHERE e.status = 1)), 2) AS porcentaje FROM evento e JOIN menu m ON e.idMenu = m.idMenu JOIN detalleSalidaMenu dsm ON m.idMenu = dsm.idMenu JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA WHERE e.status = 1 GROUP BY e.idEvento, e.nomEvent ORDER BY cantidad DESC LIMIT 5;");

       $grafico->execute();
    }     
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de eventos que han sacado grandes cantidades de alimentos', $this->payload->cedula);
         
          $this->desconectarDB();
           if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }


  // ------------------ ALIMENTOS ------------------------

public function entradaAlimentos($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

  if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM entradaalimento ea INNER JOIN detalleentradaa dea ON ea.idEntradaA = dea.idEntradaA INNER JOIN alimento a ON dea.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA INNER JOIN ( SELECT COUNT(*) AS total_count FROM entradaalimento ea INNER JOIN detalleentradaa dea ON ea.idEntradaA = dea.idEntradaA WHERE ea.status = 1 AND dea.status = 1 AND ea.fecha = ? ) AS total ON 1=1 WHERE ea.status = 1 AND dea.status = 1 AND ea.fecha = ? GROUP BY ta.tipo ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM entradaalimento ea INNER JOIN detalleentradaa dea ON ea.idEntradaA = dea.idEntradaA WHERE ea.status = 1 AND dea.status = 1)), 2) AS porcentaje FROM entradaalimento ea INNER JOIN detalleentradaa dea ON ea.idEntradaA = dea.idEntradaA INNER JOIN alimento a ON dea.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ea.status = 1 AND dea.status = 1 GROUP BY ta.tipo ORDER BY cantidad DESC;");

       $grafico->execute();
    }
       $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
        $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de entradas de alimentos', $this->payload->cedula);
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function alimentosMasIngresados($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

     if ($this->fecha !='Seleccionar') {
       $grafico = $this->conex->prepare("SELECT a.nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM alimento a INNER JOIN detalleentradaa dea ON a.idAlimento = dea.idAlimento INNER JOIN entradaalimento ea ON ea.idEntradaA = dea.idEntradaA INNER JOIN ( SELECT COUNT(*) AS total_count FROM detalleentradaa dea INNER JOIN entradaalimento ea ON ea.idEntradaA = dea.idEntradaA WHERE ea.fecha = ? ) AS total ON 1=1 WHERE ea.fecha = ? GROUP BY a.idAlimento, a.nombre ORDER BY cantidad DESC LIMIT 10;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT a.nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detalleentradaa)), 2) AS porcentaje FROM alimento a INNER JOIN detalleentradaa dea ON a.idAlimento = dea.idAlimento GROUP BY a.idAlimento, a.nombre ORDER BY cantidad DESC LIMIT 10;");
       $grafico->execute();
    }     

          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó los alimentos mas ingresados al inventario', $this->payload->cedula);
       
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function salidaAlimentosMenu($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
      if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM salidaalimentos sa INNER JOIN detallesalidamenu dsm ON sa.idSalidaA = dsm.idSalidaA INNER JOIN alimento a ON dsm.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA INNER JOIN ( SELECT COUNT(*) AS total_count FROM detallesalidamenu dsm INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA WHERE sa.status = 1 AND dsm.status = 1 AND sa.fecha = ? ) AS total ON 1=1 WHERE sa.status = 1 AND dsm.status = 1 AND sa.fecha = ? GROUP BY ta.tipo ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detallesalidamenu dsm INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA WHERE sa.status = 1 AND dsm.status = 1)), 2) AS porcentaje FROM salidaalimentos sa INNER JOIN detallesalidamenu dsm ON sa.idSalidaA = dsm.idSalidaA INNER JOIN alimento a ON dsm.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE sa.status = 1 AND dsm.status = 1 GROUP BY ta.tipo ORDER BY cantidad DESC;");

       $grafico->execute();
     }   
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total el tipo de alimentos mas sacados por menus', $this->payload->cedula);
      
       $this->desconectarDB();
           if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function salidaAlimentosMerma($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON sa.idSalidaA = dsa.idSalidaA INNER JOIN alimento a ON dsa.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA INNER JOIN ( SELECT COUNT(*) AS total_count FROM detallesalidaa dsa INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsa.idSalidaA WHERE sa.status = 1 AND dsa.status = 1 AND sa.fecha = ? ) AS total ON 1=1 WHERE sa.status = 1 AND dsa.status = 1 AND sa.fecha = ? GROUP BY ta.tipo ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT ta.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detallesalidaa dsa INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsa.idSalidaA WHERE sa.status = 1 AND dsa.status = 1)), 2) AS porcentaje FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON sa.idSalidaA = dsa.idSalidaA INNER JOIN alimento a ON dsa.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE sa.status = 1 AND dsa.status = 1 GROUP BY ta.tipo ORDER BY cantidad DESC;");

       $grafico->execute();

    }     
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó los tipos de alimentos mas sacados por Donación o Merma', $this->payload->cedula);
       
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }



  // ------------------ UTENSILIOS -----------------------

public function entradaUtensilios($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT tu.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM entradau eu INNER JOIN detalleentradau deu ON eu.idEntradaU = deu.idEntradaU INNER JOIN utensilios u ON deu.idUtensilios = u.idUtensilios INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU INNER JOIN ( SELECT COUNT(*) AS total_count FROM detalleentradau deu INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU WHERE eu.status = 1 AND deu.status = 1 AND eu.fecha = ? ) AS total ON 1=1 WHERE eu.status = 1 AND deu.status = 1 AND eu.fecha = ? GROUP BY tu.tipo ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT tu.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detalleentradau deu INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU WHERE eu.status = 1 AND deu.status = 1)), 2) AS porcentaje FROM entradau eu INNER JOIN detalleentradau deu ON eu.idEntradaU = deu.idEntradaU INNER JOIN utensilios u ON deu.idUtensilios = u.idUtensilios INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU WHERE eu.status = 1 AND deu.status = 1 GROUP BY tu.tipo ORDER BY cantidad DESC;");

       $grafico->execute();
     }    

          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó el total de entradas de utensilios', $this->payload->cedula);
      
          $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            } 
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function utensiliosMasIngresados($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();
      if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT u.nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM utensilios u INNER JOIN detalleentradau deu ON u.idUtensilios = deu.idUtensilios INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU INNER JOIN ( SELECT COUNT(*) AS total_count FROM detalleentradau deu INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU WHERE eu.fecha = ? ) AS total ON 1=1 WHERE eu.fecha = ? GROUP BY u.nombre ORDER BY cantidad DESC LIMIT 5;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT 
    u.nombre, 
    COUNT(*) AS cantidad, 
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detalleentradau deu INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU )), 2) AS porcentaje FROM  utensilios u INNER JOIN detalleentradau deu ON u.idUtensilios = deu.idUtensilios INNER JOIN entradau eu ON eu.idEntradaU = deu.idEntradaU GROUP BY u.nombre ORDER BY cantidad DESC LIMIT 5;");
       $grafico->execute();
     }   
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó los utensilios mas ingresados al inventario', $this->payload->cedula);
      
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }

public function salidaUtensilios($fecha, $returnData = false){
  $this->fecha=$fecha;

  try {
    $this->conectarDB();

    if ($this->fecha !='Seleccionar') {
      $grafico = $this->conex->prepare("SELECT tu.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / total.total_count), 2) AS porcentaje FROM salidautensilios su INNER JOIN detallesalidau dsu ON su.idSalidaU = dsu.idSalidaU INNER JOIN utensilios u ON dsu.idUtensilios = u.idUtensilios INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU INNER JOIN ( SELECT COUNT(*) AS total_count FROM detallesalidau dsu INNER JOIN salidautensilios su ON su.idSalidaU = dsu.idSalidaU WHERE su.status = 1 AND dsu.status = 1 AND su.fecha = ? ) AS total ON 1=1 WHERE su.status = 1 AND dsu.status = 1 AND su.fecha = ? GROUP BY tu.tipo ORDER BY cantidad DESC;");
       $grafico->bindValue(1, $this->fecha);
       $grafico->bindValue(2, $this->fecha);
       $grafico->execute();
    }
    else{
       $grafico = $this->conex->prepare("SELECT tu.tipo AS nombre, COUNT(*) AS cantidad, ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM detallesalidau dsu INNER JOIN salidautensilios su ON su.idSalidaU = dsu.idSalidaU WHERE su.status = 1 AND dsu.status = 1)), 2) AS porcentaje FROM salidautensilios su INNER JOIN detallesalidau dsu ON su.idSalidaU = dsu.idSalidaU INNER JOIN utensilios u ON dsu.idUtensilios = u.idUtensilios INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU WHERE su.status = 1 AND dsu.status = 1 GROUP BY tu.tipo ORDER BY cantidad DESC;");

       $grafico->execute();

      }
          $data = $grafico->fetchAll(\PDO::FETCH_OBJ);
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Reportes Estadísticos', 'Consultó los tipos de utensilios mas sacados en el inventario', $this->payload->cedula);
       
       $this->desconectarDB();
            if ($returnData === false) {
              echo json_encode($data);
              die();
            }
            else{
              return $data;
            }
   } catch (\PDOException $e) {
       return $e;
   }
 }


 /*-------LA FUNCION PARA El PDFD--------*/
   
public function fpdf($grafica, $tipo, $fecha){
        
   try {
      $this->grafica=$grafica;
      $this->fecha= $fecha;

      if($tipo === 'AE1'){
         $cabecera='Asistencias de Estudiantes';
         $titulos=['cam1'=>'Horario de Comida', 'cam2'=>'Cant. de Estudiantes', 'cam3'=> 'Porcentaje'];
         $datos=$this->asistenciasEstudiantes($this->fecha, true);
      }
      if($tipo === 'AE2'){
         $cabecera='Asistencias de Estudiantes por Sexo';
         $titulos=['cam1'=>'Sexo', 'cam2'=>'Cant. de Estudiantes', 'cam3'=> 'Porcentaje'];
         $datos=$this->asistenciasPorSexo($this->fecha, true);
      }
      if($tipo === 'AE3'){
         $cabecera='Asistencias de Estudiantes por Núcleo';
         $titulos=['cam1'=>'Núcleo', 'cam2'=>'Cant. de Estudiantes', 'cam3'=> 'Porcentaje'];
         $datos=$this->asistenciasPorNucleo($this->fecha, true);
      }
      if($tipo === 'AE4'){
         $cabecera='Asistencias de Estudiantes por PNF';
         $titulos=['cam1'=>'Programa Nacional de Formación', 'cam2'=>'Cant. de Estudiantes', 'cam3'=> 'Porcentaje'];
         $datos=$this->asistenciasPorPNF($this->fecha, true);
      }
      if($tipo === 'AE5'){
         $cabecera='Asistencias de Estudiantes por Justificativo';
         $titulos=['cam1'=>'Horario de Comida', 'cam2'=>'Cant. de Estudiantes', 'cam3'=> 'Porcentaje'];
         $datos=$this->asistenciasPorJustificativo($this->fecha, true);
      }
      if($tipo === 'ME1'){
         $cabecera='Total de Menus';
         $titulos=['cam1'=>'Horario de Comida', 'cam2'=>'Cant. de Menus', 'cam3'=> 'Porcentaje'];
         $datos=$this->menus($this->fecha, true);
      }
      if($tipo === 'ME2'){
         $cabecera='Total de Eventos';
         $titulos=['cam1'=>'Horario de Comida', 'cam2'=>'Cant. de Eventos', 'cam3'=> 'Porcentaje'];
         $datos=$this->eventos($this->fecha, true);
      }
      if($tipo === 'ME3'){
         $cabecera='Horarios de comida con mayor número de menús activos';
         $titulos=['cam1'=>'Horario de Comida', 'cam2'=>'Cant. de Menus', 'cam3'=> 'Porcentaje'];
         $datos=$this->cantidadMenuActivos($this->fecha, true);
      }
      if($tipo === 'ME4'){
         $cabecera='Alimentos más frecuentemente utilizados en los menús';
         $titulos=['cam1'=>'Alimentos', 'cam2'=>'Cant. de Uso', 'cam3'=> 'Porcentaje'];
         $datos=$this->alimentosMasUtilizados($this->fecha, true);
      }
       if($tipo === 'ME5'){
         $cabecera='Eventos con la mayor cantidad de salidas de alimentos';
         $titulos=['cam1'=>'Evento', 'cam2'=>'Cant. de Salidas', 'cam3'=> 'Porcentaje'];
         $datos=$this->eventosConMayorAlimentos($this->fecha, true);
      }
      if($tipo === 'A1'){
         $cabecera='Entrada de Alimentos';
         $titulos=['cam1'=>'Tipo de Alimento', 'cam2'=>'Cant. de Entradas', 'cam3'=> 'Porcentaje'];
         $datos=$this->entradaAlimentos($this->fecha, true);
      }
      if($tipo === 'A2'){
         $cabecera='Alimentos mas ingresados';
         $titulos=['cam1'=>'Alimento', 'cam2'=>'Cant. de Ingreso', 'cam3'=> 'Porcentaje'];
         $datos=$this->alimentosMasIngresados($this->fecha, true);
      }
      if($tipo === 'A3'){
         $cabecera='Salida de alimentos mas frecuentes por Menú';
         $titulos=['cam1'=>'Tipo de Alimento', 'cam2'=>'Cant. de Salidas', 'cam3'=> 'Porcentaje'];
         $datos=$this->salidaAlimentosMenu($this->fecha, true);
      }
      if($tipo === 'A4'){
         $cabecera='Salida de alimentos mas frecuentes por Merma o Donación';
         $titulos=['cam1'=>'Tipo de Alimento', 'cam2'=>'Cant. de Salidas', 'cam3'=> 'Porcentaje'];
         $datos=$this->salidaAlimentosMerma($this->fecha, true);
      }
      if($tipo === 'U1'){
         $cabecera='Entrada de Utensilios';
         $titulos=['cam1'=>'Tipo de Utensilio', 'cam2'=>'Cant. de Entradas', 'cam3'=> 'Porcentaje'];
         $datos=$this->entradaUtensilios($this->fecha, true);
      }
      if($tipo === 'U2'){
         $cabecera='Utensilios mas Ingresados';
         $titulos=['cam1'=>'Utensilio', 'cam2'=>'Cant. de Ingreso', 'cam3'=> 'Porcentaje'];
         $datos=$this->utensiliosMasIngresados($this->fecha, true);
      }
      if($tipo === 'U3'){
         $cabecera='Salida de Utensilios';
         $titulos=['cam1'=>'Tipo de Utensilio', 'cam2'=>'Cant. de Salidas', 'cam3'=> 'Porcentaje'];
         $datos=$this->salidaUtensilios($this->fecha, true);
      }

      
      $data = [
         'img'=>$this->grafica,
         'datos'=>$datos,
         'titulos'=>$titulos,
         'cabecera'=>$cabecera,
         'fecha' =>$this->fecha
      ];
       /*-------fDFD--------*/
      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->reporteGrafica($data);
      $reporte->Output();
       /*-------pfdf--------*/
       $bitacora= new bitacoraModelo;
       $bitacora->registrarBitacora('Reportes Estadisticos', 'Exporto el reporte estadistico de '.$cabecera,
       $this->payload->cedula);
   } catch (\PDOException $e) {
       return $e;
   }
}




}
?>