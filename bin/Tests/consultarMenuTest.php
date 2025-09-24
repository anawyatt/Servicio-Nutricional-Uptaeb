<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarMenuModelo as consultarMenu;

class consultarMenuTest extends TestCase {

      protected function setUp(): void {
          if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

        $this->object = new consultarMenu();
        $_SESSION['cedula'] = '12345678';
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

        public function test_mostrarM_DatosError() {
          $resultado = $this->object->mostrarM('2025-09-21', '2025/09/21');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía',$resultado['resultado']);

          $resultado = $this->object->mostrarM('21-09-2025', '2025-09-21');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        public function test_mostrarM_DatosFormatoInvalido() {
          $resultado = $this->object->mostrarM('2 de Noviembre del 2025','24 de Noviembre del 2025');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
          $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        public function test_mostrarM_DatosNoExiste() {
          $resultado = $this->object->mostrarM('2025-01-01', '2025-04-02');
          $this->assertIsArray($resultado);
          $this->assertEmpty($resultado, "No existen datos registrados, Ingrese la fecha correctamente");
        }

        public function test_mostrarM_DatosExiste() {
          $resultado = $this->object->mostrarM('2025-09-20', '2025-09-21');
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }

        //-------------------- VERIFICAR EXISTENCIA DEL REGISTRO DE MENÚS -----------------
        public function test_verificarExistencia_DatosVacios() {
          $resultado = $this->object->verificarExistencia('',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_verificarExistencia_DatosErroneos() {
          $resultado = $this->object->verificarExistencia('g*5',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_verificarExistencia_DatosNoExistenBD() {
          $resultado = $this->object->verificarExistencia(500);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('ya no existe', $resultado['resultado']);
        }
        
        public function test_verificarExistencia_DatosExistenBD() {
          $resultado = $this->object->verificarExistencia(50);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('si existe', $resultado['resultado']);
        }

        //-------------------- MOSTRAR INFORMACION DEL MENÚ -----------------

        public function test_menu_DatosVacios() {
          $resultado = $this->object->menu('',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_menu_DatosErroneos() {
          $resultado = $this->object->menu('0o2',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_menu_DatosNoExiste() {
          $resultado = $this->object->menu('900', );
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        }

        public function test_menu_DatosExiste() {
          $resultado = $this->object->menu('100'); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }

          //-------------------- MOSTRAR INFORMACION DEL MENÚ - ALIMENTOS -----------------

        public function test_alimento_DatosVacios() {
          $resultado = $this->object->alimento('', '');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Tipo Alimento, Ingresar Menú', $resultado['resultado']);
        }

        public function test_alimento_DatosErroneos() {
          $resultado = $this->object->alimento('0o2', 'P2');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Tipo Alimento, Ingresar Menú', $resultado['resultado']);
        }
       
        public function test_alimento_DatosNoExiste() {
          $resultado = $this->object->alimento('600', '200');
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        }

        public function test_alimento_DatosExiste() {
          $resultado = $this->object->alimento('13', '1'); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }

        //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  CONSULTAR MENU ---------------
        
        public function test_verificarExistenciaTipoA_DatosVacios() {
          $resultado = $this->object->verificarExistenciaTipoA('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

       
        public function test_verificarExistenciaTipoA_DatosErroneos() {
          $resultado = $this->object->verificarExistenciaTipoA('po00');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }


        public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
          $resultado = $this->object->verificarExistenciaTipoA(50);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no esta', $resultado['resultado']);
        } 


        public function test_verificarExistenciaTipoA_DatosExistenBD() {
          $resultado = $this->object->verificarExistenciaTipoA(12);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('si esta', $resultado['resultado']);
        }

        //------------------ VERIFICAR EXISTENCIA ALIMENTO - CONSULTAR MENU ---------------------


        public function test_verificarExistenciaAlimento_DatosVacios() {
          $resultado = $this->object->verificarExistenciaAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        } 

        public function test_verificarExistenciaAlimento_DatosErroneos() {
          $resultado = $this->object->verificarExistenciaAlimento('Man5o');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
          $resultado = $this->object->verificarExistenciaAlimento(700);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no esta', $resultado['resultado']);
        }

        public function test_verificarExistenciaAlimento_DatosExistenBD() {
          $resultado = $this->object->verificarExistenciaAlimento(9);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('si esta', $resultado['resultado']);
        } 

        //------------------ MOSTRAR ALIMENTO - CONSULTAR MENU ----------------------------------
        public function test_mostrarAlimento_DatosVacios() {
          $resultado = $this->object->mostrarAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']); 
        }

        public function test_mostrarAlimento_DatosErroneos() {
          $resultado = $this->object->mostrarAlimento('Dura129o');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        public function test_mostrarAlimento_DatosNoExiste() {
          $resultado = $this->object->mostrarAlimento('78');
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        } 
            
        public function test_mostrarAlimento_DatosExiste() {
          $resultado = $this->object->mostrarAlimento('1');
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        } 

        //------------------- INFORMACION DEL ALIMENTO - CONSULTAR MENU -------------------------

        public function test_infoAlimento_DatosVacios() {
          $resultado = $this->object->infoAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

        public function test_infoAlimento_DatosErroneos() {
          $resultado = $this->object->infoAlimento('9I0');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

        public function test_infoAlimento_DatosNoExiste() {
          $resultado = $this->object->infoAlimento('750');
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        }

        public function test_infoAlimento_DatosExiste() {
          $resultado = $this->object->infoAlimento('1'); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }

          //------------------ VERIFICAR MODIFICAR - CONSULTAR MENU ---------------------
        public function test_verificarModificacion_DatosVacios() {
          $resultado = $this->object->verificarModificacion('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_verificarModificacion_DatosErroneos() {
          $resultado = $this->object->verificarModificacion('5o');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_verificarModificacion_DatosNoExistenBD() {
          $resultado = $this->object->verificarModificacion(2);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no se puede', $resultado['resultado']);
        }

        public function test_verificarModificacion_DatosExistenBD() {
          $resultado = $this->object->verificarModificacion(80);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('se puede', $resultado['resultado']);
        } 

          //------------------- VALIDAR FECHA Y HORARIO -  MENU ---------------
       
        public function test_validarFH_DatosVacios() {
          $resultado = $this->object->validarFH('','','');
          $this->assertArrayHasKey('resultado', $resultado); 
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú, Seleccionar Menú', $resultado['resultado']);
        }

        public function test_validarFH_DatosErroneos() {
          $resultado = $this->object->validarFH('11 de noviembre del 2025','Almue23o', 'P23');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú, Seleccionar Menú',$resultado['resultado']);
        }

        public function test_validarFH_DatosNoExistenBD() {
            $resultado = $this->object->validarFH('2026-11-13', 'Almuerzo', '4000');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('No tiene un menú registrado para esa fecha y horario', $resultado['resultado']);
        }

        public function test_validarFH_DatosExistenBD() {
            $resultado = $this->object->validarFH('2025-10-10', 'Desayuno', '800');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error', $resultado['resultado']);
            $this->assertEquals('Ya tiene un menú registrado para esa fecha y horario', $resultado['mensaje']);
        }

           //------------------- MODIFICAR MENU -----------------
          public function test_modificarMenu_DatosVacios() {
            $resultado = $this->object->modificarMenu('', '', '', '','','');
            $this->assertArrayHasKey('resultado', $resultado);   
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Salida Alimento', $resultado['resultado']);
          } 

          public function test_modificarMenu_DatosErroneos() {
              $resultado = $this->object->modificarMenu('11 de noviembre del 2024', 'De432un9', 'p3o', 'a','k2','0o0',);
              $this->assertArrayHasKey('resultado', $resultado);
              $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
              $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
              $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
              $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);
              $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
              $this->assertStringContainsString('Seleccionar Salida Alimento', $resultado['resultado']);
          } 

          //------------------- MODIFICAR DESTALLE SALIDA MENU -----------------    
        public function test_detalleSalidaM_DatosVacios() {
          $resultado = $this->object->detalleSalidaM('', '', '', '');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Salida', $resultado['resultado']);
        } 

        public function test_detalleSalidaM_DatosErroneos() {
          $resultado = $this->object->detalleSalidaM('J3J', 'O0IK', 'POL02', 'PES2',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Salida', $resultado['resultado']);
        } 

          //------------------- MODIFICAR MENU -----------------
        public function test_modificarMenuYDetalleSalidaMenu_DatosListos() {
    
          $feMenu = '2025-09-22';
          $horarioComida = 'Cena';
          $cantPlatos = 900;
          $descripcion = 'Menú de cena';
          $id = 22;
          $idSalidaA = 6;
      
          $resultado = $this->object->modificarMenu($feMenu, $horarioComida, $cantPlatos, $descripcion, $id,
          $idSalidaA, );
      
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Menú Actualizado Exitosamente', $resultado['resultado']);
          $this->assertArrayHasKey('menuId', $resultado);
          $this->assertArrayHasKey('salidaId', $resultado);
      
          $menuId = $resultado['menuId'];
          $salidaId = $resultado['salidaId'];
      
          $alimentos = [
              ['alimento' => 2, 'cantidad' => 20],
              ['alimento' => 3, 'cantidad' => 20],
              ['alimento' => 4, 'cantidad' => 20]
          ];
      
          foreach ($alimentos as $item) {
              $detalleResultado = $this->object->detalleSalidaM($item['cantidad'], $menuId, $item['alimento'],
              $salidaId, );
      
              $this->assertArrayHasKey('resultado', $detalleResultado);
              $this->assertEquals('modificado alimentos exitosamente', $detalleResultado['resultado']);
          }
        }

    //------------------ VERIFICAR ELIMINAR - CONSULTAR MENU ---------------------
          public function test_verificarAnulacion_DatosVacios() {
            $resultado = $this->object->verificarAnulacion('',);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

          public function test_verificarAnulacion_DatosErroneos() {
            $resultado = $this->object->verificarAnulacion('09o',);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

          public function test_verificarAnulacion_DatosNoExistenBD() {
            $resultado = $this->object->verificarAnulacion(2);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no se puede', $resultado['resultado']);
          }

          public function test_verificarAnulacion_DatosExistenBD() {
            $resultado = $this->object->verificarAnulacion(60);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('se puede', $resultado['resultado']);
          } 

            // ------------------- ELIMINAR MENU ------------------------------------
          public function test_eliminarMenu_DatosVacios() {
            $resultado = $this->object->eliminarMenu('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

          public function test_eliminarMenu_DatosErroneos() {
            $resultado = $this->object->eliminarMenu('a04m');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

          public function test_eliminarMenuListo(){
            $id = 6;

            $resultado = $this->object->eliminarMenu($id, );
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('eliminado', $resultado['resultado']);
          }

}   
?>




