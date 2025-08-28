<?php /*
use PHPUnit\Framework\TestCase;
use modelo\salidaAlimentosModelo as salidaAlimentos;

class salidaAlimentosTest extends TestCase {

    protected function setUp(): void {
        $this->objeto = new salidaAlimentos();
        $_SESSION['cedula'] = '12345678';
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO ---------------

 // Prueba para datos vacíos
 public function test_verificarExistenciaTipoA_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoA('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoA_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoA('70gh',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(1,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(5,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------ MOSTRAR ALIMENTO ----------------------------------

 // Prueba para datos vacíos
 public function test_mostrarAlimento_DatosVacios() {
    $resultado = $this->objeto->mostrarAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_mostrarAlimento_DatosErroneos() {
    $resultado = $this->objeto->mostrarAlimento('i',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_mostrarAlimento_DatosNoExiste() {
    $resultado = $this->objeto->mostrarAlimento(70, false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_mostrarAlimento_DatosExiste() {
     $resultado = $this->objeto->mostrarAlimento(5, false); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

//------------------ VERIFICAR EXISTENCIA ALIMENTO ---------------------

// Prueba para datos vacíos
public function test_verificarExistenciaAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el  alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaAlimento('/n8',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el  alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(90,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaAlimento_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaAlimento(35,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------ VERIFICAR EXISTENCIA TIPO ALIMENTO ---------------------

// Prueba para datos vacíos
public function test_verificarExistenciaTipoS_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoS('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de salida', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoS_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoS('7HH',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el tipo de salida', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoS_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(10,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoS_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(2,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//------------------- INFORMACION DEL ALIMENTO -------------------------

 // Prueba para datos vacíos
 public function test_infoAlimento_DatosVacios() {
    $resultado = $this->objeto->infoAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_infoAlimento_DatosErroneos() {
    $resultado = $this->objeto->infoAlimento('hsd4;',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para un  alimento que no existe
public function test_infoAlimento_DatosNoExiste() {
    $resultado = $this->objeto->infoAlimento('67', false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para un  alimento existente
 public function test_infoAlimento_DatosExiste() {
     $resultado = $this->objeto->infoAlimento('20', false); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

//-------------------VERIFICAR DATOS PARA LA ENTRADA DE ALIMENTOS -----------------

// Prueba para datos vacíos
public function test_registrarSalidaA_DatosVacios() {
    $resultado = $this->objeto->registrarSalidaA('', '', '','', false);

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el tipo de salida', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarSalidaA_DatosErroneos() {
    $resultado = $this->objeto->registrarSalidaA('2 de octubre', '12:00pm','se fue', '4df',false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el tipo de salida', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}


//------------------- VERIFICAR DATOS PARA  DETALLE DE ALIMENTOS ----------------

// Prueba para datos vacíos
public function test_registrarDetalleSalidaA_DatosVacios() {
    $resultado = $this->objeto->registrarDetalleSalidaA('', '', '', false);

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarDetalleSalidaA_DatosErroneos() {
    $resultado = $this->objeto->registrarDetalleSalidaA('23 de Julio', '1:00pm', '4df',false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  alimento para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}

// --------------------- REGISTRO DELA ENTRADA DE ALIMENTOS------------------------------

public function test_registrarSalidaA_DatosListos() {
    // Datos de salida
    $fecha = '2024-11-01';
    $hora = '17:41';
    $tipoS = 3;
    $descripcion = 'donacion para abuelos';

    // Llamada al método para registrar la salida
    $resultado = $this->objeto->registrarSalidaA($fecha, $hora, $tipoS, $descripcion, false);
    $this->assertArrayHasKey('respuesta', $resultado);
    $this->assertEquals('registrado', $resultado['respuesta']);
    
    // Verificación de ID generado
    $id = $resultado['id'];
    $this->assertNotNull($id, 'ID no fue generado correctamente');

    // Datos de alimentos y cantidades
    $alimentos = [
        ['alimento' => 5, 'cantidad' => 1],
        ['alimento' => 7, 'cantidad' => 1],
        ['alimento' => 9, 'cantidad' => 1]
    ];

    // Registro y verificación de cada detalle de salida
    foreach ($alimentos as $item) {
        $detalleResultado = $this->objeto->registrarDetalleSalidaA($item['alimento'], $item['cantidad'], $id, false);
        $this->assertArrayHasKey('resultado', $detalleResultado);
        $this->assertEquals('exitoso', $detalleResultado['resultado']);
    }
}



}*/
?>