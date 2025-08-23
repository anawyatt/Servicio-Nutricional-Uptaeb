<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Stock de Alimentos | Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
       <link rel="stylesheet" href="assets/css/estilo.css"/>
    
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
                              <div class=" col-12">
                                  <h1 class="fw-bold blanco"> Stock de Alimentos </h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                          <?php echo '
                                           <li class="breadcrumb-item fw-bold"><a href="?url='.$sistem->encryptURL('home').'">Inicio</a></li>
                                           <li class="breadcrumb-item fw-bold"><a href="?url='.$sistem->encryptURL('registrarEntradaAlimentos').'"> Registrar Entrada de Alimentos</a></li>';
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
                  <div class="card-body">

                    <div class="mb-3" align="end">  
                          <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#pdfStockAlimento">
                              <i class="ri-download-line icon-24" ></i>
                              <span>Descargar PDF</span>
                          </a>               
                      </div>
                  
                     <div id="ani">
                     <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla" >
                              <thead class="table-success">
                                  <tr>
                                     <th class="blanco fw-bold">Codigo</th>
                                    <th class="blanco fw-bold">Imagen</th>
                                    <th class="blanco fw-bold">Alimento</th>
                                    <th class="blanco fw-bold">Marca</th>
                                    <th class="blanco fw-bold">Cant. Stock</th>
                                    <th class="blanco fw-bold">Cant. Reservado</th>
                                    <th class="blanco fw-bold"> Cant. Total</th>
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

              <div class="modal fade" id="pdfStockAlimento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
               <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" >Generar Reporte</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <form method="POST" id="idReporte" target="_blank" style="display: inline;">

                 <div class="modal-body mb-2 ">
                     <div align="center" class="mb-2">
                      <img src="assets/images/pdf.png" width="180" >
                     </div>
                   <h5 class="text-center"> Deseas Descargar el stock de los alimentos?</h5>
                </div>
                <div class="modal-footer">
                    <div class="text-start">
                      <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="clos" >Cancelar</button>
                       <button type="button"  class="btn btn-primary" id="reportebtn" >Decargar</button>
                    </div>
                </div>
                </form>
          </div>
      </div>
   </div>


         <?php $footer->footer(); ?>
 </main>

  

     
 </main>
   <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script  type="text/javascript" src="assets/js/inventarioAlimentos/stockAlimentos.js"></script> 
     <script src="assets/js/close.js"></script>
  </body>
</html>