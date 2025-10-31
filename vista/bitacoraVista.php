<!doctype html>
<html lang="en" dir="ltr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bitácora | Servicio Nutricional UPTAEB</title>
  <?php $components->componentsHeader(); ?>
  <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script>
        window.userCedulaGlobal = "<?php echo $payload->cedula ?>";
    </script>
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
                  <h1 class="fw-bold blanco">Bitácora</h1>
                  <nav>
                    <ol class="breadcrumb">
                      <?php 
                      echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
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

      <div class=" content-inner mt-n5 py-0">
        <div class="col-sm-12">
          <div class="card container shadow" data-aos="fade-up" data-aos-delay="700">
            <div class="card-body row ">
              <div class=" d-flex">

                                    <div class="checkbox p-1">
                                        <input id="cbx" type="checkbox" class="activarFiltro" />
                                        <label class="toggle" for="cbx"><span></span></label>
                                    </div>
                                    <div class="p-1">
                                        <span>Filtrar Por Fechas</span>
                                    </div>

                                </div>

              <div class="buscar mt-2 row justify-content-center">
                <div class="wave-group p-3 col-md-5">
                  <input class="input center fecha mt-2" id="fechaI" required="" type="date" />
                  <span class="bar bar1">
                  </span>
                  <label class="label labelPri icon">
                    <span class="label-char pl-2 letra1" style="--index: 0; margin-right: 3px!important;">
                      <i class="">
                        <svg class="icon-22" fill="none" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor" fill-rule="evenodd">
                          </path>
                          <path d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor" opacity="0.4">
                          </path>
                          <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor">
                          </path>
                          <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor">
                          </path>
                        </svg>
                      </i>
                    </span>
                    <span class="label-char letra1" style="--index: 0">
                      Fecha Inicio
                    </span>
                  </label>
                  <p id="error1" class=" text-center l"></p>
                  </p>
                </div>
                <div class="wave-group p-3 col-md-5">
                  <input class="input fecha2 mt-2" id="fechaF" required="" style="align-items: center !important;" type="date" />
                  <span class="bar bar2">
                  </span>
                  <label class="label labelPri icon">
                    <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;">
                      <i class="">
                        <svg class="icon-22" fill="none" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor" fill-rule="evenodd">
                          </path>
                          <path d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor" opacity="0.4">
                          </path>
                          <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor">
                          </path>
                          <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor">
                          </path>
                        </svg>
                      </i>
                    </span>
                    <span class="label-char letra2" style="--index: 0">
                      Fecha Fin
                    </span>
                  </label>
                  <p id="error2" class=" text-center l"></p>
                  </p>
                </div>
              </div>



              <div id="ani">
                <div class="table-responsive tabli" data-aos="fade-up" data-aos-delay="800">
                  <table class="table table-bordered table-hover tabla">
                    <thead class="table-success">
                      <tr>
                        <th class="title fw-bold">Usuario</th>
                        <th class="title fw-bold">Modulo</th>
                        <th class="title fw-bold">Acciones</th>
                        <th class="title fw-bold">Fecha</th>
                        <th class="title fw-bold">Hora</th>
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



      <div class="modal fade" id="bitacora" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-azul4">
              <h5 class="modal-title title" id="staticBackdropLabel">Acciones</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-2 mt-2 row">
              <div class="col-12">
                <!-- Aquí aplicamos el scroll horizontal a ambas tablas -->
                <div class="table-responsive" style="overflow-x: auto; max-width: 100%; white-space: nowrap;">
                  <table class="table table-hover table-bordered">
                    <thead class="table-success">
                      <tr>
                        <th class="blanco">Acciones Del Usuario</th>
                      </tr>
                    </thead>
                    <tbody id="info1"></tbody>
                  </table>

                  <table class="table table-hover table-bordered">
                    <thead class="table-success">
                      <tr>
                        <th class="blanco">Modulo</th>
                        <th class="blanco">Fecha</th>
                        <th class="blanco">Hora</th>
                      </tr>
                    </thead>
                    <tbody id="info2"></tbody>
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

      <!--
       Footer Section End -->
  </main>

  <?php $footer->footer(); ?>
  <?php $configuracion->configuracion(); ?>
  </div>
  <?php $components->componentsJS(); ?>
  <script src="assets/js/bitacora/bitacora.js"></script>
  <script src="assets/js/close.js"></script>
</body>

</html>