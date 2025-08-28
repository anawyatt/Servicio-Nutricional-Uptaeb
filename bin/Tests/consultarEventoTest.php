<?php /*
use PHPUnit\Framework\TestCase;
use modelo\consultarEventosModelo as consultarEventos;

class consultarEventoTest extends TestCase {

    protected function setUp(): void {
        $this->object = new consultarEventos();
        $_SESSION['cedula'] = '12345678';     
    }

    protected function tearDown(): void {
        unset($this->object);
    }

        //-------------------- BUSCAR EVENTO PO FILTRO -----------------

        // Prueba para datos erroneos (ingresar fecha de inicio mayor a la fecha fin)
        public function test_mostrarE_DatosError() {
        $resultado = $this->object->mostrarE('2024-11-20', '2024-11-11',  false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('La fecha de inicio no puede ser mayor que la fecha de fin', 
        $resultado['resultado']);
        }

            // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_mostrarE_DatosErrorFormato() {
        $resultado = $this->object->mostrarE('2 de diciembre del 2024', 
        '24 de noviembre del 2024', false);
    
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        // Prueba para datos que no existen
        public function test_mostrarE_DatosNoExiste() {
        $resultado = $this->object->mostrarE('2022-01-01', '2023-07-02',false);
        $this->assertIsArray($resultado);
        $this->assertEmpty($resultado, "No existen datos registrados, Ingrese la fecha correctamente");
        }

         // Prueba para mostrar registros por filtro
        public function test_mostrarE_DatosExiste() {
        $resultado = $this->object->mostrarE('2024-10-10', '2024-11-12',  false);
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        } 

        //-------------------- VERIFICAR EXISTENCIA DEL REGISTRO DE EVENTOS -----------------
            // Prueba para datos vacíos
        public function test_verificarExistencia_DatosVacios() {
        $resultado = $this->object->verificarExistencia('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistencia_DatosErroneos() {
        $resultado = $this->object->verificarExistencia('P-4',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

         // Prueba para datos inexistentes en la base de datos
        public function test_verificarExistencia_DatosNoExistenBD() {
        $resultado = $this->object->verificarExistencia(210,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('ya no existe', $resultado['resultado']);
        }

         // Prueba para datos que existen en la base de datos
        public function test_verificarExistencia_DatosExistenBD() {
        $resultado = $this->object->verificarExistencia(7,false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('si existe', $resultado['resultado']);
        }

          //-------------------- MOSTRAR INFORMACION DEL EVENTO -----------------
        // Prueba para datos vacios (no cumplen)
        public function test_evento_DatosVacios() {
        $resultado = $this->object->evento('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_evento_DatosErroneos() {
        $resultado = $this->object->evento('PX0',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }  
        
           // Prueba para un usuario que no existe
        public function test_evento_DatosNoExiste() {
        $resultado = $this->object->evento('70', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        }

           // Prueba para un usuario existente
        public function test_evento_DatosExiste() {
        $resultado = $this->object->evento('7', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

          //-------------------- MOSTRAR INFORMACION DEL EVENTO - ALIMENTOS -----------------
        // Prueba para datos vacios (no cumplen)
        public function test_alimento_DatosVacios() {
        $resultado = $this->object->alimento('', '', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Tipo Alimento, Ingresar Evento', $resultado['resultado']);
        }

         // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_alimento_DatosErroneos() {
        $resultado = $this->object->alimento('0p2', 'S2', false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar Tipo Alimento, Ingresar Evento', $resultado['resultado']);
        }

            // Prueba para un usuario que no existe
        public function test_alimento_DatosNoExiste() {
        $resultado = $this->object->alimento('450', '134', false);
        $this->assertIsArray($resultado);
        $this->assertCount(0, $resultado); 
        }

             // Prueba para un evento existente
        public function test_alimento_DatosExiste() {
        $resultado = $this->object->alimento('3', '7', false); 
        $this->assertIsArray($resultado);
        $this->assertNotEmpty($resultado);
        }

           //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  CONSULTAR EVENTO ---------------
            // Prueba para datos vacíos
        public function test_verificarExistenciaTipoA_DatosVacios() {
        $resultado = $this->object->verificarExistenciaTipoA('',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        } 

        // Prueba para datos erróneos (no cumplen con las expresiones regulares)
        public function test_verificarExistenciaTipoA_DatosErroneos() {
        $resultado = $this->object->verificarExistenciaTipoA('fs7w',false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

         // Prueba para datos inexistentes en la base de datos
            public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
            $resultado = $this->object->verificarExistenciaTipoA(76, false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no esta', $resultado['resultado']);
            } 

                  // Prueba para datos que existen en la base de datos
            public function test_verificarExistenciaTipoA_DatosExistenBD() {
            $resultado = $this->object->verificarExistenciaTipoA(1, false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('si esta', $resultado['resultado']);
            } 

            //------------------ VERIFICAR EXISTENCIA ALIMENTO - CONSULTAR EVENTO ---------------------
                // Prueba para datos vacíos
            public function test_verificarExistenciaAlimento_DatosVacios() {
            $resultado = $this->object->verificarExistenciaAlimento('',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
            } 

                   // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_verificarExistenciaAlimento_DatosErroneos() {
            $resultado = $this->object->verificarExistenciaAlimento('Man5o9A',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
            }

             // Prueba para datos inexistentes en la base de datos
            public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
            $resultado = $this->object->verificarExistenciaAlimento(40,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no esta', $resultado['resultado']);
            }
   
              // Prueba para datos que existen en la base de datos
            public function test_verificarExistenciaAlimento_DatosExistenBD() {
            $resultado = $this->object->verificarExistenciaAlimento(5,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('si esta', $resultado['resultado']);
            }
            
            //------------------ MOSTRAR ALIMENTO - CONSULTAR EVENTO ----------------------------------

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
            $resultado = $this->object->mostrarAlimento('105', false);
            $this->assertIsArray($resultado);
            $this->assertCount(0, $resultado); 
            } 

             
                // Prueba para un  alimento existente
            public function test_mostrarAlimento_DatosExiste() {
            $resultado = $this->object->mostrarAlimento('5', false); 
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
            $resultado = $this->object->infoAlimento('3o5;',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
            }

                // Prueba para un la informacion del alimento que no existe
            public function test_infoAlimento_DatosNoExiste() {
            $resultado = $this->object->infoAlimento('721', false);
            $this->assertIsArray($resultado);
            $this->assertCount(0, $resultado); 
            }

             // Prueba para un  alimento existente
            public function test_infoAlimento_DatosExiste() {
            $resultado = $this->object->infoAlimento('1', false); 
            $this->assertIsArray($resultado);
            $this->assertNotEmpty($resultado);
            }

            //------------------ VERIFICAR MODIFICAR - CONSULTAR MENU ---------------------

                // Prueba para datos vacíos
            public function test_verificarModificacion_DatosVacios() {
            $resultado = $this->object->verificarModificacion('',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            }

             // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_verificarModificacion_DatosErroneos() {
            $resultado = $this->object->verificarModificacion('5o',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            } 

               // Prueba para datos inexistentes en la base de datos
            public function test_verificarModificacion_DatosNoExistenBD() {
            $resultado = $this->object->verificarModificacion(1,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no se puede', $resultado['resultado']);
            }

             // Prueba para datos que existen en la base de datos
            public function test_verificarModificacion_DatosExistenBD() {
            $resultado = $this->object->verificarModificacion(7,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('se puede', $resultado['resultado']);
            } 
            
              //------------------- VALIDAR FECHA Y HORARIO -  EVENTO ---------------
            // Prueba para datos vacíos
            public function test_validarFH_DatosVacios() {
            $resultado = $this->object->validarFH('','','', false);
            $this->assertArrayHasKey('resultado', $resultado); 
            $this->assertEquals('Ingresar Fecha del Evento, Seleccionar Horario del Evento, Seleccionar Evento', $resultado['resultado']);
            }

               // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_validarFH_DatosErroneos() {
            $resultado = $this->object->validarFH('11 de diciembre del 2024', 'C3ena2', '1w3de', false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Fecha del Evento, Seleccionar Horario del Evento, Seleccionar Evento',
            $resultado['resultado']);
            }

                 // Prueba para datos inexistentes en la base de datos
            public function test_validarFH_DatosNoExistenBD() {
            $resultado = $this->object->validarFH('2025-10-21', 'Merienda', '400', false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('success', $resultado['resultado']);
            $this->assertEquals('No tiene un evento registrado para esa fecha y horario', $resultado['mensaje']);
            }

                 // Prueba para datos que existen en la base de datos
            public function test_validarFH_DatosExistenBD() {
            $resultado = $this->object->validarFH('2024-12-31', 'Almuerzo', '9', false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('error', $resultado['resultado']);    
            $this->assertEquals('Ya tiene un evento registrado para esa fecha y horario', $resultado['mensaje']);
            }

              //------------------- MODIFICAR MENU -----------------

          // Prueba para datos vacíos
            public function test_modificarEven_DatosVacios() {
            $resultado = $this->object->modificarEven('', '', '', '','','','','','',false);
    
            $this->assertArrayHasKey('resultado', $resultado);
        
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del Evento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar descripción del evento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar descripción del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Evento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Salida de Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
            } 

             // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_modificarEven_DatosErroneos() {
            $resultado = $this->object->modificarEven('11 de diciembre del 2024', 'Ce34', 'p3o', 'a',
            'k2','0o0','jt5','12KD', 'a',false);
    
            $this->assertArrayHasKey('resultado', $resultado);
        
            $this->assertStringContainsString('Ingresar Fecha del Menú en formato YYYY-MM-DD', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar cantidad de Platos', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar Nombre del Evento', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar descripción del evento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Horario del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Ingresar descripción del Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Evento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Salida de Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
            }
            
            //------------------- MODIFICAR DESTALLE SALIDA EVENTO -----------------  

                // Prueba para datos vacíos
            public function test_detalleSalidaE_DatosVacios() {
            $resultado = $this->object->detalleSalidaE('', '', '', '',false);
    
            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Salida ID', $resultado['resultado']);
            } 

                 // Prueba para datos erróneos (no cumplen con las expresiones regulares)  
            public function test_detalleSalidaE_DatosErroneos() {
            $resultado = $this->object->detalleSalidaE('JFF3J', 'MO0IK', 'PPOL02', 'PES42',false);
    
    
            $this->assertArrayHasKey('resultado', $resultado);
    
            $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
            $this->assertStringContainsString('Seleccionar Salida ID', $resultado['resultado']);
            } 
    

               //------------------- MODIFICAR EVENTO -----------------
            public function test_modificarEventoYDetalleSalidaMenu_DatosListos() {
    
            $feMenu = '2024-12-31';
            $cantPlatos = 400;
            $nomEvent = 'HAPPY NEW YEAR';
            $descripEvent ='Feliz año nuevo a todos' ;
            $horarioComida = 'Cena';
            $descripcion = 'cena para año nuevo';
            $id = 2;
            $idSalidaA = 9;
            $idMenu= 9;
        
            $resultado = $this->object->modificarEven($feMenu, $cantPlatos, $nomEvent, $descripEvent, 
            $horarioComida, $descripcion, $id, $idSalidaA, $idMenu,  false);
        
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Evento Actualizado Exitosamente', $resultado['resultado']);
            $this->assertArrayHasKey('eventoId', $resultado);
            $this->assertArrayHasKey('menuId', $resultado);
            $this->assertArrayHasKey('salidaId', $resultado);
        
            $eventoId = $resultado['eventoId'];
            $menuId = $resultado['menuId'];
            $salidaId = $resultado['salidaId'];
        
            $alimentos = [
                ['alimento' => 2, 'cantidad' => 30],
                ['alimento' => 3, 'cantidad' => 60]
            ];
        
            foreach ($alimentos as $item) {
                $detalleResultado = $this->object->detalleSalidaE($item['cantidad'], $menuId, $item['alimento'],
                 $salidaId, false);
        
                $this->assertArrayHasKey('resultado', $detalleResultado);
                $this->assertEquals('modificado alimentos exitosamente', $detalleResultado['resultado']);
            }
        }

            //------------------ VERIFICAR ELIMINAR - CONSULTAR EVENTO ---------------------

                // Prueba para datos vacíos
            public function test_verificarAnulacion_DatosVacios() {
            $resultado = $this->object->verificarAnulacion('',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }

                   // Prueba para datos erróneos (no cumplen con las expresiones regulares)
            public function test_verificarAnulacion_DatosErroneos() {
            $resultado = $this->object->verificarAnulacion('077o',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }

               // Prueba para datos inexistentes en la base de datos
             public function test_verificarAnulacion_DatosNoExistenBD() {
            $resultado = $this->object->verificarAnulacion(1,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no se puede', $resultado['resultado']);
            } 

              
                        // Prueba para datos que existen en la base de datos
            public function test_verificarAnulacion_DatosExistenBD() {
            $resultado = $this->object->verificarAnulacion(2,false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('se puede', $resultado['resultado']);
            } 

             // ------------------- ELIMINAR EVENTO ------------------------------------
          // Prueba para datos vacíos
            public function test_eliminarEvento_DatosVacios() {
            $resultado = $this->object->eliminarEvento('',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }

              // Prueba para datos erróneos (no cumplen con el patrón)
            public function test_eliminarEvento_DatosErroneos() {
            $resultado = $this->object->eliminarEvento('a04m',false);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }

        public function test_eliminarEventoListo(){
        $id = 2;

        $resultado = $this->object->eliminarEvento($id, false);
        $this->assertArrayHasKey('resultado', $resultado);
        $this->assertEquals('eliminado', $resultado['resultado']);
        }

   

}   */ 
?>