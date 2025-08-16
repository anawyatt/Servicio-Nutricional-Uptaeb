<?php 
use PHPUnit\Framework\TestCase;
use modelo\permisoModelo as permiso;

class permisoTest extends TestCase {
    private $objeto;
    private $conex;

    protected function setUp(): void {
        $this->objeto = new permiso();
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//----------- OBTENER PERMISOS --------------------

 // Prueba para datos vacíos
 public function test_getPermisos_DatosVacios() {
    $resultado = $this->objeto->getPermisos('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del modulo', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_getPermisos_DatosErroneos() {
    $resultado = $this->objeto->getPermisos('6#4.;');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del modulo', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
public function test_getPermisos_NoExistenBD() {
    $resultado = $this->objeto->getPermisos(30);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
}

// Prueba para datos que existen en la base de datos
public function test_getPermisos_ExistenBD() {
    $resultado = $this->objeto->getPermisos(9);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);

}
// ---------- MODIFICAR PERMISOS ------------------

// Prueba para datos vacíos
public function test_actualizarPermisos_DatosVacios() {
    $resultado = $this->objeto->actualizarPermisos('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Los datos proporcionados no son los correctos', $resultado['resultado']);
   
}

// Prueba para error de formato (no es un arreglo)
public function test_actualizarPermisos_ErrorFormato() {
    $resultado = $this->objeto->actualizarPermisos('Modificar, Registrar');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Los datos proporcionados no son los correctos', $resultado['resultado']);
   
}

// Prueba para errores en los datos del arreglo
public function test_actualizarPermisos_ErrorPermisoStatus() {
    $datos=[['idPermiso'=> 'Modificar', 'status'=>'Activo'],
            ['idPermiso'=> 'Registrar', 'status'=>'Activo'],
            ['idPermiso'=> 'Anular', 'status'=>'Inactivo'],
            ['idPermiso'=> 'Condultar', 'status'=>'Inactivo']
           ];
    $resultado = $this->objeto->actualizarPermisos($datos);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar un idPermiso válido', $resultado['resultado']);
    $this->assertStringContainsString('El valor de status no es válido.', $resultado['resultado']);
   
}
// Prueba para datos correctos

public function test_actualizarPermisos_DatosListos() {
    $datos=[['idPermiso'=> 3, 'status'=>0],
            ['idPermiso'=> 59, 'status'=>1],
            ['idPermiso'=> 56, 'status'=>1],
            ['idPermiso'=> 17, 'status'=>1]
           ];
    $resultado = $this->objeto->actualizarPermisos($datos);

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('modificado', $resultado['resultado']);
}

//----------- OBTENER PERMISOS APP --------------------

 // Prueba para datos vacíos
 public function test_permisosApp_DatosVacios() {
    $resultado = $this->objeto->permisosApp('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
   
}
 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_permisosApp_DatosErroneos() {
    $resultado = $this->objeto->permisosApp('3*6;.');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
public function test_permisosApp_NoExistenBD() {
    $resultado = $this->objeto->permisosApp(16);
    $this->assertIsArray($resultado);
    $this->assertCount(0, $resultado); 
}

// Prueba para datos que existen en la base de datos
public function test_permisosApp_ExistenBD() {
    $resultado = $this->objeto->permisosApp(1);
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);

}


}
?>