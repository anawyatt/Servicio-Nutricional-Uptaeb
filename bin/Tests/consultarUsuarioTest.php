<?php 

use PHPUnit\Framework\TestCase;
use modelo\consultarUsuarioModelo as consultarUsuario;

class consultarUsuarioTest extends TestCase {
    private $object;
    private $conex2;

    protected function setUp(): void {
        $this->object = new consultarUsuario();
       
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUPTAEB', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

    //-------------------- VERIFICAR EXISTENCIA CONSULTAR USUARIO ---------------------//
              // Prueba para datos vacíos
        public function test_verificarExistencia_DatosVacios() {
            $resultado = $this->object->verificarExistencia(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);   
        }

          // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistencia_DatosErroneos() {
            $resultado = $this->object->verificarExistencia('e1hdjk32');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
        }    

           // Prueba para datos que existen en la base de datos
        public function test_verificarExistencia_DatosExistenBD() {
            $resultado = $this->object->verificarExistencia('12345678',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Existe', $resultado['resultado']);
        }

             // Prueba para datos no existen en la bd
        public function test_verificarExistencia_DatosNoExistenBD() {
            $resultado = $this->object->verificarExistencia("22989342");
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error usuario', $resultado['resultado']);
        }
        
    //-------------------- INFORMACION DEL CONSULTAR USUARIO  ----------------------
       
        // Prueba para datos vacios (no cumplen)
        public function test_infoUsuario_DatosVacios() {
            $resultado = $this->object->infoUsuario('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_infoUsuario_DatosErroneos() {
            $resultado = $this->object->infoUsuario('2f2');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
        }

          // Prueba para un usuario existente
        public function test_infoUsuario_DatosExiste() {
            $resultado = $this->object->infoUsuario('29913499'); 
            $this->assertIsObject($resultado);
            $this->assertNotEmpty((array)$resultado); 
        }


           // Prueba para un usuario que no existe
        public function test_infoUsuario_DatosNoExiste() {
            $resultado = $this->object->infoUsuario('13881205');
            $this->assertFalse($resultado, 'no existe.');
        }


           //-------------------- VALIDAR CORREO CONSULTAR USUARIO ---------------------//
      
              // Prueba para datos vacíos
        public function test_validarCorreo_DatosVacios() {
            $resultado = $this->object->validarCorreo(' ', ' ');
            $this->assertArrayHasKey('resultado', $resultado); 
            $this->assertEquals('Ingresar Correo, Ingresar Cedula', $resultado['resultado']);
        }
            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarCorreo_DatosErroneos() {
            $resultado = $this->object->validarCorreo('hola12com ', '3462nfuje');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Correo, Ingresar Cedula', $resultado['resultado']); 
        }

        public function test_validarCorreo_DatosDuplicadosBD() {
            $resultado = $this->object->validarCorreo('Floresmarianny17@gmail.com', '30931999');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error correo', $resultado['resultado']); 
        }

            //-------------------- VALIDAR TELEFONO CONSULTAR USUARIO ---------------------//
      
              // Prueba para datos vacíos
        public function test_validarTelefono_DatosVacios() {
            $resultado = $this->object->validarTelefono(' ', ' ');
            $this->assertArrayHasKey('resultado', $resultado); 
            $this->assertEquals('Ingresar Telefono, Ingresar Cedula', $resultado['resultado']);   
        }

         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarTelefono_DatosErroneos() {
            $resultado = $this->object->validarTelefono('03er763hude ', 'njfo23');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Telefono, Ingresar Cedula', $resultado['resultado']); 
        }

                // Prueba para datos que existen en la base de datos OJO AQUI
        public function test_validarTelefono_DatosDuplicadosBD() {
            $resultado = $this->object->validarTelefono('04120546170', '30130398');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error telefono', $resultado['resultado']);
        }

         
        //-------------------- MODIFICAR USUARIO ----------------------------------------  
   
           // Prueba para datos vacíos
        public function test_editarUsuario_DatosVacios() {
            $resultado = $this->object->editarUsuario('', '', '', '', '', '','','','');

            $this->assertArrayHasKey('resultado', $resultado);
                
            $this->assertStringContainsString('Ingresar Cedula', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar nombre', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar apellido', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar Correo', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Telefono', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar rol', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar estado', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_editarUsuario_DatosErroneos() {
            $resultado = $this->object->editarUsuario('wdhwd3', 'j443u', '4467', 'li33na76','876s.d', 
            'lopexjERk', 'hduj34sg7', '2fv*','po4l');
                        
            $this->assertArrayHasKey('resultado', $resultado);
                    
            $this->assertStringContainsString('Ingresar Cedula', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar nombre', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar segundo nombre', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar apellido', $resultado['resultado']); 
            $this->assertStringContainsString('Ingresar segundo apellido', $resultado['resultado']);   
            $this->assertStringContainsString('Ingresar Correo', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Telefono', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar rol', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar estado', $resultado['resultado']);
        }

         //Prueba con datos correctos
        public function test_editarUsuario_DatosCorrectos() {
            $cedula = '12345678';
            $nombre = 'Mariana';
            $segNombre = 'Paulina';
            $apellido = 'Pérez';
            $segApellido = 'Gómez';
            $correo = 'mariaperez18@gmail.com';
            $telefono = '04121234567';
            $idRol = '1';
            $estado = '1';

            $resultado = $this->object->editarUsuario($cedula, $nombre, $segNombre, $apellido, $segApellido, $correo,
            $telefono, $idRol, $estado);

            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('modificado', $resultado['resultado']);

            $info = $this->object->infoUsuario($cedula);

            $this->assertNotEmpty($info);
            $this->assertIsObject($info);

            $this->assertEquals('Mariana', $info->nombre);
            $this->assertEquals('Paulina', $info->segNombre);
            $this->assertEquals('Pérez', $info->apellido);
            $this->assertEquals('Gómez', $info->segApellido);
            $this->assertEquals('mariaperez18@gmail.com', $info->correo);
            $this->assertEquals('04121234567', $info->telefono);
            $this->assertEquals('1', (string)$idRol); 
            $this->assertEquals(1, $info->status); 
        }

     
      

    //-------------------- ANULAR USUARIO -------------------------------------------
 
        // Prueba para datos vacíos
        public function test_eliminarUsuario_DatosVacios() {
            $resultado = $this->object->eliminarUsuario('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']); 
        }

         // Prueba para datos erróneos (no cumplen con el patrón)
        public function test_eliminarUsuario_DatosErroneos() {
            $resultado = $this->object->eliminarUsuario('6Yd');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
        }

        //prueba anular usuario que esxiste en la bd
        public function test_eliminarUsuarioExiste(){
        $id = 29913493;
 
        $resultado = $this->object->eliminarUsuario($id);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('eliminado', $resultado['resultado']);
        }
    
    
    

}
?>