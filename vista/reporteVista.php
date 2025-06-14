<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Reportes Estadísticos | Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
       <link rel="stylesheet" href="assets/css/estilo.css"/>
        <link href="assets/carousel/owl-carousel.css" rel="stylesheet">



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

              <!-- /////// HEADER //////// -->
  <div class="position-relative iq-banner">
          <div class="iq-navbar-header " style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div class=" col-md-7">
                                  <h1 class="fw-bold blanco">Reportes Estadísticos</h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                           <?php 
                                           if(isset($permisos['Home']['consultar']) ){
                                                echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
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
       <?php $cardy->cardysReporte(); ?>

      <div class="row">
  <div class="col-md-6">

    
     
     <div class="card shadow cardi" data-aos="fade-up" data-aos-delay="700" >
      <div class="card-body">
        <div class="row mb-4">
                                    <div class=" d-flex col-12 d-none filtro" id='fil' >
                                        <div class="checkbox p-1">
                                             <input id="cbx" type="checkbox" class="activarFiltro" />
                                             <label class="toggle" for="cbx"><span></span></label>
                                         </div>
                                          <div  class="p-1">
                                          <span>Filtrar Por </span>
                                        </div>

                                    </div>

        <div class="col-10">
             <div class="wave-group p-2 "  id="sel0">
               <select class="input fecha" id="selectFecha">
                    <option value="Seleccionar">Fechas</option>
                </select>
                    <span class="bar bar3"></span>
                    <p  class=" text-center l er error3"  ></p>
            </div>
         </div>
         <div class="col-2 ">
                <button type="button" class="btn p-0 buscar" id='botonB'>
                    <i class="bi bi-search azul5" style="font-size: 30px;"></i>
                </button>
         </div>
       </div>
        
 <!-- REPORTE ESTUDIANTES Y ASISTENCIAS -->

 <div class="AEcard">
    <div class="wave-group p-2  my-2" id="sel">
                <select class="input asisEstu " id="asisEstu">
                   <option value='Seleccionar'>Seleccionar</option>
                   <option value=1> Asistencias de Estudiantes</option>
                   <option value=2> Asistencias de Estudiantes por Sexo</option>
                   <option value=3> Asistencias de Estudiantes por Núcleo</option>
                   <option value=4> Asistencias de Estudiantes por PNF</option>
                   <option value=5> Asistencias de Estudiantes por Justificativo</option>
                </select>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                       <span class="label-char letra" style="--index: 0">T</span>
                      <span class="label-char letra" style="--index: 1">i</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3; margin-right: 3px!important;">o</span>
                       <span class="label-char letra" style="--index: 3">D</span>
                      <span class="label-char letra" style="--index: 4; margin-right: 3px!important;">e</span>
                      <span class="label-char letra" style="--index: 0">R</span>
                      <span class="label-char letra" style="--index: 1">e</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3">o</span>
                      <span class="label-char letra" style="--index: 3">r</span>
                      <span class="label-char letra" style="--index: 4">t</span>
                      <span class="label-char letra" style="--index: 4">e</span>
                      <span class="label-char letra" style="--index: 4">s</span>
                      
                    </label>
   
            </div>
 </div>
  <!-- REPORTE MENUS Y EVENTOS -->
 <div class="MEcard">
    <div class="wave-group p-2  my-2" id="sel2">
                <select class="input menuEvent " id="menuEvent">
                   <option value='Seleccionar'>Seleccionar</option>
                   <option class='me' value=1>Total de Menus </option>
                   <option class='eve'value=2>Total de Eventos</option>
                   <option class='me' value=3> Horarios de comida con mayor número de menús activos</option>
                   <option class='me' value=4> Alimentos más frecuentemente utilizados en los menús</option>
                   <option class='eve' value=5> Eventos con la mayor cantidad de salidas de alimentos</option>
                </select>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                       <span class="label-char letra" style="--index: 0">T</span>
                      <span class="label-char letra" style="--index: 1">i</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3; margin-right: 3px!important;">o</span>
                       <span class="label-char letra" style="--index: 3">D</span>
                      <span class="label-char letra" style="--index: 4; margin-right: 3px!important;">e</span>
                      <span class="label-char letra" style="--index: 0">R</span>
                      <span class="label-char letra" style="--index: 1">e</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3">o</span>
                      <span class="label-char letra" style="--index: 3">r</span>
                      <span class="label-char letra" style="--index: 4">t</span>
                      <span class="label-char letra" style="--index: 4">e</span>
                      <span class="label-char letra" style="--index: 4">s</span>
                      
                    </label>
   
            </div>
 </div>

 <!-- REPORTE IVENTARIO DE ALIMENTOS -->
 <div class="Acard">
   <div class="wave-group p-2  my-2" id="sel3">
                <select class="input alimento " id="alimento">
                  <option value='Seleccionar'>Seleccionar</option>
                  <option value=1>Entrada de Alimentos</option>
                   <option value=2>Alimentos mas ingresados </option>
                   <option value=3>Salida de alimentos mas frecuentes por menu</option>
                   <option value=4>Salida de alimentos mas frecuentes por Merma o donación</option>
                  
                </select>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                       <span class="label-char letra" style="--index: 0">T</span>
                      <span class="label-char letra" style="--index: 1">i</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3; margin-right: 3px!important;">o</span>
                       <span class="label-char letra" style="--index: 3">D</span>
                      <span class="label-char letra" style="--index: 4; margin-right: 3px!important;">e</span>
                      <span class="label-char letra" style="--index: 0">R</span>
                      <span class="label-char letra" style="--index: 1">e</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3">o</span>
                      <span class="label-char letra" style="--index: 3">r</span>
                      <span class="label-char letra" style="--index: 4">t</span>
                      <span class="label-char letra" style="--index: 4">e</span>
                      <span class="label-char letra" style="--index: 4">s</span>
                      
                    </label>
   
            </div>
 </div>

  <!-- REPORTE INVENTARIO UTENSILIOS -->
 <div class="Ucard">
  <div class="wave-group p-2  my-2" id="sel4">
                <select class="input utensilio " id="utensilio">
                  <option value='Seleccionar'>Seleccionar</option>
                   <option value=1> Entrada de Utensilios</option>
                   <option value=2>Utensilios mas Ingresados</option>
                   <option value=3>Salida de Utensilios</option>
                </select>
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                       <span class="label-char letra" style="--index: 0">T</span>
                      <span class="label-char letra" style="--index: 1">i</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3; margin-right: 3px!important;">o</span>
                       <span class="label-char letra" style="--index: 3">D</span>
                      <span class="label-char letra" style="--index: 4; margin-right: 3px!important;">e</span>
                      <span class="label-char letra" style="--index: 0">R</span>
                      <span class="label-char letra" style="--index: 1">e</span>
                      <span class="label-char letra" style="--index: 2">p</span>
                      <span class="label-char letra" style="--index: 3">o</span>
                      <span class="label-char letra" style="--index: 3">r</span>
                      <span class="label-char letra" style="--index: 4">t</span>
                      <span class="label-char letra" style="--index: 4">e</span>
                      <span class="label-char letra" style="--index: 4">s</span>
                      
                    </label>
   
            </div>
 </div>
       
      </div>
    </div>

   

    
  </div>
  <div class="col-md-6 grafis" id="grafos">
    <div class="row">
      <div class="col-4">
         <div class="card shadow cardiR"  id="grafico1">
          <div class="card-body">
              <img src="assets/images/graficos/0.png" width="85" height="75">
          </div>
         </div>
      </div>
      <div class="col-4">
          <div class="card shadow cardiR"  id="grafico2">
            <div class="card-body">
                 <img src="assets/images/graficos/1.png" width="85" height="75">
            </div>
          </div>
      </div>
      <div class="col-4">
          <div class="card shadow cardiR"  id="grafico3">
            <div class="card-body">
               <img src="assets/images/graficos/2.png" width="85" height="75">
            </div>
          </div>
      </div> 
      <div class="col-4">
          <div class="card shadow cardiR"  id="grafico4">
            <div class="card-body">
               <img src="assets/images/graficos/3.png" width="85" height="75">
            </div>
          </div>
      </div>
      <div class="col-4">
          <div class="card shadow cardiR" id="grafico5">
            <div class="card-body">
               <img src="assets/images/graficos/4.png" width="85" height="75">
            </div>
          </div>
      </div>
      <div class="col-4">
          <div class="card shadow cardiR" id="grafico6">
            <div class="card-body">
               <img src="assets/images/graficos/5.png" width="85" height="75">
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<div>
  <div class="card shadow graf" >
            <div class="card-body">
              <div class="agregar mb-1">
                    <a href="#" class="protected protected-agregar text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#pdfReporte">
                         <i class="ri-download-line icon-24" ></i>
                          <span>Descargar PDF</span>
                    </a>
                </div>
              <div id="reporteIMG">
                <div id="graf1" ></div>
                <div id="graf2" ></div>
                <div id="graf3" ></div>
                <div id="graf4" ></div>
                <div id="graf5" ></div>
                <div id="graf6" ></div>
              </div>
              <input type="hidden" id='imagenCap' name='img'>
            </div>
            </div>
  </div>

</div>
   </div>
</div>
</div>
      <!-- Footer Section Start -->
        <?php $footer->footer(); ?>
      <!-- Footer Section End --> 
</main>


<div class="modal fade" id="pdfReporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                   <h5 class="text-center mb-2"> Deseas Descargar este Reporte?</h5>                  
                </div>
                <div class="loadingAnimation" style="display:none;">
                    <div class="spinner"></div>
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



    
    <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script src="assets/js/reporteEstadístico/reporteEstadistico.js"></script>
     <script src="assets/js/close.js"></script>
     
  </body>
</html>