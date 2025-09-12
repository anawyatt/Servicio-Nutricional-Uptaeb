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
                                    <?php 
                                      if(isset($permisos['Home']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                      }
                                      if(isset($permisos['Inventario de Alimentos']['registrar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('registrarEntradaAlimentos')).'"> Registrar Entrada de Alimentos</a></li>';
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
                  <div class="card-body">
                  <div class="row">
                          <div class=" col-md-8">
                                    <div class='d-flex'>
                                        <div class="checkbox p-1">
                                            <input id="cbx" type="checkbox" class="activarFiltro" />
                                            <label class="toggle" for="cbx"><span></span></label>
                                        </div>
                                         <div  class="p-1"><span>Buscar por Tipos de Alimentos</span></div>
                                     </div>
                                      
                                       
                                    <div class="buscar mt-3 ">
                                      <div class="wave-group p-2 col-md-6 my-2 " id="sel" style="margin-top: 1.7vw!important">

                                        <select class="input tipoA2" id="tipoA2"> </select>
                                        <span class="bar bar2A"></span>
                                        <label class="label labelPri ic2A">
                                           <span class="label-char pl-2 letra2A" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                                           <svg class="icon-24"  viewBox="0 0 123 164" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="#ffffffff"></g><g id="#a5acb9ff"><path fill="currentColor" opacity="1.00" d=" M 20.90 9.88 C 33.94 4.67 48.12 3.38 62.03 3.01 C 73.78 3.43 85.69 4.25 96.94 7.90 C 103.27 9.92 110.00 12.34 114.43 17.55 C 116.73 20.08 116.52 23.65 116.77 26.83 C 113.46 31.33 108.76 34.54 103.59 36.56 C 93.88 40.51 83.38 41.88 73.02 42.88 C 55.59 43.50 37.65 43.13 21.11 36.97 C 15.55 34.95 10.43 31.63 6.91 26.81 C 7.34 24.07 6.73 20.95 8.48 18.59 C 11.36 14.22 16.24 11.85 20.90 9.88 Z" /><path fill="currentColor" opacity="1.00" d=" M 47.33 77.21 C 55.08 71.95 65.78 71.40 74.02 75.85 C 79.94 78.85 84.45 84.55 86.15 90.94 C 86.71 96.70 87.07 102.86 84.32 108.16 C 81.25 115.20 74.81 120.66 67.27 122.27 C 56.52 125.00 44.60 119.19 39.79 109.26 C 37.06 104.63 37.05 99.15 37.12 93.95 C 36.58 93.78 35.50 93.44 34.95 93.27 C 35.40 93.14 36.28 92.88 36.72 92.75 C 38.63 86.68 41.84 80.74 47.33 77.21 Z" /></g><g id="#1e3050ff"><path fill="currentColor" opacity="1.00" d=" M 6.91 26.81 C 10.43 31.63 15.55 34.95 21.11 36.97 C 37.65 43.13 55.59 43.50 73.02 42.88 C 83.38 41.88 93.88 40.51 103.59 36.56 C 108.76 34.54 113.46 31.33 116.77 26.83 C 116.33 64.84 116.76 102.87 116.56 140.88 C 116.25 146.46 111.57 150.46 107.13 153.16 C 93.42 160.90 77.37 162.28 61.96 163.16 C 46.52 162.30 30.44 160.94 16.68 153.23 C 11.85 150.48 7.01 146.01 7.06 140.01 C 7.43 118.01 6.94 96.01 7.18 74.02 C 7.02 58.29 7.53 42.53 6.91 26.81 M 47.33 77.21 C 41.84 80.74 38.63 86.68 36.72 92.75 C 36.28 92.88 35.40 93.14 34.95 93.27 C 30.47 91.99 25.97 90.72 21.67 88.87 C 21.53 105.57 21.56 122.27 21.66 138.97 C 30.85 145.24 42.17 146.83 53.01 147.77 C 63.71 148.37 74.54 148.01 85.06 145.79 C 90.29 144.64 95.52 143.06 100.06 140.15 C 101.18 139.50 102.44 138.48 102.18 137.01 C 102.12 120.98 102.26 104.96 102.10 88.94 C 97.08 90.74 92.07 92.71 86.74 93.41 C 86.59 92.79 86.30 91.56 86.15 90.94 C 84.45 84.55 79.94 78.85 74.02 75.85 C 65.78 71.40 55.08 71.95 47.33 77.21 Z" /></g></svg>                            
                                           </i> </span>
                                           <span class="label-char letra2A" style="--index: 0">T</span>
                                           <span class="label-char letra2A" style="--index: 1">i</span>
                                           <span class="label-char letra2A" style="--index: 2">p</span>
                                           <span class="label-char letra2A" style="--index: 3; margin-right: 3px!important;">o</span>
                                           <span class="label-char letra2A" style="--index: 3">D</span>
                                           <span class="label-char letra2A" style="--index: 4; margin-right: 3px!important;">e</span>
                                           <span class="label-char letra2A" style="--index: 4">A</span>
                                           <span class="label-char letra2A" style="--index: 5">l</span>
                                           <span class="label-char letra2A" style="--index: 5">i</span>
                                           <span class="label-char letra2A" style="--index: 6">m</span>
                                           <span class="label-char letra2A" style="--index: 6">e</span>
                                           <span class="label-char letra2A" style="--index: 7">n</span>
                                           <span class="label-char letra2A" style="--index: 7">t</span>
                                           <span class="label-char letra2A" style="--index: 7">o</span>
                     
                                       </label>
                                       <p  class=" text-center l er error2A"  ></p>
   
                                      </div>
                                       

                                    </div>
                            </div>

                    <div class=" col-md-4 mb-3" align="end">  
                          
                          <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#pdfStockAlimento">
                              <i class="ri-download-line icon-24" ></i>
                              <span>Descargar PDF</span>
                          </a>               
                      </div>
           </div>
                 
                  
                     <div id="ani">
                     <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla" >
                              <thead class="table-success">
                                  <tr>
                                    <th class="blanco fw-bold ">Tipo</th>
                                     <th class="blanco fw-bold ">Código</th>
                                    <th class="blanco fw-bold">Imagen</th>
                                    <th class="blanco fw-bold">Alimento</th>
                                    <th class="blanco fw-bold">Marca</th>
                                     <th class="blanco fw-bold">Cont. Neto</th>
                                    <th class="blanco fw-bold">Stock</th>
                                    <th class="blanco fw-bold">Reservado</th>
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