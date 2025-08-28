<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarEntradaAlimentosModelo as consultarEntradaAlimentos;

class consultarEntradaAlimentosTest extends TestCase {

    protected function setUp(): void {
        $this->objeto = new consultarEntradaAlimentos();
        $_SESSION['cedula'] = '12345678';
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

// ------------------- MOSTRAR ENTRADA ALIMENTOS ------------------------

// Prueba para datos erroneos (ingresar fecha de inicio mayor a la fecha fin)
public function test_mostrarEntradaAlimentos_DatosError() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2024-10-31', '2024-10-15',  false);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('La fecha de inicio no puede ser mayor que la fecha de fin.', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón de formato)
public function test_mostrarEntradaAlimentos_DatosErrorFormato() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2 de octubre', '24 de octubre', false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
    $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
}

// Prueba para no mostrar registros mediante filtros
public function test_mostrarEntradaAlimentos_DatosNoExiste() {
    $resultado = $this->objeto->mostrarEntradaAlimentos('2024-06-12', '2024-07-23',false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
 // Prueba para mostrar registros por filtro
 public function test_mostrarEntradaAlimentos_DatosExiste() {
     $resultado = $this->objeto->mostrarEntradaAlimentos('2024-10-12','2024-10-31', false); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }


//-------------------- VERIFICAR EXISTENCIA DEL REGISTRO -----------------
// Prueba para datos vacíos
public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la entrada de alimentos', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('/n8',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la entrada de alimentos', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(90,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(7,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);

}

// ------------------- TIPO DE ALIMENTOS DELREGISTRO -------------------
// Prueba para datos vacíos
public function test_tipoalimento_DatosVacios() {
    $resultado = $this->objeto->tipoalimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar los tipos de alimentos del registro', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_tipoalimento_DatosErroneos() {
    $resultado = $this->objeto->tipoalimento('HG',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar los tipos de alimentos del registro', $resultado['resultado']);
}

// Prueba de que no se obtenga los tipos de alimentos  del registro de una entrada de alimentos anulada
public function test_tipoalimento_DatosNoExiste() {
    $resultado = $this->objeto->tipoalimento(70, false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los tipos de alimentos  del registro de una entrada de tipoalimentos
 public function test_tipoalimento_DatosExiste() {
     $resultado = $this->objeto->tipoalimento(8, false); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }
//-------------------- ALIMENTOS DEL REGISTRO ---------------------------

// Prueba para datos vacíos
public function test_alimento_DatosVacios() {
    $resultado = $this->objeto->alimento('', '',  false);
    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la entrada', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_alimento_DatosErroneos() {
    $resultado = $this->objeto->alimento('rt', '7k', false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la entrada', $resultado['resultado']);
}

// Prueba de que no se obtenga los  alimentos  del registro de una entrada de alimentos 
public function test_alimento_DatosNoExiste() {
    $resultado = $this->objeto->alimento(70,54, false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los alimentos  del registro de una entrada de alimentos
 public function test_alimento_DatosExiste() {
     $resultado = $this->objeto->alimento(2,1, false); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }

// ------------------- VERIFICAR ANULACION-------------------------------

// Prueba para datos vacíos
public function test_verificarAnulacion_DatosVacios() {
    $resultado = $this->objeto->verificarAnulacion('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarAnulacion_DatosErroneos() {
    $resultado = $this->objeto->verificarAnulacion('ye',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarAnulacion_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(1,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarAnulacion_DatosExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(9,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);

}

// ------------------- ANULAR REGISTRO------------------------------------
// Prueba para datos vacíos
public function test_anularEntradaAlimento_DatosVacios() {
    $resultado = $this->objeto->anularEntradaAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_anularEntradaAlimento_DatosErroneos() {
    $resultado = $this->objeto->anularEntradaAlimento('7fd',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
}

public function test_anularEntradaAlimentoListo(){
    $id = 9;
 
    $resultado = $this->objeto->anularEntradaAlimento($id, false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}



}
?>