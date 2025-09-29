<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarUtensiliosModelo as consultarUtensilios;

class consultarUtensiliosTest extends TestCase {

    private $objeto;
    private $conex;

    protected function setUp(): void {
        $this->objeto = new consultarUtensilios();
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

//Verificar existencia del utensilio

public function test_verificarExistencia_DatosVacios() {
    $resultado = $this->objeto->verificarExistencia('');
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('ID inválido', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}

public function test_verificarExistencia_DatosErroneos() {
    $resultado = $this->objeto->verificarExistencia('2f;%3');
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('ID inválido', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}

public function test_verificarExistencia_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistencia(600); 
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('ya no existe', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}

public function test_verificarExistencia_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistencia(90); 
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('ok', $resultado['status']);
    $this->assertEquals('si existe', $resultado['mensaje']);
    $this->assertTrue($resultado['data']);
}

//Información del utensilio

public function test_infoUtensilio_DatosVacios() {
    $resultado = $this->objeto->infoUtensilio('');
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('ID inválido', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}


public function test_infoUtensilio_DatosErroneos() {
    $resultado = $this->objeto->infoUtensilio('7@;3');
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('ID inválido', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}


public function test_infoUtensilio_DatosNoExiste() {
    $resultado = $this->objeto->infoUtensilio('192');
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('error', $resultado['status']);
    $this->assertEquals('No se encontró utensilio', $resultado['mensaje']);
    $this->assertNull($resultado['data']);
}

public function test_infoUtensilio_DatosExiste() {
    $resultado = $this->objeto->infoUtensilio('78'); 
    $this->assertArrayHasKey('status', $resultado);
    $this->assertEquals('ok', $resultado['status']);
    $this->assertEquals('utensilio encontrado', $resultado['mensaje']);
    $this->assertNotNull($resultado['data']);
    $this->assertTrue(property_exists($resultado['data'], 'idUtensilios'));
    $this->assertTrue(property_exists($resultado['data'], 'tipo'));
    $this->assertTrue(property_exists($resultado['data'], 'nombre'));
}

//Verificar existencia del tipo de utensilio


public function test_verificarExistenciaTipoU_DatosVacios() {
    $resultado = $this->objeto->verificarExistenciaTipoU('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosErroneos() {
    $resultado = $this->objeto->verificarExistenciaTipoU('2#8.9');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Seleccionar un tipo de utensilio válido', $resultado['resultado']);
}


public function test_verificarExistenciaTipoU_DatosNoExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(50);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}

public function test_verificarExistenciaTipoU_DatosExistenBD() {
    $resultado = $this->objeto->verificarExistenciaTipoU(9);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ok', $resultado['resultado']);
}

//Verificar modificación del utensilio

public function test_verificarModificacion_DatosVacios() {
    $resultado = $this->objeto->verificarModificacion('');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}


public function test_verificarModificacion_DatosErroneos() {
    $resultado = $this->objeto->verificarModificacion('7#f.d');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ID inválido.', $resultado['resultado']);
}


public function test_verificarModificacion_Nosepuede() {
    $resultado = $this->objeto->verificarModificacion(55); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no se puede', $resultado['resultado']);
}

public function test_verificarModificacion_Sisepuede() {
    $resultado = $this->objeto->verificarModificacion(51); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('se puede', $resultado['resultado']);
}

// Verificar registro del utensilio

public function test_verificarUtensilio_DatosVacios() {
    $resultado = $this->objeto->verificarUtensilio('', '', '', '');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals(
        'ID y tipo de utensilio deben ser números enteros positivos.',
        $resultado['resultado']
    );
}

public function test_verificarUtensilio_DatosErroneos() {
    $resultado = $this->objeto->verificarUtensilio('2f.%', '3w@e', '35^/', 'Ma@dera');
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals(
        'ID y tipo de utensilio deben ser números enteros positivos.',
        $resultado['resultado']
    );
}

public function test_verificarUtensilio_DatoDuplicadoBD() {
    $resultado = $this->objeto->verificarUtensilio(87, 11, 'Parrilla De Hierro', 'Acero Inoxidable');
    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('existe', $resultado['resultado']);
}

public function test_verificarUtensilio_DatoListoParaRegistrar() {
    $resultado = $this->objeto->verificarUtensilio(255, 10, 'Pinzas de Cobre', 'Otros');
    $this->assertIsArray($resultado); 
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no esta', $resultado['resultado']);
}


// Modificar utensilio

public function test_modificarUtensilio_DatosVacios() {
    $resultado = $this->objeto->modificarUtensilio('', '', '', '');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals(
        'ID y tipo de utensilio deben ser números enteros positivos.',
        $resultado['resultado']
    );
}

public function test_modificarUtensilio_DatosErroneos() {
    $resultado = $this->objeto->modificarUtensilio('4#f', '3Te', '4dR%f', 'xw$4');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals(
        'ID y tipo de utensilio deben ser números enteros positivos.',
        $resultado['resultado']
    );
}

public function test_modificarUtensilio_DatoDuplicadoBD() {
    $resultado = $this->objeto->modificarUtensilio(94, 11, 'Molde Para Pan', 'Aluminio');

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('modificado', $resultado['resultado']);
}

public function test_modificarUtensilio_DatosListos() {
    $id = 95; 
    $tipoU = 11;
    $utensilio = 'Pinzas de Lana';
    $material = 'Otros';

    $resultado = $this->objeto->modificarUtensilio($id, $tipoU, $utensilio, $material);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('modificado', $resultado['resultado']);

}


// Modificar imagen del utensilio

public function test_modificarImagen_DatosVacios() {
    $imagen = []; 
    $id = '';

    $resultado = $this->objeto->modificarImagen($imagen, $id);

    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertStringContainsString('No se recibió imagen', $resultado['resultado']);
}

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
    $this->assertStringContainsString('El archivo no es una imagen válida', $resultado['resultado']);

    unlink($tmpFile); 
}

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

public function test_modificarImagen_DatosListos() {
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

    $resultado = $this->objeto->modificarImagen($imagen, $id);

    $this->assertArrayHasKey('error', $resultado);
    $this->assertStringContainsString('Error al mover la imagen subida', $resultado['error']);

    unlink($tmpFile);
}


//Anular utensilio

public function test_anularUtensilio_DatosVacios() {
    $resultado = $this->objeto->anularUtensilio('');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('ID de utensilio no válido', $resultado['error']);
}


public function test_anularUtensilio_DatosErroneos() {
    $resultado = $this->objeto->anularUtensilio('2@2/w');
    $this->assertArrayHasKey('error', $resultado);
    $this->assertEquals('ID de utensilio no válido', $resultado['error']);
}

public function test_anularUtensilio_Listo() {
    $id = 184; 
    $resultado = $this->objeto->anularUtensilio($id);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('eliminado', $resultado['resultado']);
}


}
?>