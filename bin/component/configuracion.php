<?php 

	namespace component;
  use modelo\mantenimientoModelo as mantenimiento;

  $objetoB= new mantenimiento();

  if(isset($_POST['exportarBaseDatos'])){
       $objetoB->exportarBD();
  }

  if(isset($_POST['importarBaseDatos'])){
       $objetoB->importarBD();
  }

  if(isset($_POST['mensaje'])){
       $respuesta= $objetoB->mostrarMensaje();
        echo json_encode($respuesta);
        die();
  }
  

	class configuracion{

    private $permisos;

    public function __construct($permisos){
      $this->permisos = $permisos;
    }

		public function configuracion(){

       $mantenimiento = (isset($this->permisos['Mantenimiento']["Exportar"]) || isset($this->permisos['Mantenimiento']["Importar"])) ? '<hr class="hr-horizontal">
             <h5 class="mt-4 mb-3 azul10">Mantenimiento</h5>
            <div class="d-grid gap-3 grid-cols-2 mb-4">'. (isset($this->permisos['Mantenimiento']["Exportar"]) ? 
     ' <div  class="btn btn-border d-block"  >
              <a type="button" id="exportBtn">
              <i class="ri-arrow-up-line icon-24"></i>
                <span class=""> Exportar la BD </span>
                </a>
              </div>
              ' : ''). (isset($this->permisos['Mantenimiento']["Importar"]) ?  
              ' <div class="btn btn-border d-block" >
               <a type="button" id="importBtn">
              <i class="ri-arrow-down-line icon-24"></i>
                <span class=""> Importar la BD </span>
                </a>
                 
              </div>
              ' : ''). '</div>
              
               <p id=msjEI></p>
              ' : '';

	$configuracion = '
                <a class="btn btn-fixed-end btn-info btn-icon btn-setting" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" role="button" aria-controls="offcanvasExample">
      <svg width="24" viewBox="0 0 24 24" class="animated-rotate icon-30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8064 7.62361L20.184 6.54352C19.6574 5.6296 18.4905 5.31432 17.5753 5.83872V5.83872C17.1397 6.09534 16.6198 6.16815 16.1305 6.04109C15.6411 5.91402 15.2224 5.59752 14.9666 5.16137C14.8021 4.88415 14.7137 4.56839 14.7103 4.24604V4.24604C14.7251 3.72922 14.5302 3.2284 14.1698 2.85767C13.8094 2.48694 13.3143 2.27786 12.7973 2.27808H11.5433C11.0367 2.27807 10.5511 2.47991 10.1938 2.83895C9.83644 3.19798 9.63693 3.68459 9.63937 4.19112V4.19112C9.62435 5.23693 8.77224 6.07681 7.72632 6.0767C7.40397 6.07336 7.08821 5.98494 6.81099 5.82041V5.82041C5.89582 5.29601 4.72887 5.61129 4.20229 6.52522L3.5341 7.62361C3.00817 8.53639 3.31916 9.70261 4.22975 10.2323V10.2323C4.82166 10.574 5.18629 11.2056 5.18629 11.8891C5.18629 12.5725 4.82166 13.2041 4.22975 13.5458V13.5458C3.32031 14.0719 3.00898 15.2353 3.5341 16.1454V16.1454L4.16568 17.2346C4.4124 17.6798 4.82636 18.0083 5.31595 18.1474C5.80554 18.2866 6.3304 18.2249 6.77438 17.976V17.976C7.21084 17.7213 7.73094 17.6516 8.2191 17.7822C8.70725 17.9128 9.12299 18.233 9.37392 18.6717C9.53845 18.9489 9.62686 19.2646 9.63021 19.587V19.587C9.63021 20.6435 10.4867 21.5 11.5433 21.5H12.7973C13.8502 21.5001 14.7053 20.6491 14.7103 19.5962V19.5962C14.7079 19.088 14.9086 18.6 15.2679 18.2407C15.6272 17.8814 16.1152 17.6807 16.6233 17.6831C16.9449 17.6917 17.2594 17.7798 17.5387 17.9394V17.9394C18.4515 18.4653 19.6177 18.1544 20.1474 17.2438V17.2438L20.8064 16.1454C21.0615 15.7075 21.1315 15.186 21.001 14.6964C20.8704 14.2067 20.55 13.7894 20.1108 13.5367V13.5367C19.6715 13.284 19.3511 12.8666 19.2206 12.3769C19.09 11.8873 19.16 11.3658 19.4151 10.928C19.581 10.6383 19.8211 10.3982 20.1108 10.2323V10.2323C21.0159 9.70289 21.3262 8.54349 20.8064 7.63277V7.63277V7.62361Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          <circle cx="12.1747" cy="11.8891" r="2.63616" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
      </svg>
    </a>
    <!-- Wrapper End-->
    <!-- offcanvas start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" data-bs-scroll="true" data-bs-backdrop="true" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header bg-azul3">
        <div class="d-flex align-items-center">
          <h3 class="offcanvas-title me-3 title fw-bold" id="offcanvasExampleLabel">Configuración</h3>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body data-scrollbar">
        <div class="row">
          <div class="col-lg-12">
             <h5 class="mb-3  azul10">Fondo</h5>
            <div class="d-grid gap-3 grid-cols-3 mb-4">

               <div class="btn btn-border os" data-setting="color-mode" data-name="color" data-value="dark">
               <i class="ri-moon-clear-fill icon-24"></i>
                <span class="ms-2 "> Oscuro </span>
              </div>
               <div class=" active btn btn-border cl cce" data-setting="color-mode" data-name="color" data-value="light">
                  <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z" />
                </svg>
                <span class="ms-2 "> Claro</span>
              </div>
            </div>'.

                $mantenimiento
            .'

            <hr class="hr-horizontal">
            <h5 class="mt-4 mb-3 azul10">Color de la Barra Lateral</h5>
            <div class="d-grid gap-3 grid-cols-2 mb-4">
              <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-white">
                <span class=""> Por Defecto </span>
              </div>
              <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-dark">
                <span class=""> Oscuro </span>
              </div>
              <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-color">
                <span class=""> Color </span>
              </div>
            </div>
               <hr class="hr-horizontal">
             <h5 class="mt-4 mb-3 azul10">Barra lateral en caja</h5>
            <div class="d-grid gap-3 grid-cols-3 mb-4">
              <div class="text-center">
                 <img src="assets/images/settings/dark/05.png" alt="boxed" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-type" data-value="sidebar-boxed">
                 <img src="assets/images/settings/light/05.png" alt="boxed" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-type" data-value="sidebar-boxed">
              </div>
            </div>
            <hr class="hr-horizontal">
              <h5 class="mt-4 mb-3 azul10">Estilo Activo de la Barra Lateral</h5>
            <div class="d-grid gap-3 grid-cols-2 mb-4">
              <div class="text-center">
                <img src="assets/images/settings/dark/06.png" alt="rounded-one-side" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-rounded">
                <img src="assets/images/settings/light/06.png" alt="rounded-one-side" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-rounded">
                <span class="mt-2">Redondeado a un lado</span>
              </div>
              <div class="text-center">
                <img src="assets/images/settings/dark/07.png" alt="rounded-all" class="mode dark-img img-fluid btn-border p-0 flex-column active mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-rounded-all">
                <img src="assets/images/settings/light/07.png" alt="rounded-all" class="mode light-img img-fluid btn-border p-0 flex-column active mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-rounded-all">
                <span class="mt-2">Redondeado todo</span>
              </div>
              <div class="text-center">
                 <img src="assets/images/settings/dark/08.png" alt="pill-one-side" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-pill">
                 <img src="assets/images/settings/light/09.png" alt="pill-one-side" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="sidebar" data-name="sidebar-item" data-value="navs-pill">
                <span class="mt-2">Pildora a un lado</span>
              </div>
              <div class="text-center">
                 <img src="assets/images/settings/dark/09.png" alt="pill-all" class="mode dark-img img-fluid btn-border p-0 flex-column" data-setting="sidebar" data-name="sidebar-item" data-value="navs-pill-all">
                 <img src="assets/images/settings/light/08.png" alt="pill-all" class="mode light-img img-fluid btn-border p-0 flex-column" data-setting="sidebar" data-name="sidebar-item" data-value="navs-pill-all">
                <span class="mt-2">Pildora todo</span>
              </div>
            </div>
            <hr class="hr-horizontal">
               <h5 class="mt-4 mb-3 azul10">Estilo del Navegador</h5>
            <div class="d-grid gap-3 grid-cols-2 ">
              <div class=" text-center">
                <img src="assets/images/settings/dark/11.png" alt="image" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="nav-glass">
                <img src="assets/images/settings/light/10.png" alt="image" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="nav-glass">
                <span class="mt-2">Vidrio</span>
              </div>
              <div class="text-center">
                 <img src="assets/images/settings/dark/10.png" alt="color" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar-header" data-name="navbar-type" data-value="navs-bg-color">
                 <img src="assets/images/settings/light/11.png" alt="color" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar-header" data-name="navbar-type" data-value="navs-bg-color">
                <span class="mt-2">Color</span>
              </div>
              <div class=" text-center">
                 <img src="assets/images/settings/dark/12.png" alt="sticky" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="navs-sticky">
                 <img src="assets/images/settings/light/12.png" alt="sticky" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="navs-sticky">
                <span class="mt-2">Pegajosa</span>
              </div>
              <div class="text-center">
                  <img src="assets/images/settings/dark/13.png" alt="transparent" class="mode dark-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="navs-transparent">
                  <img src="assets/images/settings/light/13.png" alt="transparent" class="mode light-img img-fluid btn-border p-0 flex-column mb-2" data-setting="navbar" data-target=".iq-navbar" data-name="navbar-type" data-value="navs-transparent">
                <span class="mt-2">Transparente</span>
              </div>
              <div class="btn btn-border active col-span-full mt-4 d-block" data-setting="navbar" data-name="navbar-default" data-value="default">
                <span class=""> Navegador por Defecto</span>
              </div>
            </div>

            
            </div>
          </div>
        </div>
      </div>
  ';

  	echo $configuracion;

		}
	}



 ?>