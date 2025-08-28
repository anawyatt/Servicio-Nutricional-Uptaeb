<?php /*
use PHPUnit\Framework\TestCase;
use modelo\permisoModelo as permiso;

class permisoTest extends TestCase {
    protected function setUp(): void {
        $this->objeto = new permiso();
        $_SESSION['cedula'] = '12345678';
       
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//----------- OBTENER PERMISOS --------------------

 // Prueba para datos vacíos
 public function test_getPermisos_DatosVacios() {
    $resultado = $this->objeto->getPermisos('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del modulo', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_getPermisos_DatosErroneos() {
    $resultado = $this->objeto->getPermisos('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del modulo', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
public function test_getPermisos_NoExistenBD() {
    $resultado = $this->objeto->getPermisos(30, false);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
}

// Prueba para datos que existen en la base de datos
public function test_getPermisos_ExistenBD() {
    $resultado = $this->objeto->getPermisos(5,false);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);

}
// ---------- MODIFICAR PERMISOS ------------------

// Prueba para datos vacíos
public function test_actualizarPermisos_DatosVacios() {
    $resultado = $this->objeto->actualizarPermisos('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Los datos proporcionados no son un arreglo', $resultado['resultado']);
   
}

// Prueba para datos vacíos
public function test_actualizarPermisos_ErrorFormato() {
    $resultado = $this->objeto->actualizarPermisos('Modificar, Registrar',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Los datos proporcionados no son un arreglo', $resultado['resultado']);
   
}

// Prueba para datos vacíos
public function test_actualizarPermisos_ErrorPermisoStatus() {
    $datos=[['idPermiso'=> 'Modificar', 'status'=>'Activo'],
            ['idPermiso'=> 'Registrar', 'status'=>'Activo'],
            ['idPermiso'=> 'Anular', 'status'=>'Inactivo'],
            ['idPermiso'=> 'Condultar', 'status'=>'Inactivo']
           ];
    $resultado = $this->objeto->actualizarPermisos($datos,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar un idPermiso válido (solo números enteros)', $resultado['resultado']);
    $this->assertStringContainsString('El valor de status no es válido. Valores permitidos: 1, 0', $resultado['resultado']);
   
}

public function test_actualizarPermisos_DatosListos() {
    $datos=[['idPermiso'=> 2, 'status'=>1],
            ['idPermiso'=> 59, 'status'=>1],
            ['idPermiso'=> 56, 'status'=>0],
            ['idPermiso'=> 17, 'status'=>0]
           ];
    $resultado = $this->objeto->actualizarPermisos($datos, false);

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('msg', $resultado);
    $this->assertEquals('Se han actualizado los permisos correctamente.', $resultado['msg']);
}



}*/
?>