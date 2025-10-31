<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tipos de Salida | Servicio Nutricional UPTAEB</title>
    <?php $components->componentsHeader(); ?>
    <script src="assets/js/close.js"></script>
    <link rel="stylesheet" href="assets/css/estilo.css" />
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script>
        window.userCedulaGlobal = "<?php echo $payload->cedula ?>";
    </script>

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
                                    <h1 class="fw-bold blanco">Tipos de Salida</h1>
                                    <nav>
                                        <ol class="breadcrumb">
                                            <?php
                                            if (isset($permisos['Home']['consultar'])) {
                                                echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                                            }
                                            if (isset($permisos['Inventario de Alimentos']['registrar'])) {
                                                echo '     <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('salidaAlimentos')) . '">Registrar Salida de Alimentos</a></li>';
                                            }
                                            if (isset($permisos['Inventario de Utensilios']['registrar'])) {
                                                echo '
                                        <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('salidaUtensilios')) . '"> Registrar Salida de Utensilios</a></li>';
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
                <div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-header d-flex justify-content-end flex-wrap">

                                    <div class="agregar">
                                        <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#registrarTS">
                                            <i class="btn-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </i>
                                            <span>Nuevo Tipo</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="ani">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover tabla">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th class="title fw-bold">Tipos de Salida</th>
                                                        <th class="title fw-bold accion">Acciones</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbody" class="tbody">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL REGISTRAR -->
            <div class="modal fade" id="registrarTS" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title" id="staticBackdropLabel">Registrar Tipo de Salida</h5>
                            <button type="button" id="cerrar" class="btn-close limpiar cierra" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" class="p-2 formu" id="registrarM">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                            <div class="modal-body mb-2">
                                <div class="wave-group p-2  my-2 mb-2">
                                    <input required="" type="text" class="input tipoS" id="tipoS">
                                    <span class="bar bar1"></span>
                                    <label class="label labelPri ic1">
                                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                                <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                                                    <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                                                </svg>
                                            </i> </span>
                                        <span class="label-char letra" style="--index: 0">Tipo de Salida</span>
                                    </label>
                                    <p class=" text-center l er error1"></p>

                                </div>


                            </div>
                            <div class="modal-footer">

                                <div class="text-start">
                                    <button type="reset" class="btn btn-danger limpiar">Cancelar</button>
                                    <button id="registrar" type="button" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>



                    </div>
                    </form>
                </div>
            </div>



            <!-- MODAL EDITAR -->
            <div class="modal fade" id="modificarTS" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title" id="staticBackdropLabel">Modificar Tipo Salida</h5>
                            <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" class="p-2" id="modificarM">
                            <input type="hidden" name="csrf_token" id="tokenCsrfModificar"
                                value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                            <input type="hidden" name="" id="idd">
                            <div class="modal-body mb-2">
                                <div class="wave-group p-2  my-2 mb-2">
                                    <input required="" type="text" class="input tipoS2 " id="tipoS2">
                                    <span class="bar bar2"></span>
                                    <label class="label labelPri ic2">
                                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                                <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                                                    <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                                                </svg>
                                            </i> </span>
                                        <span class="label-char letra2" style="--index: 0">T</span>
                                        <span class="label-char letra2" style="--index: 1">i</span>
                                        <span class="label-char letra2" style="--index: 1">p</span>
                                        <span class="label-char letra2" style="--index: 2; margin-right: 3px!important;">o</span>
                                        <span class="label-char letra2" style="--index: 2">d</span>
                                        <span class="label-char letra2" style="--index: 3; margin-right: 3px!important;">e</span>
                                        <span class="label-char letra2" style="--index: 3">S</span>
                                        <span class="label-char letra2" style="--index: 4">a</span>
                                        <span class="label-char letra2" style="--index: 4">l</span>
                                        <span class="label-char letra2" style="--index: 5">i</span>
                                        <span class="label-char letra2" style="--index: 5">d</span>
                                        <span class="label-char letra2" style="--index: 6">a</span>
                                    </label>
                                    <p class=" text-center l er error2"></p>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <div class="text-start">

                                    <button type="button" class="btn btn-danger resetear">Cancelar</button>
                                    <button id="editar" type="button" class="btn btn-primary">Modificar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MODAL BORRAR -->

            <div class="modal fade" id="eliminaT" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title" id="staticBackdropLabel">Anular Tipo de Salida</h5>
                            <button type="button" class="btn-close btn-primary" aria-label="Close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" id="eliminarU">
                            <input type="hidden" name="csrf_token" id="tokenCsrfEliminar"
                                value="<?php echo htmlspecialchars($tokenCsrf); ?>">

                            <div class="modal-body mb-2">
                                <div align="center">
                                    <img src="assets/images/basura.png" width="250">
                                </div>

                                <h5 class="eliminarTS text-center"></h5>

                            </div>
                            <div class="modal-footer">
                                <div class="text-start">
                                    <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="cerrar3">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="borrar" name="borrar">Anular</button>
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
    <script src="assets/js/tipoSalida/tipoSalida.js"></script>
</body>

</html>