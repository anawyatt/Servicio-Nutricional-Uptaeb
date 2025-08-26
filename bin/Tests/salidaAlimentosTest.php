<?php 
use PHPUnit\Framework\TestCase;
use modelo\salidaAlimentosModelo as salidaAlimentos;

class salidaAlimentosTest extends TestCase {
    private $objeto;


    protected function setUp(): void {
        $this->objeto = new salidaAlimentos();
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
    $resultado = $this->objeto->verificarExistenciaTipoA('9&gh');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(22);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(4);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------ MOSTRAR ALIMENTO ----------------------------------

 // Prueba para datos vacíos
 public function test_mostrarAlimento_DatosVacios() {
    $resultado = $this->objeto->mostrarAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_mostrarAlimento_DatosErroneos() {
    $resultado = $this->objeto->mostrarAlimento('8$2fd');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_mostrarAlimento_DatosNoExiste() {
    $resultado = $this->objeto->mostrarAlimento(16);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_mostrarAlimento_DatosExiste() {
     $resultado = $this->objeto->mostrarAlimento(9); 
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
    $resultado = $this->objeto->verificarExistenciaAlimento('0@j8');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el  alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(165);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaAlimento_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(136);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------ VERIFICAR EXISTENCIA TIPO SALIDA ---------------------

// Prueba para datos vacíos
public function test_verificarExistenciaTipoS_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoS('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de salida', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoS_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoS('g63');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de salida', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoS_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(10);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoS_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(2);
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
    $resultado = $this->objeto->infoAlimento('095,8');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_infoAlimento_DatosNoExiste() {
    $resultado = $this->objeto->infoAlimento('171');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_infoAlimento_DatosExiste() {
     $resultado = $this->objeto->infoAlimento('83'); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

//-------------------VERIFICAR DATOS PARA LA ENTRADA DE ALIMENTOS -----------------

// Prueba para datos vacíos
public function test_registrarSalidaA_DatosVacios() {
    $resultado = $this->objeto->registrarSalidaA('', '', '','');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el tipo de salida', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarSalidaA_DatosErroneos() {
    $resultado = $this->objeto->registrarSalidaA('2 de octubre', '12:00pm','merma', '4df');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el tipo de salida', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}


//------------------- VERIFICAR DATOS PARA  DETALLE DE ALIMENTOS ----------------

// Prueba para datos vacíos
public function test_registrarDetalleSalidaA_DatosVacios() {
    $resultado = $this->objeto->registrarDetalleSalidaA('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}


// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarDetalleSalidaA_DatosErroneos() {
    $resultado = $this->objeto->registrarDetalleSalidaA('Guayaba', '200 Kls', '9i9');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}

// --------------------- REGISTRO DELA ENTRADA DE ALIMENTOS------------------------------

public function test_registrarSalidaA_DatosListos() {
    $fecha = '2025-08-25';
    $hora = '13:20';
    $tipoS = 2;
    $descripcion = 'se daño en el transporte';

    $resultado = $this->objeto->registrarSalidaA($fecha, $hora, $tipoS, $descripcion);
    $this->assertTrue(array_key_exists('respuesta', $resultado));
    $this->assertEquals('registrado', $resultado['respuesta']);

    $id = $resultado['id'];
    $this->assertNotNull($id, 'ID no fue generado correctamente');

    $alimentos = [
        ['alimento' => 5, 'cantidad' => 200],
        ['alimento' => 9, 'cantidad' => 100],
        ['alimento' => 20, 'cantidad' => 150]
    ];

    foreach ($alimentos as $item) {
        $detalleResultado = $this->objeto->registrarDetalleSalidaA($item['alimento'], $item['cantidad'], $id);
        $this->assertTrue(array_key_exists('resultado', $detalleResultado));
        $this->assertEquals('exitoso', $detalleResultado['resultado']);
    }
}



}
?>