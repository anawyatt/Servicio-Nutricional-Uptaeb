<?php

use PHPUnit\Framework\TestCase;
use modelo\asistenciaModelo as asistencia;

class asistenciaTests extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new asistencia();

        $this->objeto = $this->getMockBuilder(asistencia::class)
            ->onlyMethods(['obtenercodigo'])
            ->getMock();
        
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }
    /*

    // <-- Funcion 1
    public function testInfoStudy_CedulaVacia() {
        $cedula = ""; 
        $resultado = $this->objeto->infoStudy($cedula);

        $this->assertIsArray($resultado, "Debe retornar un array");
        $this->assertArrayHasKey('error', $resultado, "Debe contener la clave 'error'");
        $this->assertEquals('Ingresar una cédula válida', $resultado['error']);
    }

 
    public function testInfoStudy_CedulaValidaNoRegistrada() {
        $cedula = "999999199"; // <-- Cédula que no existe en la BD
        $resultado = $this->objeto->infoStudy($cedula);

        $this->assertIsArray($resultado, "Debe retornar un array");
        $this->assertEmpty($resultado, "Debe retornar array vacío si la cédula no existe");
    }

 
    public function testInfoStudy_CedulaInvalida() {
        $cedula = "abc123"; // <-- Cédula inválida
        $resultado = $this->objeto->infoStudy($cedula);

        $this->assertIsArray($resultado, "Debe retornar un array de error");
        $this->assertArrayHasKey('error', $resultado, "Debe contener clave 'error'");
        $this->assertEquals('Ingresar una cédula válida', $resultado['error']);
    }

      public function testInfoStudy_CedulaValidaRegistrada() {
        $cedula = "1279543"; // <-- Asegúrate que existe en tu BD real
        $resultado = $this->objeto->infoStudy($cedula);

        $this->assertIsArray($resultado, "Debe retornar un array");
        $this->assertNotEmpty($resultado, "Debe retornar datos si la cédula existe");
        $this->assertEquals($cedula, $resultado[0]['cedEstudiante']);
    }
    */
    /*
    // Id MENU HORARIO DE COMIDAS
      public function testObtenerIdMenu_HorarioVacio() {
    $horario = ""; // vacio
    $resultado = $this->objeto->obtenerIdMenu($horario);
    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertEmpty($resultado, "Debe retornar array vacío si el horario esta Vacio");
    }

    public function testObtenerIdMenu_HorarioValidoNoExiste() {
    $horario = "Merienda"; // Asegúrate que no esté cargado para hoy
    $resultado = $this->objeto->obtenerIdMenu($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertEmpty($resultado, "Debe retornar array vacío si el horario no existe");
}

    public function testObtenerIdMenu_HorarioInvalido() {
        $horario = "INVALIDO";
        $resultado = $this->objeto->obtenerIdMenu($horario);

        $this->assertIsArray($resultado, "Debe retornar un array");
        $this->assertEmpty($resultado, "Debe retornar array vacío si el horario es inválido");
    }

    public function testObtenerIdMenu_HorarioValidoExiste() {
    $horario = "Desayuno"; // Debe existir en menu para hoy
    $resultado = $this->objeto->obtenerIdMenu($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertNotEmpty($resultado, "Debe retornar datos si el horario existe");
    $this->assertArrayHasKey('idMenu', $resultado[0], "Debe contener la clave idMenu"); 
    }
  */
    /*
    //Platos Disponibles

    public function testPlatosDisponibles_HorarioValidoConDatos() {
    $horario = "Desayuno"; // Asegúrate que exista en BD
    $resultado = $this->objeto->platosDisponibles($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertNotEmpty($resultado, "Debe retornar datos si el horario existe");
    $this->assertArrayHasKey('platosDisponibles', $resultado[0], "Debe contener la clave platosDisponibles");
}

public function testPlatosDisponibles_HorarioValidoSinDatos() {
    $horario = "Merienda"; // Asegúrate que no esté cargado en BD
    $resultado = $this->objeto->platosDisponibles($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertEmpty($resultado, "Debe retornar array vacío si no existen platos para el horario");
}

public function testPlatosDisponibles_HorarioInvalido() {
    $horario = "INVALIDO";
    $resultado = $this->objeto->platosDisponibles($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertArrayHasKey('resultado', $resultado, "Debe retornar un mensaje de error");
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}

public function testPlatosDisponibles_HorarioVacio() {
    $horario = "";
    $resultado = $this->objeto->platosDisponibles($horario);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertArrayHasKey('resultado', $resultado, "Debe retornar un mensaje de error");
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}
*/
/*

public function testVerificarAsistencia_HorarioVacio() {
    $resultado = $this->objeto->verificarAsistenciaEstudiante("", "12345678");

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}

public function testVerificarAsistencia_CedulaVacia() {
    $resultado = $this->objeto->verificarAsistenciaEstudiante("Almuerzo", "");

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Cedula de estudiante inválido.', $resultado['resultado']);
}

public function testVerificarAsistencia_HorarioInvalido() {
    $resultado = $this->objeto->verificarAsistenciaEstudiante("INVALIDO", "12345678");

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}

public function testVerificarAsistencia_CedulaInvalida() {
    $resultado = $this->objeto->verificarAsistenciaEstudiante("Almuerzo", "ABC123");

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('Cedula de estudiante inválido.', $resultado['resultado']);
}

public function testVerificarAsistencia_EstudianteConAsistencia() {
    $cedula = "1279543"; // 🔹 asegúrate que exista con asistencia hoy
    $resultado = $this->objeto->verificarAsistenciaEstudiante("Desayuno", $cedula);

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('ya ingreso al comedor', $resultado['resultado']);
}

public function testVerificarAsistencia_EstudianteSinAsistencia() {
    $cedula = "12345678"; // 🔹 cédula real registrada, pero sin asistencia hoy
    $resultado = $this->objeto->verificarAsistenciaEstudiante("Almuerzo", $cedula);

    $this->assertIsArray($resultado);
    $this->assertArrayHasKey('resultado', $resultado);
    $this->assertEquals('no ha ingresado al comedor', $resultado['resultado']);
}
*/
/*

public function testVerificarPorHorario_CedulaInvalida() {
    $resultado = $this->objeto->verificarPorHorario("ABC123");
    $this->assertIsArray($resultado);
    $this->assertEquals("cedula de estudiante inválido.", $resultado['resultado']);
}

public function testVerificarPorHorario_CedulaVacia() {
    $resultado = $this->objeto->verificarPorHorario("");
    $this->assertIsArray($resultado);
    $this->assertEquals("cedula de estudiante inválido.", $resultado['resultado']);
}

public function testVerificarPorHorario_PuedeComer() {
    // Usa una cédula real registrada con horario en el mismo día actual
    $cedula = "1077554"; 
    $resultado = $this->objeto->verificarPorHorario($cedula);

    $this->assertIsArray($resultado);
    $this->assertEquals("puede comer", $resultado['resultado']);
}

public function testVerificarPorHorario_NoPuedeComer() {
    // Usa una cédula real registrada, pero cuyo horario NO corresponde al día actual
    $cedula = "98562699"; 
    $resultado = $this->objeto->verificarPorHorario($cedula);

    $this->assertIsArray($resultado);
    $this->assertEquals("no puede comer", $resultado['resultado']);
}

public function testVerificarPorHorario_SinHorario() {
    // Cédula real de estudiante registrado pero sin sección/horario asignado
    $cedula = "985623699";
    $resultado = $this->objeto->verificarPorHorario($cedula);

    $this->assertIsArray($resultado);
    $this->assertEquals("no puede comer", $resultado['resultado']);
}
*/

///REGISTRO
/*
public function testRegistrarAsistencia_CedulaInvalida() {
    $resultado = $this->objeto->registrarAsistencia("ABC123", "1");
    $this->assertIsArray($resultado);
    $this->assertEquals("error", $resultado['resultado']);
    $this->assertEquals("Cédula inválida", $resultado['mensaje']);
}

public function testRegistrarAsistencia_CedulaVacia() {
    $resultado = $this->objeto->registrarAsistencia("", "1");
    $this->assertIsArray($resultado);
    $this->assertEquals("error", $resultado['resultado']);
    $this->assertEquals("Cédula inválida", $resultado['mensaje']);
}

public function testRegistrarAsistencia_IdMenuInvalido() {
    $resultado = $this->objeto->registrarAsistencia("11203224", "ABC");
    $this->assertIsArray($resultado);
    $this->assertEquals("error", $resultado['resultado']);
    $this->assertEquals("ID de menú inválido", $resultado['mensaje']);
}

public function testRegistrarAsistencia_IdMenuVacio() {
    $resultado = $this->objeto->registrarAsistencia("11203224", "");
    $this->assertIsArray($resultado);
    $this->assertEquals("error", $resultado['resultado']);
    $this->assertEquals("ID de menú inválido", $resultado['mensaje']);
}

public function testRegistrarAsistencia_RegistroExitoso() {
    // Cédula válida y menú existente en tu BD de pruebas
    $cedula = "3338103";
    $idmenu = "5";

    $resultado = $this->objeto->registrarAsistencia($cedula, $idmenu);

    $this->assertIsArray($resultado);
    $this->assertEquals("registro exitoso", $resultado['resultado']);
}
*/

/*
 public function testVerificarCodigo_Correcto()
{
    $hash = password_hash("Uptaeb123*", PASSWORD_DEFAULT);

    $this->objeto->method('obtenercodigo')->willReturn([
        (object)["clave" => $hash]
    ]);

    $resultado = $this->objeto->verificarCodigo("Uptaeb123*", "12345678");
    $this->assertTrue($resultado, "El código correcto debería validar en true");
}



public function testVerificarCodigo_DatosVacios()
{
    // Simulamos que obtenercodigo devuelve un array vacío
    $this->objeto->method('obtenercodigo')->willReturn([]);

    $resultado = $this->objeto->verificarCodigo("", "");
    $this->assertEquals(
    ['resultado' => 'El código es invalido'],
    $resultado,
    "Con datos vacíos debería retornar mensaje de error"
);

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


*/
///// VERIFICAR CEDULA EXECCION 1
/*
public function testVerificarCedula_CedulaVacia() {
    $resultado = $this->objeto->verificarCedula("");
    $this->assertIsArray($resultado);
    $this->assertEquals("Cédula inválida.", $resultado['resultado']);
}

public function testVerificarCedula_CedulaInvalida() {
    $resultado = $this->objeto->verificarCedula("ABC123");
    $this->assertIsArray($resultado);
    $this->assertEquals("Cédula inválida.", $resultado['resultado']);
}

public function testVerificarCedula_CedulaRegistrada() {
    // Cédula existente en la base de datos de pruebas
    $cedula = "3187982";
    $resultado = $this->objeto->verificarCedula($cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals("error Cedula", $resultado['resultado']);
}

public function testVerificarCedula_CedulaNoRegistrada() {
    // Cédula que no existe en la base de datos de pruebas
    $cedula = "99999999";
    $resultado = $this->objeto->verificarCedula($cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals("Cedula no registrada", $resultado['resultado']);
}
*/
///SECICION
/*
public function testMostrarHorarios_DatosVacios()
{
    $seccion = ""; // valor vacío
    $resultado = $this->objeto->mostrarHorarios($seccion);

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertEmpty($resultado, "Sección vacía debería retornar array vacío");
}

public function testMostrarHorarios_SeccionInvalida()
{
    $seccion = "ABC"; // valor no numérico
    if (!preg_match("/^\d+$/", $seccion)) {
        $resultado = ['error' => 'Sección inválida'];
    } else {
        $resultado = $this->objeto->mostrarHorarios($seccion);
    }

    $this->assertIsArray($resultado, "Debe retornar un array");
    $this->assertArrayHasKey('error', $resultado, "Debe contener mensaje de error por sección inválida");
    $this->assertEquals('Sección inválida', $resultado['error']);
}



public function testMostrarHorarios_SeccionSinHorarios() {
    $idSeccion = 999; // ID de sección existente pero sin horarios
    $resultado = $this->objeto->mostrarHorarios($idSeccion);

    $this->assertIsArray($resultado);
    $this->assertEmpty($resultado, "La sección no tiene horarios y debería devolver array vacío");
}

public function testMostrarHorarios_SeccionNoExistente() {
    $idSeccion = 123456; // ID que no existe
    $resultado = $this->objeto->mostrarHorarios($idSeccion);

    $this->assertIsArray($resultado);
    $this->assertEmpty($resultado, "Sección no existente debería devolver array vacío");
}

public function testMostrarHorarios_SeccionConHorarios() {
    $idSeccion = 1; // ID de sección existente en la base de datos de pruebas
    $resultado = $this->objeto->mostrarHorarios($idSeccion);

    $this->assertIsArray($resultado);
    $this->assertNotEmpty($resultado, "La sección existe y debería devolver horarios");
    $this->assertArrayHasKey('horario', (array)$resultado[0], "Debe contener el campo 'horario'");

}

*/
// rEGISTRO DE estudiante eXXICION 
/*

public function testRegistrarStudyExcepcion1_DatosVacios()
{
    $resultado = $this->objeto->registrarStudyExcepcion1(
        '', '', '', '', '', '', '', '', ''
    );

    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion1_CedulaInvalida()
{
    $resultado = $this->objeto->registrarStudyExcepcion1(
        'ABC123', 'Juan', 'Perez', 'M', 'Nucleo1', 'Carrera1', 1, 2, 'Justificativo'
    );

    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion1_NombreApellidoInvalido()
{
    $resultado = $this->objeto->registrarStudyExcepcion1(
        '1234567', 'Juan123', 'Perez!', 'M', 'Nucleo1', 'Carrera1', 1, 2, 'Justificativo'
    );

    $this->assertIsArray($resultado);
    $this->assertEquals('Nombre o apellido inválido', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion1_JustificativoDemasiadoLargo()
{
    $longJustificativo = str_repeat('A', 1001);
    $resultado = $this->objeto->registrarStudyExcepcion1(
        '1234567', 'Juan', 'Perez', 'M', 'Nucleo1', 'Carrera1', 1, 2, $longJustificativo
    );

    $this->assertIsArray($resultado);
    $this->assertEquals('Justificativo demasiado largo', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion1_SeccionInexistente()
{
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('La sección 9999 no existe.');

    $this->objeto->registrarStudyExcepcion1(
        '1234567', 'Juan', 'Perez', 'M', 'Nucleo1', 'Carrera1', 9999, 8888, 'Justificativo'
    );
}

public function testRegistrarStudyExcepcion1_RegistroCorrecto()
{
    $resultado = $this->objeto->registrarStudyExcepcion1(
        '29972192', 'Samuel', 'Perez', 'M', 'Moran', 'Informatica', 1, 2, 'Justificativo válido'
    );

    $this->assertIsArray($resultado);
    $this->assertEquals('registro del Estudiante', $resultado['resultado']);
}

public function testRegistrarStudyExcepcion1_DosSecciones()
{
    // Datos válidos
    $cedula = '17654321';
    $nombre = 'Ana';
    $apellido = 'Gomez';
    $sexo = 'F';
    $nucleo = 'Nucleo1';
    $carrera = 'Carrera1';
    $seccion1 = 1; // debe existir en la tabla seccion
    $seccion2 = 2; // también debe existir
    $justificativo = 'Justificativo válido';

    // Ejecutar la función
    $resultado = $this->objeto->registrarStudyExcepcion1(
        $cedula, $nombre, $apellido, $sexo, $nucleo, $carrera, $seccion1, $seccion2, $justificativo
    );

    // Validaciones
    $this->assertIsArray($resultado);
    $this->assertEquals('registro del Estudiante', $resultado['resultado']);


}
*/

 ///------------------ EXCEPCION 2 ----------///
 /*
public function testVerificarExistenciaEstudiante_CedulaVacia()
{
    $resultado = $this->objeto->verificarExistenciaEstudiante('');
    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida.', $resultado['resultado']);
}

public function testVerificarExistenciaEstudiante_CedulaInvalida()
{
    $resultado = $this->objeto->verificarExistenciaEstudiante('ABC123');
    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida.', $resultado['resultado']);
}
public function testVerificarExistenciaEstudiante_Existe()
{
    $cedula = '1077554'; // cédula existente
    $resultado = $this->objeto->verificarExistenciaEstudiante($cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals('exito', $resultado['resultado']);
}

public function testVerificarExistenciaEstudiante_NoExiste()
{
    $cedula = '999999939'; // cédula no registrada
    $resultado = $this->objeto->verificarExistenciaEstudiante($cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals('error Cedula', $resultado['resultado']);
}
    */
 ///------------------ Verificar HORAIO Y ENTRADA SI YA PASO EL ESTUDIANTE 2 ----------///
 /*
 public function testVerificarAsistenciaEstudiante2_HorarioVacio()
{
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('', '10883680');
    $this->assertIsArray($resultado);
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}

public function testVerificarAsistenciaEstudiante2_CedulaVacia()
{
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('Desayuno', '');
    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida.', $resultado['resultado']);
}

public function testVerificarAsistenciaEstudiante2_HorarioYCedulaVacios()
{
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('', '');
    $this->assertIsArray($resultado);
    // Prioriza la validación del horario primero
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}


public function testVerificarAsistenciaEstudiante2_HorarioInvalido()
{
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('Snack', '10883680');
    $this->assertIsArray($resultado);
    $this->assertEquals('Horario de comida inválido.', $resultado['resultado']);
}
public function testVerificarAsistenciaEstudiante2_CedulaInvalida()
{
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('Desayuno', 'ABC123');
    $this->assertIsArray($resultado);
    $this->assertEquals('Cédula inválida.', $resultado['resultado']);
}

public function testVerificarAsistenciaEstudiante2_AlumnoIngreso()
{
    $cedula = '1077554'; // cédula registrada con asistencia hoy
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('Cena', $cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals('ya ingreso al comedor2', $resultado['resultado']);
}
public function testVerificarAsistenciaEstudiante2_AlumnoNoIngreso()
{
    $cedula = '1077554'; // cédula válida pero sin registro hoy
    $resultado = $this->objeto->verificarAsistenciaEstudiante2('Almuerzo', $cedula);
    $this->assertIsArray($resultado);
    $this->assertEquals('no ingreso al comedor', $resultado['resultado']);
}
*/


///////////////////////REGISTRO ASISTENCIA2 //////////////////////////////////////////////////

public function testRegistrarStudyExcepcion2_CedulaVacia()
{
    $resultado = $this->objeto->registrarStudyExcepcion2("", "5", "Motivo");
    $this->assertEquals('error', $resultado['resultado']);
    $this->assertEquals('Cédula inválida', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion2_IdMenuVacio()
{
    $resultado = $this->objeto->registrarStudyExcepcion2("1077554", "", "Motivo");
    $this->assertEquals('error', $resultado['resultado']);
    $this->assertEquals('ID de menú inválido', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion2_JustificativoVacio()
{
    $resultado = $this->objeto->registrarStudyExcepcion2("1077554", "5", "");
    $this->assertEquals('registro del Estudiante', $resultado['resultado']);
}


public function testRegistrarStudyExcepcion2_CedulaInvalida()
{
    $resultado = $this->objeto->registrarStudyExcepcion2("abc123", "5", "Motivo");
    $this->assertEquals('error', $resultado['resultado']);
    $this->assertEquals('Cédula inválida', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion2_IdMenuInvalido()
{
    $resultado = $this->objeto->registrarStudyExcepcion2("1077554", "0", "Motivo");
    $this->assertEquals('error', $resultado['resultado']);
    $this->assertEquals('ID de menú inválido', $resultado['mensaje']);
}

public function testRegistrarStudyExcepcion2_JustificativoLargo()
{
    $textoLargo = str_repeat("A", 260);
    $resultado = $this->objeto->registrarStudyExcepcion2("12345678", "2", $textoLargo);
    $this->assertEquals('error', $resultado['resultado']);
    $this->assertEquals('Justificativo demasiado largo', $resultado['mensaje']);
}


/*
public function testRegistrarStudyExcepcion2_RegistroExitoso()
{
    // Simular valores válidos
    $resultado = $this->objeto->registrarStudyExcepcion2("1088368", "3", "Motivo válido");
    
    $this->assertIsArray($resultado);
    $this->assertEquals('registro del Estudiante', $resultado['resultado']);
}
*/








}
