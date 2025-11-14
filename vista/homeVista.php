
<!doctype html>
<html lang="en" dir="ltr">
  <head>
  <?php $components->componentsHeader(); ?>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <title>Inicio | Servicio Nutricional UPTAEB</title>
    <link rel="stylesheet" href="assets/css/estilo.css"/>
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script>
        window.userCedulaGlobal = "<?php echo $payload->cedula ?>";
    </script>
    
    <link rel="stylesheet" href="assets/css/chosen.min.css">
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

          <div class="iq-navbar-header" style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center" >
                              <div class=" col-12">
                                  <h1 class="fw-bold blanco"><?php if (!empty($payload->horario_comida)) {
                                     echo 'Bienvenido al Horario del '.htmlspecialchars($payload->horario_comida);
                                  }else{   echo 'Bienvenido '. htmlspecialchars($payload->nombre) .' '. htmlspecialchars($payload->apellido).' ' ; }?></h1>
                                  <p class="fw-bold azul9">Sistema de Servicio Nutricional UPTAEB </p>
                              </div>
                            
                          </div>
                      </div>
                  </div>
              </div>
              <div class="iq-header-img">
                  <img src="assets/images/dashboard/header2.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
              </div>
          </div>          <!-- Nav Header Component End -->
        <!--Nav End-->
      </div>

      <div class="conatiner-fluid content-inner mt-n5 py-0">
      <div class="row">

      <?php $cardy->cardysHome(); ?>
      
   <div class="container col-md-8 "  data-aos="fade-up" data-aos-delay="1500">
     <div class="card">
      <div class=" card-header">
        <h4 class="azul5" align="center">Asistencias de la Semana</h4>
      </div>
                <div class="card-body">
                  <!-- Line Chart -->
                  <div id="reportsChart"></div>
                </div>

              </div>
   </div>


   <div class="container col-md-4 "  data-aos="fade-up" data-aos-delay="1500">
     <div class="card">
      <div class=" card-header">
        <h4 class="azul5" align="center"> Menús por horario </h4>
      </div>
      <div class="card-body pb-0">
              <div id="trafficChart" style="min-height: 360px;" class="echart"></div>
     </div>

              </div>
   </div>

      
     <div class="col-lg-12" data-aos="fade-up" data-aos-delay="1500">            
        <div class="card shadow ">
            <div class="card-body">
              <div id="calendar" class="calendar-s"></div>
            </div>
            
         </div>
   </div>


    
    <div class="modal fade" id="gestionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Titulo</h5>
                                          <button type="button" class="btn-close btn-primary limpiar" aria-label="Close" data-bs-dismiss="modal"></button>
                                      </div>
                                        <form method="POST" id="forma" class="forma">
                                      <div class="modal-body mb-2">
                                      
                                           
                                      </div>
                                      <div class="modal-footer">
                                           <div class="text-start">
                                              
                                           <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="cerrar3">Cerrar</button>
                                        
                                          </div>
                                      </div>
                                      </form>
                                  </div>
                              </div>
                          </div>  
      
                          
     
      <!-- Footer Section Start -->
      <?php $footer->footer(); ?>
      <!-- Footer Section End -->  
 </main>

   
    

  <?php $configuracion->configuracion(); ?>



    </div>



 
    <?php $components->componentsJS(); ?>
  <script src="assets/js/home/home.js"></script>
  <script src="assets/js/close.js"></script>

<style>
.fc-content {
  white-space: nowrap;  
  overflow: hidden;     
  text-overflow: ellipsis; 
}

.blue-dot {
  display: inline-block;
  width: 8px;
  height: 8px;
  background-color: #37b7b5;
  border-radius: 50%;
  margin-right: 4px; 
}

</style>
                  

  </body>
</html>