<?php 
use PHPUnit\Framework\TestCase;
use modelo\alimentosModelo as alimentos;

class alimentosTest extends TestCase {
    private $objeto;
    private $conex;



    protected function setUp(): void {
        $this->objeto = new alimentos();       
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//-------------------- VERIFICAR EXISTENCIA DEL TIPO ALIMENTO DEL SELECT ---------------------//

    // Prueba para datos vacíos
    public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->objeto->verificarExistenciaTipoA('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento correctamente', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->objeto->verificarExistenciaTipoA('9h#6.;');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento correctamente', $resultado['resultado']);
    }
    
     // Prueba para datos inexistentes en la base de datos
     public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoA(16);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
    }


    // Prueba para datos que existen en la base de datos
    public function test_verificarExistenciaTipoA_DatosExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoA(4);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
  
    }


   //----------------- VERIFICAR ALIMENTO -------------------------------

   // Prueba para datos vacíos
   public function test_verificarAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarAlimento('', '', '');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar un alimento correctamente, Ingresar una marca correctamente, Ingresar la unidad correctamente', $resultado['resultado']);
   }

// Prueba para datos erróneos (no cumplen con el patrón)
   public function test_verificarAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarAlimento('2fd3', '.87d*&', '5@57');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar un alimento correctamente, Ingresar una marca correctamente, Ingresar la unidad correctamente', $resultado['resultado']);
   }

// Prueba para datos que ya existen en la base de datos
   public function test_verificarAlimento_DatoDuplicadoBD() {
    $resultado = $this->objeto->verificarAlimento('Arroz', 'Mary', '1 Kg');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


// Prueba para datos nuevos que pueden registrarse
public function test_verificarAlimento_DatoListoParaRegistrar() {
    $resultado = $this->objeto->verificarAlimento('Diablito', 'Under Wood', '115 Gr');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);
}


//------------- REGISTRAR ALIMENTO -------------------------------------

// Prueba para datos vacíos
public function test_registrarAlimento_DatosVacios() {
    $resultado = $this->objeto->registrarAlimento('', '', '', '', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Valor inválido para men', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_registrarAlimento_DatosErroneos() {
    $resultado = $this->objeto->registrarAlimento('4rf', '3e-;', '4erdf', '44;.', 'f0;f', '68;f');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Valor inválido para men', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}

public function test_registrarAlimento_DatoDuplicadoBD() {
    $resultado = $this->objeto->registrarAlimento('assets/images/alimentos/alimentoPredeterminado.png', 'SI', 3, 'Avena', 'Quaker', '400 Gr');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


public function test_registrarAlimento_DatosListos()
{
    
    $imagen = 'assets/images/alimentos/alimentoPredeterminado.png';
    $men = 'SI';
    $tipoA = '14';
    $alimento = 'Diablito';
    $marca = 'Under Wood';
    $unidad = '115 Gr';
 
    $resultado = $this->objeto->registrarAlimento($imagen, $men, $tipoA, $alimento, $marca, $unidad);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('registrado', $resultado['resultado']);
    
    $stmt = $this->conex->prepare("SELECT * FROM `alimento` WHERE `nombre` = ?");
    $stmt->execute([$alimento]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Diablito', $registro['nombre']);
    $this->assertEquals('Under Wood', $registro['marca']);
    $this->assertEquals('115 Gr', $registro['unidadMedida']);
}


    








}
?>