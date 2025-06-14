<!DOCTYPE html>
<html>
<head>
	<title>Inactividad | Servicio Nutricional UPTAEB</title>
</head>
<body class='bg-imagen img-fluid gradient-main'>

<div class="container">
    <section class="section min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <!-- Contenido de la sección -->
          <?php  echo '
        <h1 class="text-white mb-4 text-center">Sesión Inactiva</h1>
        <h4 class="text-white mb-4 text-center"> '.$_SESSION['nombre'].' '.$_SESSION['apellido'].' tu cuenta se cerró por inactividad!</h4>
    <a class="btn btn-primary fw-bold text-center mb-5" href="?url='. urlencode($sistem->encryptURL('cerrar')).'">Volver</a>';?>
    </section>
</div>

<style>
    .bg-cardi{
        background: #05727350!important;
    }
    .bg-imagen{
        background-image: url("assets/images/dashboard/inactividad.png");
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 100%;
        display: flex;
        flex-flow: column nowrap;
    }
</style>

</body>

</html>

