<!doctype html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restablecer Contraseña | Servicio Nutricional UPTAEB</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
    <script>
        window.userCedulaGlobal = "<?php echo $payload->cedula ?>";
    </script>
    <?php $components->componentsHeader(); ?>
</head>

<body>

    <div class="container  d-md-block" id="container">
        <div class="form-container sign-in " align="center">
            <form id="formnuevaClave">
                <div align='center' class='mb-2 d-block d-md-none'>
                    <img src="assets/images/logos/logo.png" class='' alt="" align='center' width='150' height='100'>
                </div>
                <h1 class='mb-2'>Restablecer Contraseña</h1>
                
                <span class='mb-2 text-center'> Introduce el código recibido y tu nueva contraseña.</span>
                  <div class="wave-group col-11 mt-4 mb-4">

                    <input required="" type="codigo" class="input codigo" name="codigo" id="codigo"  autocomplete="off">
                    <span class="bar bar1"></span>
                    <label class="label labelPri ic1">
                        <span class="label-char pl-2 letra" style="--index: 0; margin-right: 3px!important;"> <i class=" ">
                                <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                                </svg>
                            </i> </span>
                        <span class="label-char letra" style="--index: 0">Codigo</span>

                    </label>
                    <p class=" text-center l er error1"></p>
                </div>

                <div class="wave-group col-11  mb-4 row">
                    <div class="col-11">
                        <input required="" type="password" class="input clave1" name="nuevaClave" id="nuevaClave" autocomplete="off">
                        <span class="bar bar2"></span>
                        <label class="label labelPri ic2">
                            <span class="label-char pl-2 letra2" style="--index: 0; margin-right: 3px!important;"> <i>
                                    <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.7688 8.71387H16.2312C18.5886 8.71387 20.5 10.5831 20.5 12.8885V17.8254C20.5 20.1308 18.5886 22 16.2312 22H7.7688C5.41136 22 3.5 20.1308 3.5 17.8254V12.8885C3.5 10.5831 5.41136 8.71387 7.7688 8.71387ZM11.9949 17.3295C12.4928 17.3295 12.8891 16.9419 12.8891 16.455V14.2489C12.8891 13.772 12.4928 13.3844 11.9949 13.3844C11.5072 13.3844 11.1109 13.772 11.1109 14.2489V16.455C11.1109 16.9419 11.5072 17.3295 11.9949 17.3295Z" fill="currentColor"></path>
                                        <path opacity="0.4" d="M17.523 7.39595V8.86667C17.1673 8.7673 16.7913 8.71761 16.4052 8.71761H15.7447V7.39595C15.7447 5.37868 14.0681 3.73903 12.0053 3.73903C9.94257 3.73903 8.26594 5.36874 8.25578 7.37608V8.71761H7.60545C7.20916 8.71761 6.83319 8.7673 6.47754 8.87661V7.39595C6.4877 4.41476 8.95692 2 11.985 2C15.0537 2 17.523 4.41476 17.523 7.39595Z" fill="currentColor"></path>
                                    </svg>
                                </i></span>
                            <span class="label-char letra2" style="--index: 0">Nueva Contraseña</span>


                        </label>
                        <p class=" text-center l er error2"></p>
                    </div>

                    <div class="col-1" style="margin-left: -25px!important; margin-top:12px!important;" id="eye1"><i class="labelPri ojo">
                            <svg class="icon-24 eyeSi d-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"></path>
                                <path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"></path>
                            </svg>
                            <svg class="icon-24 eyeNo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M11.9902 3.88184H12C13.3951 3.88184 14.7512 4.21657 16 4.84567L12.7415 8.13491C12.5073 8.09553 12.2537 8.066 12 8.066C9.8439 8.066 8.09756 9.82827 8.09756 12.004C8.09756 12.26 8.12683 12.516 8.16585 12.7523L4.5561 16.3949C3.58049 15.2529 2.73171 13.8736 2.05854 12.2895C1.98049 12.1123 1.98049 11.8957 2.05854 11.7087C4.14634 6.80583 7.86341 3.88184 11.9902 3.88184ZM18.4293 6.54985C19.8439 7.8494 21.0439 9.60183 21.9415 11.7087C22.0195 11.8957 22.0195 12.1123 21.9415 12.2895C19.8537 17.1924 16.1366 20.1262 12 20.1262H11.9902C10.1073 20.1262 8.30244 19.506 6.71219 18.3738L9.80488 15.2529C10.4293 15.6753 11.1902 15.9322 12 15.9322C14.1463 15.9322 15.8927 14.1699 15.8927 12.004C15.8927 11.1869 15.639 10.419 15.2195 9.78889L18.4293 6.54985Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4296 6.54952L20.2052 4.75771C20.4979 4.4722 20.4979 3.99964 20.2052 3.71413C19.9223 3.42862 19.4637 3.42862 19.1711 3.71413L18.254 4.63957C18.2442 4.65926 18.2247 4.67895 18.2052 4.69864C18.1954 4.71833 18.1759 4.73802 18.1564 4.75771L17.2881 5.63491L14.1954 8.7558L3.72715 19.3186L3.69789 19.358C3.50276 19.6435 3.54179 20.0383 3.78569 20.2844C3.92228 20.4311 4.1174 20.5 4.30276 20.5C4.48813 20.5 4.6735 20.4311 4.81984 20.2844L15.2198 9.78855L18.4296 6.54952ZM12.0004 14.4555C13.337 14.4555 14.4297 13.3529 14.4297 12.0041C14.4297 11.5906 14.3321 11.1968 14.1565 10.8621L10.8687 14.1798C11.2004 14.3571 11.5907 14.4555 12.0004 14.4555Z" fill="currentColor"></path>
                            </svg>
                        </i>
                    </div>
                </div>

                                <div class="wave-group col-11  mb-4 row">
                    <div class="col-11">
                        <input required="" type="password" class="input clave2" name="confirmarClave" id="confirmarClave" autocomplete="off">
                        <span class="bar bar3"></span>
                        <label class="label labelPri ic3">
                            <span class="label-char pl-2 letra3" style="--index: 0; margin-right: 3px!important;"> <i>
                                    <svg class="icon-24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.7688 8.71387H16.2312C18.5886 8.71387 20.5 10.5831 20.5 12.8885V17.8254C20.5 20.1308 18.5886 22 16.2312 22H7.7688C5.41136 22 3.5 20.1308 3.5 17.8254V12.8885C3.5 10.5831 5.41136 8.71387 7.7688 8.71387ZM11.9949 17.3295C12.4928 17.3295 12.8891 16.9419 12.8891 16.455V14.2489C12.8891 13.772 12.4928 13.3844 11.9949 13.3844C11.5072 13.3844 11.1109 13.772 11.1109 14.2489V16.455C11.1109 16.9419 11.5072 17.3295 11.9949 17.3295Z" fill="currentColor"></path>
                                        <path opacity="0.4" d="M17.523 7.39595V8.86667C17.1673 8.7673 16.7913 8.71761 16.4052 8.71761H15.7447V7.39595C15.7447 5.37868 14.0681 3.73903 12.0053 3.73903C9.94257 3.73903 8.26594 5.36874 8.25578 7.37608V8.71761H7.60545C7.20916 8.71761 6.83319 8.7673 6.47754 8.87661V7.39595C6.4877 4.41476 8.95692 2 11.985 2C15.0537 2 17.523 4.41476 17.523 7.39595Z" fill="currentColor"></path>
                                    </svg>
                                </i></span>
                            <span class="label-char letra3" style="--index: 0">Confirmar Contraseña</span>

                        </label>
                        <p class=" text-center l er error3"></p>
                    </div>

                    <div class="col-1" style="margin-left: -25px!important; margin-top:12px!important;" id="eye2"><i class="labelPri ojo">
                            <svg class="icon-24 eyeSi d-none" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M17.7366 6.04606C19.4439 7.36388 20.8976 9.29455 21.9415 11.7091C22.0195 11.8924 22.0195 12.1067 21.9415 12.2812C19.8537 17.1103 16.1366 20 12 20H11.9902C7.86341 20 4.14634 17.1103 2.05854 12.2812C1.98049 12.1067 1.98049 11.8924 2.05854 11.7091C4.14634 6.87903 7.86341 4 11.9902 4H12C14.0683 4 16.0293 4.71758 17.7366 6.04606ZM8.09756 12C8.09756 14.1333 9.8439 15.8691 12 15.8691C14.1463 15.8691 15.8927 14.1333 15.8927 12C15.8927 9.85697 14.1463 8.12121 12 8.12121C9.8439 8.12121 8.09756 9.85697 8.09756 12Z" fill="currentColor"></path>
                                <path d="M14.4308 11.997C14.4308 13.3255 13.3381 14.4115 12.0015 14.4115C10.6552 14.4115 9.5625 13.3255 9.5625 11.997C9.5625 11.8321 9.58201 11.678 9.61128 11.5228H9.66006C10.743 11.5228 11.621 10.6695 11.6601 9.60184C11.7674 9.58342 11.8845 9.57275 12.0015 9.57275C13.3381 9.57275 14.4308 10.6588 14.4308 11.997Z" fill="currentColor"></path>
                            </svg>
                            <svg class="icon-24 eyeNo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M11.9902 3.88184H12C13.3951 3.88184 14.7512 4.21657 16 4.84567L12.7415 8.13491C12.5073 8.09553 12.2537 8.066 12 8.066C9.8439 8.066 8.09756 9.82827 8.09756 12.004C8.09756 12.26 8.12683 12.516 8.16585 12.7523L4.5561 16.3949C3.58049 15.2529 2.73171 13.8736 2.05854 12.2895C1.98049 12.1123 1.98049 11.8957 2.05854 11.7087C4.14634 6.80583 7.86341 3.88184 11.9902 3.88184ZM18.4293 6.54985C19.8439 7.8494 21.0439 9.60183 21.9415 11.7087C22.0195 11.8957 22.0195 12.1123 21.9415 12.2895C19.8537 17.1924 16.1366 20.1262 12 20.1262H11.9902C10.1073 20.1262 8.30244 19.506 6.71219 18.3738L9.80488 15.2529C10.4293 15.6753 11.1902 15.9322 12 15.9322C14.1463 15.9322 15.8927 14.1699 15.8927 12.004C15.8927 11.1869 15.639 10.419 15.2195 9.78889L18.4293 6.54985Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4296 6.54952L20.2052 4.75771C20.4979 4.4722 20.4979 3.99964 20.2052 3.71413C19.9223 3.42862 19.4637 3.42862 19.1711 3.71413L18.254 4.63957C18.2442 4.65926 18.2247 4.67895 18.2052 4.69864C18.1954 4.71833 18.1759 4.73802 18.1564 4.75771L17.2881 5.63491L14.1954 8.7558L3.72715 19.3186L3.69789 19.358C3.50276 19.6435 3.54179 20.0383 3.78569 20.2844C3.92228 20.4311 4.1174 20.5 4.30276 20.5C4.48813 20.5 4.6735 20.4311 4.81984 20.2844L15.2198 9.78855L18.4296 6.54952ZM12.0004 14.4555C13.337 14.4555 14.4297 13.3529 14.4297 12.0041C14.4297 11.5906 14.3321 11.1968 14.1565 10.8621L10.8687 14.1798C11.2004 14.3571 11.5907 14.4555 12.0004 14.4555Z" fill="currentColor"></path>
                            </svg>
                        </i>
                    </div>
                </div>

                <input type="hidden" id="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                <button type="submit" class="button2">Actualizar contraseña</button>
            </form>
        </div>
        <div class="toggle-container d-none d-md-block ">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <div align='center'>
                        <img src="assets/images/logos/logo2.png" class='' alt="" align='center' width='200' height='150'>
                    </div>
                    <h1 class="blanco">Bienvenido</h1>
                    <p class="blanco text-center">Sistema Servicio Nutricional</p>
                    <h4 class="blanco">UPTAEB</h4>
                    <a class="button3 mt-5" id="login">
                        <span class="box2 blanco">
                            Iniciar Sesión
                        </span>
                    </a>
                </div>
                <div class="toggle-panel toggle-right">
                    <div align='center'>
                        <img src="assets/images/logos/logo2.png" class='' alt="" align='center' width='200' height='150'>
                    </div>
                    <h1 class="blanco">Bienvenido</h1>
                    <p class="blanco">Sistema Servicio Nutricional</p>
                    <h4 class="blanco">UPTAEB</h4>

                </div>
            </div>
        </div>
    </div>


<?php $components->componentsJS(); ?>
<script src="assets/js/login/cambiarClave.js"></script>
</body>
</html>