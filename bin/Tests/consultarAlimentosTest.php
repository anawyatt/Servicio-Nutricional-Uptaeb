<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarAlimentosModelo as consultarAlimentos;

class consultarAlimentosTest extends TestCase {

    private $objeto;
    private $conex;

    protected function setUp(): void {
        $this->objeto = new consultarAlimentos();
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//-------------------- MOSTRAR ALIMENTOS TABLA ---------------------//

// Prueba para datos vacíos (no cumplen con el patrón)

    public function test_mostrarAlimentos_DatosVacios() {
        $resultado = $this->objeto->mostrarAlimentos('2f;#3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }

     // Prueba para datos erróneos (no cumplen con el patrón)
     public function test_mostrarAlimentos_DatosErroneos() {
        $resultado = $this->objeto->mostrarAlimentos('2f;#3');
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
    }

  // Prueba para un tipo de alimento que no existe
     public function test_mostrarAlimentos_DatosNoExiste() {
       $resultado = $this->objeto->mostrarAlimentos('190');
       $this->assertIsArray($resultado);
       $this->assertCount(0, $resultado); 
    }

    // Prueba para un tipo de alimento existente
    public function test_mostrarAlimentos_DatosExiste() {
        $resultado = $this->objeto->mostrarAlimentos('9'); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
    }

//---------------- VERIFICAR EXISTENCIA DEL ALIMENTO --------------------------------//

 // Prueba para datos vacíos
 public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ingrese el id del alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('2f;%3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ingrese el id del alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(190);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya no existe', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(112);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si existe', $resultado['resultado']);

}

//-------------------- INFORMACION DEL ALIMENTO ----------------------
// Prueba para datos vacios (no cumplen con el patrón)
public function test_infoAlimento_DatosVacios() {
    $resultado = $this->objeto->infoAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para datos erróneos (no cumplen con el patrón)
public function test_infoAlimento_DatosErroneos() {
    $resultado = $this->objeto->infoAlimento('7@;3');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento', $resultado['resultado']);
}

// Prueba para un tipo de alimento que no existe
 public function test_infoAlimento_DatosNoExiste() {
   $resultado = $this->objeto->infoAlimento('192');
   $this->assertIsArray($resultado);
   $this->assertCount(0, $resultado); 
}

// Prueba para un tipo de alimento existente
public function test_infoAlimento_DatosExiste() {
    $resultado = $this->objeto->infoAlimento('78'); 
    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado);
}

//-------------------- VERIFICAR EXISTENCIA DEL TIPO ALIMENTO ---------------
  // Prueba para datos vacíos
  public function test_verificarExistenciaTipoA_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoA('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarExistenciaTipoA_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoA('2#8.9');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el tipo de alimento', $resultado['resultado']);
}

 // Prueba para datos inexistentes en la base de datos
 public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(22);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Prueba para datos que existen en la base de datos
public function test_verificarExistenciaTipoA_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoA(5);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('si esta', $resultado['resultado']);

}

//-------------------- VERIFICAR BOTON DE MODIFICAR Y ANULAR ----------------

 // Prueba para datos vacíos
 public function test_verificarBoton_DatosVacios() {
    $resultado = $this->objeto->verificarBoton('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el alimento', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_verificarBoton_DatosErroneos() {
    $resultado = $this->objeto->verificarBoton('7#f.d');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el alimento', $resultado['resultado']);
}

 // Prueba que no permita  anular o modificar el alimento 
 public function test_verificarBoton_Nosepuede() {
    $resultado = $this->objeto->verificarBoton(7);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}


// Prueba que permita anular o modificar el alimento
public function test_verificarBoton_Sisepuede() {
    $resultado = $this->objeto->verificarBoton(155);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);

}

// ------------------- VERIFICAR DUPLICACION DE DATOS DEL ALIMENTO ----------------

   // Prueba para datos vacíos
   public function test_verificarAlimento_DatosVacios() {
    $resultado = $this->objeto->verificarAlimento('', '', '','');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el codigo del alimento, Ingresar un alimento correctamente, Ingresar una marca correctamente, Ingresar la unidad correctamente', $resultado['resultado']);
   }

// Prueba para datos erróneos (no cumplen con el patrón)
   public function test_verificarAlimento_DatosErroneos() {
    $resultado = $this->objeto->verificarAlimento('2f.%', '3w@e', '35^/',55);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Ingresar el codigo del alimento, Ingresar un alimento correctamente, Ingresar una marca correctamente, Ingresar la unidad correctamente', $resultado['resultado']);
   }

// Prueba para datos que ya existen en la base de datos
   public function test_verificarAlimento_DatoDuplicadoBD() {
    $resultado = $this->objeto->verificarAlimento(20,'Arroz', 'Mary', '1 Kg');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


// Prueba para datos nuevos que pueden registrarse
public function test_verificarAlimento_DatoListoParaRegistrar() {
    $resultado = $this->objeto->verificarAlimento(155,'Maizina', 'Americana', '90 Gr');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta duplicado', $resultado['resultado']);
}


//-------------------- MODIFICAR ALIMENTO ----------------------------------------
// Prueba para datos vacíos
public function test_modificarAlimentos_DatosVacios() {
    $resultado = $this->objeto->modificarAlimentos('', '', '', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}



// Prueba para datos erróneos (no cumplen con el patrón)
public function test_modificarAlimentos_DatosErroneos() {
    $resultado = $this->objeto->modificarAlimentos('4#f', '3Te', '4dR%f', 'xw$4','@j');
    $this->assertArrayHasKey('resultado', $resultado);

    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un tipo alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar un alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar una marca correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Ingresar la unidad correctamente', $resultado['resultado']);
}

public function test_modificarAlimentos_DatoDuplicadoBD() {
    $resultado = $this->objeto->modificarAlimentos(20,6,'Arroz', 'Mary', '1 Kg');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
   }


public function test_modificarAlimentos_DatosListos(){
    $id = 155;
    $tipoA = '14';
    $alimento = 'Maizina';
    $marca = 'Americana';
    $unidad = '90 Gr';
 
    $resultado = $this->objeto->modificarAlimentos($id, $tipoA, $alimento, $marca, $unidad);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('modificado', $resultado['resultado']);

    $info = $this->objeto->infoAlimento($id);
    
    $this->assertNotEmpty($info);
    $this->assertIsArray($info);

    $alimentoInfo = $info[0];
    $this->assertEquals('Maizina', $alimentoInfo['nombre']);
    $this->assertEquals('Americana', $alimentoInfo['marca']);
    $this->assertEquals('90 Gr', $alimentoInfo['unidadMedida']);
}



//-------------------- MODIFICAR IMAGEN DEL ALIMENTO -----------------------------

// Prueba para datos vacíos
public function test_modificarImagen_DatosVacios() {
    $imagen = []; 
    $id = '';

    $resultado = $this->objeto->modificarImagen($imagen, $id);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('Error al subir la imagen', $resultado['resultado']);
}

// Prueba para datos erróneos (id no válido y archivo no permitido)
public function test_modificarImagen_DatosErroneos() {
    $tmpFile = tempnam(sys_get_temp_dir(), 'img');
    file_put_contents($tmpFile, 'contenido falso');

    $imagen = [
        'name' => 'archivo.pdf',
        'type' => 'application/pdf',
        'tmp_name' => $tmpFile,
        'error' => UPLOAD_ERR_OK,
        'size' => filesize($tmpFile)
    ];
    $id = 'abc12'; 

    $resultado = $this->objeto->modificarImagen($imagen, $id);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('Ingresar el id del alimento correctamente', $resultado['resultado']);
    $this->assertStringContainsString('El archivo no es una imagen válida', $resultado['resultado']);

    unlink($tmpFile); 
}

// Prueba para archivo inválido (tipo no permitido, id correcto)
public function test_modificarImagen_ArchivoInvalido() {
    $tmpFile = tempnam(sys_get_temp_dir(), 'img');
    file_put_contents($tmpFile, 'contenido falso');

    $imagen = [
        'name' => 'documento.pdf',
        'type' => 'application/pdf',
        'tmp_name' => $tmpFile,
        'error' => UPLOAD_ERR_OK,
        'size' => filesize($tmpFile)
    ];
    $id = 10; 

    $resultado = $this->objeto->modificarImagen($imagen, $id);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('El archivo no es una imagen válida', $resultado['resultado']);

    unlink($tmpFile);
}

// Prueba para datos correctos
public function test_modificarImagen_DatosListos() {

    $tempDir = sys_get_temp_dir() . '/alimentos_test';
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    $tmpFile = tempnam(sys_get_temp_dir(), 'img') . '.png';
    $im = imagecreatetruecolor(1, 1);
    imagepng($im, $tmpFile);
    imagedestroy($im);

    $imagen = [
        'name' => 'imagen.png',
        'type' => 'image/png',
        'tmp_name' => $tmpFile,
        'error' => UPLOAD_ERR_OK,
        'size' => filesize($tmpFile)
    ];
    $id = 58;

    $resultado = $this->objeto->modificarImagenTest($imagen, $id, $tempDir);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('imagen modificado', $resultado['resultado']);

    unlink($tmpFile);
    array_map('unlink', glob("$tempDir/*.*"));
    rmdir($tempDir);
}



//-------------------- ANULAR ALIMENTO -------------------------------------------
 
 // Prueba para datos vacíos
 public function test_anularAlimento_DatosVacios() {
    $resultado = $this->objeto->anularAlimento('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento a anular', $resultado['resultado']);
   
}

 // Prueba para datos erróneos (no cumplen con el patrón)
 public function test_anularAlimento_DatosErroneos() {
    $resultado = $this->objeto->anularAlimento('2@2/w');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar el  alimento a anular', $resultado['resultado']);
}
 public function test_anularAlimento_DatosNoExistenBD() {
    $resultado = $this->objeto->anularAlimento(158);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('el alimento ya no existe', $resultado['resultado']);
}

public function test_anularAlimento_Nosepuede() {
    $resultado = $this->objeto->anularAlimento(67);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}

public function test_anularAlimentoListo(){
    $id = 155;
 
    $resultado = $this->objeto->anularAlimento($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}
?>