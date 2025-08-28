<?php /*
use PHPUnit\Framework\TestCase;
use modelo\eventoModelo as evento;

class eventoTest extends TestCase {

    protected function setUp(): void {
        $this->object = new evento();
        $_SESSION['cedula'] = '12345678';     
    }

    protected function tearDown(): void {
        unset($this->object);
    }

     //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  EVENTO ---------------
       // Prueba para datos vacíos
       public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->object->verificarExistenciaTipoA('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

          // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaTipoA('Toma45',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

          // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(60,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
        }

        // Prueba para datos que existen en la base de datos
        public function test_verificarExistenciaTipoA_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(2,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
        }

        //------------------ VERIFICAR EXISTENCIA ALIMENTO - EVENTO ---------------------

                // Prueba para datos vacíos
        public function test_verificarExistenciaAlimento_DatosVacios() {
        $resultado = $this->object->verificarExistenciaAlimento('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        } 

              // Prueba para datos vacíos
         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaAlimento_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaAlimento('Rem9394ch',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }
        
           // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(30,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
        } 
        
           // Prueba para datos que existen en la base de datos
        public function test_verificarExistenciaAlimento_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(5,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
        } 

          //------------------ MOSTRAR ALIMENTO - EVENTO ----------------------------------

           // Prueba para datos vacíos
          public function test_mostrarAlimento_DatosVacios() {
          $resultado = $this->object->mostrarAlimento('',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']); 
          }

            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
          public function test_mostrarAlimento_DatosErroneos() {
          $resultado = $this->object->mostrarAlimento('Mo4a',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
          }

            // Prueba para un  alimento que no existe
          public function test_mostrarAlimento_DatosNoExiste() {
          $resultado = $this->object->mostrarAlimento('52', false);
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
          }

           // Prueba para un  alimento existente
          public function test_mostrarAlimento_DatosExiste() {
          $resultado = $this->object->mostrarAlimento('1', false); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
          } 

               //------------------- INFORMACION DEL ALIMENTO - EVENTO -------------------------
                  // Prueba para datos vacíos
          public function test_infoAlimento_DatosVacios() {
          $resultado = $this->object->infoAlimento('',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
          }

            // Prueba para datos erróneos (no cumplen con las expesiones regulares)
          public function test_infoAlimento_DatosErroneos() {
          $resultado = $this->object->infoAlimento('07po0;',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
          }

           // Prueba para un la informacion del alimento que no existe
           public function test_infoAlimento_DatosNoExiste() {
           $resultado = $this->object->infoAlimento('88', false);
           $this->assertIsArray($resultado);
           $this->assertCount(0, $resultado); 
          }

           // Prueba para un  alimento existente
          public function test_infoAlimento_DatosExiste() {
          $resultado = $this->object->infoAlimento('1', false); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
          }

           //------------------- VALIDAR FECHA Y HORARIO -  EVENTO ---------------
            // Prueba para datos vacíos
          public function test_validarFH_DatosVacios() {
          $resultado = $this->object->validarFH('','', false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
          }

            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
          public function test_validarFH_DatosErroneos() {
          $resultado = $this->object->validarFH('20 de septiembre', 'Dejs74n', false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
          }

             // Prueba para datos inexistentes en la base de datos
          public function test_validarFH_DatosNoExistenBD() {
          $resultado = $this->object->validarFH('2024-12-12','Cena',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('No tiene un evento registrado para esa fecha y horario', $resultado['resultado']);
          }

            // Prueba para datos que existen en la base de datos
           public function test_validarFH_DatosExistenBD() {
            $resultado = $this->object->validarFH('2024-11-18', 'Merienda', false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error', $resultado['resultado']);    
            $this->assertArrayHasKey('mensaje', $resultado);
            $this->assertEquals('Ya tiene un evento registrado para esa fecha y horario', $resultado['mensaje']);
            }

            //-------------------VERIFICAR DATOS PARA REGISTRA EVENTOS -----------------
            // Prueba para datos vacíos
            public function test_registrarEvento_DatosVacios() {
            $resultado = $this->object->registrarEvento('', '', '',
            '', '','',false);
      
            $this->assertArrayHasKey('resultado', $resultado);
          
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
            }

            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
           public function test_registrarEvento_DatosErroneos() {
            $resultado = $this->object->registrarEvento('25 de noviembre del 2025',
             'De354yo','4u5','1a', '12','p1',
            false);
    
            $this->assertArrayHasKey('resultado', $resultado);
        
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
            }

              //-------------------VERIFICAR DATOS PARA REGISTRA DETALLE SALIDA EVENTO -----------------

                // Prueba para datos vacíos
            public function test_detalleSalidaM_DatosVacios() {
            $resultado = $this->object->detalleSalidaM('', '', '', '', false);

            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
            } 

            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_detalleSalidaM_DatosErroneos() {
            $resultado = $this->object->detalleSalidaM('YY76', 'PO9', '6D','0P9J', false);

            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
            }  


   // --------------------- REGISTRO DE UN EVENTO-----------------------------
          public function test_registrarEventoYDetalleSalidaMenu_DatosListos() {
    
          $feMenu = '2024-12-31';
          $horarioComida = 'Cena';
          $cantPlatos = 60;
          $nomEvent = 'Año Nuevo';
          $descripEvent ='Cena de fin de año';
          $descripcion = 'Cena ingredientes especiales';

          $resultado = $this->object->registrarEvento($feMenu, $horarioComida, $cantPlatos, $nomEvent, $descripEvent,
          $descripcion, false);

          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('registrado', $resultado['resultado']);

          $eventId = $resultado['eventId'];
          $this->assertNotNull($eventId, 'eventId no fue generado correctamente');

          $menuId = $resultado['menuId'];
          $this->assertNotNull($menuId, 'menuId no fue generado correctamente');

          $salidaId = $resultado['salidaId'];
          $this->assertNotNull($salidaId, 'salidaId no fue generado correctamente');

  
          $alimentos = [
            ['alimento' => 3, 'cantidad' => 30],
            ['alimento' => 1, 'cantidad' => 30],
            ['alimento' => 4, 'cantidad' => 30]
          ];

        foreach ($alimentos as $item) {
          $detalleResultado = $this->object->detalleSalidaM($item['alimento'], $item['cantidad'], 
       $menuId, $salidaId, false);

      ||  $this->assertArrayHasKey('resultado', $detalleResultado);
      ||  $this->assertEquals('exitoso', $detalleResultado['resultado']);
  }

}

       

      
          
       
}*/
?>