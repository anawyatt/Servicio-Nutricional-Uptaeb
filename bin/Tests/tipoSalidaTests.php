<?php

use PHPUnit\Framework\TestCase;
use modelo\tipoSalidaModelo as tipoSalida;

class tipoSalidaTests extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new tipoSalida();
        
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }


public function testTipoSalida_Vacio() {
    $resultado = $this->objeto->verificarTipoSalida("");
    $this->assertEquals(['resultado' => 'Tipo de salida inválido.'], $resultado);
}

public function testTipoSalida_InvalidoConNumeros() {
    $resultado = $this->objeto->verificarTipoSalida("123Salida");
    $this->assertEquals(['resultado' => 'Tipo de salida inválido.'], $resultado);
}

public function testTipoSalida_Existente() {
    // Simulando que "Salida Normal" existe en la BD con status=1
    $resultado = $this->objeto->verificarTipoSalida("Merma");
    $this->assertEquals(['resultado' => 'error tipo'], $resultado);
}

public function testTipoSalida_NoExistente() {
    // Simulando que "Salida Especial" no existe en la BD
    $resultado = $this->objeto->verificarTipoSalida("Salida Especial");
    $this->assertEquals(['resultado' => 'ok'], $resultado);
}


/////rregistrar tipo salida//////////////


    public function testRegistrarTipoSalida_Invalido() {
        $resultado = $this->objeto->registrarTipoSalida("1234###");
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo de salida inválido.', $resultado['resultado']);
    }

    public function testRegistrarTipoSalida_Vacio() {
        $resultado = $this->objeto->registrarTipoSalida("");
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Tipo de salida inválido.', $resultado['resultado']);
    }

    public function testRegistrarTipoSalida_Valido() {
        // ⚠️ Mock recomendado para no tocar datos reales
        $resultado = $this->objeto->registrarTipoSalida("Salida Especial");
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('registrado', $resultado['resultado']);
    }


public function testRegistrarTipoSalida_Duplicado() {
    $this->objeto->registrarTipoSalida("Salida Especial");
    $resultado = $this->objeto->registrarTipoSalida("Salida Especial");

    $this->assertIsArray($resultado);

    // Si no hay UNIQUE, la BD permite duplicados → sigue registrando
    $this->assertEquals('registrado', $resultado['resultado']);
}


    // mostrar tipo salida en editar creo///
    // 4️⃣ ID vacío
    public function testMostrarTipoS_IdVacio() {
        $resultado = $this->objeto->mostrarTipoS("");
        $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
    }

    // 1️⃣ ID inválido (no numérico)
    public function testMostrarTipoS_IdInvalido() {
        $ids = ["abc", "12a3", ""];
        foreach ($ids as $id) {
            $resultado = $this->objeto->mostrarTipoS($id);
            $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
        }
    }

    // 2️⃣ ID válido, pero no existe en la BD
    public function testMostrarTipoS_IdNoExistente() {
        $id = 99999; // suponer que no existe
        $resultado = $this->objeto->mostrarTipoS($id);
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado, "Debe retornar array vacío si no existe el ID");
    }

    // 3️⃣ ID válido y existe en la BD
    public function testMostrarTipoS_IdExistente() {
        $id = 1; // suponer que existe
        $resultado = $this->objeto->mostrarTipoS($id);
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado, "Debe retornar datos si el ID existe");
        $this->assertArrayHasKey('idTipoSalidas', $resultado[0]);
        $this->assertArrayHasKey('tipoSalida', $resultado[0]);
        $this->assertArrayHasKey('status', $resultado[0]);
    }

    // verificar modificacion tipo salida///

    // 1️⃣ ID inválido (no numérico)
    public function testVerificarModificacion_IdInvalido() {
        $ids = ["abc", "12a3", ""];
        foreach ($ids as $id) {
            $resultado = $this->objeto->verificarModificacion($id);
            $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
        }
    }

    // 2️⃣ ID vacío
    public function testVerificarModificacion_IdVacio() {
        $resultado = $this->objeto->verificarModificacion("");
        $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
    }

    // 3️⃣ ID válido, existe y tiene referencias (no se puede modificar)
    public function testVerificarModificacion_IdConReferencias() {
        $id = 1; // ajustar a un ID que tenga referencias en salidaAlimentos o salidaUtensilios
        $resultado = $this->objeto->verificarModificacion($id);
        $this->assertIsArray($resultado);
        $this->assertEquals('no se puede', $resultado['resultado']);
    }

    // 4️⃣ ID válido, existe y NO tiene referencias (se puede modificar)
    public function testVerificarModificacion_IdSinReferencias() {
        $id = 7; // ajustar a un ID que exista pero no tenga referencias
        $resultado = $this->objeto->verificarModificacion($id);
        $this->assertIsArray($resultado);
        $this->assertEquals('se puede', $resultado['resultado']);
    }
    

    // verificar tipo salida 2 para modificar///

// 1️⃣ ID inválido
    public function testVerificarExistencia_IdInvalido() {
        $ids = ["abc", "12a3", ""];
        foreach ($ids as $id) {
            $resultado = $this->objeto->verificarExistencia($id);
            $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
        }
    }
    //ID Vacio
    public function testVerificarExistencia_Idvacio() {
        $ids = ["", "", ""];
        foreach ($ids as $id) {
            $resultado = $this->objeto->verificarExistencia($id);
            $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
        }
    }

    // 2️⃣ ID válido pero ya no existe
    public function testVerificarExistencia_IdNoExiste() {
        $id = 999999; // Ajustar a un ID que no exista o tenga status != 1
        $resultado = $this->objeto->verificarExistencia($id);
        $this->assertEquals(['resultado' => 'ya no existe'], $resultado);
    }

    // 3️⃣ ID válido y existe
    public function testVerificarExistencia_IdExiste() {
        $id = 1; // Ajustar a un ID existente con status = 1
        $resultado = $this->objeto->verificarExistencia($id);
        $this->assertNull($resultado); // debe ser null si existe
    }


    /// verificar tipo salida 2 para modificar validar///
    // 1️⃣ Datos vacíos
    public function testVerificarTipoS2_DatosVacios() {
        $resultado = $this->objeto->verificarTipoS2("", "");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 2️⃣ Tipo de salida no válido
    public function testVerificarTipoS2_TipoSalidaInvalido() {
        $resultado = $this->objeto->verificarTipoS2("Tipo123!", "1");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 3️⃣ ID no válido
    public function testVerificarTipoS2_IdInvalido() {
        $resultado = $this->objeto->verificarTipoS2("Almuerzo", "abc");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 4️⃣ Tipo de salida ya existe para otro ID
    public function testVerificarTipoS2_TipoExisteOtroID() {
        $tipoS = "Salida Especial"; // Ajustar a un tipo existente en la BD
        $id = 1; // ID diferente al que tiene este tipo
        $resultado = $this->objeto->verificarTipoS2($tipoS, $id);
        $this->assertEquals(['resultado' => 'error tipo'], $resultado);
    }

    // 5️⃣ Tipo de salida válido y no existe para otro ID
    public function testVerificarTipoS2_TipoValidoNoExiste() {
        $tipoS = "MeriendaEspecial"; // Tipo que no exista
        $id = 10; // Cualquier ID
        $resultado = $this->objeto->verificarTipoS2($tipoS, $id);
        $this->assertEquals(['resultado' => 'ok'], $resultado);
    }


/// modificaR TIPO SALIDA///
    // 1️⃣ Datos vacíos
    public function testModificarTipoSalida_DatosVacios() {
        $resultado = $this->objeto->modificarTipoSalida("", "");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 2️⃣ Tipo de salida no válido
    public function testModificarTipoSalida_TipoInvalido() {
        $resultado = $this->objeto->modificarTipoSalida("Tipo123!", "1");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 3️⃣ ID no válido
    public function testModificarTipoSalida_IdInvalido() {
        $resultado = $this->objeto->modificarTipoSalida("Almuerzo", "abc");
        $this->assertEquals(['resultado' => 'Datos inválidos.'], $resultado);
    }

    // 4️⃣ Modificación exitosa
    public function testModificarTipoSalida_ModificacionExitosa() {
        $tipoS = "TipoSALIDA"; // Ajustar según tu BD
        $id = 5; // ID existente
        $resultado = $this->objeto->modificarTipoSalida($tipoS, $id);
        $this->assertEquals(['resultado' => 'Editado correctamente'], $resultado);
    }

    // 5️⃣ No se realizaron cambios
    public function testModificarTipoSalida_NoCambios() {
        $tipoS = "Salida Especial"; // mismo valor que ya tiene el registro
        $id = 8;
        $resultado = $this->objeto->modificarTipoSalida($tipoS, $id);
        $this->assertEquals(['resultado' => 'No se encontró el tipo de salida o no hubo cambios'], $resultado);
    }

   /// ANULAR TIPO SALIDA///
    // 1️⃣ ID vacío
    public function testAnularTipoSalida_IdVacio() {
        $resultado = $this->objeto->anularTipoSalida("");
        $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
    }

    // 2️⃣ ID no numérico
    public function testAnularTipoSalida_IdNoNumerico() {
        $resultado = $this->objeto->anularTipoSalida("abc");
        $this->assertEquals(['resultado' => 'ID inválido.'], $resultado);
    }

    // 3️⃣ Tipo de salida no existe
    public function testAnularTipoSalida_NoExiste() {
        $id = 999999; // ID que no exista
        $resultado = $this->objeto->anularTipoSalida($id);
        $this->assertEquals(['mensaje' => 'No se encontró el tipo de Salida'], $resultado);
    }

    // 4️⃣ Anulación exitosa
    public function testAnularTipoSalida_Exito() {
        $id = 6; // ID existente
        $resultado = $this->objeto->anularTipoSalida($id);
        $this->assertEquals(['resultado' => 'anulado correctamente.'], $resultado);
    }


}