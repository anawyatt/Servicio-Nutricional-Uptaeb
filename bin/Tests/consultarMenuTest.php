<?php /*
use PHPUnit\Framework\TestCase;
use modelo\consultarMenuModelo as consultarMenu;

class consultarMenuTest extends TestCase {

    protected function setUp(): void {
        $this->object = new consultarMenu();
        $_SESSION['cedula'] = '12345678';     
    }

    protected function tearDown(): void {
        unset($this->object);
    }
    

       // Prueba para datos erroneos (ingresar fecha de inicio mayor a la fecha fin)
        public function test_mostrarM_DatosError() {
        $resultado = $this->object->mostrarM('2024-11-10', '2024-11-5',  false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('La fecha de inicio no puede ser mayor que la fecha de fin', $resultado['resultado']);
        }

          // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_mostrarM_DatosErrorFormato() {
        $resultado = $this->object->mostrarM('2 de Novienbre del 2024', 
        '24 de noviemre del 2024', false);

        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        // Prueba para datos que no existen
        public function test_mostrarM_DatosNoExiste() {
        $resultado = $this->object->mostrarM('2023-01-01', '2023-04-02',
         false);
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado, "No existen datos registrados, Ingrese la fecha correctamente");
        }

            // Prueba para mostrar registros por filtro
        public function test_mostrarM_DatosExiste() {
        $resultado = $this->object->mostrarM('2024-10-21', '2024-11-05', 
        false);
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

        //-------------------- VERIFICAR EXISTENCIA DEL REGISTRO DE MENÚS -----------------
            // Prueba para datos vacíos
        public function test_verificarExistencia_DatosVacios() {
        $resultado = $this->object->verificarExistencia('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

          // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistencia_DatosErroneos() {
        $resultado = $this->object->verificarExistencia('g*5',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

             // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistencia_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistencia(50,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ya no existe', $resultado['resultado']);
        }
        
         // Prueba para datos que existen en la base de datos
        public function test_verificarExistencia_DatosExistenBD() {
        $resultado = $this->object->verificarExistencia(5,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si existe', $resultado['resultado']);
        }

        //-------------------- MOSTRAR INFORMACION DEL MENÚ -----------------
        // Prueba para datos vacios (no cumplen)
        public function test_menu_DatosVacios() {
        $resultado = $this->object->menu('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_menu_DatosErroneos() {
        $resultado = $this->object->menu('0o2',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        // Prueba para un usuario que no existe
        public function test_menu_DatosNoExiste() {
        $resultado = $this->object->menu('40', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        }

        // Prueba para un usuario existente
        public function test_menu_DatosExiste() {
        $resultado = $this->object->menu('5', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

          //-------------------- MOSTRAR INFORMACION DEL MENÚ - ALIMENTOS -----------------
        // Prueba para datos vacios (no cumplen)
        public function test_alimento_DatosVacios() {
        $resultado = $this->object->alimento('', '', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Tipo Alimento, Ingresar Menú', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_alimento_DatosErroneos() {
        $resultado = $this->object->alimento('0o2', 'P2', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Tipo Alimento, Ingresar Menú', $resultado['resultado']);
        }

        // Prueba para un usuario que no existe
        public function test_alimento_DatosNoExiste() {
        $resultado = $this->object->alimento('40', '34', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        }

        // Prueba para un usuario existente
        public function test_alimento_DatosExiste() {
        $resultado = $this->object->alimento('3', '3', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

        //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  CONSULTAR MENU ---------------
       // Prueba para datos vacíos
        public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->object->verificarExistenciaTipoA('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaTipoA('po00',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

             // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(50, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
        } 

          // Prueba para datos que existen en la base de datos
        public function test_verificarExistenciaTipoA_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaTipoA(2, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
        }

        //------------------ VERIFICAR EXISTENCIA ALIMENTO - CONSULTAR MENU ---------------------

                // Prueba para datos vacíos
        public function test_verificarExistenciaAlimento_DatosVacios() {
        $resultado = $this->object->verificarExistenciaAlimento('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        } 

                // Prueba para datos vacíos
        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaAlimento_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaAlimento('Man5o',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

        // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(70,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no esta', $resultado['resultado']);
        }

        // Prueba para datos que existen en la base de datos
        public function test_verificarExistenciaAlimento_DatosExistenBD() {
        $resultado = $this->object->verificarExistenciaAlimento(9,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si esta', $resultado['resultado']);
        } 

        //------------------ MOSTRAR ALIMENTO - CONSULTAR MENU ----------------------------------

        // Prueba para datos vacíos
        public function test_mostrarAlimento_DatosVacios() {
        $resultado = $this->object->mostrarAlimento('', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']); 
        }

           // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_mostrarAlimento_DatosErroneos() {
        $resultado = $this->object->mostrarAlimento('Dura129o',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
        }

          // Prueba para un  alimento que no existe
        public function test_mostrarAlimento_DatosNoExiste() {
        $resultado = $this->object->mostrarAlimento('78', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        } 

              // Prueba para un  alimento existente
        public function test_mostrarAlimento_DatosExiste() {
        $resultado = $this->object->mostrarAlimento('3', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        } 

        //------------------- INFORMACION DEL ALIMENTO - CONSULTAR MENU -------------------------
                // Prueba para datos vacíos
        public function test_infoAlimento_DatosVacios() {
        $resultado = $this->object->infoAlimento('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expesiones regulares)
        public function test_infoAlimento_DatosErroneos() {
        $resultado = $this->object->infoAlimento('9I0;',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
        }

            // Prueba para un la informacion del alimento que no existe
        public function test_infoAlimento_DatosNoExiste() {
        $resultado = $this->object->infoAlimento('75', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        }

            // Prueba para un  alimento existente
        public function test_infoAlimento_DatosExiste() {
        $resultado = $this->object->infoAlimento('2', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

          //------------------ VERIFICAR MODIFICAR - CONSULTAR MENU ---------------------

                // Prueba para datos vacíos
        public function test_verificarModificacion_DatosVacios() {
        $resultado = $this->object->verificarModificacion('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

           // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarModificacion_DatosErroneos() {
        $resultado = $this->object->verificarModificacion('5o',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

          // Prueba para datos inexistentes en la base de datos
        public function test_verificarModificacion_DatosNoExistenBD() {
        $resultado = $this->object->verificarModificacion(2,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('no se puede', $resultado['resultado']);
        }

        // Prueba para datos que existen en la base de datos
        public function test_verificarModificacion_DatosExistenBD() {
        $resultado = $this->object->verificarModificacion(7,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('se puede', $resultado['resultado']);
        } 

          //------------------- VALIDAR FECHA Y HORARIO -  MENU ---------------
            // Prueba para datos vacíos
        public function test_validarFH_DatosVacios() {
        $resultado = $this->object->validarFH('','','', false);
        $this->assertArrayHasKey('resultado', $resultado); 
        $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú, Seleccionar Menú', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_validarFH_DatosErroneos() {
        $resultado = $this->object->validarFH('11 de noviembre del 2024',
        'Almue23o', 'P23', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Fecha, Seleccionar Horario del Menú, Seleccionar Menú',
         $resultado['resultado']);
        }

           // Prueba para datos inexistentes en la base de datos
        public function test_validarFH_DatosNoExistenBD() {
        $resultado = $this->object->validarFH('2024-11-13', 'Almuerzo', '40', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('success', $resultado['resultado']);
        $this->assertEquals('No tiene un menú registrado para esa fecha y horario', $resultado['mensaje']);
        }

           // Prueba para datos que existen en la base de datos
          public function test_validarFH_DatosExistenBD() {
          $resultado = $this->object->validarFH('2024-11-20', 'Almuerzo', '3', false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('error', $resultado['resultado']);    
          $this->assertEquals('Ya tiene un menú registrado para esa fecha y horario', $resultado['mensaje']);
          }

           //------------------- MODIFICAR MENU -----------------

          // Prueba para datos vacíos
        public function test_modificarMenu_DatosVacios() {
        $resultado = $this->object->modificarMenu('', '', '', '','','',false);

        $this->assertArrayHasKey('resultado', $resultado);
    
        $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Salida Alimento', $resultado['resultado']);
        } 

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_modificarMenu_DatosErroneos() {
        $resultado = $this->object->modificarMenu('11 de noviembre del 2024', 'De432un9', 'p3o', 'a',
        'k2','0o0',false);

        $this->assertArrayHasKey('resultado', $resultado);
    
        $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
        $this->assertStringContainsString('Ingresar Descripción del Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Salida Alimento', $resultado['resultado']);
        } 

          //------------------- MODIFICAR DESTALLE SALIDA MENU -----------------    
        // Prueba para datos vacíos
        public function test_detalleSalidaM_DatosVacios() {
        $resultado = $this->object->detalleSalidaM('', '', '', '',false);

        $this->assertArrayHasKey('resultado', $resultado);

        $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Salida', $resultado['resultado']);
        } 

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)  
        public function test_detalleSalidaM_DatosErroneos() {
        $resultado = $this->object->detalleSalidaM('J3J', 'O0IK', 'POL02', 'PES2',false);

        $this->assertArrayHasKey('resultado', $resultado);

        $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
        $this->assertStringContainsString('Seleccionar Salida', $resultado['resultado']);
        } 

          //------------------- MODIFICAR MENU -----------------

        public function test_modificarMenuYDetalleSalidaMenu_DatosListos() {
    
        $feMenu = '2024-12-31';
        $horarioComida = 'Desayuno';
        $cantPlatos = 400;
        $descripcion = 'Menú de desayuno';
        $id = 6;
        $idSalidaA = 6;
    
        $resultado = $this->object->modificarMenu($feMenu, $horarioComida, $cantPlatos, $descripcion, $id,
        $idSalidaA, false);
    
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Menú Actualizado Exitosamente', $resultado['resultado']);
        $this->assertArrayHasKey('menuId', $resultado);
        $this->assertArrayHasKey('salidaId', $resultado);
    
        $menuId = $resultado['menuId'];
        $salidaId = $resultado['salidaId'];
    
        $alimentos = [
            ['alimento' => 2, 'cantidad' => 20],
            ['alimento' => 3, 'cantidad' => 20],
            ['alimento' => 4, 'cantidad' => 20]
        ];
    
        foreach ($alimentos as $item) {
            $detalleResultado = $this->object->detalleSalidaM($item['cantidad'], $menuId, $item['alimento'],
             $salidaId, false);
    
            $this->assertArrayHasKey('resultado', $detalleResultado);
            $this->assertEquals('modificado alimentos exitosamente', $detalleResultado['resultado']);
        }
    }

    //------------------ VERIFICAR ELIMINAR - CONSULTAR MENU ---------------------

                // Prueba para datos vacíos
          public function test_verificarAnulacion_DatosVacios() {
          $resultado = $this->object->verificarAnulacion('',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

           // Prueba para datos erróneos (no cumplen con las expresiones regulares)
          public function test_verificarAnulacion_DatosErroneos() {
          $resultado = $this->object->verificarAnulacion('09o',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

          // Prueba para datos inexistentes en la base de datos
          public function test_verificarAnulacion_DatosNoExistenBD() {
          $resultado = $this->object->verificarAnulacion(2,false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('no se puede', $resultado['resultado']);
          }

            // Prueba para datos que existen en la base de datos
          public function test_verificarAnulacion_DatosExistenBD() {
          $resultado = $this->object->verificarAnulacion(6,false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('se puede', $resultado['resultado']);
          } 

            // ------------------- ELIMINAR MENU ------------------------------------
          // Prueba para datos vacíos
          public function test_eliminarMenu_DatosVacios() {
          $resultado = $this->object->eliminarMenu('',false);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
          }

            // Prueba para datos erróneos (no cumplen con el patrón)
        public function test_eliminarMenu_DatosErroneos() {
        $resultado = $this->object->eliminarMenu('a04m',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Menú', $resultado['resultado']);
        }

        public function test_eliminarMenuListo(){
        $id = 6;

        $resultado = $this->object->eliminarMenu($id, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('eliminado', $resultado['resultado']);
        }


}   */
?>




