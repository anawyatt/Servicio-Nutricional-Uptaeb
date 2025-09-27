<?php
use PHPUnit\Framework\TestCase;
use modelo\loginModelo as Login;
use helpers\ConteoLoginHelpers;
use helpers\JwtHelpers;

class loginTest extends TestCase {
    private $object;
    private $conex2;

    protected function setUp(): void
{
    if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

    $this->object = new Login();
    $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUPTAEB', 'root', '');
    $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}


    protected function tearDown(): void {
        unset($this->object);
    }

    

    //-------------------- LOGIN SISTEMA ---------------------//

    public function test_loginSistema_CamposVacios() {
        $resultado = $this->object->loginSistema('', '');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertEquals('Cédula y contraseña son obligatorios.', $resultado['mensaje']);
    }

    public function test_loginSistema_UsuarioNoExiste() {
        $resultado = $this->object->loginSistema('23345242', 'password123');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertStringContainsString('Usuario o contraseña incorrectos', $resultado['mensaje']);
        $this->assertStringContainsString('Intento registrado', $resultado['mensaje']);
    }


    public function test_loginSistema_ContraseñaIncorrecta() {
        $resultado = $this->object->loginSistema('12345678', 'clave_incorrecta');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertStringContainsString('Usuario o contraseña incorrectos', $resultado['mensaje']);
        $this->assertStringContainsString('Intento registrado', $resultado['mensaje']);
   
    }

    public function test_loginSistema_BloqueoUsuario() {
        ConteoLoginHelpers::registrarIntento('12345678');
        ConteoLoginHelpers::registrarIntento('12345678');
        ConteoLoginHelpers::registrarIntento('12345678');

        $resultado = $this->object->loginSistema('12345678', 'clave_incorrecta');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertStringContainsString('bloqueado', strtolower($resultado['mensaje']));
    }

   public function test_loginSistema_Exito() {
        $cedula = '12345678';
        $claveCorrecta = 'Uptaeb123*'; 

        $resultado = $this->object->loginSistema($cedula, $claveCorrecta);

        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('success', $resultado['resultado']);
        $this->assertArrayHasKey('token', $resultado);
        $this->assertArrayHasKey('url', $resultado);

        $payload = JwtHelpers::validarToken($resultado['token']);
        $this->assertEquals($cedula, $payload->cedula);
    }

}
