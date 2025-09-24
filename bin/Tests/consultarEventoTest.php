<?php 
use PHPUnit\Framework\TestCase;
use modelo\consultarEventosModelo as consultarEventos;

class consultarEventoTest extends TestCase {

      protected function setUp(): void {
          if (!isset($_ENV['SECRET_KEY_JWT'])) {
        $_ENV['SECRET_KEY_JWT'] = 'graciasDiosF4bK7P9X2Q7mJ8vZ3R6Y1nF4bK7P9X2SamuelEsElMejorQ7mJ8vZ3R6Y1nF4bK7P9X2Q7mJ8vZ3R6Y.';
    }

        $this->object = new consultarEventos();
        $_SESSION['cedula'] = '12345678';
        $this->conex = new PDO('mysql:host=localhost;dbname=comerdorUptaeb', 'root', '');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void {
        unset($this->object);
    }

        //-------------------- BUSCAR EVENTO PO FILTRO -----------------
        public function test_mostrarE_DatosError() {
          $resultado = $this->object->mostrarE('2025-09-25', '2025/09/24');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía',$resultado['resultado']);

          $resultado = $this->object->mostrarE('12-10-2025', '2025-09-23');
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        public function test_mostrarE_DatosErrorFormato() {
            $resultado = $this->object->mostrarE('2 de diciembre del 2025',  '24 de noviembre del 2025');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertStringContainsString('La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
            $this->assertStringContainsString('La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía', $resultado['resultado']);
        }

        public function test_mostrarE_DatosExiste() {
            $resultado = $this->object->mostrarE('2025-10-10', '2025-11-12');
            $this->assertIsArray($resultado);
            $this->assertNotEmpty($resultado);
        } 

        //-------------------- VERIFICAR EXISTENCIA DEL REGISTRO DE EVENTOS -----------------
        public function test_verificarExistencia_DatosVacios() {
            $resultado = $this->object->verificarExistencia('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

        public function test_verificarExistencia_DatosErroneos() {
            $resultado = $this->object->verificarExistencia('P-4');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

        public function test_verificarExistencia_DatosNoExistenEventoBD() {
          $resultado = $this->object->verificarExistencia(500);
          $this->assertArrayHasKey('resultado', $resultado);
          $this->assertEquals('ya no existe', $resultado['resultado']);
        }

        public function test_verificarExistencia_DatosExistenBD() {
            $resultado = $this->object->verificarExistencia(7);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('si existe', $resultado['resultado']);
        }

          //-------------------- MOSTRAR INFORMACION DEL EVENTO -----------------
        public function test_evento_DatosVacios() {
            $resultado = $this->object->evento('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }

        public function test_evento_DatosErroneos() {
            $resultado = $this->object->evento('PX0');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
        }  
        
        public function test_evento_DatosNoExiste() {
            $resultado = $this->object->evento('700');
            $this->assertIsArray($resultado);
            $this->assertCount(0, $resultado); 
        }

        public function test_evento_DatosExiste() {
            $resultado = $this->object->evento('7');
            $this->assertIsArray($resultado);
            $this->assertNotEmpty($resultado);
        }

          //-------------------- MOSTRAR INFORMACION DEL EVENTO - ALIMENTOS -----------------

        public function test_alimento_DatosVacios() {
            $resultado = $this->object->alimento('', '');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Tipo Alimento, Ingresar Evento', $resultado['resultado']);
        }

        public function test_alimento_DatosErroneos() {
            $resultado = $this->object->alimento('0p2', 'S2');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar Tipo Alimento, Ingresar Evento', $resultado['resultado']);
        }

        public function test_alimento_DatosNoExiste() {
            $resultado = $this->object->alimento('450', '134');
            $this->assertIsArray($resultado);
            $this->assertCount(0, $resultado); 
        }

        public function test_alimento_DatosExiste() {
            $resultado = $this->object->alimento('1', '3');
            $this->assertIsArray($resultado);
            $this->assertNotEmpty($resultado);
        }

           //------------------- VERIFICAR EXISTENCIA TIPO ALIMENTO -  CONSULTAR EVENTO ---------------
        public function test_verificarExistenciaTipoA_DatosVacios() {
            $resultado = $this->object->verificarExistenciaTipoA('');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        } 

        public function test_verificarExistenciaTipoA_DatosErroneos() {
            $resultado = $this->object->verificarExistenciaTipoA('fs7w');
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('Ingresar el Tipo de Alimento', $resultado['resultado']);
        }

        public function test_verificarExistenciaTipoA_DatosNoExistenBD() {
            $resultado = $this->object->verificarExistenciaTipoA(760);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('no esta', $resultado['resultado']);
        } 

        public function test_verificarExistenciaTipoA_DatosExistenBD() {
            $resultado = $this->object->verificarExistenciaTipoA(1);
            $this->assertArrayHasKey('resultado', $resultado);
            $this->assertEquals('si esta', $resultado['resultado']);
        } 

            //------------------ VERIFICAR EXISTENCIA ALIMENTO - CONSULTAR EVENTO ---------------------
            public function test_verificarExistenciaAlimento_DatosVacios() {
                $resultado = $this->object->verificarExistenciaAlimento('');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
            } 

            public function test_verificarExistenciaAlimento_DatosErroneos() {
                $resultado = $this->object->verificarExistenciaAlimento('Man5o9A');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
            }

            public function test_verificarExistenciaAlimento_DatosNoExistenBD() {
                $resultado = $this->object->verificarExistenciaAlimento(700);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('no esta', $resultado['resultado']);
            }

            public function test_verificarExistenciaAlimento_DatosExistenBD() {
                $resultado = $this->object->verificarExistenciaAlimento(9);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('si esta', $resultado['resultado']);
            }
            
            //------------------ MOSTRAR ALIMENTO - CONSULTAR EVENTO ----------------------------------
            public function test_mostrarAlimento_DatosVacios() {
                $resultado = $this->object->mostrarAlimento('');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Ingresar Alimento', $resultado['resultado']); 
            }

            public function test_mostrarAlimento_DatosErroneos() {
                $resultado = $this->object->mostrarAlimento('Dura129o');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Ingresar Alimento', $resultado['resultado']);
            }

            public function test_mostrarAlimento_DatosNoExiste() {
                $resultado = $this->object->mostrarAlimento('105');
                $this->assertIsArray($resultado);
                $this->assertCount(0, $resultado); 
            } 

            public function test_mostrarAlimento_DatosExiste() {
                $resultado = $this->object->mostrarAlimento('1');
                $this->assertIsArray($resultado);
                $this->assertNotEmpty($resultado);
            } 

            //------------------- INFORMACION DEL ALIMENTO - CONSULTAR MENU -------------------------
            public function test_infoAlimento_DatosVacios() {
                $resultado = $this->object->infoAlimento('');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
            }

            public function test_infoAlimento_DatosErroneos() {
                $resultado = $this->object->infoAlimento('3o5');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Selecionar Alimento para Obtener Informacion', $resultado['resultado']);
            }

            public function test_infoAlimento_DatosNoExiste() {
                $resultado = $this->object->infoAlimento('721');
                $this->assertIsArray($resultado);
                $this->assertCount(0, $resultado); 
            }

            public function test_infoAlimento_DatosExiste() {
                $resultado = $this->object->infoAlimento('1'); 
                $this->assertIsArray($resultado);
                $this->assertNotEmpty($resultado);
            }

            //------------------ VERIFICAR MODIFICAR - CONSULTAR MENU ---------------------
            public function test_verificarModificacion_DatosVacios() {
                $resultado = $this->object->verificarModificacion('');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            }

            public function test_verificarModificacion_DatosErroneos() {
                $resultado = $this->object->verificarModificacion('5o');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            } 

            public function test_verificarModificacion_DatosNoExistenBD() {
                $resultado = $this->object->verificarModificacion(1);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('no se puede', $resultado['resultado']);
            }

            public function test_verificarModificacion_DatosExistenBD() {
                    $resultado = $this->object->verificarModificacion(70);
                    $this->assertArrayHasKey('resultado', $resultado);
                    $this->assertEquals('se puede', $resultado['resultado']);
            } 
            
              //------------------- VALIDAR FECHA Y HORARIO -  EVENTO ---------------
            public function test_validarFH_DatosVacios() {
                $resultado = $this->object->validarFH('','','');
                $this->assertArrayHasKey('resultado', $resultado); 
                $this->assertEquals('Ingresar Fecha del Evento, Seleccionar Horario del Evento, Seleccionar Evento', $resultado['resultado']);
            }

            public function test_validarFH_DatosErroneos() {
                $resultado = $this->object->validarFH('11 de diciembre del 2025', 'C3ena2', '1w3de');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Ingresar Fecha del Evento, Seleccionar Horario del Evento, Seleccionar Evento',
                $resultado['resultado']);
            }

            public function test_validarFH_DatosNoExistenBD() {
                $resultado = $this->object->validarFH('2027-11-13', 'Almuerzo', '4000');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('No tiene un evento registrado para esa fecha y horario', $resultado['resultado']);
            }

            public function test_validarFH_DatosExistenBD() {
                $resultado = $this->object->validarFH('2025-09-20', 'Cena', '980');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('error', $resultado['resultado']);
                $this->assertEquals('Ya tiene un evento registrado para esa fecha y horario', $resultado['mensaje']);
            }

              //------------------- MODIFICAR MENU -----------------
            public function test_modificarEven_DatosVacios() {
                $resultado = $this->object->modificarEven('', '', '', '','','','','','');
        
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

            public function test_modificarEven_DatosErroneos() {
                $resultado = $this->object->modificarEven('11 de diciembre del 2024', 'Ce34', 'p3o', 'a',
                'k2','0o0','jt5','12KD', 'a');

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
            public function test_detalleSalidaE_DatosVacios() {
                $resultado = $this->object->detalleSalidaE('', '', '', '', '');

                $this->assertArrayHasKey('resultado', $resultado);
        
                $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Salida ID', $resultado['resultado']);
            } 

            public function test_detalleSalidaE_DatosErroneos() {
                $resultado = $this->object->detalleSalidaE('JFF3J', 'MO0IK', 'PPOL02', 'PES42',);
        
        
                $this->assertArrayHasKey('resultado', $resultado);
        
                $this->assertStringContainsString('Ingresar cantidad de alimentos', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Menú', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Alimento', $resultado['resultado']);
                $this->assertStringContainsString('Seleccionar Salida ID', $resultado['resultado']);
            } 

               //------------------- MODIFICAR EVENTO -----------------
            public function test_modificarEventoYDetalleSalidaMenu_DatosListos() {
    
                $feMenu = '2025-09-23';
                $cantPlatos = 400;
                $nomEvent = 'HAPPY NEW YEAR';
                $descripEvent ='Feliz año nuevo a todos' ;
                $horarioComida = 'Cena';
                $descripcion = 'cena para año nuevo';
                $id = 2;
                $idSalidaA = 9;
                $idMenu= 9;
            
                $resultado = $this->object->modificarEven($feMenu, $cantPlatos, $nomEvent, $descripEvent, 
                $horarioComida, $descripcion, $id, $idSalidaA, $idMenu,  );
            
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
                    $salidaId, );
            
                    $this->assertArrayHasKey('resultado', $detalleResultado);
                    $this->assertEquals('modificado alimentos exitosamente', $detalleResultado['resultado']);
                }
            }

            //------------------ VERIFICAR ELIMINAR - CONSULTAR EVENTO ---------------------
            public function test_verificarAnulacion_DatosVacios() {
                $resultado = $this->object->verificarAnulacion('');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            }

            public function test_verificarAnulacion_DatosErroneos() {
                $resultado = $this->object->verificarAnulacion('077o');
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Seleccionar Evento', $resultado['resultado']);
            }

            public function test_verificarAnulacion_DatosNoExistenBD() {
                $resultado = $this->object->verificarAnulacion(1);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('no se puede', $resultado['resultado']);
            } 

            public function test_verificarAnulacion_DatosExistenBD() {
                $resultado = $this->object->verificarAnulacion(50);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('se puede', $resultado['resultado']);
            } 

             // ------------------- ELIMINAR EVENTO ------------------------------------

            public function test_eliminarEvento_DatosVacios() {
                $resultado = $this->object->eliminarEvento('',);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }


            public function test_eliminarEvento_DatosErroneos() {
                $resultado = $this->object->eliminarEvento('a04m',);
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('Obtener ID Evento', $resultado['resultado']);
            }

            public function test_eliminarEventoListo(){
                $id = 2;

                $resultado = $this->object->eliminarEvento($id, );
                $this->assertArrayHasKey('resultado', $resultado);
                $this->assertEquals('eliminado', $resultado['resultado']);
            }

   

}   
?>