<?php /*
use PHPUnit\Framework\TestCase;
use modelo\rolesModelo as roles;

class rolesTest extends TestCase {

    protected function setUp(): void {
        $this->objeto = new roles();
        $_SESSION['cedula'] = '30483987';
        $_SESSION['idRol'] = 3;
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUptaeb', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

   //------------- VALIDAR ROL -----------------------------
// Prueba para datos vacíos
 public function test_validarRol_DatosVacios() {
    $resultado = $this->objeto->validarRol('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
   
 }
 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_validarRol_DatosErroneos() {
    $resultado = $this->objeto->validarRol('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_validarRol_DatoDuplicado() {
    $resultado = $this->objeto->validarRol('Cocineros',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('error2', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_validarRol_DatoListo() {
    $resultado = $this->objeto->validarRol('Suplente',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);

}
   //------------- REGISTRAR ROL ----------------------------

   // Prueba para datos vacíos
 public function test_registrarRol_DatosVacios() {
    $resultado = $this->objeto->registrarRol('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
   
 }
 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_registrarRol_DatosErroneos() {
    $resultado = $this->objeto->registrarRol('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
}

   public function test_registrarRol_DatosListos(){
    
    $rol = 'Nuevo';
 
    $resultado = $this->objeto->registrarRol($rol, false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('exitoso', $resultado['resultado']);
    
    $stmt = $this->conex2->prepare("SELECT * FROM `rol` WHERE `nombreRol` = ?");
    $stmt->execute([$rol]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Nuevo', $registro['nombreRol']);
}

   //------------- MOSTRAR ROL ---------------------------
    // Prueba para datos vacíos
    public function test_muestraRol_DatosVacios() {
        $resultado = $this->objeto->muestraRol('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_muestraRol_DatosErroneos() {
        $resultado = $this->objeto->muestraRol('4we',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
    }

    // Prueba para un tipo de  alimento que no existe
    public function test_muestraRol_DatosNoExiste() {
        $resultado = $this->objeto->muestraRol(20, false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
    }
 
    // Prueba para un tipo de  alimento existente
    public function test_muestraRol_DatosExiste() {
       $resultado = $this->objeto->muestraRol(1, false); 
       $this->assertIsArray($resultado);
       $this->assertNotEmpty($resultado);
    }
   //------------- VERIFICAR EXISTENCIA ---------------------
    // Prueba para datos vacíos
    public function test_verificarExistencia_DatosVacios() {
        $resultado = $this->objeto->verificarExistencia('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarExistencia_DatosErroneos() {
        $resultado = $this->objeto->verificarExistencia('4r54w3',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
    }

    // Prueba para verificar que el tipo de alimento no existe
   public function test_verificarExistencia_DatoNoExiste() {
    $resultado = $this->objeto->verificarExistencia(5,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
   }


  // Prueba para verificar que el tipo de alimento existe
  public function test_verificarExistencia_DatoExiste() {
    $resultado = $this->objeto->verificarExistencia(9,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);
  }

   //------------- VALIDAR ROL PARA MODIFICAR ---------------

    // Prueba para datos vacíos
    public function test_validarRol2_DatosVacios() {
        $resultado = $this->objeto-> validarRol2('','',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del rol', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar un el nombre del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_validarRol2_DatosErroneos() {
        $resultado = $this->objeto-> validarRol2('2fd3','5ytyg',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del rol', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar un el nombre del rol', $resultado['resultado']);
       
    }
    
     // Prueba para datos inexistentes en la base de datos
     public function test_validarRol2_DatoDuplicado() {
        $resultado = $this->objeto-> validarRol2('Nuevo',3,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('error2', $resultado['resultado']);
    }


    // Prueba para datos que existen en la base de datos
    public function test_validarRol2_DatoListo() {
        $resultado = $this->objeto-> validarRol2('Cocinero',9,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta duplicado', $resultado['resultado']);
  
    }
   //------------- MODIFICAR ROL-----------------------------
   public function test_editarRol_DatosVacios() {
    $resultado = $this->objeto->editarRol('', '', false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
   }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_editarRol_DatosErroneos() {
        $resultado = $this->objeto->editarRol('22w','k3tr',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['resultado']);
       
    }

    public function test_editarRol_ErrorModificarSuperUsuario() {
        $resultado = $this->objeto->editarRol('Admin',1,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('No tienes permiso para editar el rol de Super Usuario.', $resultado['resultado']);
       
    }


    public function test_editarRol_DatosListos() {
        $id = 13;
        $rol = 'admin';
    
        $resultado = $this->objeto->editarRol($rol, $id, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Rol actualizado exitosamente', $resultado['resultado']);
    
        $info = $this->objeto->muestraRol($id, false);
    
        $this->assertNotEmpty($info);
        $this->assertIsArray($info);
    
        $alimentoInfo = $info[0];
        $this->assertEquals('hola', $alimentoInfo['nombreRol']);
    }
    
   //------------- VALIDAR ANULACION DEL ROL ---------------
   // Prueba para datos vacíos
   public function test_usuariosRegistradosConRol_DatosVacios() {
    $resultado = $this->objeto->usuariosRegistradosConRol('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_usuariosRegistradosConRol_DatosErroneos() {
    $resultado = $this->objeto->usuariosRegistradosConRol('4we',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
}

public function test_usuariosRegistradosConRol_ErrorAnular() {
    $resultado = $this->objeto->usuariosRegistradosConRol(3,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('usuarios_asociados', $resultado['resultado']);
   
}

public function test_usuariosRegistradosConRol_ListoAnular() {
    $resultado = $this->objeto->usuariosRegistradosConRol(9,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
   
}

   //------------- ANULAR ROL-------------------------------

     // Prueba para datos vacíos
     public function test_eliminarRol_DatosVacios() {
        $resultado = $this->objeto->eliminarRol('',false);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_eliminarRol_DatosErroneos() {
        $resultado = $this->objeto->eliminarRol('22w',false);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_eliminarRol_ErrorAnularRolSession() {
        $resultado = $this->objeto->eliminarRol(3,false);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('No puedes eliminar el rol con el que iniciaste sesión.', $resultado['resultado']);
       
    }

    public function test_eliminarRol_DatosListos(){
        $id = 7;
        $resultado = $this->objeto->eliminarRol($id, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('anulado correctamente.', $resultado['resultado']);
    }
}*/
?>