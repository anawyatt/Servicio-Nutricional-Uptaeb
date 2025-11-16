<?php 

	namespace component;
	class generadorMenu{

    private $permisos;

    public function __construct($permisos){
      $this->permisos = $permisos;
    }

		public function generadorMenu(){

       $boton = (isset($this->permisos['Menú']["registrar"])) ? '
       
       <a class="btn btn-fixed-end2 btn-info btn-icon btn-setting" role="button" data-bs-toggle="modal" data-bs-target="#generarMenu" title="Generar Menu">
       <svg width="24" height="24" viewBox="0 0 612 612" class="animated-scale icon-30" version="1.1" xmlns="http://www.w3.org/2000/svg">
<g id="#007afaff">
<path fill="#ffffffff" opacity="1.00" d=" M 269.15 0.00 L 272.21 0.00 C 268.33 2.00 265.39 5.32 262.67 8.66 C 259.47 12.65 256.43 17.02 255.37 22.12 C 252.97 32.15 256.23 42.52 260.76 51.45 C 265.97 60.74 271.36 69.92 276.90 79.01 C 280.99 85.89 282.36 94.71 279.32 102.24 C 277.80 105.54 275.74 109.29 272.01 110.37 C 276.47 105.88 278.13 99.04 275.77 93.09 C 269.46 77.34 257.26 64.72 251.20 48.83 C 247.96 40.48 246.30 30.99 249.32 22.33 C 252.63 12.08 261.27 4.36 270.87 0.01 L 269.15 0.00 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 311.22 0.00 L 314.35 0.00 C 312.34 0.59 310.65 1.88 309.13 3.28 C 302.53 9.97 296.30 18.19 296.22 28.02 C 295.76 42.19 304.02 54.35 310.86 66.06 C 315.65 74.90 323.19 83.29 322.54 94.01 C 322.94 100.99 318.99 107.59 313.38 111.51 C 314.82 108.24 317.76 105.67 318.26 102.00 C 319.13 97.14 317.31 92.28 315.26 87.95 C 310.01 77.75 302.93 68.63 297.47 58.55 C 292.46 49.28 288.33 38.82 289.74 28.10 C 291.02 15.34 301.22 5.30 312.31 0.02 L 311.22 0.00 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 353.20 0.00 L 353.95 0.00 C 348.18 4.92 342.97 10.77 339.75 17.69 C 336.24 25.18 336.98 33.91 339.46 41.59 C 343.00 52.45 349.75 61.81 355.27 71.69 C 359.45 78.48 364.37 85.65 363.76 94.03 C 363.61 100.31 361.07 108.12 354.66 110.41 C 356.26 108.43 358.33 106.62 358.89 104.02 C 361.03 97.19 357.75 90.32 354.56 84.41 C 348.40 73.98 341.13 64.18 335.89 53.22 C 331.44 43.90 328.89 32.99 331.91 22.84 C 335.17 12.52 343.79 4.81 353.20 0.00 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 285.93 138.95 C 292.63 130.84 304.44 128.91 314.18 131.72 C 319.60 133.21 324.90 136.68 327.13 142.00 C 328.03 145.07 325.04 147.19 323.23 149.17 C 319.52 152.62 318.15 157.71 317.40 162.55 C 309.68 162.13 301.92 162.02 294.22 162.61 C 293.33 156.64 290.81 150.78 286.09 146.85 C 283.64 144.94 283.80 141.03 285.93 138.95 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 236.93 178.82 C 267.58 166.62 301.51 162.85 334.12 167.86 C 369.28 173.16 402.74 189.03 429.19 212.78 C 449.74 231.09 466.14 254.05 476.72 279.46 C 477.37 280.79 477.59 282.26 477.36 283.73 C 477.70 283.60 478.39 283.34 478.73 283.20 C 485.24 302.59 490.30 322.66 490.84 343.20 C 483.58 343.31 476.32 343.22 469.06 343.25 C 468.01 319.82 462.01 296.58 451.24 275.73 C 429.17 232.23 386.72 199.49 338.76 190.07 C 366.25 199.95 391.90 215.66 411.83 237.14 C 429.02 255.67 441.52 278.47 447.92 302.92 C 451.42 316.01 452.81 329.53 453.96 343.00 C 433.97 343.49 413.97 343.16 393.97 343.25 C 302.94 343.25 211.90 343.25 120.86 343.26 C 121.67 309.06 133.12 275.41 152.23 247.14 C 172.72 216.51 202.80 192.59 236.93 178.82 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 47.32 351.25 C 50.48 349.01 54.44 349.80 58.04 349.76 C 102.69 349.76 147.34 349.76 191.99 349.76 C 234.98 349.31 277.98 349.60 320.98 349.52 C 364.31 350.00 407.65 349.66 450.98 349.76 C 486.98 349.75 522.98 349.78 558.98 349.74 C 561.19 349.72 563.71 350.17 565.31 351.81 C 566.24 354.31 565.72 357.12 564.59 359.48 C 560.07 361.79 554.93 361.46 550.03 361.96 C 538.01 362.91 526.00 363.89 513.99 364.86 C 507.37 365.43 500.37 366.71 495.17 371.16 C 492.89 373.11 490.08 374.72 486.98 374.50 C 368.00 374.46 249.03 374.49 130.05 374.48 C 127.37 374.39 124.62 374.80 122.00 374.14 C 118.04 372.70 115.19 369.34 111.33 367.72 C 104.61 364.81 97.15 364.89 89.98 364.27 C 77.30 363.05 64.58 362.35 51.90 361.06 C 47.20 361.13 44.20 354.75 47.32 351.25 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 193.77 382.74 C 203.40 378.27 215.63 381.50 222.45 389.47 C 232.91 400.99 238.06 415.93 245.42 429.38 C 248.36 434.07 252.51 438.04 257.26 440.88 C 262.61 443.95 269.12 444.17 275.05 443.01 C 283.70 441.30 292.03 438.33 300.20 435.07 C 313.51 429.73 326.94 424.54 339.48 417.50 C 354.66 409.10 367.87 397.60 383.02 389.15 C 392.75 384.08 403.62 379.10 414.88 380.85 C 418.71 381.68 423.61 382.64 425.25 386.73 C 426.58 389.61 426.43 393.79 423.54 395.67 C 419.10 398.71 413.69 399.65 408.88 401.90 C 393.65 408.56 381.06 419.77 369.31 431.26 C 355.55 444.18 343.05 458.35 329.54 471.52 C 315.28 485.54 298.79 496.97 282.49 508.46 C 271.02 516.58 259.10 524.09 247.50 532.00 C 247.41 532.47 247.24 533.41 247.15 533.88 C 246.72 533.73 245.87 533.41 245.44 533.26 C 233.30 541.08 221.21 549.00 209.01 556.75 C 200.69 540.25 192.02 523.92 183.68 507.43 C 181.55 503.56 179.39 499.68 177.93 495.49 C 187.31 491.04 196.80 485.42 202.40 476.38 C 206.07 470.64 206.80 463.63 206.76 456.98 C 207.12 442.57 211.26 427.68 206.52 413.58 C 203.84 405.33 196.29 400.17 192.22 392.78 C 190.15 389.61 191.17 385.25 193.77 382.74 Z" />
<path fill="#ffffffff" opacity="1.00" d=" M 112.10 525.33 C 131.64 516.23 151.38 507.53 170.94 498.45 C 178.69 513.29 186.31 528.19 193.96 543.08 C 199.82 554.87 206.38 566.31 211.86 578.28 C 195.80 587.39 180.07 597.04 164.13 606.36 C 161.08 608.01 158.17 609.92 155.39 612.00 L 155.23 612.00 C 141.31 582.88 126.34 554.29 112.10 525.33 M 177.49 573.82 C 178.59 575.25 179.46 577.06 181.21 577.84 C 183.91 579.57 187.78 577.63 188.56 574.67 C 189.62 571.26 186.70 567.22 183.01 567.70 C 179.77 567.86 178.36 571.17 177.49 573.82 Z" />
</g>
</svg>
    </a>
    
<div class="modal fade" id="generarMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-azul4">
                <h5 class="modal-title title" id="staticBackdropLabel">Generar Menú</h5>
                <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form method="POST" class="p-2" id="modificarM">
                <div class="modal-body mb-2">
                     <input type="hidden" name="csrf_token"  value="<?php echo htmlspecialchars($tokenCsrf); ?>">
                    <!-- Sección de horarios -->
                    <div class="wave-group p-1 col-md-12 my-1" id="tablita22">
                        <div class="table-responsive table-wrapper">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th colspan="1" class="blanco fw-bold text-center">Horario de la comida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                       <td class="d-flex justify-content-between flex-wrap gap-2">
    <button type="button" class="btn btnHorario" data-value="Desayuno">
        <i class="ri-sun-foggy-line"></i> Desayuno
    </button>
    <button type="button" class="btn btnHorario" data-value="Almuerzo">
        <i class="ri-restaurant-2-line"></i> Almuerzo
    </button>
    <button type="button" class="btn btnHorario" data-value="Merienda">
        <i class="ri-cup-line"></i> Merienda
    </button>
    <button type="button" class="btn btnHorario" data-value="Cena">
        <i class="ri-moon-line"></i> Cena
    </button>
</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- input oculto -->
                        <input type="hidden" id="horarioSeleccionado" name="horarioSeleccionado">
                        <p class="text-center l er error30"></p>
                    </div>

                    <!-- Campo número de platos -->
                    <div class="wave-group p-1 col-12 my-1">
                        <input required type="number" class="input cantPlatos2 mt-2" id="cantPlatos2">
                        <span class="bar bar20"></span>
                        <label class="label labelPri ic20">
                            <span class="label-char pl-2 letra20" style="--index: 0; margin-right: 3px!important;">
                                <i class="ri-restaurant-2-line"></i>
                            </span>
                            <span class="label-char letra20" style="--index: 0">N° de Platos</span>
                        </label>
                        <p class="text-center l er error20"></p>
                    </div>




                </div>
            </form>
          <div class="modal-footer d-flex justify-content-center">
    <div> 
        <button id="generar" type="button" class="btn btn-primary">Generar Menú</button>
    </div>
</div>
        </div>
    </div>
</div>


<div class="modal fade" id="sugerenciasMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="sugerenciasMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-azul4">
                <h5 class="modal-title title" id="sugerenciasMenuLabel">Generar Menú</h5>
                <button type="button" id="cerrar2" class="btn-close resetear" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h4 id="menuHorario">Menú para **[Horario Seleccionado]**</h4> 
                <p>Número de Platos solicitados: <strong id="menuPlatos">N</strong></p> 
                <hr>

                <div class="accordion" id="listaSugerencias">

                    <div class="accordion-item shadow-sm mb-3 rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-azul7 azul4 fw-bold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Cargando Opciones de Menú...
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#listaSugerencias">
                            <div class="accordion-body">
                                <p>Generando sugerencias basado en sus reglas y preferencias.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer d-flex">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    
    ' : '';

	

     	echo $boton;

		}
	}



 ?>