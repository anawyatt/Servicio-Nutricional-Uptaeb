<?php

namespace modelo;

use \FPDF;

class reporteModelo extends FPDF
{
// Cabecera de página
public function Header()
{
    // Logo izquierda
    $this->Image('assets/images/logos/logo.png', 10, 8, 38);
    // Logo derecha
    $this->Image('assets/images/logos/uptaeb.png', 167, 8, 30);

    // Fuente
    $this->SetFont('Helvetica', 'B', 16);

    // Título
    $this->SetY(10);
    $this->Cell(0, 10, utf8_decode('Servicio Nutricional'), 0, 1, 'C');

    $this->SetFont('Helvetica', 'B', 12);
    $this->Cell(0, 8, utf8_decode('Universidad Politécnica Territorial Andrés Eloy Blanco'), 0, 1, 'C');
    $this->Cell(0, 8, 'Barquisimeto - Edo - Lara', 0, 1, 'C');

    $this->Ln(5);
}



// Pie de página
// Pie de página
public function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',10);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().utf8_decode('/Servicio Nutricional'),0,0,'C');
}

// Tabla coloreada
function entradaAlimentos($data) {
    ob_end_clean(); // Limpiar el búfer de salida

    // Título principal
    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    $this->SetX(0);
    $this->Cell(210, 10, utf8_decode('Entrada de Alimentos'), 0, 0, 'C');
    $this->Ln(25);

    $descripcion = $data['descripcion'][0];
    $horaFormateada = date('h:i A', strtotime($descripcion->hora));
    $fechaFormateada = (new \DateTime($descripcion->fecha))->format('d-m-y');

    // Datos generales: Fecha, Hora y Descripción
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Fecha: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(0, 8, utf8_decode($descripcion->descripcion), 0, 1, 'L');
    $this->Ln(10);

    $alimentos = $data['detalle'];

    // Agrupar alimentos por tipo
    $alimentosPorTipo = [];
    foreach ($alimentos as $alimento) {
        $alimentosPorTipo[$alimento->tipo][] = $alimento;
    }

    foreach ($alimentosPorTipo as $tipo => $detalleAlimentos) {
        // Encabezado por tipo
        $this->SetFillColor(9,85,160);
        $this->SetTextColor(255);
        $this->SetDrawColor(9,85,160);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 8, utf8_decode($tipo), 1, 1, 'C', true);

        // Cabecera de columnas
        $tieneConMarca = false;
        foreach ($detalleAlimentos as $info) {
            if (strtolower(trim($info->marca)) !== "sin marca") {
                $tieneConMarca = true;
                break;
            }
        }

        $this->SetFillColor(30,163,223);
        $this->SetTextColor(255);
        $this->SetDrawColor(30,163,223);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 12);

        if ($tieneConMarca) {
            $this->Cell(35, 6, utf8_decode('Código'), 1, 0, 'L', true);
            $this->Cell(50, 6, 'Alimento', 1, 0, 'L', true);
            $this->Cell(45, 6, 'Marca', 1, 0, 'L', true);
            $this->Cell(25, 6, 'Cont Neto', 1, 0, 'L', true);
            $this->Cell(35, 6, 'Cantidad', 1, 1, 'L', true);
        } else {
            $this->Cell(40, 6, utf8_decode('Código'), 1, 0, 'L', true);
            $this->Cell(55, 6, 'Alimento', 1, 0, 'L', true);
            $this->Cell(55, 6, 'Marca', 1, 0, 'L', true);
            $this->Cell(40, 6, 'Cantidad', 1, 1, 'L', true);
        }

        // Imprimir los alimentos
        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(30,163,223);
        $this->SetTextColor(0);
        $this->SetFont('');

        foreach ($detalleAlimentos as $info) {
            if (strtolower(trim($info->marca)) !== "sin marca") {
                $this->Cell(35, 8, utf8_decode($info->codigo), 1, 0, 'L');
                $this->Cell(50, 8, utf8_decode($info->nombre), 1, 0, 'L');
                $this->Cell(45, 8, utf8_decode($info->marca), 1, 0, 'L');
                $this->Cell(25, 8, utf8_decode($info->unidadMedida), 1, 0, 'L');

                $unidadTexto = ($info->cantidad == 1) ? "U." : "U.";
                $this->Cell(35, 8, utf8_decode($info->cantidad . ' ' . $unidadTexto), 1, 1, 'L');
            } else {
                $this->Cell(40, 8, utf8_decode($info->codigo), 1, 0, 'L');
                $this->Cell(55, 8, utf8_decode($info->nombre), 1, 0, 'L');
                $this->Cell(55, 8, utf8_decode($info->marca), 1, 0, 'L');
                $this->Cell(40, 8, utf8_decode($info->cantidad . ' ' . $info->unidadMedida), 1, 1, 'L');
            }
        }

        $this->Ln(10);
    }


    $nombreArchivo = 'entradaAlimentos Fecha ' . $descripcion->fecha . '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}





function entradaAlimentosTotal($data){
    ob_end_clean(); // Limpiar el búfer de salida

    $fechaI = $data['fechaI'];
    $fechaF = $data['fechaF'];

    setlocale(LC_TIME, 'es_ES.UTF-8');

    // --- Encabezado Principal y Fechas ---
    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    $this->SetX(0);

    if ($fechaI && $fechaF) {
        if ($fechaI != $fechaF) {
            $dateTimeI = new \DateTime($fechaI);
            $dateTimeF = new \DateTime($fechaF);
            $fechaFormateadaI = $dateTimeI->format('d-m-y');
            $fechaFormateadaF = $dateTimeF->format('d-m-y');

            $this->Cell(210, 10, utf8_decode('Entrada Total de Alimentos'), 0, 1, 'C');
            // Subtítulo de fechas
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 13);
            $this->Cell(190, 10, utf8_decode('Desde el '. $fechaFormateadaI. ' hasta el '.$fechaFormateadaF), 0, 0, 'C');
        } else {
            // Si las fechas son iguales o si solo hay una fecha de rango (no aplica en este caso, pero por consistencia con salida)
            $this->Cell(210, 10, utf8_decode('Entrada Total de Alimentos'), 0, 0, 'C');
        }
    } else {
        $this->Cell(210, 10, utf8_decode('Entrada Total de Alimentos'), 0, 0, 'C');
    }

    $this->Ln(15);

    $alimentos = $data['detalle'];
    $idEntrada = ''; // Renombrado de idInventario a idEntrada para mayor claridad
    $fechaActual = '';

    // El primer bucle es para agrupar por fecha
    foreach($alimentos as $porFecha){
        if ($fechaActual != $porFecha->fecha) {
            // --- Encabezado por Fecha ---
            $this->Ln(5);
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 14);

            setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish'); // Asegurar la configuración regional

            $fechaFormateada = strftime('%e de %B del %Y', strtotime($porFecha->fecha));
            $nombreMes = mb_convert_case(strftime('%B', strtotime($porFecha->fecha)), MB_CASE_TITLE, "UTF-8");
            $fechaFormateada = preg_replace('/\b' . mb_strtolower($nombreMes, 'UTF-8') . '\b/', $nombreMes, mb_strtolower($fechaFormateada, 'UTF-8'));

            $this->Cell(185, 8, utf8_decode($fechaFormateada), 0, 1, 'C');
            $fechaActual = $porFecha->fecha;

            // El segundo bucle anidado es para procesar las entradas dentro de esta fecha
            foreach ($alimentos as $info) {
                // Verificar que sea una nueva entrada (idEntradaA) y que pertenezca a la fecha actual
                if ($idEntrada != $info->idEntradaA && $fechaActual == $info->fecha) {
                    // --- Detalle de la Entrada (Hora, Descripción) ---
                    $this->Ln(10);
                    $horaFormateada = date('h:i A', strtotime($info->hora));

                    $this->SetFillColor(255, 255, 255);
                    $this->SetDrawColor(30,163,223);
                    $this->SetFont('');

                    // Hora
                    $this->SetFont('Arial', 'B', 13);
                    $this->SetTextColor(30,163,223);
                    $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L', 1);
                    $this->SetFont('Arial', '', 12);
                    $this->SetTextColor(0);
                    $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L', 1);

                    // Descripción
                    $this->SetFont('Arial', 'B', 13);
                    $this->SetTextColor(30,163,223);
                    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L', 1);
                    $this->SetFont('Arial', '', 12);
                    $this->SetTextColor(0);
                    $this->Cell(50, 7, utf8_decode($info->descripcion), 0, 1, 'L', 1);

                    $this->Ln(5);
                    $idEntrada = $info->idEntradaA;

                    $tiposProcesados = [];
                    // El tercer bucle anidado es para agrupar y mostrar los alimentos por tipo dentro de esta entrada
                    foreach ($alimentos as $detalle) {
                        // Verificar que pertenezca a la entrada actual y que el tipo no haya sido procesado
                        if ($idEntrada == $detalle->idEntradaA && !in_array($detalle->tipo, $tiposProcesados)) {
                            // --- Encabezado por Tipo de Alimento ---
                            $this->SetFillColor(9,85,160);
                            $this->SetTextColor(255);
                            $this->SetDrawColor(9,85,160);
                            $this->SetLineWidth(.2);
                            $this->SetFont('Arial', 'B', 14);
                            $this->Cell(0, 8, utf8_decode($detalle->tipo), 1, 1, 'C', true);

                            // --- Cabecera de Columnas ---
                            $this->SetFillColor(30,163,223);
                            $this->SetTextColor(255);
                            $this->SetDrawColor(30,163,223);
                            $this->SetLineWidth(.2);
                            $this->SetFont('Arial', 'B', 12);
                            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'L', true);
                            $this->Cell(55, 6, 'Alimento', 1, 0, 'L', true);
                            $this->Cell(45, 6, 'Marca', 1, 0, 'L', true);
                            $this->Cell(25, 6, 'Cont Neto', 1, 0, 'L', true);
                            $this->Cell(35, 6, 'Cantidad', 1, 1, 'L', true);

                            // --- Datos de Alimentos ---
                            $this->SetFillColor(255, 255, 255);
                            $this->SetDrawColor(30,163,223);
                            $this->SetTextColor(0);
                            $this->SetFont('');

                            foreach ($alimentos as $detalleA) {
                                // Muestra solo los detalles que coincidan con el tipo y la entrada actual
                                if ($detalle->tipo == $detalleA->tipo && $idEntrada == $detalleA->idEntradaA) {
                                    $this->Cell(30, 8, utf8_decode($detalleA->codigo), 1, 0, 'L');
                                    $this->Cell(55, 8, utf8_decode($detalleA->nombre), 1, 0, 'L');
                                    $this->Cell(45, 8, utf8_decode($detalleA->marca), 1, 0, 'L');

                                    // Cont. Neto vacío si la marca es "Sin Marca"
                                    $contNeto = (strtolower(trim($detalleA->marca)) === "sin marca") ? '' : $detalleA->unidadMedida;
                                    $this->Cell(25, 8, utf8_decode($contNeto), 1, 0, 'L');

                                    $unidadTexto = ($detalleA->cantidad == 1) ? "U." : "U.";
                                    $this->Cell(35, 8, utf8_decode($detalleA->cantidad . ' ' . $unidadTexto), 1, 1, 'L');
                                }
                            }

                            $this->Ln(6);
                            $tiposProcesados[] = $detalle->tipo;
                        }
                    }
                }
            }
        }
    }

    // --- ENVIAR PDF DIRECTAMENTE AL NAVEGADOR ---
    if ($fechaI && $fechaF) {
        $nombreArchivo = ($fechaI != $fechaF)
            ? 'entradaAlimentosTotal '.$fechaI.' hasta '.$fechaF.'.pdf'
            : 'entradaAlimentosTotal '.$fechaI.'.pdf';
    } else {
        $nombreArchivo = 'entradaAlimentosTotal.pdf';
    }
    $this->Output('D', $nombreArchivo);
    die();

    
}



function stockAlimentos($data){
    ob_end_clean(); // Limpiar el búfer de salida

    date_default_timezone_set('America/Caracas');

    $meses_espanol = array(
        'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo',
        'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Junio',
        'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre',
        'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
    );

    $mes_actual = date('F'); 
    $mes_actual_spanish = $meses_espanol[$mes_actual] ?? '';
    $fecha_actual = date('d') . ' de ' . $mes_actual_spanish . ' del ' . date('Y');
    $hora_actual = date('g:i A');

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    $this->SetX(0);
    $this->Cell(210, 10, utf8_decode('Stock de Alimentos'), 0, 1, 'C');
    $this->Ln(6);
    $this->SetTextColor(0);
    $this->SetFont('Helvetica', 'B', 14);
    $this->Cell(185, 8, utf8_decode($fecha_actual), 0, 1, 'C');
    $this->Cell(185, 8, utf8_decode($hora_actual), 0, 1, 'C');
    $this->Ln(25);

    $alimento = $data['detalle'];
    $alimentoI = '';

    foreach ($alimento as $info) {
        if ($alimentoI != $info->tipo) {
            $this->SetFillColor(9,85,160);
            $this->SetTextColor(255);
            $this->SetDrawColor(9,85,160);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 14);
            $alimentoI = $info->tipo;

            $this->Cell(0, 8, utf8_decode($info->tipo), 1, 1, 'C', true);

            $this->SetFillColor(30,163,223);
            $this->SetTextColor(255);
            $this->SetDrawColor(30,163,223);
            $this->SetLineWidth(.2);
            $this->SetFont('', 'B',12);

            $this->Cell(51, 6, 'Alimento', 1, 0, 'L', true); // Más ancho
            $this->Cell(35, 6, 'Marca', 1, 0, 'L', true);
            $this->Cell(25, 6, 'Cont Neto', 1, 0, 'L', true);
            $this->Cell(27,6, ' Stock', 1, 0, 'L', true);
            $this->Cell(25,6, ' Reservado', 1, 0, 'L', true);
            $this->Cell(27, 6, ' Total', 1, 1, 'L', true);

            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(30,163,223);
            $this->SetTextColor(0);
            $this->SetFont('');

            foreach ($alimento as $detalle) {
                if ($alimentoI == $detalle->tipo) {
                    $contNeto = ($detalle->marca != 'Sin Marca') ? $detalle->unidadMedida : '';

                    $unidadStock = ($detalle->stock == 1) ? ' U.' : ' U.';
                    $unidadReservado = ($detalle->reservado == 1) ? ' U.' : ' U.';
                    $unidadTotal = (($detalle->stock + $detalle->reservado) == 1) ? ' U.' : ' U.';

                    $this->Cell(51, 8, utf8_decode($detalle->nombre), 1, 0, 'L', true);
                    $this->Cell(35, 8, utf8_decode($detalle->marca), 1, 0, 'L', true);
                    $this->Cell(25, 8, utf8_decode($contNeto), 1, 0, 'L', true);
                    $this->Cell(27, 8,utf8_decode($detalle->stock . $unidadStock), 1, 0, 'L', true);
                    $this->Cell(25, 8, utf8_decode($detalle->reservado . $unidadReservado), 1, 0, 'L', true);
                    $this->Cell(27, 8, utf8_decode(($detalle->stock +  $detalle->reservado) . $unidadTotal), 1, 1, 'L', true);
                }
            }
            $this->Ln(6);
        }
        
    }

    $nombreArchivo = 'stockAlimentos - '.$fecha_actual.' '.$hora_actual. '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}



function salidaAlimentos($data){
    ob_end_clean(); // Limpiar el búfer de salida

    // --- Título principal ---
    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    $this->SetX(0);
    $this->Cell(210, 10, utf8_decode('Salida de Alimentos'), 0, 0, 'C');
    $this->Ln(25);

    $descripcion = $data['descripcion'][0];
    $horaFormateada = date('h:i A', strtotime($descripcion->hora));
    $fechaFormateada = (new \DateTime($descripcion->fecha))->format('d-m-y');

    // --- Datos generales ---
    // Fecha
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Fecha: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');

    // Hora
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L');

    // Salida por
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(30, 7, utf8_decode('Salida por: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(0, 8, utf8_decode($descripcion->tipoSalida), 0, 1, 'L');

    // Descripción
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(0, 8, utf8_decode($descripcion->descripcion), 0, 1, 'L');
    $this->Ln(5);

    $alimentos = $data['detalle'];

    // Agrupar alimentos por tipo
    $alimentosPorTipo = [];
    foreach ($alimentos as $alimento) {
        $alimentosPorTipo[$alimento->tipo][] = $alimento;
    }

    foreach ($alimentosPorTipo as $tipo => $detalleAlimentos) {
        // --- Encabezado por tipo ---
        $this->SetFillColor(9,85,160);
        $this->SetTextColor(255);
        $this->SetDrawColor(9,85,160);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 8, utf8_decode($tipo), 1, 1, 'C', true);

        // Lógica para determinar si mostrar 'Cont Neto' o expandir otras columnas
        $tieneContNeto = false;
        foreach ($detalleAlimentos as $info) {
            // Verifica si al menos uno tiene marca diferente de "Sin Marca" (y por lo tanto, Cont Neto)
            if (strtolower(trim($info->marca)) !== "sin marca") {
                $tieneContNeto = true;
                break;
            }
        }

        // --- Cabecera de columnas ---
        $this->SetFillColor(30,163,223);
        $this->SetTextColor(255);
        $this->SetDrawColor(30,163,223);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 12);

        if ($tieneContNeto) {
            // Formato con Cont Neto (ancho similar a entradaAlimentos)
            $this->Cell(35, 6, utf8_decode('Código'), 1, 0, 'L', true);
            $this->Cell(50, 6, 'Alimento', 1, 0, 'L', true);
            $this->Cell(45, 6, 'Marca', 1, 0, 'L', true);
            $this->Cell(25, 6, 'Cont Neto', 1, 0, 'L', true);
            $this->Cell(35, 6, 'Cantidad', 1, 1, 'L', true);
        } else {
            // Formato sin Cont Neto (Distribuyendo el ancho extra de 25)
            // 35+50+45+25+35 = 190. Sin 25, queda 165.
            // 165 / 4 = 41.25. Usaremos 40, 55, 55, 40 (igual que entradaAlimentos)
            $this->Cell(40, 6, utf8_decode('Código'), 1, 0, 'L', true);
            $this->Cell(55, 6, 'Alimento', 1, 0, 'L', true);
            $this->Cell(55, 6, 'Marca', 1, 0, 'L', true); // Marca absorbe Cont Neto y parte del total
            $this->Cell(40, 6, 'Cantidad', 1, 1, 'L', true);
        }

        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(30,163,223);
        $this->SetTextColor(0);
        $this->SetFont('');

        // --- Imprimir cada alimento ---
        foreach ($detalleAlimentos as $info) {
            $contNetoVacio = (strtolower(trim($info->marca)) === "sin marca");

            if ($tieneContNeto) {
                // Formato con Cont Neto
                $this->Cell(35, 8, utf8_decode($info->codigo), 1, 0, 'L');
                $this->Cell(50, 8, utf8_decode($info->nombre), 1, 0, 'L');
                $this->Cell(45, 8, utf8_decode($info->marca), 1, 0, 'L');

                $contNeto = $contNetoVacio ? '' : utf8_decode($info->unidadMedida);
                $this->Cell(25, 8, $contNeto, 1, 0, 'L');

                $unidadTexto = ($info->cantidad == 1) ? "U." : "U.";
                $this->Cell(35, 8, utf8_decode($info->cantidad . ' ' . $unidadTexto), 1, 1, 'L');
            } else {
                // Formato sin Cont Neto
                $this->Cell(40, 8, utf8_decode($info->codigo), 1, 0, 'L');
                $this->Cell(55, 8, utf8_decode($info->nombre), 1, 0, 'L');
                $this->Cell(55, 8, utf8_decode($info->marca), 1, 0, 'L');

                $unidadTexto = ($info->cantidad == 1) ? "U." : "U.";
                $this->Cell(40, 8, utf8_decode($info->cantidad . ' ' . $unidadTexto), 1, 1, 'L');
            }
        }

        $this->Ln(10);
    }

    // --- Guardar PDF ---
    $nombreArchivo = 'salidaAlimentos Fecha ' . $descripcion->fecha . '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}


  function salidaAlimentosTotal($data){
    ob_end_clean(); // Limpiar el búfer de salida

    $fechaI = $data['fechaI'];
    $fechaF = $data['fechaF'];

    setlocale(LC_TIME, 'es_ES.UTF-8');

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    $this->SetX(0);

    if ($fechaI != '' && $fechaF != '') {
        if ($fechaI != $fechaF) {
            $dateTimeI = new \DateTime($fechaI);
            $dateTimeF = new \DateTime($fechaF);
            $fechaFormateadaI = $dateTimeI->format('d-m-y');
            $fechaFormateadaF = $dateTimeF->format('d-m-y');

            $this->Cell(210, 10, utf8_decode('Salida Total de Alimentos'), 0, 1, 'C');
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 13);
            $this->Cell(190, 10, utf8_decode('Desde el '. $fechaFormateadaI. ' hasta el '.$fechaFormateadaF), 0, 0, 'C');
        } else {
            $this->Cell(210, 10, utf8_decode('Salida Total de Alimentos'), 0, 0, 'C');
        }
    } else {
        $this->Cell(210, 10, utf8_decode('Salida Total de Alimentos'), 0, 0, 'C');
    }

    $this->Ln(15);

    $alimentos = $data['detalle'];
    $idSalida = '';
    $fecha = '';

    foreach($alimentos as $porFecha){
        if ($fecha != $porFecha->fecha) {
            $this->Ln(5);
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 14);

            setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish');

            $fechaFormateada = strftime('%e de %B del %Y', strtotime($porFecha->fecha));
            $nombreMes = mb_convert_case(strftime('%B', strtotime($porFecha->fecha)), MB_CASE_TITLE, "UTF-8");
            $fechaFormateada = preg_replace('/\b' . mb_strtolower($nombreMes, 'UTF-8') . '\b/', $nombreMes, mb_strtolower($fechaFormateada, 'UTF-8'));

            $this->Cell(185, 8, utf8_decode($fechaFormateada), 0, 1, 'C');
            $fecha = $porFecha->fecha;

            foreach ($alimentos as $info) {
                if ($idSalida != $info->idSalidaA && $fecha == $info->fecha ) {
                    $this->Ln(10);
                    $horaFormateada = date('h:i A', strtotime($info->hora));
                    $this->SetFillColor(255, 255, 255);
                    $this->SetDrawColor(30,163,223);
                    $this->SetFont('');

                    // Datos de la descripción general
                    $this->SetFont('Arial', 'B', 13);
                    $this->SetTextColor(30,163,223);
                    $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L', 1);
                    $this->SetFont('Arial', '', 12);
                    $this->SetTextColor(0);
                    $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L', 1);

                    $this->SetFont('Arial', 'B', 13);
                    $this->SetTextColor(30,163,223);
                    $this->Cell(30, 7, utf8_decode('Salida por: '), 0, 0, 'L', 1);
                    $this->SetFont('Arial', '', 12);
                    $this->SetTextColor(0);
                    $this->Cell(50, 7, utf8_decode($info->tipoSalida), 0, 1, 'L', 1);

                    $this->SetFont('Arial', 'B', 13);
                    $this->SetTextColor(30,163,223);
                    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L', 1);
                    $this->SetFont('Arial', '', 12);
                    $this->SetTextColor(0);
                    $this->Cell(50, 7, utf8_decode($info->descripcion), 0, 1, 'L', 1);

                    $this->Ln(5);
                    $idSalida = $info->idSalidaA;
                    $tiposProcesados = array();

                    foreach ($alimentos as $detalle) {
                        if ($idSalida == $detalle->idSalidaA && !in_array($detalle->tipo, $tiposProcesados)) {
                            // Encabezado tipo de alimento
                            $this->SetFillColor(9,85,160);
                            $this->SetTextColor(255);
                            $this->SetDrawColor(9,85,160);
                            $this->SetLineWidth(.2);
                            $this->SetFont('Arial', 'B', 14);
                            $this->Cell(0, 8, utf8_decode($detalle->tipo), 1, 1, 'C', true);

                            // Cabecera de columnas (siempre Cont Neto)
                            $this->SetFillColor(30,163,223);
                            $this->SetTextColor(255);
                            $this->SetDrawColor(30,163,223);
                            $this->SetLineWidth(.2);
                            $this->SetFont('', 'B', 12);

                            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'L', true);
                            $this->Cell(65, 6, 'Alimento', 1, 0, 'L', true);
                            $this->Cell(40, 6, 'Marca', 1, 0, 'L', true);
                            $this->Cell(25, 6, 'Cont Neto', 1, 0, 'L', true);
                            $this->Cell(30, 6, 'Cantidad', 1, 1, 'L', true);

                            $this->SetFillColor(255, 255, 255);
                            $this->SetDrawColor(30,163,223);
                            $this->SetTextColor(0);
                            $this->SetFont('');

                            // Datos de alimentos
                            foreach ($alimentos as $detalleA) {
                                if ($detalle->tipo == $detalleA->tipo && $idSalida == $detalleA->idSalidaA) {
                                    $this->Cell(30, 8, utf8_decode($detalleA->codigo), 1, 0, 'L', true);
                                    $this->Cell(65, 8, utf8_decode($detalleA->nombre), 1, 0, 'L', true);
                                    $this->Cell(40, 8, utf8_decode($detalleA->marca), 1, 0, 'L', true);

                                    // Cont Neto vacío si marca es "Sin Marca"
                                    $contNeto = (strtolower(trim($detalleA->marca)) === "sin marca") ? '' : utf8_decode($detalleA->unidadMedida);
                                    $this->Cell(25, 8, $contNeto, 1, 0, 'L');

                                    $this->Cell(30, 8, utf8_decode($detalleA->cantidad . ' ' . $detalleA->unidadMedida), 1, 1, 'L', true);
                                }
                            }

                            $this->Ln(6);
                            $tiposProcesados[] = $detalle->tipo;
                        }
                    }
                }
            }
        }
    }

    $this->Ln(6);

    // Guardar PDF
   if ($fechaI != '' && $fechaF != '') {
        $nombreArchivo = ($fechaI != $fechaF) 
            ? 'salidaAlimentosTotal '.$fechaI.' hasta '.$fechaF.'.pdf'
            : 'salidaAlimentosTotal '.$fechaI.'.pdf';
    } else {
        $nombreArchivo = 'salidaAlimentosTotal.pdf';
    }

    $this->Output('D', $nombreArchivo);
    die();
}



function asistencia($data){
    ob_end_clean();

    $fecha = $data['fecha'];
    $horario = $data['horario'];

    // Establecer zona horaria de Venezuela
    date_default_timezone_set('America/Caracas');
    
    // Array para traducir nombres de meses de inglés a español
    $meses_espanol = array(
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    );

    $mes_actual = date('F');
    $mes_actual_spanish = isset($meses_espanol[$mes_actual]) ? $meses_espanol[$mes_actual] : '';

    $fecha_actual = date('d') . ' de ' . $mes_actual_spanish . ' del ' . date('Y');

    //-------------- ESTRUCTURA--------------

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0);
    $this->Cell(210, 10, utf8_decode('Asistencias del Servicio Nutricional'), 0, 1, 'C');
    $this->Ln(6);
    $this->SetTextColor(0);
    $this->SetFont('Helvetica', 'B', 14);

    $nombreArchivo = 'Asistencias';

    if ($fecha != 'Seleccionar' && $horario != 'Seleccionar') {
       $fechaDateTime = new \DateTime($fecha);
       $formattedFecha = $fechaDateTime->format('d-m-Y');
       $this->Cell(185, 8, utf8_decode($horario.' - '. $formattedFecha), 0, 1, 'C');
       $nombreArchivo .= ' '.$horario.' '. $formattedFecha;
    }
    else if ($fecha != 'Seleccionar' || $horario != 'Seleccionar') {
      
      if ($fecha != 'Seleccionar') {
           $fechaDateTime = new \DateTime($fecha);
           $formattedFecha = $fechaDateTime->format('d-m-Y');
           $this->Cell(185, 8, utf8_decode($formattedFecha), 0, 1, 'C');
           $nombreArchivo .= ' '.$formattedFecha;
      }
      if ($horario != 'Seleccionar') {
           $this->Cell(185, 8, utf8_decode($horario), 0, 1, 'C');
           $nombreArchivo .= ' '.$horario;
      }
    }
    else{
        $this->Cell(185, 8, utf8_decode($fecha_actual), 0, 1, 'C');
        $nombreArchivo .= ' '.$fecha_actual;
    }

    $this->Ln(20);
    $asistencia = $data['detalle'];
    $horarioC = '';
    foreach ($asistencia as $info) {
        if ($horarioC != $info->HorarioDeComida) {
            $this->SetFillColor(9,85,160);
            $this->SetTextColor(255);
            $this->SetDrawColor(9,85,160);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 14);
            $horarioC = $info->HorarioDeComida;

            $this->Cell(0, 8, utf8_decode($info->HorarioDeComida), 1, 1, 'C', true);

            $this->SetFillColor(30,163,223);
            $this->SetTextColor(255);
            $this->SetDrawColor(30,163,223);
            $this->SetLineWidth(.2);
            $this->SetFont('', 'B',12);

            $this->Cell(40, 6, utf8_decode('Cedula'), 1, 0, 'L', true);
            $this->Cell(40, 6, 'Nombre', 1, 0, 'L', true);
            $this->Cell(40, 6, 'Apellido', 1, 0, 'L', true);
            $this->Cell(70, 6, 'Carrera', 1, 1, 'L', true);

            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(30,163,223);
            $this->SetTextColor(0);
            $this->SetFont('');

            foreach ($asistencia as $detalle) {
                if ($horarioC == $detalle->HorarioDeComida) {
                    $this->Cell(40, 8, utf8_decode($detalle->Cedula), 1, 0, 'L', true);
                    $this->Cell(40, 8, utf8_decode($detalle->Nombre), 1, 0, 'L', true);
                    $this->Cell(40, 8, utf8_decode($detalle->Apellido), 1, 0, 'L', true);
                    $this->Cell(70, 8, utf8_decode($detalle->Carrera), 1, 1, 'L', true);
                }
            }
        }
        $this->Ln(1);
    }
    
    $nombreArchivo .= '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}


function asistencia2($data){
    ob_end_clean();
//-------------- ESTRUCTURA--------------
$asistencia = $data['detalle'];

$this->SetTextColor(9, 85, 160);
$this->SetFont('Helvetica', 'B', 20);
// Título
$this->SetX(0);
$this->Cell(210, 10, utf8_decode('Asistencias del Servicio Nutricional'), 0, 1, 'C');
$this->Ln(6);
$this->SetTextColor(0);
$this->SetFont('Helvetica', 'B', 14);

if (isset($asistencia[0]->FechaAsistencia)) {
    $fechaOriginal = $asistencia[0]->FechaAsistencia;
    $fechaDateTime = new \DateTime($fechaOriginal);
    $fechaAsistencia = $fechaDateTime->format('d-m-Y');
} else {
    $fechaAsistencia = 'Fecha no definida';
}
$this->Cell(185, 8, utf8_decode($fechaAsistencia), 0, 1, 'C');

$this->Ln(20);

$horarioC = '';
foreach ($asistencia as $info) {
    if ($horarioC != $info->HorarioDeComida) {
        $this->SetFillColor(9, 85, 160);
        $this->SetTextColor(255);
        $this->SetDrawColor(9, 85, 160);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 14);
        $horarioC = $info->HorarioDeComida;

        $this->Cell(0, 8, utf8_decode($info->HorarioDeComida), 1, 1, 'C', true);

        $this->SetFillColor(30, 163, 223);
        $this->SetTextColor(255);
        $this->SetDrawColor(30, 163, 223);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 12);

        $this->Cell(40, 6, utf8_decode('Cedula'), 1, 0, 'L', true);
        $this->Cell(40, 6, 'Nombre', 1, 0, 'L', true);
        $this->Cell(40, 6, 'Apellido', 1, 0, 'L', true);
        $this->Cell(70, 6, 'Carrera', 1, 1, 'L', true);

        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(30, 163, 223);
        $this->SetTextColor(0);
        $this->SetFont('');

        foreach ($asistencia as $detalle) {
            if ($horarioC == $detalle->HorarioDeComida) {
                $this->Cell(40, 8, utf8_decode($detalle->Cedula), 1, 0, 'L', true);
                $this->Cell(40, 8, utf8_decode($detalle->Nombre), 1, 0, 'L', true);
                $this->Cell(40, 8, utf8_decode($detalle->Apellido), 1, 0, 'L', true);
                $this->Cell(70, 8, utf8_decode($detalle->Carrera), 1, 1, 'L', true);
            }
        }
    }
    $this->Ln(1);
}

$nombreArchivo = 'Asistencias ' . $fechaAsistencia . '.pdf';
$this->Output('D', $nombreArchivo);
die();

}



//----------------- MENU ------------------------


function menu($data){
    ob_end_clean(); // Limpiar el búfer de salida
    $descripcion = $data['descripcion'];

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0);
    $this->Cell(210, 10, utf8_decode('Menú - '.$descripcion[0]->horarioComida), 0, 0, 'C');
    $this->Ln(25);

    // Datos de la descripción
    $dateTime = new \DateTime($descripcion[0]->feMenu);
    $fechaFormateada = $dateTime->format('d-m-y');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(17, 7, utf8_decode('Fecha: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(20, 7, utf8_decode('Horario: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(55, 7, utf8_decode($descripcion[0]->horarioComida), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(58, 7, utf8_decode('Cantidad de Comensales: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(130, 7, utf8_decode($descripcion[0]->cantPlatos), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(0, 8, utf8_decode($descripcion[0]->descripcion), 0, 1, 'L'); 

    $this->Ln(5);

    $alimento = $data['detalle'];
    $alimentoI = '';
    foreach ($alimento as $info) {
        if ($alimentoI != $info->tipo) {
            $this->SetFillColor(9,85,160);
            $this->SetTextColor(255);
            $this->SetDrawColor(9,85,160);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 14);
            $alimentoI = $info->tipo;

            $this->Cell(0, 8, utf8_decode($info->tipo), 1, 1, 'C', true);

            $this->SetFillColor(30,163,223);
            $this->SetTextColor(255);
            $this->SetDrawColor(30,163,223);
            $this->SetLineWidth(.2);
            $this->SetFont('', 'B', 12);

            // Encabezado de tabla
            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'L', true);
            $this->Cell(90, 6, 'Alimento', 1, 0, 'L', true);
            $this->Cell(40, 6, 'Marca', 1, 0, 'L', true);
            $this->Cell(30, 6, 'Cantidad', 1, 1, 'L', true);

            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(30,163,223);
            $this->SetTextColor(0);
            $this->SetFont('');

            // Filas con MultiCell para Alimento
            foreach ($alimento as $detalle) {
                if ($alimentoI == $detalle->tipo) {

                    $nombreAlimento = ($detalle->marca != 'Sin Marca') 
                        ? $detalle->nombre . ' - ' . $detalle->unidadMedida 
                        : $detalle->nombre;

                    $cantidad = ($detalle->marca != 'Sin Marca') 
                        ? $detalle->cantidad . ' U.' 
                        : $detalle->cantidad . ' ' . $detalle->unidadMedida;

                    // Anchos iguales a los encabezados
                    $wCodigo   = 30;
                    $wAlimento = 90;
                    $wMarca    = 40;
                    $wCantidad = 30;

                    $x = $this->GetX();
                    $y = $this->GetY();

                    // Código
                    $this->MultiCell($wCodigo, 8, utf8_decode($detalle->codigo), 1, 'L');
                    $hCodigo = $this->GetY() - $y;

                    // Alimento
                    $this->SetXY($x + $wCodigo, $y);
                    $this->MultiCell($wAlimento, 8, utf8_decode($nombreAlimento), 1, 'L');
                    $hAlimento = $this->GetY() - $y;

                    // Marca
                    $this->SetXY($x + $wCodigo + $wAlimento, $y);
                    $this->MultiCell($wMarca, 8, utf8_decode($detalle->marca), 1, 'L');
                    $hMarca = $this->GetY() - $y;

                    // Cantidad
                    $this->SetXY($x + $wCodigo + $wAlimento + $wMarca, $y);
                    $this->MultiCell($wCantidad, 8, utf8_decode($cantidad), 1, 'L');
                    $hCantidad = $this->GetY() - $y;

                    // Saltar a la siguiente fila
                    $maxAltura = max($hCodigo, $hAlimento, $hMarca, $hCantidad);
                    $this->SetXY($x, $y + $maxAltura);
                }
            }
        }
        $this->Ln(6);
    }

    $nombreArchivo = 'Menu del dia ' . $descripcion[0]->feMenu . ' - ' . $descripcion[0]->horarioComida . '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}



//----------------- EVENTO ------------------------


function evento($data){
    ob_end_clean(); // Limpiar el búfer de salida
     $descripcion = $data['descripcion'];

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0); // Establecer posición X en 0
    $this->Cell(210, 10, utf8_decode('Evento - '.$descripcion[0]->horarioComida), 0, 0, 'C');
    $this->Ln(25);

     // Datos de la descripcion
    $dateTime = new \DateTime($descripcion[0]->feMenu);
    $fechaFormateada = $dateTime->format('d-m-y');

    // Datos de la descripción general en formato de párrafo
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(17, 7, utf8_decode('Fecha: '), 0, 0, 'L');
    
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(20, 7, utf8_decode('Horario: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(55, 7, utf8_decode($descripcion[0]->horarioComida), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(45, 7, utf8_decode('Nombre del Evento: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($descripcion[0]->nomEvent), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(55, 7, utf8_decode('Descripción del Evento: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($descripcion[0]->descripEvent), 0, 1, 'L');

    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(58, 7, utf8_decode('Cantidad de Comensales: '), 0, 0, 'L');

    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(130, 7, utf8_decode($descripcion[0]->cantPlatos), 0, 1, 'L');

    $this->Ln(5);
    
    

   $alimento = $data['detalle'];
$tiposDibujados = [];

foreach ($alimento as $detalle) {
    $tipoActual = $detalle->tipo;
    // Si ya dibujamos este tipo, saltamos
    if (in_array($tipoActual, $tiposDibujados)) continue;

    $tiposDibujados[] = $tipoActual;

    // Dibujar encabezado de tabla
    $this->SetFillColor(9,85,160);
    $this->SetTextColor(255);
    $this->SetDrawColor(9,85,160);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(0, 8, utf8_decode($tipoActual), 1, 1, 'C', true);

    $this->SetFillColor(30,163,223);
    $this->SetTextColor(255);
    $this->SetDrawColor(30,163,223);
    $this->SetLineWidth(.2);
    $this->SetFont('', 'B', 12);

    $this->Cell(40, 6, utf8_decode('Código'), 1, 0, 'L', true);
    $this->Cell(55, 6, 'Alimento', 1, 0, 'L', true);
    $this->Cell(55, 6, 'Marca', 1, 0, 'L', true);
    $this->Cell(40, 6, 'Cantidad', 1, 1, 'L', true);

    $this->SetFillColor(255, 255, 255);
    $this->SetDrawColor(30,163,223);
    $this->SetTextColor(0);
    $this->SetFont('');

    // Dibujar filas solo de este tipo
    foreach ($alimento as $fila) {
        if ($fila->tipo == $tipoActual) {
            $this->Cell(40, 8, utf8_decode($fila->codigo), 1, 0, 'L');

            $nombreAlimento = ($fila->marca != 'Sin Marca') 
                ? $fila->nombre . ' - ' . $fila->unidadMedida 
                : $fila->nombre;
            $this->Cell(55, 8, utf8_decode($nombreAlimento), 1, 0, 'L');

            $this->Cell(55, 8, utf8_decode($fila->marca), 1, 0, 'L');

            $cantidad = ($fila->marca != 'Sin Marca') 
                ? $fila->cantidad . ' U.' 
                : $fila->cantidad . ' ' . $fila->unidadMedida;
            $this->Cell(40, 8, utf8_decode($cantidad), 1, 1, 'L');
        }
    }

    $this->Ln(6);
}


    $nombreArchivo = 'Evento del dia ' . $descripcion[0]->feMenu . ' - ' . $descripcion[0]->horarioComida . '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}


// --------------- UTENSILIOS ------------------------

    function entradaUtensilios($data){
    ob_end_clean(); // Limpiar el búfer de salida

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0); // Establecer posición X en 0
    $this->Cell(210, 10, utf8_decode('Entrada de Utensilios'), 0, 0, 'C');
    $this->Ln(25);
    // Datos de la descripcion
    $descripcion = $data['descripcion'];
    $horaFormateada = date('h:i A', strtotime($descripcion[0]->hora));
    $dateTime = new \DateTime($descripcion[0]->fecha);
    $fechaFormateada = $dateTime->format('d-m-y');

    // Datos de la descripción general en formato de párrafo
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Fecha: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);
    $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L');
    $this->SetFont('Arial', 'B', 13);
    $this->SetTextColor(30,163,223);
    $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L');
    $this->SetFont('Arial', '', 12);
    $this->SetTextColor(0);

    $pageWidth = $this->GetPageWidth();
    $margins = $this->lMargin + $this->rMargin;
    $usableWidth = $pageWidth - $margins;

    $this->MultiCell($usableWidth, 8, utf8_decode($descripcion[0]->descripcion), 0, 'L');

    $this->Ln(5);

    $utensilios = $data['detalle'];
    $utensiliosI = '';
    foreach ($utensilios as $info) {
        if ($utensiliosI != $info->tipo) {
            $this->SetFillColor(9,85,160);
            $this->SetTextColor(255);
            $this->SetDrawColor(9,85,160);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial', 'B', 14);
            $utensiliosI = $info->tipo;

            $this->Cell(0, 8, utf8_decode($info->tipo), 1, 1, 'C', true);

            $this->SetFillColor(30,163,223);
$this->SetTextColor(255);
$this->SetDrawColor(30,163,223);
$this->SetLineWidth(.2);
$this->SetFont('', 'B', 12);

// Obtener el ancho de la página
$pageWidth = $this->GetPageWidth();
$margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
$usableWidth = $pageWidth - $margins;

// Calcular el ancho de cada celda
$widths = array(0.4 * $usableWidth, 0.4 * $usableWidth, 0.2 * $usableWidth);

$this->Cell($widths[0], 6, 'Utensilio', 1, 0, 'L', true);
$this->Cell($widths[1], 6, 'Material', 1, 0, 'L', true);
$this->Cell($widths[2], 6, 'Cantidad', 1, 1, 'L', true);

$this->SetFillColor(255, 255, 255);
$this->SetDrawColor(30,163,223);
$this->SetTextColor(0);
$this->SetFont('');

foreach ($utensilios as $detalle) {
    if ($utensiliosI == $detalle->tipo) {
        $this->Cell($widths[0], 8, utf8_decode($detalle->nombre), 1, 0, 'L');
        $this->Cell($widths[1], 8, utf8_decode($detalle->material), 1, 0, 'L');
        $this->Cell($widths[2], 8, utf8_decode($detalle->cantidad), 1, 1, 'L');
    }
}
        }
        $this->Ln(6);
    }

    $nombreArchivo = 'entradaUtensilios Fecha ' . $descripcion[0]->fecha . '.pdf';
    $this->Output('D', $nombreArchivo);
    die();
}

function entradaUtensiliosTotal($data){
    ob_end_clean(); // Limpiar el búfer de salida

     $fechaI = $data['fechaI'];
     $fechaF = $data['fechaF'];
    // Configurar idioma para strftime
    setlocale(LC_TIME, 'es_ES.UTF-8');

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0); // Establecer posición X en 0

    
    if ($fechaI != '' && $fechaF != '') {
      if ($fechaI != $fechaF) {
  
           $dateTimeI = new \DateTime($fechaI);
           $dateTimeF = new \DateTime($fechaF);

        // Formatear las fechas al formato d-m-y
        $fechaFormateadaI = $dateTimeI->format('d-m-y');
        $fechaFormateadaF = $dateTimeF->format('d-m-y');

      $this->Cell(210, 10, utf8_decode('Entrada Total de Utensilios'), 0, 1, 'C');
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 13);
             $this->Cell(190, 10, utf8_decode('Desde el '. $fechaFormateadaI. ' hasta el '.$fechaFormateadaF), 0, 0, 'C');

    }else{
      $this->Cell(210, 10, utf8_decode('Entrada Total de Utensilios'), 0, 0, 'C');
      }
    }else{
      $this->Cell(210, 10, utf8_decode('Entrada Total de Utensilios'), 0, 0, 'C');
    }
   
   
    $this->Ln(15);

     // Acceder a la propiedad como un objeto
    $utensilios = $data['detalle'];
    $idInventario = '';
    $fecha='';

    foreach($utensilios as $porFecha){
       if ($fecha != $porFecha->fecha) {
            $this->Ln(5);
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 14);

           setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish');

           $fechaFormateada = strftime('%e de %B del %Y', strtotime($porFecha->fecha));
           $nombreMes = mb_convert_case(strftime('%B', strtotime($porFecha->fecha)), MB_CASE_TITLE, "UTF-8");

           $fechaFormateada = preg_replace('/\b' . mb_strtolower($nombreMes, 'UTF-8') . '\b/', $nombreMes, mb_strtolower($fechaFormateada, 'UTF-8'));

            $this->Cell(185, 8, utf8_decode( $fechaFormateada), 0, 1, 'C');
              $fecha= $porFecha->fecha;

             foreach ($utensilios as $info) {
        if ($idInventario  != $info->idEntradaU  && $fecha == $info->fecha ) {
            $this->Ln(10);
            // Restauración de colores y fuentes
            $horaFormateada = date('h:i A', strtotime($info->hora));
            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(30,163,223);
            $this->SetFont('');

            // Datos de la descripción general en formato de párrafo
            $this->SetFont('Arial', 'B', 13);
            $this->SetTextColor(30,163,223);
            $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L', 1);
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L', 1);
            $this->SetFont('Arial', 'B', 13);
            $this->SetTextColor(30,163,223);
$this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L', 1);

$this->SetFont('Arial', '', 12);
$this->SetTextColor(0);

// Obtener el ancho de la página
$pageWidth = $this->GetPageWidth();
$margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
$usableWidth = $pageWidth - $margins - 30; // Restar el ancho de la celda de la etiqueta

$this->SetX($this->GetX()); // Ajustar la posición X para evitar superposición
$this->MultiCell($usableWidth, 7, utf8_decode($info->descripcion), 0, 'L', 1);

            $this->Ln(5);

            $idInventario = $info->idEntradaU ;

            $tiposProcesados = array(); // Array para evitar repetir tipos

            foreach ($utensilios as $detalle) {
                if ($idInventario == $detalle->idEntradaU  && !in_array($detalle->tipo, $tiposProcesados)) {
                    
                    $this->SetFillColor(9,85,160);
                    $this->SetTextColor(255);
                    $this->SetDrawColor(9,85,160);
                    $this->SetLineWidth(.2);
                    $this->SetFont('Arial', 'B', 14);
                    $this->Cell(0, 8, utf8_decode($detalle->tipo), 1, 1, 'C', true);

                    $this->SetFillColor(30,163,223);
$this->SetTextColor(255);
$this->SetDrawColor(30,163,223);
$this->SetLineWidth(.2);
$this->SetFont('', 'B', 12);

// Obtener el ancho de la página
$pageWidth = $this->GetPageWidth();
$margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
$usableWidth = $pageWidth - $margins;

// Calcular el ancho de cada celda
$widths = array(0.4 * $usableWidth, 0.4 * $usableWidth, 0.2 * $usableWidth);

$this->Cell($widths[0], 6, 'Utensilios', 1, 0, 'L', true);
$this->Cell($widths[1], 6, 'Material', 1, 0, 'L', true);
$this->Cell($widths[2], 6, 'Cantidad', 1, 1, 'L', true);

$this->SetFillColor(255, 255, 255);
$this->SetDrawColor(30,163,223);
$this->SetTextColor(0);
$this->SetFont('');

// Datos de alimentos
foreach ($utensilios as $detalleU) {
    if ($detalle->tipo == $detalleU->tipo && $idInventario == $detalleU->idEntradaU ) {
        $this->Cell($widths[0], 8, utf8_decode($detalleU->nombre), 1, 0, 'L', true);
        $this->Cell($widths[1], 8, utf8_decode($detalleU->material), 1, 0, 'L', true);
        $this->Cell($widths[2], 8, utf8_decode($detalleU->cantidad), 1, 1, 'L', true);
    }
}

                    $this->Ln(6);
                    $tiposProcesados[] = $detalle->tipo; // Marcar tipo como procesado
                }
            }
        }
    }
         
       }

    }   
    
    $this->Ln(6);
  
    if ($fechaI != '' && $fechaF != '') {
      if ($fechaI != $fechaF) {
          $archivo = 'entradaUtensiliosTotal '. $fechaI . ' hasta '. $fechaF.'.pdf';
      }
      else{
         $archivo = 'entradaUtensiliosTotal.pdf';
      }
      }else{
           $archivo = 'entradaUtensiliosTotal.pdf';
      }
  
    $this->Output('D', $archivo);
    die();
}

function stockUtensilios($data){
    ob_end_clean(); // Limpiar el búfer de salida

   // Establecer zona horaria de Venezuela
   date_default_timezone_set('America/Caracas');
   
   // Array para traducir nombres de meses de inglés a español
   $meses_espanol = array(
       'January' => 'Enero',
       'February' => 'Febrero',
       'March' => 'Marzo',
       'April' => 'Abril',
       'May' => 'Mayo',
       'June' => 'Junio',
       'July' => 'Julio',
       'August' => 'Agosto',
       'September' => 'Septiembre',
       'October' => 'Octubre',
       'November' => 'Noviembre',
       'December' => 'Diciembre'
   );

   // Obtener la fecha y hora actual
   $mes_actual = date('F'); // Obtener nombre del mes en inglés
   $mes_actual_spanish = isset($meses_espanol[$mes_actual]) ? $meses_espanol[$mes_actual] : '';

   $fecha_actual = date('d') . ' de ' . $mes_actual_spanish . ' del ' . date('Y');
   $hora_actual = date('g:i A');

   $this->SetTextColor(9,85,160);
   $this->SetFont('Helvetica', 'B', 20);
   // Título
   $this->SetX(0); // Establecer posición X en 0
   $this->Cell(210, 10, utf8_decode('Stock de Utensilios'), 0, 1, 'C');
   $this->Ln(6);
   $this->SetTextColor(0);
   $this->SetFont('Helvetica', 'B', 14);
   // Incluir fecha y hora actual en el encabezado
   $this->Cell(185, 8, utf8_decode( $fecha_actual), 0, 1, 'C');
   $this->Cell(150, 8, utf8_decode( $hora_actual), 0, 1, 'C');
     $this->Ln(25);
   $utensilios = $data['detalle'];
   $utensiliosI = '';
   foreach ($utensilios as $info) {
       if ($utensiliosI != $info->tipo) {
           $this->SetFillColor(9,85,160);
           $this->SetTextColor(255);
           $this->SetDrawColor(9,85,160);
           $this->SetLineWidth(.2);
           $this->SetFont('Arial', 'B', 14);
           $utensiliosI = $info->tipo;

           $this->Cell(0, 8, utf8_decode($info->tipo), 1, 1, 'C', true);

           $this->SetFillColor(30,163,223);
           $this->SetTextColor(255);
           $this->SetDrawColor(30,163,223);
           $this->SetLineWidth(.2);
           $this->SetFont('', 'B', 12);
           
           // Obtener el ancho de la página
           $pageWidth = $this->GetPageWidth();
           $margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
           $usableWidth = $pageWidth - $margins;
           
           // Calcular el ancho de cada celda
           $widths = array(0.4 * $usableWidth, 0.4 * $usableWidth, 0.2 * $usableWidth);
           
           $this->Cell($widths[0], 6, 'Utensilio', 1, 0, 'L', true);
           $this->Cell($widths[1], 6, 'Material', 1, 0, 'L', true);
           $this->Cell($widths[2], 6, 'Stock', 1, 1, 'L', true);
           
           $this->SetFillColor(255, 255, 255);
           $this->SetDrawColor(30,163,223);
           $this->SetTextColor(0);
           $this->SetFont('');
           
           foreach ($utensilios as $detalle) {
               if ($utensiliosI == $detalle->tipo) {
                   $this->Cell($widths[0], 8, utf8_decode($detalle->nombre), 1, 0, 'L', true);
                   $this->Cell($widths[1], 8, utf8_decode($detalle->material), 1, 0, 'L', true);
                   $this->Cell($widths[2], 8, utf8_decode($detalle->stock), 1, 1, 'L', true);
               }
           }
       }
       $this->Ln(6);
   }

   $nombreArchivo = 'stockUtensilios ' . $fecha_actual . '.pdf';
   $this->Output('D', $nombreArchivo);
   die();
}


function salidaUtensilios($data){
    ob_end_clean(); // Limpiar el búfer de salida

   //   $cedula = $data['cedula'];

   $this->SetTextColor(9,85,160);
   $this->SetFont('Helvetica', 'B', 20);
   // Título
   $this->SetX(0); // Establecer posición X en 0
   $this->Cell(210, 10, utf8_decode('Salida de Utensilios'), 0, 0, 'C');
   $this->Ln(25);

  // Datos de la descripcion
   $descripcion = $data['descripcion'];
   $horaFormateada = date('h:i A', strtotime($descripcion[0]->hora));
   $dateTime = new \DateTime($descripcion[0]->fecha);
   $fechaFormateada = $dateTime->format('d-m-y');

   // Datos de la descripción general en formato de párrafo
   $this->SetFont('Arial', 'B', 13);
   $this->SetTextColor(30,163,223);
   $this->Cell(15, 7, utf8_decode('Fecha: '), 0, 0, 'L');
   $this->SetFont('Arial', '', 12);
   $this->SetTextColor(0);
   $this->Cell(50, 7, utf8_decode($fechaFormateada), 0, 1, 'L');
   $this->SetFont('Arial', 'B', 13);
   $this->SetTextColor(30,163,223);
   $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L');
   $this->SetFont('Arial', '', 12);
   $this->SetTextColor(0);
   $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L');

   $this->SetFont('Arial', 'B', 13);
   $this->SetTextColor(30,163,223);
   $this->Cell(30, 7, utf8_decode('Salida por:'), 0, 0, 'L');
   $this->SetFont('Arial', '', 12);
   $this->SetTextColor(0);
   $this->Cell(0, 8, utf8_decode($descripcion[0]->tipoSalida), 0, 1, 'L');
   $this->SetFont('Arial', 'B', 13);
   $this->SetTextColor(30,163,223);
   $this->Cell(30, 7, utf8_decode('Descripción:'), 0, 0, 'L');
   $this->SetFont('Arial', '', 12);
   $this->SetTextColor(0);
   $this->Cell(0, 8, utf8_decode($descripcion[0]->descripcion), 0, 1, 'L');

   $this->Ln(5);

  $utensilios = $data['detalle'];
  $utensiliosI = '';
 foreach ($utensilios as $info) {
   if ($utensiliosI != $info->tipo) {
      $this->SetFillColor(9,85,160);
      $this->SetTextColor(255);
      $this->SetDrawColor(9,85,160);
      $this->SetLineWidth(.2);
      $this->SetFont('Arial', 'B', 14);
      $utensiliosI = $info->tipo;
  
      $this->Cell(0, 8, utf8_decode($info->tipo), 1, 1, 'C', true);
      
      $this->SetFillColor(30,163,223);
      $this->SetTextColor(255);
      $this->SetDrawColor(30,163,223);
      $this->SetLineWidth(.2);
      $this->SetFont('', 'B', 12);
      
      // Obtener el ancho de la página
      $pageWidth = $this->GetPageWidth();
      $margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
      $usableWidth = $pageWidth - $margins;
      
      // Calcular el ancho de cada celda
      $widths = array(0.4 * $usableWidth, 0.4 * $usableWidth, 0.2 * $usableWidth);
      
      $this->Cell($widths[0], 6, 'Utensilio', 1, 0, 'L', true);
      $this->Cell($widths[1], 6, 'Material', 1, 0, 'L', true);
      $this->Cell($widths[2], 6, 'Cantidad', 1, 1, 'L', true);
      
      $this->SetFillColor(255, 255, 255);
      $this->SetDrawColor(30,163,223);
      $this->SetTextColor(0);
      $this->SetFont('');
      
      foreach ($utensilios as $detalle) {
          if ($utensiliosI == $detalle->tipo) {
              $this->Cell($widths[0], 8, utf8_decode($detalle->nombre), 1, 0, 'L', true);
              $this->Cell($widths[1], 8, utf8_decode($detalle->material), 1, 0, 'L', true);
              $this->Cell($widths[2], 8, utf8_decode($detalle->cantidad), 1, 1, 'L', true);
          }
       
       
   }
      
          
       }
       
         $this->Ln(6);
   }


  $archivo = 'salidaUtensilios Fecha '. $descripcion[0]->fecha .'.pdf';
  $this->Output('D', $archivo);
  die();
}

function salidaUtensiliosTotal($data){
    ob_end_clean(); // Limpiar el búfer de salida

     $fechaI = $data['fechaI'];
     $fechaF = $data['fechaF'];
    // Configurar idioma para strftime
    setlocale(LC_TIME, 'es_ES.UTF-8');

    $this->SetTextColor(9,85,160);
    $this->SetFont('Helvetica', 'B', 20);
    // Título
    $this->SetX(0); // Establecer posición X en 0

    
    if ($fechaI != '' && $fechaF != '') {
      if ($fechaI != $fechaF) {
  
           $dateTimeI = new \DateTime($fechaI);
           $dateTimeF = new \DateTime($fechaF);

    // Formatear las fechas al formato d-m-y
    $fechaFormateadaI = $dateTimeI->format('d-m-y');
    $fechaFormateadaF = $dateTimeF->format('d-m-y');

      $this->Cell(210, 10, utf8_decode('Salida Total de Alimentos'), 0, 1, 'C');
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 13);
             $this->Cell(190, 10, utf8_decode('Desde el '. $fechaFormateadaI. ' hasta el '.$fechaFormateadaF), 0, 0, 'C');

      }
       else{
      $this->Cell(210, 10, utf8_decode('Salida Total de Utensilios'), 0, 0, 'C');
      }
    }
     else{
      $this->Cell(210, 10, utf8_decode('Salida Total de Utensilios'), 0, 0, 'C');
    }
   
   
    $this->Ln(15);

     // Acceder a la propiedad como un objeto
    $utensilios = $data['detalle'];
    $idSalida = '';
    $fecha='';
   

    foreach($utensilios as $porFecha){
       if ($fecha != $porFecha->fecha) {
            $this->Ln(5);
            $this->SetTextColor(0);
            $this->SetFont('Arial', 'B', 14);

           setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish');

           $fechaFormateada = strftime('%e de %B del %Y', strtotime($porFecha->fecha));
           $nombreMes = mb_convert_case(strftime('%B', strtotime($porFecha->fecha)), MB_CASE_TITLE, "UTF-8");

           $fechaFormateada = preg_replace('/\b' . mb_strtolower($nombreMes, 'UTF-8') . '\b/', $nombreMes, mb_strtolower($fechaFormateada, 'UTF-8'));

            $this->Cell(185, 8, utf8_decode( $fechaFormateada), 0, 1, 'C');
              $fecha= $porFecha->fecha;

             foreach ($utensilios as $info) {
            if ($idSalida != $info->idSalidaU && $fecha == $info->fecha ) {
            $this->Ln(10);
            // Restauración de colores y fuentes
            $horaFormateada = date('h:i A', strtotime($info->hora));
            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(30,163,223);
            $this->SetFont('');

            // Datos de la descripción general en formato de párrafo
            $this->SetFont('Arial', 'B', 13);
            $this->SetTextColor(30,163,223);
            $this->Cell(15, 7, utf8_decode('Hora: '), 0, 0, 'L', 1);
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->Cell(50, 7, utf8_decode($horaFormateada), 0, 1, 'L', 1);
             $this->SetFont('Arial', 'B', 13);
            $this->SetTextColor(30,163,223);
            $this->Cell(30, 7, utf8_decode('Salida por: '), 0, 0, 'L', 1);
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->Cell(50, 7, utf8_decode($info->tipoSalida), 0, 1, 'L', 1);
            $this->SetFont('Arial', 'B', 13);
            $this->SetTextColor(30,163,223);
            $this->Cell(30, 7, utf8_decode('Descripción: '), 0, 0, 'L', 1);
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->Cell(50, 7, utf8_decode($info->descripcion), 0, 1, 'L', 1);

            $this->Ln(5);

            $idSalida = $info->idSalidaU;

            // Procesar tipos de alimentos por inventario
            $tiposProcesados = array(); // Array para evitar repetir tipos

            foreach ($utensilios as $detalle) {
                if ($idSalida == $detalle->idSalidaU && !in_array($detalle->tipo, $tiposProcesados)) {
                    // Nueva sección para cada tipo de alimento
                    $this->SetFillColor(9,85,160);
                    $this->SetTextColor(255);
                    $this->SetDrawColor(9,85,160);
                    $this->SetLineWidth(.2);
                    $this->SetFont('Arial', 'B', 14);
                    $this->Cell(0, 8, utf8_decode($detalle->tipo), 1, 1, 'C', true);

                    $this->SetFillColor(30,163,223);
                    $this->SetTextColor(255);
                    $this->SetDrawColor(30,163,223);
                    $this->SetLineWidth(.2);
                    $this->SetFont('', 'B', 12);
                    
                    // Obtener el ancho de la página
                    $pageWidth = $this->GetPageWidth();
                    $margins = $this->lMargin + $this->rMargin; // Márgenes izquierdo y derecho
                    $usableWidth = $pageWidth - $margins;
                    
                    // Calcular el ancho de cada celda
                    $widths = array(0.4 * $usableWidth, 0.4 * $usableWidth, 0.2 * $usableWidth);
                    
                    $this->Cell($widths[0], 6, 'Utensilio', 1, 0, 'L', true);
                    $this->Cell($widths[1], 6, 'Material', 1, 0, 'L', true);
                    $this->Cell($widths[2], 6, 'Cantidad', 1, 1, 'L', true);
                    
                    $this->SetFillColor(255, 255, 255);
                    $this->SetDrawColor(30,163,223);
                    $this->SetTextColor(0);
                    $this->SetFont('');
                    
                    // Datos de alimentos
                    foreach ($utensilios as $detalleU) {
                        if ($detalle->tipo == $detalleU->tipo && $idSalida == $detalleU->idSalidaU) {
                            $this->Cell($widths[0], 8, utf8_decode($detalleU->nombre), 1, 0, 'L', true);
                            $this->Cell($widths[1], 8, utf8_decode($detalleU->material), 1, 0, 'L', true);
                            $this->Cell($widths[2], 8, utf8_decode($detalleU->cantidad), 1, 1, 'L', true);
                        }
                    }

                    $this->Ln(6);
                    $tiposProcesados[] = $detalle->tipo; // Marcar tipo como procesado
                }
            }
        }
    }
         
       }

    }

   
    
    $this->Ln(6);
  
    if ($fechaI != '' && $fechaF != '') {
      if ($fechaI != $fechaF) {
          $archivo = 'salidaUtensiliosTotal '.$fechaI.' hasta '.$fechaF.'.pdf';
      }
      else{
         $archivo = 'salidaUtensiliosTotal.pdf';
      }
      }else{
           $archivo = 'salidaUtensiliosTotal.pdf';
      }
  
    $this->Output('D', $archivo);
    die();
}




// -------------------- GRAFICA ------------

function reporteGrafica($data){
        ob_end_clean(); // Limpiar el búfer de salida
       $img = $data['img'];
       $cabecera = $data['cabecera'];
       $fecha= $data['fecha'];
       
       $this->Ln(10);
       $this->SetTextColor(9, 85, 160);
       $this->SetFont('Helvetica', 'B', 20);
       // Título
       $this->SetX(0); // Establecer posición X en 0
       $this->Cell(210, 10, utf8_decode('Reporte Estadístico'), 0, 1, 'C');
       
       $this->SetTextColor(0, 0, 0);
       $this->SetFont('Helvetica', 'B', 14);
       $this->Cell(190, 10, utf8_decode($cabecera), 0, 1, 'C');
       if ($fecha != 'Seleccionar') {
          $fechaDateTime = new \DateTime($fecha);
          $fechaReporte = $fechaDateTime->format('d-m-Y');
            $this->Cell(190, 10, utf8_decode($fechaReporte), 0, 1, 'C');
       }
       $this->Ln(20);
       $this->Image($img, 10, 95, 190,60,'PNG');
       $this->Ln(65);

       $datos = $data['datos'];
       $titulos = $data['titulos'];
       
        $this->SetFillColor(30, 163, 223);
        $this->SetTextColor(255);
        $this->SetDrawColor(30, 163, 223);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 12);

    // Cabecera para antecedentes
    $this->Cell(70, 8, utf8_decode($titulos['cam1']), 1, 0, 'C', true);
     $this->Cell(70, 8, utf8_decode($titulos['cam2']), 1, 0, 'C', true);
      $this->Cell(50, 8, utf8_decode($titulos['cam3']), 1, 1, 'C', true);

        // Restauración de colores y fuentes
        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(30, 163, 223);
        $this->SetTextColor(0);
        $this->SetFont('');
       
    

    // Mostrar datos de antecedentes
    foreach ($datos as $data) {
        if ($data->cantidad != 0) {
        $this->Cell(70, 7, utf8_decode($data->nombre), 1, 0, 'C', true);
         $this->Cell(70, 7, utf8_decode($data->cantidad),  1, 0, 'C', true);
         $this->Cell(50, 7, utf8_decode($data->porcentaje . ' %'),  1, 1, 'C', true);
        }
    }
       if ($fecha != 'Seleccionar') {
          $fechaDateTime = new \DateTime($fecha);
          $fechaReporte = $fechaDateTime->format('d-m-Y');

          $archivo = 'Reporte Estadistico '.$cabecera.' '. $fechaReporte .'.pdf';
       }
       else{
          $archivo = 'Reporte Estadistico '.$cabecera.'.pdf';
       }
        
        $this->Output('D', $archivo);
        die();
    }



}








   

 

?>