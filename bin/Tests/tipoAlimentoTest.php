<?php 

use PHPUnit\Framework\TestCase;
use modelo\tipoAlimentoModelo as tipoAlimento;


class tipoAlimentoTest extends TestCase {
    private $objeto;
    private $conex;

    protected function setUp(): void {
        $this->objeto = new tipoAlimento();
        $this->conex = new \PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

    

    //--------------- VERIFICAR EL TIPO DE ALIMENTO --------------------------//
     // Prueba para datos vacíos
     public function test_verificarTipoAlimento_DatosVacios(): void {
        $resultado = $this->objeto->verificarTipoAlimento('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el tipo de alimento correctamente', $resultado['resultado']);
       
    }
     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarTipoAlimento_DatosErroneos() {
        $resultado = $this->objeto->verificarTipoAlimento('2fd3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el tipo de alimento correctamente', $resultado['resultado']);
    }
    
     // Prueba para datos inexistentes en la base de datos
     public function test_verificarTipoAlimento_DatoDuplicado() {
        $resultado = $this->objeto->verificarTipoAlimento('Carnes');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error tipo', $resultado['resultado']);
    }

    // Prueba para datos que existen en la base de datos
    public function test_verificarTipoAlimento_DatoListo() {
        $resultado = $this->objeto->verificarTipoAlimento('Proteinas y Nutrientes');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta duplicado', $resultado['resultado']);
  
    }
    //--------------- REGISTRAR EL TIPO DE ALIMENTO --------------------------//
     // Prueba para datos vacíos
     public function test_registrarTipoAlimento_DatosVacios() {
        $resultado = $this->objeto->registrarTipoAlimento('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el tipo de alimento correctamente', $resultado['resultado']);
       
    }
     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_registrarTipoAlimento_DatosErroneos() {
        $resultado = $this->objeto->registrarTipoAlimento('a3jsd');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el tipo de alimento correctamente', $resultado['resultado']);
    }
     // Prueba para datos duplicados
      public function test_registrarTipoAlimento_DatoDuplicado() {
        $resultado = $this->objeto->registrarTipoAlimento('Cereales');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error tipo', $resultado['resultado']);
    }
    
     // Prueba para datos correctos
    public function test_registrarTipoAlimento_DatosListos(){
    
    $tipoA = 'Proteinas y Nutrientes';
 
    $resultado = $this->objeto->registrarTipoAlimento($tipoA);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('registrado', $resultado['resultado']);
    
    $stmt = $this->conex->prepare("SELECT * FROM `tipoalimento` WHERE `tipo` = ?");
    $stmt->execute([$tipoA]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Proteinas y Nutrientes', $registro['tipo']);
}

    // -------------- MOSTRAR EL TIPO DE ALIMENTO ---------------------------//
    // Prueba para datos vacíos
    public function test_mostrarTipoA_DatosVacios() {
        $resultado = $this->objeto->mostrarTipoA('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_mostrarTipoA_DatosErroneos() {
        $resultado = $this->objeto->mostrarTipoA('4rsw3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
    }

    // Prueba para un tipo de  alimento que no existe
    public function test_mostrarTipoA_DatosNoExiste() {
        $resultado = $this->objeto->mostrarTipoA(90);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
    }
 
    // Prueba para un tipo de  alimento existente
    public function test_mostrarTipoA_DatosExiste() {
       $resultado = $this->objeto->mostrarTipoA(2); 
       $this->assertIsArray($resultado);
       $this->assertNotEmpty($resultado);
    }
    //--------------- VERIFICAR BOTON ---------------------------------------//

    // Prueba para datos vacíos
    public function test_verificarBoton_DatosVacios() {
        $resultado = $this->objeto->verificarBoton('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
    }
     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarBoton_DatosErroneos() {
        $resultado = $this->objeto->verificarBoton('4r54w3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
    }

    // Prueba para verificar que no permita modificar ni anular el tipo de alimento relacionado con un alimento
   public function test_verificarBoton_DatoNoSePuede() {
    $resultado = $this->objeto->verificarBoton(3);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
   }

  // Prueba para verificar que  permita modificar y anular el tipo de alimento que no este relacionado
  public function test_verificarBoton_DatoSePuede() {
    $resultado = $this->objeto->verificarBoton(15);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
  }
    //--------------- VERIFICAR EXISTENCIA ---------------------------------//
     // Prueba para datos vacíos
     public function test_verificarExistencia_DatosVacios() {
        $resultado = $this->objeto->verificarExistencia('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarExistencia_DatosErroneos() {
        $resultado = $this->objeto->verificarExistencia('23#.;');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
    }

    // Prueba para verificar que el tipo de alimento no existe
   public function test_verificarExistencia_DatoNoExiste() {
    $resultado = $this->objeto->verificarExistencia(16);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
   }


  // Prueba para verificar que el tipo de alimento existe
  public function test_verificarExistencia_DatoExiste() {
    $resultado = $this->objeto->verificarExistencia(10);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);
  }
    //---------------- VERIFICAR EL TIPO DE ALIMENTO MODIFICADO -----------//

    // Prueba para datos vacíos
    public function test_verificarTipoA2_DatosVacios() {
        $resultado = $this->objeto->verificarTipoA2('','');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del tipo alimento correctamente', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el tipo correctamente', $resultado['resultado']);
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarTipoA2_DatosErroneos() {
        $resultado = $this->objeto->verificarTipoA2('2fd*3','5yty@g');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del tipo alimento correctamente', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el tipo correctamente', $resultado['resultado']);
    }
    
     // Prueba para datos inexistentes en la base de datos
     public function test_verificarTipoA2_DatoDuplicado() {
        $resultado = $this->objeto->verificarTipoA2('Carnes',2);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error tipo2', $resultado['resultado']);
    }
    // Prueba para datos que existen en la base de datos
    public function test_verificarTipoA2_DatoListo() {
        $resultado = $this->objeto->verificarTipoA2('Nuevo Tipo',15);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta duplicado', $resultado['resultado']);
  
    }
    // --------------- MODIFICAR EL TIPO DE ALIMENTO ----------------------//
     // Prueba para datos vacíos
     public function test_modificarTipoAlimento_DatosVacios() {
        $resultado = $this->objeto->modificarTipoAlimento('','');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del tipo alimento correctamente', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el tipo correctamente', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_modificarTipoAlimento_DatosErroneos() {
        $resultado = $this->objeto->modificarTipoAlimento('22!w>/','k3t&.r');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del tipo alimento correctamente', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el tipo correctamente', $resultado['resultado']);
       
    }

    public function test_modificarTipoAlimento_DatosDuplicados() {
        $resultado = $this->objeto->modificarTipoAlimento('Bebidas', 1);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error tipo2', $resultado['resultado']);
    }

    public function test_modificarTipoAlimento_DatosNoExiste() {
        $resultado = $this->objeto->modificarTipoAlimento('Nuevo Tipo', 16);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ya no existe', $resultado['resultado']);
    }

     public function test_modificarTipoAlimento_NoModificar() {
        $resultado = $this->objeto->modificarTipoAlimento('Proteinas', 4);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no se puede', $resultado['resultado']);
    }
    
    public function test_modificarTipoAlimento_DatosListos(){
        $id =15;
        $tipoA = 'Nuevo Tipo';
     
        $resultado = $this->objeto->modificarTipoAlimento($tipoA, $id);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Editado correctamente', $resultado['resultado']);
    
        $info = $this->objeto->mostrarTipoA($id);
        
        $this->assertNotEmpty($info);
        $this->assertIsArray($info);
    
        $alimentoInfo = $info[0];
        $this->assertEquals('Nuevo Tipo', $alimentoInfo['tipo']);
    }
    // ---------------- ANULAR EL TIPO DE ALIMENTO -------------------------//

     // Prueba para datos vacíos
     public function test_anularTipoAlimento_DatosVacios() {
        $resultado = $this->objeto->anularTipoAlimento('');
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_anularTipoAlimento_DatosErroneos() {
        $resultado = $this->objeto->anularTipoAlimento('22/w');
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del tipo de alimento correctamente', $resultado['resultado']);
       
    }

    public function test_anularTipoAlimento_DatosNoExiste() {
        $resultado = $this->objeto->anularTipoAlimento(30);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ya no existe', $resultado['resultado']);
    }

     public function test_anularTipoAlimento_NoAnular() {
        $resultado = $this->objeto->anularTipoAlimento( 8);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no se puede', $resultado['resultado']);
    }


    public function test_anularTipoAlimento_DatosListos(){
        $id = 15;
        $resultado = $this->objeto->anularTipoAlimento($id);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('anulado correctamente.', $resultado['resultado']);
    }

}

?>