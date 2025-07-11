<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use modelo\reporteModelo as reporte; 
use \PDO;
use helpers\JwtHelpers;



class consultarEventosModelo extends connectDB {

    private $fechaInicio;
    private $fechaFin;

    private $horarioComida;
    private $feMenu;
    private $cantPlatos;

    private $descripcion;

    private $cantidad;
    private $idAlimento;

    private $idTipoA;
    private $alimento;

    private $menuId;
    private $salidaId;

    private $id;
    private $idMenu;
    private $TipoA;
    private $idSalidaA;

    private $alimentos;
    private $nomEvent;
    private $descripEvent;
    private $payload;

    
   
    public function __construct(){
        parent ::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
        }

        public function mostrarE($fechaInicio, $fechaFin) {
            if (!preg_match("/^(?:\s*|((19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])))$/", $fechaInicio)) {
                return ['La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía'];
            }
        
            if (!preg_match("/^(?:\s*|((19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])))$/", $fechaFin)) {
                 return ['La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía'];
            }

            $this->fechaInicio = $fechaInicio;
            $this->fechaFin = $fechaFin;
            return $this->mostrarEvento();
        }
        
        private function mostrarEvento() {
            try {
                if (isset($this->payload->horario_comida)) {
                    $this->horario = $this->payload->horario_comida;
                    if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
                        return $this->mostrarEConHorarioConFiltros();
                    } else {
                        return $this->mostrarEConHorarioSinFiltros();
                    }
                } else {
                    if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
                        return $this->mostrarEConFiltros();
                    } else {
                        return $this->mostrarESinFiltros();
                    }
                }
            } catch (\Exception $e) {
                return ["Sistema", "¡Error Sistema!"];
            }
        }
        
        private function mostrarEConHorarioConFiltros() {
            try {
                $this->conectarDB();
                $info = $this->conex->prepare("SELECT e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos
                FROM salidaAlimentos sa JOIN detalleSalidaMenu dsm ON sa.idSalidaA = dsm.idSalidaA JOIN menu m ON dsm.idMenu = m.idMenu
                JOIN evento e ON m.idMenu = e.idMenu WHERE sa.status = 1 AND m.status = 1 AND dsm.status = 1 AND e.status = 1 AND m.feMenu BETWEEN ? AND ? 
               AND m.horarioComida = ? GROUP BY e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos ORDER BY m.feMenu;");
                
                $info->bindValue(1, $this->fechaInicio);
                $info->bindValue(2, $this->fechaFin);
                $info->bindValue(3, $this->horario);
                $info->execute();
                $data = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
                $this->desconectarDB();
        
                return $data;
            } catch (\Exception $error) {
                return ["Sistema", "¡Error Sistema!"];
            }
        }
        
        private function mostrarEConHorarioSinFiltros() {
            try {
                $this->conectarDB();
                $info = $this->conex->prepare("SELECT e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos
                FROM salidaAlimentos sa JOIN detalleSalidaMenu dsm ON sa.idSalidaA = dsm.idSalidaA JOIN menu m ON dsm.idMenu = m.idMenu
                JOIN evento e ON m.idMenu = e.idMenu WHERE sa.status = 1 AND dsm.status = 1 AND m.status = 1 AND e.status = 1 
                AND m.feMenu >= CURDATE() AND m.horarioComida = ? GROUP BY  e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, 
                m.horarioComida, m.cantPlatos ORDER BY m.feMenu ASC;");

                $info->bindValue(1, $this->horario);
                $info->execute();
                $data = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
                $this->desconectarDB();

                return $data;
            } catch (\Exception $error) {
                return ["Sistema", "¡Error Sistema!"];
            }
        }
        
        private function mostrarEConFiltros() {
            try {
                $this->conectarDB();
                $info = $this->conex->prepare("SELECT e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos
                FROM salidaAlimentos sa JOIN detalleSalidaMenu dsm ON sa.idSalidaA = dsm.idSalidaA JOIN menu m ON dsm.idMenu = m.idMenu
                JOIN evento e ON m.idMenu = e.idMenu WHERE sa.status = 1 AND dsm.status = 1 AND m.status = 1 AND e.status = 1 
                AND m.feMenu BETWEEN ? AND ? GROUP BY e.idEvento,  m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos
                ORDER BY m.feMenu;");
                
                $info->bindValue(1, $this->fechaInicio);
                $info->bindValue(2, $this->fechaFin);
                $info->execute();
                $data = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
                $this->desconectarDB();
    
                return $data;
            } catch (\Exception $error) {
                return ["Sistema", "¡Error Sistema!"];
            }
        }
        
        private function mostrarESinFiltros() {
            try {
                $this->conectarDB();
                $info = $this->conex->prepare("SELECT e.idEvento, m.feMenu, e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos
                FROM salidaAlimentos sa JOIN detalleSalidaMenu dsm ON sa.idSalidaA = dsm.idSalidaA JOIN menu m ON dsm.idMenu = m.idMenu
                JOIN evento e ON m.idMenu = e.idMenu WHERE sa.status = 1 AND dsm.status = 1 AND m.status = 1 AND e.status = 1 AND m.feMenu >= CURDATE()
                GROUP BY e.idEvento, m.feMenu,  e.nomEvent, e.descripEvent, m.horarioComida, m.cantPlatos ORDER BY m.feMenu ASC;");
                
                $info->execute();
                $data = $info->fetchAll(\PDO::FETCH_OBJ) ?: [];
                $this->desconectarDB();
        
                return $data;
            } catch (\Exception $error) {
                return ["Sistema", "¡Error Sistema!"];
            }
        }
        
        
        public function verificarExistencia($id){
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
               return ['resultado' => 'Seleccionar Evento'];
          }
            $this->id = $id;
            $resultado = $this->verificar(); 
            return $resultado === true ? ['resultado' => 'si existe'] : ['resultado' => 'ya no existe'];

        }

        private function verificar(){      
            try{
               $this->conectarDB();
              $mostrar=$this->conex->prepare("SELECT idEvento FROM evento WHERE idEvento = ? and status = 1");
              $mostrar->bindValue(1, $this->id);
              $mostrar->execute();
              $data = $mostrar->fetchAll();
              $this->desconectarDB();
               return $data !== false;
            } catch (Exception $error) {
                    return false;  
                
            }
        }

        public function evento($id) {
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
              return ['resultado' => 'Seleccionar Evento'];
            }
     
            $this->id = $id;
            return $this->mostrarEven();    
        }
    
        private function mostrarEven() {
            try {
                $this->conectarDB();
                $query = $this->conex->prepare("SELECT idTipoA, tipo, nomEvent FROM vista_tipo_alimento_evento WHERE idEvento = ?;");
                $query->bindValue(1, $this->id);
                $query->execute();
                $data = $query->fetchAll();
                $this->desconectarDB();
                return $data;
            } catch (\PDOException $e) {
                return $e;
            }
        }

        public function alimento( $idTipoA, $idEvento) {
            if (!preg_match("/^[0-9]{1,}$/", $idTipoA)) {
            return ['Ingresar Tipo Alimento'];
            }

            if (!preg_match("/^[0-9]{1,}$/", $idEvento)) {
             return ['Ingresar Evento'];
            }

            $this->idTipoA = $idTipoA;
            $this->id = $idEvento;
            return $this->mostEven();
        }

        private function mostEven(){
            try {
                 $this->conectarDB();
                $show = $this->conex->prepare("SELECT idAlimento, imgAlimento, nombre, marca, unidadMedida, cantidad, idTipoA, tipo, idMenu, feMenu, horarioComida, cantPlatos, descripcion, idSalidaA, 
                idEvento, nomEvent, descripEvent, idMenuEvento FROM vista_detalle_alimentos_evento WHERE idTipoA = ? AND idEvento = ?;");

                $show->bindValue(1, $this->idTipoA);
                $show->bindValue(2, $this->id);
      
                $show->execute();
                $data = $show->fetchAll(PDO::FETCH_ASSOC);
                $this->desconectarDB(); 
                
                return $data;
                } catch (\PDOException $e) {
                    return $e->getMessage();
            }
        }

         public function verificarExistenciaTipoA($tipoA){
            if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
                return ['resultado' => 'Ingresar el Tipo de Alimento'];
            }
           
             $this->tipoA = $tipoA;
             $resultado = $this->verificarETA();
             return $resultado === true ? ['resultado' => 'no esta'] : ['resultado' => 'si esta'];

        }
    
        private function verificarETA(){
          try{
            $this->conectarDB();
            $verificar=$this->conex->prepare("CALL verificar_existencia_tipo_alimento(?);");
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
                $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                 $this->desconectarDB();
                echo json_encode($data);
                die();
    
            }catch(\PDOException $e){
                return $e;
             }
            
        }

        public function verificarExistenciaAlimento($alimento){
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
                return ['resultado' => 'Ingresar Alimento'];
            }
           $this->tipoA = $tipoA;
           return $this->mostrarA();
        }
  
        private function mostrarA(){
            try{
                $this->conectarDB();
                $mostrar = $this->conex->prepare("SELECT DISTINCT a.idAlimento, a.codigo, a.imgAlimento, a.nombre, a.unidadMedida, a.marca, a.stock FROM tipoalimento ta INNER JOIN alimento a ON ta.idTipoA = a.idTipoA WHERE a.idTipoA =? and a.stock > 0 and a.idAlimento IN (SELECT idAlimento FROM detalleentradaa WHERE status=1);");
                $mostrar->bindValue(1, $this->tipoA);
                $mostrar->execute();
                $resultado = $mostrar->fetchAll();
                $this->desconectarDB();
            
                return $resultado;
    
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
                $resultado = $mostrar->fetchAll();
                return $resultado;
        
            }catch(\PDOException $e){
                return $e;
            }
        }

        public function verificarModificacion($id){
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Seleccionar Evento'];
            }
            $this->id=$id;
            $resultado = $this->verificarModi();
            return $resultado === true ? ['resultado' => 'no se puede'] : ['resultado' => 'se puede'];
        }

        private function verificarModi(){
            try{
                 $this->conectarDB();

                $mostrar=$this->conex->prepare("SELECT e.idEvento FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu
                INNER JOIN detalleSalidaMenu dsm ON dsm.idMenu = m.idMenu INNER JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA
                WHERE e.idEvento = ? AND m.feMenu <= CURRENT_DATE;");
      
                $mostrar->bindValue(1, $this->id);
                $mostrar->execute();
                $data = $mostrar->fetchAll();
                $this->desconectarDB();
                return !empty($data);

            } catch (\Exception $error) {
                return ['resultado' => 'error', 'mensaje' => '¡Error del sistema!'];
            }
        }

        public function validarFH($feMenu, $horarioComida, $idEvento) {
            if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
               return ['Ingresar Fecha del Evento'];
            }
        
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
               return ['Seleccionar Horario del Evento'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idEvento)) {
               return ['Seleccionar Evento'];
            }
        
            $this->feMenu = $feMenu;
            $this->horarioComida = $horarioComida;
            $this->idEvento = $idEvento;
        
            $resultado = $this->validar();
            return $resultado === true ? ['resultado' => 'error', 'mensaje' => 'Ya tiene un evento registrado para esa fecha y horario'] 
           :  ['resultado' => 'No tiene un evento registrado para esa fecha y horario'];
        }
        

        private function validar(){
            try {
                $this->conectarDB();
                $validar = $this->conex->prepare("SELECT * FROM evento e LEFT JOIN menu m ON e.idMenu = m.idMenu 
                WHERE m.feMenu = ? AND m.horarioComida = ?  AND (m.idMenu IS NOT NULL AND m.status = 1)  AND (e.idEvento != ? AND e.status = 1);");
               
                $validar->bindValue(1, $this->feMenu);
                $validar->bindValue(2, $this->horarioComida);
                $validar->bindValue(3, $this->idEvento);
                
                $validar->execute();
                $data = $validar->fetchAll();
                $this->desconectarDB();
        
                 return !empty($data);
            
              } catch (Exception $error) {
                  return (array("resultado" => "error", "mensaje" => "¡Error Sistema!"));
              }
        }
        
        public function modificarEven($feMenu, $cantPlatos, $nomEvent, $descripEvent, $horarioComida, $descripcion, $id, $idSalidaA, $idMenu) {
        
            if (!preg_match("/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $feMenu)) {
               return ['Ingresar Fecha del Menú en formato YYYY-MM-DD'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $cantPlatos)) {
               return ['Ingresar cantidad de Platos'];
            }
        
            if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $nomEvent)) {
               return ['Ingresar Nombre del Evento'];
            }
        
            if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $descripEvent)) {
               return ['Ingresar descripción del evento'];
            }
        
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $horarioComida)) {
               return ['Seleccionar Horario del Menú'];
            }
        
            if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/", $descripcion)) {
               return ['Ingresar descripción del Menú'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
                return ['Seleccionar Evento'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idSalidaA)) {
                return ['Seleccionar Salida de Alimento'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idMenu)) {
                return ['Seleccionar Menú'];
            }
        
            $this->feMenu = $feMenu;
            $this->cantPlatos = $cantPlatos;
            $this->nomEvent = $nomEvent;
            $this->descripEvent = $descripEvent;
            $this->horarioComida = $horarioComida;
            $this->descripcion = $descripcion;
            $this->id = $id;
            $this->idSalidaA = $idSalidaA;
            $this->idMenu = $idMenu;
        
            return $this->modiEvento();
        }
        
        
        private function modiEvento() {
            try {
                $this->conectarDB();
                $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
                $this->conex->beginTransaction();

                $bitacora = new bitacoraModelo;
        
                $idTipoSalidas = $this->tipoSalidaMenu();
                $updateM = $this->datosMenu($this->idMenu);
                $updateE = $this->datosEvento($this->id);
                $updateS = $this->salidaA($idTipoSalidas, $this->idSalidaA);
                $borrar=$this->borrarAlimentoM($this->idSalidaA);



                if ($updateM['feMenu'] !== $this->feMenu) {
                    $this->actualizarFechaMenu($this->feMenu, $this->idMenu);
                    $bitacora->registrarBitacora('Modificar Evento', "feMenu de '{$updateM['feMenu']}' a '{$this->feMenu}'",$this->payload->cedula);
                }
                if ($updateM['horarioComida'] !== $this->horarioComida) {
                    $this->actualizarHorarioComida($this->horarioComida, $this->idMenu);
                    $bitacora->registrarBitacora('Modificar Evento', "horarioComida de '{$updateM['horarioComida']}' a '{$this->horarioComida}'",$this->payload->cedula);
                }
                if ($updateM['cantPlatos'] !== $this->cantPlatos) {
                    $this->actualizarCantidadPlatos($this->cantPlatos, $this->idMenu);
                    $bitacora->registrarBitacora('Modificar Evento', "cantPlatos de '{$updateM['cantPlatos']}' a '{$this->cantPlatos}'",$this->payload->cedula);
                }
        
                if ($updateE['nomEvent'] !== $this->nomEvent) {
                    $this->actualizarNombreEvento($this->nomEvent, $this->id);
                    $bitacora->registrarBitacora('Modificar Evento', "nomEvent de '{$updateE['nomEvent']}' a '{$this->nomEvent}'",$this->payload->cedula);
                }
                if ($updateE['descripEvent'] !== $this->descripEvent) {
                    $this->actualizarDescripcionEvento($this->descripEvent, $this->id);
                    $bitacora->registrarBitacora('Modificar Evento', "descripEvent de '{$updateE['descripEvent']}' a '{$this->descripEvent}'",$this->payload->cedula);
                }
        
                if ($updateS['descripcion'] !== $this->descripcion) {
                    $this->actualizarDescripcionSalida($this->descripcion, $idTipoSalidas, $this->idSalidaA);
                    $bitacora->registrarBitacora('Modificar Evento', "descripcion de '{$updateS['descripcion']}' a '{$this->descripcion}'",$this->payload->cedula);
                }
        
                $this->conex->commit();

                return ['resultado' => 'Evento Actualizado Exitosamente','eventoId' => $this->id,'menuId' => $this->idMenu,'salidaId' => $this->idSalidaA];
                
            } catch (Exception $error) {
               $this->conex->rollBack();
                return ['error' => $error->getMessage()];
            }
             finally {
                $this->desconectarDB();
            }
          
        }
        
        private function tipoSalidaMenu() {
            $info = $this->conex->prepare("SELECT idTipoSalidas FROM tiposalidas WHERE tipoSalida = 'Menú'");
            $info->execute();
            return $info->fetchColumn();
        }
      
        
         private function datosMenu($idMenu) {
            $info = $this->conex->prepare("SELECT feMenu, horarioComida, cantPlatos FROM menu WHERE idMenu = ? AND status = 1 FOR UPDATE");
            $info->bindValue(1, $idMenu);
            $info->execute();
            return $info->fetch(PDO::FETCH_ASSOC);
        }

       
        private function datosEvento($idEvento) {
            $info = $this->conex->prepare("SELECT nomEvent, descripEvent FROM evento WHERE idEvento = ? AND status = 1 FOR UPDATE");
            $info->bindValue(1, $idEvento);
            $info->execute();
            return $info->fetch(PDO::FETCH_ASSOC);
        }
        
        private function salidaA($idTipoSalidas, $idSalidaA) {
            $info = $this->conex->prepare("SELECT descripcion FROM salidaalimentos WHERE idTipoSalidaA = ? AND idSalidaA = ? AND status = 1 FOR UPDATE");
            $info->bindValue(1, $idTipoSalidas);
            $info->bindValue(2, $idSalidaA);
            $info->execute();
            return $info->fetch(PDO::FETCH_ASSOC);
        }
        
        private function actualizarFechaMenu($feMenu, $idMenu) {
            $info = $this->conex->prepare("UPDATE menu SET feMenu = ? WHERE idMenu = ? AND status = 1");
            $info->bindValue(1, $feMenu);
            $info->bindValue(2, $idMenu);
            $info->execute();
        }
        
        private function actualizarHorarioComida($horarioComida, $idMenu) {
            $info = $this->conex->prepare("UPDATE menu SET horarioComida = ? WHERE idMenu = ? AND status = 1");
            $info->bindValue(1, $horarioComida);
            $info->bindValue(2, $idMenu);
            $info->execute();
        }
        
        private function actualizarCantidadPlatos($cantPlatos, $idMenu) {
            $info = $this->conex->prepare("UPDATE menu SET cantPlatos = ? WHERE idMenu = ? AND status = 1");
            $info->bindValue(1, $cantPlatos);
            $info->bindValue(2, $idMenu);
            $info->execute();
        }
        
        private function actualizarNombreEvento($nomEvent, $idEvento) {
            $info = $this->conex->prepare("UPDATE evento SET nomEvent = ? WHERE idEvento = ? AND status = 1");
            $info->bindValue(1, $nomEvent);
            $info->bindValue(2, $idEvento);
            $info->execute();
        }
        
        private function actualizarDescripcionEvento($descripEvent, $idEvento) {
            $info = $this->conex->prepare("UPDATE evento SET descripEvent = ? WHERE idEvento = ? AND status = 1");
            $info->bindValue(1, $descripEvent);
            $info->bindValue(2, $idEvento);
            $info->execute();
        }
        
        private function actualizarDescripcionSalida($descripcion, $idTipoSalidas, $idSalidaA) {
            $info = $this->conex->prepare("UPDATE salidaalimentos SET descripcion = ? WHERE idTipoSalidaA = ? AND idSalidaA = ? AND status = 1");
            $info->bindValue(1, $descripcion);
            $info->bindValue(2, $idTipoSalidas);
            $info->bindValue(3, $idSalidaA);
            $info->execute();
        }
        
        public function detalleSalidaE($cantidad, $idMenu, $idAlimento, $idSalidaA) {
            if (!preg_match("/^[0-9]{1,}$/", $cantidad)) {
                return ['Ingresar cantidad de alimentos'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idMenu)) {
                return ['Seleccionar Menú'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idAlimento)) {
                return ['Seleccionar Alimentos'];
            }
        
            if (!preg_match("/^[0-9]{1,}$/", $idSalidaA)) {
                return ['Seleccionar Salida ID'];
            }
        
            $this->cantidad = $cantidad;
            $this->idMenu = $idMenu;
            $this->alimento = $idAlimento;
            $this->idSalidaA = $idSalidaA;
        
            return $this->actualizarDetalle();
        }
        
        private function actualizarDetalle(){
            try {
                 $this->conectarDB();
                $new = $this->conex->prepare("INSERT INTO detallesalidamenu(idDetalleSalidaMenu, cantidad, idMenu, idAlimento, idSalidaA, status) VALUES (DEFAULT,?,?,?,?,1)");
                $new->bindValue(1, $this->cantidad);
                $new->bindValue(2, $this->idMenu);
                $new->bindValue(3, $this->alimento);
                $new->bindValue(4, $this->idSalidaA);
                $new->execute();
        
                $this->actualizarStock($this->alimento, $this->cantidad);
                $this->actualizarReservado($this->alimento, $this->cantidad);
                $this->desconectarDB();
                
                return ['resultado' => 'modificado alimentos exitosamente'];

                } catch (Exception $error) {   
                  $this->conex->rollBack();
                  return ['error' => $error->getMessage()];     
               }
               finally {
                   $this->desconectarDB();
               } 
        }
              
        private function actualizarStock($alimento, $cantidad){
            $this->alimento= $alimento;
            $this->cantidad= $cantidad;
            try {
                $info = $this->infoAlimento2($this->alimento);
                $actualizarStock = $info[0]["stock"] - $this->cantidad;
                $registrar = $this->conex->prepare("UPDATE alimento SET stock = ? WHERE idAlimento = ?");
                $registrar->bindValue(1, $actualizarStock);
                $registrar->bindValue(2, $this->alimento);
                $registrar->execute();
            } catch(Exception $error) {
                return array("Sistema", "¡Error Sistema!");
            }
        }

        private function actualizarReservado($idAlimento, $cantidad){
            $this->alimento=$idAlimento;
            $this->cantidad=$cantidad;
           try {
        
              $info= $this->infoAlimento2($this->alimento);
              $actualizarReservado= $info[0]["reservado"] + $this->cantidad;
              $registrar=$this->conex->prepare("UPDATE `alimento` SET  reservado = ? WHERE `idAlimento` = ?;");
              $registrar->bindValue(1, $actualizarReservado);
              $registrar->bindValue(2, $this->alimento);
              $registrar->execute();
           }
           
           catch(exection $error){
                    return array("Sistema", "¡Error Sistema!");
        
           }
        
        }
    

        private function infoAlimento2($alimento){
          $this->alimento=$alimento;
          
          try{
              $mostrar = $this->conex->prepare("SELECT idAlimento, codigo, imgAlimento, nombre, unidadMedida, marca,
              stock, reservado, idTipoA  FROM alimento WHERE status = 1 AND idAlimento = ? FOR UPDATE;");
              $mostrar->bindValue(1, $this->alimento);
              $mostrar->execute();
              $data = $mostrar->fetchAll();
              return $data;
              
          }catch(\PDOException $e){
              return $e;
           }
        }

        private function borrarAlimentoM($id) {
            $this->id = $id;
            try {
                $data = $this->obtenerAlimentosSalida($this->id);
        
                $this->eliminarDetallesSalida($this->id);
        
                foreach ($data as $item) {
                    $this->regresarStock($item->idAlimento, $item->cantidad);
                    $this->borrarReservado($item->idAlimento, $item->cantidad);
                }
           } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        private function obtenerAlimentosSalida($idSalidaA) {
            $info = $this->conex->prepare("SELECT idAlimento, cantidad FROM detallesalidamenu WHERE idSalidaA = ? FOR UPDATE;");
            $info->bindValue(1, $idSalidaA);
            $info->execute();
            return $info->fetchAll(PDO::FETCH_OBJ);
        }
        
        private function eliminarDetallesSalida($idSalidaA) {
            $delet = $this->conex->prepare("DELETE FROM detallesalidamenu WHERE idSalidaA = ?");
            $delet->bindValue(1, $idSalidaA);
            $delet->execute();
        }
         
        private function regresarStock($idAlimento, $cantidad) {
            try {
                $info = $this->infoAlimento2($idAlimento);
                $nuevoStock = $info[0]["stock"] + $cantidad;
        
                $updateStock = $this->conex->prepare("UPDATE alimento SET stock = ? WHERE idAlimento = ?");
                $updateStock->bindValue(1, $nuevoStock);
                $updateStock->bindValue(2, $idAlimento);
                $updateStock->execute();
            } catch (Exception $error) {
                throw new Exception("Error al actualizar el stock: " . $error->getMessage());
            }
        }

        private function borrarReservado($idAlimento, $cantidad) {
            try {
                $info = $this->infoAlimento2($idAlimento);
                $nuevoReserva = $info[0]["reservado"] - $cantidad;
        
                $updateReserva = $this->conex->prepare("UPDATE alimento SET reservado = ? WHERE idAlimento = ?");
                $updateReserva->bindValue(1, $nuevoReserva);
                $updateReserva->bindValue(2, $idAlimento);
                $updateReserva->execute();
            } catch (Exception $error) {
                throw new Exception("Error al actualizar el stock: " . $error->getMessage());
            }
        }


        public function verificarAnulacion($id){
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
                return ['resultado' => 'Seleccionar Evento'];
            }

            $this->id = $id;
            $resultado = $this->verify();
            return $resultado === true ? ['resultado' => 'no se puede'] : ['resultado' => 'se puede'];
        }

        private function verify(){    
            try{
                $this->conectarDB();
                $mostrar=$this->conex->prepare("SELECT e.idEvento FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu
                INNER JOIN detalleSalidaMenu dsm ON dsm.idMenu = m.idMenu INNER JOIN salidaAlimentos sa ON dsm.idSalidaA = sa.idSalidaA
                WHERE e.idEvento = ? AND m.feMenu <= CURRENT_DATE;");

                $mostrar->bindValue(1, $this->id);
                $mostrar->execute();
                $data = $mostrar->fetchAll();
                $this->desconectarDB();
                return !empty($data);                
            }
            catch (\Exception $error) {
                return array("Sistema", "¡Error Sistema!");
            }
        }

        public function eliminarEvento($id) {
            if (!preg_match("/^[0-9]{1,}$/", $id)) {
              return ['resultado' => 'Obtener ID Evento'];
            } 
      
            $this->id = $id;
            return $this->eliminar();
        } 
        
        private function eliminar() {
            try {
                $this->conectarDB();
                $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
                $this->conex->beginTransaction();
                $mostrar = $this->conex->prepare("SELECT m.idMenu, sa.idSalidaA FROM evento e INNER JOIN menu m ON m.idMenu = e.idMenu INNER JOIN detallesalidamenu dsm 
                ON m.idMenu = dsm.idMenu INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA WHERE e.idEvento = ? FOR UPDATE;");
                $mostrar->bindValue(1, $this->id);
                $mostrar->execute();
                $data = $mostrar->fetchAll(PDO::FETCH_ASSOC);

                if (empty($data)) {
                    throw new Exception("No se encontraron idMenu e idSalidaA relacionados con el evento.");
                }

                $idMenu = $data[0]["idMenu"];

                $this->anularEvento($this->id);
                $this->anularMenu($idMenu);

                $procesados = [];

                foreach ($data as $row) {
                    $idSalidaA = $row["idSalidaA"];

                    if (in_array($idSalidaA, $procesados)) {
                        continue;
                    }

                    $this->anularSalidaA($idSalidaA);
                    $this->anularDetalle($idSalidaA);
                    $this->restarCantidadStock($idSalidaA);
                    $this->restarCantidadReservado($idSalidaA);

                    $procesados[] = $idSalidaA;
                }

        
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Eliminar Evento', "Se ha eliminado un Evento con idEvento: {$this->id}",$this->payload->cedula);
        
             
                $this->conex->commit();
        
                return ['resultado' => 'eliminado'];
            
               } catch (Exception $e) {
                $this->conex->rollBack();
                return ['error' => $e->getMessage()];
            } finally {
                $this->desconectarDB();
            }
        }

        private function anularEvento($id) {
            try {
                $new = $this->conex->prepare("UPDATE evento SET status = 0 WHERE idEvento = ?;");
                $new->bindValue(1, $id);
                $new->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        private function anularMenu($id) {
            try {
                $new = $this->conex->prepare("UPDATE menu SET status = 0 WHERE idMenu = ? ");
                $new->bindValue(1, $id);
                $new->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

         private function anularSalidaA($id) {
            try {
                $new = $this->conex->prepare("UPDATE `salidaalimentos` SET status = 0 WHERE `idSalidaA` = ?");
                $new->bindValue(1, $id);
                $new->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        private function anularDetalle($id) {
            try {
                $new = $this->conex->prepare("UPDATE `detallesalidamenu` SET status = 0 WHERE `idSalidaA` = ?");
                $new->bindValue(1, $id);
                $new->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        private function restarCantidadStock($id) {
            try {
               $data = $this->obtenerCantidadAlimentosSalida($id);
        
               foreach ($data as $cant) {
                    $nuevoStock = $cant->stock + $cant->totalCantidad;
                    $this->actualizarStockAlimento($cant->idAlimento, $nuevoStock);
                }
        
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        private function obtenerCantidadAlimentosSalida($idSalidaA) {
            $info = $this->conex->prepare("SELECT a.idAlimento, a.stock, SUM(dsm.cantidad) AS totalCantidad FROM salidaAlimentos sa 
            INNER JOIN detallesalidamenu dsm ON dsm.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento 
            WHERE sa.idSalidaA = ?  GROUP BY a.idAlimento, a.stock;");
            $info->bindValue(1, $idSalidaA);
            $info->execute();
            return $info->fetchAll(PDO::FETCH_OBJ);
        }
        
        private function actualizarStockAlimento($idAlimento, $nuevoStock) {
            $updateStock = $this->conex->prepare("UPDATE alimento SET stock = ? WHERE idAlimento = ?");
            $updateStock->bindValue(1, $nuevoStock);
            $updateStock->bindValue(2, $idAlimento);
            $updateStock->execute();
        }
        
        private function restarCantidadReservado($id) {
            try {
               $data = $this->obtenerCantidadReservadoSalida($id);
        
                foreach ($data as $cant) {
                    $nuevoReservado = $cant->reservado + $cant->totalCantidad;
                    $this->actualizarReservadoAlimento($cant->idAlimento, $nuevoReservado);
                }
        
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        
        private function obtenerCantidadReservadoSalida($idSalidaA) {
            $info = $this->conex->prepare("SELECT a.idAlimento, a.reservado, -SUM(dsm.cantidad) AS totalCantidad FROM salidaAlimentos sa 
            INNER JOIN detallesalidamenu dsm ON dsm.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento 
            WHERE sa.idSalidaA = ? GROUP BY a.idAlimento, a.reservado;");

            $info->bindValue(1, $idSalidaA);
            $info->execute();
            return $info->fetchAll(PDO::FETCH_OBJ);
        }
        
        private function actualizarReservadoAlimento($idAlimento, $nuevoReservado) {
            $updateReservado = $this->conex->prepare("UPDATE alimento SET reservado = ? WHERE idAlimento = ?");
            $updateReservado->bindValue(1, $nuevoReservado);
            $updateReservado->bindValue(2, $idAlimento);
            $updateReservado->execute();
        }    
 
        private function detalleEvento($id){
 
            try{
                 $this->conectarDB();
                $this->id = $id;
                $mostrar=$this->conex->prepare("SELECT * FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu INNER JOIN
                detallesalidamenu dsm ON m.idMenu = dsm.idMenu AND dsm.status = 1 INNER JOIN salidaalimentos sa ON dsm.idSalidaA = 
                sa.idSalidaA AND sa.status = 1 INNER JOIN alimento a ON dsm.idAlimento = a.idAlimento AND a.status = 1 INNER JOIN 
                tipoalimento ta ON a.idTipoA = ta.idTipoA AND ta.status = 1 WHERE e.idEvento = ?;");
                 $mostrar->bindValue(1, $this->id);
                 $mostrar->execute();
                 $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
                 $this->desconectarDB();
                    return $data;

            }
            catch(Exception $error){

                 return array("Sistema", "¡Error Sistema!");
            }
        }
        
        public function fpdf($id) {
            try {
                $this->id = $id;
                $descripcion = $this->descripcionEvento($this->id);
                $detalle = $this->detalleEvento($this->id, true);
               
                $data = [
                    'descripcion' => $descripcion,
                    'detalle' => $detalle
                ];
        
                /*-------fDFD--------*/
                $reporte = new reporte;
                $reporte->AddPage();
                $reporte->evento($data);
                $reporte->Output();
        
            } catch (\PDOException $e) {
                return $e;
            }
       }
        
     
        private function descripcionEvento($id) {
             $this->conectarDB();
            $info = $this->conex->prepare("SELECT * FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu  
            INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA WHERE e.idEvento = ?;");
            $info->bindValue(1, $id);
            $info->execute();
            $dta=$info->fetchAll(\PDO::FETCH_OBJ);
             $this->desconectarDB();
             return $dta;
        }
          
        
         public function infoAppEvento($idEvento) {
            if (!preg_match("/^[0-9]{1,}$/", $idEvento)) {
                return ['Ingresar Evenot'];
            }

            $this->idEvento = $idEvento;
            return $this->mostrarAppEvento();
        }


        private function mostrarAppEvento(){
            try {
                $this->conectarDB();
                $query = $this->conex->prepare("SELECT a.idAlimento, a.imgAlimento, a.nombre, a.marca, a.unidadMedida, dsm.cantidad,
                ta.idTipoA, ta.tipo, m.idMenu, m.feMenu, m.horarioComida, m.cantPlatos, sa.descripcion, sa.idSalidaA, e.idEvento,
                e.nomEvent, e.descripEvent, e.idMenu AS idMenuEvento FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu AND m.status = 1
                INNER JOIN detallesalidamenu dsm ON dsm.idMenu = m.idMenu AND dsm.status = 1 LEFT JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA AND sa.status = 1
                INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento AND a.status = 1 INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA AND ta.status = 1
                WHERE e.status = 1 AND e.idEvento = ?;");

                $query->bindValue(1, $this->idEvento);
                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC); 
                 $this->desconectarDB();
        
                return $resultado;
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        }