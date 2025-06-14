<?php

namespace component;

use helpers\encryption as encryption;
use modelo\horarioComidaModelo as horarioComida;


$objetoN = new horarioComida();



if (isset($_POST['ingresarSistem']) && isset($_POST['horariosC'])) {
  $objetoN->ingresar($_POST['horariosC']);
}

if (isset($_POST['inactividad'])) {
  $objetoN->inactividad();
}

if (isset($_POST['descuentoAlimentos'])) {
  $objetoN->descontarAlimentos();
}



class navegador
{
  private $payload;

  public function __construct($payload)
  {
    $this->payload = $payload;
  }

  public function navegador()
  {
    $sistem = new encryption();

    if (isset($this->payload->rol) && $this->payload->rol != 1) {
      $horario = '<li><hr class="dropdown-divider"></li>
           <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cambiarH" >Cambiar Horario</a></li>';
    } else {
      $horario = '';
    }

    $navegador = '
        <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
          <div class="container-fluid navbar-inner">
            <a class="navbar-brand">
                <!--Logo start-->
                <!--logo End-->
                
                <!--Logo start-->
                <img src="assets/images/logos/logo.png" width="75">
                <h5 class="logo-title titulo12 d-none d-sm-block ">Servicio Nutricional</h5>
            </a>
            <div type="button" class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                 <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
           
          
            <div class=" ms-auto">
              <ul class="navbar-nav d-flex align-items-center cen" >
              
                 <li class="nav-item dropdown">
                <a href="#"  class="nav-link" id="notification-drop" data-bs-toggle="dropdown" >
                    <svg class="icon-24 bb" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M19.7695 11.6453C19.039 10.7923 18.7071 10.0531 18.7071 8.79716V8.37013C18.7071 6.73354 18.3304 5.67907 17.5115 4.62459C16.2493 2.98699 14.1244 2 12.0442 2H11.9558C9.91935 2 7.86106 2.94167 6.577 4.5128C5.71333 5.58842 5.29293 6.68822 5.29293 8.37013V8.79716C5.29293 10.0531 4.98284 10.7923 4.23049 11.6453C3.67691 12.2738 3.5 13.0815 3.5 13.9557C3.5 14.8309 3.78723 15.6598 4.36367 16.3336C5.11602 17.1413 6.17846 17.6569 7.26375 17.7466C8.83505 17.9258 10.4063 17.9933 12.0005 17.9933C13.5937 17.9933 15.165 17.8805 16.7372 17.7466C17.8215 17.6569 18.884 17.1413 19.6363 16.3336C20.2118 15.6598 20.5 14.8309 20.5 13.9557C20.5 13.0815 20.3231 12.2738 19.7695 11.6453Z" fill="currentColor"></path>
                      <path opacity="0.4" d="M14.0088 19.2283C13.5088 19.1215 10.4627 19.1215 9.96275 19.2283C9.53539 19.327 9.07324 19.5566 9.07324 20.0602C9.09809 20.5406 9.37935 20.9646 9.76895 21.2335L9.76795 21.2345C10.2718 21.6273 10.8632 21.877 11.4824 21.9667C11.8123 22.012 12.1482 22.01 12.4901 21.9667C13.1083 21.877 13.6997 21.6273 14.2036 21.2345L14.2026 21.2335C14.5922 20.9646 14.8734 20.5406 14.8983 20.0602C14.8983 19.5566 14.4361 19.327 14.0088 19.2283Z" fill="currentColor"></path>
                    </svg>
                    <span class="bg-danger dots"></span>
                    <span id="notificacionCount" class="notification-count">0</span>
                </a>
                <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="notification-drop">
                  <div class="m-0 shadow-none card">
                      <div class="py-3 card-header d-flex justify-content-between bg-primary">
                          <div class="header-title">
                              <h5 class="mb-0 text-white">Notificaciones</h5>
                          </div>
                      </div>
                      
                      <div class="p-3">
                          <button id="leerTodas" class="btn btn-primary rounded-pill shadow" style="width: 100%;">
                              <i class="fas fa-check"></i> Marcar Todas
                          </button>
                      </div>
                      
                      <div id="nota"></div>
                  </div>
              </div>
              </li>

                <li class="nav-item dropdown">
                  <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="' . $this->payload->img . '" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                 
                    <div class="caption ms-3 d-none d-md-block ">
                        <h6 class="mb-0 caption-title azul14 fw-bold tata">' . $this->payload->nombre . ' ' . $this->payload->apellido . '</h6>
                        <p class="mb-0 caption-sub-title tete text-center azul10" id="rol_session">' . $this->payload->nombreRol . '</p>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow perfil" aria-labelledby="navbarDropdown">
                    <div class="justify-content-center p-1" align="center">
                          <img src="' . $this->payload->img . '" width="75" height="75"alt="Profile" class="rounded-circle mb-2">
                           <h6 class="mb-0 azul">' . $this->payload->nombre . ' ' . $this->payload->apellido . '</h6>
                           <p class="mb-0 caption-sub-title ">' . $this->payload->nombreRol . '</p>
                    </div>

                     <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item"href="?url=' . urlencode($sistem->encryptURL('perfil')) . '">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?url=' . urlencode($sistem->encryptURL('ayuda')) . '">Ayuda</a></li>
                      ' . $horario . '
                      <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?url=' . urlencode($sistem->encryptURL('cerrar')) . '">Cerrar Sesión</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>  
 <div class="modal fade" id="cambiarH" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header bg-azul4">
                                          <h5 class="modal-title title" id="staticBackdropLabel">Cambiar Horario de Comida</h5>
                                           <button type="button" id="cerrar" class="btn-close limpiar" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form  method="POST" class="p-2 formu" id="horarioC">
                                      <div class="modal-body mb-2">
                                        <div class="wave-group p-2  my-2 mt-3 col-12"  id="sel1">
               <select class="input horario mt-2" id="Chorario">
                <option value="Desayuno">Desayuno</option>
                <option value="Almuerzo">Almuerzo</option>
                <option value="Merienda">Merienda</option>
                <option value="Cena">Cena</option>
                </select>
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1 mb-2">
                        <span class="label-char pl-2 letra1" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
   <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>                                <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>                                <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>                                <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>                                </svg>                             
                         </i> </span>
                      <span class="label-char letra1" style="--index: 0">H</span>
                      <span class="label-char letra1" style="--index: 1">o</span>
                      <span class="label-char letra1" style="--index: 2">r</span>
                      <span class="label-char letra1" style="--index: 3">a</span>
                      <span class="label-char letra1" style="--index: 4">r</span>
                      <span class="label-char letra1" style="--index: 5">i</span>
                      <span class="label-char letra1" style="--index: 6">o</span>
                     
                    </label>
                    <p  class=" text-center l er error1"  ></p>
   
            </div>

                           
                                      </div>
                                      <div class="modal-footer">
                                            
                                            <div class="text-start">                    
                                                <button type="button" class="btn btn-danger limpiar" aria-label="Close" data-bs-dismiss="modal">Cancelar</button>
                                                <button id="cambiar" type="button" class="btn btn-primary">Cambiar</button>
                                            </div>
                                        </div>



                                      </div>
                                    </form>
                                  </div>
                              </div>
                          </div>


  ';

    echo $navegador;
  }
}
