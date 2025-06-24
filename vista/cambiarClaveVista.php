<!doctype html>
<html lang="es" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nueva Contraseña | Servicio Nutricional UPTAEB</title>

  <?php $components->componentsHeader(); ?>
  <script src="assets/js/close.js"></script>
  <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
<!-- Loader Start -->
<div id="loading">
  <div class="loader simple-loader">
    <div class="loader-body"></div>
  </div>
</div>
<!-- Loader End -->

<?php $sidebar->sidebar(); ?>

<main class="main-content">
  <!-- Nav Start -->
  <?php $navegador->navegador(); ?>

  <div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 215px;">
      <div class="container-fluid iq-container">
        <div class="row">
          <div class="col-md-12">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
              <div class="col-md-7">
                <h1 class="fw-bold blanco">Nueva Contraseña</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="iq-header-img">
        <img src="assets/images/dashboard/header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
      </div>
    </div>

    <div class="content-inner mt-n5 py-0">
      <div class="col-sm-12">
        <div class="card" data-aos="fade-up" data-aos-delay="700">
          <div class="card-header"></div>
          <div class="card-body row">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <h2 class="text-center mb-4">Restablecer Contraseña</h2>

                <form id="formNuevaContrasena">
                  <div class="form-group mb-3">
                    <input type="password" class="form-control" name="nuevaContrasena" id="nuevaContrasena" placeholder="Nueva contraseña" required>
                  </div>
                  <div class="form-group mb-3">
                    <input type="password" class="form-control" name="confirmarContrasena" id="confirmarContrasena" placeholder="Confirmar contraseña" required>
                  </div>
                  <input type="hidden" id="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php $footer->footer(); ?>
    </div>
  </div>
</main>

<?php $configuracion->configuracion(); ?>
<?php $components->componentsJS(); ?>
<script src="assets/js/cambiarClave.js"></script>
</body>
</html>
