<?php /*
use PHPUnit\Framework\TestCase;
use modelo\consultarAlimentosModelo as consultarAlimentos;

class consultarAlimentosTest extends TestCase {

    protected function setUp(): void {
        $this->objeto = new consultarAlimentos();
        $_SESSION['cedula'] = '12345678';
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//-------------------- MOSTRAR ALIMENTOS TABLA ---------------------//


     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_mostrarAlimentos_DatosErroneos() {
        $resultado = $this->objeto->mostrarAlimentos('2fd3',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }

  // Prueba para un tipo de alimento que no existe
     public function test_mostrarAlimentos_DatosNoExiste() {
       $resultado = $this->objeto->mostrarAlimentos('999', false);
       $this->assertIsArray($resultado);
       $this->assertCount(0, $resultado); 
    }

    // Prueba para un tipo de alimento existente
    public function test_mostrarAlimentos_DatosExiste() {
        $resultado = $this->objeto->mostrarAlimentos('1', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
    }

//---------------- VERIFICAR EXISTENCIA DEL ALIMENTO --------------------------------//

 // Prueba para datos vacíos
 public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('id del alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('id del alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(100,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(31,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);

}

//-------------------- INFORMACION DEL ALIMENTO ----------------------
// Prueba para datos vacios (no cumplen con el patrón)
public function test_infoAlimento_DatosVacios() {
    $resultado = $this->objeto->infoAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_infoAlimento_DatosErroneos() {
    $resultado = $this->objeto->infoAlimento('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para un tipo de alimento que no existe
 public function test_infoAlimento_DatosNoExiste() {
   $resultado = $this->objeto->infoAlimento('55', false);
   $this->assertIsArray($resultado);
   $this->assertCount(0, $resultado); 
}

// Prueba para un tipo de alimento existente
public function test_infoAlimento_DatosExiste() {
    $resultado = $this->objeto->infoAlimento('1', false); 
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//-------------------- VERIFICAR EXISTENCIA DEL TIPO ALIMENTO ---------------
  // Prueba para datos vacíos
  public function test_verificarExistenciaTipoA_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoA('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoA_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoA('2fd3',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(11,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(5,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//-------------------- VERIFICAR BOTON DE MODIFICAR Y ANULAR ----------------

 // Prueba para datos vacíos
 public function test_verificarBoton_DatosVacios() {
    $resultado = $this->objeto->verificarBoton('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarBoton_DatosErroneos() {
    $resultado = $this->objeto->verificarBoton('7fd',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el alimento', $resultado['resultado']);
}

 // Prueba que no permita  anular o modificar el alimento 
 public function test_verificarBoton_Nosepuede() {
    $resultado = $this->objeto->verificarBoton(7,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}


// Prueba que permita anular o modificar el alimento
public function test_verificarBoton_Sisepuede() {
    $resultado = $this->objeto->verificarBoton(30,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);

}

// ------------------- VERIFICAR DUPLICACION DE DATOS DEL ALIMENTO ----------------

   // Prueba para datos vacíos
   public function test_verificarAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarAlimento('', '', '','',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el codigo del alimento, Ingresar un tipo alimento correctamente, Ingresar un alimento correctamente, Ingresar una marca correctamente', $resultado['resultado']);
   }

// Prueba para datos erróneos (no cumplen con el patrón)
   public function test_verificarAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarAlimento('2fd3', '3we', 35,55,false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el codigo del alimento, Ingresar un tipo alimento correctamente, Ingresar un alimento correctamente, Ingresar una marca correctamente', $resultado['resultado']);
   }

// Prueba para datos que ya existen en la base de datos
   public function test_verificarAlimento_DatoDuplicadoBD() {
    $resultado = $this->objeto->verificarAlimento(20,3, 'Caraotas', 'El Maizalito',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


// Prueba para datos nuevos que pueden registrarse
public function test_verificarAlimento_DatoListoParaRegistrar() {
    $resultado = $this->objeto->verificarAlimento(58,3, 'Vinagre', 'Mavesa',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);
}


//-------------------- MODIFICAR ALIMENTO ----------------------------------------
// Prueba para datos vacíos
public function test_modificarAlimentos_DatosVacios() {
    $resultado = $this->objeto->modificarAlimentos('', '', '', '', '', false);

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_modificarAlimentos_DatosErroneos() {
    $resultado = $this->objeto->modificarAlimentos('4rf', '3e', '4df', 4,'j',false);
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}



public function test_modificarAlimentos_DatosListos(){
    $id = 58;
    $tipoA = '4';
    $alimento = 'vainita';
    $marca = 'Natural';
    $unidad = 'KL';
 
    $resultado = $this->objeto->modificarAlimentos($id, $tipoA, $alimento, $marca, $unidad, false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('modificado', $resultado['resultado']);

    $info = $this->objeto->infoAlimento($id, false);
    
    $this->assertNotEmpty($info);
    $this->assertIsArray($info);

    $alimentoInfo = $info[0];
    $this->assertEquals('vainita', $alimentoInfo['nombre']);
    $this->assertEquals('Natural', $alimentoInfo['marca']);
    $this->assertEquals('KL', $alimentoInfo['unidadMedida']);
}



//-------------------- MODIFICAR IMAGEN DEL ALIMENTO -----------------------------

// Prueba para datos vacíos
public function test_modificarImagen_DatosVacios() {
    $resultado = $this->objeto->modificarImagen('', '',  false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Error al cargar el archivo. Asegúrate de subir una imagen válida.', $resultado['resultado']);
}

// Prueba para datos erroneos
public function test_modificarImagen_DatosErroneos() {
    $resultado = $this->objeto->modificarImagen('ed34', 'archivo.pdf',  false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Error al cargar el archivo. Asegúrate de subir una imagen válida.', $resultado['resultado']);
}

public function test_modificarImagen_DatosListos(){
    $_FILES['imagen'] = [
        'name' => 'alimento.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => '/path/to/tmp/alimento.jpg', 
        'error' => UPLOAD_ERR_OK,
        'size' => 500 
    ];
    
    $id = 58;
    $imagen = $_FILES['imagen']['tmp_name'];

    $resultado = $this->objeto->modificarImagen($imagen, $id, false);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('imagen modificado', $resultado['resultado']);
}

//-------------------- ANULAR ALIMENTO -------------------------------------------
 
 // Prueba para datos vacíos
 public function test_anularAlimento_DatosVacios() {
    $resultado = $this->objeto->anularAlimento('',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento a anular', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_anularAlimento_DatosErroneos() {
    $resultado = $this->objeto->anularAlimento('7fd',false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento a anular', $resultado['resultado']);
}

public function test_anularAlimentoListo(){
    $id = 58;
 
    $resultado = $this->objeto->anularAlimento($id, false);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}*/
?>