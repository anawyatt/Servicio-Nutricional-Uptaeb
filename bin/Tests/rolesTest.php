<?php 
use PHPUnit\Framework\TestCase;
use modelo\rolesModelo as roles;

class rolesTest extends TestCase {
    private $objeto;
    private $conex2;

    protected function setUp(): void {
        $this->objeto = new roles();
        $this->conex2 = new PDO('mysql:host=localhost;dbname=seguridadUptaeb', 'root', '');
        $this->conex2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

   //------------- VALIDAR ROL -----------------------------
// Prueba para datos vacíos
 public function test_validarRol_DatosVacios() {
    $resultado = $this->objeto->validarRol('');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
   
 }
 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_validarRol_DatosErroneos() {
    $resultado = $this->objeto->validarRol('2/8h$');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_validarRol_DatoDuplicado() {
    $resultado = $this->objeto->validarRol('Cocinero');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('error2', $resultado['resultado']);
}

// Prueba para datos que existen en la base de datos
public function test_validarRol_DatoListo() {
    $resultado = $this->objeto->validarRol('Suplente');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);

}
   //------------- REGISTRAR ROL ----------------------------

   // Prueba para datos vacíos
 public function test_registrarRol_DatosVacios() {
    $resultado = $this->objeto->registrarRol('');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
   
 }
 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_registrarRol_DatosErroneos() {
    $resultado = $this->objeto->registrarRol('9^42@');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
}

 public function test_registrarRol_DatosDuplicado() {
    $resultado = $this->objeto->registrarRol('Encargado');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('error2', $resultado['resultado']);
}

   public function test_registrarRol_DatosListos(){
    
    $rol = 'Asistente de Cocina';
 
    $resultado = $this->objeto->registrarRol($rol);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('exitoso', $resultado['resultado']);
    
    $stmt = $this->conex2->prepare("SELECT * FROM `rol` WHERE `nombreRol` = ?");
    $stmt->execute([$rol]);
    $registro = $stmt->fetch();

    $this->assertNotEmpty($registro);
    $this->assertEquals('Asistente de Cocina', $registro['nombreRol']);
}

   //------------- MOSTRAR ROL ---------------------------
    // Prueba para datos vacíos
    public function test_muestraRol_DatosVacios() {
        $resultado = $this->objeto->muestraRol('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_muestraRol_DatosErroneos() {
        $resultado = $this->objeto->muestraRol('4we');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
    }

    // Prueba para un tipo de  alimento que no existe
    public function test_muestraRol_DatosNoExiste() {
        $resultado = $this->objeto->muestraRol(9);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
    }
 
    // Prueba para un tipo de  alimento existente
    public function test_muestraRol_DatosExiste() {
       $resultado = $this->objeto->muestraRol(3); 
       $this->assertIsArray($resultado);
       $this->assertNotEmpty($resultado);
    }
   //------------- VERIFICAR EXISTENCIA ---------------------
    // Prueba para datos vacíos
    public function test_verificarExistencia_DatosVacios() {
        $resultado = $this->objeto->verificarExistencia('');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }
     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_verificarExistencia_DatosErroneos() {
        $resultado = $this->objeto->verificarExistencia('78)@8^');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
    }

    // Prueba para verificar que el tipo de alimento no existe
   public function test_verificarExistencia_DatoNoExiste() {
    $resultado = $this->objeto->verificarExistencia(10);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
   }

  // Prueba para verificar que el tipo de alimento existe
  public function test_verificarExistencia_DatoExiste() {
    $resultado = $this->objeto->verificarExistencia(5);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);
  }

   //------------- VALIDAR ROL PARA MODIFICAR ---------------
    // Prueba para datos vacíos
    public function test_validarRol2_DatosVacios() {
        $resultado = $this->objeto-> validarRol2('','');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del rol', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el nombre del rol', $resultado['resultado']);
    }
     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_validarRol2_DatosErroneos() {
        $resultado = $this->objeto-> validarRol2('20#3','5yt;&');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('Ingresar el id del rol', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar el nombre del rol', $resultado['resultado']);
    }
     // Prueba para datos inexistentes en la base de datos
     public function test_validarRol2_DatoDuplicado() {
        $resultado = $this->objeto-> validarRol2('Cocinero',3);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('errorRol', $resultado['resultado']);
    }
    // Prueba para datos que existen en la base de datos
    public function test_validarRol2_DatoListo() {
        $resultado = $this->objeto-> validarRol2('Lavaplatos',4);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta duplicado', $resultado['resultado']);
    }
   //------------- MODIFICAR ROL-----------------------------
   public function test_editarRol_DatosVacios() {
    $resultado = $this->objeto->editarRol('', '');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
   }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_editarRol_DatosErroneos() {
        $resultado = $this->objeto->editarRol('22w','k3tr');
        $this->assertArrayHasKey('error', $resultado);
        $this->assertEquals('El nombre debe contener solo letras y no puede estar vacío.', $resultado['error']);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

    public function test_editarRol_DatoDuplicado() {
        $resultado = $this->objeto->editarRol('Cocinero',3);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('errorRol', $resultado['resultado']);
       
    }

    public function test_editarRol_ErrorModificarSuperUsuario() {
        $resultado = $this->objeto->editarRol('Admin',1);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('No tienes permiso para editar el rol de Super Usuario.', $resultado['resultado']);
       
    }

    public function test_editarRol_DatosListos() {
        $id = 4;
        $rol = 'Administrador';
    
        $resultado = $this->objeto->editarRol($rol, $id,);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Rol actualizado exitosamente', $resultado['resultado']);
    
        $info = $this->objeto->muestraRol($id,);
    
        $this->assertNotEmpty($info);
        $this->assertIsArray($info);
    
        $alimentoInfo = $info[0];
        $this->assertEquals('Administrador', $alimentoInfo['nombreRol']);
    }
    
   //------------- VALIDAR ANULACION DEL ROL ---------------
   // Prueba para datos vacíos
   public function test_usuariosRegistradosConRol_DatosVacios() {
    $resultado = $this->objeto->usuariosRegistradosConRol('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_usuariosRegistradosConRol_DatosErroneos() {
    $resultado = $this->objeto->usuariosRegistradosConRol('4?0we');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
}

public function test_usuariosRegistradosConRol_ErrorAnular() {
    $resultado = $this->objeto->usuariosRegistradosConRol(3);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('usuarios_asociados', $resultado['resultado']);
   
}

public function test_usuariosRegistradosConRol_ListoAnular() {
    $resultado = $this->objeto->usuariosRegistradosConRol(8);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
   
}

   //------------- ANULAR ROL-------------------------------

     // Prueba para datos vacíos
     public function test_eliminarRol_DatosVacios() {
        $resultado = $this->objeto->eliminarRol('');
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_eliminarRol_DatosErroneos() {
        $resultado = $this->objeto->eliminarRol('5^3fh');
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('Ingresar el id del rol', $resultado['resultado']);
       
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_eliminarRol_ErrorAnularRolSession() {
        $resultado = $this->objeto->eliminarRol(3);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('No puedes eliminar el rol con el que iniciaste sesión.', $resultado['resultado']);
       
    }

    public function test_eliminarRol_NoExiste() {
        $resultado = $this->objeto->eliminarRol(10);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('ya no existe', $resultado['resultado']);
       
    }

    public function test_eliminarRol_UsuarioAsociado() {
        $resultado = $this->objeto->eliminarRol(2);
        $this->assertArrayHasKey('resultado', $resultado);
       $this->assertEquals('usuarios_asociados', $resultado['resultado']);
       
    }

    public function test_eliminarRol_DatosListos(){
        $id = 8;
        $resultado = $this->objeto->eliminarRol($id);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('anulado correctamente.', $resultado['resultado']);
    }
}
?>