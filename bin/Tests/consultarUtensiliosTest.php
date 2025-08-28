<?php/*
    use PHPUnit\Framework\TestCase;
    use modelo\consultarUtensiliosModelo as utensilios;

    class consultarUtensiliosTest extends TestCase {
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
    // Test Suite: Mostrar Utensilios
    // Descripción: Pruebas para Validar el funcionamiento de  Mostrar Utensilios .
    // -----------------------------------
        
        public function testMostrarUtensiliosConResultados() {
        
            $resultado = $this->utensilios->mostrarUtensilios(false);
        
            $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
            $this->assertNotEmpty($resultado, "El resultado no debería estar vacío cuando hay utensilios disponibles.");
        
            if (!empty($resultado)) {
                $primerElemento = (array) $resultado[0];
                $this->assertArrayHasKey('nombre', $primerElemento, "Cada utensilio debería tener el atributo 'nombre'.");
                $this->assertArrayHasKey('idTipoU', $primerElemento, "Cada utensilio debería tener el atributo 'idTipoU'.");
            }
        }

        public function testMostrarUtensiliosSinResultados() {
            $this->conex->exec("UPDATE utensilios SET status = 0 WHERE status = 1");
        
            $resultado = $this->utensilios->mostrarUtensilios(false);
        
            $this->assertEquals(['resultado' => 'No se encontraron utensilios.'], $resultado, "Debería devolver un mensaje indicando que no se encontraron utensilios.");
        
            $this->conex->exec("UPDATE utensilios SET status = 1 WHERE status = 0");
        }


    // -----------------------------------
    // Test Suite: Verificar existencia Utensilios
    // Descripción: Pruebas para Validar el funcionamiento de Verificar existencia Utensilios.
    // -----------------------------------
      
        public function testVerificarExistenciaIdInvalido() {
            $resultado = $this->utensilios->verificarExistencia('abc', false);
            $this->assertEquals(['error' => 'ID inválido.'], $resultado);
        }

        public function testVerificarExistenciaEncontrado() {
    
            $resultado = $this->utensilios->verificarExistencia(30, false);
            $this->assertEquals(null, $resultado);

        }
        

    // -----------------------------------
    // Test Suite: Verificar existencia infoUtensilios
    // Descripción: Pruebas para Validar el funcionamiento de Verificar existencia infoUtensilios.
    // -----------------------------------


    public function testInfoUtensilioIdVacio() {
        $resultado = $this->utensilios->infoUtensilio('', false);
        $this->assertEquals(['error' => 'ID inválido.'], $resultado);
    }

    public function testInfoUtensilioEncontrado() {

        $resultado = $this->utensilios->infoUtensilio(30, false);
    
        $this->assertIsArray($resultado, "El resultado debe ser un arreglo.");
        $this->assertNotEmpty($resultado, "El resultado no debería estar vacío cuando el utensilio existe.");

        $utensilio = (array) $resultado[0];
        $this->assertArrayHasKey('idUtensilios', $utensilio);
        $this->assertArrayHasKey('nombre', $utensilio);
        $this->assertArrayHasKey('material', $utensilio);
        $this->assertArrayHasKey('idTipoU', $utensilio);
    }

    
    // -----------------------------------
    // Test Suite: Mostrar Tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de Mostrar Tipo Utensilio
    // -----------------------------------
    
    public function testMostrarTipoUtensilioConDatos() {
        $resultado = $this->utensilios->mostrarTipoUtensilio(false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertNotEmpty($resultado, "El resultado no debería estar vacío.");
    }

    public function testMostrarTipoUtensilioSinDatos() {
        // Desactiva todos los registros para simular una base de datos vacía
        $this->conex->exec("UPDATE `tipoutensilios` SET status = 0 WHERE status = 1");
    
        $resultado = $this->utensilios->mostrarTipoUtensilio(false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals(['resultado' => 'No se encontraron tipos de utensilios.'], $resultado, "El mensaje debería indicar que no se encontraron tipos de utensilios.");
    
        // Restaura el estado de los registros
        $this->conex->exec("UPDATE `tipoutensilios` SET status = 1 WHERE status = 0");
    }


    // -----------------------------------
    // Test Suite: Verificar Modificacion
    // Descripción: Pruebas para Validar el funcionamiento de Verificar Modificacion
    // -----------------------------------

    public function testVerificarModificacionPermitida() {
        $id = 20; 
    
        $resultado = $this->utensilios->verificarModificacion($id, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals(['resultado' => 'se puede'], $resultado, "La respuesta debería indicar que 'se puede' modificar.");
    }

    public function testVerificarModificacionEstructura() {
        $id = 2;
    
        $resultado = $this->utensilios->verificarModificacion($id, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertArrayHasKey('resultado', $resultado, "El arreglo debería contener la clave 'resultado'.");
    }



    // -----------------------------------
    // Test Suite: Verificar Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de verificar Utensilio
    // -----------------------------------

    public function testVerificarUtensilioExistente() {

        $id = 40;
        $tipoU = 57;
        $utensilio = "Aparca";
        $material = "No Definido";
    
        $resultado = $this->utensilios->verificarUtensilio($id, $tipoU, $utensilio, $material, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertArrayHasKey('resultado', $resultado, "El resultado debe tener la clave 'resultado'.");
        $this->assertEquals('existe', $resultado['resultado'], "El mensaje debe ser 'existe' cuando el utensilio ya está registrado.");
    }

    public function testVerificarUtensilioIDInvalido() {
       
        $id = "abc";  
        $tipoU = 57;
        $utensilio = "Cuchillo";
        $material = "No Definido";
    
        $resultado = $this->utensilios->verificarUtensilio($id, $tipoU, $utensilio, $material, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertArrayHasKey('resultado', $resultado, "El resultado debe tener la clave 'resultado'.");
        $this->assertEquals('ID y tipo de utensilio deben ser números enteros positivos.', $resultado['resultado'], "El mensaje de error debe ser sobre un ID no válido.");
    }



    // -----------------------------------
    // Test Suite: Modificar Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de Modificar Utensilio
    // -----------------------------------

    public function testModificarUtensilioExitoso() {
        $id = 19;  // ID del utensilio existente
        $tipoU = 57;  // Tipo de utensilio válido
        $utensilio = "Nuevo Cuchillo";  // Nuevo nombre del utensilio
        $material = "Acero Inoxidable";  // Nuevo material
    
        $resultado = $this->utensilios->modificarUtensilio($id, $tipoU, $utensilio, $material, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals('modificado', $resultado['resultado'], "El mensaje debería ser 'modificado'.");
    
        // Verificar que el utensilio se ha actualizado correctamente en la base de datos
        $consulta = $this->conex->prepare("SELECT nombre, material FROM utensilios WHERE idUtensilios = ?");
        $consulta->bindValue(1, $id);
        $consulta->execute();
        $data = $consulta->fetch();
    
        $this->assertEquals($utensilio, $data['nombre'], "El nombre del utensilio no se ha modificado correctamente.");
        $this->assertEquals($material, $data['material'], "El material del utensilio no se ha modificado correctamente.");
    }


    public function testModificarUtensilioDatosVacios() {
        $id = 19;
        $tipoU = 57;
        $utensilio = "";  // Nombre vacío
        $material = "Acero Inoxidable";
    
        $resultado = $this->utensilios->modificarUtensilio($id, $tipoU, $utensilio, $material, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals('El nombre del utensilio es inválido.', $resultado['resultado'], "El mensaje debería ser 'El nombre del utensilio es inválido.'");
    
        // Verificar que el nombre no se ha modificado
        $consulta = $this->conex->prepare("SELECT nombre FROM utensilios WHERE idUtensilios = ?");
        $consulta->bindValue(1, $id);
        $consulta->execute();
        $data = $consulta->fetch();
    
        $this->assertNotEquals("", $data['nombre'], "El nombre del utensilio no debería haberse modificado.");
    }
   
    
    // -----------------------------------
    // Test Suite: Anular Utensilio
    // Descripción: Pruebas para Validar el funcionamiento de Modificar Utensilio
    // -----------------------------------
   

    public function testAnularUtensilioExitoso() {
        $id = 19;  // ID del utensilio que existe
        $resultado = $this->utensilios->anularUtensilio($id, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals('eliminado', $resultado['resultado'], "El mensaje debería ser 'eliminado'.");
    
        // Verificar que el estado del utensilio se haya actualizado a inactivo (0)
        $consulta = $this->conex->prepare("SELECT status FROM utensilios WHERE idUtensilios = ?");
        $consulta->bindValue(1, $id);
        $consulta->execute();
        $data = $consulta->fetch();
    
        $this->assertEquals(0, $data['status'], "El estado del utensilio no se ha actualizado correctamente.");
    }

    public function testAnularUtensilioIdInvalido() {
        $id = "abc";  // ID no válido
        $resultado = $this->utensilios->anularUtensilio($id, false);
    
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertEquals('ID de utensilio no válido', $resultado['resultado'], "El mensaje debería ser 'ID de utensilio no válido.'");
    }

   
}*/

?>