<?php 
use PHPUnit\Framework\TestCase;
use modelo\entradaUtensiliosModelo as entradaUtensilios;

class entradaUtensiliosTest extends TestCase {
    private $objeto;



    protected function setUp(): void {
        $this->objeto = new entradaUtensilios();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//Verificar Existencia Tipo de Utensilio

public function test_verificarExistenciaTipoU_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoU('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoU('70gh');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(99999); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no está', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(12);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}

//Mostrar Utensilios

public function test_mostrarUtensilio_DatosVacios() {
    $resultado = $this->objeto->mostrarUtensilio('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron utensilios.', $resultado['resultado']);
}

public function test_mostrarUtensilio_DatosErroneos() {
    $resultado = $this->objeto->mostrarUtensilio('2@8$3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron utensilios.', $resultado['resultado']);
}

public function test_mostrarUtensilio_DatosNoExiste() {
    $resultado = $this->objeto->mostrarUtensilio(99999); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontraron utensilios.', $resultado['resultado']);
}

public function test_mostrarUtensilio_DatosExiste() {
    $resultado = $this->objeto->mostrarUtensilio(56);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Verificar Existencia Utensilio

public function test_verificarExistenciaUtensilio_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaUtensilio('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaUtensilio('28;3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaUtensilio(99999); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no está', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaUtensilio(94); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}


//Info Utensilio

public function test_infoUtensilio_DatosVacios() {
    $resultado = $this->objeto->infoUtensilio('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_infoUtensilio_DatosErroneos() {
    $resultado = $this->objeto->infoUtensilio('g#67');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_infoUtensilio_DatosNoExiste() {
    $resultado = $this->objeto->infoUtensilio(99999); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('No se encontró el utensilio.', $resultado['resultado']);
}

public function test_infoUtensilio_DatosExiste() {
    $resultado = $this->objeto->infoUtensilio(57);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
     $this->assertTrue(property_exists($resultado[0], 'idUtensilios'));
    $this->assertTrue(property_exists($resultado[0], 'nombre'));
}

//Registrar Entrada de Utensilios

public function test_registrarEntradaU_DatosVacios() {
    $resultado = $this->objeto->registrarEntradaU('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}

public function test_registrarEntradaU_DatosErroneos() {
    $resultado = $this->objeto->registrarEntradaU('2 de octubre', '12:00pm', '4df');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar la fecha en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la hora en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una descripción válida con al menos 5 caracteres', $resultado['resultado']);
}

public function test_registrarEntradaU_DatosCorrectos() {
    $fecha = date('Y-m-d');
    $hora = date('H:i');
    $descripcion = 'Entrada de prueba válida';

    $resultado = $this->objeto->registrarEntradaU($fecha, $hora, $descripcion);

    $this->assertArrayHasKey('id', $resultado);
    $this->assertIsNumeric($resultado['id']);
}

//registrar Detalle Entrada de Utensilios

public function test_registrarDetalleEntradaU_DatosVacios() {
    $resultado = $this->objeto->registrarDetalleEntradaU('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el utensilio para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}


public function test_registrarDetalleEntradaU_DatosErroneos() {
    $resultado = $this->objeto->registrarDetalleEntradaU('abc', '0', 'x5');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el utensilio para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el  id del registro', $resultado['resultado']);
}

public function test_registrarDetalleEntradaU_DatosCorrectos() {
    $utensilio = 25;
    $cantidad = 5;
    $id = 12;

    $resultado = $this->objeto->registrarDetalleEntradaU($utensilio, $cantidad, $id);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('exitoso', $resultado['resultado']);
}

//registrar Entrada Utensilios con Detalles

public function test_registrarEntradaU_DatosListos(){ 
    $fecha ='2025-09-15';
    $hora = '09:10';
    $descripcion = 'Compra de Utensilios en el Centro';

    $resultado = $this->objeto->registrarEntradaU($fecha, $hora, $descripcion);

    $this->assertArrayHasKey('id', $resultado);
    $this->assertNotNull($resultado['id'], 'ID no fue generado correctamente');

    $id = $resultado['id'];

    $utensilios = [
        ['utensilio' => 58, 'cantidad' => 10],
        ['utensilio' => 22, 'cantidad' => 20],
        ['utensilio' => 99, 'cantidad' => 52]
    ];

    foreach ($utensilios as $item) {
        $detalleResultado = $this->objeto->registrarDetalleEntradaU($item['utensilio'], $item['cantidad'], $id);
        $this->assertArrayHasKey('resultado', $detalleResultado);
        $this->assertEquals('exitoso', $detalleResultado['resultado']);
    }
}



}
?>