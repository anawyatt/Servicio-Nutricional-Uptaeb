<?php/*
use PHPUnit\Framework\TestCase;
use modelo\tipoUtensilioModelo as tipoUtensilios;

class tipoUtensilioTest extends TestCase {
    protected $tipo;

    protected function setUp(): void {
        session_start(); // Inicia la sesión
        $_SESSION['cedula'] = '12345678';
        $this->tipo = new tipoUtensilios();

        $this->tipo->conectarParaPrueba();
        $this->conex = $this->tipo->getConexion();

    }

    protected function tearDown(): void {

        $this->tipo->DesconectarParaPrueba();
    
        unset($this->tipo);
        unset($this->conex);
    }
/*
    // -----------------------------------
    // Test Suite: Validar Tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento del Tipo.
    // -----------------------------------

    public function testValidarTipoExistente()
    {
    // Preparar el tipo de utensilio a probar
    $tipo = 'Coccion';

    // Inserta el tipo en la base de datos para asegurar que ya exista
    $this->tipo->conectarParaPrueba();
    $query = $this->conex->prepare("INSERT INTO `tipoutensilios` (`tipo`, `status`) VALUES (?, 1)");
    $query->bindValue(1, $tipo);
    $query->execute();

    // Ejecutar el método validarTipo
    $resultado = $this->tipo->validarTipo($tipo);

    // Verificar que el resultado sea el esperado
    $this->assertEquals(['resultado' => 'Ya existe'], $resultado, "El tipo '$tipo' debería ser identificado como existente.");

    // Limpiar la base de datos eliminando el tipo insertado
    $query = $this->conex->prepare("DELETE FROM `tipoutensilios` WHERE `tipo` = ?");
    $query->bindValue(1, $tipo);
    $query->execute();

    // Desconectar
    $this->tipo->DesconectarParaPrueba();
    }

    public function testValidarTipoInvalido()
    {
        $tipo = 'Bandejas@'; 
        $resultado = $this->tipo->validarTipo($tipo);
        $this->assertEquals(['resultado' => 'Tipo inválido'], $resultado, "Debería indicar que el tipo es inválido.");
    }

    public function testValidarTipoVacio()
    {
        $tipo = ''; 
        $resultado = $this->tipo->validarTipo($tipo);
        $this->assertEquals(['resultado' => 'Tipo inválido'], $resultado, "Debería indicar que el tipo vacío es inválido.");
    }

    public function testValidarTipoDisponible()
    {
        $tipo = 'Utensilio de Prueba'; 
        $resultado = $this->tipo->validarTipo($tipo);
        $this->assertEquals(['resultado' => 'disponible'], $resultado, "El tipo '$tipo' debería estar disponible.");
    }

    // -----------------------------------
    // Test Suite: Registrar Tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento del Registrar.
    // -----------------------------------

    public function testRegistrarTipoConDatoVacio()
    {
        $tipo = '';
        $resultado = $this->tipo->registrarTipo($tipo);
        $this->assertEquals((['resultado' => 'Tipo invalido']),
            $resultado
        );
    }

    public function testRegistrarTipoConDatoInvalido()
    {
        $tipoInvalido = 'Hola123%&*'; 
        $resultado = $this->tipo->registrarTipo($tipoInvalido);

        $this->assertEquals((['resultado' => 'Tipo invalido']),
            $resultado
        );
    }

    public function testRegistrarTipoValido()
    {
        $tipoValido = 'Utensilios de Preparacion'; 
        $resultado = $this->tipo->registrarTipo($tipoValido);

        $this->assertEquals((['resultado' => 'exitoso']),
            $resultado
        );
    }


    // -----------------------------------
    // Test Suite: Mostrar tipo Utensilio
    // Descripción: Pruebas para Validar el funcionamiento del Mostrar Tipo de Utensilios.
    // -----------------------------------

    public function testMostrarTablaDeTiposConDatos()
    {
        // Configura la base de datos para que tenga al menos un registro con `status != 0`
        $resultado = $this->tipo->mostrarTiposTabla(false);

        // Verifica que el resultado sea un arreglo y que contenga al menos un objeto
        $this->assertIsArray($resultado, "El resultado debería ser un arreglo.");
        $this->assertNotEmpty($resultado, "El resultado no debería estar vacío.");
        $this->assertIsObject($resultado[0], "Cada elemento del resultado debería ser un objeto.");
    }



    public function testMostrarTiposSinDatos()
    {
        // Actualiza el estado de los utensilios en la base de datos para que no haya tipos con `status != 0`
        $this->conex->exec("UPDATE `tipoutensilios` SET status = 0 WHERE status != 0");
    
        // Llamada a la función que consultará los tipos de utensilios
        $resultado = $this->tipo->mostrarTiposTabla(false);
    
        // Verifica que el resultado sea el esperado cuando no hay tipos de utensilios
        $this->assertEquals(['resultado' => 'No se encontraron tipos de utensilios.'], $resultado);
    
        // Restaura el estado original de los utensilios
        $this->conex->exec("UPDATE `tipoutensilios` SET status = 1 WHERE status = 0");
    }


    // -----------------------------------
    // Test Suite: Ver Tipos Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del Ver Tipos de Utensilios.
    // -----------------------------------

    public function testVerTiposIdVacio()
    {
    $resultado = $this->tipo->verTipos('', false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testVerTiposIdConCaracteresEspeciales()
    {
    $resultado = $this->tipo->verTipos('@#$%', false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testVerTiposIdInvalido()
    {
    $resultado = $this->tipo->verTipos('abc', false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testVerTiposNoEncontrado()
    {
    $resultado = $this->tipo->verTipos(99999, false);
    $this->assertEquals(['resultado' => 'Tipo no encontrado'], $resultado);
    }

    public function testVerTiposEncontrado()
    {
    $resultado = $this->tipo->verTipos(57, false);

    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
    $resultadoArray = (array) $resultado[0];

    $this->assertArrayHasKey('idTipoU', $resultadoArray);
    $this->assertArrayHasKey('tipo', $resultadoArray);
    $this->assertArrayHasKey('status', $resultadoArray);
    }
 

    // -----------------------------------
    // Test Suite: Existe Tipos Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del Ver Tipos de Utensilios.
    // -----------------------------------

    public function testExisteTipoIdInvalido()
    {
    $resultado = $this->tipo->existeTipo('abc', false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testExisteTipoIdNoExistente()
    {
    $resultado = $this->tipo->existeTipo(99999, false);
    $this->assertEquals(['resultado' => 'ya no existe'], $resultado);
    }

    public function testExisteTipoIdExistente()
    {
    $resultado = $this->tipo->existeTipo(58, false);
    $this->assertNull($resultado); 
    }  

    public function testExisteTipoIdNulo()
    {
    $resultado = $this->tipo->existeTipo(null, false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testExisteTipoIdVacio()
    {
    $resultado = $this->tipo->existeTipo('', false);
    $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testExisteTipoMultipleIds()
    {
    $ids = [58, 59, 99999];
    foreach ($ids as $id) {
        $resultado = $this->tipo->existeTipo($id, false);
        if ($id === 99999) {
            $this->assertEquals(['resultado' => 'ya no existe'], $resultado);
        } else {
            $this->assertNull($resultado);
        }
    }
    }


    // -----------------------------------
    // Test Suite: Modificar Tipos Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del Modificar tipos de Utensilios.
    // -----------------------------------


    public function testValidarModificarIdInvalido() {
        $resultado = $this->tipo->validarModificar('abc', false); // ID no numérico
        $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testValidarModificarIdExistenteConUtensiliosActivos() {
        $idExistente = 1; 
        $resultado = $this->tipo->validarModificar($idExistente, false);
        $this->assertEquals(['resultado' => 'no se puede'], $resultado);
    }

    public function testValidarModificarIdExistenteSinUtensiliosActivos() {
        $idSinUtensiliosActivos = 27; 
        $resultado = $this->tipo->validarModificar($idSinUtensiliosActivos, false);
        $this->assertEquals(['resultado' => 'se puede'], $resultado);
    }


    public function testValidarModificarIdVacio() {
        $resultado = $this->tipo->validarModificar('', false); 
        $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }


    // -----------------------------------
    // Test Suite: Validar Tipos2 Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del validar tipos de Utensilios.
    // -----------------------------------
  
    public function testValidarTipo2ConTipoInvalido() {
        $resultado = $this->tipo->validarTipo2('Tipo123', 1, false); 
        $this->assertEquals(['resultado' => 'Tipo inválido'], $resultado);
    }

    public function testValidarTipo2ConIdInvalido() {
        $resultado = $this->tipo->validarTipo2('TipoValido', 'abc', false); 
        $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testValidarTipo2ConTipoExistente() {
        $tipoExistente = 'Cuchillos';
        $idExistente = 57; 
        $resultado = $this->tipo->validarTipo2($tipoExistente, $idExistente, false);
        $this->assertEquals(['resultado' => 'error2'], $resultado);
    }


    // -----------------------------------
    // Test Suite: Editar Tipos Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del Editar tipo de Utensilios.
    // -----------------------------------


    public function testEditarTipoNombreInvalido() {
        $resultado = $this->tipo->editarTipo('Nombre123', 1, false); // Nombre con caracteres no permitidos
        $this->assertEquals(['resultado' => 'Nombre inválido'], $resultado);
    }

    public function testEditarTipoExitoso() {
        $tipo = 'Tazas'; // Nombre válido
        $id = 60; // ID válido que existe en la base de datos
    
        $resultado = $this->tipo->editarTipo($tipo, $id, false);
        $this->assertEquals(['mensaje' => 'Tipo de utensilio actualizado exitosamente'], $resultado);
    
    }

    public function testEditarTipoSinCambios() {
        $tipoExistente = 'Ollas'; // Nombre que ya tiene el registro
        $id = 3; // ID válido que existe en la base de datos
    
        $resultado = $this->tipo->editarTipo($tipoExistente, $id, false);
        $this->assertEquals(['mensaje' => 'No se encontró el tipo de utensilio o no hubo cambios'], $resultado);
    }


    // -----------------------------------
    // Test Suite: Anular Tipos Utensilios
    // Descripción: Pruebas para Validar el funcionamiento del Editar tipo de Utensilios.
    // -----------------------------------

    public function testEliminarTipoExistente() {
        $resultado = $this->tipo->eliminarTipo(59, false); 
        $this->assertEquals(['resultado' => 'Anulado correctamente.'], $resultado);
    }

    public function testEliminarTipoIdInvalido() {
        $resultado = $this->tipo->eliminarTipo('abc', false);
        $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

    public function testEliminarTipoYaAnulado() {
        $resultado = $this->tipo->eliminarTipo(2, false);
        $this->assertEquals(['mensaje' => 'No se encontró el tipo de utensilio o no se pudo anular'], $resultado);
    }

    public function testEliminarTipoIdVacio() {
        $resultado = $this->tipo->eliminarTipo('', false);
        $this->assertEquals(['resultado' => 'ID inválido'], $resultado);
    }

}




*/
?>