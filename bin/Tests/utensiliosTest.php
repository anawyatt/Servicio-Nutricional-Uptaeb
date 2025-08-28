<?php/*
    use PHPUnit\Framework\TestCase;
    use modelo\utensiliosModelo as utensilios;

    class utensiliosTest extends TestCase {
        protected $utensilios;

        protected function setUp(): void {
            session_start(); // Inicia la sesión
            $_SESSION['cedula'] = '12345678';
            $this->utensilios = new utensilios();
            $this->utensilios->conectarParaPrueba();
            $this->conex = $this->utensilios->getConexion();
        }

        protected function tearDown(): void {
        
        $this->conex = null;
        $this->utensilios->DesconectarParaPrueba();
        }
        
    // -----------------------------------
    // Test Suite: Verificar Existencia Tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de verificar Existencia Tipo Utensilio .
    // -----------------------------------
    /*
        public function testVerificarExistenciaTipoUExistente() {

            $resultado = $this->utensilios->verificarExistenciaTipoU(58, false);
            $this->assertIsArray($resultado);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('está', $resultado['resultado']);
        }
    
        public function testVerificarExistenciaTipoUNoExistente() {

            $resultado = $this->utensilios->verificarExistenciaTipoU(99999, false); 
            $this->assertIsArray($resultado);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no está', $resultado['resultado']);
        }
    
        public function testVerificarExistenciaTipoUIDInvalido() {

            $resultado = $this->utensilios->verificarExistenciaTipoU("abc", false);
            $this->assertIsArray($resultado);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
        }
    */
        

    // -----------------------------------
    // Test Suite: Mostrar Tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de Mostrar Tipo Utensilio .
    // -----------------------------------
    /*
        public function testMostrarTipoUtensiliosConDatos() {
            $resultado = $this->utensilios->mostrarTipoUtensilios(false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío.");
            $this->assertIsObject($resultado[0], "Cada elemento debería ser un objeto.");
        }
        
        public function testMostrarTipoUtensiliosSinDatos() {
            $this->conex->exec("UPDATE `tipoutensilios` SET status = 0 WHERE status = 1");

            $resultado = $this->utensilios->mostrarTipoUtensilios(false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertEmpty($resultado, "El resultado debería estar vacío.");

            $this->conex->exec("UPDATE `tipoutensilios` SET status = 1 WHERE status = 0");
        }

        public function testMostrarTipoUtensiliosEstructura() {
            $resultado = $this->utensilios->mostrarTipoUtensilios(false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            if (!empty($resultado)) {
                $this->assertIsObject($resultado[0], "Cada elemento debería ser un objeto.");
            }
        }

        public function testMostrarTipoUtensiliosCamposEsperados() {
            $resultado = $this->utensilios->mostrarTipoUtensilios(false);

            if (!empty($resultado)) {
                $utensilio = (array) $resultado[0];
                $this->assertArrayHasKey('idTipoU', $utensilio, "Cada objeto debería tener el campo 'idTipoU'.");
                $this->assertArrayHasKey('tipo', $utensilio, "Cada objeto debería tener el campo 'tipo'.");
                $this->assertArrayHasKey('status', $utensilio, "Cada objeto debería tener el campo 'status'.");
            }
        }

        public function testMostrarTipoUtensiliosMuchosDatos() {
            $resultado = $this->utensilios->mostrarTipoUtensilios(false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertGreaterThanOrEqual(1, count($resultado), "Debería haber al menos un utensilio si la tabla contiene datos.");
        }
    */
    
    // -----------------------------------
    // Test Suite: Verificar Existencia Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de verificar Existencia Utensilio .
    // -----------------------------------

/*
    public function testVerificarUtensiliosExistente() {

        $resultado = $this->utensilios->verificarUtensilios(58, 'Aparca', 'Silicona', false);
        $this->assertEquals(['resultado' => 'existe'], $resultado);
    }


    public function testVerificarUtensiliosNoExistente() {
        $resultado = $this->utensilios->verificarUtensilios(1, 'Cucharón', 'Plástico', false);
        $this->assertEquals(null, $resultado);
    }

*/
    // -----------------------------------
    // Test Suite: Registrar Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de verificar Existencia Utensilio .
    // -----------------------------------
  /*  
    public function testRegistrarUtensilioSinImagen() {
        $resultado = $this->utensilios->registrarUtensilio(null, 'NO', 61, 'Cuchillo', 'Plástico', false);
    
        $this->assertEquals(['resultado' => 'registrado'], $resultado);
    }
/*
    public function testRegistrarUtensilioTipoInvalido() {
        $resultado = $this->utensilios->registrarUtensilio(null, 'NO', 'abc', 'Cuchara', 'Metal', false);
    
        $this->assertEquals(['resultado' => 'Seleccionar un tipo de utensilio válido'], $resultado);
    }
*/
    /*public function testRegistrarUtensilioNombreInvalido() {
        $resultado = $this->utensilios->registrarUtensilio(null, 'NO', 1, 'Cuchara123', 'Metal', false);
    
        $this->assertEquals(['resultado' => 'Nombre de utensilio inválido'], $resultado);
    }

    }
    

   
/*
?>