<?php  /*
use PHPUnit\Framework\TestCase;
use modelo\salidaUtensiliosModelo as entradaUtensilios;

class salidaUtensiliosTest extends TestCase {
    protected $utensilios;

        protected function setUp(): void {
            session_start(); // Inicia la sesión
            $_SESSION['cedula'] = '12345678';
            $this->utensilios = new entradaUtensilios();
            $this->utensilios->conectarParaPrueba();
            $this->conex = $this->utensilios->getConexion();
        }

        protected function tearDown(): void {
        
        $this->conex = null;
        $this->utensilios->DesconectarParaPrueba();
        }

    public function testVerificarExistenciaTipoSNoExistente() { 
    $tipoS = 999;

    $resultado = $this->utensilios->verificarExistenciaTipoS($tipoS, false);

    $this->assertArrayHasKey('resultado', $resultado, "El resultado debería contener la clave 'resultado'.");
    $this->assertEquals('no está', $resultado['resultado'], "El mensaje debería indicar que el tipo de salida no está en la base de datos.");
    }

    

    public function testVerificarExistenciaTipoSEsistente() {
        $tipoS = 1; 
        $resultado = $this->utensilios->verificarExistenciaTipoS($tipoS, false);

        $this->assertNull($resultado, "El resultado debería ser null si el tipo de salida existe.");
    }

    public function testMostrarUtensiliosSinResultados() {
        $tipoU = 999; 
        $resultado = $this->utensilios->mostrarUtensilios($tipoU, false);

        $this->assertEmpty($resultado, "El resultado debería estar vacío si no existen utensilios.");
    }

    public function testMostrarUtensiliosTipoValido() {
        $tipoU = 61; 
    

        $resultado = $this->utensilios->mostrarUtensilios($tipoU, false);
    

        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertNotEmpty($resultado, "El arreglo no debería estar vacío.");
    }

    public function testRegistrarSalidaUParametrosValidos() {
        $fecha = '2024-12-15'; // Fecha válida
        $hora = '12:30'; // Hora válida
        $tipoS = 1; // Tipo de salida válido
        $descripcion = 'Salida de utensilios de prueba';

        $resultado = $this->utensilios->registrarSalidaU($fecha, $hora, $tipoS, $descripcion, false);

        $this->assertArrayHasKey('id', $resultado, "El resultado debería contener un ID.");
        $this->assertIsNumeric($resultado['id'], "El ID debe ser un número entero.");

    }

    public function testRegistrarSalidaUHoraInvalida() {
        $fecha = '2024-12-15'; 
        $hora = ''; // Hora inválida
        $tipoS = 1; 
        $descripcion = 'Salida de utensilios de prueba';
        $resultado = $this->utensilios->registrarSalidaU($fecha, $hora, $tipoS, $descripcion, false);

        $this->assertArrayHasKey('resultado', $resultado, "Debería devolver el mensaje de 'Hora inválida'");
        $this->assertEquals('Hora inválida, debe ser en formato HH:MM', $resultado['resultado'], "El mensaje de error debe ser el esperado.");
    }
}*/