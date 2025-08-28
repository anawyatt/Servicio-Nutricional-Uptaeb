<?php 
use PHPUnit\Framework\TestCase;
use modelo\perfilModelo as perfil;

class perfilTest extends TestCase {
    private $object;
    private $conex2;

    protected function setUp(): void {
        $this->object = new perfil();
       
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUPTAEB', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

//-------------------- VALIDAR INFORMACION USUARIO ---------------------//

                 // Prueba para datos vacíos
        public function test_informacionUsuario_DatosVacios() {
            $resultado = $this->object->informacionUsuario(' ');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);   
        }

                // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_informacionUsuario_DatosErroneos() {
            $resultado = $this->object->informacionUsuario('23453mf45');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Usuario', $resultado['resultado']);
        }
        

        public function test_informacionUsuario_ExisteBD() {
            $resultado = $this->object->informacionUsuario('29913499');

            $this->assertIsObject($resultado);
            $this->assertNotEmpty($resultado->nombre);
            $this->assertNotEmpty($resultado->apellido);
            $this->assertNotEmpty($resultado->correo);
        }


 
 
       

}
?>