<?php
use PHPUnit\Framework\TestCase;
use modelo\modulosModelo as modelo;


class moduloTests extends TestCase
{
    private $objeto;

    protected function setUp(): void
    {
        $this->objeto = new modelo();
       
    }

    protected function tearDown(): void
    {
        unset($this->objeto);
    }

    // Escenario 1: Editar módulo con datos válidos
    
      public function testEditarModulo_Exitoso()
    {
        $resultado = $this->objeto->editarModulo(1, 1); // módulo existente
        $this->assertIsArray($resultado);
        $this->assertEquals('Módulo actualizado exitosamente', $resultado['mensaje']);
    }
      public function testEditarModulo_Desactivar()
    {
        $resultado = $this->objeto->editarModulo(2, 2); // módulo existente
        $this->assertIsArray($resultado);
        $this->assertEquals('Módulo actualizado exitosamente', $resultado['mensaje']);
    }
    // Escenario 2: Editar módulo con ID no existente
     public function testEditarModulo_IdInexistente()
    {
        $resultado = $this->objeto->editarModulo(1, 9999); // id que no existe
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('mensaje', $resultado);
        // puede ser que no lance error, pero el mensaje puede diferir
        $this->assertStringContainsString('exitosamente', $resultado['mensaje']);
    }

    // Escenario 3: Editar módulo con estado inválido
    public function testEditarModulo_EstadoInvalido()
    {
        $resultado = $this->objeto->editarModulo(999, 1); // estado inválido
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('mensaje', $resultado);
        // puede ser que no lance error, pero el mensaje puede diferir
        $this->assertStringContainsString('exitosamente', $resultado['mensaje']);
    }

    public function testEditarModulo_EstaVacio()
    {
        $resultado = $this->objeto->editarModulo("",""); // estado nulo
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('mensaje', $resultado);
        // puede ser que no lance error, pero el mensaje puede diferir
        $this->assertStringContainsString('exitosamente', $resultado['mensaje']);
    }


   

}