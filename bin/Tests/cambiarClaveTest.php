<?php
use PHPUnit\Framework\TestCase;
use modelo\cambiarClaveModelo;
use helpers\JwtHelpers;

class cambiarClaveTest extends TestCase {
    private $object;

    protected function setUp(): void {
        $this->object = new cambiarClaveModelo();

        if (!isset($_ENV['SECRET_KEY_JWT'])) {
            $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
        }
    }

    //-------------------- PRUEBAS CAMBIO DE CLAVE ---------------------//

    public function test_tokenInvalido() {
        $resultado = $this->object->actualizarClaveRecuperacion('token_falso', '123456', 'NuevaClave1*', 'NuevaClave1*');
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertEquals('Token inválido', $resultado['mensaje']);
    }

    public function test_codigoIncorrecto() {
        $tokenValido = JwtHelpers::generarToken([
            'tipo' => 'recuperacion',
            'codigo' => '999999',
            'correo' => 'usuario@correo.com'
        ]);

        $resultado = $this->object->actualizarClaveRecuperacion($tokenValido, '123456', 'NuevaClave1*', 'NuevaClave1*');
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertEquals('Código incorrecto', $resultado['mensaje']);
    }

    public function test_contraseñasNoCoinciden() {
        $tokenValido = JwtHelpers::generarToken([
            'tipo' => 'recuperacion',
            'codigo' => '123456',
            'correo' => 'usuario@correo.com'
        ]);

        $resultado = $this->object->actualizarClaveRecuperacion($tokenValido, '123456', 'NuevaClave1*', 'OtraClave2*');
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertEquals('Las contraseñas no coinciden', $resultado['mensaje']);
    }

    public function test_contraseñaNoCumpleSeguridad() {
        $tokenValido = JwtHelpers::generarToken([
            'tipo' => 'recuperacion',
            'codigo' => '123456',
            'correo' => 'usuario@correo.com'
        ]);

        $resultado = $this->object->actualizarClaveRecuperacion($tokenValido, '123456', 'clave', 'clave');
        $this->assertEquals('error', $resultado['resultado']);
        $this->assertEquals('La contraseña no cumple con los requisitos mínimos de seguridad', $resultado['mensaje']);
    }

    public function test_actualizacionExitosa() {
        $tokenValido = JwtHelpers::generarToken([
            'tipo' => 'recuperacion',
            'codigo' => '123456',
            'correo' => 'Servicionutricional2024@gmail.com',
            'jti' => 'jti_test',
            'exp' => time() + 3600
        ]);

        $resultado = $this->object->actualizarClaveRecuperacion($tokenValido, '123456', 'NuevaClave1*', 'NuevaClave1*');
        $this->assertEquals('ok', $resultado['resultado']);
        $this->assertStringContainsString('Contraseña actualizada correctamente', $resultado['mensaje']);
    }
}
?>