<?php
use PHPUnit\Framework\TestCase;
use modelo\tipoUtensilioModelo as tipoUtensilio;

class tipoUtensilioTest extends TestCase
{
    private $objeto;

    protected function setUp(): void
    {
        $this->objeto = new tipoUtensilio();
    }

    protected function tearDown(): void
    {
        unset($this->objeto);
    }

    // validar tipo utensilio //

    public function test_validarTipo_DatoVacio(): void
    {
        $resultado = $this->objeto->validarTipo('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo inválido', $resultado['resultado']);
    }

    public function test_validarTipo_DatoInvalido(): void
    {
        $resultado = $this->objeto->validarTipo('tipo@utensilio'); 
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo inválido', $resultado['resultado']);
    }

    public function test_validarTipo_DatoDuplicado(): void
    {
        $resultado = $this->objeto->validarTipo('Utensilios De Limpieza');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ya existe', $resultado['resultado']);
    }

    public function test_validarTipo_DatoDisponible(): void
    {
        $resultado = $this->objeto->validarTipo('Utensilios de Prueba');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('disponible', $resultado['resultado']);
    }

    //Registrar Tipo de Utensilios//
    
    public function test_registrarTipoUtensilio_DatosVacios(): void {
        $resultado = $this->objeto->registrarTipo('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo invalido', $resultado['resultado']);
    }

    public function test_registrarTipoUtensilio_DatosErroneos() {
        $resultado = $this->objeto->registrarTipo('@-@-@-@');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo invalido', $resultado['resultado']);
    }

    public function test_registrarTipoUtensilio_DatoDuplicado() {
        $resultado = $this->objeto->registrarTipo('Utensilios De Corte Y Pelado');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ya existe', $resultado['resultado']);
    }

    public function test_registrarTipoUtensilio_DatosListos() {
        $tipoU = 'Utensilio Prueba PHPUnit';

        $resultado = $this->objeto->registrarTipo($tipoU);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('exitoso', $resultado['resultado']); 

        $pdoCheck = new \PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $pdoCheck->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdoCheck->prepare("SELECT * FROM tipoutensilios WHERE tipo = ?");
        $stmt->execute([$tipoU]);
        $registro = $stmt->fetch();

        $this->assertNotEmpty($registro);
        $this->assertEquals($tipoU, $registro['tipo']);
    }

    // Ver Tipo Utensilio//

        public function test_verTipos_DatoVacio() {
            $resultado = $this->objeto->verTipos('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_verTipos_DatoErroneo() {
            $resultado = $this->objeto->verTipos('4rsw3');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_verTipos_DatoNoExiste() {
            $resultado = $this->objeto->verTipos(90);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Tipo no encontrado', $resultado['resultado']);
        }

        public function test_verTipos_DatoExiste() {
            $resultado = $this->objeto->verTipos(8); 
            $this->assertIsArray($resultado);
            $this->assertNotEmpty($resultado);
            $this->assertTrue(property_exists($resultado[0], 'idTipoU'));
            $this->assertTrue(property_exists($resultado[0], 'tipo'));
            $this->assertTrue(property_exists($resultado[0], 'status'));
        }
    
    //Verificar Existencia//

    public function test_existeTipo_DatoVacio() {
        $resultado = $this->objeto->existeTipo('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ID inválido', $resultado['resultado']);
    }

    public function test_existeTipo_DatoErroneo() {
        $resultado = $this->objeto->existeTipo('23#.;');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ID inválido', $resultado['resultado']);
    }

    public function test_existeTipo_DatoNoExiste() {
        $resultado = $this->objeto->existeTipo(1); 
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ya no existe', $resultado['resultado']);
    }

    public function test_existeTipo_DatoExiste() {
        $resultado = $this->objeto->existeTipo(9);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('existe', $resultado['resultado']);
    }

    //Validar Tipos de Datos modificados//

    public function test_validarTipo2_DatosVacios() {
        $resultado = $this->objeto->validarTipo2('', '');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo inválido', $resultado['resultado']); 
    }

    public function test_validarTipo2_DatosErroneos() {
        $resultado = $this->objeto->validarTipo2('2fd*3', '5yty@g');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo inválido', $resultado['resultado']);
    }

    public function test_validarTipo2_DatoDuplicado() {

        $resultado = $this->objeto->validarTipo2('Utensilios Especializados', 21);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error2', $resultado['resultado']);
    }

    public function test_validarTipo2_DatoDisponible() {
        $resultado = $this->objeto->validarTipo2('Utensilio de Prueba', 18);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('disponible', $resultado['resultado']);
    }

    //Modificar Tipo Utensilio//

        public function test_editarTipo_DatosVacios() {
            $resultado = $this->objeto->editarTipo('', '');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_editarTipo_IdInvalido() {
            $resultado = $this->objeto->editarTipo('Utensilios Varios', 'abc'); 
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_editarTipo_NombreInvalido() {
            $resultado = $this->objeto->editarTipo('@@@', 5);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Nombre inválido', $resultado['resultado']);
        }

        public function test_editarTipo_NoExiste() {
    
            $resultado = $this->objeto->editarTipo('Tipo Fantasma', 9999);
            $this->assertArrayHasKey('mensaje', $resultado);
            $this->assertEquals('No se encontró el tipo de utensilio o no hubo cambios', $resultado['mensaje']);
        }

        public function test_editarTipo_NoModifica() {
    
            $resultado = $this->objeto->editarTipo('Utensilios De Corte Y Pelado', 8);
            $this->assertArrayHasKey('mensaje', $resultado);
            $this->assertEquals('No se encontró el tipo de utensilio o no hubo cambios', $resultado['mensaje']);
        }

        public function test_editarTipo_Exitoso() {
            $id = 17;
            $nuevoNombre = 'Prueba Nueva actualizada';

            $resultado = $this->objeto->editarTipo($nuevoNombre, $id);

            $this->assertArrayHasKey('mensaje', $resultado);
            $this->assertEquals('Tipo de utensilio actualizado exitosamente', $resultado['mensaje']);

            $pdoCheck = new \PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
            $pdoCheck->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdoCheck->prepare("SELECT tipo FROM tipoutensilios WHERE idTipoU = ?");
            $stmt->execute([$id]);
            $registro = $stmt->fetch();

            $this->assertNotEmpty($registro);
            $this->assertEquals($nuevoNombre, $registro['tipo']);
        }
    
    //Anular tipo Utensilio//

        public function test_anularTipoUtensilio_DatosVacios() {
            $resultado = $this->objeto->eliminarTipo('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_anularTipoUtensilio_DatosErroneos() {
            $resultado = $this->objeto->eliminarTipo('22/w');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ID inválido', $resultado['resultado']);
        }

        public function test_anularTipoUtensilio_DatosNoExiste() {
            $resultado = $this->objeto->eliminarTipo(30); 
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('ya no existe', $resultado['resultado']);
        }

        public function test_anularTipoUtensilio_DatosListos() {
            $id = 18; 
            $resultado = $this->objeto->eliminarTipo($id);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Anulado correctamente.', $resultado['resultado']);
        }


    }

?>