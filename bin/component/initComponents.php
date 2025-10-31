<?php 

	namespace component;

	class initComponents{

		public static function componentsHeader(){

			$componentsHeader = '
                     
                     <!-- Favicon -->
                     <link rel="shortcut icon" href="assets/images/logos/favicon.ico" />

                     <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

                     <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

                     <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
      
                     <!-- Library / Plugin Css Build -->
                     <link rel="stylesheet" href="assets/css/core/libs.min.css" />
      
                     <!-- Aos Animation Css -->
                     <link rel="stylesheet" href="assets/vendor/aos/dist/aos.css" />
      
                     <!-- Hope Ui Design System Css -->
                     <link rel="stylesheet" href="assets/css/hope-ui.css?v=2.0.0" />
      
                     <!-- Custom Css -->
                     <link rel="stylesheet" href="assets/css/custom.css?v=2.0.0" />
      
                     <!-- Dark Css -->
                     <link rel="stylesheet" href="assets/css/dark.css"/>
      
                     <!-- Customizer Css -->
                     <link rel="stylesheet" href="assets/css/customizer.css" />
      
                     <!-- RTL Css -->
                     <link rel="stylesheet" href="assets/css/rtl.css"/>
                   

                     <!-- Fullcalender CSS -->

                  
                     <!-- Alerts CSS-->
                      <link href="assets/sw2/sweetalert2.min.css" rel="stylesheet">

                     <!-- Select2 CSS-->

                      <link href="assets/css/select2/select2-bootstrap-5-theme.min.css" rel="stylesheet">

                      <link href="assets/css/select2/select2-bootstrap-5-theme.rtl.min.css" rel="stylesheet">

                      <link href="assets/css/select2/select2.min.css" rel="stylesheet">

                    <!-- dataTable CSS-->

                    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

                    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

                    <link rel="stylesheet" href="assets/css/notificaciones.css"/>

                  ';

			echo $componentsHeader;
		}

		public static function componentsJS(){

			$componentsJS = '

                  <!-- Library Bundle Script -->
                  <script src="assets/js/core/libs.min.js"></script>
    
                  <!-- External Library Bundle Script -->
                  <script src="assets/js/core/external.min.js"></script>
    
                  <!-- mapchart Script -->

                  <script src="assets/js/charts/vectore-chart.js"></script>

                  <script src="assets/js/charts/dashboard.js" ></script>
    
                  
                  <!-- Settings Script MOOD OSCURO-->
                  <script src="assets/js/plugins/setting.js"></script>
    
                  <!-- Slider-tab Script -->
                  <script src="assets/js/plugins/slider-tabs.js"></script>
    
                  <!-- Form Wizard Script -->
                  <script src="assets/js/plugins/form-wizard.js"></script>

                  <!-- cricle progress Script -->
                  <script src="assets/js/plugins/circle-progress.js"></script>

                  <!-- AOS Animation Plugin-->
                  <script src="assets/vendor/aos/dist/aos.js"></script>
    
                  <!-- App Script -->
                  <script src="assets/js/hope-ui.js" defer></script>

                   <!-- GRAFICAS Script -->

                    <script src="assets/vendor/echarts/echarts.min.js"></script>

                    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

                  
                   <!-- Fullcalender Javascript -->

                   <script src="assets/vendor/fullcalendar/dist/index.global.js"></script>
                 

                  <!-- ALERTS Script-->

                   <script src="assets/sw2/sweetalert2.all.min.js"></script>

                  <!-- Jquery Script-->

                  <script src="assets/js/jquery-3.6.0.js"></script>

                   <!-- select2 Script-->

                  <script src="assets/js/select2/select2.full.min.js"></script>

                  <script src="assets/js/select2/select2.min.js"></script>

                  <!-- dataTable Script-->

                  <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>

                 <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

                  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

                  <!-- html2 canva Script-->

                  <script src="assets/js/plugins/html2canvas.min.js"></script>

                    <script src="assets/js/cambiarHorario.js"></script>
                    <script src="assets/js/configuracion.js"></script>
                   
                   <script src="assets/js/main.js"></script>
                   <script src="assets/js/descuentoAlimento.js"></script>
                   <script src="assets/js/postRateLimiterAlert.js"></script>
                 
			';

			echo $componentsJS;



		}




	}
 ?>