<?php  /*
use PHPUnit\Framework\TestCase;
use modelo\entradaUtensiliosModelo as entradaUtensilios;

class entradaUtensiliosTest extends TestCase {
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
     
        public function testVerificarExistenciaTipoUIdExistente()
        {
            $tipoU = 57; // ID existente en la base de datos
            $resultado = $this->utensilios->verificarExistenciaTipoU($tipoU, false);
            
            // Verificar que el resultado sea null cuando el ID existe
            $this->assertNull($resultado, "El resultado debería ser null para un ID existente.");
        }


        public function testVerificarExistenciaUtensilioExistente() {
            $idUtensilio = 43; // ID que existe en la base de datos
            $resultado = $this->utensilios->verificarExistenciaUtensilio($idUtensilio, false);
            $this->assertEquals(null, $resultado);
        }


        public function testRegistrarEntradaUCorrecto() {
            $fecha = '2024-11-15';
            $hora = '14:30';
            $descripcion = 'Descripción de prueba para la entrada de utensilios';
            $resultado = $this->utensilios->registrarEntradaU($fecha, $hora, $descripcion, false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertArrayHasKey('id', $resultado, "El arreglo debería tener la clave 'id' cuando el registro es exitoso.");
            $this->assertIsNumeric($resultado['id'], "El 'id' debería ser un número entero.");
        }


        public function testRegistrarEntradaUFechaInvalida() {
            $fecha = ''; // Fecha inválida
            $hora = '14:30';
            $descripcion = 'Descripción de prueba para la entrada de utensilios';
            $resultado = $this->utensilios->registrarEntradaU($fecha, $hora, $descripcion, false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertArrayHasKey('resultado', $resultado, "El arreglo debería tener la clave 'resultado' cuando la fecha es inválida.");
            $this->assertEquals('Fecha o hora no válidas.', $resultado['resultado'], "El mensaje debería indicar que la fecha o la hora no son válidas.");
        }

        public function testRegistrarDetalleEntradaUValido() {
            $utensilio = 39; // ID de utensilio existente
            $cantidad = 10;  // Cantidad válida
            $id = 8;         // ID de entrada de utensilio existente
            $resultado = $this->utensilios->registrarDetalleEntradaU($utensilio, $cantidad, $id, false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertArrayHasKey('resultado', $resultado, "El arreglo debería tener la clave 'resultado'.");
            $this->assertEquals('exitoso', $resultado['resultado'], "El resultado debería ser 'exitoso'.");
        }

        public function testRegistrarDetalleEntradaUCantidadInvalida() {
            $utensilio = 39; // ID de utensilio existente
            $cantidad = 0;   // Cantidad inválida
            $id = 1;         // ID de entrada de utensilio existente
            $resultado = $this->utensilios->registrarDetalleEntradaU($utensilio, $cantidad, $id, false);

            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertArrayHasKey('resultado', $resultado, "El arreglo debería tener la clave 'resultado'.");
            $this->assertEquals('La cantidad debe ser mayor a cero.', $resultado['resultado'], "El mensaje debería indicar que la cantidad es inválida.");
        }

}*/
?>