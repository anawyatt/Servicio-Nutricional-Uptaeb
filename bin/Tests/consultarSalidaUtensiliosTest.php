<?php/*
    use PHPUnit\Framework\TestCase;
    use modelo\consultarSalidaUtensiliosModelo as salidaUtensilios;

    class consultarSalidaUtensiliosTest extends TestCase {
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

        public function testMostrarSalidaUtensiliosFechasValidas() {
            $fechaInicio = '2024-11-01';
            $fechaFin = '2024-11-15';
        
            $resultado = $this->utensilios->mostrarSalidaUtensilios($fechaInicio, $fechaFin, false);
    
            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");

            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío si existen registros.");
        }

        public function testMostrarSalidaUtensiliosFechaInicioInvalida() {
            $fechaInicio = 'www'; 
            $fechaFin = '2024-11-15'; 
        
            $resultado = $this->utensilios->mostrarSalidaUtensilios($fechaInicio, $fechaFin, false);
            
            $this->assertEquals('Formato de fecha no válido. Debe ser YYYY-MM-DD.', $resultado['resultado'], "El mensaje debería indicar que la fecha de inicio es inválida.");
        }

        public function testMostrarSalidaUtensiliosSinFechas() {
            $fechaInicio = ''; 
            $fechaFin = ''; 
            $resultado = $this->utensilios->mostrarSalidaUtensilios($fechaInicio, $fechaFin, false);
        
            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            
            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío si existen registros.");
        }
    }*/