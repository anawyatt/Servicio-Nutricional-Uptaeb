<?php 
use PHPUnit\Framework\TestCase;
use modelo\registrarEntradaAlimentosModelo as registrarEntradaAlimentos;

class registrarEntradaAlimentosTest extends TestCase {
    private $objeto;



    protected function setUp(): void {
        $this->objeto = new registrarEntradaAlimentos();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO ---------------

 // Prueba para datos vacíos
 public function test_verificarExistenciaTipoA_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoA('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoA_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoA('70gh');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(18);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(8);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------ MOSTRAR ALIMENTO ----------------------------------

 // Prueba para datos vacíos
 public function test_mostrarAlimento_DatosVacios() {
    $resultado = $this->objeto->mostrarAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_mostrarAlimento_DatosErroneos() {
    $resultado = $this->objeto->mostrarAlimento('2@8$3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_mostrarAlimento_DatosNoExiste() {
    $resultado = $this->objeto->mostrarAlimento('18');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_mostrarAlimento_DatosExiste() {
     $resultado = $this->objeto->mostrarAlimento('3'); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

//------------------ VERIFICAR EXISTENCIA ALIMENTO ---------------------

// Prueba para datos vacíos
public function test_verificarExistenciaAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el  alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaAlimento('28;3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el  alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(180);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}

// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaAlimento_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(78);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------- INFORMACION DEL ALIMENTO -------------------------

 // Prueba para datos vacíos
 public function test_infoAlimento_DatosVacios() {
    $resultado = $this->objeto->infoAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_infoAlimento_DatosErroneos() {
    $resultado = $this->objeto->infoAlimento('g#67');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_infoAlimento_DatosNoExiste() {
    $resultado = $this->objeto->infoAlimento('186');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_infoAlimento_DatosExiste() {
     $resultado = $this->objeto->infoAlimento('57'); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

//-------------------VERIFICAR DATOS PARA LA ENTRADA DE ALIMENTOS -----------------

// Prueba para datos vacíos
public function test_registrarEntradaA_DatosVacios() {
    $resultado = $this->objeto->registrarEntradaA('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarEntradaA_DatosErroneos() {
    $resultado = $this->objeto->registrarEntradaA('2 de octubre', '12:00pm', '4df');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}


//------------------- VERIFICAR DATOS PARA  DETALLE DE ALIMENTOS ----------------

// Prueba para datos vacíos
public function test_registrarDetalleEntradaA_DatosVacios() {
    $resultado = $this->objeto->registrarDetalleEntradaA('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarDetalleEntradaA_DatosErroneos() {
    $resultado = $this->objeto->registrarDetalleEntradaA('Manzana', '1000 Kls', '4df');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}

// --------------------- REGISTRO DELA ENTRADA DE ALIMENTOS------------------------------

public function test_registrarEntradaA_DatosListos(){
    $fecha ='2025-08-30';
    $hora = '12:23';
    $descripcion = 'compra de alimentos';

    $resultado = $this->objeto->registrarEntradaA($fecha, $hora, $descripcion);

    $this->assertArrayHasKey('respuesta', $resultado);
    $this->assertEquals('registrado', $resultado['respuesta']);

    $id = $resultado['id'];
    $this->assertNotNull($id, 'ID no fue generado correctamente');

     // Datos de alimentos y cantidades
     $alimentos = [
        ['alimento' => 5, 'cantidad' => 5],
        ['alimento' => 7, 'cantidad' => 6],
        ['alimento' => 9, 'cantidad' => 9]
    ];

    foreach ($alimentos as $item) {
        $detalleResultado = $this->objeto->registrarDetalleEntradaA($item['alimento'], $item['cantidad'], $id);
        $this->assertArrayHasKey('resultado', $detalleResultado);
        $this->assertEquals('exitoso', $detalleResultado['resultado']);
    }

}



}
?>