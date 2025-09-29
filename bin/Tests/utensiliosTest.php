<?php 
use PHPUnit\Framework\TestCase;
use modelo\utensiliosModelo as utensilios;

class utensiliosTest extends TestCase {
    private $objeto;
    private $conex;



    protected function setUp(): void {
        $this->objeto = new utensilios();       
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//Verificar Existencia Tipo Utensilio//

    // Prueba para datos vacíos
    public function test_verificarExistenciaTipoU_DatosVacios() {
        $resultado = $this->objeto->verificarExistenciaTipoU('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    }

    public function test_verificarExistenciaTipoU_DatosErroneos() {
        $resultado = $this->objeto->verificarExistenciaTipoU('9h#6.;');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    }
    
    public function test_verificarExistenciaTipoU_DatosNoExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoU(7000); 
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no está', $resultado['resultado']);
    }

    public function test_verificarExistenciaTipoU_DatosExistenBD() {
        $resultado = $this->objeto->verificarExistenciaTipoU(13); 
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('está', $resultado['resultado']);
    }


   //Verificar Utensilios

    public function test_verificarUtensilios_DatosVacios() {
        $resultado = $this->objeto->verificarUtensilios('', '', '');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    }

    public function test_verificarUtensilios_DatosErroneos() {
        $resultado = $this->objeto->verificarUtensilios('xx', '3dd##', '998!');
        $this->assertArrayHasKey('resultado', $resultado);
       
        $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    }

    public function test_verificarUtensilios_DatoDuplicadoBD() {
        
        $resultado = $this->objeto->verificarUtensilios(9, 'Cucharas De Madera', 'Madera');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('existe', $resultado['resultado']);
    }

    public function test_verificarUtensilios_DatoNuevo() {
        $resultado = $this->objeto->verificarUtensilios(500, 'Espátula', 'Madera');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no existe', $resultado['resultado']);
    }


//Registrar Utensilios

public function test_registrarUtensilio_DatosVacios() {
    $resultado = $this->objeto->registrarUtensilio('', '', '', '', '', '');

    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    $this->assertStringContainsString('Nombre de utensilio inválido', $resultado['resultado']);
    $this->assertStringContainsString('Material inválido', $resultado['resultado']);
}

public function test_registrarUtensilio_DatosErroneos() {
    $resultado = $this->objeto->registrarUtensilio('4rf', '3e-;', 'abc', '4erdf', '44;.', '68;f');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
    $this->assertStringContainsString('Nombre de utensilio inválido', $resultado['resultado']);
    $this->assertStringContainsString('Material inválido', $resultado['resultado']);
}

public function test_registrarUtensilio_DatosListos()
{
    $imagen = 'assets/images/utensilios/utensiliospredetereminado.png';
    $imgState = 'NO';
    $tipoU = '9'; 
    $utensilio = 'Platos';
    $material = 'Ceramica';

    $resultado = $this->objeto->registrarUtensilio($imagen, $imgState, $tipoU, $utensilio, $material);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('registrado', $resultado['resultado']);
    
    $stmt = $this->conex->prepare("SELECT * FROM `utensilios` WHERE `nombre` = ?");
    $stmt->execute([$utensilio]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Platos', $registro['nombre']);
    $this->assertEquals('Ceramica', $registro['material']);
    $this->assertEquals('9', $registro['idTipoU']);
}


    








}
?>