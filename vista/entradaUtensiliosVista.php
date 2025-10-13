
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Registrar Entrada de Utensilios | Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
       <script src="assets/js/close.js"></script>
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
              <!-- /////// HEADER //////// -->
      <div class="position-relative iq-banner">
          <div class="iq-navbar-header " style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div class=" col-md-12">
                                  <h1 class="fw-bold blanco">Registrar Entrada de Utensilios</h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                    <?php 
                                      if(isset($permisos['Home']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode( $sistem->encryptURL('home')).'">Inicio</a></li>';
                                      }
                                      if(isset($permisos['Inventario de Utensilios']['consultar']) ){
                                        echo ' <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('consultarEntradaUtensilios')).'"> Consultar Entrada de Utensilios</a></li>';
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


                <div class="col-md-4">
                    <div class="card shadow" data-aos="fade-up" data-aos-delay="700">
                        <div class="card-body">
                        
                              <form class="formu form1">
                              <input type="hidden" name="csrf_token"  value="<?php echo htmlspecialchars($tokenCsrf); ?>">


                                  <div class="wave-group p-2 my-2 " id="sel" style="margin-top: 1.7vw!important">

                <select class="input tipoU" id="tipoU">
                   
                </select>
                    <span class="bar bar2"></span>
                    <label class="label labelPri ic2">
                        <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i class="icon">
           <svg width="20" height="20" viewBox="0 0 207 170" version="1.1" xmlns="http://www.w3.org/2000/svg">

<g id="#a5acb9ff">
<path fill="currentColor" opacity="1.00" d=" M 22.70 3.62 C 25.92 2.12 29.52 3.79 31.72 6.25 C 53.43 28.13 75.21 49.94 96.91 71.83 C 85.56 83.18 74.15 94.48 62.88 105.92 C 58.50 102.71 55.20 98.34 51.13 94.79 C 41.90 86.04 33.23 76.66 25.49 66.57 C 16.29 54.63 12.84 38.78 15.21 24.00 C 15.97 19.23 16.87 14.48 17.76 9.73 C 18.20 7.01 19.94 4.41 22.70 3.62 Z" />
<path fill="currentColor" opacity="1.00" d=" M 111.90 114.51 C 115.94 109.46 121.05 105.38 125.31 100.53 C 126.21 101.38 127.25 102.06 128.14 102.94 C 142.41 117.28 156.87 131.43 171.16 145.75 C 175.59 149.85 175.07 157.74 170.08 161.14 C 166.17 163.96 160.43 163.36 157.09 159.91 C 141.95 144.86 127.05 129.55 111.90 114.51 Z" />
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 155.60 4.72 C 157.17 3.72 159.23 2.35 161.08 3.52 C 164.22 4.66 164.86 9.34 162.48 11.50 C 153.22 20.89 143.89 30.20 134.65 39.61 C 133.72 40.59 133.17 41.83 132.53 43.00 C 133.37 44.55 134.04 46.55 135.99 46.97 C 137.92 47.91 139.83 46.45 141.23 45.26 C 150.88 36.89 160.60 28.60 170.28 20.25 C 171.86 18.82 174.21 17.32 176.32 18.69 C 179.63 20.12 179.60 24.95 177.21 27.20 C 169.30 36.27 161.44 45.38 153.52 54.44 C 151.95 56.31 149.48 58.23 150.25 61.00 C 150.64 64.02 155.02 65.49 157.09 63.17 C 166.78 53.82 176.27 44.26 185.91 34.85 C 188.76 31.31 193.82 34.10 194.51 37.98 C 192.94 41.68 190.46 44.86 188.24 48.18 C 182.36 56.96 176.47 65.75 170.58 74.54 C 165.96 81.42 158.44 86.31 150.20 87.46 C 142.58 89.10 134.78 86.67 128.16 82.94 C 102.86 108.39 77.52 133.80 52.21 159.24 C 49.29 162.63 44.17 164.07 40.08 161.98 C 33.79 159.38 32.70 150.13 37.55 145.62 C 63.18 120.05 88.80 94.46 114.56 69.02 C 110.25 62.26 108.38 53.86 110.15 45.98 C 111.53 37.91 116.64 30.84 123.37 26.33 C 134.12 19.13 144.85 11.90 155.60 4.72 Z" />
</g>
</svg>

        </i> </span>
                      <span class="label-char letra2" style="--index: 0">T</span>
                      <span class="label-char letra2" style="--index: 1">i</span>
                      <span class="label-char letra2" style="--index: 2">p</span>
                      <span class="label-char letra2" style="--index: 3; margin-right: 3px!important;">o</span>
                      <span class="label-char letra2" style="--index: 3">D</span>
                      <span class="label-char letra2" style="--index: 4; margin-right: 3px!important;">e</span>
                       <span class="label-char letra2" style="--index: 4">U</span>
                      <span class="label-char letra2" style="--index: 5">t</span>
                      <span class="label-char letra2" style="--index: 5">e</span>
                       <span class="label-char letra2" style="--index: 6">n</span>
                        <span class="label-char letra2" style="--index: 6">s</span>
                        <span class="label-char letra2" style="--index: 7">i</span>
                        <span class="label-char letra2" style="--index: 7">l</span>
                        <span class="label-char letra2" style="--index: 7">i</span>
                        <span class="label-char letra2" style="--index: 7">o</span>
                     
                     
                     
                    </label>
                    <p  class=" text-center l er error2"  ></p>
   
            </div>


            <div class="wave-group p-2  my-2 mt-1"  id="sel2">
               <select class="input utensilio" id="utensilio">
                   <option value="Seleccionar">Seleccionar</option>
                </select>
                    <span class="bar bar3"></span>
                    <label class="label labelPri ic3">
                        <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;">  <i class="icon">
           <svg width="20" height="20" viewBox="0 0 209 157" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#ffffffff">
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 14.27 3.98 C 14.46 2.65 15.25 0.89 16.88 1.10 C 18.86 1.07 19.26 3.44 19.31 4.97 C 19.82 17.84 20.96 30.67 21.60 43.53 C 23.52 43.53 25.44 43.52 27.35 43.52 C 28.71 32.01 30.01 20.50 31.36 8.99 C 31.58 6.45 31.84 3.90 32.55 1.44 C 33.85 1.24 35.18 1.16 36.43 1.70 C 38.12 15.65 39.60 29.62 41.40 43.55 C 43.33 43.53 45.25 43.51 47.17 43.47 C 47.74 29.98 48.77 16.53 49.61 3.06 C 49.84 0.77 52.53 0.90 54.06 1.90 C 56.82 15.30 60.21 28.59 63.23 41.94 C 65.60 49.73 63.16 58.71 57.51 64.50 C 53.36 68.85 47.36 70.54 41.56 71.17 C 41.60 95.42 41.65 119.66 41.54 143.91 C 41.63 148.93 35.52 152.58 31.16 150.08 C 28.34 149.01 27.02 145.88 27.19 143.04 C 27.03 124.35 27.33 105.65 27.04 86.98 C 27.32 81.75 27.11 76.51 27.22 71.27 C 23.61 70.56 19.86 70.14 16.56 68.40 C 7.52 63.87 2.59 52.61 5.23 42.88 C 8.26 29.92 11.25 16.95 14.27 3.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 190.02 4.09 C 193.21 2.69 196.77 -0.12 200.33 1.75 C 203.20 2.87 204.28 6.14 204.22 8.98 C 204.25 53.32 204.22 97.66 204.24 142.00 C 204.29 145.14 203.18 148.99 199.90 150.12 C 195.58 152.51 189.60 148.97 189.59 144.01 C 189.40 128.02 189.56 112.01 189.52 96.01 C 184.02 95.89 178.51 96.20 173.02 95.88 C 168.53 95.41 164.71 91.56 164.58 87.00 C 164.40 74.32 164.57 61.64 164.50 48.95 C 164.36 40.15 165.56 30.96 170.00 23.21 C 174.98 15.36 181.52 8.16 190.02 4.09 Z" />
<path fill="currentColor" opacity="1.00" d=" M 68.57 19.07 C 83.03 8.73 101.56 4.17 119.14 6.88 C 133.57 8.74 147.23 15.47 157.60 25.67 C 153.83 34.54 154.03 44.34 154.59 53.74 C 149.26 44.31 141.63 35.91 131.74 31.17 C 112.91 21.64 88.19 25.52 73.50 40.76 C 71.96 33.51 70.21 26.30 68.57 19.07 Z" />
<path fill="currentColor" opacity="1.00" d=" M 102.47 36.71 C 119.87 33.22 138.50 43.38 145.65 59.49 C 149.90 68.75 150.24 79.60 146.97 89.21 C 142.23 102.91 129.52 113.55 115.10 115.47 C 96.75 118.64 77.51 106.69 71.67 89.12 C 67.91 78.24 69.02 65.71 74.96 55.81 C 80.79 45.88 91.06 38.57 102.47 36.71 Z" />
<path fill="currentColor" opacity="1.00" d=" M 52.18 79.48 C 54.65 78.59 57.01 77.43 59.22 76.02 C 59.18 90.01 65.25 103.91 75.75 113.18 C 87.18 123.73 103.79 128.08 118.98 125.13 C 135.51 122.13 150.12 110.02 155.91 94.23 C 158.64 101.01 165.56 105.28 172.64 106.14 C 166.29 118.93 156.19 129.75 143.71 136.71 C 129.43 144.99 112.06 147.85 95.89 144.53 C 78.72 141.41 63.20 131.17 52.89 117.18 C 51.90 115.94 52.22 114.25 52.09 112.79 C 52.25 101.69 52.16 90.59 52.18 79.48 Z" />
</g>
</svg>
        </i></span>
                      <span class="label-char letra3" style="--index: 0">U</span>
                      <span class="label-char letra3" style="--index: 1">t</span>
                      <span class="label-char letra3" style="--index: 2">e</span>
                      <span class="label-char letra3" style="--index: 3">n</span>
                      <span class="label-char letra3" style="--index: 4">s</span>
                      <span class="label-char letra3" style="--index: 5">i</span>
                      <span class="label-char letra3" style="--index: 6">l</span>
                      <span class="label-char letra3" style="--index: 7">i</span>
                      <span class="label-char letra3" style="--index: 7">o</span>
                     
                     
                    </label>
                    <p  class=" text-center l er error3"  ></p>
   
            </div>
 <div class="row">
            <div class="col-12 wave-group p-2  my-2">
                <input required="" type="number" class="input cantidad" id="cantidad">
                    <span class="bar bar4"></span>
                    <label class="label labelPri ic4">
                        <span class="label-char pl-2 letra4" style="--index: 0; margin-right: 3px!important;"> <i class="icon">
           <svg width="20" height="20" viewBox="0 0 209 157" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#ffffffff">
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 14.27 3.98 C 14.46 2.65 15.25 0.89 16.88 1.10 C 18.86 1.07 19.26 3.44 19.31 4.97 C 19.82 17.84 20.96 30.67 21.60 43.53 C 23.52 43.53 25.44 43.52 27.35 43.52 C 28.71 32.01 30.01 20.50 31.36 8.99 C 31.58 6.45 31.84 3.90 32.55 1.44 C 33.85 1.24 35.18 1.16 36.43 1.70 C 38.12 15.65 39.60 29.62 41.40 43.55 C 43.33 43.53 45.25 43.51 47.17 43.47 C 47.74 29.98 48.77 16.53 49.61 3.06 C 49.84 0.77 52.53 0.90 54.06 1.90 C 56.82 15.30 60.21 28.59 63.23 41.94 C 65.60 49.73 63.16 58.71 57.51 64.50 C 53.36 68.85 47.36 70.54 41.56 71.17 C 41.60 95.42 41.65 119.66 41.54 143.91 C 41.63 148.93 35.52 152.58 31.16 150.08 C 28.34 149.01 27.02 145.88 27.19 143.04 C 27.03 124.35 27.33 105.65 27.04 86.98 C 27.32 81.75 27.11 76.51 27.22 71.27 C 23.61 70.56 19.86 70.14 16.56 68.40 C 7.52 63.87 2.59 52.61 5.23 42.88 C 8.26 29.92 11.25 16.95 14.27 3.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 190.02 4.09 C 193.21 2.69 196.77 -0.12 200.33 1.75 C 203.20 2.87 204.28 6.14 204.22 8.98 C 204.25 53.32 204.22 97.66 204.24 142.00 C 204.29 145.14 203.18 148.99 199.90 150.12 C 195.58 152.51 189.60 148.97 189.59 144.01 C 189.40 128.02 189.56 112.01 189.52 96.01 C 184.02 95.89 178.51 96.20 173.02 95.88 C 168.53 95.41 164.71 91.56 164.58 87.00 C 164.40 74.32 164.57 61.64 164.50 48.95 C 164.36 40.15 165.56 30.96 170.00 23.21 C 174.98 15.36 181.52 8.16 190.02 4.09 Z" />
<path fill="currentColor" opacity="1.00" d=" M 68.57 19.07 C 83.03 8.73 101.56 4.17 119.14 6.88 C 133.57 8.74 147.23 15.47 157.60 25.67 C 153.83 34.54 154.03 44.34 154.59 53.74 C 149.26 44.31 141.63 35.91 131.74 31.17 C 112.91 21.64 88.19 25.52 73.50 40.76 C 71.96 33.51 70.21 26.30 68.57 19.07 Z" />
<path fill="currentColor" opacity="1.00" d=" M 102.47 36.71 C 119.87 33.22 138.50 43.38 145.65 59.49 C 149.90 68.75 150.24 79.60 146.97 89.21 C 142.23 102.91 129.52 113.55 115.10 115.47 C 96.75 118.64 77.51 106.69 71.67 89.12 C 67.91 78.24 69.02 65.71 74.96 55.81 C 80.79 45.88 91.06 38.57 102.47 36.71 Z" />
<path fill="currentColor" opacity="1.00" d=" M 52.18 79.48 C 54.65 78.59 57.01 77.43 59.22 76.02 C 59.18 90.01 65.25 103.91 75.75 113.18 C 87.18 123.73 103.79 128.08 118.98 125.13 C 135.51 122.13 150.12 110.02 155.91 94.23 C 158.64 101.01 165.56 105.28 172.64 106.14 C 166.29 118.93 156.19 129.75 143.71 136.71 C 129.43 144.99 112.06 147.85 95.89 144.53 C 78.72 141.41 63.20 131.17 52.89 117.18 C 51.90 115.94 52.22 114.25 52.09 112.79 C 52.25 101.69 52.16 90.59 52.18 79.48 Z" />
</g>
</svg>
        </i> </span>
                      <span class="label-char letra4" style="--index: 0">C</span>
                      <span class="label-char letra4" style="--index: 1">a</span>
                      <span class="label-char letra4" style="--index: 2">n</span>
                      <span class="label-char letra4" style="--index: 3">t</span>
                      <span class="label-char letra4" style="--index: 4">i</span>
                      <span class="label-char letra4" style="--index: 5">d</span>
                      <span class="label-char letra4" style="--index: 6">a</span>
                      <span class="label-char letra4" style="--index: 7">d</span>
                     
                     
                    </label>
                    <p  class=" text-center l er error4"  ></p>
   
            </div>

            
             </div>
                                 <button type="button"  class="btn btn-primary action-button float-end" id="agregarInventario" > Agregar</button>
                                 <button type="reset" class="btn btn-danger float-end me-1" id="cancelarInventario">Cancelar</button>

             
                              </form>
                         
                          
                        </div>
                        </div>
                    </div>

                     <div class="col-md-8">
                    <div class="card shadow" data-aos="fade-up" data-aos-delay="700">
                        <div class="card-body">
                       
                              <form class="formu form1 ">
                                <div class='row'>
                                <div class="wave-group p-2  my-2 col-md-6">
                <input required="" type="date" class="input fecha mt-3" id="fecha" disabled>
                    <span class="bar bar5"></span>
                    <label class="label labelPri ic5 ">
                        <span class="label-char pl-2 letra5" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
 <svg class="icon-22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>                                <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>                                <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>                                <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>                                </svg>                                                        
                         </i> </span>
                      <span class="label-char letra5" style="--index: 0">F</span>
                      <span class="label-char letra5" style="--index: 1">e</span>
                      <span class="label-char letra5" style="--index: 2">c</span>
                      <span class="label-char letra5" style="--index: 3">h</span>
                      <span class="label-char letra5" style="--index: 4">a</span>
                    
                     
                     
                    </label>
                    <p  class=" text-center l er error5"  ></p>
   
            </div>

            <div class="wave-group p-2  my-2 col-md-6">
                <input required="" type="time" class="input hora mt-3" id="hora" disabled>
                    <span class="bar bar8"></span>
                    <label class="label labelPri ic8 ">
                        <span class="label-char pl-2 letra8" style="--index: 0; margin-right: 3px!important;"> <i class="bi bi-clock-fill "></i> </span>
                      <span class="label-char letra8" style="--index: 0">H</span>
                      <span class="label-char letra8" style="--index: 1">o</span>
                      <span class="label-char letra8" style="--index: 2">r</span>
                      <span class="label-char letra8" style="--index: 3">a</span>
                     
                    </label>
                    <p  class=" text-center l er error8"  ></p>
   
            </div>
            </div>


    <div class="wave-group p-2  my-2">
               <textarea class="input Textarea" id="descripcion"></textarea>
                    <span class="bar bar6"></span>
                    <label class="label labelPri ic6 ">
                        <span class="label-char pl-2 letra6" style="--index: 0; margin-right: 3px!important;"> <i class="icon">
           <svg width="20" height="20" viewBox="0 0 209 157" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#ffffffff">
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 14.27 3.98 C 14.46 2.65 15.25 0.89 16.88 1.10 C 18.86 1.07 19.26 3.44 19.31 4.97 C 19.82 17.84 20.96 30.67 21.60 43.53 C 23.52 43.53 25.44 43.52 27.35 43.52 C 28.71 32.01 30.01 20.50 31.36 8.99 C 31.58 6.45 31.84 3.90 32.55 1.44 C 33.85 1.24 35.18 1.16 36.43 1.70 C 38.12 15.65 39.60 29.62 41.40 43.55 C 43.33 43.53 45.25 43.51 47.17 43.47 C 47.74 29.98 48.77 16.53 49.61 3.06 C 49.84 0.77 52.53 0.90 54.06 1.90 C 56.82 15.30 60.21 28.59 63.23 41.94 C 65.60 49.73 63.16 58.71 57.51 64.50 C 53.36 68.85 47.36 70.54 41.56 71.17 C 41.60 95.42 41.65 119.66 41.54 143.91 C 41.63 148.93 35.52 152.58 31.16 150.08 C 28.34 149.01 27.02 145.88 27.19 143.04 C 27.03 124.35 27.33 105.65 27.04 86.98 C 27.32 81.75 27.11 76.51 27.22 71.27 C 23.61 70.56 19.86 70.14 16.56 68.40 C 7.52 63.87 2.59 52.61 5.23 42.88 C 8.26 29.92 11.25 16.95 14.27 3.98 Z" />
<path fill="currentColor" opacity="1.00" d=" M 190.02 4.09 C 193.21 2.69 196.77 -0.12 200.33 1.75 C 203.20 2.87 204.28 6.14 204.22 8.98 C 204.25 53.32 204.22 97.66 204.24 142.00 C 204.29 145.14 203.18 148.99 199.90 150.12 C 195.58 152.51 189.60 148.97 189.59 144.01 C 189.40 128.02 189.56 112.01 189.52 96.01 C 184.02 95.89 178.51 96.20 173.02 95.88 C 168.53 95.41 164.71 91.56 164.58 87.00 C 164.40 74.32 164.57 61.64 164.50 48.95 C 164.36 40.15 165.56 30.96 170.00 23.21 C 174.98 15.36 181.52 8.16 190.02 4.09 Z" />
<path fill="currentColor" opacity="1.00" d=" M 68.57 19.07 C 83.03 8.73 101.56 4.17 119.14 6.88 C 133.57 8.74 147.23 15.47 157.60 25.67 C 153.83 34.54 154.03 44.34 154.59 53.74 C 149.26 44.31 141.63 35.91 131.74 31.17 C 112.91 21.64 88.19 25.52 73.50 40.76 C 71.96 33.51 70.21 26.30 68.57 19.07 Z" />
<path fill="currentColor" opacity="1.00" d=" M 102.47 36.71 C 119.87 33.22 138.50 43.38 145.65 59.49 C 149.90 68.75 150.24 79.60 146.97 89.21 C 142.23 102.91 129.52 113.55 115.10 115.47 C 96.75 118.64 77.51 106.69 71.67 89.12 C 67.91 78.24 69.02 65.71 74.96 55.81 C 80.79 45.88 91.06 38.57 102.47 36.71 Z" />
<path fill="currentColor" opacity="1.00" d=" M 52.18 79.48 C 54.65 78.59 57.01 77.43 59.22 76.02 C 59.18 90.01 65.25 103.91 75.75 113.18 C 87.18 123.73 103.79 128.08 118.98 125.13 C 135.51 122.13 150.12 110.02 155.91 94.23 C 158.64 101.01 165.56 105.28 172.64 106.14 C 166.29 118.93 156.19 129.75 143.71 136.71 C 129.43 144.99 112.06 147.85 95.89 144.53 C 78.72 141.41 63.20 131.17 52.89 117.18 C 51.90 115.94 52.22 114.25 52.09 112.79 C 52.25 101.69 52.16 90.59 52.18 79.48 Z" />
</g>
</svg>
        </i> </span>
                      <span class="label-char letra6" style="--index: 0">D</span>
                      <span class="label-char letra6" style="--index: 1">e</span>
                      <span class="label-char letra6" style="--index: 2">s</span>
                      <span class="label-char letra6" style="--index: 3">c</span>
                      <span class="label-char letra6" style="--index: 4">r</span>
                      <span class="label-char letra6" style="--index: 5">i</span>
                      <span class="label-char letra6" style="--index: 5">p</span>
                      <span class="label-char letra6" style="--index: 6">c</span>
                      <span class="label-char letra6" style="--index: 6">i</span>
                      <span class="label-char letra6" style="--index: 7">ó</span>
                      <span class="label-char letra6" style="--index: 7">n</span>
                    
                     
                     
                    </label>
                    <p  class=" text-center l er error6"  ></p>
   
 </div>

 <div id="ani">
    <div class="table-responsive">
                          <table class="table table-bordered table-hover tabla" id="tabla">
                              <thead class="table-success">
                                  <tr>
                                    <th class="blanco fw-bold">Imagen</th>
                                    <th class="blanco fw-bold">Utensilio</th>
                                    <th class="blanco fw-bold">Material</th>
                                     <th class="blanco fw-bold">Cantidad</th>
                                    <th class="blanco fw-bold accion"></th>
                                  </tr>
                              </thead>
                              <tbody id="tbody" class="tbody">
                            
                                  
                              </tbody>
                          </table>
                        </div>
 </div>
                             
                          
                                <button type="button" name="next" class="btn btn-primary next action-button float-end" id="registrar"  value="Next"  >Registrar</button>
                                 <button type="button" class="btn btn-danger float-end me-1 cancelarI" id="cancelar">Cancelar</button>
                              </form>
                         
                      
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
      <?php $configuracion->configuracion(); ?>
    </div>
     <?php $components->componentsJS(); ?>
     <script src="assets/js/inventarioUtensilios/registrarEntrada.js"></script> 
  </body>
</html>