<?php 
use PHPUnit\Framework\TestCase;
use modelo\salidaUtensiliosModelo as salidaUtensilios;

class salidaUtensiliosTest extends TestCase {
    private $objeto;


    protected function setUp(): void {
        $this->objeto = new salidaUtensilios();
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//Verificar existencia tipo utensilio

public function test_verificarExistenciaTipoU_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoU('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoU('9&gh');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(22);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no está', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(10);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}

// Mostrar utensilios

 public function test_mostrarUtensilios_DatosVacios() {
    $resultado = $this->objeto->mostrarUtensilios('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
   
}

public function test_mostrarUtensilios_DatosErroneos() {
    $resultado = $this->objeto->mostrarUtensilios('8$2fd');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_mostrarUtensilios_DatosNoExiste() {
    $resultado = $this->objeto->mostrarUtensilios(500);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado);
}

public function test_mostrarUtensilios_DatosExiste() {
    $resultado = $this->objeto->mostrarUtensilios(9);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//Verificar existencia utensilio

public function test_verificarExistenciaUtensilio_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaUtensilio('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaUtensilio('0@j8');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaUtensilio(500);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no está', $resultado['resultado']);
}

public function test_verificarExistenciaUtensilio_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaUtensilio(136);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('está', $resultado['resultado']);
}
//Verificar existencia tipo salida

public function test_verificarExistenciaTipoS_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoS('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de salida válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoS_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoS('g63');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de salida válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoS_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(10);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no está', $resultado['resultado']);
}

public function test_verificarExistenciaTipoS_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoS(2);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}

//Info utensilio

public function test_infoUtensilio_DatosVacios() {
    $resultado = $this->objeto->infoUtensilio('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_infoUtensilio_DatosErroneos() {
    $resultado = $this->objeto->infoUtensilio('095,8');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un utensilio válido', $resultado['resultado']);
}

public function test_infoUtensilio_DatosNoExiste() {
    $resultado = $this->objeto->infoUtensilio('9999');
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado);
}

public function test_infoUtensilio_DatosExiste() {
    $resultado = $this->objeto->infoUtensilio('19');
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
    $this->assertTrue(property_exists($resultado[0], 'idUtensilios'));
    $this->assertTrue(property_exists($resultado[0], 'nombre'));
    $this->assertTrue(property_exists($resultado[0], 'material'));
}

//Verificar datos para salida de utensilios

public function test_registrarSalidaU_DatosVacios() {
    $resultado = $this->objeto->registrarSalidaU('', '', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Fecha inválida, debe ser en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Hora inválida, debe ser en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Seleccionar un tipo de salida válido', $resultado['resultado']);
}

public function test_registrarSalidaU_DatosErroneos() {
    $resultado = $this->objeto->registrarSalidaU('2 de octubre', '12:00pm', 'merma', '4df');

    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Fecha inválida, debe ser en formato YYYY-MM-DD', $resultado['resultado']);
    $this->assertStringContainsString('Hora inválida, debe ser en formato HH:MM', $resultado['resultado']);
    $this->assertStringContainsString('Seleccionar un tipo de salida válido', $resultado['resultado']);
}

//verificar datos para detalle de salida de utensilios

public function test_registrarDetalleSalidaU_DatosVacios() {
    $resultado = $this->objeto->registrarDetalleSalidaU('', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el utensilio para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id del registro', $resultado['resultado']);
}

public function test_registrarDetalleSalidaU_DatosErroneos() {
    $resultado = $this->objeto->registrarDetalleSalidaU('Guayaba', '200 Kls', '9i9');

    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el utensilio para el registro', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la cantidad', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar el id del registro', $resultado['resultado']);
}

//Registrar salida de utensilios y detalle de salida

public function test_registrarSalidaU_DatosListos() {
    $fecha = '2025-08-25';
    $hora = '13:20';
    $tipoS = 2;
    $descripcion = 'se daño en el transporte';


    $resultado = $this->objeto->registrarSalidaU($fecha, $hora, $tipoS, $descripcion);

    $this->assertArrayHasKey('id', $resultado, 'No se generó el ID de la salida');
    $this->assertNotNull($resultado['id'], 'ID no fue generado correctamente');

    $id = $resultado['id'];

    $utensilios = [
        ['utensilio' => 19, 'cantidad' => 2],
        ['utensilio' => 65, 'cantidad' => 2],
        ['utensilio' => 103, 'cantidad' => 2]
    ];

    foreach ($utensilios as $item) {
        $detalleResultado = $this->objeto->registrarDetalleSalidaU($item['utensilio'], $item['cantidad'], $id);
        $this->assertArrayHasKey('resultado', $detalleResultado, 'Detalle de salida no retornó resultado');
        $this->assertEquals('exitoso', $detalleResultado['resultado']);
    }
}



}
?>