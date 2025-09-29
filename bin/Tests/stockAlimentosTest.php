<?php 
use PHPUnit\Framework\TestCase;
use modelo\stockAlimentosModelo as stockAlimentos;

class stockAlimentosTest extends TestCase {

    private $objeto;
 
    protected function setUp(): void {
        $this->objeto = new stockAlimentos();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//-------------------- VERIFICAR EXISTENCIA DEL TIPO ALIMENTO ---------------
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
    $resultado = $this->objeto->verificarExistenciaTipoA(30);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(5);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}


//-------------------- MOSTRAR ALIMENTOS TABLA ---------------------//

// Prueba para datos vacíos (no cumplen con el patrón)

    public function test_mostrarAlimentos_DatosVacios() {
        $resultado = $this->objeto->mostrarAlimentos('2f;#3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_mostrarAlimentos_DatosErroneos() {
        $resultado = $this->objeto->mostrarAlimentos('2f;#3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }

  // Prueba para un tipo de alimento que no existe
     public function test_mostrarAlimentos_DatosNoExiste() {
       $resultado = $this->objeto->mostrarAlimentos('190');
       $this->assertIsArray($resultado);
       $this->assertCount(0, $resultado); 
    }

    // Prueba para un tipo de alimento existente
    public function test_mostrarAlimentos_DatosExiste() {
        $resultado = $this->objeto->mostrarAlimentos('9'); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
    }





}
?>