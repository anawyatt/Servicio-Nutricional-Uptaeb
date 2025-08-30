<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarEntradaAlimentosModelo as consultarEntradaAlimentos;

class consultarEntradaAlimentosTest extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new consultarEntradaAlimentos();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

// ------------------- MOSTRAR ENTRADA ALIMENTOS ------------------------

// Prueba para datos erroneos (ingresar fecha de inicio mayor a la fecha fin)
public function test_mostrarEntradaAlimentos_DatosError() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2025-08-31', '2025-07-01');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('La fecha de inicio no puede ser mayor que la fecha de fin.', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón de formato)
public function test_mostrarEntradaAlimentos_DatosErrorFormato() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2 de octubre', '24 de octubre');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
    $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
}

// Prueba para no mostrar registros mediante filtros
public function test_mostrarEntradaAlimentos_DatosNoExiste() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2024-06-12', '2024-07-23');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para mostrar registros por filtro
 public function test_mostrarEntradaAlimentos_DatosExiste() {
     $resultado = $this->objeto->mostrarEntradaAlimentos('2025-08-01','2025-08-02'); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }


//-------------------- VERIFICAR EXISTENCIA DEL REGISTRO -----------------
// Prueba para datos vacíos
public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la entrada de alimentos', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('#$97f');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la entrada de alimentos', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(176);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(97);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

// ------------------- TIPO DE ALIMENTOS DELREGISTRO -------------------
// Prueba para datos vacíos
public function test_tipoalimento_DatosVacios() {
    $resultado = $this->objeto->tipoalimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar los tipos de alimentos del registro', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_tipoalimento_DatosErroneos() {
    $resultado = $this->objeto->tipoalimento('H@G9');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar los tipos de alimentos del registro', $resultado['resultado']);
}

// Prueba de que no se obtenga los tipos de alimentos  del registro de una entrada de alimentos anulada
public function test_tipoalimento_DatosNoExiste() {
    $resultado = $this->objeto->tipoalimento(186);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los tipos de alimentos  del registro de una entrada de tipoalimentos
 public function test_tipoalimento_DatosExiste() {
     $resultado = $this->objeto->tipoalimento(126); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }
//-------------------- ALIMENTOS DEL REGISTRO ---------------------------

// Prueba para datos vacíos
public function test_alimento_DatosVacios() {
    $resultado = $this->objeto->alimento('', '');
    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la entrada', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_alimento_DatosErroneos() {
    $resultado = $this->objeto->alimento('r@t9', '7k!6');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la entrada', $resultado['resultado']);
}

// Prueba de que no se obtenga los  alimentos  del registro de una entrada de alimentos 
public function test_alimento_DatosNoExiste() {
    $resultado = $this->objeto->alimento(7,35);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los alimentos  del registro de una entrada de alimentos
 public function test_alimento_DatosExiste() {
     $resultado = $this->objeto->alimento(8,150); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

// ------------------- VERIFICAR ANULACION-------------------------------

// Prueba para datos vacíos
public function test_verificarAnulacion_DatosVacios() {
    $resultado = $this->objeto->verificarAnulacion('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarAnulacion_DatosErroneos() {
    $resultado = $this->objeto->verificarAnulacion('1ye&');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarAnulacion_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(58);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarAnulacion_DatosExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(38);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);

}

// ------------------- ANULAR REGISTRO------------------------------------
// Prueba para datos vacíos
public function test_anularEntradaAlimento_DatosVacios() {
    $resultado = $this->objeto->anularEntradaAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_anularEntradaAlimento_DatosErroneos() {
    $resultado = $this->objeto->anularEntradaAlimento('2@2/w');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
}

 public function test_anularEntradaAlimento_DatosNoExistenBD() {
    $resultado = $this->objeto->anularEntradaAlimento(170);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}

 public function test_anularEntradaAlimento_DatosNosePuede() {
    $resultado = $this->objeto->anularEntradaAlimento(140);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}

public function test_anularEntradaAlimentoListo(){
    $id = 50;
 
    $resultado = $this->objeto->anularEntradaAlimento($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}



}
?>