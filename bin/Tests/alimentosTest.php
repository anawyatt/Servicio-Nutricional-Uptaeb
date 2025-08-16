<?php /*
use PHPUnit\Framework\TestCase;
use modelo\alimentosModelo as alimentos;

class alimentosTest extends TestCase {

    protected function setUp(): void {
        $this->objeto = new alimentos();
        $_SESSION['cedula'] = '12345678';
       
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//-------------------- VERIFICAR EXISTENCIA DEL TIPO ALIMENTO DEL SELECT ---------------------//

    // Prueba para datos vacíos
    public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->objeto->verificarExistenciaTipoA('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->objeto->verificarExistenciaTipoA('2fd3',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }
    
     // Prueba para datos inexistentes en la base de datos
     public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoA(1,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
    }


    // Prueba para datos que existen en la base de datos
    public function test_verificarExistenciaTipoA_DatosExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoA(5,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
  
    }


   //----------------- VERIFICAR ALIMENTO -------------------------------

 
   // Prueba para datos vacíos
   public function test_verificarAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarAlimento('', '', '',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar un tipo alimento correctamente, Ingresar un alimento correctamente, Ingresar una marca correctamente', $resultado['resultado']);
   }

// Prueba para datos erróneos (no cumplen con el patrón)
   public function test_verificarAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarAlimento('2fd3', '3we', '5',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar un tipo alimento correctamente, Ingresar un alimento correctamente, Ingresar una marca correctamente', $resultado['resultado']);
   }

// Prueba para datos que ya existen en la base de datos
   public function test_verificarAlimento_DatoDuplicadoBD() {
    $resultado = $this->objeto->verificarAlimento(3, 'Caraotas', 'El Maizalito',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


// Prueba para datos nuevos que pueden registrarse
public function test_verificarAlimento_DatoListoParaRegistrar() {
    $resultado = $this->objeto->verificarAlimento(3, 'Vinagre', 'Mavesa',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);
}


//------------- REGISTRAR ALIMENTO -------------------------------------

// Prueba para datos vacíos
public function test_registrarAlimento_DatosVacios() {
    $resultado = $this->objeto->registrarAlimento('', '', '', '', '', '',false);

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Valor inválido para men', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarAlimento_DatosErroneos() {
    $resultado = $this->objeto->registrarAlimento('4rf', '3e', '4erdf', '44', 'ff', 'f',false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Valor inválido para men', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}

public function test_registrarAlimento_DatosListos()
{
    
    $imagen = 'assets/images/alimentos/alimentoPredeterminado.png';
    $men = 'SI';
    $tipoA = '1';
    $alimento = 'Manzana';
    $marca = 'Natural';
    $unidad = 'KL';
 
    $resultado = $this->objeto->registrarAlimento($imagen, $men, $tipoA, $alimento, $marca, $unidad, false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('registrado', $resultado['resultado']);
    
    $stmt = $this->conex->prepare("SELECT * FROM `alimento` WHERE `nombre` = ?");
    $stmt->execute([$alimento]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Manzana', $registro['nombre']);
    $this->assertEquals('Natural', $registro['marca']);
    $this->assertEquals('KL', $registro['unidadMedida']);
}


    








}*/
?>