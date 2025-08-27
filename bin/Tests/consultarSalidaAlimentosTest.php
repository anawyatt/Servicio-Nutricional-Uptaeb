<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarSalidaAlimentosModelo as consultarSalidaAlimentos;

class consultarSalidaAlimentosTest extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new consultarSalidaAlimentos();
        $_SESSION['cedula'] = '12345678';
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

// ------------------- MOSTRAR SALIDA ALIMENTOS ------------------------

// Prueba para datos erroneos (ingresar fecha de inicio mayor a la fecha fin)
public function test_mostrarSalidaAlimentos_DatosError() {
    $resultado = $this->objeto->mostrarSalidaAlimentos('2025-08-29', '2025-08-12');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('La fecha de inicio no puede ser mayor que la fecha de fin.', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón de formato)
public function test_mostrarSalidaAlimentos_DatosErrorFormato() {
    $resultado = $this->objeto->mostrarSalidaAlimentos('12 de octubre', '28 de octubre');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
    $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.', $resultado['resultado']);
}

// Prueba para no mostrar registros mediante filtros
public function test_mostrarSalidaAlimentos_DatosNoExiste() {
    $resultado = $this->objeto->mostrarSalidaAlimentos('2025-06-12', '2025-07-23');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
}
 
 // Prueba para mostrar registros por filtro
 public function test_mostrarSalidaAlimentos_DatosExiste() {
     $resultado = $this->objeto->mostrarSalidaAlimentos('2025-08-20','2025-08-27'); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }


//-------------------- VERIFICAR EXISTENCIA DEL REGISTRO -----------------
// Prueba para datos vacíos
public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la Salida de alimentos', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('kjk8');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar la Salida de alimentos', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(90);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(5);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);

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
    $resultado = $this->objeto->tipoalimento('HG');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar los tipos de alimentos del registro', $resultado['resultado']);
}

// Prueba de que no se obtenga los tipos de alimentos  del registro de una Salida de alimentos anulada
public function test_tipoalimento_DatosNoExiste() {
    $resultado = $this->objeto->tipoalimento(70);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los tipos de alimentos  del registro de una Salida de tipoalimentos
 public function test_tipoalimento_DatosExiste() {
     $resultado = $this->objeto->tipoalimento(10); 
     $this->assertIsArray($resultado);
     $this->assertNotEmpty($resultado);
 }
//-------------------- ALIMENTOS DEL REGISTRO ---------------------------

// Prueba para datos vacíos
public function test_alimento_DatosVacios() {
    $resultado = $this->objeto->alimento('', '');
    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la salida', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_alimento_DatosErroneos() {
    $resultado = $this->objeto->alimento('rt', '7k');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el  id del tipo', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id de la salida', $resultado['resultado']);
}

// Prueba de que no se obtenga los  alimentos  del registro de una Salida de alimentos 
public function test_alimento_DatosNoExiste() {
    $resultado = $this->objeto->alimento(70,54);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
 }
 
// Prueba si se obtiene los alimentos  del registro de una Salida de alimentos
 public function test_alimento_DatosExiste() {
     $resultado = $this->objeto->alimento(5,11); 
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
    $resultado = $this->objeto->verificarAnulacion('ye');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarAnulacion_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(14);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarAnulacion_DatosExistenBD() {
    $resultado = $this->objeto->verificarAnulacion(9);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);

}

// ------------------- ANULAR REGISTRO------------------------------------
// Prueba para datos vacíos
public function test_anularSalidaAlimento_DatosVacios() {
    $resultado = $this->objeto->anularSalidaAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_anularSalidaAlimento_DatosErroneos() {
    $resultado = $this->objeto->anularSalidaAlimento('7fd');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el id del registro a anular', $resultado['resultado']);
}

public function test_anularSalidaAlimentoListo(){
    $id = 12;
 
    $resultado = $this->objeto->anularSalidaAlimento($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}
?>