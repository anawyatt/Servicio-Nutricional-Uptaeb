<?php 
use PHPUnit\Framework\TestCase;
use modelo\perfilModelo as perfil;

class perfilTest extends TestCase {
    private $object;
    private $conex2;

    protected function setUp(): void {
         if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

        $this->object = new perfil();
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUPTAEB', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

    //-------------------- INFORMACION USUARIO ---------------------//
    public function test_informacionUsuario_valida() {
        $resultado = $this->object->informacionUsuario('12345678');
        $this->assertIsObject($resultado);
        $this->assertTrue(property_exists($resultado, 'nombre'));
        $this->assertTrue(property_exists($resultado, 'apellido'));
        $this->assertTrue(property_exists($resultado, 'correo'));
    }

    public function test_informacionUsuario_invalida() {
        $resultado = $this->object->informacionUsuario('abc');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
    }

    //-------------------- VALIDAR CORREO ---------------------//
    public function test_validarCorreo_DatosVacios() {
        $resultado = $this->object->validarCorreo(' ');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Correo', $resultado['resultado']);
    }

    public function test_validarCorreo_DatosErroneos() {
        $resultado = $this->object->validarCorreo('correoInvalido12');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Correo', $resultado['resultado']);
    }

    public function test_validarCorreo_DatosDuplicadosBD() {
        $resultado = $this->object->validarCorreo('Servicionutricional2024@gmail.com');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ok', $resultado['resultado']);
    }

    public function test_validarCorreo_DatosNoExistenBD() {
        $resultado = $this->object->validarCorreo('amia12@gmail.com');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ok', $resultado['resultado']);
    }

    //-------------------- EDITAR PERFIL ---------------------//
    public function test_editarPerfil_Correcto() {
        $resultado = $this->object->editarPerfil('Servicio', 'Nutricional', 'Servicionutricional2024@gmail.com');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('success', $resultado['resultado']);
    }

    public function test_editarPerfil_CorreoRepetido() {
        $resultado = $this->object->editarPerfil('Pedro', 'Lopez', 'Servicionutricional2024@gmail.com');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('success', $resultado['resultado']);
    }

    //-------------------- CAMBIO DE CONTRASEÑA ---------------------//
    public function test_cambiarContraseña_exitosa() {
        $resultado = $this->object->cambiarContraseña('Uptaeb123*', 'NuevaClave12*', 'NuevaClave12*');
        $this->assertStringContainsString('clave Editada correctamente.', $resultado['resultado']);
    }

    public function test_cambiarContraseña_errorCoincidencia() {
        $resultado = $this->object->cambiarContraseña('Uptaeb123*', 'NuevaClave1!', 'OtraClave1!');
        $this->assertEquals('La contraseña no cumple con los requisitos mínimos de seguridad', $resultado['mensaje']);
    }

    public function test_cambiarContraseña_errorSeguridad() {
        $resultado = $this->object->cambiarContraseña('clave', 'clave', 'clave');
        $this->assertStringContainsString('La contraseña no cumple', $resultado['mensaje']);
    }

    //-------------------- ELIMINAR IMAGEN ---------------------//
    public function test_eliminarImagen() {
        $resultado = $this->object->eliminarImagen();
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('success', $resultado['resultado']);
        $this->assertEquals('assets/images/perfil/user.png', $resultado['img']);
    }

    //-------------------- EDITAR IMAGEN ---------------------//
    public function test_editarImagen_ErrorArchivo() {
        $resultado = $this->object->editarImagen('/ruta/falsa/archivo.png');
        $this->assertEquals('error', $resultado['resultado']);
    }

}
?>