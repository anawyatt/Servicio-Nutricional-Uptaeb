<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarSalidaUtensiliosModelo as consultarSalidaUtensilios;

class consultarSalidaUtensiliosTest extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new consultarSalidaUtensilios();
        $_SESSION['cedula'] = '12345678';
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

// Mostrar salida de utensilios con filtros

public function test_mostrarSalidaUtensilios_DatosErrorI() {
    $resultado = $this->objeto->mostrarSalidaUtensilios('2025-08-29', '2025-08-12');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString(
        'La fecha de inicio no puede ser mayor que la fecha de fin.',
        $resultado['resultado']
    );
}

public function test_mostrarSalidaUtensilios_DatosErrorFormato() {
    $resultado = $this->objeto->mostrarSalidaUtensilios('12 de octubre', '28 de octubre');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString(
        'La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.',
        $resultado['resultado']
    );
    $this->assertStringContainsString(
        'La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.',
        $resultado['resultado']
    );
}

public function test_mostrarSalidaUtensilios_DatosNoExiste() {
    $resultado = $this->objeto->mostrarSalidaUtensilios('2025-06-12', '2025-07-23');

    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado);
}

public function test_mostrarSalidaUtensilios_DatosExiste() {
    $resultado = $this->objeto->mostrarSalidaUtensilios('2025-08-20', '2025-08-27');

    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Verificar existencia del registro

public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('9h@1');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(150);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(10); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}
//Tipos de utensilios


public function test_tipoutensilios_DatosVacios() {
    $resultado = $this->objeto->tipoutensilios('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_tipoutensilios_DatosErroneos() {
    $resultado = $this->objeto->tipoutensilios('3*G9');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_tipoutensilios_DatosNoExiste() {
    $resultado = $this->objeto->tipoutensilios(165);
    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron tipos de utensilios.', $resultado['resultado']);
}

public function test_tipoutensilios_DatosExiste() {
    $resultado = $this->objeto->tipoutensilios(2); 
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Utensilios

public function test_utensilios_DatosVacios() {
    $resultado = $this->objeto->utensilios('', '');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('IDs inválidos.', $resultado['resultado']);
}

public function test_utensilios_DatosErroneos() {
    $resultado = $this->objeto->utensilios('92.', '7k!6');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('IDs inválidos.', $resultado['resultado']);
}

public function test_utensilios_DatosNoExiste() {
    $resultado = $this->objeto->utensilios(10, 2);
    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron utensilios.', $resultado['resultado']);
}

public function test_utensilios_DatosExiste() {
    $resultado = $this->objeto->utensilios(8, 2); 
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Verificar Anulación

public function test_verificarAnulacion_DatosVacios() {
    $resultado = $this->objeto->verificarAnulacion('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_verificarAnulacion_DatosErroneos() {
    $resultado = $this->objeto->verificarAnulacion('3/5f');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}

public function test_verificarAnulacion_DatosNoSePuede() {
    $resultado = $this->objeto->verificarAnulacion(1);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}

public function test_verificarAnulacion_DatosSePuede() {
    $resultado = $this->objeto->verificarAnulacion(55); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
}

//Anular salida de utensilios

public function test_anularSalidaUtensilios_DatosVacios() {
    $resultado = $this->objeto->anularSalidaUtensilios('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar una salida válida', $resultado['resultado']);
}

public function test_anularSalidaUtensilios_DatosErroneos() {
    $resultado = $this->objeto->anularSalidaUtensilios('78@3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar una salida válida', $resultado['resultado']);
}

public function test_anularSalidaUtensilios_DatosCorrectos() {
    $id = 55; 
    $resultado = $this->objeto->anularSalidaUtensilios($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}
?>