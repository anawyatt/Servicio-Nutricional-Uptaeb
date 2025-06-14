<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Roles |Servicio Nutricional UPTAEB</title>
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
                                    <h1 class="fw-bold blanco">Roles</h1>
                                    <nav>
                                        <ol class="breadcrumb">
                                            <?php
                                            if (isset($permisos['Home']['consultar'])) {
                                                echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                                            }
                                            if (isset($permisos['Permisos']['consultar'])) {
                                                echo '    <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('permiso')) . '"> Permisos</a></li>';
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
                    <img src="assets/images/dashboard/header.png" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>


            <div class="conatiner-fluid content-inner mt-n5 py-0">
                <div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-header d-flex justify-content-end flex-wrap" align="end">

                                    <div class="agrega" align="end">
                                        <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-2"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <i class="btn-inner">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </i>
                                            <span>Nuevo Rol</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="ani">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover tabla2">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th class="title fw-bold">Roles del Sistema</th>
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




            <!-- Footer Section Start -->


            <!-- MODAL REGISTRAR -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-azul4">
                            <h5 class="modal-title title" id="staticBackdropLabel">Registrar Rol</h5>
                            <button type="button" id="cerrar" class="btn-close limpiar" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST" class="p-2" id="registrarM">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                            <div class="modal-body mb-2">
                                <div class="wave-group p-2  my-2 mb-2">
                                    <input required="" type="text" class="input rol" id="rol">
                                    <span class="bar bar1"></span>
                                    <label class="label labelPri ic1">
                                        <span class="label-char pl-2 letra"
                                            style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M21.9964 8.37513H17.7618C15.7911 8.37859 14.1947 9.93514 14.1911 11.8566C14.1884 13.7823 15.7867 15.3458 17.7618 15.3484H22V15.6543C22 19.0136 19.9636 21 16.5173 21H7.48356C4.03644 21 2 19.0136 2 15.6543V8.33786C2 4.97862 4.03644 3 7.48356 3H16.5138C19.96 3 21.9964 4.97862 21.9964 8.33786V8.37513ZM6.73956 8.36733H12.3796H12.3831H12.3902C12.8124 8.36559 13.1538 8.03019 13.152 7.61765C13.1502 7.20598 12.8053 6.87318 12.3831 6.87491H6.73956C6.32 6.87664 5.97956 7.20858 5.97778 7.61852C5.976 8.03019 6.31733 8.36559 6.73956 8.36733Z"
                                                        fill="currentColor"></path>
                                                    <path opacity="0.4"
                                                        d="M16.0374 12.2966C16.2465 13.2478 17.0805 13.917 18.0326 13.8996H21.2825C21.6787 13.8996 22 13.5715 22 13.166V10.6344C21.9991 10.2297 21.6787 9.90077 21.2825 9.8999H17.9561C16.8731 9.90338 15.9983 10.8024 16 11.9102C16 12.0398 16.0128 12.1695 16.0374 12.2966Z"
                                                        fill="currentColor"></path>
                                                    <circle cx="18" cy="11.8999" r="1" fill="currentColor"></circle>
                                                </svg>
                                            </i> </span>
                                        <span class="label-char letra" style="--index: 0">R</span>
                                        <span class="label-char letra" style="--index: 1">o</span>
                                        <span class="label-char letra" style="--index: 2">l</span>

                                    </label>
                                    <p class=" text-center l er error1"></p>

                                </div>


                            </div>
                            <div class="modal-footer">
                                <div id="spinner" class=" mb-3 w-100" style="display: none;">
                                    <div class="spinner-border text-primary me-2" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                    <span style="font-size: 12px;">Generando permisos para el rol...</span>
                                </div>
                                <div class="text-start">
                                    <button type="reset" class="btn btn-danger limpiar">Cancelar</button>
                                    <button id="registrar" type="button" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>



                    </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- MODAL EDITAR -->
        <div class="modal fade" id="ediatarModulos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-azul4">
                        <h5 class="modal-title title" id="staticBackdropLabel">Modificar Rol</h5>
                        <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" class="p-2" id="modificarM">
                        <input type="hidden" name="" id="idd">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                        <div class="modal-body mb-2">
                            <div class="wave-group p-2  my-2 mb-2">
                                <input required="" type="text" class="input rol2 " id="rol2">
                                <span class="bar bar2"></span>
                                <label class="label labelPri ic2">
                                    <span class="label-char pl-2 letra2"
                                        style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                            <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M21.9964 8.37513H17.7618C15.7911 8.37859 14.1947 9.93514 14.1911 11.8566C14.1884 13.7823 15.7867 15.3458 17.7618 15.3484H22V15.6543C22 19.0136 19.9636 21 16.5173 21H7.48356C4.03644 21 2 19.0136 2 15.6543V8.33786C2 4.97862 4.03644 3 7.48356 3H16.5138C19.96 3 21.9964 4.97862 21.9964 8.33786V8.37513ZM6.73956 8.36733H12.3796H12.3831H12.3902C12.8124 8.36559 13.1538 8.03019 13.152 7.61765C13.1502 7.20598 12.8053 6.87318 12.3831 6.87491H6.73956C6.32 6.87664 5.97956 7.20858 5.97778 7.61852C5.976 8.03019 6.31733 8.36559 6.73956 8.36733Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.4"
                                                    d="M16.0374 12.2966C16.2465 13.2478 17.0805 13.917 18.0326 13.8996H21.2825C21.6787 13.8996 22 13.5715 22 13.166V10.6344C21.9991 10.2297 21.6787 9.90077 21.2825 9.8999H17.9561C16.8731 9.90338 15.9983 10.8024 16 11.9102C16 12.0398 16.0128 12.1695 16.0374 12.2966Z"
                                                    fill="currentColor"></path>
                                                <circle cx="18" cy="11.8999" r="1" fill="currentColor"></circle>
                                            </svg>
                                        </i> </span>
                                    <span class="label-char letra2" style="--index: 0">R</span>
                                    <span class="label-char letra2" style="--index: 1">o</span>
                                    <span class="label-char letra2" style="--index: 2">l</span>

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
        <div class="modal fade" id="borrarModulos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-azul4">
                        <h5 class="modal-title title" id="staticBackdropLabel">Eliminar Rol</h5>
                        <button type="button" id="cerrar3" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" id="eliminarRol">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                        <div class="modal-body mb-2">
                            <div align="center">
                                <img src="assets/images/basura.png" width="250">
                            </div>

                            <h5 class="eliminarR text-center"></h5>

                        </div>
                        <div class="modal-footer">
                            <div class="text-start">
                                <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal"
                                    id="cerrar3">Cancelar</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="borrar"
                                    name="anular">Eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $footer->footer(); ?>
        <!-- Footer Section End -->
    </main>
    <?php $configuracion->configuracion(); ?>
    </div>
    <?php $components->componentsJS(); ?>
    <script src="assets/js/roles/roles.js"></script>
    <script src="assets/js/close.js"></script>
</body>

</html>