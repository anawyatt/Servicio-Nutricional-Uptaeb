<?php 
use PHPUnit\Framework\TestCase;
use modelo\eventoModelo as evento;

class eventoTest extends TestCase {

    protected function setUp(): void {
          if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

        $this->object = new evento();
        $_SESSION['cedula'] = '12345678';
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

     //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  EVENTO ---------------
      public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->object->verificarExistenciaTipoA('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
      }

      public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaTipoA('Toma45');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
      }

      public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(600);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
      }

      public function test_verificarExistenciaTipoA_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(12);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
      }

        //------------------ VERIFICAR EXISTENCIA ALIMENTO - EVENTO ---------------------

      public function test_verificarExistenciaAlimento_DatosVacios() {
        $resultado = $this->object->verificarExistenciaAlimento('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
      } 

      public function test_verificarExistenciaAlimento_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaAlimento('Rem9394ch');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
      }
        
      public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(300);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
      } 
        
      public function test_verificarExistenciaAlimento_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(15);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
      } 

          //------------------ MOSTRAR ALIMENTO - EVENTO ----------------------------------

      public function test_mostrarAlimento_DatosVacios() {
          $resultado = $this->object->mostrarAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']); 
      }

      public function test_mostrarAlimento_DatosErroneos() {
          $resultado = $this->object->mostrarAlimento('Mo4a');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
      }

      public function test_mostrarAlimento_DatosNoExiste() {
          $resultado = $this->object->mostrarAlimento('52',);
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
      }

      public function test_mostrarAlimento_DatosExiste() {
          $resultado = $this->object->mostrarAlimento('1',); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
      } 

               //------------------- INFORMACION DEL ALIMENTO - EVENTO -------------------------
      public function test_infoAlimento_DatosVacios() {
          $resultado = $this->object->infoAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
      }

      public function test_infoAlimento_DatosErroneos() {
          $resultado = $this->object->infoAlimento('07po0;');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
      }

      public function test_infoAlimento_DatosNoExiste() {
           $resultado = $this->object->infoAlimento('880',);
           $this->assertIsArray($resultado);
           $this->assertCount(0, $resultado); 
      }

      public function test_infoAlimento_DatosExiste() {
          $resultado = $this->object->infoAlimento('1',); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
      }

           //------------------- VALIDAR FECHA Y HORARIO -  EVENTO ---------------
        public function test_validarFH_DatosVacios() {
          $resultado = $this->object->validarFH('','');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
        }

        public function test_validarFH_DatosErroneos() {
          $resultado = $this->object->validarFH('20 de septiembre', 'Dejs74n',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
        }

        public function test_validarFH_DatosNoExistenBD() {
          $resultado = $this->object->validarFH('2024-12-12','Cena');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('No tiene un evento registrado para esa fecha y horario', $resultado['resultado']);
        }

        public function test_validarFH_DatosExistenBD() {
            $resultado = $this->object->validarFH('2025-10-01', 'Cena');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error', $resultado['resultado']);    
            $this->assertArrayHasKey('mensaje', $resultado);
            $this->assertEquals('Ya tiene un evento registrado para esa fecha y horario', $resultado['mensaje']);
        }

            //-------------------VERIFICAR DATOS PARA REGISTRA EVENTOS -----------------
        public function test_registrarEvento_DatosVacios() {
            $resultado = $this->object->registrarEvento('', '', '', '', '','');
      
            $this->assertArrayHasKey('resultado', $resultado);
          
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
        }

        public function test_registrarEvento_DatosErroneos() {
            $resultado = $this->object->registrarEvento('25 de noviembre del 2025','De354yo','4u5','1a', '12','p1');
    
            $this->assertArrayHasKey('resultado', $resultado);
        
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del evento', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
        }

              //-------------------VERIFICAR DATOS PARA REGISTRA DETALLE SALIDA EVENTO -----------------
        public function test_detalleSalidaM_DatosVacios() {
            $resultado = $this->object->detalleSalidaM('', '', '', '');

            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
        } 

        public function test_detalleSalidaM_DatosErroneos() {
            $resultado = $this->object->detalleSalidaM('YY76', 'PO9', '6D','0P9J');

            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
        }  


   // --------------------- REGISTRO DE UN EVENTO-----------------------------
          public function test_registrarEventoYDetalleSalidaMenu_DatosListos() {
    
          $feMenu = '2025-12-31';
          $horarioComida = 'Cena';
          $cantPlatos = 60;
          $nomEvent = 'Año Nuevo';
          $descripEvent ='Cena de fin de año';
          $descripcion = 'Cena ingredientes especiales';

          $resultado = $this->object->registrarEvento($feMenu, $horarioComida, $cantPlatos, $nomEvent, $descripEvent,
          $descripcion,);

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
       $menuId, $salidaId,);

      $this->assertArrayHasKey('resultado', $detalleResultado);
      $this->assertEquals('exitoso', $detalleResultado['resultado']);
  }

}

       

      
          
       
}
?>