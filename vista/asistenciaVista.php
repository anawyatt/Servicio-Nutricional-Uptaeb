<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registrar Asistencia | Servicio Nutricional UPTAEB</title>
  <?php $components->componentsHeader(); ?>
  <link rel="stylesheet" href="assets/css/estilo.css" />
  <link rel="stylesheet" href="assets/css/asistencia.css">
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
      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class=" col-12">
                  <h1 class="fw-bold blanco">Registrar Asistencia</h1>
                  <nav>
                    <ol class="breadcrumb">
                      <?php
                      if (isset($permisos['Home']['consultar'])) {
                        echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                      }
                      if (isset($permisos['Estudiantes']['consultar'])) {
                        echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('estudiantes')) . '">Consultar Estudiantes</a></li>';
                      }
                      if (isset($permisos['Asistencias']['consultar'])) {
                        echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('consultarAsistencia')) . '">Consultar Asistencias</a></li>
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
          <img src="assets/images/dashboard/header2.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
      </div> <!-- Nav Header Component End -->
      <!--Nav End-->
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1 ">



            </div>
          </div>
        </div>


        <div class="container col-md-6" data-aos="fade-up" data-aos-delay="1500">
          <div class="card shadow">
            <div class="row p-3">
              <div class="col-10">
                <h5 class="card-title azul5">Buscar Estudiante</h5>
              </div>
              <div class="col-2">
                <div class="filter" align="end">
                  <a class="icon " href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots icon-32 "></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Excepciones</h6>
                    </li>
                    <li><a class="dropdown-item protected" href="#" data-bs-toggle="modal" data-bs-target="#estudiantes">• Estudiante no existe</a></li>
                    <li><a class="dropdown-item protected" href="#" data-bs-toggle="modal" data-bs-target="#justificativo">• Justificativo </a></li>
                  </ul>
                </div>
              </div>

            </div>
            <div class="card-body">
              <!-- Line Chart -->
              <div class="panel panel-primary">
                <div class="panel-body">
                  <div class="form-group">

                    <div class="row">
                      <div class="wave-group col-10">
                        <input required="" type="number" id="inputCedula" class="input cedula">
                        <span class="bar bar1CE"></span>
                        <label class="label labelPri ic1">
                          <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;">
                            <i class="">
                              <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                                <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                              </svg>
                            </i>
                          </span>
                          <span class="label-char letra" style="--index: 0">Cédula</span>
                        </label>
                        <p class="text-center l er error1ce" id="error1ce"></p>
                      </div>

                      <div class="form-group col-2 d-flex align-items-center">
                        <button id="btnBuscar" name="btnBuscar" type="button" class="btn p-0 buscar">
                          <i class="bi bi-search azul5" style="font-size: 30px;"></i>
                        </button>
                      </div>
                    </div>

                  </div>

                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault"> <i class="bi bi-camera-fill"></i> Encender Cámara</label>
                  </div>
                  <div class="contenedor" style="position:relative; display:none;">
                    <video id="preview" style="border: 1px solid #CCC; border-radius: 5px; width: 100%; position: relative;">
                    </video>
                    <div id="qr-detection" class="hidden"></div>
                    <div id="error-message" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.7); color: white; padding: 20px; border-radius: 10px; text-align: center;">
                      <p>No se pudo activar la cámara. Por favor, recargue la página o verifique si esta activo los permisos e intente de nuevo.</p>
                    </div>
                  </div>

                </div>
                <div class="panel-footer">
                  <audio id="lectura">
                    <source src="assets\js\asistencia\sounds\success.mp3">
                  </audio>
                </div>
              </div>
              <!-- End Line Chart -->

            </div>

          </div>

          <div class="card shadow">
            <div class="card-body  ">
              <div class="col-10">
                <h5 class="card-title azul5 mb-4">Datos del Estudiante</h5>
              </div>
              <form class="form-Study container">
                <div class="form-row row ">
                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="nombre" class="input cedula" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="defecto " style="--index: 0">Nombre</span>
                    </label>

                  </div>


                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="segundoNombre" class="input" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="defecto " style="--index: 0">Segundo Nombre</span>
                    </label>

                  </div>

                </div>
                <div class="form-row row">

                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="apellido" class="input" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"><i class="ri-edit-fill "></i> </span>
                      <span class="defecto " style="--index: 0">Apellido</span>
                    </label>

                  </div>

                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="segundoApellido" class="input" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="defecto " style="--index: 0">Segundo Apellido</span>
                    </label>

                  </div>
                </div>
                <div class="form-row row">

                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="sexo" class="input" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M176 288a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM352 176c0 86.3-62.1 158.1-144 173.1V384h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H208v32c0 17.7-14.3 32-32 32s-32-14.3-32-32V448H112c-17.7 0-32-14.3-32-32s14.3-32 32-32h32V349.1C62.1 334.1 0 262.3 0 176C0 78.8 78.8 0 176 0s176 78.8 176 176zM271.9 360.6c19.3-10.1 36.9-23.1 52.1-38.4c20 18.5 46.7 29.8 76.1 29.8c61.9 0 112-50.1 112-112s-50.1-112-112-112c-7.2 0-14.3 .7-21.1 2c-4.9-21.5-13-41.7-24-60.2C369.3 66 384.4 64 400 64c37 0 71.4 11.4 99.8 31l20.6-20.6L487 41c-6.9-6.9-8.9-17.2-5.2-26.2S494.3 0 504 0H616c13.3 0 24 10.7 24 24V136c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-33.4-33.4L545 140.2c19.5 28.4 31 62.7 31 99.8c0 97.2-78.8 176-176 176c-50.5 0-96-21.3-128.1-55.4z" />
                          </svg>
                        </i> </span>
                      <span class="defecto " style="--index: 0">Sexo</span>
                    </label>

                  </div>

                  <div class="wave-group p-2 col-md-6 my-2">
                    <input required="" type="text" id="telefono" class="input" disabled="true">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" fill="currentColor" />
                          </svg>
                        </i> </span>
                      <span class="defecto " style="--index: 0">Nº de Teléfono</span>
                    </label>

                  </div>


                </div>
                <div class="form-row row">
                  <div class="wave-group p-2 col-md-6 my-2">
                    <textarea required="" type="text" id="carrera" class="input" disabled="true" style="resize: none;" readonly></textarea>

                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" fill="currentColor" />
                          </svg>
                        </i> </span>
                      <span class="defecto " style="--index: 0">Carrera</span>
                    </label>

                  </div>

                  <div class="wave-group p-2 col-md-6 my-2">
                    <textarea required="" type="text" id="seccion" class="input" disabled="true" style="resize: none;" readonly></textarea>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" fill="currentColor" />
                          </svg>
                        </i> </span>
                      <span class="defecto " style="--index: 0">Sección</span>
                    </label>

                  </div>

                  <div class="wave-group col-12 p-2 my-2">
                    <textarea required="" type="textarea" id="horario" class="input" disabled="true" style="resize: none;" readonly></textarea>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                      <span class=" pl-2 defecto " style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm-fill" viewBox="0 0 16 16">
                            <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5m2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.04 8.04 0 0 0 .86 5.387M11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.04 8.04 0 0 0-3.527-3.527" fill="currentColor" />
                          </svg>
                        </i> </span>
                      <span class="defecto " style="--index: 0">Horario</span>
                    </label>

                  </div>

                </div>




              </form>
            </div>

          </div>

        </div>


        <div class="container col-md-6" data-aos="fade-up" data-aos-delay="1500">
          <div class="card shadow">
            <div class="row p-3">
              <div class="col-10">
                <h5 class="card-title azul5">Menú <span>/Asistencia</span></h5>
              </div>
            </div>
            <div class="card-body">
              <!-- Formulario -->

              <div class="form-row row">
                <div class="form-group col-md-12">
                  <label class="label labelPri ic2">
                    <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;">
                      <svg class="icon-20" width="20" viewBox="0 0 201 173" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <g id="#ffffffff">
                        </g>
                        <g id="#a5acb9ff">
                          <path fill="currentColor" opacity="1.00" d=" M 25.45 4.58 C 28.16 3.44 31.42 4.56 33.38 6.60 C 36.15 10.34 34.58 15.39 36.49 19.46 C 39.34 26.19 45.44 30.67 49.26 36.76 C 53.49 42.60 55.13 49.93 55.14 57.04 C 54.91 61.96 49.22 65.47 44.80 63.16 C 41.08 61.82 40.40 57.51 40.39 54.06 C 40.22 47.45 35.56 42.31 31.32 37.73 C 25.62 31.40 21.22 23.61 20.68 14.95 C 19.92 10.98 21.05 5.82 25.45 4.58 Z" />
                          <path fill="currentColor" opacity="1.00" d=" M 60.45 4.58 C 63.01 3.46 65.92 4.51 67.99 6.15 C 71.28 9.80 69.51 15.19 71.46 19.40 C 74.29 26.15 80.41 30.64 84.25 36.74 C 88.49 42.59 90.13 49.92 90.14 57.04 C 89.91 62.26 83.62 65.69 79.18 62.86 C 74.71 60.64 75.86 55.01 74.97 50.99 C 73.10 43.17 65.95 38.52 61.87 31.99 C 57.63 26.23 55.66 19.09 55.52 12.01 C 55.39 8.82 57.26 5.48 60.45 4.58 Z" />
                          <path fill="currentColor" opacity="1.00" d=" M 113.71 46.69 C 126.56 35.93 147.43 36.74 159.20 48.75 C 166.41 55.10 169.94 64.60 170.30 74.04 C 147.05 73.94 123.79 74.04 100.54 74.00 C 100.47 63.49 105.42 53.15 113.71 46.69 Z" />
                        </g>
                        <g id="#1e3050ff">
                          <path fill="currentColor" opacity="1.00" d=" M 21.13 83.93 C 21.03 78.62 25.53 73.87 30.92 74.03 C 54.12 73.95 77.33 74.03 100.54 74.00 C 123.79 74.04 147.05 73.94 170.30 74.04 C 175.59 74.14 179.51 78.89 179.67 83.99 C 183.72 84.03 188.36 83.42 191.68 86.29 C 196.58 90.15 196.32 98.69 191.09 102.16 C 186.59 105.19 180.85 103.61 175.78 104.01 C 169.53 122.79 156.38 139.34 138.91 148.83 C 136.10 149.70 136.71 152.91 135.92 155.15 C 134.51 160.29 129.44 164.09 124.10 163.98 C 108.39 164.03 92.66 163.99 76.95 164.00 C 73.04 164.08 69.12 162.33 66.79 159.16 C 64.59 156.54 64.32 153.01 63.54 149.82 C 45.39 140.41 31.24 123.59 25.04 104.12 C 19.96 103.53 14.30 105.19 9.72 102.29 C 4.08 98.75 4.09 89.23 9.73 85.71 C 13.09 83.44 17.31 84.08 21.13 83.93 Z" />
                        </g>
                      </svg>
                    </span>
                    <span class="label-char letra2" style="--index: 0">Ménu</span>
                  </label>
                  <?php
                  if (!empty($payload->horario_comida) && $payload->horario_comida !== 'null') {
                    echo '<div class="wave-group p-1 col-md-12 my-1" id="tablita">
            <div class="table-responsive table-wrapper">
              <table class="table table-bordered table-hover" id="horarioComida">
                <tbody id="horarioC">
                  <tr>
                    <th class="text-primary text-center">'
                      . htmlspecialchars($payload->horario_comida) .
                      '<div class="form-check d-flex justify-content-center align-items-center">
                         <input class="form-check-input opcion" type="checkbox" name="opcion" id="' . htmlspecialchars($payload->horario_comida) . '" value="' . htmlspecialchars($payload->horario_comida) . '" checked>
                       </div>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
            <p class="text-center l er error5"></p>
          </div>';
                  } else {
                    echo '<div class="wave-group p-1 col-md-12 my-1" id="tablita">
            <div class="table-responsive table-wrapper">
              <table class="table table-bordered table-hover" id="horarioComida">
                <tbody id="horarioC">
                  <tr>
                    <th class="text-primary text-center">Desayuno
                      <div class="form-check d-flex justify-content-center align-items-center">
                        <input class="form-check-input opcion" type="checkbox" name="opcion" id="desayuno" value="Desayuno">
                      </div>
                    </th>
                    <th class="text-primary text-center">Almuerzo
                      <div class="form-check d-flex justify-content-center align-items-center">
                        <input class="form-check-input opcion" type="checkbox" name="opcion" id="almuerzo" value="Almuerzo">
                      </div>
                    </th>
                    <th class="text-primary text-center">Merienda
                      <div class="form-check d-flex justify-content-center align-items-center">
                        <input class="form-check-input opcion" type="checkbox" name="opcion" id="merienda" value="Merienda">
                      </div>
                    </th>
                    <th class="text-primary text-center">Cena
                      <div class="form-check d-flex justify-content-center align-items-center">
                        <input class="form-check-input opcion" type="checkbox" name="opcion" id="cena" value="Cena">
                      </div>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
            <p class="text-center l er error5"></p>
          </div>';
                  }
                  ?>

                  <div class="form-row row" id="contador-container" style="display: none;">
                    <div class="form-group col-md-12">
                      <label class="label labelPri ic2" id="contador-label">
                        <span class="label-char letra2">Platos Disponible</span>
                      </label>
                      <input type="text" class="form-control readonly-input contador" id="comidaDisponible" placeholder="" readonly>
                    </div>
                  </div>

                  <div class="modal-footer mt-2">

                    <button type="button" class="btn btn-danger borra">Cancelar</button>
                    <div class="text-start p-2">
                      <button type="button" class="btn btn-primary confirmar">Confirmar</button>

                    </div>

                  </div>

                  <!-- Fin del Formulario -->
                </div>
              </div>
            </div>





            <!-- Footer Section Start -->

            <!-- Footer Section End -->
  </main>



  <!-- Modal justificativo EXCEPCION 2-->
  <div class="modal fade " id="justificativo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-azul4">
          <h1 class="modal-title fs-5  title" id="staticBackdropLabel">Justificativo</h1>
          <button type="button" id="cerrarModal2" class="btn-close borrarE2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="formu">
          <div class="modal-body">

            <div class="form-row row">
              <div id="alerts" data-aos="fade-up" data-aos-delay="1000">
                <div class="alert alert-top alert-info alert-dismissible fade show h-5" role="alert">

                  <p style="font-size: 13px!important;" align="justify">
                    <svg class="icon-30" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path opacity="0.4" d="M4.72251 21.1672C4.70951 21.1672 4.69751 21.1672 4.68351 21.1662C4.36851 21.1502 4.05951 21.0822 3.76551 20.9632C2.31851 20.3752 1.62051 18.7222 2.20751 17.2762L9.52851 4.45025C9.78051 3.99425 10.1625 3.61225 10.6285 3.35425C11.9935 2.59825 13.7195 3.09525 14.4745 4.45925L21.7475 17.1872C21.9095 17.5682 21.9785 17.8782 21.9955 18.1942C22.0345 18.9502 21.7765 19.6752 21.2705 20.2362C20.7645 20.7972 20.0695 21.1282 19.3145 21.1662L4.79451 21.1672H4.72251Z" fill="currentColor"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1245 10.0208C11.1245 9.53875 11.5175 9.14575 11.9995 9.14575C12.4815 9.14575 12.8745 9.53875 12.8745 10.0208V12.8488C12.8745 13.3318 12.4815 13.7238 11.9995 13.7238C11.5175 13.7238 11.1245 13.3318 11.1245 12.8488V10.0208ZM11.1245 16.2699C11.1245 15.7849 11.5175 15.3899 11.9995 15.3899C12.4815 15.3899 12.8745 15.7799 12.8745 16.2589C12.8745 16.7519 12.4815 17.1449 11.9995 17.1449C11.5175 17.1449 11.1245 16.7519 11.1245 16.2699Z" fill="currentColor"></path>
                    </svg>
                    Este apartado son para los estudiantes que tienen una excepción para acceder al Servicio Nutriconal fuera del horario Académico,
                    Verifica si está seleccionado el horario de comida y visualiza si hay platos disponibles para poder Registrar su Asistencia.
                  <p>
                    <button type="button" class="btn-close btn-primary" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

              </div>
              <div class="form-group col-md-12">
                <label class="label labelPri ic9e">
                  <span class="label-char pl-2 letra9e" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                      <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                        <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                      </svg>
                    </i> </span>
                  <span class="label-char letra9e" style="--index: 0">Cédula</span>
                </label>
                <input type="number" class="form-control" id="cedula2" placeholder="">
                <p class=" text-center l er error9e"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="label labelPri ic22">
                <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical" viewBox="0 0 16 16">
                    <path d="M7.5 5.5a.5.5 0 0 0-1 0v.634l-.549-.317a.5.5 0 1 0-.5.866L6 7l-.549.317a.5.5 0 1 0 .5.866l.549-.317V8.5a.5.5 0 1 0 1 0v-.634l.549.317a.5.5 0 1 0 .5-.866L8 7l.549-.317a.5.5 0 1 0-.5-.866l-.549.317zm-2 4.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z" />
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                  </svg>
                </span>
                <span class="label-char letra22" style="--index: 0">Justificativo</span>
              </label>
              <textarea name="textarea" class="form-control" id="justificativo3"></textarea>
              <p class=" text-center l er error9J"></p>

            </div>

          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-danger borrarE2">Cancelar</button>
            <button type="button" class="btn btn-primary" id="registrarE2">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Modal EXCEPCION 1-->
  <div class="modal fade " id="estudiantes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-azul4">
          <h1 class="modal-title fs-5  title" id="staticBackdropLabel">Estudiante No Existente</h1>
          <button type="button" class="btn-close borrarE1" data-bs-dismiss="modal" aria-label="Close" id="cerrar"></button>
        </div>
        <form class="formu">
          <div class="modal-body">
            <div id="alerts" data-aos="fade-up" data-aos-delay="1000">
              <div class="alert alert-top alert-info alert-dismissible fade show h-5" role="alert">

                <p style="font-size: 13px!important;" align="justify">
                  <svg class="icon-30" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4" d="M4.72251 21.1672C4.70951 21.1672 4.69751 21.1672 4.68351 21.1662C4.36851 21.1502 4.05951 21.0822 3.76551 20.9632C2.31851 20.3752 1.62051 18.7222 2.20751 17.2762L9.52851 4.45025C9.78051 3.99425 10.1625 3.61225 10.6285 3.35425C11.9935 2.59825 13.7195 3.09525 14.4745 4.45925L21.7475 17.1872C21.9095 17.5682 21.9785 17.8782 21.9955 18.1942C22.0345 18.9502 21.7765 19.6752 21.2705 20.2362C20.7645 20.7972 20.0695 21.1282 19.3145 21.1662L4.79451 21.1672H4.72251Z" fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1245 10.0208C11.1245 9.53875 11.5175 9.14575 11.9995 9.14575C12.4815 9.14575 12.8745 9.53875 12.8745 10.0208V12.8488C12.8745 13.3318 12.4815 13.7238 11.9995 13.7238C11.5175 13.7238 11.1245 13.3318 11.1245 12.8488V10.0208ZM11.1245 16.2699C11.1245 15.7849 11.5175 15.3899 11.9995 15.3899C12.4815 15.3899 12.8745 15.7799 12.8745 16.2589C12.8745 16.7519 12.4815 17.1449 11.9995 17.1449C11.5175 17.1449 11.1245 16.7519 11.1245 16.2699Z" fill="currentColor"></path>
                  </svg>
                  Este apartado facilitará un registro ágil del estudiante, justificando su ausencia en el sistema del servicio nutricional (el estudiante debe presentar la planilla de inscripción). Para realizar el registro, es importante asegurarse de que el núcleo, la carrera y la sección ya estén registrados
                <p>
                  <button type="button" class="btn-close btn-primary" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

            </div>

            <div class="form-row row">
              <div class="form-group col-md-12">
                <label class="label labelPri ic1e">
                  <span class="label-char pl-2 letra1e" style="--index: 0; margin-right: 3px!important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                      <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" fill="currentColor" />
                      <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" fill="currentColor" />
                    </svg>
                  </span>
                  <span class="label-char letra1e" style="--index: 0">Cédula</span>
                </label>
                <input type="number" class="form-control" id="cedulaStudy" placeholder="">
                <p class=" text-center l er error1e"></p>
              </div>
            </div>

            <div class="form-row row">
              <div class="form-group col-md-6">
                <label class="label labelPri ic2e">
                  <span class="label-char pl-2 letra2e" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                      <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                        <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                      </svg>
                    </i> </span>
                  <span class="label-char letra2e" style="--index: 0">Nombre</span>
                </label>
                <input type="text" class="form-control" id="nombreStudy" placeholder="">
                <p class=" text-center l er error2e"></p>
              </div>
              <div class="form-group col-md-6">
                <label class="label labelPri ic3e">
                  <span class="label-char pl-2 letra3e" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                      <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                        <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                      </svg>
                    </i> </span>
                  <span class="label-char letra3e" style="--index: 0">apellido</span>
                </label>
                <input type="text" class="form-control" id="apellidoStudy" placeholder="">
                <p class=" text-center l er error3e"></p>
              </div>
            </div>
            <div class="form-row row">

              <div class="form-group col-md-4" id="selS">
                <label class="label labelPri ic4eS">
                  <span class="label-char pl-2 letra4e" style="--index: 0; margin-right: 3px!important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                      <path d="M176 288a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM352 176c0 86.3-62.1 158.1-144 173.1V384h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H208v32c0 17.7-14.3 32-32 32s-32-14.3-32-32V448H112c-17.7 0-32-14.3-32-32s14.3-32 32-32h32V349.1C62.1 334.1 0 262.3 0 176C0 78.8 78.8 0 176 0s176 78.8 176 176zM271.9 360.6c19.3-10.1 36.9-23.1 52.1-38.4c20 18.5 46.7 29.8 76.1 29.8c61.9 0 112-50.1 112-112s-50.1-112-112-112c-7.2 0-14.3 .7-21.1 2c-4.9-21.5-13-41.7-24-60.2C369.3 66 384.4 64 400 64c37 0 71.4 11.4 99.8 31l20.6-20.6L487 41c-6.9-6.9-8.9-17.2-5.2-26.2S494.3 0 504 0H616c13.3 0 24 10.7 24 24V136c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-33.4-33.4L545 140.2c19.5 28.4 31 62.7 31 99.8c0 97.2-78.8 176-176 176c-50.5 0-96-21.3-128.1-55.4z" />
                    </svg>
                  </span>

                  <span class="label-char letra4e" style="--index: 0">Sexo</span>
                </label>
                <div class="wave-group" id="sexo">
                  <select class="form-select input sexoStudy" id="sexoStudy">
                    <option value="Seleccionar">Seleccionar</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                  </select>
                </div>
                <p class=" text-center l er errorsexo"></p>
              </div>

              <div class="form-group col-md-4">
                <label class="label labelPri ic42e">
                  <span class="label-char pl-2 letra42e" style="--index: 0; margin-right: 3px!important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512">
                      <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" fill="currentColor" />
                    </svg>
                  </span>
                  <span class="label-char letra42e" style="--index: 0">Nucleo</span>
                </label>
                <div class="wave-group" id="selectN">
                  <select class="form-select input nucleoStudy" id="nucleoStudy">

                  </select>
                </div>
                <p class=" text-center l er error42e"></p>
              </div>

              <div class="form-group col-md-4">
                <label class="label labelPri ic5e">
                  <span class="label-char pl-2 letra5e" style="--index: 0; margin-right: 3px!important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512">
                      <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" fill="currentColor" />
                    </svg>
                  </span>
                  <span class="label-char letra5e" style="--index: 0">Carrera</span>
                </label>
                <div class="wave-group" id="selectC">
                  <select class="form-select input carreraStudy" id="carreraStudy">

                  </select>
                </div>
                <p class=" text-center l er error5e"></p>
              </div>


            </div>
            <div class="form-row row">

              <div class="form-group col-md-6">
                <label class="label labelPri ic6e">
                  <span class="label-char pl-2 letra6e" style="--index: 0; margin-right: 3px!important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512">
                      <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" fill="currentColor" />
                    </svg>
                  </span>
                  <span class="label-char letra6e" style="--index: 0">Sección</span>
                </label>
                <div class="wave-group" id="selectS">
                  <select class="form-select input seccionStudy" id="seccionStudy">

                  </select>
                </div>
                <p class=" text-center l er error6e"></p>

              </div>

              <div class="form-group col-md-6">
                <label class="label labelPri ic7e">
                  <span class="label-char pl-2 letra7e" style="--index: 0; margin-right: 3px!important;">
                    <input class="form-check-input" type="checkbox" value="" id="mostrarOtraSecion">
                  </span>
                  <span class="label-char letra7e" style="--index: 0">Otra Sección</span>
                </label>
                <div class="wave-group" id="selectS2" style="display: none;">
                  <select class="form-select input seccionStudy" id="seccionStudy2">

                  </select>
                </div>
                <p class=" text-center l er error7e"></p>
              </div>
            </div>
            <div class="form-group ">
              <label class="label labelPri ic">
                <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm-fill" viewBox="0 0 16 16">
                    <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5m2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.04 8.04 0 0 0 .86 5.387M11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.04 8.04 0 0 0-3.527-3.527" fill="currentColor" />
                  </svg>
                </span>
                <span class="label-char letra8e" style="--index: 0">Horario</span>
              </label>
              <div id="horariosContainer"></div>
            </div>
            <div class="form-group">
              <label class="label labelPri ic8e">
                <span class="label-char pl-2 letra8e" style="--index: 0; margin-right: 3px!important;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical" viewBox="0 0 16 16">
                    <path d="M7.5 5.5a.5.5 0 0 0-1 0v.634l-.549-.317a.5.5 0 1 0-.5.866L6 7l-.549.317a.5.5 0 1 0 .5.866l.549-.317V8.5a.5.5 0 1 0 1 0v-.634l.549.317a.5.5 0 1 0 .5-.866L8 7l.549-.317a.5.5 0 1 0-.5-.866l-.549.317zm-2 4.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z" />
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                  </svg>
                </span>
                <span class="label-char letra8e" style="--index: 0">Justificativo</span>
              </label>
              <textarea name="textarea" class="form-control" id="justificativo2"></textarea>
              <p class=" text-center l er error8e"></p>

            </div>

          </div>
          <div class="modal-footer">
            <div class="text-start">
              <button type="reset" class="btn btn-danger borrarE1">Cancelar</button>
              <button type="button" class="btn btn-primary Registro-Study" id="registrarE1">Registrar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php $footer->footer(); ?>

  <?php $configuracion->configuracion(); ?>
  </div>
  <?php $components->componentsJS(); ?>
  <script src="assets\js\asistencia\asistencia.js"></script>
  <script src="assets/js/close.js"></script>
  <script src="assets\js\plugins\instascan\instascan.min.js"></script>
</body>

</html>