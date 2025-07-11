<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Permisos | Servicio Nutricional UPTAEB</title>
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
                  <h1 class="fw-bold blanco">Permisos</h1>
                  <nav>
                    <ol class="breadcrumb">
                      <?php
                      if (isset($permisos['Home']['consultar'])) {
                        echo '<li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('home')) . '">Inicio</a></li>';
                      }
                      if (isset($permisos['Modulos']['consultar'])) {
                        echo '    <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('modulos')) . '"> Módulos</a></li>';
                      }
                      if (isset($permisos['Roles']['consultar'])) {
                        echo '    <li class="breadcrumb-item fw-bold"><a href="?url=' . urlencode($sistem->encryptURL('roles')) . '"> Roles</a></li>';
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
                <div class="card-header">
                  <div class=" mb-2" align="end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modificarP"
                      id="actualiza">Modificar Permiso</button>
                  </div>
                </div>
                <div class="card-body" id="ani">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover tabla">
                      <thead id="thead" class="table-success">
                        <tr id="theadTR">

                        </tr>
                      </thead>
                      <tbody id="tbody">



                      </tbody>
                    </table>

                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <div class="modal fade" id="modificarP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-azul4">
              <h5 class="modal-title title" id="staticBackdropLabel">Modificar Permisos</h5>
              <button type="button" id="cerrarM" class="btn-close btn-primary" aria-label="Close"
                data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="eliminarU">
               <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
              <div class="modal-body mb-2">
                <div align="center">
                  <i>
                    <svg width="150" height="130" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z"
                        fill="#007afa"></path>
                      <path opacity="0.4"
                        d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z"
                        fill="#007afa"></path>
                      <path opacity="0.4"
                        d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z"
                        fill="#007afa"></path>
                      <path
                        d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z"
                        fill="#007afa"></path>
                      <path opacity="0.4"
                        d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z"
                        fill="#007afa"></path>
                      <path
                        d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z"
                        fill="#007afa"></path>
                    </svg>
                  </i>
                </div>

                <h5 class=" text-center">Deseas realizar estos cambios en Permisos?</h5>

              </div>
              <div class="modal-footer">
                <div class="text-start">
                  <button type="button" class="btn btn-danger limpiar" aria-label="Close" data-bs-dismiss="modal"
                    id="cerrar">Cancelar</button>
                  <button type="button" class="btn btn-primary editar" id="enviarPermisos">Modificar</button>
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
  <script src="assets/js/permisos/permisos.js"></script>
  <script src="assets/js/close.js"></script>
</body>

</html>