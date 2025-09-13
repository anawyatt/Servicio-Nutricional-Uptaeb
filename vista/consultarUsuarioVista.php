<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Consultar Usuarios | Servicio Nutricional UPTAEB</title>
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
                              <div class=" col-md-7">
                                  <h1 class="fw-bold blanco">Consultar Usuarios</h1>
                                  <nav>
                                     <ol class="breadcrumb">
                                     <?php 
                                    if(isset($permisos['Home']['consultar']) ){
                                      echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                    }
                                    if(isset($permisos['Usuarios']['registrar']) ){
                                      echo '
                                        <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('usuario')).'">Registrar Usuarios</a></li>';
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
                     </div>
                     <div id="ani">
                     <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla" >
                              <thead class="table-success">
                                  <tr>
                                    <th class="blanco fw-bold">Foto de perfil</th>
                                    <th class="blanco fw-bold">Cédula</th>
                                    <th class="blanco fw-bold">Nombre</th>
                                    <th class="blanco fw-bold">Apellido</th>
                                    <th class="blanco fw-bold">Estado</th>
                                    <th class="blanco fw-bold accion">Acciones</th>
                                  </tr>
                              </thead>
                              <tbody id="tbody_usuario">
                            
                                  
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
                     <div class="modal fade" id="infoUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Información del Usuario</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body mb-2 mt-2 row">
                                        <div class="col-12 m-auto mb-2" id="imag" align="center">
                                          
                                        </div>
                                        <div class="col-12">
                                        <div class="table-responsive">
                                             <table class="table table-hover table-bordered" >
                                              
                                               <thead class="table-success">
                                                  <tr>
                                                   <th class="blanco text-center">Cédula</th>
                                                   <th class=" blanco text-center">Nombre</th>
                                                   <th class=" blanco text-center">Segundo Nombre</th>
                                                   <th class=" blanco text-center">Apellido</th>
                                                   <th class=" blanco text-center">Segundo Apellido</th>
                                                   </tr>
                                               </thead>
                                               <tbody id="info1"></tbody>
                                             </table>

                                                <table class="table table-hover table-bordered" >
                                               <thead class="table-success">
                                                  <tr>
                                                <th class="blanco text-center">Correo</th>
                                                <th class="blanco text-center">Nº de Teléfono</th>
                                                 <th class="blanco text-center">Rol</th>                                    
                                                  </tr>
                                                 </thead>
                                               <tbody id="info2"> </tbody>
                                             </table>

                                             
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
                    <div class="modal fade" id="editarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                        
                                          <h5 class="modal-title title" id="staticBackdropLabel">Modificar Usuario</h5>
                                          <button type="button" class="btn-close btn-primary resetear cerrar2" aria-label="Close" data-bs-dismiss="modal"></button>
                                          
                                      </div>
                                      <div class="modal-body mb-2">
                                        <div class="row container">
                                              <input type="hidden" id="idd" name="">
                                           <div class="wave-group p-2 col-12 my-2">
                        <input type="hidden" name="csrf_token" id="tokenCsrfModificar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">

                <input required="" type="text" id="cedula" class="input cedula" disabled="true">
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1">
                        <span class="defecto pl-2 " style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="defecto" style="--index: 0">Cédula</span>
                    </label>
                    <p  class=" text-center l er error1"  ></p>
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="nombre" class="input nombre">
                    <span class="bar bar2"></span>
                    <label class="label labelPri ic2">
                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra2" style="--index: 0">Nombre</span>     
                    </label>
                    <p  class=" text-center l er error2"  ></p>
   
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="segNombre" class="input segNombre">
                    <span class="bar bar3"></span>
                    <label class="label labelPri ic3">
                        <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra3" style="--index: 0">Segundo Nombre</span>                     
                    </label>
                    <p  class=" text-center l er error3"  ></p>
   
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="apellido" class="input apellido">
                    <span class="bar bar4"></span>
                    <label class="label labelPri ic4">
                        <span class="label-char pl-2 letra4" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra4" style="--index: 0">Apellido</span>             
                    </label>
                    <p  class=" text-center l er error4"  ></p>
   
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="segApellido" class="input segApellido">
                    <span class="bar bar5"></span>
                    <label class="label labelPri ic5">
                        <span class="label-char pl-2 letra5" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra5" style="--index: 0">Segundo Apellido</span>  
                    </label>
                    <p  class=" text-center l er error5"  ></p>
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="email" id="correo" class="input correo">
                    <span class="bar bar6"></span>
                    <label class="label labelPri ic6">
                        <span class="label-char pl-2 letra6" style="--index: 0; margin-right: 3px!important;"> <i  >                                <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z" fill="currentColor"></path>                                <path d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z" fill="currentColor"></path>                                </svg>                            </i> </span>
                      <span class="label-char letra6" style="--index: 0">Correo Electrónico</span>
                    </label>
                    <p  class=" text-center l er error6"  ></p>
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="telefono" class="input telefono">
                    <span class="bar bar7"></span>
                    <label class="label labelPri ic7">
                        <span class="label-char pl-2 letra7" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                     <span class="label-char letra7" style="--index: 0; margin-right: 5px!important;">Nº de Teléfono</span> 
                    </label>
                    <p  class=" text-center l er error7"  ></p>
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2" id="selectR">
             <select class="input rol" id="rol">
                                        
                                        </select>
                                      
                    <span class="bar bar8"></span>
                    <label class="label labelPri ic8">
                        <span class="label-char pl-2 letra8" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra8" style="--index: 0">Tipo de Rol</span>                
                    </label>
                    <p  class=" text-center l er error8"  ></p>
                                          </div>

                                          <div class="wave-group p-2 col-md-6 my-2">
                <select id="estado" class="input estado statusUser">
                   <option value=1> Activo</option>
                   <option value=2> Inactivo</option>
                </select>
                    <span class="bar bar9"></span>
                    <label class="label labelPri ic9">
                        <span class="label-char pl-2 letra9" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                            <svg class="icon-24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path> <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path> </svg>                            
                         </i> </span>
                      <span class="label-char letra9" style="--index: 0">Estado</span>
                    </label>
                    <p  class=" text-center l er error9"  ></p>
   
                                          </div>

                                         </div>
                                      <div class="modal-footer">
                                           <div class="text-start">
                                           <button type="button" class="btn btn-danger resetear" aria-label="Close">Cancelar</button>
                                         
                                              <button id="editar" type="button" class="btn btn-primary">Modificar</button>
                                         </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>

                     <!-- MODAL BORRAR -->       
                    <div class="modal fade" id="borrarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Anular Usuario</h5>
                                          <button type="button" class="btn-close btn-primary" aria-label="Close" data-bs-dismiss="modal"></button>
                                      </div>
                                <form method="POST" id="eliminarU">
                         <input type="hidden" name="csrf_token" id="tokenCsrfEliminar" value="<?php echo htmlspecialchars($tokenCsrf); ?>">


                 <div class="modal-body mb-2">
                  <div align="center">
                    <img src="assets/images/basura.png" width="250" >
                  </div>
                   
                  <h5 class="eliminarU text-center"></h5>
                              
                </div>
                <div class="modal-footer">
                    <div class="text-start">
                      <button type="button" class="btn btn-danger" aria-label="Close" data-bs-dismiss="modal" id="cerrarU">Cancelar</button>
                       <button type="button" class="btn btn-primary"  id="borrar" name="borrar">Anular</button>
                    </div>
                </div>
                </form>
                                  </div>
                              </div>
                    </div>
     


         <?php $footer->footer(); ?>
 </main>

 </div>  
   <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script  type="text/javascript" src="assets/js/user/consultarUsuario.js"></script> 
     <script src="assets/js/close.js"></script>
  </body>
</html>