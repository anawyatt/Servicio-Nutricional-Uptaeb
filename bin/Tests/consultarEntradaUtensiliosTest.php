<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarEntradaUtensiliosModelo as consultarEntradaUtensilios;

class consultarEntradaUtensiliosTest extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new consultarEntradaUtensilios();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//Mostrar Entradas de Utensilios

public function test_mostrarEntradaUtensilios_DatosError() {
    $resultado = $this->objeto->mostrarEntradaUtensilios('2025-08-31', '2025-07-01');

   $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado);
}

public function test_mostrarEntradaUtensilios_DatosErrorFormato() {
    $resultado = $this->objeto->mostrarEntradaUtensilios('2 de octubre', '24 de octubre');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Fecha de inicio inválida', $resultado['resultado']);
    $this->assertStringContainsString('Fecha de fin inválida', $resultado['resultado']);
}

public function test_mostrarEntradaUtensilios_DatosNoExiste() {
    $resultado = $this->objeto->mostrarEntradaUtensilios('2024-06-12', '2024-07-23');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
}

public function test_mostrarEntradaUtensilios_DatosExiste() {
    $resultado = $this->objeto->mostrarEntradaUtensilios('2025-09-01','2025-09-31'); 
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}


//Verificar Existencia Entrada de Utensilios

public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID válido', $resultado['resultado']);
}


public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('#$97f');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID válido', $resultado['resultado']);
}


public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(176);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(97);
    $this->assertNull($resultado, 'Se esperaba null para un ID existente');
}

//Tipos de Utensilios

public function test_tipoutensilios_DatosVacios() {
    $resultado = $this->objeto->tipoutensilios('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID válido', $resultado['resultado']);
}

public function test_tipoutensilios_DatosErroneos() {
    $resultado = $this->objeto->tipoutensilios('H@G9');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID válido', $resultado['resultado']);
}

public function test_tipoutensilios_DatosNoExiste() {
    $resultado = $this->objeto->tipoutensilios(186);
    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron tipos de utensilios.', $resultado['resultado']);
}

public function test_tipoutensilios_DatosExiste() {
    $resultado = $this->objeto->tipoutensilios(12);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

// Utensilios

public function test_utensilios_DatosVacios() {
    $resultado = $this->objeto->utensilios('', '');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio y un inventario válidos', $resultado['resultado']);
}


public function test_utensilios_DatosErroneos() {
    $resultado = $this->objeto->utensilios('r@t9', '7k!6');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio y un inventario válidos', $resultado['resultado']);
}

public function test_utensilios_DatosNoExiste() {
    $resultado = $this->objeto->utensilios(7, 35);
    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron utensilios.', $resultado['resultado']);
}

public function test_utensilios_DatosExiste() {
    $resultado = $this->objeto->utensilios(8, 150);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Verificar Anulación Entrada Utensilios

public function test_verificarAnulacion_DatosVacios() {
    $resultado = $this->objeto->verificarAnulacion('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID de entrada no válido', $resultado['resultado']);
}


public function test_verificarAnulacion_DatosErroneos() {
    $resultado = $this->objeto->verificarAnulacion('1ye&');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID de entrada no válido', $resultado['resultado']);
}

public function test_verificarAnulacion_DatosNoSePuede() {
    $resultado = $this->objeto->verificarAnulacion(58);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}

public function test_verificarAnulacion_DatosSePuede() {
    $resultado = $this->objeto->verificarAnulacion(38);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
}

// Anular Entrada Utensilios

public function test_anularEntradaUtensilios_DatosVacios() {
    $resultado = $this->objeto->anularEntradaUtensilios('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID de entrada válido', $resultado['resultado']);
}


public function test_anularEntradaUtensilios_DatosErroneos() {
    $resultado = $this->objeto->anularEntradaUtensilios('2@2/w');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un ID de entrada válido', $resultado['resultado']);
}

public function test_anularEntradaUtensilios_DatosNoExistenBD() {
    $resultado = $this->objeto->anularEntradaUtensilios(170);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se pudo anular la entrada.', $resultado['resultado']);
}

public function test_anularEntradaUtensilios_Listo() {
    $id = 50;
    $resultado = $this->objeto->anularEntradaUtensilios($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}
?>