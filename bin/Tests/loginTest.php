<?php
use PHPUnit\Framework\TestCase;
use modelo\loginModelo as login;

class loginTest extends TestCase {
    protected function setUp(): void {
        $this->object = new login();
    }

    protected function tearDown(): void {
        unset($this->object);
    }

   /*     //Iniciar sesion login
    public function test_loginSistema_AutenticacionNormalExitosa() {
    $cedula = '12345678';
    $clave = 'Uptaeb123*';
    
    $_SESSION['idRol'] = 1;
    $_SESSION['nombreRol'] = 'Super Usuario';
    $_SESSION['cedula'] = $cedula;
    $_SESSION['nombre'] = 'Servicio';
    $_SESSION['apellido'] = 'Nutricional';
    $_SESSION['img'] = 'img.jpg';
    
    $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
    
    $resultado = $this->object->loginSistema($cedula, $clave, false);
    $this->assertIsArray($resultado, 'El resultado debe ser un array.');
    $this->assertEquals('success', $resultado['resultado'], 'El resultado debe ser un inicio de sesión exitoso.');
    }
    // ingresamos contraseña incorrecta 
    public function test_loginSistema_AutenticacionNormalClaveIncorrecta() {
    $cedula = '12345678';
    $clave = 'wrongpassword';

    $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
    $resultado = $this->object->loginSistema($cedula, $clave, false);
    $this->assertIsArray($resultado, 'El resultado debe ser un array.');
    $this->assertEquals('error', $resultado['resultado'], 'El resultado debe ser un error debido a 
    una contraseña incorrecta.');
    }

     public function test_loginSistema_RecuperacionExpirada() {
        $_SESSION['recoveryCode'] = ['12345678' => password_hash('12345', PASSWORD_BCRYPT)];
        $_SESSION['recoveryCodeExpiration'] = ['12345678' => time() - 10]; 

        $cedula = '12345678';
        $clave = '12345';

        $resultado = $this->object->loginSistema($cedula, $clave, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('expirado', $resultado['resultado'], 'El resultado debe indicar que el 
        código de recuperación ha expirado.');
    }

       // 5 minutos de expiración
    public function test_loginSistema_RecuperacionExitosa() {
        $_SESSION['recoveryCode'] = ['12345678' => password_hash('12345', PASSWORD_BCRYPT)];
        $_SESSION['recoveryCodeExpiration'] = ['12345678' => time() + 300]; 

        $cedula = '12345678';
        $clave = '12345';

        $resultado = $this->object->loginSistema($cedula, $clave, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('success', $resultado['resultado'], 'El resultado debe ser un inicio de 
        sesión exitoso.');
    }

    //Recuperacion 5 minutos codigo invalido
    public function test_loginSistema_RecuperacionCodigoInvalido() {
        $_SESSION['recoveryCode'] = ['12345678' => password_hash('12345', PASSWORD_BCRYPT)];
        $_SESSION['recoveryCodeExpiration'] = ['12345678' => time() + 300];

        $cedula = '12345678';
        $clave = '54321'; // Código incorrecto

        $resultado = $this->object->loginSistema($cedula, $clave, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('codigo_invalido', $resultado['resultado'], 'El resultado debe indicar un 
        código de recuperación inválido.');
    }

     public function test_recuperContraseñas_CorreoInvalido() {
        $correo = 'correoInvalido';

        $resultado = $this->object->recuperContraseñas($correo, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('Error de correo', $resultado['resultado'], 'El resultado debe indicar un
         error de correo inválido.');
        $this->assertEquals('Correo inválido.', $resultado['error'], 'El mensaje de error debe ser 
        "Correo inválido.".');
    }

     // Si hace mas de tres intentos es Bloqueado por 8 horas
    public function test_recuperContraseñas_LimiteDeIntentosSuperado() {
        $correo = 'usuario@gmail.com';
        $_SESSION['reset_attempts'] = [
            $correo => ['attempts' => 3, 'blocked_until' => time() + 60 * 60 * 8] 
        ];

        $resultado = $this->object->recuperContraseñas($correo, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('Supero el límite de intentos, espere 8 horas', $resultado['resultado'], 
        'El resultado debe indicar que el límite de intentos ha sido superado.');
    }

      //correo que no existe
    public function test_recuperContraseñas_CorreoNoRegistrado() {
        $correo = 'no_registrado@example.com';

        $resultado = $this->object->recuperContraseñas($correo, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('El correo no está registrado.', $resultado['resultado'], 'El resultado debe
        indicar que el correo no está registrado.');
    }
   
    
    */

  
    public function test_recuperContraseñas_CorreoRegistrado_EnvioExitoso() {
        $correo = 'Servicionutricional2024@gmail.com';
        $_SESSION['reset_attempts'] = [
            $correo => ['attempts' => 0, 'blocked_until' => 0]
        ];

        $resultado = $this->object->recuperContraseñas($correo, false);
        $this->assertIsArray($resultado, 'El resultado debe ser un array.');
        $this->assertEquals('Correo enviado', $resultado['resultado'], 'El resultado debe indicar
         que el correo de recuperación fue enviado.');
    }



}
?>
