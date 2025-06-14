<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Registrar Usuarios | Servicio Nutricional UPTAEB</title>
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
                              <h1 class="fw-bold blanco">Registrar Usuario</h1>
                                  <nav>
                                     <ol class="breadcrumb">
                                     <?php 
                                      if(isset($permisos['Home']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                      }
                                      if(isset($permisos['Usuarios']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('consultarUsuario')).'">Consultar Usuarios</a></li>';
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
                <div class="col-md-12">
                    <div class="card shadow" data-aos="fade-up" data-aos-delay="700">
                        <div class="card-body">
                        <div id="form-wizard1" class="mt-3 text-center" method="POST">
                            <ul id="top-tab-list" class="p-0 row list-inline justify-content-center">
                                <li class=" col-md-3  mb-2 center active" data-aos="fade-up" data-aos-delay="700" id="account">
                                    <a href="javascript:void();">
                                        <div class="iq-icon me-3">
                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">  <path opacity="0.4" d="M21.101 9.58786H19.8979V8.41162C19.8979 7.90945 19.4952 7.5 18.999 7.5C18.5038 7.5 18.1 7.90945 18.1 8.41162V9.58786H16.899C16.4027 9.58786 16 9.99731 16 10.4995C16 11.0016 16.4027 11.4111 16.899 11.4111H18.1V12.5884C18.1 13.0906 18.5038 13.5 18.999 13.5C19.4952 13.5 19.8979 13.0906 19.8979 12.5884V11.4111H21.101C21.5962 11.4111 22 11.0016 22 10.4995C22 9.99731 21.5962 9.58786 21.101 9.58786Z" fill="currentColor"></path>                                <path d="M9.5 15.0156C5.45422 15.0156 2 15.6625 2 18.2467C2 20.83 5.4332 21.5001 9.5 21.5001C13.5448 21.5001 17 20.8533 17 18.269C17 15.6848 13.5668 15.0156 9.5 15.0156Z" fill="currentColor"></path>                                <path opacity="0.4" d="M9.50023 12.5542C12.2548 12.5542 14.4629 10.3177 14.4629 7.52761C14.4629 4.73754 12.2548 2.5 9.50023 2.5C6.74566 2.5 4.5376 4.73754 4.5376 7.52761C4.5376 10.3177 6.74566 12.5542 9.50023 12.5542Z" fill="currentColor"></path>                                </svg>                                                                    
                                        </div>
                                        <span class="dark-wizard blanco">Identificación</span>
                                    </a>
                                </li>
                                <li id="personal" class="mb-2 col-md-3 center" data-aos="fade-up" data-aos-delay="700">
                                    <a href="javascript:void();">
                                        <div class="iq-icon me-3 ">
                                         <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M14.4183 5.49C13.9422 5.40206 13.505 5.70586 13.4144 6.17054C13.3238 6.63522 13.6285 7.08891 14.0916 7.17984C15.4859 7.45166 16.5624 8.53092 16.8353 9.92995V9.93095C16.913 10.3337 17.2675 10.6265 17.6759 10.6265C17.7306 10.6265 17.7854 10.6215 17.8412 10.6115C18.3043 10.5186 18.609 10.0659 18.5184 9.60018C18.1111 7.51062 16.5027 5.89672 14.4183 5.49Z" fill="currentColor"></path>                                <path opacity="0.4" d="M14.3558 2.00793C14.1328 1.97595 13.9087 2.04191 13.7304 2.18381C13.5472 2.32771 13.4326 2.53557 13.4078 2.76841C13.355 3.23908 13.6946 3.66479 14.1646 3.71776C17.4063 4.07951 19.9259 6.60477 20.2904 9.85654C20.3392 10.2922 20.7047 10.621 21.1409 10.621C21.1738 10.621 21.2057 10.619 21.2385 10.615C21.4666 10.59 21.6698 10.4771 21.8132 10.2972C21.9556 10.1174 22.0203 9.89351 21.9944 9.66467C21.5403 5.60746 18.4002 2.45862 14.3558 2.00793Z" fill="currentColor"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0317 12.9724C15.0208 16.9604 15.9258 12.3467 18.4656 14.8848C20.9143 17.3328 22.3216 17.8232 19.2192 20.9247C18.8306 21.237 16.3616 24.9943 7.6846 16.3197C-0.993478 7.644 2.76158 5.17244 3.07397 4.78395C6.18387 1.67385 6.66586 3.08938 9.11449 5.53733C11.6544 8.0765 7.04266 8.98441 11.0317 12.9724Z" fill="currentColor"></path>                                </svg> 
                                        </div>
                                        <span class="dark-wizard blanco">Contacto</span>
                                    </a>
                                </li>
                                <li id="payment" class="mb-2 col-md-3 text-center" data-aos="fade-up" data-aos-delay="700">
                                    <a href="javascript:void();">
                                        <div class="iq-icon me-3">

                                     <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path opacity="0.4" d="M11.9912 18.6215L5.49945 21.864C5.00921 22.1302 4.39768 21.9525 4.12348 21.4643C4.0434 21.3108 4.00106 21.1402 4 20.9668V13.7087C4 14.4283 4.40573 14.8725 5.47299 15.37L11.9912 18.6215Z" fill="currentColor"></path>
                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M8.89526 2H15.0695C17.7773 2 19.9735 3.06605 20 5.79337V20.9668C19.9989 21.1374 19.9565 21.3051 19.8765 21.4554C19.7479 21.7007 19.5259 21.8827 19.2615 21.9598C18.997 22.0368 18.7128 22.0023 18.4741 21.8641L11.9912 18.6215L5.47299 15.3701C4.40573 14.8726 4 14.4284 4 13.7088V5.79337C4 3.06605 6.19625 2 8.89526 2ZM8.22492 9.62227H15.7486C16.1822 9.62227 16.5336 9.26828 16.5336 8.83162C16.5336 8.39495 16.1822 8.04096 15.7486 8.04096H8.22492C7.79137 8.04096 7.43991 8.39495 7.43991 8.83162C7.43991 9.26828 7.79137 9.62227 8.22492 9.62227Z" fill="currentColor"></path>
                                     </svg>

                                                                                                                     
                                        </div>
                                        <span class="dark-wizard blanco">Acceso</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                              <form class="formu form1">
                              <input type="hidden" name="csrf_token" id="tokenCsrf" value="<?php echo htmlspecialchars($tokenCsrf); ?>">

                                <div class="form-card text-start">
                                 
                                    <div class="row container center">

             <div class="wave-group p-2 col-md-12 my-2">
                <input required="" type="text" id="cedula" class="input cedula">
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class="bi bi-person-badge " ></i> </span>
                      <span class="label-char letra" style="--index: 0">Cédula</span>
                    </label>
                    <p  class=" text-center l er error1"  ></p>
            </div>

            <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="nombre" class="input nombre">
                    <span class="bar bar2"></span>
                    <label class="label labelPri ic2">
                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="label-char letra2" style="--index: 0">Nombre</span>             
                    </label>
                    <p  class=" text-center l er error2"  ></p>
            </div>

             <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="segNombre" class="input segNombre">
                    <span class="bar bar3"></span>
                    <label class="label labelPri ic3">
                        <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="label-char letra3" style="--index: 0">Segundo Nombre</span>                     
                    </label>
                    <p  class=" text-center l er error3"  ></p>
            </div>

            <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="apellido" class="input apellido">
                    <span class="bar bar4"></span>
                    <label class="label labelPri ic4">
                        <span class="label-char pl-2 letra4" style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="label-char letra4" style="--index: 0">Apellido</span> 
                    </label>
                    <p  class=" text-center l er error4"  ></p>
            </div>

            <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" id="segApellido" class="input segApellido">
                    <span class="bar bar5"></span>
                    <label class="label labelPri ic5">
                        <span class="label-char pl-2 letra5" style="--index: 0; margin-right: 3px!important;"> <i class="ri-edit-fill "></i> </span>
                      <span class="label-char letra5" style="--index: 0">Segundo Apellido</span>              
                    </label>
                    <p  class="text-center l er error5"></p>
            </div>
                                    </div>
                                   
                                    </div>
                          
                                <button type="button" name="next" class="btn btn-primary next action-button float-end" id="val1"  value="Next" disabled="true" >Siguiente</button>
                                 <button type="reset" class="btn btn-danger limpiar float-end me-1 can" >Cancelar</button>
                              </form>
                            </fieldset>

                            <fieldset>
                               <form class="formu form2" id="formu">
                                <div class="form-card text-start">
                                    <div class="row container">
                                     
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
                        <span class="label-char pl-2 letra7" style="--index: 0; margin-right: 3px!important;"> <i class="ri-phone-fill "></i> </span>
                     <span class="label-char letra7" style="--index: 0; margin-right: 5px!important;">Nº de Teléfono</span>             
                    </label>
                    <p  class=" text-center l er error7"  ></p>
                                    </div>

                                    </div>
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button float-end next" value="Next" disabled="true" id="val2" >Siguiente</button>
                                 <button type="reset" class="btn btn-danger limpiar float-end me-1 can2" >Cancelar</button>
                                <button type="button" name="previous" class="btn btn-info previous action-button-previous float-end me-1" value="Previous" >Anterior</button>
                              </form>
                            </fieldset>

                            <fieldset>
                               <form class="formu">
                                <div class="form-card text-start" id="form23">
                                    <div class="row container">
                                        

                                      <div class="wave-group p-3 col-md-6 my-2" id="selectR"> 
                                        
                                        <select class="input rol" id="rol">
                                         <option value="Seleccionar">Seleccionar</option>
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

                                      <div class="wave-group p-2 col-md-6 my-2  row">
                                        <div class="col-11">
                                           <input required="" type="password" class="input clave" value="Uptaeb123*" disabled="true" id="clave">
                    <span class="bar"></span>
                    <label class="label labelPri ">
                         <span class="defecto pl-2 " style="--index: 0; margin-right: 3px!important;"> <i >
 <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.7688 8.71387H16.2312C18.5886 8.71387 20.5 10.5831 20.5 12.8885V17.8254C20.5 20.1308 18.5886 22 16.2312 22H7.7688C5.41136 22 3.5 20.1308 3.5 17.8254V12.8885C3.5 10.5831 5.41136 8.71387 7.7688 8.71387ZM11.9949 17.3295C12.4928 17.3295 12.8891 16.9419 12.8891 16.455V14.2489C12.8891 13.772 12.4928 13.3844 11.9949 13.3844C11.5072 13.3844 11.1109 13.772 11.1109 14.2489V16.455C11.1109 16.9419 11.5072 17.3295 11.9949 17.3295Z" fill="currentColor"></path>                                <path opacity="0.4" d="M17.523 7.39595V8.86667C17.1673 8.7673 16.7913 8.71761 16.4052 8.71761H15.7447V7.39595C15.7447 5.37868 14.0681 3.73903 12.0053 3.73903C9.94257 3.73903 8.26594 5.36874 8.25578 7.37608V8.71761H7.60545C7.20916 8.71761 6.83319 8.7673 6.47754 8.87661V7.39595C6.4877 4.41476 8.95692 2 11.985 2C15.0537 2 17.523 4.41476 17.523 7.39595Z" fill="currentColor"></path>                                </svg>                                                        
                       </i></span>
                      <span class="defecto" style="--index: 0">Contraseña</span>
                    </label>
                                        </div>

                                        <div class="col-1" style="margin-left: -25px!important; margin-top:12px!important;" id="eye"><i class="azul4" >
   <svg class="icon-24 eyeSi d-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"></path>                                <path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"></path>                                </svg>


    <svg class="icon-24 eyeNo"   viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M11.9902 3.88184H12C13.3951 3.88184 14.7512 4.21657 16 4.84567L12.7415 8.13491C12.5073 8.09553 12.2537 8.066 12 8.066C9.8439 8.066 8.09756 9.82827 8.09756 12.004C8.09756 12.26 8.12683 12.516 8.16585 12.7523L4.5561 16.3949C3.58049 15.2529 2.73171 13.8736 2.05854 12.2895C1.98049 12.1123 1.98049 11.8957 2.05854 11.7087C4.14634 6.80583 7.86341 3.88184 11.9902 3.88184ZM18.4293 6.54985C19.8439 7.8494 21.0439 9.60183 21.9415 11.7087C22.0195 11.8957 22.0195 12.1123 21.9415 12.2895C19.8537 17.1924 16.1366 20.1262 12 20.1262H11.9902C10.1073 20.1262 8.30244 19.506 6.71219 18.3738L9.80488 15.2529C10.4293 15.6753 11.1902 15.9322 12 15.9322C14.1463 15.9322 15.8927 14.1699 15.8927 12.004C15.8927 11.1869 15.639 10.419 15.2195 9.78889L18.4293 6.54985Z" fill="currentColor"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4296 6.54952L20.2052 4.75771C20.4979 4.4722 20.4979 3.99964 20.2052 3.71413C19.9223 3.42862 19.4637 3.42862 19.1711 3.71413L18.254 4.63957C18.2442 4.65926 18.2247 4.67895 18.2052 4.69864C18.1954 4.71833 18.1759 4.73802 18.1564 4.75771L17.2881 5.63491L14.1954 8.7558L3.72715 19.3186L3.69789 19.358C3.50276 19.6435 3.54179 20.0383 3.78569 20.2844C3.92228 20.4311 4.1174 20.5 4.30276 20.5C4.48813 20.5 4.6735 20.4311 4.81984 20.2844L15.2198 9.78855L18.4296 6.54952ZM12.0004 14.4555C13.337 14.4555 14.4297 13.3529 14.4297 12.0041C14.4297 11.5906 14.3321 11.1968 14.1565 10.8621L10.8687 14.1798C11.2004 14.3571 11.5907 14.4555 12.0004 14.4555Z" fill="currentColor"></path>                                </svg>                                                         
                       </i>
               
                    
            </div>


                        
                                    </div>
                                    
                                </div>
                                <button type="button" class="btn btn-primary  float-end"  disabled="true" id="enviar">Registrar</button>
                                 <button type="reset" class="btn btn-danger limpiar float-end me-1 can3"  >Cancelar</button>
                                <button type="button" name="previous" class="btn btn-info previous action-button-previous float-end me-1" value="Previous" >Anterior</button>
                              </form>
                            </fieldset>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div> 

 


         <?php $footer->footer(); ?>
 </main>

   <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script  type="text/javascript" src="assets/js/user/usuario.js"></script> 
     <script src="assets/js/close.js"></script>
  </body>
</html>