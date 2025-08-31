<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Horario de Comida | Servicio Nutricional UPTAEB</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <?php $components->componentsHeader(); ?>
</head>

<body>

    <div class="container  d-md-block" id="container">

        <div class="form-container sign-in " align="center">
            <form>
                <h1 class='mb-2'>Horario de Comida</h1>
                <span class='mb-2 text-center'>Seleccione el Horario de Comida que desea para ingresar al sistema.</span>
                <div class="wave-group p-2  my-2 mt-3 col-12" id="sel1">
                    <select class="input horario mt-2" id="horario">
                        <option value="Seleccionar">Seleccionar</option>
                        <option value="Desayuno">Desayuno</option>
                        <option value="Almuerzo">Almuerzo</option>
                        <option value="Merienda">Merienda</option>
                        <option value="Cena">Cena</option>
                    </select>
                    
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1 mb-2">
                        <span class="label-char pl-2 letra1" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 16.8701V9.25708H21V16.9311C21 20.0701 19.0241 22.0001 15.8628 22.0001H8.12733C4.99561 22.0001 3 20.0301 3 16.8701ZM7.95938 14.4101C7.50494 14.4311 7.12953 14.0701 7.10977 13.6111C7.10977 13.1511 7.46542 12.7711 7.91987 12.7501C8.36443 12.7501 8.72997 13.1011 8.73985 13.5501C8.7596 14.0111 8.40395 14.3911 7.95938 14.4101ZM12.0198 14.4101C11.5653 14.4311 11.1899 14.0701 11.1701 13.6111C11.1701 13.1511 11.5258 12.7711 11.9802 12.7501C12.4248 12.7501 12.7903 13.1011 12.8002 13.5501C12.82 14.0111 12.4643 14.3911 12.0198 14.4101ZM16.0505 18.0901C15.596 18.0801 15.2305 17.7001 15.2305 17.2401C15.2206 16.7801 15.5862 16.4011 16.0406 16.3911H16.0505C16.5148 16.3911 16.8902 16.7711 16.8902 17.2401C16.8902 17.7101 16.5148 18.0901 16.0505 18.0901ZM11.1701 17.2401C11.1899 17.7001 11.5653 18.0611 12.0198 18.0401C12.4643 18.0211 12.82 17.6411 12.8002 17.1811C12.7903 16.7311 12.4248 16.3801 11.9802 16.3801C11.5258 16.4011 11.1701 16.7801 11.1701 17.2401ZM7.09989 17.2401C7.11965 17.7001 7.49506 18.0611 7.94951 18.0401C8.39407 18.0211 8.74973 17.6411 8.72997 17.1811C8.72009 16.7311 8.35456 16.3801 7.90999 16.3801C7.45554 16.4011 7.09989 16.7801 7.09989 17.2401ZM15.2404 13.6011C15.2404 13.1411 15.596 12.7711 16.0505 12.7611C16.4951 12.7611 16.8507 13.1201 16.8705 13.5611C16.8804 14.0211 16.5247 14.4011 16.0801 14.4101C15.6257 14.4201 15.2503 14.0701 15.2404 13.6111V13.6011Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M3.00293 9.25699C3.01577 8.66999 3.06517 7.50499 3.15803 7.12999C3.63224 5.02099 5.24256 3.68099 7.54442 3.48999H16.4555C18.7376 3.69099 20.3677 5.03999 20.8419 7.12999C20.9338 7.49499 20.9832 8.66899 20.996 9.25699H3.00293Z" fill="currentColor"></path>
                                    <path d="M8.30465 6.59C8.73934 6.59 9.06535 6.261 9.06535 5.82V2.771C9.06535 2.33 8.73934 2 8.30465 2C7.86996 2 7.54395 2.33 7.54395 2.771V5.82C7.54395 6.261 7.86996 6.59 8.30465 6.59Z" fill="currentColor"></path>
                                    <path d="M15.6953 6.59C16.1201 6.59 16.456 6.261 16.456 5.82V2.771C16.456 2.33 16.1201 2 15.6953 2C15.2606 2 14.9346 2.33 14.9346 2.771V5.82C14.9346 6.261 15.2606 6.59 15.6953 6.59Z" fill="currentColor"></path>
                                </svg>
                            </i> </span>
                        <span class="label-char letra1" style="--index: 0">H</span>
                        <span class="label-char letra1" style="--index: 1">o</span>
                        <span class="label-char letra1" style="--index: 2">r</span>
                        <span class="label-char letra1" style="--index: 3">a</span>
                        <span class="label-char letra1" style="--index: 4">r</span>
                        <span class="label-char letra1" style="--index: 5">i</span>
                        <span class="label-char letra1" style="--index: 6">o</span>

                    </label>
                    <p class=" text-center l er error1"></p>

                </div>
                <button type="button" class="btn btn-primary" id="registrar">Ingresar</button>
            </form>
        </div>
        <div class="toggle-container d-none d-sm-block ">
            <div class="toggle">

                <div class="toggle-panel toggle-right">
                    <div align='center'>
                        <img src="assets/images/logos/logo2.png" class='' alt="" align='center' width='200' height='150'>
                    </div>
                    <h1 class="blanco">Bienvenido</h1>
                    <p class="blanco">Sistema Servicio Nutricional</p>
                    <h4 class="blanco">UPTAEB</h4>
                    <?php echo '
                    <a class=" mt-5" href="?url=' . $sistem->encryptURL('login') . '">
                        <span class="box blanco">
                      <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M16.084 2L7.916 2C4.377 2 2 4.276 2 7.665L2 16.335C2 19.724 4.377 22 7.916 22L16.084 22C19.622 22 22 19.723 22 16.334L22 7.665C22 4.276 19.622 2 16.084 2Z" fill="currentColor"></path>                                <path d="M11.1445 7.72082L7.37954 11.4688C7.09654 11.7508 7.09654 12.2498 7.37954 12.5328L11.1445 16.2808C11.4385 16.5728 11.9135 16.5718 12.2055 16.2778C12.4975 15.9838 12.4975 15.5098 12.2035 15.2168L9.72654 12.7498H16.0815C16.4965 12.7498 16.8315 12.4138 16.8315 11.9998C16.8315 11.5858 16.4965 11.2498 16.0815 11.2498L9.72654 11.2498L12.2035 8.78382C12.3505 8.63682 12.4235 8.44482 12.4235 8.25182C12.4235 8.06082 12.3505 7.86882 12.2055 7.72282C11.9135 7.42982 11.4385 7.42882 11.1445 7.72082Z" fill="currentColor"></path>                                </svg>                            
                            Volver a Iniciar Sesión
                        </span>
                    </a>';
                    ?>


                </div>
            </div>
        </div>
    </div>



    <?php $components->componentsJS(); ?>
    <script src="assets/js/horario/horario.js"></script>



</body>

</html>