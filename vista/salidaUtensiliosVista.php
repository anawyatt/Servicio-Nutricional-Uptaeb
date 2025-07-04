
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Registrar Salida de Utensilios | Servicio Nutricional UPTAEB</title>
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
                                  <h1 class="fw-bold blanco">Registrar Salida de Utensilios</h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                    <?php 
                                      if(isset($permisos['Home']['consultar']) ){
                                        echo '<li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                      }
                                      if(isset($permisos['Inventario de Utensilios']['consultar']) ){
                                        echo '    <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('consultarSalidaUtensilios')).'">Consultar Salida de Utensilios</a></li>';
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
                        <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;"> <i class="icon">
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
            <div class=" wave-group p-2  mt-2 " id="disponibilidad">
                <input  type="tex" class="input dispo non-editable" id="dispo"  value="0">
                    <span class="bar bar"></span>
                    <label class="label labelPri ic">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
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
                      <span class="label-char letra" style="--index: 0">C</span>
                      <span class="label-char letra" style="--index: 1">a</span>
                      <span class="label-char letra" style="--index: 2">n</span>
                      <span class="label-char letra" style="--index: 3">t</span>
                      <span class="label-char letra" style="--index: 4">i</span>
                      <span class="label-char letra" style="--index: 5">d</span>
                      <span class="label-char letra" style="--index: 6">a</span>
                      <span class="label-char letra" style="--index: 7; margin-right: 3px!important;">d</span>
                      <span class="label-char letra" style="--index: 8">D</span>
                      <span class="label-char letra" style="--index: 8">i</span>
                      <span class="label-char letra" style="--index: 9">s</span>
                      <span class="label-char letra" style="--index: 9">p</span>
                      <span class="label-char letra" style="--index: 10">o</span>
                      <span class="label-char letra" style="--index: 10">n</span>
                      <span class="label-char letra" style="--index: 11">i</span>
                      <span class="label-char letra" style="--index: 11">b</span>
                      <span class="label-char letra" style="--index: 12">l</span>
                      <span class="label-char letra" style="--index: 12">e</span>
                     
                     
                    </label>
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
        </i></span>
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
                <input required="" type="date" class="input fecha mt-2" id="fecha">
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
                <input required="" type="time" class="input hora mt-2" id="hora">
                    <span class="bar bar8"></span>
                    <label class="label labelPri ic8 ">
                        <span class="label-char pl-2 letra8" style="--index: 0; margin-right: 3px!important;"> <i class="bi bi-clock-fill "></i>                                                        
                         </i> </span>
                      <span class="label-char letra8" style="--index: 0">H</span>
                      <span class="label-char letra8" style="--index: 1">o</span>
                      <span class="label-char letra8" style="--index: 2">r</span>
                      <span class="label-char letra8" style="--index: 3">a</span>
                     
                    </label>
                    <p  class=" text-center l er error8"  ></p>
   
            </div>
            </div>

  <div class="wave-group p-2  my-2" id="sel3">
                  <select class="input tipoS" id="tipoS">
                  </select>
                    <span class="bar bar7"></span>
                    <label class="label labelPri ic7 ">
                        <span class="label-char pl-2 letra7" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
 <svg  class='icon-22' viewBox="0 0 169 170" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#ffffffff">
</g>
<g id="#1e3050ff">
<path fill="currentColor" opacity="1.00" d=" M 75.48 3.79 C 80.65 3.52 86.52 1.62 91.14 4.88 C 96.54 8.51 96.52 17.56 91.10 21.16 C 87.02 24.07 81.79 22.48 77.20 23.53 C 61.57 25.40 46.89 33.84 37.41 46.41 C 28.54 57.82 24.40 72.61 25.38 86.97 C 26.21 103.48 34.36 119.44 47.29 129.76 C 57.81 138.42 71.46 142.99 85.04 143.00 C 89.62 142.88 94.23 146.14 94.93 150.80 C 96.46 156.44 92.05 162.63 86.18 162.97 C 70.64 162.89 54.99 158.70 42.00 150.04 C 24.10 138.53 11.06 119.56 7.11 98.61 C 3.96 83.22 5.64 66.93 11.60 52.40 C 22.22 26.38 47.46 6.85 75.48 3.79 Z" />
<path fill="currentColor" opacity="1.00" d=" M 111.43 43.78 C 113.73 37.65 122.67 36.19 127.15 40.77 C 138.90 52.39 150.55 64.13 162.24 75.81 C 166.15 79.58 166.16 86.41 162.24 90.18 C 150.56 101.86 138.91 113.59 127.17 125.21 C 122.79 129.71 114.07 128.45 111.58 122.55 C 109.19 118.21 110.88 112.67 114.54 109.60 C 120.31 104.19 125.61 98.26 131.68 93.19 C 109.11 92.68 86.49 93.28 63.92 92.88 C 57.66 92.27 53.78 85.10 56.13 79.42 C 57.20 75.59 61.09 73.26 64.89 73.02 C 87.15 72.85 109.43 73.26 131.68 72.82 C 125.61 67.74 120.31 61.81 114.54 56.40 C 110.99 53.41 109.24 48.08 111.43 43.78 Z" />
</g>
</svg>                                                        
                         </i> </span>
                      <span class="label-char letra7" style="--index: 0">T</span>
                      <span class="label-char letra7" style="--index: 1">i</span>
                      <span class="label-char letra7" style="--index: 2">p</span>
                      <span class="label-char letra7" style="--index: 3; margin-right: 3px!important;">o</span>
                      <span class="label-char letra7" style="--index: 3">D</span>
                      <span class="label-char letra7" style="--index: 4; margin-right: 3px!important;">e</span>
                       <span class="label-char letra7" style="--index: 4">S</span>
                      <span class="label-char letra7" style="--index: 5">a</span>
                      <span class="label-char letra7" style="--index: 5">l</span>
                       <span class="label-char letra7" style="--index: 6">i</span>
                        <span class="label-char letra7" style="--index: 6">d</span>
                        <span class="label-char letra7" style="--index: 7">a</span>
                        
                    </label>
                    <p  class=" text-center l er error7"  ></p>
   
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
                          <table class="table table-bordered table-hover tabla" id="tabla" >
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
                                 <button type="reset" class="btn btn-danger float-end me-1" id="cancelar">Cancelar</button>
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
     <script src="assets/js/inventarioUtensilios/registrarSalida.js"></script> 
  </body>
</html>