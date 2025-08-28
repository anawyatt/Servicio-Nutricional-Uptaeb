<?php/*
    use PHPUnit\Framework\TestCase;
    use modelo\consultarEntradaUtensiliosModelo as salidaUtensilios;

    class consultarEntradaUtensiliosTest extends TestCase {
        protected $utensilios;

        protected function setUp(): void {
            session_start(); // Inicia la sesión
            $_SESSION['cedula'] = '12345678';
            $this->utensilios = new salidaUtensilios();
            $this->utensilios->conectarParaPrueba();
            $this->conex = $this->utensilios->getConexion();
        }

        protected function tearDown(): void {
        
        $this->conex = null;
        $this->utensilios->DesconectarParaPrueba();
        }

        public function testMostrarEntradaUtensiliosFechasValidas() {
            $fechaInicio = '2024-11-01';
            $fechaFin = '2024-11-15';
            
            $resultado = $this->utensilios->mostrarEntradaUtensilios($fechaInicio, $fechaFin, false);
            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            
            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío si existen registros.");
        }

        public function testMostrarEntradaUtensiliosFechaInicioInvalida() {
                $fechaInicio = 'www'; 
                $fechaFin = '2024-11-15';
                
                $resultado = $this->utensilios->mostrarEntradaUtensilios($fechaInicio, $fechaFin, false);
                $this->assertEquals('Fecha de inicio inválida. Formato requerido: YYYY-MM-DD', $resultado['resultado'], "El mensaje debería indicar que la fecha de inicio es inválida.");
        }

        public function testMostrarEntradaUtensiliosSinFechas() {
            $fechaInicio = '';
            $fechaFin = '';
        
            $resultado = $this->utensilios->mostrarEntradaUtensilios($fechaInicio, $fechaFin, false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            
            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío si existen registros.");
        }
        public function testVerificarExistenciaIdNoExistente() {
            $id = 9999;
            
            $resultado = $this->utensilios->verificarExistencia($id, false);
            $this->assertArrayHasKey('resultado', $resultado, "El arreglo debería tener la clave 'resultado'.");
            $this->assertEquals('ya no existe', $resultado['resultado'], "El mensaje debería indicar que el ID ya no existe.");
        }

        public function testVerificarExistenciaIdExistente() {
            $id = 7; 
            $resultado = $this->utensilios->verificarExistencia($id, false);
            $this->assertNull($resultado, "El resultado debería ser null si el ID existe en la base de datos.");
        }

        public function testUtensiliosParametrosValidos() {
            $idTipoU = 61;
            $idInventarioU = 8;

            $resultado = $this->utensilios->utensilios($idTipoU, $idInventarioU, false);

            $this->assertNotEmpty($resultado, "La consulta debería devolver al menos un utensilio.");
        }

        public function testAnularEntradaUtensiliosIdNoExistente() {
            $id = 999; 

            $resultado = $this->utensilios->anularEntradaUtensilios($id, false);
            $this->assertArrayHasKey('resultado', $resultado, "El resultado debería contener la clave 'resultado'.");
            $this->assertEquals('No se pudo anular la entrada.', $resultado['resultado'], "El mensaje debería indicar que no se pudo anular la entrada.");
        }

        public function testAnularEntradaUtensiliosExitosa() {
            $id = 8; 

            $resultado = $this->utensilios->anularEntradaUtensilios($id, false);
            $this->assertArrayHasKey('resultado', $resultado, "El resultado debería contener la clave 'resultado'.");
            $this->assertEquals('eliminado', $resultado['resultado'], "El mensaje debería indicar que la entrada fue eliminada.");
        }


           

    }*/