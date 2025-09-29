<?php 
use PHPUnit\Framework\TestCase;
use modelo\estudiantesModelo as estudiante;
use helpers\encryption;

class estudiantesTests extends TestCase {
    private $objeto;
    private $encryption;
    private $conex;

    public function setUp(): void {
    $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
    $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->objeto = new estudiante();
        $this->encryption = new encryption();
        $this->objeto = $this->getMockBuilder(estudiante::class)
            ->onlyMethods(['obtenercodigo'])
            ->getMock();
    }
 
// identificador encriptado de un estudiante existente
 public function testInfoStudy_DatosCorrectos()
    {
        $cedula = "1077554"; // cedula real que ya existe
        $idEncriptado = $this->encryption->encryptData($cedula);

        $resultado = $this->objeto->infoStudy($idEncriptado);

        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado, "Debería retornar datos del estudiante");
        $this->assertEquals($cedula, $resultado[0]->cedEstudiante);
    }

  
    public function testInfoStudy_DatosIncorrectos()
{
        $cedula = "99999999"; // cedula que no existe
        $idEncriptado = $this->encryption->encryptData($cedula);

        $resultado = $this->objeto->infoStudy($idEncriptado);

        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado, "Debería retornar vacío si la cédula no existe");
}

   public function testInfoStudy_IdInvalido()
{
    $idEncriptado = "cadena_invalida";

    $resultado = $this->objeto->infoStudy($idEncriptado);

    // Puede devolver false o array vacío, ambos son válidos
    $this->assertTrue($resultado === false || $resultado === [], "Si el ID no es válido debería devolver false o array vacío");
}


// Pruebas para el método verificarCodigo con diferentes escenarios CODIDO DE SEGURIDAD PARA REGISTRAR LA DATA
public function testVerificarCodigo_DatosVacios()
{
    // Simulamos que obtenercodigo devuelve un array vacío
    $this->objeto->method('obtenercodigo')->willReturn([]);

    $resultado = $this->objeto->verificarCodigo("", "");
    $this->assertFalse($resultado, "Con datos vacíos debería retornar false");
}

public function testVerificarCodigo_DatosIncorrectos_CedulaYCodigo()
{
    // Simulamos que no se encontró usuario en DB
    $this->objeto->method('obtenercodigo')->willReturn([]);

    $resultado = $this->objeto->verificarCodigo("ClaveIncorrecta", "99999999");
    $this->assertFalse($resultado, "Con cédula y código incorrectos debería retornar false");
}


public function testVerificarCodigo_DatosIncorrectos_SoloCodigo()
{
    // Generamos un hash de la clave real
    $hash = password_hash("Uptaeb123*", PASSWORD_DEFAULT);

    // Mock: el usuario existe pero se pasa código incorrecto
    $this->objeto->method('obtenercodigo')->willReturn([
        (object)["clave" => $hash]
    ]);

    $resultado = $this->objeto->verificarCodigo("ClaveIncorrecta", "12345678");
    $this->assertFalse($resultado, "Con código incorrecto debería retornar false");
}

 public function testVerificarCodigo_Correcto()
{
    $hash = password_hash("Uptaeb123*", PASSWORD_DEFAULT);

    $this->objeto->method('obtenercodigo')->willReturn([
        (object)["clave" => $hash]
    ]);

    $resultado = $this->objeto->verificarCodigo("Uptaeb123*", "12345678");
    $this->assertTrue($resultado, "El código correcto debería validar en true");
}

// Pruebas para el método registrarEstudiante con diferentes escenarios

public function testRegistrarEstudiante_DatosVacios()
{
    $resultado = $this->objeto->registrarEstudiante(
        '', '', '', '', '', '', '', '', '', [], ''
    );

    $this->assertIsString($resultado);
    $this->assertStringContainsString('faltan datos', strtolower($resultado));
}

public function testRegistrarEstudiante_DatosIncorrectos(): void
{
    $resultado = $this->objeto->registrarEstudiante(
        'ABC123', 'Maria123', '', 'Perez', '',
        'X', '0412XXXXXX', '', 'Administración',
        ['Seccion!@'], 'Lunes'
    );

    $this->assertIsString($resultado);
    $this->assertStringContainsStringIgnoringCase('dato inválido', $resultado);
}


public function testRegistrarEstudianteConSeccionYHorario(): void
{
    // 👉 Llamamos solo al método público
    $resultado = $this->objeto->registrarEstudiante(
        '29972123', 'Maria', 'Jose', 'Perez', 'Gomez',
        'F', '0412-1510342', 'Barquisimeto', 'Administración',
        ['SeccionTest'], 'Martes'
    );

    // 🔹 Verificamos el resultado
    $this->assertIsString($resultado);
    $this->assertStringContainsString('registrado', $resultado);

    // ✅ Verificar estudiante
    $stmt = $this->conex->prepare("SELECT * FROM estudiante WHERE cedEstudiante = ?");
    $stmt->execute(['29972123']);
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($estudiante);
    $this->assertSame('Maria', $estudiante['nombre']);               // antes: assertEquals
    $this->assertSame('Administración', $estudiante['carrera']);     // antes: assertEquals

    // ✅ Verificar sección
    $stmt = $this->conex->prepare("SELECT COUNT(*) FROM seccion WHERE seccion = 'SeccionTest'");
    $stmt->execute();
    $this->assertGreaterThan(0, (int)$stmt->fetchColumn());

    // ✅ Verificar horario
    $stmt = $this->conex->prepare("
        SELECT COUNT(*) FROM horario h 
        INNER JOIN seccion s ON h.idSeccion = s.idSeccion
        WHERE h.dia = 'Martes' AND s.seccion = 'SeccionTest'
    ");
    $stmt->execute();
    $this->assertGreaterThan(0, (int)$stmt->fetchColumn());

    // ✅ Verificar relación estudiante-sección
    $stmt = $this->conex->prepare("SELECT COUNT(*) FROM estudiante_seccion WHERE cedEstudiante = ?");
    $stmt->execute(['29972123']);
    $this->assertGreaterThan(0, (int)$stmt->fetchColumn());
}

public function testRegistrarEstudianteExistenteActualiza(): void
{
    // 👉 Insertamos estudiante inicial
    $this->objeto->registrarEstudiante(
        '99999999', 'Pedro', 'Luis', 'Martinez', 'Diaz',
        'M', '0412-1510341', 'Barquisimeto', 'Informática',
        ['SeccionTest'], 'Lunes'
    );

    // 👉 Registramos de nuevo el mismo estudiante con datos modificados
    $resultado = $this->objeto->registrarEstudiante(
        '99999999', 'Pedroactualizado', 'Luis', 'Martinez', 'Diaz',
        'M', '0412-1599231', 'Cabudare', 'Sistemas',
        ['SeccionTest'], 'Miercoles'
    );

    // ✅ Validar que devuelve el mensaje esperado
    $this->assertIsString($resultado);
    $this->assertStringContainsString('actualizada', $resultado);

    // ✅ Verificar actualización en BD
    $stmt = $this->conex->prepare("SELECT * FROM estudiante WHERE cedEstudiante = ?");
    $stmt->execute(['99999999']);
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($estudiante);
    $this->assertSame('Pedroactualizado', $estudiante['nombre']);
    $this->assertSame('0412-1599231', $estudiante['telefono']);
    $this->assertSame('Cabudare', $estudiante['nucleo']);
    $this->assertSame('Sistemas', $estudiante['carrera']);

    // ✅ Verificar que la sección existe
    $stmt = $this->conex->prepare("SELECT COUNT(*) FROM seccion WHERE seccion = 'SeccionTest'");
    $stmt->execute();
    $this->assertGreaterThan(0, (int)$stmt->fetchColumn());

    // ✅ Verificar que el horario fue actualizado a "Miercoles"
    $stmt = $this->conex->prepare("
        SELECT COUNT(*) FROM horario h 
        INNER JOIN seccion s ON h.idSeccion = s.idSeccion
        INNER JOIN estudiante_seccion es ON s.idSeccion = es.idSeccion
        WHERE h.dia = 'Miercoles' AND es.cedEstudiante = ?
    ");
    $stmt->execute(['99999999']);
    $this->assertGreaterThan(0, (int)$stmt->fetchColumn());
}


}
  