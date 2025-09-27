<?php 
use PHPUnit\Framework\TestCase;
use modelo\usuarioModelo as usuario;

class usuarioTest extends TestCase {
    private $object;
    private $conex2;

    protected function setUp(): void {
        $this->object = new usuario();
       
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUPTAEB', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

//-------------------- VALIDAR CEDULA USUARIO ---------------------//

                 // Prueba para datos vacíos
        public function test_validarCedula_DatosVacios() {
            $resultado = $this->object->validarCedula(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Cedula', $resultado['resultado']);   
        }

                // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarCedula_DatosErroneos() {
            $resultado = $this->object->validarCedula('2fd3');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Cedula', $resultado['resultado']);
        }

              // Prueba para datos duplicados en la bd
        public function test_validarCedula_DatosDuplicadosBD() {
            $resultado = $this->object->validarCedula(29913499);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error Cedula', $resultado['resultado']);
        }
        
             // Prueba para datos no existen en la bd
        public function test_validarCedula_DatosNoExisteBD() {
            $resultado = $this->object->validarCedula(28913495);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('No Existe', $resultado['resultado']);
        }
     //-------------------- VALIDAR CORREO USUARIO ---------------------//

                 // Prueba para datos vacíos
        public function test_validarCorreo_DatosVacios() {
            $resultado = $this->object->validarCorreo(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Correo', $resultado['resultado']);   
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarCorreo_DatosErroneos() {
            $resultado = $this->object->validarCorreo('prueba2gmailcom');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Correo', $resultado['resultado']);
        }

         // Prueba para datos duplicado en la bd
        public function test_validarCorreo_DatosDuplicadosBD() {
            $resultado = $this->object->validarCorreo("Floresmarianny17@gmail.com");
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error correo', $resultado['resultado']);
        }

         // Prueba para datos no existen en la bd
        public function test_validarCorreo_DatosNoExistenBD() {
            $resultado = $this->object->validarCorreo("Amia12@gmail.com");
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('No Existe', $resultado['resultado']);
        }

               //-------------------- VALIDAR TELEFONO USUARIO ---------------------//
               // Prueba para datos vacíos
        public function test_validarTelefono_DatosVacios() {
            $resultado = $this->object->validarTelefono(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Teléfono válido sin espacios', $resultado['resultado']);   
        }
      
         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarTelefono_DatosErroneos() {
            $resultado = $this->object->validarTelefono('0412123ed.2');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Teléfono válido sin espacios', $resultado['resultado']);
        }
        
                  // Prueba para datos duplicado en la bd
        public function test_validarTelefono_DatosDuplicadosBD() {
            $resultado = $this->object->validarTelefono("04120546170");
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error telefono', $resultado['resultado']);
        }
                          // Prueba para datos no existen en la bd
        public function test_validarTelefono_DatosNoExistenBD() {
            $resultado = $this->object->validarTelefono("04121111111",);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('No Existe', $resultado['resultado']);
        }

        //-------------------- VERIFICAR EXISTENCIA ROL - USUARIO ---------------------//

              // Prueba para datos vacíos
        public function test_verificarExistenciaRol_DatosVacios() {
            $resultado = $this->object->verificarExistenciaRol(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Rol', $resultado['resultado']);   
        }

             // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaRol_DatosErroneos() {
            $resultado = $this->object->verificarExistenciaRol('e1');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Rol', $resultado['resultado']);
        }

          // Prueba para datos que existen en la base de datos
        public function test_verificarExistenciaRol_DatosExistenBD() {
            $resultado = $this->object->verificarExistenciaRol('7');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('existe rol', $resultado['resultado']);
        }      
                            // Prueba para datos no existen en la bd
        public function test_verificarExistenciaRol_DatosNoExistenBD() {
            $resultado = $this->object->verificarExistenciaRol("800",);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error rol', $resultado['resultado']);
        }
        
         //------------- REGISTRAR USUARIO -------------------------------------
         
           // Prueba para datos vacíos
        public function test_registrarUsuario_DatosVacios() {
            $resultado = $this->object->registrarUsuario('', '', '', '',
            '', '', '', '', '',);
                
            $this->assertArrayHasKey('resultado', $resultado);
                
            $this->assertStringContainsString('Ingresar Cedula', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar nombre', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar apellido', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar Correo', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Teléfono válido sin espacios', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar rol', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar clave', $resultado['resultado']);
        }

         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_registrarUsuario_DatosErroneos() {
            $resultado = $this->object->registrarUsuario('43f8', 'ju', '67', 'lina76',
            '876sd', 'lopexjsk', 'hdujsg7', '2fv', 'pol',);
                
            $this->assertArrayHasKey('resultado', $resultado);
                
            $this->assertStringContainsString('Ingresar Cedula', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar nombre', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar segundo nombre', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar apellido', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar segundo apellido', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar Correo', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Teléfono válido sin espacios', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar rol', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar clave', $resultado['resultado']);
        }

                // Registrar usuario
        public function test_registrarUsuario_DatosValidos(){
    
            $cedula = '13881507';
            $nombre = 'Yethzenia';
            $segNombre = 'Zulimar';
            $apellido = 'Alarcon';
            $segApellido = 'Leon';
            $correo = 'yeth.alar8con@gmail.com';
            $telefono = '01234567899';
            $idRol = 2;
            $clave = 'yethzenia123*';

            $resultado = $this->object->registrarUsuario($cedula, $nombre, $segNombre, $apellido, $segApellido, 
            $correo, $telefono, $idRol, $clave,);

            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('registro exitoso', $resultado['resultado']);
        
            $verify = $this->conex2->prepare("SELECT * FROM usuario WHERE cedula = ?");
            $verify->execute([$cedula]);
            $registro = $verify->fetch();

            $this->assertNotEmpty($registro);
            $this->assertEquals('Yethzenia', $registro['nombre']);
            $this->assertEquals('Zulimar', $registro['segNombre']);
            $this->assertEquals('Alarcon', $registro['apellido']);
            $this->assertEquals('Leon', $registro['segApellido']);
            $this->assertNotEmpty($registro['correo']); 
            $this->assertEquals('01234567899', $registro['telefono']);
            $this->assertEquals(2, $registro['idRol']);
            $this->assertNotEmpty($registro['clave']); 
            $this->assertEquals(1, $registro['status']); 
        }
       

}
?>