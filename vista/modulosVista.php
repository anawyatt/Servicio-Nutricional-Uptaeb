<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Módulos | Servicio Nutricional UPTAEB</title>
    <?php $components->componentsHeader(); ?>
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
                                    <h1 class="fw-bold blanco">Módulos</h1>
                                    <nav>
                                        <ol class="breadcrumb">
                                            <?php
                                            if (isset($permisos['Home']['consultar'])) {
                                                echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                                            }
                                            if (isset($permisos['Permisos']['consultar'])) {
                                                echo '   <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('permiso')) . '">Permisos</a></li>';
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
                    <img src="assets/images/dashboard/header2.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>


            <div class="conatiner-fluid content-inner mt-n5 py-0">
                <div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-header d-flex justify-content-between flex-wrap">

                                </div>
                                <div class="card-body">
                                    <div id="ani">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover tabla">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th class="title fw-bold">Módulos del Sistema</th>
                                                        <th class="blanco fw-bold">Estado</th>
                                                        <th class="title fw-bold accion">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_modulos">


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
            <div class="modal fade" id="ediatarModulos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title" id="staticBackdropLabel">Modificar Módulo</h5>
                            <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" class="p-2" id="modificarM">
                            <input type="hidden" name="" id="idd">
                            <div class="modal-body mb-2">


                                <div class="wave-group p-2 col-md-12 my-2 " id='sel'>
                                    <select class="input estado " id="nombre_modulos_edit">
                                        <option value=1> Activo</option>
                                        <option value=2> Inactivo</option>
                                    </select>
                                    <span class="bar bar9"></span>
                                    <label class="label labelPri ic9">
                                        <span class="label-char pl-2 letra9" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.4" d="M11.9912 18.6215L5.49945 21.864C5.00921 22.1302 4.39768 21.9525 4.12348 21.4643C4.0434 21.3108 4.00106 21.1402 4 20.9668V13.7087C4 14.4283 4.40573 14.8725 5.47299 15.37L11.9912 18.6215Z" fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.89526 2H15.0695C17.7773 2 19.9735 3.06605 20 5.79337V20.9668C19.9989 21.1374 19.9565 21.3051 19.8765 21.4554C19.7479 21.7007 19.5259 21.8827 19.2615 21.9598C18.997 22.0368 18.7128 22.0023 18.4741 21.8641L11.9912 18.6215L5.47299 15.3701C4.40573 14.8726 4 14.4284 4 13.7088V5.79337C4 3.06605 6.19625 2 8.89526 2ZM8.22492 9.62227H15.7486C16.1822 9.62227 16.5336 9.26828 16.5336 8.83162C16.5336 8.39495 16.1822 8.04096 15.7486 8.04096H8.22492C7.79137 8.04096 7.43991 8.39495 7.43991 8.83162C7.43991 9.26828 7.79137 9.62227 8.22492 9.62227Z" fill="currentColor"></path>
                                                </svg>
                                            </i> </span>
                                        <span class="label-char letra9" style="--index: 0">E</span>
                                        <span class="label-char letra9" style="--index: 1">s</span>
                                        <span class="label-char letra9" style="--index: 2">t</span>
                                        <span class="label-char letra9" style="--index: 3">a</span>
                                        <span class="label-char letra9" style="--index: 3">d</span>
                                        <span class="label-char letra9" style="--index: 4">o</span>

                                    </label>
                                    <p class=" text-center l er error9"></p>

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



    </main>
    <?php $footer->footer(); ?>
    <?php $configuracion->configuracion(); ?>

    <?php $components->componentsJS(); ?>
    <script src="assets/js/modulos/modulos.js"></script>
    <script src="assets/js/close.js"></script>
</body>

</html>