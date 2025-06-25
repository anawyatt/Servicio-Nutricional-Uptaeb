<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Tipos de Utensilios | Serv.Nutricional </title>
       <?php $components->componentsHeader(); ?>
       <link rel="stylesheet" href="assets/css/estilo.css"/>
       <script src="assets/js/close.js"></script>
       
  </head>
  <body class="  ">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
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
                                  <h1 class="fw-bold blanco">Tipos de Utensilios</h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                    <?php 
                                      if(isset($permisos['Home']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                      }
                                      if(isset($permisos['Utensilios']['registrar']) ){
                                        echo ' <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('utensilios')).'">Registrar Utensilios</a></li>';
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
                      <div class="agrega">  
                          <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3 agrega" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                              <i class="btn-inner">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                  </svg>
                              </i>
                              <span>Nuevo Tipo de Utensilio</span>
                          </a>               
                      </div>
                  </div>
                  <div class="card-body">
                     <div id="ani"> 
                      <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla2">
                              <thead class="table-success">
                                  <tr>
                                      <th class="title fw-bold">Tipos de Utensilios</th>
                                      <th  class="title fw-bold accion">Acciones</th>
                                     
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="staticBackdropLabel">Registrar Tipo de Utensilio</h5>
                    <button type="button" id="cerrar" class="btn-close limpiar" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form method="POST" class="p-2" id="registrarM">
                        <input type="hidden" name="csrf_token" id="tokenCsrf" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                        <div class="modal-body mb-2">
                            <div class="wave-group p-2  my-2 mb-2">
                                    <input required="" type="text" class="input tipo" id="tipo">
                                    <span class="bar bar1"></span>
                                    <label class="label labelPri ic1">
                                    <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                                        <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                                    </i> </span>
                                <span class="label-char letra" style="--index: 0">T</span>
                                <span class="label-char letra" style="--index: 1">i</span>
                                <span class="label-char letra" style="--index: 2">p</span>
                                <span class="label-char letra" style="--index: 3">o</span>
                                    </label>
                                    <p  class=" text-center l er error1"  ></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <div id="spinner" class=" mb-3 w-100" style="display: none;">
                                    <div class="spinner-border text-primary me-2" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                    <span style="font-size: 12px;">Generando registro...</span>
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
    <div class="modal fade" id="editarTipos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="staticBackdropLabel">Modificar Tipos De Utensilios</h5>
                        <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form  method="POST" class="p-2" id="modificarM">
                <input type="hidden" name="csrf_token" id="tokenCsrfModificar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                <input type="hidden" name="" id="idd">
                    <div class="modal-body mb-2">
                        <div class="wave-group p-2  my-2 mb-2">
                            <input required="" type="text" class="input tipo2" id="tipo2">
                                <span class="bar bar2"></span>
                                    <label class="label labelPri ic2">
                                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"><i class="icon">
           <svg width="20" height="20" viewBox="0 0 207 170" version="1.1" xmlns="http://www.w3.org/2000/svg">

<g id="#a5acb9ff">
<path fill="currentColor" opacity="1.00" d=" M 22.70 3.62 C 25.92 2.12 29.52 3.79 31.72 6.25 C 53.43 28.13 75.21 49.94 96.91 71.83 C 85.56 83.18 74.15 94.48 62.88 105.92 C 58.50 102.71 55.20 98.34 51.13 94.79 C 41.90 86.04 33.23 76.66 25.49 66.57 C 16.29 54.63 12.84 38.78 15.21 24.00 C 15.97 19.23 16.87 14.48 17.76 9.73 C 18.20 7.01 19.94 4.41 22.70 3.62 Z" />
<path fill="currentColor" opacity="1.00" d=" M 111.90 114.51 C 115.94 109.46 121.05 105.38 125.31 100.53 C 126.21 101.38 127.25 102.06 128.14 102.94 C 142.41 117.28 156.87 131.43 171.16 145.75 C 175.59 149.85 175.07 157.74 170.08 161.14 C 166.17 163.96 160.43 163.36 157.09 159.91 C 141.95 144.86 127.05 129.55 111.90 114.51 Z" />
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 155.60 4.72 C 157.17 3.72 159.23 2.35 161.08 3.52 C 164.22 4.66 164.86 9.34 162.48 11.50 C 153.22 20.89 143.89 30.20 134.65 39.61 C 133.72 40.59 133.17 41.83 132.53 43.00 C 133.37 44.55 134.04 46.55 135.99 46.97 C 137.92 47.91 139.83 46.45 141.23 45.26 C 150.88 36.89 160.60 28.60 170.28 20.25 C 171.86 18.82 174.21 17.32 176.32 18.69 C 179.63 20.12 179.60 24.95 177.21 27.20 C 169.30 36.27 161.44 45.38 153.52 54.44 C 151.95 56.31 149.48 58.23 150.25 61.00 C 150.64 64.02 155.02 65.49 157.09 63.17 C 166.78 53.82 176.27 44.26 185.91 34.85 C 188.76 31.31 193.82 34.10 194.51 37.98 C 192.94 41.68 190.46 44.86 188.24 48.18 C 182.36 56.96 176.47 65.75 170.58 74.54 C 165.96 81.42 158.44 86.31 150.20 87.46 C 142.58 89.10 134.78 86.67 128.16 82.94 C 102.86 108.39 77.52 133.80 52.21 159.24 C 49.29 162.63 44.17 164.07 40.08 161.98 C 33.79 159.38 32.70 150.13 37.55 145.62 C 63.18 120.05 88.80 94.46 114.56 69.02 C 110.25 62.26 108.38 53.86 110.15 45.98 C 111.53 37.91 116.64 30.84 123.37 26.33 C 134.12 19.13 144.85 11.90 155.60 4.72 Z" />
</g>
</svg>

        </i></span>
                                        <span class="label-char letra2" style="--index: 0">T</span>
                                        <span class="label-char letra2" style="--index: 1">i</span>
                                        <span class="label-char letra2" style="--index: 2">p</span>
                                        <span class="label-char letra2" style="--index: 3">o</span>
                                       
                                    </label>
                                        <p  class=" text-center l er error2"></p>

                                <div class="modal-footer">
                                    <div class="text-start">
                                        
                                        <button type="button" class="btn btn-danger resetear" >Cancelar</button>
                                        <button id="editar" type="button" class="btn btn-primary">Modificar</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>  
    
    
    <div class="modal fade" id="borrarTipos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="staticBackdropLabel">Anular Tipo Utensilio</h5>
                    <button type="button" id="cerrar3" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="eliminarRol">
                <input type="hidden" name="csrf_token" id="tokenCsrfEliminar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">

                    <div class="modal-body mb-2">
                        <div align="center">
                            <img src="assets/images/basura.png" width="250">
                        </div>
                        <h5 class="eliminarR text-center"></h5>
                    </div>
                    <div class="modal-footer">
                        <div class="text-start">
                            <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="cerrar3">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="borrar" name="anular">Eliminar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

                             
        


        <footer class="footer">
        <?php $footer->footer(); ?>
      </footer>
      <!-- Footer Section End -->   
 </main>
    <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script src="assets/js/tipoUtensilio/tipoUtensilio.js"></script>
  </body>
</html>