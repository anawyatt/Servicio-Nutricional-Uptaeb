<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Consultar Asistencia | Servicio Nutricional UPTAEB</title>
    <?php $components->componentsHeader(); ?>
    <link rel="stylesheet" href="assets/css/estilo.css" />

</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <!--//////////////// SIDEBAR ///////////////////////////////////////////-->
    <?php $sidebar->sidebar(); ?>
    <main class="main-content">
        <!--Nav Start-->
        <?php $navegador->navegador(); ?>
        <div class="position-relative iq-banner">
            <!-- /////// HEADER //////// -->

            <div class="iq-navbar-header " style="height: 215px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <div class=" col-md-7">
                                    <h1 class="fw-bold blanco">Consultar Asistencia</h1>
                                    <nav>
                                        <ol class="breadcrumb">
                                            <?php
                                            if (isset($permisos['Home']['consultar'])) {
                                                echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                                            }
                                            if (isset($permisos['Asistencias']['registrar'])) {
                                                echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('asistencia')) . '">Asistencia</a></li>
                                      ';
                                            }

                                            ?>
                                        </ol>
                                    </nav>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="assets/images/dashboard/header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>


            <div class="conatiner-fluid content-inner mt-n5 py-0">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="700">
                            <div class="card-header d-flex justify-content-between flex-wrap">
                                <div class=" d-flex">

                                    <div class="checkbox p-1">
                                        <input id="cbx" type="checkbox" class="activarFiltro" />
                                        <label class="toggle" for="cbx"><span></span></label>
                                    </div>
                                    <div class="p-1">
                                        <span>Filtrar Por </span>
                                    </div>

                                </div>



                                <div class="agregar">
                                    <button class="protected protected-agregar text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" disabled="true" data-bs-target="#pdfAsistencia" id="botonPDF">
                                        <i class="ri-download-line icon-24"></i>
                                        <span>Descargar PDF</span>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-row row mb-2" id="mostrar" style="display: none;">
                                    <div class="form-group col-md-4 row ">
                                        <div class=" col-12">
                                            <input type="checkbox" class="form-check-input" id="ultimo_Registro">
                                            <label class="form-check-label" for="">Último Registro</label>
                                        </div>


                                        <div class="col-12" id="muestraU">
                                            <div class="col-9 wave-group p-2  my-2">
                                                <input required="" type="text" class="input " id="ultima" disabled="true">
                                                <span class="bar bar"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 row">
                                        <div class="col-12 mb-2">
                                            <input type="checkbox" class="form-check-input" id="porFecha">
                                            <label class="form-check-label" for="">Fecha</label>
                                        </div>
                                        <div class="col-12">

                                            <div class="wave-group p-2 " id="sel2">
                                                <select class="input fecha" id="selectFecha">
                                                    <option value="Seleccionar">Seleccionar</option>
                                                </select>
                                                <span class="bar bar3"></span>
                                                <p class=" text-center l er error3"></p>

                                            </div>
                                        </div>



                                    </div>
                                    <?php if (!empty($payload->horario_comida) && $payload->horario_comida !== 'null') {
                                        echo '<div class="d-none"><input type="hidden" id="selectHorario" value="Seleccionar" class="d-none" ></div>';
                                    } else {
                                        echo   ' <div class="form-group col-md-4 row">
                                                 <div class="col-12">
                                                    <input type="checkbox" class="form-check-input" id="porHorario">
                                                    <label class="form-check-label" for="">Horario</label>
                                                </div>
            
                                            <div class="col-12">
                                                
                                        <div class="wave-group p-2 "  id="sel3">
                                        <select class="input Horario" id="selectHorario">
                                            <option value="Seleccionar">Seleccionar</option>
                                            </select>
                                                <span class="bar bar4"></span>
                                                <p  class=" text-center l er error4"  ></p>
                            
                                        </div>
                                    </div>

                                                </div>';
                                    } ?>
                                </div>
                                <div id="ani">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover tabla">
                                            <thead class="table-success">
                                                <tr>
                                                    <th class="title fw-bold">Cédula</th>
                                                    <th class="title fw-bold">Nombre - Apellido</th>
                                                    <th class="title fw-bold">Carrera</th>
                                                    <th class="title fw-bold">Horarios</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tbody_Asistencia"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>




            <div class="modal fade" id="pdfAsistencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title">Generar Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" id="idReporte" target="_blank" style="display: inline;">

                            <div class="modal-body mb-2 ">
                                <div align="center" class="mb-2">
                                    <img src="assets/images/pdf.png" width="180">
                                </div>
                                <h5 class="text-center">¿Deseas Descargar las Asistencias?</h5>
                            </div>
                            <!-- Animation Div -->
                            <div class="loadingAnimation" style="display:none;">
                                <div class="spinner"></div>
                            </div>

                            <div class="modal-footer">
                                <div class="text-start">
                                    <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="clos">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="reportebtn">Decargar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


    </main>

    <?php $footer->footer(); ?>
    <?php $configuracion->configuracion(); ?>
    </div>
    <?php $components->componentsJS(); ?>
    <script type="text/javascript" src="assets/js/asistencia/consultarAsistencia.js"></script>
    <script src="assets/js/close.js"></script>
</body>

</html>