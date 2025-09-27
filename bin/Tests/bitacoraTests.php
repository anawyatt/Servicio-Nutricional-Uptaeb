<?php
use PHPUnit\Framework\TestCase;
use modelo\bitacoraModelo as bitacora;
use helpers\encryption;

class bitacoraTests extends TestCase
{
    private $objeto;
      private $encryption;


    protected function setUp(): void
    {
        $this->objeto = new bitacora();
        $this->encryption = new encryption();
        // Inyectar payload usando Reflection (usuario autenticado)
        $reflection = new ReflectionClass($this->objeto);
        $propPayload = $reflection->getProperty('payload');
        $propPayload->setAccessible(true);
        $propPayload->setValue($this->objeto, (object)['cedula' => '12345678']);
    }

    protected function tearDown(): void
    {
        unset($this->objeto);
    }

    
/*

    ///Escenario 5: Datos vacíos/
    public function testRegistrarBitacora_DatosVacios()
    {
        $resultado = $this->objeto->registrarBitacora("", "", "");
        $this->assertEquals(["resultado" => "Datos inválidos"], $resultado);
    }
   
           ///Escenario 2: Modulo inválido (caracteres no permitidos)/
    public function testRegistrarBitacora_ModuloInvalido()
    {
        $resultado = $this->objeto->registrarBitacora("Asist@nce!", "Registro de estudiante", "12345");
        $this->assertEquals(["resultado" => "Datos inválidos"], $resultado);
    }

    ///Escenario 3: Acciones inválido (caracteres no permitidos)/
    public function testRegistrarBitacora_AccionesInvalidas()
    {
        $resultado = $this->objeto->registrarBitacora("Asistencia", "Registro #1", "12345");
        $this->assertEquals(["resultado" => "Datos inválidos"], $resultado);
    }

    //Escenario 4: Usuario inválido (no numérico)//
    public function testRegistrarBitacora_UsuarioInvalido()
    {
        $resultado = $this->objeto->registrarBitacora("Asistencia", "Registro de estudiante", "ABC123");
        $this->assertEquals(["resultado" => "Datos inválidos"], $resultado);
    }

    
 // Escenario 1: Registrar bitácora con datos válidos
        public function testRegistrarBitacora_DatosValidos()
    {
        $resultado = $this->objeto->registrarBitacora("Asistencia", "Registro de estudiante", "12345");
        $this->assertNull($resultado, "El registro debería retornar null cuando es exitoso.");
    }
*/

    /////////////////mostrar bitacora//////////////
/*
    //Escenario 1: Fechas válidas//
    public function testMostrarBitacora_FechasValidas()
    {
        $resultado = $this->objeto->mostrarBitacora('2025-09-01', '2025-09-15');

        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('recordsTotal', $resultado);
        $this->assertArrayHasKey('recordsFiltered', $resultado);
        $this->assertArrayHasKey('data', $resultado);
    }

    //Escenario 2: Fechas vacías //
    public function testMostrarBitacora_FechasVacias()
    {
        $resultado = $this->objeto->mostrarBitacora('', '');

        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('recordsTotal', $resultado);
        $this->assertArrayHasKey('recordsFiltered', $resultado);
        $this->assertArrayHasKey('data', $resultado);
    }

    ///Escenario 3: Fechas inválidas //
    public function testMostrarBitacora_FechasInvalidas()
    {
        $resultado = $this->objeto->mostrarBitacora('2025-13-01', '2025-02-30');

        $this->assertIsArray($resultado);
        $this->assertEquals(0, $resultado['recordsTotal']);
        $this->assertEquals(0, $resultado['recordsFiltered']);
        $this->assertEquals([], $resultado['data']);
        $this->assertEquals('¡Fecha inválida!', $resultado['resultado']);
    }

    ///Escenario 4: Usuario no autenticado/
    public function testMostrarBitacora_UsuarioNoAutenticado()
    {
        // Crear nuevo objeto sin payload
        $obj = new bitacora();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Usuario no autenticado o token inválido");

        // Llamada directa al método privado mostrarBitacora1 usando Reflection
        $reflection = new ReflectionClass($obj);
        $method = $reflection->getMethod('mostrarBitacora1');
        $method->setAccessible(true);

        $method->invoke($obj); // Esto lanzará la excepción
    }
    */

    /////////////////ver acciones de bitacora//////////////

    public function testVerAccionesDeBitacora_DatosCorrectos()
{
    $id = "12345678"; // cédula real de prueba
    $idBitacora = 5;  // id real de bitácora de prueba

    $idEncriptado = $this->encryption->encryptData($id);
    $idBitacoraEncriptado = $this->encryption->encryptData($idBitacora);

    $resultado = $this->objeto->verAccionesDeBitacora($idEncriptado, $idBitacoraEncriptado);

    $this->assertIsArray($resultado, "Debe retornar un array");

    if (!empty($resultado)) {
        $this->assertTrue(is_object($resultado[0]), "El primer elemento debe ser un objeto");

        // Verificamos las propiedades reales que devuelve el SP
        $this->assertTrue(property_exists($resultado[0], 'acciones'), "Debe existir la propiedad 'acciones'");
        $this->assertTrue(property_exists($resultado[0], 'modulo'), "Debe existir la propiedad 'modulo'");
        $this->assertTrue(property_exists($resultado[0], 'fecha'), "Debe existir la propiedad 'fecha'");
        $this->assertTrue(property_exists($resultado[0], 'hora'), "Debe existir la propiedad 'hora'");
    } else {
        $this->markTestIncomplete("No hay datos en la base de datos para estos IDs de prueba");
    }
}


/*

     /// Escenario 2: IDs vacíos ///
    public function testVerAccionesDeBitacora_IdsVacios()
    {
        $idEncriptado = '';
        $idBitacoraEncriptado = '';

        $resultado = $this->objeto->verAccionesDeBitacora($idEncriptado, $idBitacoraEncriptado);

        $this->assertIsArray($resultado);
        $this->assertEquals(['resultado' => 'Error al obtener acciones de bitácora.'], $resultado);
    }

    ////Escenario 3: IDs inválidos (no desencriptables)////
    public function testVerAccionesDeBitacora_IdsInvalidos()
    {
        $idEncriptado = 'abc123';
        $idBitacoraEncriptado = 'xyz456';

        $resultado = $this->objeto->verAccionesDeBitacora($idEncriptado, $idBitacoraEncriptado);

        $this->assertIsArray($resultado);
        $this->assertEquals(['resultado' => 'Error al obtener acciones de bitácora.'], $resultado);
    }
*/


}
