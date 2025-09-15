<?php 
use PHPUnit\Framework\TestCase;
use modelo\menuModelo as menu;

class menuTest extends TestCase {

    protected function setUp(): void {
          if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

        $this->object = new menu();
        $_SESSION['cedula'] = '12345678';
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

  
         //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  MENU ---------------
        public function test_verificarExistenciaTipoA_DatosVacios() {
          $resultado = $this->object->verificarExistenciaTipoA('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }
        
        public function test_verificarExistenciaTipoA_DatosErroneos() {
          $resultado = $this->object->verificarExistenciaTipoA('56P3');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }
        
        public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
          $resultado = $this->object->verificarExistenciaTipoA(200);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no esta', $resultado['resultado']);
        }

        public function test_verificarExistenciaTipoA_DatosExistenBD() {
          $resultado = $this->object->verificarExistenciaTipoA(11);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('si esta', $resultado['resultado']);
        }

        //------------------ VERIFICAR EXISTENCIA ALIMENTO - MENU ---------------------

        public function test_verificarExistenciaAlimento_DatosVacios() {
          $resultado = $this->object->verificarExistenciaAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        } 

        public function test_verificarExistenciaAlimento_DatosErroneos() {
          $resultado = $this->object->verificarExistenciaAlimento('Pla342nos');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
          $resultado = $this->object->verificarExistenciaAlimento(500);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no esta', $resultado['resultado']);
        }
        
        public function test_verificarExistenciaAlimento_DatosExistenBD() {
          $resultado = $this->object->verificarExistenciaAlimento(8);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('si esta', $resultado['resultado']);
        }  

        //------------------ MOSTRAR ALIMENTO - MENU ----------------------------------

        public function test_mostrarAlimento_DatosVacios() {
          $resultado = $this->object->mostrarAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        public function test_mostrarAlimento_DatosErroneos() {
          $resultado = $this->object->mostrarAlimento('Fre93s');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        public function test_mostrarAlimento_DatosNoExiste() {
          $resultado = $this->object->mostrarAlimento('580',);
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        } 

        public function test_mostrarAlimento_DatosExiste() {
          $resultado = $this->object->mostrarAlimento('6',); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }  

        //------------------- INFORMACION DEL ALIMENTO - MENU -------------------------
        public function test_infoAlimento_DatosVacios() {
          $resultado = $this->object->infoAlimento('');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

        public function test_infoAlimento_DatosErroneos() {
          $resultado = $this->object->infoAlimento('2p0;');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

        public function test_infoAlimento_DatosNoExiste() {
          $resultado = $this->object->infoAlimento('450',);
          $this->assertIsArray($resultado);
          $this->assertCount(0, $resultado); 
        }

        public function test_infoAlimento_DatosExiste() {
          $resultado = $this->object->infoAlimento('7',); 
          $this->assertIsArray($resultado);
          $this->assertNotEmpty($resultado);
        }

           //------------------- VALIDAR FECHA Y HORARIO -  MENU ---------------
        public function test_validarFH_DatosVacios() {
          $resultado = $this->object->validarFH('','');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
        }

        public function test_validarFH_DatosErroneos() {
          $resultado = $this->object->validarFH('21hjd23kje2024', 'Almue23o');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú', $resultado['resultado']);
        }

        public function test_validarFH_DatosNoExistenBD() {
          $resultado = $this->object->validarFH('2026-11-18','Almuerzo');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('No tiene un menú registrado para esa fecha y horario', $resultado['resultado']);
        }

        public function test_validarFH_DatosExistenBD() {
          $resultado = $this->object->validarFH('2025-09-05', 'Almuerzo',);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('error', $resultado['resultado']);    
          $this->assertArrayHasKey('mensaje', $resultado);
          $this->assertEquals('Ya tiene un menú registrado para esa fecha y horario', $resultado['mensaje']);
        }

          //-------------------VERIFICAR DATOS PARA REGISTRA MENU -----------------

        public function test_registrarMenu_DatosVacios() {
          $resultado = $this->object->registrarMenu('', '', '','' );

          $this->assertArrayHasKey('resultado', $resultado);
      
          $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
        }

        public function test_registrarMenu_DatosErroneos() {
          $resultado = $this->object->registrarMenu('20 de noviembre del 2024', 'De354yo','4u5','1a');

          $this->assertArrayHasKey('resultado', $resultado);
      
          $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
          $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);    
        }

        //-------------------VERIFICAR DATOS PARA REGISTRA DETALLE SALIDA MENU -----------------

        public function test_detalleSalidaM_DatosVacios() {
          $resultado = $this->object->detalleSalidaM('', '', '', '');

          $this->assertArrayHasKey('resultado', $resultado);
      
          $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
          $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
          $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
        }   
    
        public function test_detalleSalidaM_DatosErroneos() {
          $resultado = $this->object->detalleSalidaM('jngr4', '22n', '2je','k24');

          $this->assertArrayHasKey('resultado', $resultado);
      
          $this->assertStringContainsString('Ingresar Alimento', $resultado['resultado']);
          $this->assertStringContainsString('Ingresar Cantidad de Alimentos', $resultado['resultado']);
          $this->assertStringContainsString('Obtener ID del Menú', $resultado['resultado']);
          $this->assertStringContainsString('Obtener ID de la Salida', $resultado['resultado']);
        }   


// --------------------- REGISTRO DE UN MENU-----------------------------
public function test_registrarMenuYDetalleSalidaMenu_DatosListos() {
    
    $feMenu = '2024-12-21';
    $horarioComida = 'Almuerzo';
    $cantPlatos = 40;
    $descripcion = 'Menú de almuerzo';

    $resultado = $this->object->registrarMenu($feMenu, $horarioComida, $cantPlatos, $descripcion,);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('registrado', $resultado['resultado']);

    $menuId = $resultado['menuId'];
    $this->assertNotNull($menuId, 'menuId no fue generado correctamente');

    $salidaId = $resultado['salidaId'];
    $this->assertNotNull($salidaId, 'salidaId no fue generado correctamente');

     $alimentos = [
        ['alimento' => 2, 'cantidad' => 5],
        ['alimento' => 3, 'cantidad' => 6],
        ['alimento' => 4, 'cantidad' => 9]
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