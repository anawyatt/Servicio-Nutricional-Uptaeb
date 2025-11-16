<?php 

    namespace modelo;
    use config\connect\connectDB as connectDB;
    use \PDO;
    use helpers\JwtHelpers;


    class menuModelo extends connectDB {
      private $feMenu;
      private $horarioComida;
    
      private $cantPlatos;
      private $descripcion;

      private $cantidad;
      private $idAlimento;

      private $tipoA;
      private $alimento;

      private $menuId;
      private $salidaId;

      private $payload;

    

      public function __construct(){
        parent ::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);

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

        public function mostrarAlimento($tipoA){
           if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
           $resultado = ['resultado' => 'Ingresar Alimento'];
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


        public function validarFH($feMenu, $horarioComida){
          if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
             return ['resultado' => 'Ingresar Fecha'];
          }

          if (!preg_match( "/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
            return ['resultado' => 'Seleccionar Horario del Menú']; 
          } 

           $this->feMenu = $feMenu;
           $this->horarioComida = $horarioComida;
           $resultado = $this->validar();
           return $resultado === true 
           ? ['resultado' => 'error', 'mensaje' => 'Ya tiene un menú registrado para esa fecha y horario'] 
           : ['resultado' => 'No tiene un menú registrado para esa fecha y horario'];
        }

        private function validar(){
          try {
            $this->conectarDB();
              $validar = $this->conex->prepare("SELECT m.idMenu, m.feMenu, m.horarioComida, m.status FROM menu m WHERE 
              m.feMenu = ? AND m.horarioComida = ? AND m.status != 0 AND NOT EXISTS (SELECT 1 FROM evento e WHERE e.idMenu = m.idMenu);");
              
              $validar->bindValue(1, $this->feMenu);
              $validar->bindValue(2, $this->horarioComida);
              
              $validar->execute();
              $data = $validar->fetchAll();
              $this->desconectarDB();

              return !empty($data);
            
              } catch (Exception $error) {
                  return (array("resultado" => "error", "mensaje" => "¡Error Sistema!"));
              }
        }

        public function registrarMenu($feMenu, $horarioComida, $cantPlatos, $descripcion) {
          if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
              return ['Ingresar Fecha del Menú en formato YYYY-MM-DD'];
          }
      
          if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
              return ['Seleccionar Horario del Menú']; 
          }
      
          if (!preg_match("/^[0-9]{1,}$/", $cantPlatos)) {
              return ['Ingresar cantidad de Platos']; 
          }
      
          if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $descripcion)) {
              return ['Ingresar Descripción del Menú']; 
          }
      
      
          $this->feMenu = $feMenu;
          $this->horarioComida = $horarioComida;
          $this->cantPlatos = $cantPlatos;
          $this->descripcion = $descripcion;
      
          return $this->menu(); 
        }
      
        private function menu(){
          try {
              $this->conectarDB();
              $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
              $this->conex->beginTransaction();
              $idTipoSalidas = $this->tipoSalida();
              $menuId = $this->infoMenu();
              $salidaId = $this->salidaAlimentos($idTipoSalidas);

              $bitacora = new bitacoraModelo;
              $bitacora->registrarBitacora('Menú', 'Se registró un menú para el dia: '.$this->feMenu.' n° comensales: '.$this->cantPlatos,  $this->payload->cedula);
        
              $this->conex->commit();
              $this->notificaciones2();
             
              return ['resultado' => 'registrado', 'menuId' => $menuId, 'salidaId' => $salidaId];


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

        private function salidaAlimentos($idTipoSalidas) {
          $new = $this->conex->prepare("INSERT INTO `salidaalimentos`(`idSalidaA`, `fecha`, `hora`, `descripcion`, `idTipoSalidaA`, `status`)  
          VALUES (DEFAULT, ?, NOW(), ?, ?, 1)");

          $new->bindValue(1, $this->feMenu);   
          $new->bindValue(2, $this->descripcion);
          $new->bindValue(3, $idTipoSalidas);
          $new->execute();
          return $this->conex->lastInsertId();
        }

        public function detalleSalidaM($alimento, $cantidad, $menuId, $salidaId) {
          if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
              return ['Ingresar Alimento'];
          }
      
         if (!preg_match("/^\d+([.,]\d+)?$/", $cantidad)) {
               return ['Ingresar Cantidad de Alimentos'];
          }
      
          if (!preg_match("/^[0-9]{1,}$/", $menuId)) {
              return ['Obtener ID del Menú'];
          }
      
          if (!preg_match("/^[0-9]{1,}$/", $salidaId)) {
             return['Obtener ID de la Salida'];
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
              $bitacora->registrarBitacora('Menú', 'Se despachó el alimento '.$nombreAlimento.' cantidad: '.$this->cantidad.' '.$unidadMedida, $this->payload->cedula);

              $this->conex->commit();
              return ['resultado' => 'exitoso'];

               
                    } catch (Exception $error) {
                $this->conex->rollBack();
                return ['error' => $error->getMessage()];     
            } finally {
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




private function notificaciones2() 
{
    try {
        $titulo = "Menú";
        $mensaje = 'Se registró un menú para ' . $this->cantPlatos . ' Estudiantes para el día ' . $this->feMenu . ' en el horario: ' . $this->horarioComida;
        $tipomsj = "informacion";
        $this->conectarDBSeguridad();
        $query = $this->conex2->prepare('INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)');
        $query->bindValue(1, $titulo);
        $query->bindValue(2, $mensaje);
        $query->bindValue(3, $tipomsj);
        $query->execute();

        $notificacionId = $this->conex2->lastInsertId();

        $query = $this->conex2->prepare("SELECT u.cedula FROM usuario u 
            INNER JOIN rol r ON u.idRol = r.idRol 
            INNER JOIN permiso p ON p.idRol = r.idRol 
            INNER JOIN modulo m ON m.idModulo = p.idModulo 
            WHERE m.nombreModulo = 'Menú' 
            AND p.nombrePermiso = 'consultar' 
            AND p.status = 1 
            AND u.status = 1;");
        $query->execute();
        $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);

        $cedulasDestino = [];
        if (!empty($usuarios)) {
            $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
            foreach ($usuarios as $usuario) {
                $query->bindValue(1, $usuario->cedula);
                $query->bindValue(2, $notificacionId);
                $query->execute();
                $cedulasDestino[] = $usuario->cedula;
            }
        }

        if (!empty($cedulasDestino)) {
            $this->enviarNotificacionWebSocket($cedulasDestino, [
                'type' => 'nueva_notificacion', 
                'idNotificaciones' => $notificacionId,
                'titulo' => $titulo,
                'mensaje' => $mensaje
            ]);
        }

        $this->desconectarDB();

    } catch (\Exception $e) {
        error_log("Error en notificaciones2 (Registro de Menú): " . $e->getMessage());
    }
}


private function enviarNotificacionWebSocket(array $cedulasDestino, array $data) {
    $url = 'http://localhost:3000/send-notif'; 
    $payload = [
        'cedulas' => $cedulasDestino,
        'data' => $data
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($payload)))
    );

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log('Error cURL al enviar a Node.js: ' . curl_error($ch));
    }
    curl_close($ch);
}
  ///------------------------------------------ CONSULTAR  - IA --------------------------------------
  
        public function stockAlimentosDisponibles(){
          try{
              $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT ta.tipo,a.idAlimento, a.nombre, a.unidadMedida, a.marca, a.stock FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE stock>0 AND a.status =1;");
                $mostrar->execute();
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                $this->desconectarDB();
                 return $data;
                
            }catch(\PDOException $e){
                return $e;
            }
        }

        public function MenuUltimo($horario){
          $this->horarioComida=$horario;
          return $this->MenusU();
        }

        public function MenusU(){
          try{
              $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT m.idMenu, m.feMenu, m.horarioComida, sa.descripcion, m.cantPlatos, ta.tipo, a.nombre, dsm.cantidad, a.marca, a.unidadMedida FROM menu m INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA INNER JOIN alimento a ON dsm.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE m.status = 1 AND m.horarioComida = ? AND m.idMenu = ( SELECT idMenu FROM menu WHERE status = 1 AND horarioComida = ? AND feMenu < CURDATE() AND idMenu NOT IN (SELECT e.idMenu FROM evento e) ORDER BY feMenu DESC, idMenu DESC LIMIT 1 ) ORDER BY a.nombre;`");
                $mostrar->bindValue(1, $this->horarioComida);
                $mostrar->bindValue(2, $this->horarioComida);
                $mostrar->execute();
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                $this->desconectarDB();
                 return $data;
                
            }catch(\PDOException $e){
                return $e;
            }
        }


        public function MenusHechos($horario){
          $this->horarioComida=$horario;
          return $this->MenusH();
        }

        public function MenusH(){
          try{
              $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT m.idMenu, m.feMenu, m.horarioComida, sa.descripcion, m.cantPlatos, ta.tipo, a.nombre, dsm.cantidad, a.marca, a.unidadMedida FROM menu m INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA INNER JOIN alimento a ON dsm.idAlimento = a.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA LEFT JOIN evento me ON m.idMenu = me.idMenu WHERE m.status = 1 AND m.horarioComida = ? AND me.idMenu IS NULL;");
                $mostrar->bindValue(1, $this->horarioComida);
                $mostrar->execute();
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                $this->desconectarDB();
                 return $data;
                
            }catch(\PDOException $e){
                return $e;
            }
        }

         public function entradaAlimentos(){
          try{
              $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT a.idAlimento, a.nombre, dea.cantidad, ea.fecha FROM alimento a INNER JOIN detalleentradaa dea ON a.idAlimento = dea.idAlimento INNER JOIN entradaalimento ea ON dea.idEntradaA = ea.idEntradaA INNER JOIN (  SELECT dea_max.idAlimento, MAX(ea_max.fecha) AS ultima_fecha FROM detalleentradaa dea_max INNER JOIN entradaalimento ea_max ON dea_max.idEntradaA = ea_max.idEntradaA GROUP BY dea_max.idAlimento ) AS ult_reg ON a.idAlimento = ult_reg.idAlimento AND ea.fecha = ult_reg.ultima_fecha;");
                $mostrar->execute();
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                $this->desconectarDB();
                 return $data;
                
            }catch(\PDOException $e){
                return $e;
            }
        }

    
}

?>
