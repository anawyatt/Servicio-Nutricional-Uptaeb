<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Consultar Eventos |Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
       <link rel="stylesheet" href="assets/css/estilo.css"/>
    
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
                                  <h1 class="fw-bold blanco">Consultar Eventos</h1>
                                  <nav>
                                     <ol class="breadcrumb">
                                     <?php 
                                    if(isset($permisos['Home']['consultar']) ){
                                      echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                    }
                                    if(isset($permisos['Eventos']['registrar']) ){
                                      echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('evento')).'">Registrar Evento</a></li>';
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
                  
                     <div id="ani" class="row" >
                         <div class="mb-1 col-md-8">
                                      <div class=" d-flex">
                                        <div class="checkbox p-1">
                                             <input id="cbx" type="checkbox" class="activarFiltro" />
                                             <label class="toggle" for="cbx"><span></span></label>
                                         </div>
                                          <div  class="p-1">
                                          <span>Buscar Por Fechas</span>
                                        </div>

                                    </div>
                              </div>

                            
                          <div class="buscar mt-2 row justify-content-center">
                            

                          <div class="wave-group p-3 col-md-5">
                        <input required="" type="date" class="input center fecha mt-2" id="fecha">
                        <span class="bar bar1"></span>
                    <label class="label labelPri ic1 ">
                        <span class="label-char pl-2 letra1" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                         <svg class="icon-22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>                                <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>                                <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>                                <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>                                </svg>                                                        
                         </i> </span>
                      <span class="label-char letra1" style="--index: 0">Fecha Inicio</span>
                    </label>
                    <p  class=" text-center l er error1"  ></p>
   
                          </div>
                          
                          <div class="wave-group p-3 col-md-5">
                <input required="" type="date" class="input fecha2 mt-2" style="align-items: center !important;" id="fecha2">
                    <span class="bar bar2"></span>
                    <label class="label labelPri ic2 ">
                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
 <svg class="icon-22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>                                <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>                                <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>                                <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>                                </svg>                                                        
                         </i> </span>
                      <span class="label-char letra2" style="--index: 0">Fecha Fin</span>
                    </label>
                    <p  class=" text-center l er error2"  ></p>
   
                          </div>
                         
 
                          </div> 


                     <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla" >
                              <thead class="table-success">
                                  <tr>
                                  <th class="blanco fw-bold  text-center">Fecha</th>
                                    <th class="blanco fw-bold  text-center">Horario</th>
                                    <th class="blanco fw-bold  text-center">N° de Platos</th>
                                    <th class="blanco fw-bold  text-center">Nombre del Evento</th>
                                    <th class="blanco fw-bold accion  text-center">Acciones</th>
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


                     <!-- MODAL ver informacion -->
     <div class="modal fade" id="infoEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Información del Evento</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body mb-2 mt-2 ">
                                       
                                        <div>
                                           <div class="table-responsive">
                                              <table class="table table-bordered table-hover tabla3">
                                                   <thead class="table-success">
                                   <tr>
                                    <th class="blanco fw-bold">Fecha</th>
                                    <th class="blanco fw-bold">Horario de Comida</th>
                                    <th class="blanco fw-bold">N° de Platos</th>
                                  </tr>
                              </thead>
                              <tbody id="tbody3">
                              </tbody>
                          </table>
                        </div>

                        <div class="table-responsive">
                                              <table class="table table-bordered table-hover tabla4">
                                                   <thead class="table-success">
                                   <tr>
                                    <th class="blanco fw-bold text-center">Nombre del evento</th>
                                    <th class="blanco fw-bold text-center">Descripción del evento</th>
                                  </tr>
                              </thead>
                              <tbody id="tbody4">
                              </tbody>
                          </table>
                        </div>

                        <div class="table-responsive">
                                              <table class="table table-bordered table-hover tabla5">
                                                   <thead class="table-success">
                                   <tr>
                                    <th class="blanco fw-bold text-center">Descripcion del menú</th>
                                  </tr>
                              </thead>
                              <tbody id="tbody5">
                              </tbody>
                          </table>
                        </div>
                                    
                                        <div class="table-responsive" id="tablas">
                                             

                                            
                                             
                                             </div>
                                           </div>
                        
                                   
                                      </div>
                                       <div class="modal-footer">
                                          <div class="text-start">
                                            <button type="button"  class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal">Cerrar</button>
                      
                                           </div>
                                        </div>
                                  </div>
                              </div>
                          </div>
      
      <!-- MODAL EDITAR -->
      <div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modificarEvento" tabindex="-1">
     <div  class="modal-dialog modal-xl">
      <div class="modal-content">
       <div class="modal-header bg-azul4">
        <h5 class="modal-title title" id="staticBackdropLabel">
         Modificar Evento
        </h5>
        <button type="button" id="cerrar2" class="btn-close resetear cut" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body mb-1 mt-2">

        <form class="formu form1" method="POST">
            <input type="hidden" name="csrf_token" id="tokenCsrfModificar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">

         <div class="row mt-1 p-3" id="menu1">

         <div class="wave-group p-1 col-md-6 my-1">
         <input type="hidden" id="idd">
         <input type="hidden" id="idSalidaA">
         <input type="hidden" id="idMenu">
                      <input required="" type="date" class="input feMenu mt-2" id="feMenu">
                        <span class="bar bar5"></span>
                         <label class="label labelPri ic5 ">
                        <span class="label-char pl-2 letra5" style="--index: 0; margin-right: 3px!important;">
                             <i class=" " >
                        <svg class="icon-22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>                                <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>                                <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>                                <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>                                </svg>                                                        
                         </i> </span>
                      <span class="label-char letra5" style="--index: 0">Fecha</span>
                    </label>
                    <p  class=" text-center l er error5"  ></p>
                       </div>

                       
                       <div class="wave-group p-1 col-md-6 my-1">
                  <input required="" type="number" class="input cantPlatos mt-2" id="cantPlatos">
                    <span class="bar bar6"></span>
                    <label class="label labelPri ic6 ">
                        <span class="label-char pl-2 letra6" style="--index: 0; margin-right: 3px!important;">
                            <i class="ri-restaurant-2-line " ></i> </span>
                      <span class="label-char letra6" style="--index: 0">N° de Platos </span>
                    </label>
                    <p  class=" text-center l er error6"  ></p>
                       </div>
                   

                       <div class="wave-group p-2  my-2">
                    <input required="" type="text" class="input nomEvent" name="nomEvent" id="nomEvent">
                    <span class="bar bar7"></span>
                    <label class="label labelPri ic7 ">
                        <span class="label-char pl-2 letra7" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
  <path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 18c4.411 0 8-3.589 8-8s-3.589-8-8-8-8 3.589-8 8 3.589 8 8 8zM12 7.293l-4.646 4.647 1.414 1.414L12 9.121l3.232 3.233 1.414-1.414L12 7.293z"/>
</svg>                          
                         </i> </span>
                      <span class="label-char letra7" style="--index: 0">Nombre del Evento</span>
                    </label>
                    <p  class=" text-center l er error7"  ></p> 
                       </div>

                        <div class="wave-group p-2  my-2">
                    <textarea class="input Textarea descripcion" id="descripEvent"></textarea>
                    <span class="bar bar8"></span>
                    <label class="label labelPri ic8 ">
                        <span class="label-char pl-2 letra8" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
  <path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 18c4.411 0 8-3.589 8-8s-3.589-8-8-8-8 3.589-8 8 3.589 8 8 8zM12 7.293l-4.646 4.647 1.414 1.414L12 9.121l3.232 3.233 1.414-1.414L12 7.293z"/>
</svg>                           
                         </i> </span>
                      <span class="label-char letra8" style="--index: 0">Descripción del Evento</span>
                    </label>
                    <p  class=" text-center l er error8"  ></p> 
                        </div>

                        <div class="wave-group p-1 col-md-12 my-1" id="tablita">
                       <div class="table-responsive table-wrapper">
                        <table  class="table table-bordered table-hover " id="horarioComida">
                             <thead class="table-success center">
                              <tr>
                              <th colspan="4" class="blanco fw-bold text-center">
                              Horarios de la Comidas
                              </th>
                              </tr>
                              </thead>
                            
                              <tbody id="horarioC">
                              <tr>
                        <th class="text-primary text-center">Desayuno
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input checkHorarioComida opcion" type="checkbox" name="opcion"
                                    id="checkDesayuno" value="Desayuno">
                            </div>
                        </th>
                        <th class="text-primary text-center">Almuerzo
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input checkHorarioComida opcion" type="checkbox" name="opcion"
                                    id="checkAlmuerzo" value="Almuerzo">
                            </div>
                        </th>
                        <th class="text-primary text-center">Merienda
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input checkHorarioComida opcion" type="checkbox" name="opcion"
                                    id="checkMerienda" value="Merienda">
                            </div>
                        </th>
                        <th class="text-primary text-center">Cena
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input checkHorarioComida opcion" type="checkbox" name="opcion"
                                    id="checkCena" value="Cena">
                            </div>
                        </th>
                    </tr>

                                </tbody>
                            </table>
                         </div>
                         <p  class=" text-center l er error9"  ></p>
                          
                        </div>

                        <div class="wave-group p-2  my-2">
                            <textarea class="input Textarea descripcion" id="descripcion"></textarea>
                                <span class="bar bar10"></span>
                                    <label class="label labelPri ic10 ">
                                    <span class="label-char pl-2 letra10" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                             <svg class="icon-24"   viewBox="0 0 612 612" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#007afcff">
<path fill="currentColor" opacity="1.00" d=" M 332.85 172.98 C 334.85 126.15 355.17 80.32 388.64 47.50 C 393.65 52.56 398.75 57.54 403.72 62.64 C 377.06 89.05 359.60 124.60 355.20 161.88 C 353.63 173.53 354.03 185.30 354.01 197.02 C 359.59 192.56 365.06 187.95 370.81 183.70 C 393.64 166.86 422.65 158.75 450.91 160.92 C 475.14 162.63 498.73 171.99 517.57 187.31 C 542.06 206.94 557.26 236.48 562.60 267.11 C 565.66 284.25 565.19 301.82 563.51 319.08 C 561.43 339.49 556.84 359.62 550.09 378.99 C 544.86 393.54 538.21 407.52 531.90 421.63 C 518.58 413.20 502.74 408.81 486.98 409.33 C 477.49 409.70 468.31 412.29 459.03 414.02 C 398.95 426.30 338.88 438.61 278.78 450.79 C 281.23 431.09 279.30 410.87 273.14 391.99 C 262.93 358.24 247.05 326.19 226.20 297.74 C 213.09 279.81 198.08 263.03 180.11 249.83 C 167.02 240.17 152.23 232.61 136.38 228.75 C 149.77 200.11 175.21 177.36 205.11 167.09 C 240.29 154.78 281.14 160.00 311.94 181.04 C 319.16 185.83 325.65 191.62 332.50 196.93 C 332.37 188.94 332.67 180.96 332.85 172.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 264.64 55.74 C 284.79 58.39 303.87 68.56 317.17 83.94 C 328.13 96.31 335.07 112.03 337.38 128.36 C 317.00 125.68 297.68 115.27 284.36 99.60 C 273.71 87.29 266.97 71.81 264.64 55.74 Z" />
<path fill="currentColor" opacity="1.00" d=" M 47.76 86.76 C 61.83 86.75 75.90 86.77 89.96 86.75 C 114.07 86.51 138.15 94.97 156.81 110.24 C 170.31 121.15 180.87 135.53 187.65 151.48 C 174.40 157.58 162.01 165.51 151.06 175.15 C 144.80 168.95 138.63 162.65 132.33 156.49 C 132.22 140.31 132.32 124.13 132.28 107.95 C 125.27 107.96 118.25 107.96 111.24 107.95 C 111.24 117.08 111.24 126.21 111.24 135.34 C 99.65 123.76 88.09 112.16 76.48 100.60 C 71.57 105.52 66.68 110.46 61.72 115.34 C 73.28 127.03 84.97 138.58 96.56 150.24 C 87.45 150.24 78.35 150.24 69.24 150.24 C 69.24 157.17 69.24 164.11 69.24 171.05 C 84.87 171.04 100.50 171.04 116.13 171.04 C 117.96 170.86 118.96 172.76 120.24 173.71 C 125.70 179.21 131.39 184.49 136.55 190.27 C 127.36 201.21 120.13 213.66 114.32 226.68 C 75.65 212.63 48.24 173.00 47.99 131.97 C 47.48 116.91 47.89 101.83 47.76 86.76 Z" />
<path fill="currentColor" opacity="1.00" d=" M 91.53 251.32 C 106.86 245.76 124.14 245.76 139.47 251.35 C 160.93 258.71 178.62 273.82 193.71 290.33 C 218.81 318.71 237.95 352.24 250.16 388.08 C 253.71 398.88 257.19 409.82 258.28 421.20 C 259.52 432.56 258.91 444.06 256.89 455.30 C 249.27 456.93 241.61 458.39 233.96 459.93 C 239.22 441.04 238.79 420.51 232.13 402.03 C 224.28 379.89 207.88 360.91 187.05 350.03 C 168.79 340.34 147.28 336.84 126.91 340.43 C 104.46 344.23 83.59 356.48 69.29 374.21 C 56.52 389.90 48.99 409.77 48.18 429.99 C 47.18 452.82 55.03 475.80 69.30 493.59 C 61.61 495.16 53.94 496.79 46.23 498.27 C 36.92 484.43 30.62 468.58 28.11 452.07 C 20.89 410.64 22.62 367.60 33.81 327.03 C 38.57 310.48 45.19 294.26 55.26 280.20 C 64.37 267.50 76.65 256.62 91.53 251.32 Z" />
<path fill="currentColor" opacity="1.00" d=" M 122.14 362.92 C 139.19 357.99 158.03 359.30 174.11 366.87 C 187.15 372.85 198.28 382.82 205.80 395.03 C 218.67 415.62 220.42 442.89 209.84 464.78 C 171.00 472.84 132.12 480.76 93.22 488.57 C 81.26 477.68 72.86 462.93 70.06 446.97 C 67.17 430.37 69.94 412.81 78.20 398.08 C 87.45 381.18 103.59 368.19 122.14 362.92 Z" />
<path fill="currentColor" opacity="1.00" d=" M 575.42 428.75 C 581.43 432.66 587.31 436.75 593.19 440.86 C 588.50 447.54 583.96 454.33 579.30 461.03 C 587.32 459.56 595.25 457.63 603.27 456.10 C 604.70 463.07 606.33 470.00 607.58 477.02 C 597.08 479.22 586.60 481.51 576.09 483.64 C 584.92 493.15 593.90 502.54 602.68 512.10 C 597.49 516.99 592.32 521.90 587.06 526.71 C 573.81 512.45 560.30 498.45 547.27 484.00 C 548.28 499.88 542.31 515.92 531.41 527.46 C 527.37 531.42 523.67 535.78 519.05 539.11 C 509.57 546.24 497.94 550.76 486.02 551.00 C 330.00 551.01 173.98 550.98 17.96 551.01 C 11.20 551.17 4.92 544.83 5.44 538.01 C 5.31 532.22 9.86 526.77 15.55 525.76 C 62.82 516.15 110.05 506.38 157.34 496.88 C 156.76 503.33 155.00 509.57 153.31 515.79 C 159.88 517.85 166.29 520.39 172.81 522.59 C 176.05 512.85 178.06 502.70 178.60 492.44 C 195.89 488.97 213.16 485.33 230.46 481.90 C 230.07 490.29 228.41 498.56 225.95 506.58 C 232.44 508.88 238.90 511.25 245.37 513.62 C 249.48 502.20 251.39 490.00 251.29 477.88 C 268.53 473.99 285.92 470.67 303.25 467.11 C 303.39 477.42 301.93 487.78 298.56 497.54 C 305.07 499.90 311.63 502.14 318.13 504.53 C 322.66 491.19 324.67 476.95 323.70 462.89 C 340.97 459.40 358.24 455.86 375.49 452.28 C 376.49 464.47 375.26 476.87 371.26 488.46 C 377.79 490.75 384.30 493.13 390.84 495.41 C 396.03 480.27 397.67 464.01 395.84 448.13 C 416.14 444.02 436.43 439.85 456.73 435.71 C 457.67 446.69 456.40 457.80 453.47 468.40 C 460.16 470.18 466.85 471.96 473.56 473.64 C 477.41 460.00 478.77 445.62 477.16 431.52 C 489.56 428.92 502.88 430.08 514.37 435.56 C 529.59 442.62 541.28 456.81 545.32 473.09 C 555.00 458.07 565.48 443.60 575.42 428.75 Z" />
</g>
                             </svg>                            
                         </i> </span>
                      <span class="label-char letra10" style="--index: 0">Descripción del Menú</span>
                    </label>
                    <p  class=" text-center l er error10"  ></p> 
                        </div>
          
           <div style="text-align: center;">
            <button class="btn btn-primary" id="alimentoB" type="button">
             Ingredientes
            </button>
          </div>
         </div>

         <div class="formu" id="alimento1">
          <div class="form-card text-start">
           <div class="row  p-3">
            <div class="container-fluid" id="">
             <div class="card-body">

             <div class="card-header d-flex justify-content-end flex-wrap">
      <div class="agregar">
        <a class="text-center btn btn-primary btn-icon me-2" data-bs-target="#alimentoos" data-bs-toggle="modal" href="#">
            <i class="btn-inner">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </i>
            <span>Alimentos</span>
        </a>
    </div>
</div>

<br>
           


<div id="ani">
    <div class="table-responsive table-wrapper" id="tablas1">
        <table class="table tables table-bordered table-hover tabla3" id="tabla3">
            <thead class="table-success">
                <tr>
                    <th class="blanco fw-bold">Imagen</th>
                    <th class="blanco fw-bold">Alimento</th>
                    <th class="blanco fw-bold">Marca</th>
                    <th class="blanco fw-bold">Cantidad</th>
                    <th class="blanco fw-bold"></th>
                </tr>
            </thead>
            <tbody id="tbody3" class="tbody33">
               
            </tbody>
        </table>
    </div>
</div>
               
              
              </div>
             </div>
             <div>
             <div class="d-flex justify-content-center align-items-center mt-3">
    <button class="btn btn-primary" id="menuB" type="button" style="height: 35px;display: flex; align-items: center; justify-content: center;">Regresar</button>
    </div>

          </div>
            </div>
           </div>
          </div>

          

         </div>
         <div class="modal-footer">
          <div class="text-start">
           <button class="btn btn-danger resetear blanco limpiar cance" type="button">
            Cancelar
           </button>
           <button class="btn btn-primary blanco" id="editar" type="button">
            Modificar
           </button>
          </div>
         </div>
        </form>
       </div>
      </div>
     </div>
    
    
    <div class="modal fade" id="alimentoos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div  class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-azul4">
            <h5 class="modal-title title" id="staticBackdropLabel">Agregar Alimentos</h5>
            <button type="button" id="cerrar" class="btn-close limpiar" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
           <form class="formu form1">
          <div class="col-12">
       
                       
                    
                    <div class="card">                       
            <div class="card-body">
            <div align="end" class="mb-3 mt-2">
                               <button class="btn btn-primary mb-3" data-bs-target="#modificarEvento" data-bs-toggle="modal" style="height: 35px;display: flex; align-items: center;">Regresar</button>
                           </div>

                                <div class="wave-group p-2 my-2 " id="sel" style="margin-top: 1.7vw!important">

                <select class="input tipoA" id="tipoA">
                   
                </select>
                    <span class="bar bar2"></span>
                    <label class="label labelPri ic2">
                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                           <svg class="icon-24"  viewBox="0 0 123 164" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#ffffffff">
</g>
<g id="#a5acb9ff">
<path fill="currentColor" opacity="1.00" d=" M 20.90 9.88 C 33.94 4.67 48.12 3.38 62.03 3.01 C 73.78 3.43 85.69 4.25 96.94 7.90 C 103.27 9.92 110.00 12.34 114.43 17.55 C 116.73 20.08 116.52 23.65 116.77 26.83 C 113.46 31.33 108.76 34.54 103.59 36.56 C 93.88 40.51 83.38 41.88 73.02 42.88 C 55.59 43.50 37.65 43.13 21.11 36.97 C 15.55 34.95 10.43 31.63 6.91 26.81 C 7.34 24.07 6.73 20.95 8.48 18.59 C 11.36 14.22 16.24 11.85 20.90 9.88 Z" />
<path fill="currentColor" opacity="1.00" d=" M 47.33 77.21 C 55.08 71.95 65.78 71.40 74.02 75.85 C 79.94 78.85 84.45 84.55 86.15 90.94 C 86.71 96.70 87.07 102.86 84.32 108.16 C 81.25 115.20 74.81 120.66 67.27 122.27 C 56.52 125.00 44.60 119.19 39.79 109.26 C 37.06 104.63 37.05 99.15 37.12 93.95 C 36.58 93.78 35.50 93.44 34.95 93.27 C 35.40 93.14 36.28 92.88 36.72 92.75 C 38.63 86.68 41.84 80.74 47.33 77.21 Z" />
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 6.91 26.81 C 10.43 31.63 15.55 34.95 21.11 36.97 C 37.65 43.13 55.59 43.50 73.02 42.88 C 83.38 41.88 93.88 40.51 103.59 36.56 C 108.76 34.54 113.46 31.33 116.77 26.83 C 116.33 64.84 116.76 102.87 116.56 140.88 C 116.25 146.46 111.57 150.46 107.13 153.16 C 93.42 160.90 77.37 162.28 61.96 163.16 C 46.52 162.30 30.44 160.94 16.68 153.23 C 11.85 150.48 7.01 146.01 7.06 140.01 C 7.43 118.01 6.94 96.01 7.18 74.02 C 7.02 58.29 7.53 42.53 6.91 26.81 M 47.33 77.21 C 41.84 80.74 38.63 86.68 36.72 92.75 C 36.28 92.88 35.40 93.14 34.95 93.27 C 30.47 91.99 25.97 90.72 21.67 88.87 C 21.53 105.57 21.56 122.27 21.66 138.97 C 30.85 145.24 42.17 146.83 53.01 147.77 C 63.71 148.37 74.54 148.01 85.06 145.79 C 90.29 144.64 95.52 143.06 100.06 140.15 C 101.18 139.50 102.44 138.48 102.18 137.01 C 102.12 120.98 102.26 104.96 102.10 88.94 C 97.08 90.74 92.07 92.71 86.74 93.41 C 86.59 92.79 86.30 91.56 86.15 90.94 C 84.45 84.55 79.94 78.85 74.02 75.85 C 65.78 71.40 55.08 71.95 47.33 77.21 Z" />
</g>
                           </svg>                            
                         </i> </span>
                        
                      <span class="label-char letra2" style="--index: 0">Tipo de Alimento</span> 
                    </label>
                    <p  class=" text-center l er error2"  ></p>
   
                                </div>


                                <div class="wave-group p-2  my-2 mt-1"  id="sel2">
               <select class="input alimento" id="alimento">
                   <option value="Seleccionar">Seleccionar</option>
                </select>
                    <span class="bar bar3"></span>
                    <label class="label labelPri ic3">
                        <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                             <svg class="icon-24"   viewBox="0 0 612 612" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#007afcff">
<path fill="currentColor" opacity="1.00" d=" M 332.85 172.98 C 334.85 126.15 355.17 80.32 388.64 47.50 C 393.65 52.56 398.75 57.54 403.72 62.64 C 377.06 89.05 359.60 124.60 355.20 161.88 C 353.63 173.53 354.03 185.30 354.01 197.02 C 359.59 192.56 365.06 187.95 370.81 183.70 C 393.64 166.86 422.65 158.75 450.91 160.92 C 475.14 162.63 498.73 171.99 517.57 187.31 C 542.06 206.94 557.26 236.48 562.60 267.11 C 565.66 284.25 565.19 301.82 563.51 319.08 C 561.43 339.49 556.84 359.62 550.09 378.99 C 544.86 393.54 538.21 407.52 531.90 421.63 C 518.58 413.20 502.74 408.81 486.98 409.33 C 477.49 409.70 468.31 412.29 459.03 414.02 C 398.95 426.30 338.88 438.61 278.78 450.79 C 281.23 431.09 279.30 410.87 273.14 391.99 C 262.93 358.24 247.05 326.19 226.20 297.74 C 213.09 279.81 198.08 263.03 180.11 249.83 C 167.02 240.17 152.23 232.61 136.38 228.75 C 149.77 200.11 175.21 177.36 205.11 167.09 C 240.29 154.78 281.14 160.00 311.94 181.04 C 319.16 185.83 325.65 191.62 332.50 196.93 C 332.37 188.94 332.67 180.96 332.85 172.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 264.64 55.74 C 284.79 58.39 303.87 68.56 317.17 83.94 C 328.13 96.31 335.07 112.03 337.38 128.36 C 317.00 125.68 297.68 115.27 284.36 99.60 C 273.71 87.29 266.97 71.81 264.64 55.74 Z" />
<path fill="currentColor" opacity="1.00" d=" M 47.76 86.76 C 61.83 86.75 75.90 86.77 89.96 86.75 C 114.07 86.51 138.15 94.97 156.81 110.24 C 170.31 121.15 180.87 135.53 187.65 151.48 C 174.40 157.58 162.01 165.51 151.06 175.15 C 144.80 168.95 138.63 162.65 132.33 156.49 C 132.22 140.31 132.32 124.13 132.28 107.95 C 125.27 107.96 118.25 107.96 111.24 107.95 C 111.24 117.08 111.24 126.21 111.24 135.34 C 99.65 123.76 88.09 112.16 76.48 100.60 C 71.57 105.52 66.68 110.46 61.72 115.34 C 73.28 127.03 84.97 138.58 96.56 150.24 C 87.45 150.24 78.35 150.24 69.24 150.24 C 69.24 157.17 69.24 164.11 69.24 171.05 C 84.87 171.04 100.50 171.04 116.13 171.04 C 117.96 170.86 118.96 172.76 120.24 173.71 C 125.70 179.21 131.39 184.49 136.55 190.27 C 127.36 201.21 120.13 213.66 114.32 226.68 C 75.65 212.63 48.24 173.00 47.99 131.97 C 47.48 116.91 47.89 101.83 47.76 86.76 Z" />
<path fill="currentColor" opacity="1.00" d=" M 91.53 251.32 C 106.86 245.76 124.14 245.76 139.47 251.35 C 160.93 258.71 178.62 273.82 193.71 290.33 C 218.81 318.71 237.95 352.24 250.16 388.08 C 253.71 398.88 257.19 409.82 258.28 421.20 C 259.52 432.56 258.91 444.06 256.89 455.30 C 249.27 456.93 241.61 458.39 233.96 459.93 C 239.22 441.04 238.79 420.51 232.13 402.03 C 224.28 379.89 207.88 360.91 187.05 350.03 C 168.79 340.34 147.28 336.84 126.91 340.43 C 104.46 344.23 83.59 356.48 69.29 374.21 C 56.52 389.90 48.99 409.77 48.18 429.99 C 47.18 452.82 55.03 475.80 69.30 493.59 C 61.61 495.16 53.94 496.79 46.23 498.27 C 36.92 484.43 30.62 468.58 28.11 452.07 C 20.89 410.64 22.62 367.60 33.81 327.03 C 38.57 310.48 45.19 294.26 55.26 280.20 C 64.37 267.50 76.65 256.62 91.53 251.32 Z" />
<path fill="currentColor" opacity="1.00" d=" M 122.14 362.92 C 139.19 357.99 158.03 359.30 174.11 366.87 C 187.15 372.85 198.28 382.82 205.80 395.03 C 218.67 415.62 220.42 442.89 209.84 464.78 C 171.00 472.84 132.12 480.76 93.22 488.57 C 81.26 477.68 72.86 462.93 70.06 446.97 C 67.17 430.37 69.94 412.81 78.20 398.08 C 87.45 381.18 103.59 368.19 122.14 362.92 Z" />
<path fill="currentColor" opacity="1.00" d=" M 575.42 428.75 C 581.43 432.66 587.31 436.75 593.19 440.86 C 588.50 447.54 583.96 454.33 579.30 461.03 C 587.32 459.56 595.25 457.63 603.27 456.10 C 604.70 463.07 606.33 470.00 607.58 477.02 C 597.08 479.22 586.60 481.51 576.09 483.64 C 584.92 493.15 593.90 502.54 602.68 512.10 C 597.49 516.99 592.32 521.90 587.06 526.71 C 573.81 512.45 560.30 498.45 547.27 484.00 C 548.28 499.88 542.31 515.92 531.41 527.46 C 527.37 531.42 523.67 535.78 519.05 539.11 C 509.57 546.24 497.94 550.76 486.02 551.00 C 330.00 551.01 173.98 550.98 17.96 551.01 C 11.20 551.17 4.92 544.83 5.44 538.01 C 5.31 532.22 9.86 526.77 15.55 525.76 C 62.82 516.15 110.05 506.38 157.34 496.88 C 156.76 503.33 155.00 509.57 153.31 515.79 C 159.88 517.85 166.29 520.39 172.81 522.59 C 176.05 512.85 178.06 502.70 178.60 492.44 C 195.89 488.97 213.16 485.33 230.46 481.90 C 230.07 490.29 228.41 498.56 225.95 506.58 C 232.44 508.88 238.90 511.25 245.37 513.62 C 249.48 502.20 251.39 490.00 251.29 477.88 C 268.53 473.99 285.92 470.67 303.25 467.11 C 303.39 477.42 301.93 487.78 298.56 497.54 C 305.07 499.90 311.63 502.14 318.13 504.53 C 322.66 491.19 324.67 476.95 323.70 462.89 C 340.97 459.40 358.24 455.86 375.49 452.28 C 376.49 464.47 375.26 476.87 371.26 488.46 C 377.79 490.75 384.30 493.13 390.84 495.41 C 396.03 480.27 397.67 464.01 395.84 448.13 C 416.14 444.02 436.43 439.85 456.73 435.71 C 457.67 446.69 456.40 457.80 453.47 468.40 C 460.16 470.18 466.85 471.96 473.56 473.64 C 477.41 460.00 478.77 445.62 477.16 431.52 C 489.56 428.92 502.88 430.08 514.37 435.56 C 529.59 442.62 541.28 456.81 545.32 473.09 C 555.00 458.07 565.48 443.60 575.42 428.75 Z" />
</g>
                             </svg>                            
                         </i> </span>
                      <span class="label-char letra3" style="--index: 0">Alimento</span>
                     
                     
                    </label>
                    <p  class=" text-center l er error3"  ></p>
   
                                </div>
          
                                <div class=" wave-group p-2  mt-2 " id="disponibilidad">
                <input  type="tex" class="input dispo non-editable" id="dispo"  value="0">
                    <span class="bar bar000"></span>
                    <label class="label labelPri ic000">
                        <span class="label-char pl-2 letra000" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                             <svg class="icon-24"   viewBox="0 0 612 612" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#007afcff">
<path fill="currentColor" opacity="1.00" d=" M 332.85 172.98 C 334.85 126.15 355.17 80.32 388.64 47.50 C 393.65 52.56 398.75 57.54 403.72 62.64 C 377.06 89.05 359.60 124.60 355.20 161.88 C 353.63 173.53 354.03 185.30 354.01 197.02 C 359.59 192.56 365.06 187.95 370.81 183.70 C 393.64 166.86 422.65 158.75 450.91 160.92 C 475.14 162.63 498.73 171.99 517.57 187.31 C 542.06 206.94 557.26 236.48 562.60 267.11 C 565.66 284.25 565.19 301.82 563.51 319.08 C 561.43 339.49 556.84 359.62 550.09 378.99 C 544.86 393.54 538.21 407.52 531.90 421.63 C 518.58 413.20 502.74 408.81 486.98 409.33 C 477.49 409.70 468.31 412.29 459.03 414.02 C 398.95 426.30 338.88 438.61 278.78 450.79 C 281.23 431.09 279.30 410.87 273.14 391.99 C 262.93 358.24 247.05 326.19 226.20 297.74 C 213.09 279.81 198.08 263.03 180.11 249.83 C 167.02 240.17 152.23 232.61 136.38 228.75 C 149.77 200.11 175.21 177.36 205.11 167.09 C 240.29 154.78 281.14 160.00 311.94 181.04 C 319.16 185.83 325.65 191.62 332.50 196.93 C 332.37 188.94 332.67 180.96 332.85 172.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 264.64 55.74 C 284.79 58.39 303.87 68.56 317.17 83.94 C 328.13 96.31 335.07 112.03 337.38 128.36 C 317.00 125.68 297.68 115.27 284.36 99.60 C 273.71 87.29 266.97 71.81 264.64 55.74 Z" />
<path fill="currentColor" opacity="1.00" d=" M 47.76 86.76 C 61.83 86.75 75.90 86.77 89.96 86.75 C 114.07 86.51 138.15 94.97 156.81 110.24 C 170.31 121.15 180.87 135.53 187.65 151.48 C 174.40 157.58 162.01 165.51 151.06 175.15 C 144.80 168.95 138.63 162.65 132.33 156.49 C 132.22 140.31 132.32 124.13 132.28 107.95 C 125.27 107.96 118.25 107.96 111.24 107.95 C 111.24 117.08 111.24 126.21 111.24 135.34 C 99.65 123.76 88.09 112.16 76.48 100.60 C 71.57 105.52 66.68 110.46 61.72 115.34 C 73.28 127.03 84.97 138.58 96.56 150.24 C 87.45 150.24 78.35 150.24 69.24 150.24 C 69.24 157.17 69.24 164.11 69.24 171.05 C 84.87 171.04 100.50 171.04 116.13 171.04 C 117.96 170.86 118.96 172.76 120.24 173.71 C 125.70 179.21 131.39 184.49 136.55 190.27 C 127.36 201.21 120.13 213.66 114.32 226.68 C 75.65 212.63 48.24 173.00 47.99 131.97 C 47.48 116.91 47.89 101.83 47.76 86.76 Z" />
<path fill="currentColor" opacity="1.00" d=" M 91.53 251.32 C 106.86 245.76 124.14 245.76 139.47 251.35 C 160.93 258.71 178.62 273.82 193.71 290.33 C 218.81 318.71 237.95 352.24 250.16 388.08 C 253.71 398.88 257.19 409.82 258.28 421.20 C 259.52 432.56 258.91 444.06 256.89 455.30 C 249.27 456.93 241.61 458.39 233.96 459.93 C 239.22 441.04 238.79 420.51 232.13 402.03 C 224.28 379.89 207.88 360.91 187.05 350.03 C 168.79 340.34 147.28 336.84 126.91 340.43 C 104.46 344.23 83.59 356.48 69.29 374.21 C 56.52 389.90 48.99 409.77 48.18 429.99 C 47.18 452.82 55.03 475.80 69.30 493.59 C 61.61 495.16 53.94 496.79 46.23 498.27 C 36.92 484.43 30.62 468.58 28.11 452.07 C 20.89 410.64 22.62 367.60 33.81 327.03 C 38.57 310.48 45.19 294.26 55.26 280.20 C 64.37 267.50 76.65 256.62 91.53 251.32 Z" />
<path fill="currentColor" opacity="1.00" d=" M 122.14 362.92 C 139.19 357.99 158.03 359.30 174.11 366.87 C 187.15 372.85 198.28 382.82 205.80 395.03 C 218.67 415.62 220.42 442.89 209.84 464.78 C 171.00 472.84 132.12 480.76 93.22 488.57 C 81.26 477.68 72.86 462.93 70.06 446.97 C 67.17 430.37 69.94 412.81 78.20 398.08 C 87.45 381.18 103.59 368.19 122.14 362.92 Z" />
<path fill="currentColor" opacity="1.00" d=" M 575.42 428.75 C 581.43 432.66 587.31 436.75 593.19 440.86 C 588.50 447.54 583.96 454.33 579.30 461.03 C 587.32 459.56 595.25 457.63 603.27 456.10 C 604.70 463.07 606.33 470.00 607.58 477.02 C 597.08 479.22 586.60 481.51 576.09 483.64 C 584.92 493.15 593.90 502.54 602.68 512.10 C 597.49 516.99 592.32 521.90 587.06 526.71 C 573.81 512.45 560.30 498.45 547.27 484.00 C 548.28 499.88 542.31 515.92 531.41 527.46 C 527.37 531.42 523.67 535.78 519.05 539.11 C 509.57 546.24 497.94 550.76 486.02 551.00 C 330.00 551.01 173.98 550.98 17.96 551.01 C 11.20 551.17 4.92 544.83 5.44 538.01 C 5.31 532.22 9.86 526.77 15.55 525.76 C 62.82 516.15 110.05 506.38 157.34 496.88 C 156.76 503.33 155.00 509.57 153.31 515.79 C 159.88 517.85 166.29 520.39 172.81 522.59 C 176.05 512.85 178.06 502.70 178.60 492.44 C 195.89 488.97 213.16 485.33 230.46 481.90 C 230.07 490.29 228.41 498.56 225.95 506.58 C 232.44 508.88 238.90 511.25 245.37 513.62 C 249.48 502.20 251.39 490.00 251.29 477.88 C 268.53 473.99 285.92 470.67 303.25 467.11 C 303.39 477.42 301.93 487.78 298.56 497.54 C 305.07 499.90 311.63 502.14 318.13 504.53 C 322.66 491.19 324.67 476.95 323.70 462.89 C 340.97 459.40 358.24 455.86 375.49 452.28 C 376.49 464.47 375.26 476.87 371.26 488.46 C 377.79 490.75 384.30 493.13 390.84 495.41 C 396.03 480.27 397.67 464.01 395.84 448.13 C 416.14 444.02 436.43 439.85 456.73 435.71 C 457.67 446.69 456.40 457.80 453.47 468.40 C 460.16 470.18 466.85 471.96 473.56 473.64 C 477.41 460.00 478.77 445.62 477.16 431.52 C 489.56 428.92 502.88 430.08 514.37 435.56 C 529.59 442.62 541.28 456.81 545.32 473.09 C 555.00 458.07 565.48 443.60 575.42 428.75 Z" />
</g>
                        </svg>                            
                         </i> </span>
                      <span class="label-char letra000" style="--index: 0">Cantidad Disponible</span>
                    </label>
            
                                </div>
                                
                                <div class="row">
            <div class="col-8 wave-group p-2  my-3">
                <input required="" type="number" class="input cantidad" id="cantidad">
                    <span class="bar bar4"></span>
                    <label class="label labelPri ic4">
                        <span class="label-char pl-2 letra4" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                             <svg class="icon-24"   viewBox="0 0 612 612" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#007afcff">
<path fill="currentColor" opacity="1.00" d=" M 332.85 172.98 C 334.85 126.15 355.17 80.32 388.64 47.50 C 393.65 52.56 398.75 57.54 403.72 62.64 C 377.06 89.05 359.60 124.60 355.20 161.88 C 353.63 173.53 354.03 185.30 354.01 197.02 C 359.59 192.56 365.06 187.95 370.81 183.70 C 393.64 166.86 422.65 158.75 450.91 160.92 C 475.14 162.63 498.73 171.99 517.57 187.31 C 542.06 206.94 557.26 236.48 562.60 267.11 C 565.66 284.25 565.19 301.82 563.51 319.08 C 561.43 339.49 556.84 359.62 550.09 378.99 C 544.86 393.54 538.21 407.52 531.90 421.63 C 518.58 413.20 502.74 408.81 486.98 409.33 C 477.49 409.70 468.31 412.29 459.03 414.02 C 398.95 426.30 338.88 438.61 278.78 450.79 C 281.23 431.09 279.30 410.87 273.14 391.99 C 262.93 358.24 247.05 326.19 226.20 297.74 C 213.09 279.81 198.08 263.03 180.11 249.83 C 167.02 240.17 152.23 232.61 136.38 228.75 C 149.77 200.11 175.21 177.36 205.11 167.09 C 240.29 154.78 281.14 160.00 311.94 181.04 C 319.16 185.83 325.65 191.62 332.50 196.93 C 332.37 188.94 332.67 180.96 332.85 172.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 264.64 55.74 C 284.79 58.39 303.87 68.56 317.17 83.94 C 328.13 96.31 335.07 112.03 337.38 128.36 C 317.00 125.68 297.68 115.27 284.36 99.60 C 273.71 87.29 266.97 71.81 264.64 55.74 Z" />
<path fill="currentColor" opacity="1.00" d=" M 47.76 86.76 C 61.83 86.75 75.90 86.77 89.96 86.75 C 114.07 86.51 138.15 94.97 156.81 110.24 C 170.31 121.15 180.87 135.53 187.65 151.48 C 174.40 157.58 162.01 165.51 151.06 175.15 C 144.80 168.95 138.63 162.65 132.33 156.49 C 132.22 140.31 132.32 124.13 132.28 107.95 C 125.27 107.96 118.25 107.96 111.24 107.95 C 111.24 117.08 111.24 126.21 111.24 135.34 C 99.65 123.76 88.09 112.16 76.48 100.60 C 71.57 105.52 66.68 110.46 61.72 115.34 C 73.28 127.03 84.97 138.58 96.56 150.24 C 87.45 150.24 78.35 150.24 69.24 150.24 C 69.24 157.17 69.24 164.11 69.24 171.05 C 84.87 171.04 100.50 171.04 116.13 171.04 C 117.96 170.86 118.96 172.76 120.24 173.71 C 125.70 179.21 131.39 184.49 136.55 190.27 C 127.36 201.21 120.13 213.66 114.32 226.68 C 75.65 212.63 48.24 173.00 47.99 131.97 C 47.48 116.91 47.89 101.83 47.76 86.76 Z" />
<path fill="currentColor" opacity="1.00" d=" M 91.53 251.32 C 106.86 245.76 124.14 245.76 139.47 251.35 C 160.93 258.71 178.62 273.82 193.71 290.33 C 218.81 318.71 237.95 352.24 250.16 388.08 C 253.71 398.88 257.19 409.82 258.28 421.20 C 259.52 432.56 258.91 444.06 256.89 455.30 C 249.27 456.93 241.61 458.39 233.96 459.93 C 239.22 441.04 238.79 420.51 232.13 402.03 C 224.28 379.89 207.88 360.91 187.05 350.03 C 168.79 340.34 147.28 336.84 126.91 340.43 C 104.46 344.23 83.59 356.48 69.29 374.21 C 56.52 389.90 48.99 409.77 48.18 429.99 C 47.18 452.82 55.03 475.80 69.30 493.59 C 61.61 495.16 53.94 496.79 46.23 498.27 C 36.92 484.43 30.62 468.58 28.11 452.07 C 20.89 410.64 22.62 367.60 33.81 327.03 C 38.57 310.48 45.19 294.26 55.26 280.20 C 64.37 267.50 76.65 256.62 91.53 251.32 Z" />
<path fill="currentColor" opacity="1.00" d=" M 122.14 362.92 C 139.19 357.99 158.03 359.30 174.11 366.87 C 187.15 372.85 198.28 382.82 205.80 395.03 C 218.67 415.62 220.42 442.89 209.84 464.78 C 171.00 472.84 132.12 480.76 93.22 488.57 C 81.26 477.68 72.86 462.93 70.06 446.97 C 67.17 430.37 69.94 412.81 78.20 398.08 C 87.45 381.18 103.59 368.19 122.14 362.92 Z" />
<path fill="currentColor" opacity="1.00" d=" M 575.42 428.75 C 581.43 432.66 587.31 436.75 593.19 440.86 C 588.50 447.54 583.96 454.33 579.30 461.03 C 587.32 459.56 595.25 457.63 603.27 456.10 C 604.70 463.07 606.33 470.00 607.58 477.02 C 597.08 479.22 586.60 481.51 576.09 483.64 C 584.92 493.15 593.90 502.54 602.68 512.10 C 597.49 516.99 592.32 521.90 587.06 526.71 C 573.81 512.45 560.30 498.45 547.27 484.00 C 548.28 499.88 542.31 515.92 531.41 527.46 C 527.37 531.42 523.67 535.78 519.05 539.11 C 509.57 546.24 497.94 550.76 486.02 551.00 C 330.00 551.01 173.98 550.98 17.96 551.01 C 11.20 551.17 4.92 544.83 5.44 538.01 C 5.31 532.22 9.86 526.77 15.55 525.76 C 62.82 516.15 110.05 506.38 157.34 496.88 C 156.76 503.33 155.00 509.57 153.31 515.79 C 159.88 517.85 166.29 520.39 172.81 522.59 C 176.05 512.85 178.06 502.70 178.60 492.44 C 195.89 488.97 213.16 485.33 230.46 481.90 C 230.07 490.29 228.41 498.56 225.95 506.58 C 232.44 508.88 238.90 511.25 245.37 513.62 C 249.48 502.20 251.39 490.00 251.29 477.88 C 268.53 473.99 285.92 470.67 303.25 467.11 C 303.39 477.42 301.93 487.78 298.56 497.54 C 305.07 499.90 311.63 502.14 318.13 504.53 C 322.66 491.19 324.67 476.95 323.70 462.89 C 340.97 459.40 358.24 455.86 375.49 452.28 C 376.49 464.47 375.26 476.87 371.26 488.46 C 377.79 490.75 384.30 493.13 390.84 495.41 C 396.03 480.27 397.67 464.01 395.84 448.13 C 416.14 444.02 436.43 439.85 456.73 435.71 C 457.67 446.69 456.40 457.80 453.47 468.40 C 460.16 470.18 466.85 471.96 473.56 473.64 C 477.41 460.00 478.77 445.62 477.16 431.52 C 489.56 428.92 502.88 430.08 514.37 435.56 C 529.59 442.62 541.28 456.81 545.32 473.09 C 555.00 458.07 565.48 443.60 575.42 428.75 Z" />
</g>
                            </svg>                            
                         </i> </span>
                      <span class="label-char letra4" style="--index: 0">Cantidad</span>
                     
                     
                     
                    </label>
                    <p  class=" text-center l er error4"  ></p>
   
            </div>

               <div class="col-4 wave-group p-2  my-3">
                <input required="" disabled="true" type="text" class="input unidad" id="unidad">
                    <span class="bar bar4"></span>
               </div>
                                </div>
                           
             
                              

      <div class="col-12">
                      <div class="card shadow" id="tablaD">
                        <div class="card-body">
                         
                          <div>
                             <div class="table-responsive table-wrapper" id="totalD">
                          <table class="table tables table-bordered table-hover tabla2" id="tabla2" >
                              <thead class="table-success">
                                  <tr>
                                    <th colspan="3" class="blanco fw-bold text-center">Stock Disponible</th>
                                  </tr>
                              </thead>
                              <tbody id="tbody2" class="tbody2">
                            
                                  
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
                    

                    <div class="modal-footer">   
              <div class="text-start">  

         
                  <button type="button"  class="btn btn-primary action-button " id="agregarInventario" > Agregar</button>
                  <button type="reset" class="btn btn-danger float-end me-2" id="cancelarInventario">Cancelar</button>
                  
              </div>
            </div>
             
                </form>
                </div>
                </div>
                </div>
      
      
        
                          <!-- MODAL BORRAR -->
                <div class="modal fade" id="borrarE" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Eliminar Evento</h5>
                                          <button type="button" class="btn-close btn-primary" aria-label="Close" data-bs-dismiss="modal"></button>
                                      </div>
                                <form method="POST">
                          <input type="hidden" name="csrf_token" id="tokenCsrfEliminar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">

                 <div class="modal-body mb-2">
                  <div align="center">
                    <img src="assets/images/basura.png" width="250" >
                  </div>
                   
                  <h5 class="eliminarE text-center"></h5>
                  <input type="hidden" name="" id="idE">
                              
                </div>
                <div class="modal-footer">
                    <div class="text-start">
                      <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="cerrar3">Cancelar</button>
                       <button type="button" class="btn btn-primary"  id="borrar" name="borrar">Eliminar</button>
                    </div>
                </div>
                </form>
                                  </div>
                              </div>
                </div>

     <!-- MODAL PDF -->
     <div class="modal fade" id="pdfEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                   <h5 class="text-center"> ¿Deseas Descargar el Evento?</h5>
                   <input type="hidden" id='idEvento'>
                </div>
                <div class="loadingAnimation" style="display:none;">
                    <div class="spinner"></div>
                </div>
                <div class="modal-footer">
                    <div class="text-start">
                      <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="clos" >Cancelar</button>
                       <button type="button"  class="btn btn-primary" id="reportebtn" >Descargar</button>
                    </div>
                </div>
                </form>
          </div>
      </div>
   </div>
                 


          <?php $footer->footer(); ?>
      </div>  
     
 </main>
   <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script  type="text/javascript" src="assets/js/evento/consultarEvento.js"></script> 
     <script src="assets/js/close.js"></script>
  </body>
</html>