<?php

use PHPUnit\Framework\TestCase;
use modelo\consultarAsistenciaModelo as consultarAsistencia;

class consultarAsistenciaTests extends TestCase {
    private $objeto;

    protected function setUp(): void {
        $this->objeto = new consultarAsistencia();
        
    }

    protected function tearDown(): void {
        unset($this->objeto);
    }

     public function testMostrarHorarios_FechaVacia() {
        $resultado = $this->objeto->mostrarHorarios("");
        $this->assertEquals('Fecha inválida.', $resultado['resultado']);
    }

     public function testMostrarHorarios_FechaInvalida() {
        $resultado = $this->objeto->mostrarHorarios("2025/09/10");
        $this->assertEquals('Fecha inválida.', $resultado['resultado']);
    }

     public function testMostrarHorarios_SeleccionarIgnoraValidacion() {
        $resultado = $this->objeto->mostrarHorarios("Seleccionar");
        $this->assertIsArray($resultado);
    }

    public function testMostrarHorarios_FechaValidaSinResultados() {
        $resultado = $this->objeto->mostrarHorarios("2025-09-25");
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado);
    }

     public function testMostrarHorarios_FechaValidaConResultados() {
        // Simula que existe asistencia para esa fecha
        $resultado = $this->objeto->mostrarHorarios("2025-09-11");
        $this->assertIsArray($resultado);
        if (!empty($resultado)) {
            $this->assertArrayHasKey('horarioComida', $resultado[0]);
        }
    }

 public function testMostrarAsistencia_HorarioVacio() {
        $resultado = $this->objeto->mostrarAsistencia("2025-09-10", "");
        $this->assertEquals('Horario de comida inválido', $resultado['resultado']);
    }

        public function testMostrarAsistencia_FechaVacia() {
        $resultado = $this->objeto->mostrarAsistencia("", "Cena");
        $this->assertEquals('Fecha inválida', $resultado['resultado']);
    }



     public function testMostrarAsistencia_FechaInvalida() {
        $resultado = $this->objeto->mostrarAsistencia("2025/09/10", "Almuerzo");
        $this->assertEquals('Fecha inválida', $resultado['resultado']);
    }

  

     public function testMostrarAsistencia_HorarioInvalido() {
        $resultado = $this->objeto->mostrarAsistencia("2025-09-10", "Meriendita");
        $this->assertEquals('Horario de comida inválido', $resultado['resultado']);
    }

       public function testMostrarAsistencia_SeleccionarAmbos() {
        $resultado = $this->objeto->mostrarAsistencia("Seleccionar", "Seleccionar");
        $this->assertIsArray($resultado);
    }

   public function testMostrarAsistencia_FechaYHorarioValidosSinResultados() {
        $resultado = $this->objeto->mostrarAsistencia("2025-09-27", "Cena");
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado);
    }

     public function testMostrarAsistencia_FechaValidaHorarioSeleccionar() {
        $resultado = $this->objeto->mostrarAsistencia("2025-09-11", "Seleccionar");
        $this->assertIsArray($resultado);
    }


     public function testMostrarAsistencia_HorarioValidoFechaSeleccionar() {
        $resultado = $this->objeto->mostrarAsistencia("Seleccionar", "Desayuno");
        $this->assertIsArray($resultado);
    }
    
     public function testMostrarAsistencia_FechaYHorarioValidosConResultados() {
        $resultado = $this->objeto->mostrarAsistencia("2025-09-11", "Almuerzo");
        $this->assertIsArray($resultado);
        if (!empty($resultado)) {
               $this->assertTrue(property_exists($resultado[0], 'cedEstudiante'));

        }
    }



}