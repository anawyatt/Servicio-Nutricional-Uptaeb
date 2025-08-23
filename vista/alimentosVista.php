
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Registrar Alimentos | Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
        <link rel="stylesheet" href="assets/css/estilo.css"/>

  </head>
  <body class="  ">
    
<!--//////////////// SIDEBAR ///////////////////////////////////////////-->
   <?php $sidebar->sidebar(); ?>
<main class="main-content">
        <!--Nav Start-->
        <?php $navegador->navegador(); ?>

        <div class="position-relative iq-banner">

          <div class="iq-navbar-header " style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div class=" col-md-7">
                                  <h1 class="fw-bold blanco">Registrar Alimentos</h1>
                                  <nav>
                                    <ol class="breadcrumb">
                                    	 <?php echo '
                                           <li class="breadcrumb-item fw-bold"><a href="?url='.$sistem->encryptURL('home').'">Inicio</a></li>
                                           <li class="breadcrumb-item fw-bold"><a href="?url='.$sistem->encryptURL('consultarAlimentos').'"> Consultar Alimentos</a></li>';
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
                                <div class="form-card text-start">
                                 
                                    <div class="row container">

                                       <div id="container0" class="contai"></div>
                                       

                                        <div class="wave-group p-2  my-2 mb-2">

        <input type="file" class=" input imagen" id="fileInput0">
        
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important; font-size: 18px!important"> <i class=" ri-image-fill " >
                                                       
                         </i> </span>
                      <span class="label-char letra" style="--index: 0">I</span>
                      <span class="label-char letra" style="--index: 1">m</span>
                      <span class="label-char letra" style="--index: 1">a</span>
                      <span class="label-char letra" style="--index: 2">g</span>
                      <span class="label-char letra" style="--index: 2">e</span>
                      <span class="label-char letra" style="--index: 3; margin-right: 3px!important;">n</span>
                      <span class="label-char letra" style="--index: 4">d</span>
                      <span class="label-char letra" style="--index: 4">e</span>
                      <span class="label-char letra" style="--index: 5; margin-right: 3px!important;">l</span>
                      <span class="label-char letra" style="--index: 5">A</span>
                      <span class="label-char letra" style="--index: 6">l</span>
                      <span class="label-char letra" style="--index: 6">i</span>
                      <span class="label-char letra" style="--index: 7">m</span>
                      <span class="label-char letra" style="--index: 7">e</span>
                      <span class="label-char letra" style="--index: 8">n</span>
                      <span class="label-char letra" style="--index: 8">t</span>
                      <span class="label-char letra" style="--index: 8">o</span>
                     
                    
                    </label>
                    <p  class=" text-center l er error1"  ></p>
   
            </div>

        </div>
                                   
     </div>
                          
 </form>
                         
                          
                        </div>
                        </div>
                    </div>

                     <div class="col-md-8">
                    <div class="card shadow" data-aos="fade-up" data-aos-delay="700">
                        <div class="card-body">
                       
                              <form class="formu form1 ">
                                <div class="form-card text-start pt-2 mb-4">
                                   <div class="mb-5 d-none" align="end">
                                      <div class="row">
                                        <div class="col-10">
                                          <span>Escanear Código</span>
                                        </div>
                                        
                                        <div class="checkbox col-1">
                                             <input id="cbx" type="checkbox" />
                                             <label class="toggle" for="cbx"><span></span></label>
                                         </div>

                                    </div>
                                  </div>
                                   
                                    
                                    <div class="row container">
                                       <div class="wave-group p-2 col-md-6 my-2 " id="sel" style="margin-top: 1.7vw!important">

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
                      <span class="label-char letra2" style="--index: 0">T</span>
                      <span class="label-char letra2" style="--index: 1">i</span>
                      <span class="label-char letra2" style="--index: 2">p</span>
                      <span class="label-char letra2" style="--index: 3; margin-right: 3px!important;">o</span>
                      <span class="label-char letra2" style="--index: 3">D</span>
                      <span class="label-char letra2" style="--index: 4; margin-right: 3px!important;">e</span>
                       <span class="label-char letra2" style="--index: 4">A</span>
                      <span class="label-char letra2" style="--index: 5">l</span>
                      <span class="label-char letra2" style="--index: 5">i</span>
                       <span class="label-char letra2" style="--index: 6">m</span>
                        <span class="label-char letra2" style="--index: 6">e</span>
                        <span class="label-char letra2" style="--index: 7">n</span>
                        <span class="label-char letra2" style="--index: 7">t</span>
                        <span class="label-char letra2" style="--index: 7">o</span>
                     
                     
                     
                    </label>
                    <p  class=" text-center l er error2"  ></p>
   
            </div>
                                        <div class="wave-group p-2 col-md-6 my-2">
                <input required="" type="text" class="input alimento" id="alimento">
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
                      <span class="label-char letra3" style="--index: 0">A</span>
                      <span class="label-char letra3" style="--index: 1">l</span>
                      <span class="label-char letra3" style="--index: 2">i</span>
                      <span class="label-char letra3" style="--index: 3">m</span>
                      <span class="label-char letra3" style="--index: 4">e</span>
                      <span class="label-char letra3" style="--index: 5">n</span>
                      <span class="label-char letra3" style="--index: 6">t</span>
                      <span class="label-char letra3" style="--index: 7">o</span>
                     
                     
                    </label>
                    <p  class=" text-center l er error3"  ></p>
   
            </div>

           

                 <div class="wave-group p-2 col-md-6 my-2">
                   <div>
              
                <input class="form-check-input check" type="checkbox" id="acMarca" style="margin-top: -0.6vw!important" >
                  <label class="label labelPri ic4" style="margin-left: 2vw!important; margin-top: -1.2vw!important;">
                         
                        <span class="label-char pl-2 letra4" style="--index: 0; margin-right: 3px!important;"> <i class=" ri-article-fill" >
                                                        
                         </i> </span>
                      <span class="label-char letra4" style="--index: 0">M</span>
                      <span class="label-char letra4" style="--index: 1">a</span>
                      <span class="label-char letra4" style="--index: 2">r</span>
                      <span class="label-char letra4" style="--index: 3">c</span>
                      <span class="label-char letra4" style="--index: 4">a</span>
                     
                     
                     
                    </label>
            </div>
                <input required="" type="text" class="input" id="marca" style="margin-top: -2vw!important;">
                    <span class="bar bar4"></span>

                    <p  class=" text-center l er error4"  ></p>
   
            </div>
                 <div class="wave-group p-2 col-md-6 my-2" id="sel2" style="margin-top: 1.7vw!important">
                 <select class="input " id="unidad">
                  <option value='Seleccionar'> Seleccionar</option>
                   <option value='Kl'> Kilogramo (Kl)</option>
                   <option value='Gr'> Gramo (Gr)</option>
                   <option value='Lt'> Litro (Lt)</option>
                   <option value='Ml'> Mililitro (Ml)</option>
                   <option value='Unidad'> Unidad (U)</option>
                </select>
                    <span class="bar bar5"></span>
                    <label class="label labelPri ic5">
                        <span class="label-char pl-2 letra5" style="--index: 0; margin-right: 3px!important;"> <i class=" " >
                           <svg class='icon-24' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M384 32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 128c-17.7 0-32-14.3-32-32s14.3-32 32-32H288V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32zm55.6 288H584.4L512 195.8 439.6 320zM512 416c-62.9 0-115.2-34-126-78.9c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C627.2 382 574.9 416 512 416zM126.8 195.8L54.4 320H199.3L126.8 195.8zM.9 337.1c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C242 382 189.7 416 126.8 416S11.7 382 .9 337.1z"/></svg>                            
                         </i> </span>
                      <span class="label-char letra5" style="--index: 0">U</span>
                      <span class="label-char letra5" style="--index: 1">n</span>
                      <span class="label-char letra5" style="--index: 2">i</span>
                      <span class="label-char letra5" style="--index: 3">d</span>
                      <span class="label-char letra5" style="--index: 4">a</span>
                      <span class="label-char letra5" style="--index: 5; margin-right: 3px!important;">d</span>
                      <span class="label-char letra5" style="--index: 5">d</span>
                      <span class="label-char letra5" style="--index: 5; margin-right: 3px!important;">e</span>
                      <span class="label-char letra5" style="--index: 5">M</span>
                      <span class="label-char letra5" style="--index: 5">e</span>
                      <span class="label-char letra5" style="--index: 5">d</span>
                      <span class="label-char letra5" style="--index: 5">i</span>
                      <span class="label-char letra5" style="--index: 5">d</span>
                      <span class="label-char letra5" style="--index: 5">a</span>
                     
                    </label>
                    <p  class=" text-center l er error5"  ></p>
   
            </div>



           

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
     <?php $components->componentsJS(); ?>
     <script src="assets/js/alimentos/alimentos.js"></script> 
      <script src="assets/js/close.js"></script>
  </body>
</html>