<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
use helpers\JwtHelpers;


class eventoModelo extends connectDB {

    private $tipoA;
    private $alimento;
   
    private $feMenu; 
     private $horarioComida;
    private $cantPlatos;
    private $nomEvent;
    private $descripEventt;
    private $descripcion;

    private $payload;
    

   
    public function __construct(){
         parent::__construct();

        if (isset($_COOKIE['jwt']) && !empty($_COOKIE['jwt'])) {
            $token = $_COOKIE['jwt'];
            $this->payload = JwtHelpers::validarToken($token);
        } else {
            $this->payload = (object) ['cedula' => '12345678'];
        }
    }

      public function verificarExistenciaTipoA($tipoA){
        if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
            return ['resultado' => 'Ingresar el Tipo de Alimento'];
            }

            $this->tipoA = $tipoA;
            $resultado =  $this->verificarETA();
            return $resultado === true ? ['resultado' => 'no esta'] : ['resultado' => 'si esta'];
      }
  
      private function verificarETA(){
            try{
              $this->conectarDB();
              $verificar=$this->conex->prepare("CALL verificar_existencia_tipo_alimento(?)");
              $verificar->bindValue(1, $this->tipoA);
              $verificar->execute();
              $data=$verificar->fetchAll();
              $verificar->closeCursor(); 
              $this->desconectarDB();

              return empty($data);
            }
            catch (Exception $error) {
            return ['resultado' => '¡Error Sistema!'];
            }
      }
 
      public function mostrarTipoAlimento(){
              try{
                $this->conectarDB();
                  $mostrar = $this->conex->prepare("SELECT * FROM vistaTiposAlimentosConStock");
                  $mostrar->execute();
                  $this->desconectarDB();
                  $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                  return $data;
      
              }catch (\PDOException $e){
                  return $e;
              }   
      }
  
      public function verificarExistenciaAlimento($alimento) {
              if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
                  return ['resultado' => 'Ingresar Alimento'];
              } 

              $this->alimento = $alimento;
              $resultado =  $this->verificarEA();
              return $resultado === true ? ['resultado' => 'no esta'] : ['resultado' => 'si esta'];           
      }

      private function verificarEA(){
            try{
              $this->conectarDB();
              $verificar=$this->conex->prepare("CALL proceVerificarAlimentoDisponible(?)");
              $verificar->bindValue(1, $this->alimento);
              $verificar->execute();
              $data=$verificar->fetchAll();
              $verificar->closeCursor(); 
              $this->desconectarDB();
              return empty($data);
        
            }
            catch(Exception $error){
              
              return array("Sistema", "¡Error Sistema!");
            }
      }

      public function mostrarAlimento($tipoA) {
          if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
              return ['resultado' => 'Ingresar Alimento'];
          }

          $this->tipoA = $tipoA;
          return $this->mostrarA();
      }

          
      private function mostrarA(){
            try{
                $this->conectarDB();
                  $mostrar = $this->conex->prepare("CALL proceMostrarAlimentosPorTipo(?)");
                  $mostrar->bindValue(1, $this->tipoA);
                  $mostrar->execute();
                  $data = $mostrar->fetchAll();
                  $mostrar->closeCursor();
                
                  return $data;
                  
              }catch(\PDOException $e){
                  return $e;
              }
      }

      public function infoAlimento($alimento) {
            if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
            return ['resultado' => 'Selecionar Alimento para Obtener Informacion'];
            } 
          
            $this->alimento = $alimento;
            return $this->infor();   
      }

      private function infor(){
            try{
              $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT idAlimento, codigo, imgAlimento, nombre, unidadMedida, marca,
                stock, idTipoA  FROM alimento WHERE status = 1 AND idAlimento = ?");
                $mostrar->bindValue(1, $this->alimento);
                $mostrar->execute();
                $data = $mostrar->fetchAll();
                $this->desconectarDB();
                  return $data;
        
                }catch(\PDOException $e){
                return $e;
            }
      }

      public function validarFH($feMenu, $horarioComida) {
          $errores = [];

          if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
              $errores[] = 'Ingresar Fecha';
          }

          if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
              $errores[] = 'Seleccionar Horario del Menú';
          }

          if (!empty($errores)) {
              return ['resultado' => implode(', ', $errores)];
          }

          $this->feMenu = $feMenu;
          $this->horarioComida = $horarioComida;
          $resultado = $this->validar();
          return $resultado === true 
              ? ['resultado' => 'error', 'mensaje' => 'Ya tiene un evento registrado para esa fecha y horario'] 
              : ['resultado' => 'No tiene un evento registrado para esa fecha y horario'];
      }

      private function validar(){
            try {
              $this->conectarDB();
                $validar = $this->conex->prepare("SELECT m.idMenu,  m.feMenu, m.horarioComida, m.status AS menuStatus,
                e.idEvento, e.status AS eventoStatus FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu WHERE m.feMenu = ? 
                AND m.horarioComida = ? AND m.status != 0 AND e.status != 0;");
                
                $validar->bindValue(1, $this->feMenu);
                $validar->bindValue(2, $this->horarioComida);
                
                $validar->execute();
                $data = $validar->fetchAll();
                $this->desconectarDB();

                return !empty($data);
              
                } catch (Exception $error) {
                    echo json_encode(array("resultado" => "error", "mensaje" => "¡Error Sistema!"));
                }
      }

     public function registrarEvento($feMenu, $horarioComida, $cantPlatos, $nomEvent, $descripEvent, $descripcion) {
          $errores = [];

          if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
              $errores[] = 'Ingresar Fecha del Menú en formato YYYY-MM-DD';
          }

          if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
              $errores[] = 'Seleccionar Horario del Menú';
          }

          if (!preg_match("/^[0-9]{1,}$/", $cantPlatos)) {
              $errores[] = 'Ingresar cantidad de Platos';
          }

          if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $nomEvent)) {
              $errores[] = 'Ingresar Nombre del evento';
          }

          if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $descripEvent)) {
              $errores[] = 'Ingresar Descripción del evento';
          }

          if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $descripcion)) {
              $errores[] = 'Ingresar Descripción del Menú';
          }

          if (!empty($errores)) {
              return ['resultado' => implode(' | ', $errores)];
          }

          $this->feMenu = $feMenu;
          $this->horarioComida = $horarioComida;
          $this->cantPlatos = $cantPlatos;
          $this->nomEvent = $nomEvent;
          $this->descripEvent = $descripEvent;
          $this->descripcion = $descripcion;

          return $this->evento();
    }

      private function evento(){
        try{
          $this->conectarDB();
          $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
          $this->conex->beginTransaction();

          $idTipoSalidas = $this->tipoSalida();
          $menuId = $this->infoMenu();
          $eventId = $this->infoEvento($menuId);
          $salidaId = $this->salidaAlimentos($idTipoSalidas);

          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Eventos', 'Se registró un evento para el dia: '.$this->feMenu.' n° comensales: '.$this->cantPlatos, $this->payload->cedula);
        
          $this->conex->commit();

          $this->notificaciones($this->horarioComida, $this->descripcion, $this->cantPlatos, $this->feMenu,  $this->nomEvent, $this->descripEvent);
          $this->notificaciones2($this->horarioComida, $this->descripcion, $this->cantPlatos, $this->feMenu,  $this->nomEvent, $this->descripEvent);
          
          return ['resultado' => 'registrado', 'eventId' => $eventId, 'menuId' => $menuId, 'salidaId' => $salidaId];

           } catch (Exception $error) {
                $this->conex->rollBack();
                return ['error' => $error->getMessage()];
           }
           finally {
              $this->desconectarDB();
           }
      }
       
      private function tipoSalida(){
        $tipoSalida = $this->conex->prepare("SELECT idTipoSalidas FROM tiposalidas WHERE tipoSalida = 'Menú'");
        $tipoSalida->execute();
        return $tipoSalida->fetchColumn();
      }
      
      private function infoMenu() {
        $new = $this->conex->prepare("INSERT INTO `menu`(`idMenu`, `feMenu`, `horarioComida`, `cantPlatos`, `status`) 
        VALUES (DEFAULT, ?, ?, ?, 1)");
 
        $new->bindValue(1, $this->feMenu);
        $new->bindValue(2, $this->horarioComida);
        $new->bindValue(3, $this->cantPlatos);
        $new->execute();
        return $this->conex->lastInsertId();
      }

      private function infoEvento($menuId) {
        $new = $this->conex->prepare("INSERT INTO `evento`(`idEvento`, `nomEvent`, `descripEvent`, `idMenu`, `status`) 
        VALUES (DEFAULT, ?, ?, ?, 1)");
        $new->bindValue(1, $this->nomEvent);
        $new->bindValue(2, $this->descripEvent);
        $new->bindValue(3, $menuId);
        $new->execute();
        return $this->conex->lastInsertId();
      }

      private function salidaAlimentos($idTipoSalidas) {
        $new = $this->conex->prepare("INSERT INTO `salidaalimentos`(`idSalidaA`, `fecha`, `hora`, `descripcion`, `idTipoSalidaA`, `status`)  
        VALUES (DEFAULT, DEFAULT, DEFAULT, ?, ?, 1)");

        $new->bindValue(1, $this->descripcion);
        $new->bindValue(2, $idTipoSalidas);
        $new->execute();
        return $this->conex->lastInsertId();
      }

     public function detalleSalidaM($alimento, $cantidad, $menuId, $salidaId) {
        $errores = [];

        if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
            $errores[] = 'Ingresar Alimento';
        }

        if (!preg_match("/^[0-9]{1,}$/", $cantidad)) {
            $errores[] = 'Ingresar Cantidad de Alimentos';
        }

        if (!preg_match("/^[0-9]{1,}$/", $menuId)) {
            $errores[] = 'Obtener ID del Menú';
        }

        if (!preg_match("/^[0-9]{1,}$/", $salidaId)) {
            $errores[] = 'Obtener ID de la Salida';
        }

        if (!empty($errores)) {
            return ['resultado' => implode(' | ', $errores)];
        }

        $this->alimento = $alimento;
        $this->cantidad = $cantidad;
        $this->menuId = $menuId;
        $this->salidaId = $salidaId;

        return $this->registrarDetalle();
    }

       
    
      private function registrarDetalle() {
        try {
              $this->conectarDB();
              $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
              $this->conex->beginTransaction();

              $this->detalleSalidaMenu();
              
                list($nombreAlimento, $unidadMedida) = $this->obtenerDatosAlimento();        
                $resultado = $this->actualizarStockYReservado($this->alimento, $this->cantidad);
                if (isset($resultado['error'])) 
                return $resultado;

    
              $bitacora = new bitacoraModelo;
              $bitacora->registrarBitacora('Evento', 'Se despachó el alimento '.$nombreAlimento.' cantidad: '.$this->cantidad.' '.$unidadMedida, $this->payload->cedula);

            $this->conex->commit();

            return ['resultado' => 'exitoso'];

              } catch (Exception $error) {
                    $this->conex->rollBack();
                    return ['error' => $error->getMessage()]; 
            }
            finally {
            $this->desconectarDB();
        }
      }


      private function detalleSalidaMenu() {
          $new = $this->conex->prepare("INSERT INTO detallesalidamenu(idDetalleSalidaMenu, cantidad, idMenu, idAlimento, idSalidaA, status) 
          VALUES (DEFAULT, ?, ?, ?, ?, 1)");
          
          $new->bindValue(1, $this->cantidad);
          $new->bindValue(2, $this->menuId);
          $new->bindValue(3, $this->alimento);
          $new->bindValue(4, $this->salidaId);
          $new->execute();
      }    

      private function obtenerDatosAlimento() {
        $infoAlimento = $this->conex->prepare("SELECT nombre, unidadMedida FROM alimento WHERE idAlimento = ?");
        $infoAlimento->bindValue(1, $this->alimento);
        $infoAlimento->execute();
        $alimento = $infoAlimento->fetch(PDO::FETCH_ASSOC);
        return [$alimento['nombre'], $alimento['unidadMedida']];
      }

      private function actualizarStockYReservado($idAlimento, $cantidad) {
          try {
              $query = $this->conex->prepare("SELECT stock, reservado FROM alimento WHERE idAlimento = ? FOR UPDATE");
              $query->bindValue(1, $idAlimento);
              $query->execute();
              $data = $query->fetch(PDO::FETCH_ASSOC);

              if (!$data) {
                  throw new Exception("Alimento no encontrado.");
              }

              $nuevoStock = $data['stock'] - $cantidad;
              $nuevoReservado = $data['reservado'] + $cantidad;

              if ($nuevoStock < 0) {
                  throw new Exception("No hay stock suficiente.");
              }

              $update = $this->conex->prepare("UPDATE alimento SET stock = ?, reservado = ? WHERE idAlimento = ?");
              $update->bindValue(1, $nuevoStock);
              $update->bindValue(2, $nuevoReservado);
              $update->bindValue(3, $idAlimento);
              $update->execute();

              return true;

          } catch (Exception $error) {
              return ['error' => $error->getMessage()];
          }
      }

      
    //$this->notificaciones($this->horarioComida, $this->descripcion, $this->cantPlatos, $this->feMenu,  $this->nomEvent = $nomEvent, $this->descripEvent);
        private function notificaciones() {
          $this->conectarDBSeguridad();
          try {
            $titulo = "Evento Del Dia - ". $this->nomEvent;
            $mensaje = "Descripción: " . $this->descripEvent . " hecho para " .$this->cantPlatos. "° comensales." ;
            $tipomsj = $this->horarioComida;
            $query = $this->conex2->prepare("INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`, `fechaNoti`) VALUES (?, ?, ?, ?)");
            $query->bindValue(1, $titulo);
            $query->bindValue(2, $mensaje);
            $query->bindValue(3, $tipomsj);
            $query->bindValue(4, $this->feMenu);
            $query->execute();

            $notificacionId = $this->conex2->lastInsertId();
    
            // Obtener todos los usuarios con status igual a 1
            $query = $this->conex2->prepare("SELECT u.cedula FROM usuario u
                INNER JOIN rol r ON u.idRol = r.idRol
                INNER JOIN permiso p ON p.idRol = r.idRol
                INNER JOIN modulo m ON m.idModulo = p.idModulo
                WHERE m.nombreModulo = 'Eventos' 
                AND p.nombrePermiso = 'consultar' 
                AND p.status = 1 
                AND u.status = 1;");
            $query->execute();
            $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);
    
            // Insertar en la tabla notificaciones_usuarios
            $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
            foreach ($usuarios as $usuario) {
                $query->bindValue(1, $usuario->cedula);
                $query->bindValue(2, $notificacionId);
                $query->execute();
            }
            $this->desconectarDB();
          } catch (Exception $e) {
              
              error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
          }
          
        }

        private function notificaciones2() {
          try {
             $this->conectarDBSeguridad();
            $titulo = "Registro de Evento";
            $mensaje = 'Se registro el evento '.$this->nomEvent. ' para '.$this->cantPlatos. '° comensales. Para el dia ' .$this->feMenu;
            $tipomsj = "informacion";
            $query = $this->conex2->prepare("INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)");
              $query->bindValue(1, $titulo);
              $query->bindValue(2, $mensaje);
              $query->bindValue(3, $tipomsj);
              $query->execute();
      
            $notificacionId = $this->conex2->lastInsertId();
      
            $query = $this->conex2->prepare("SELECT * FROM usuario u INNER JOIN rol r ON u.idRol = r.idRol INNER JOIN permiso p ON p.idRol = r.idRol INNER JOIN modulo m ON m.idModulo = p.idModulo WHERE m.nombreModulo = 'Menú' and p.nombrePermiso = 'consultar' and p.status = 1 and u.status = 1;");
            $query->execute();
            $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);
      
            $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
            foreach ($usuarios as $usuario) {
                $query->bindValue(1, $usuario->cedula);
                $query->bindValue(2, $notificacionId);
                $query->execute();
            }
      
          } catch (Exception $e) {
              
              error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
          }
        }
  
  
















}
        
?>