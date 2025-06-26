<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Estudiantes | Servicio Nutricional UPTAEB</title>
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
                  <h1 class="fw-bold blanco">Estudiantes</h1>
                  <nav>
                    <ol class="breadcrumb">
                      <?php

                      if (isset($permisos['Home']['consultar'])) {
                        echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                      }
                      if (isset($permisos['Asistencias']['registrar'])) {
                        echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('asistencia')) . '">Asistencias</a></li>';
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
                <div class="card-header d-flex justify-content-end flex-wrap">

                  <div class="agregar">
                    <a href="#" class="protected protected-agregar text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#agregar">
                      <i class="btn-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                      </i>
                      <span>Agregar Data</span>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div>
                    <!-- El spinner de carga superpuesto -->

                    <div id="loading-spinner" class="loading-overlay">
                      <div class="spinner-container">
                        <div class="spinner-border text-primary" role="status">
                          <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando datos...</p>
                      </div>
                    </div>


                    <div id="ani">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover tabla">
                          <thead class="table-success">
                            <tr>
                              <th class="title fw-bold">Cédula</th>
                              <th class="title fw-bold">Nombre - Apellido</th>
                              <th class="title fw-bold">Carrera</th>
                              <th class="title fw-bold">Sección</th>
                              <th class="title fw-bold accion justify-content-center align-center">Acciones</th>

                            </tr>
                          </thead>
                          <tbody id="tbody"></tbody>
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

        <div class="modal fade" id="consultarStudy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-azul4">
                <h5 class="modal-title title" id="staticBackdropLabel">Información del Estudiantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body mb-2 mt-2 row">
                <div class="col-12 m-auto mb-2" id="imag" align="center">

                </div>
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                      <thead class="table-success">
                        <tr>
                          <th class="blanco">Cédula</th>
                          <th class=" blanco">Nombre</th>
                          <th class=" blanco">Apellido</th>
                        </tr>
                      </thead>
                      <tbody id="info1"></tbody>
                    </table>

                    <table class="table table-hover table-bordered">
                      <thead class="table-success">
                        <tr>
                          <th class="blanco">Sexo</th>
                          <th class="blanco">Teléfono</th>
                          <th class="blanco">Nucleo</th>
                          <th class="blanco">Carrera</th>
                        </tr>
                      </thead>
                      <tbody id="info2"> </tbody>
                    </table>

                    <table class="table table-hover table-bordered">
                      <thead class="table-success">
                        <tr>

                          <th class="blanco">Sección</th>
                          <th class="blanco">Horario</th>
                        </tr>
                      </thead>
                      <tbody id="info3"> </tbody>
                    </table>


                  </div>
                </div>


              </div>
              <div class="modal-footer">
                <div class="text-start">
                  <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal">Cerrar</button>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer Section Start -->

        <div class="modal fade" id="agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-azul4">
                <h1 class="modal-title fs-5  title" id="staticBackdropLabel">Registrar Data de los Estudiantes</h1>
                <button type="button" class="btn-close cerrarData" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="alerts" data-aos="fade-up" data-aos-delay="1000">
                  <div class="alert alert-top alert-info alert-dismissible fade show h-5" role="alert">
                    <p style="font-size: 13px!important;" align="justify">
                      <svg class="icon-30" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M4.72251 21.1672C4.70951 21.1672 4.69751 21.1672 4.68351 21.1662C4.36851 21.1502 4.05951 21.0822 3.76551 20.9632C2.31851 20.3752 1.62051 18.7222 2.20751 17.2762L9.52851 4.45025C9.78051 3.99425 10.1625 3.61225 10.6285 3.35425C11.9935 2.59825 13.7195 3.09525 14.4745 4.45925L21.7475 17.1872C21.9095 17.5682 21.9785 17.8782 21.9955 18.1942C22.0345 18.9502 21.7765 19.6752 21.2705 20.2362C20.7645 20.7972 20.0695 21.1282 19.3145 21.1662L4.79451 21.1672H4.72251Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1245 10.0208C11.1245 9.53875 11.5175 9.14575 11.9995 9.14575C12.4815 9.14575 12.8745 9.53875 12.8745 10.0208V12.8488C12.8745 13.3318 12.4815 13.7238 11.9995 13.7238C11.5175 13.7238 11.1245 13.3318 11.1245 12.8488V10.0208ZM11.1245 16.2699C11.1245 15.7849 11.5175 15.3899 11.9995 15.3899C12.4815 15.3899 12.8745 15.7799 12.8745 16.2589C12.8745 16.7519 12.4815 17.1449 11.9995 17.1449C11.5175 17.1449 11.1245 16.7519 11.1245 16.2699Z" fill="currentColor"></path>
                      </svg>
                      En esta sección, podrás registrar o actualizar la información de los estudiantes mediante un archivo Excel. Asegúrate de que el archivo contenga los datos necesarios, siendo los campos obligatorios: cédula, nombre, apellido, sexo, núcleo, carrera, sección y horario.
                      <a href="#" class="fw-bold" id="descargarArchivoExceldeEjemplo">Descargar Plantilla de Ejemplo</a>
                    </p>
                    <button type="button" class="btn-close btn-primary" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                </div>

                <form id="uploadForm" enctype="multipart/form-data" class="vaciar">
                  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                  <div class="form-group">
                    <label for="file" class="label labelPri ic1"><span class="label-char letra" style="--index: 0">Selecciona un archivo Excel:</span></label>
                    <input type="file" id="file" name="file" class="form-control input imagen" accept=".xlsx, .xls">
                  </div>
                  <div class="progress" style="display: none;">
                    <div id="Barra_de_Proceso" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                  </div>
                  <br>
                  <div class="modal-footer">
                    <div class="text-start">
                      <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" id="uploadButton" disabled>Registrar</button>

                      <button type="button" class="btn btn-danger" id="cancelButton" style="display: none;">Cancelar</button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>


  </main>
  <?php $footer->footer(); ?>

  <?php $configuracion->configuracion(); ?>

  <?php $components->componentsJS(); ?>

  <script src="assets/js/estudiantes/estudiantes.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
</body>

</html>