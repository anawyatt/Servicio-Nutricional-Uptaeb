
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title> Ayuda | Servicio Nutricional UPTAEB</title>
       <?php $components->componentsHeader(); ?>
       <script src="assets/js/close.js"></script>
       <link rel="stylesheet" href="assets/css/estilo.css"/>

      
       <?php $components->componentsHeader(); ?>
      
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
      <div class="position-relative iq-banner">
              <!-- /////// HEADER //////// -->
          <div class="iq-navbar-header " style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div class=" col-md-7">
                                  <h1 class="fw-bold blanco">Centro de Ayuda</h1>
                                  <nav>
                            
                                     <ol class="breadcrumb">
                                     <?php 
                                    if(isset($permisos['Home']['consultar']) ){
                                      echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('home')).'">Inicio</a></li>';
                                    }
                                      echo '
                                      <li class="breadcrumb-item fw-bold"><a href="?url='.urlencode($sistem->encryptURL('perfil')).'">Perfil</a></li>';
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

          
    
      <div class=" content-inner mt-n5 py-0">
      <div class="col-sm-12">
         <div class="card" data-aos="fade-up" data-aos-delay="700">
            <div class="card-header"></div>
            <div class="card-body row">
                
            <div class="row justify-content-center ">
            <div class="col-md-10 mb-3 ">
                <label class="form-label icon"></label>
                <div class="input-group">
                    <span class="input-group-text bg-azul4"><i class="bi bi-search ii"></i></span>
                    <input type="search" id="buscar" name="buscar" class="buscador form-control" placeholder="Buscar">
                </div>
            </div>
            
    <div>
        <div class="container my-4 ">
            <div class="row g-3">
                <div class="container mt-2">
                    <div class="row cards">

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modaTipolUtensilios">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-tools fs-1 azul10"></i> <!-- Icono de utensilios -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Tipo Utensilio</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo para gestionar los diferentes tipos de utensilios disponibles en el comedor.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modaTipoAlimentos">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-egg-fried fs-1 azul10"></i> <!-- Icono de alimentos -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Tipo Alimentos</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo para la clasificación y gestión de los diferentes tipos de alimentos en el sistema.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modaTipoSalidas">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                <i class="bi bi-box-arrow-right fs-1 azul10"></i> <!-- Icono representando salidas o descartes -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Tipos de Salidas</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo para la clasificación de los tipos de salidas de alimentos o utensilios del sistema.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tarjeta 1: Estudiantes -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal1">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-person-fill fs-1 azul10"></i> <!-- Icono de estudiante -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Estudiantes</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del ingreso del ingreso de información estudiantil.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 2: Asistencias -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal2">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-calendar-check-fill fs-1 azul10"></i> <!-- Icono de asistencias -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Asistencias</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del registro y consulta de las asistencias.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 3: Menú -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal3">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-list-ul fs-1 azul10"></i> <!-- Icono de menú -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Menú</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del registro y consulta de los menú del comedor.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 4: Eventos -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal4">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-calendar-event-fill fs-1 azul10"></i> <!-- Icono de eventos -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Eventos</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del registro y consulta de los eventos.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 5: Alimentos -->
                                <div class="col-md-4 mb-4 ">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal5">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-egg-fill fs-1 azul10"></i> <!-- Icono de alimentos (huevo) -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Alimentos</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del registro y consulta de los alimentos.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 7: Inventario de Alimentos -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal7">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-basket-fill fs-1 azul10"></i> <!-- Icono de inventario de alimentos -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Inventario de Alimentos</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado de la administración de los alimentos en el inventario.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modalUtensilios">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-scissors fs-1 azul10"></i> <!-- Icono de cuchara y tenedor -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Utensilios</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado del registro y consulta de los utensilios.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tarjeta 6: Inventario de Utensilios -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal6">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-basket fs-1 azul10"></i> <!-- Icono de utensilios de cocina -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Inventario de Utensilios</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado de la administración de los utensilios del comedor.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            

                                <!-- Tarjeta 8: Reportes Estadísticos -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm cardiA" data-bs-toggle="modal" data-bs-target="#modal8">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <i class="bi bi-bar-chart-fill fs-1 azul10"></i> <!-- Icono de reportes -->
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="card-title azul10">Reportes Estadísticos</h5>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <p class="card-text fs-6">Módulo encargado de consultar las estadísticas del sistema.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div id="contenedor-items" class="mt-4 d-flex flex-column align-items-center">
                        <div class="item card mb-4" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6 class="card-title">¿Cómo consulto el stock de utensilios almacenados?</h6>
                                <p class="card-text" style="text-align: justify;">
                                    Para consultar el stock, puedes acceder a la opción "Stock Utensilios", donde verás una lista completa de los utensilios almacenados, con detalles como la cantidad disponible, cantidad apartada, material, imagen y conteo total de cada utensilio.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-4" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6 class="card-title">¿Cómo registro nuevos alimentos en el sistema?</h6>
                                <p class="card-text" style="text-align: justify;">
                                    Para registrar nuevos alimentos, dirígete a la sección "Registrar Alimentos", completa los campos con la información solicitada, como el nombre, tipo de alimento, fecha de ingreso y cantidad.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-4" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6 class="card-title">¿Qué tipos de salidas de alimentos se pueden registrar?</h6>
                                <p class="card-text" style="text-align: justify;">
                                    En el sistema, puedes registrar salidas de alimentos por motivos como descomposición, uso en eventos especiales o donaciones a terceros.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registra la asistencia de un estudiante?</h6>
                                <p style="text-align: justify;">
                                    Para registrar la asistencia, se debe ingresar la cédula del estudiante o escanear el código QR de su carnet. El sistema verificará si el estudiante está registrado y tiene acceso al servicio nutricional.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué sucede si un estudiante intenta registrarse más de una vez en el mismo horario?</h6>
                                <p style="text-align: justify;">
                                    Si un estudiante ya ha sido registrado para un horario de comida (desayuno, almuerzo, merienda o cena), no podrá registrarse de nuevo en ese mismo horario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se controla el número de platos disponibles?</h6>
                                <p style="text-align: justify;">
                                    Cada vez que un estudiante es registrado, se descuenta un plato del total de platos disponibles para el servicio de comida correspondiente.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo consultar las asistencias de días anteriores?</h6>
                                <p style="text-align: justify;">
                                    Sí, el sistema permite consultar las asistencias registradas en días anteriores y generar reportes con los datos históricos.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué pasa si un estudiante no está registrado en el sistema?</h6>
                                <p style="text-align: justify;">
                                    Si el estudiante no está registrado en el sistema, hay tres caminos, los dos primeros son las excepciones, que aparecen en los tres puntos (...) que permiten el registro de estudiantes o ingreso (que tengan justificación o la planilla de la universidad). El tercero sería que la persona no puede ingresar debido a que no tiene lo requerido.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registra un nuevo menú?</h6>
                                <p style="text-align: justify;">
                                    Para registrar un nuevo menú, primero se deben seleccionar los alimentos y las cantidades correspondientes. Luego, se elige el día, la cantidad de comensales y el horario (desayuno, almuerzo, merienda o cena). También se puede agregar una descripción para proporcionar más detalles sobre el menú.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Se puede modificar un menú registrado?</h6>
                                <p style="text-align: justify;">
                                    Sí, los menús pueden ser modificados siempre y cuando la fecha del menú no haya pasado. Una vez que el menú ha sido ejecutado o ha pasado su fecha programada, ya no es posible realizar modificaciones.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué información puedo consultar sobre los menús?</h6>
                                <p style="text-align: justify;">
                                    El sistema permite consultar los menús registrados previamente, incluyendo detalles como los alimentos seleccionados, la cantidad de comensales, el día y horario en que se ofreció el menú.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es posible ver los menús de días anteriores?</h6>
                                <p style="text-align: justify;">
                                    Sí, el sistema permite acceder a la información de los menús servidos en días anteriores, facilitando la consulta de los menús ejecutados y los alimentos utilizados.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo afecta el registro de un menú a la organización de los alimentos?</h6>
                                <p style="text-align: justify;">
                                    El registro de un menú ayuda a organizar los alimentos que serán utilizados y permite planificar la cantidad de comensales a los que se servirá, garantizando una adecuada distribución de los recursos.
                                </p>
                            </div>
                        </div>         
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registra un nuevo evento?</h6>
                                <p style="text-align: justify;">
                                    Para registrar un nuevo evento, se deben seleccionar los alimentos y las cantidades correspondientes, elegir el día y el horario del evento (desayuno, almuerzo, merienda o cena), e indicar la cantidad de personas. Además, se registra el nombre del evento y se puede agregar una descripción del menú.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es posible modificar un evento registrado?</h6>
                                <p style="text-align: justify;">
                                    Sí, es posible modificar los detalles de un evento registrado, como el menú o la cantidad de comensales, siempre que el evento aún no haya tenido lugar.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué información puedo consultar sobre los eventos registrados?</h6>
                                <p style="text-align: justify;">
                                    El sistema permite consultar todos los eventos registrados, mostrando detalles como la fecha, el menú diseñado para el evento y el número de comensales esperados.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se gestiona el menú de un evento?</h6>
                                <p style="text-align: justify;">
                                    El menú para un evento se gestiona de forma similar al registro de un menú diario, permitiendo seleccionar los alimentos y las cantidades necesarias para los comensales, además de agregar descripciones adicionales.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Se pueden consultar los eventos anteriores?</h6>
                                <p style="text-align: justify;">
                                    Sí, el sistema permite consultar los eventos anteriores, lo que facilita la revisión de los menús servidos y los detalles logísticos, como la cantidad de comensales que asistieron.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registra un nuevo alimento en el sistema?</h6>
                                <p style="text-align: justify;">
                                    Para registrar un nuevo alimento, se debe seleccionar una imagen que lo identifique (o usar una predeterminada), elegir el tipo de alimento ya registrado en el sistema, escribir el nombre del alimento, indicar la marca si corresponde, y seleccionar la unidad de medida (gramos, litros, unidades, etc.).
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es posible modificar la información de un alimento registrado?</h6>
                                <p style="text-align: justify;">
                                    Sí, se puede modificar la información de un alimento registrado, como su nombre, marca, tipo, unidad de medida o la imagen asociada, para mantener los datos actualizados y correctos en el sistema.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué sucede si un alimento ya no es necesario en el inventario?</h6>
                                <p style="text-align: justify;">
                                    Si un alimento ya no es necesario, el sistema permite eliminar su registro, asegurando que solo se mantengan activos los alimentos relevantes para la operación del servicio nutricional.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se consultan los alimentos registrados?</h6>
                                <p style="text-align: justify;">
                                    El sistema permite consultar todos los alimentos registrados, mostrando detalles como el nombre, el tipo, la marca, la unidad de medida, y la imagen del alimento. Esta información es fundamental para gestionar el inventario de manera eficiente.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Por qué es importante seleccionar la unidad de medida correcta al registrar un alimento?</h6>
                                <p style="text-align: justify;">
                                    Seleccionar la unidad de medida correcta (gramos, litros, unidades, etc.) es crucial para asegurar una correcta administración de los recursos, ya que facilita la planificación de menús, la organización de eventos y el control de inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué sucede si no tengo una imagen específica para un alimento al momento de registrarlo?</h6>
                                <p style="text-align: justify;">
                                    Si no tienes una imagen específica para un alimento, el sistema utilizará una imagen predeterminada para identificar visualmente el producto. Esto asegura que todos los alimentos estén representados de manera uniforme en el inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es obligatorio registrar la marca del alimento?</h6>
                                <p style="text-align: justify;">
                                    No es obligatorio registrar la marca del alimento, pero es recomendable incluirla si está disponible, ya que esto puede facilitar la gestión del inventario y asegurar una mejor organización de los productos.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo puedo visualizar el inventario actual de alimentos?</h6>
                                <p style="text-align: justify;">
                                    Para visualizar el inventario actual, accede a la opción "Stock Alimentos" en el módulo de inventario. Allí podrás ver una lista completa de los alimentos almacenados con detalles como la cantidad disponible, cantidad apartada, marca e imagen del producto.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué información se muestra en la lista de Stock de Alimentos?</h6>
                                <p style="text-align: justify;">
                                    La lista de Stock de Alimentos incluye información clave como la cantidad disponible de cada alimento, cantidad apartada, conteo total, la marca del producto y una imagen para identificar visualmente cada alimento.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registra la entrada de un nuevo alimento en el inventario?</h6>
                                <p style="text-align: justify;">
                                    Para registrar una entrada, selecciona el tipo de alimento, elige el alimento específico, ingresa la cantidad, registra la fecha y hora del ingreso, y proporciona una descripción del ingreso. Este proceso garantiza que los nuevos alimentos se agreguen correctamente al inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es necesario proporcionar una descripción al registrar una entrada de alimento?</h6>
                                <p style="text-align: justify;">
                                    Sí, es recomendable proporcionar una descripción al registrar una entrada, ya que esto permite agregar detalles adicionales como el proveedor o el motivo del ingreso, lo que facilita una mejor gestión del inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se registran las salidas de alimentos del inventario?</h6>
                                <p style="text-align: justify;">
                                    Para registrar una salida, selecciona el tipo de alimento, elige el alimento específico, ingresa la cantidad, registra la fecha y hora de salida, selecciona el tipo de salida y proporciona una descripción. Esto asegura que el sistema documente correctamente las salidas del inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué detalles se deben proporcionar al registrar una salida de alimento?</h6>
                                <p style="text-align: justify;">
                                    Al registrar una salida, debes especificar el tipo de alimento, la cantidad, la fecha y hora de salida, el tipo de salida, y proporcionar una descripción que incluya detalles como el motivo de la salida. Esto garantiza un control preciso de las existencias.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo modificar las cantidades de alimentos después de haber registrado una entrada o salida?</h6>
                                <p style="text-align: justify;">
                                    Una vez que se ha registrado una entrada o salida de alimentos, no se puede modificar directamente. En caso de errores, se debe registrar una nueva entrada o salida con las correcciones correspondientes.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo generar reportes del inventario de alimentos?</h6>
                                <p style="text-align: justify;">
                                    Sí, el sistema permite generar reportes detallados del inventario de alimentos, proporcionando una visión clara de las entradas, salidas y el stock disponible para una gestión eficiente.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo registro un nuevo utensilio en el sistema?</h6>
                                <p style="text-align: justify;">
                                    Para registrar un utensilio, debes seleccionar una imagen que lo identifique, elegir el tipo de utensilio previamente registrado, escribir el nombre del utensilio y seleccionar el material del que está hecho. Si no cuentas con una imagen específica, el sistema usará una imagen predeterminada.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué información es necesaria para registrar un utensilio?</h6>
                                <p style="text-align: justify;">
                                    Al registrar un utensilio, necesitas proporcionar una imagen (o usar la predeterminada), seleccionar el tipo de utensilio, escribir el nombre, y elegir el material del utensilio (plástico, acero inoxidable, vidrio, etc.).
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo modificar los datos de un utensilio ya registrado?</h6>
                                <p style="text-align: justify;">
                                    Sí, puedes modificar los datos de un utensilio registrado, como su tipo, material o nombre. Esto es útil si necesitas actualizar información o corregir errores en el registro inicial.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo consulto los utensilios registrados en el sistema?</h6>
                                <p style="text-align: justify;">
                                    Para consultar los utensilios registrados, accede a la sección de consulta donde podrás ver todos los utensilios con detalles como el nombre, tipo, material y la imagen asociada a cada uno.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es posible eliminar un utensilio del sistema?</h6>
                                <p style="text-align: justify;">
                                    Sí, si un utensilio ya no es necesario, puedes eliminarlo del sistema para mantener un registro actualizado y organizado de los utensilios disponibles.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo consulto el stock de utensilios almacenados?</h6>
                                <p style="text-align: justify;">
                                    Para consultar el stock, puedes acceder a la opción "Stock Utensilios", donde verás una lista completa de los utensilios almacenados, con detalles como la cantidad disponible, cantidad apartada, material, imagen y conteo total de cada utensilio.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué pasos debo seguir para registrar la entrada de nuevos utensilios?</h6>
                                <p style="text-align: justify;">
                                    Para registrar la entrada de utensilios, selecciona el tipo de utensilio y luego el utensilio específico que ingresará. Ingresa la cantidad, registra la fecha y hora de la entrada, y agrega una descripción del ingreso para mantener un registro detallado.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo registrar la salida de utensilios del inventario?</h6>
                                <p style="text-align: justify;">
                                    Sí, para registrar la salida, selecciona el tipo de utensilio, el utensilio específico, e ingresa la cantidad que se está sacando. También debes registrar la fecha y hora de salida, así como el motivo de la salida para un control adecuado del inventario.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Es posible modificar la cantidad de utensilios disponibles en el inventario?</h6>
                                <p style="text-align: justify;">
                                    Sí, puedes actualizar las cantidades existentes de utensilios al registrar nuevas entradas o salidas. Esto asegura que el inventario siempre esté actualizado y refleje correctamente los cambios en las existencias.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se asegura el sistema de un manejo eficiente del inventario de utensilios?</h6>
                                <p style="text-align: justify;">
                                    El sistema permite registrar y consultar cada movimiento de entrada y salida de utensilios, asegurando que todas las operaciones estén documentadas y organizadas, lo que facilita la gestión eficiente del inventario y evita desajustes.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo se gestionan los utensilios que están dañados o en mal estado?</h6>
                                <p style="text-align: justify;">
                                    Para los utensilios dañados, se recomienda marcar su estado en el sistema. Esto permite llevar un control de los utensilios que requieren reparación o reemplazo, y así mantener el inventario en condiciones óptimas.
                                </p>
                            </div>
                        </div>
                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué tipo de reportes estadísticos puedo generar?</h6>
                                <p style="text-align: justify;">
                                    En el módulo de reportes estadísticos, puedes generar reportes sobre la asistencia de estudiantes, el consumo de alimentos y la gestión de utensilios, permitiendo un análisis detallado de la operación del comedor.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Cómo puedo personalizar los parámetros de un reporte?</h6>
                                <p style="text-align: justify;">
                                    Para personalizar un reporte, accede al módulo y selecciona los parámetros que deseas incluir, como rangos de fechas, tipos de alimentos o utensilios, y luego haz clic en "Generar Reporte".
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿En qué formato se generan los reportes estadísticos?</h6>
                                <p style="text-align: justify;">
                                    Los reportes estadísticos se generan en formato PDF, lo que facilita su visualización e impresión.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Puedo acceder a reportes generados anteriormente?</h6>
                                <p style="text-align: justify;">
                                    Sí, puedes consultar todos los reportes generados anteriormente en el módulo de reportes estadísticos. Tendrás acceso a los detalles de cada reporte, incluyendo la fecha de generación y los parámetros utilizados.
                                </p>
                            </div>
                        </div>

                        <div class="item card mb-3" style="max-width: 800px; width: 100%; padding: 20px;">
                            <div class="card-body">
                                <h6>¿Qué debo hacer si un reporte no se genera correctamente?</h6>
                                <p style="text-align: justify;">
                                    Si un reporte no se genera correctamente, verifica que hayas seleccionado los parámetros adecuados. Si el problema persiste, contacta al soporte técnico para obtener asistencia.
                                </p>
                            </div>
                        </div>


    
                    </div>


            
            </div>

            
            </div>



            <div class="card-footer ">
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
     <script src="assets/js/ayuda/ayuda.js"></script>
     <script src="assets/js/ayuda/main.js"></script>
  </body>

  <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
            <h5 class="modal-title title" id="modal1Label">Estudiantes</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab" data-bs-toggle="tab" data-bs-target="#descripcion-general" type="button" role="tab" aria-controls="descripcion-general" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes" type="button" role="tab" aria-controls="preguntas-frecuentes" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="descripcion-general" role="tabpanel" aria-labelledby="descripcion-general-tab">
                        <p class="text-justify">
                            El módulo de estudiantes permite a los usuarios autorizados registrar y gestionar la información de los estudiantes en el sistema de servicio nutricional. Esta funcionalidad asegura una correcta información a controlar de forma eficiente las asistencias y facilita el acceso de los estudiantes al comedor universitario, garantizando un proceso ágil y ordenado.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title" id="modal1Label">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Ingresar Información Estudiantil
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para ingresar la Data estudiantil se debe ingresar al módulo y seleccionar el botón <strong>"Ingresar Data"</strong>. Al hacerlo, será requerida una clave de seguridad. Al ingresarla, se mostrará un modal donde se seleccionará el documento con la Data estudiantil que será cargada en su totalidad. (En caso de no saber el formato del documento, se tiene un archivo de ejemplo en el modal).
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Consultar Información de la Data Estudiantil
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Al ingresar la Data estudiantil, esta podrá ser vista en su totalidad con todos los estudiantes cargados, teniendo a la mano toda la información requerida para su uso dentro del sistema.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el evento. Por ejemplo:</p>
                        <div class="item">
                            <h6>¿Quiénes pueden acceder al módulo de estudiantes?</h6>
                            <p>Solo los usuarios autorizados con las credenciales necesarias pueden acceder al módulo para registrar y gestionar la información de los estudiantes.</p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

  

    <!-- Modal 2 -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal2Label">Asistencias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab2" data-bs-toggle="tab" data-bs-target="#descripcion-general2" type="button" role="tab" aria-controls="descripcion-general2" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab2" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes2" type="button" role="tab" aria-controls="preguntas-frecuentes2" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="descripcion-general2" role="tabpanel" aria-labelledby="descripcion-general-tab2">
                        <p class="text-justify">
                        El módulo de asistencia permite registrar a las personas que acceden al servicio nutricional durante los diferentes tiempos de comida (desayuno, almuerzo, merienda o cena). Este registro ayuda a llevar un control preciso de las entradas, así como del número de platos disponibles a medida que se sirven las comidas. Al igual de un apartado que permite ver todas las asistencias de cada dia y horarios de comida que fueron cumplidos
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                        Registrar Asistencias
                                    </button>
                                </h2>
                                <div id="collapseOne2" class="accordion-collapse collapse show" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                        Para registrar a un estudiante en el sistema de asistencia y asignarle el horario de comida correspondiente, se debe ingresar su cédula o escanear el código QR de su carnet estudiantil. Durante este proceso, se verificará si el estudiante está registrado y tiene permiso para acceder al servicio nutricional. Una vez confirmada esta información, se autoriza su ingreso, se descuenta un plato del total disponible, y este procedimiento se repite cada vez que un estudiante accede al servicio. Si el estudiante ya ha sido registrado previamente a ese horario no podra hacerlo otra vez.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                                        Consultar Asistencias
                                    </button>
                                </h2>
                                <div id="collapseTwo2" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            El sistema permite consultar las asistencias de los estudiantes registradas en días anteriores, facilitando el acceso a los datos históricos y la generación de reportes.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes2" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab2">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el módulo de asistencias:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registra la asistencia de un estudiante?</h6>
                            <p style="text-align: justify;">Para registrar la asistencia, se debe ingresar la cédula del estudiante o escanear el código QR de su carnet. El sistema verificará si el estudiante está registrado y tiene acceso al servicio nutricional.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué sucede si un estudiante intenta registrarse más de una vez en el mismo horario?</h6>
                            <p style="text-align: justify;">Si un estudiante ya ha sido registrado para un horario de comida (desayuno, almuerzo, merienda o cena), no podrá registrarse de nuevo en ese mismo horario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se controla el número de platos disponibles?</h6>
                            <p style="text-align: justify;">Cada vez que un estudiante es registrado, se descuenta un plato del total de platos disponibles para el servicio de comida correspondiente.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo consultar las asistencias de días anteriores?</h6>
                            <p style="text-align: justify;">Sí, el sistema permite consultar las asistencias registradas en días anteriores y generar reportes con los datos históricos.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué pasa si un estudiante no está registrado en el sistema?</h6>
                            <p style="text-align: justify;">Si el estudiante no está registrado en el sistema, hay tres caminos, los dos primeros son las excepciones, que aparecen en los tres puntos (...) que permiten el registro de estudiantes o ingreso (que tengan justificación o la planilla de la universidad). El tercero seria que la persona no puede ingresar debido a que no tiene lo requerido.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal3Label">Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
   
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab3" data-bs-toggle="tab" data-bs-target="#descripcion-general3" type="button" role="tab" aria-controls="descripcion-general3" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab3" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes3" type="button" role="tab" aria-controls="preguntas-frecuentes3" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="descripcion-general3" role="tabpanel" aria-labelledby="descripcion-general-tab3">
                        <p class="text-justify">
                        El módulo de menú permite registrar y consultar los menús que se llevarán a cabo en los días posteriores, facilitando la organización de los alimentos que serán utilizados, la cantidad de comensales a los que se servirá, y el horario correspondiente. Además, se pueden consultar los menús programados, modificarlos si es necesario o visualizar aquellos que ya se hayan ejecutado.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample3">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                                        Registrar Menú
                                    </button>
                                </h2>
                                <div id="collapseOne3" class="accordion-collapse collapse show" data-bs-parent="#accordionExample3">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para registrar un nuevo menú, primero se deben seleccionar los alimentos y especificar la cantidad correspondiente de cada uno. Una vez seleccionados, se elige el día en que se servirá el menú, la cantidad de comensales a los que estará destinado, y el horario en que se ofrecerá (desayuno, almuerzo, merienda o cena). Además, se puede agregar una descripción del menú para proporcionar más detalles e información.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                        Consultar Menú
                                    </button>
                                </h2>
                                <div id="collapseTwo3" class="accordion-collapse collapse" data-bs-parent="#accordionExample3">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            El sistema permite consultar los menús previamente registrados, facilitando el acceso a la información de los menús servidos en días anteriores. También ofrece la opción de realizar modificaciones, siempre que el menú aún no haya sido utilizado. Una vez que la fecha del menú ha pasado, ya no será posible modificarlo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes3" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab3">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el módulo de menú:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registra un nuevo menú?</h6>
                            <p style="text-align: justify;">Para registrar un nuevo menú, primero se deben seleccionar los alimentos y las cantidades correspondientes. Luego, se elige el día, la cantidad de comensales y el horario (desayuno, almuerzo, merienda o cena). También se puede agregar una descripción para proporcionar más detalles sobre el menú.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Se puede modificar un menú registrado?</h6>
                            <p style="text-align: justify;">Sí, los menús pueden ser modificados siempre y cuando la fecha del menú no haya pasado. Una vez que el menú ha sido ejecutado o ha pasado su fecha programada, ya no es posible realizar modificaciones.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué información puedo consultar sobre los menús?</h6>
                            <p style="text-align: justify;">El sistema permite consultar los menús registrados previamente, incluyendo detalles como los alimentos seleccionados, la cantidad de comensales, el día y horario en que se ofreció el menú.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es posible ver los menús de días anteriores?</h6>
                            <p style="text-align: justify;">Sí, el sistema permite acceder a la información de los menús servidos en días anteriores, facilitando la consulta de los menús ejecutados y los alimentos utilizados.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo afecta el registro de un menú a la organización de los alimentos?</h6>
                            <p style="text-align: justify;">El registro de un menú ayuda a organizar los alimentos que serán utilizados y permite planificar la cantidad de comensales a los que se servirá, garantizando una adecuada distribución de los recursos.</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal4Label">Eventos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab4" data-bs-toggle="tab" data-bs-target="#descripcion-general4" type="button" role="tab" aria-controls="descripcion-general4" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab4" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes4" type="button" role="tab" aria-controls="preguntas-frecuentes4" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-general4" role="tabpanel" aria-labelledby="descripcion-general-tab4">
                        <p class="text-justify">
                        El módulo de Eventos permite registrar ocasiones especiales en las que se requiera el servicio de alimentación para los comensales que participen en dichos eventos. Al igual que el módulo de Menú, este sistema gestiona el registro de un menú específico diseñado para cada evento.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample4">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                                        Registrar Evento
                                    </button>
                                </h2>
                                <div id="collapseOne4" class="accordion-collapse collapse show" data-bs-parent="#accordionExample4">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                        Para registrar un nuevo evento, primero se deben seleccionar los alimentos y especificar la cantidad correspondiente de cada uno. Una vez realizados estos pasos, se elige el día en que se servirá el menú y se indica la cantidad de personas a las que estará destinado.

                                        Además, se registra el nombre del evento, una descripción detallada del mismo y el horario en que se ofrecerá (ya sea desayuno, almuerzo, merienda o cena). También es posible agregar una descripción del menú para proporcionar información adicional y más detalles sobre lo que se ofrecerá.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo4">
                                        Consultar Eventos
                                    </button>
                                </h2>
                                <div id="collapseTwo4" class="accordion-collapse collapse" data-bs-parent="#accordionExample4">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            El sistema permite consultar todos los eventos registrados, proporcionando detalles del evento, como la fecha, el menú y los comensales esperados, permitiendo una planificación efectiva del comedor.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes4" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab4">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el módulo de eventos:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registra un nuevo evento?</h6>
                            <p style="text-align: justify;">Para registrar un nuevo evento, se deben seleccionar los alimentos y las cantidades correspondientes, elegir el día y el horario del evento (desayuno, almuerzo, merienda o cena), e indicar la cantidad de personas. Además, se registra el nombre del evento y se puede agregar una descripción del menú.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es posible modificar un evento registrado?</h6>
                            <p style="text-align: justify;">Sí, es posible modificar los detalles de un evento registrado, como el menú o la cantidad de comensales, siempre que el evento aún no haya tenido lugar.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué información puedo consultar sobre los eventos registrados?</h6>
                            <p style="text-align: justify;">El sistema permite consultar todos los eventos registrados, mostrando detalles como la fecha, el menú diseñado para el evento y el número de comensales esperados.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se gestiona el menú de un evento?</h6>
                            <p style="text-align: justify;">El menú para un evento se gestiona de forma similar al registro de un menú diario, permitiendo seleccionar los alimentos y las cantidades necesarias para los comensales, además de agregar descripciones adicionales.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Se pueden consultar los eventos anteriores?</h6>
                            <p style="text-align: justify;">Sí, el sistema permite consultar los eventos anteriores, lo que facilita la revisión de los menús servidos y los detalles logísticos, como la cantidad de comensales que asistieron.</p>
                        </div>
                                            </div>
                                        </div>
                                    </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal5" tabindex="-1" aria-labelledby="modal5Label" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal5Label">Alimentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab5" data-bs-toggle="tab" data-bs-target="#descripcion-general5" type="button" role="tab" aria-controls="descripcion-general5" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab5" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes5" type="button" role="tab" aria-controls="preguntas-frecuentes5" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-general5" role="tabpanel" aria-labelledby="descripcion-general-tab5">
                        <p class="text-justify">
                        El módulo de Alimentos permite registrar de manera eficiente los distintos alimentos en el sistema de servicio nutricional. Este registro es fundamental para garantizar que se disponga de los ingredientes necesarios para una variedad de aplicaciones, incluyendo el ingreso y salida de alimentos, la elaboración de menús, y la organización de eventos.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample5">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
                                        Registrar Alimento
                                    </button>
                                </h2>
                                <div id="collapseOne5" class="accordion-collapse collapse show" data-bs-parent="#accordionExample5">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                        Al registrar un alimento en el sistema, se debe seleccionar una imagen que identifique el producto. En caso de no contar con una imagen específica, se utilizará una imagen predeterminada para asegurar que cada alimento esté visualmente representado.

                                        A continuación, se selecciona el tipo de alimento, el cual debe estar registrado previamente en el sistema. Esto garantiza que todos los alimentos se clasifiquen de manera adecuada. Después, se escribe el nombre del alimento y, si aplica, se indica la marca del producto para proporcionar información adicional que puede ser útil para la gestión del inventario.

                                        Por último, es fundamental seleccionar la unidad de medida correspondiente al alimento (por ejemplo, gramos, litros, unidades, etc.). Este paso es crucial para asegurar una correcta administración de los recursos y facilitar la planificación de menús y eventos.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo5" aria-expanded="false" aria-controls="collapseTwo5">
                                        Consultar y Modificar Alimentos
                                    </button>
                                </h2>
                                <div id="collapseTwo5" class="accordion-collapse collapse" data-bs-parent="#accordionExample5">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                        Una vez que los alimentos han sido registrados, el apartado de consulta permite visualizar toda la información relacionada con cada producto. Esto incluye detalles como el nombre del alimento, su tipo, la marca, la unidad de medida y la imagen asociada. Esta funcionalidad es esencial para el seguimiento y la gestión eficiente del inventario.

                                        Si es necesario, también se pueden modificar los datos de un alimento. Esto resulta útil en situaciones donde se requiera actualizar información, como cambios en la marca o en la unidad de medida. Además, si un alimento ya no es necesario, se tiene la opción de eliminarlo del sistema, asegurando así que solo se mantengan activos los registros pertinentes para la operación.

                                        Esta capacidad de consulta y gestión asegura que el sistema permanezca organizado y que la información esté siempre actualizada, facilitando la planificación de menús y la preparación de eventos.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes5" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab5">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el módulo de alimentos:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registra un nuevo alimento en el sistema?</h6>
                            <p style="text-align: justify;">Para registrar un nuevo alimento, se debe seleccionar una imagen que lo identifique (o usar una predeterminada), elegir el tipo de alimento ya registrado en el sistema, escribir el nombre del alimento, indicar la marca si corresponde, y seleccionar la unidad de medida (gramos, litros, unidades, etc.).</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es posible modificar la información de un alimento registrado?</h6>
                            <p style="text-align: justify;">Sí, se puede modificar la información de un alimento registrado, como su nombre, marca, tipo, unidad de medida o la imagen asociada, para mantener los datos actualizados y correctos en el sistema.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué sucede si un alimento ya no es necesario en el inventario?</h6>
                            <p style="text-align: justify;">Si un alimento ya no es necesario, el sistema permite eliminar su registro, asegurando que solo se mantengan activos los alimentos relevantes para la operación del servicio nutricional.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se consultan los alimentos registrados?</h6>
                            <p style="text-align: justify;">El sistema permite consultar todos los alimentos registrados, mostrando detalles como el nombre, el tipo, la marca, la unidad de medida, y la imagen del alimento. Esta información es fundamental para gestionar el inventario de manera eficiente.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Por qué es importante seleccionar la unidad de medida correcta al registrar un alimento?</h6>
                            <p style="text-align: justify;">Seleccionar la unidad de medida correcta (gramos, litros, unidades, etc.) es crucial para asegurar una correcta administración de los recursos, ya que facilita la planificación de menús, la organización de eventos y el control de inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué sucede si no tengo una imagen específica para un alimento al momento de registrarlo?</h6>
                            <p style="text-align: justify;">Si no tienes una imagen específica para un alimento, el sistema utilizará una imagen predeterminada para identificar visualmente el producto. Esto asegura que todos los alimentos estén representados de manera uniforme en el inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es obligatorio registrar la marca del alimento?</h6>
                            <p style="text-align: justify;">No es obligatorio registrar la marca del alimento, pero es recomendable incluirla si está disponible, ya que esto puede facilitar la gestión del inventario y asegurar una mejor organización de los productos.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal7" tabindex="-1" aria-labelledby="modal7Label" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal7Label">Inventario de Alimentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tab7" data-bs-toggle="tab" data-bs-target="#descripcion-general7" type="button" role="tab" aria-controls="descripcion-general7" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tab7" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes7" type="button" role="tab" aria-controls="preguntas-frecuentes7" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-general7" rzzzzzole="tabpanel" aria-labelledby="descripcion-general-tab7">
                        <p class="text-justify">
                            El módulo de Inventario de Alimentos permite gestionar y controlar las existencias de alimentos en el comedor universitario. A través de este módulo, puedes visualizar el inventario actual, registrar nuevas entradas de alimentos, actualizar las cantidades existentes y generar reportes para un mejor seguimiento del stock.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample7">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne7" aria-expanded="true" aria-controls="collapseOne7">
                                        Stock de Alimentos
                                    </button>
                                </h2>
                                <div id="collapseOne7" class="accordion-collapse collapse show" data-bs-parent="#accordionExample7">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            A través de la opción Stock Alimentos, se puede acceder a la lista completa de alimentos almacenados en el comedor. Los alimentos estarán organizados con información clave como la cantidad disponible, cantidad apartada, conteo total, marca, imagen del producto.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo7" aria-expanded="false" aria-controls="collapseTwo7">
                                        Registrar Entrada de Alimentos
                                    </button>
                                </h2>
                                <div id="collapseTwo7" class="accordion-collapse collapse" data-bs-parent="#accordionExample7">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                        Para registrar la entrada de un alimento, primero se debe seleccionar el tipo de alimento correspondiente y luego elegir el alimento específico que se desea ingresar. A continuación, se aplica la cantidad del alimento, que se añadirá al listado de ingresos. Este procedimiento se repite para cada uno de los alimentos que se estén ingresando al sistema.

                                        Después de ingresar la cantidad, se debe registrar la hora y el día del ingreso para llevar un control preciso de los tiempos de llegada. Además, es importante agregar una descripción del ingreso, que puede incluir información adicional como el proveedor, el motivo del ingreso o cualquier detalle relevante que facilite la gestión del inventario.

                                        Este proceso asegura que todos los alimentos ingresados estén debidamente documentados, lo que contribuye a un manejo más eficiente y organizado del inventario.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                        Registrar Salida de Alimentos
                                    </button>
                                </h2>
                                <div id="collapseThree7" class="accordion-collapse collapse" data-bs-parent="#accordionExample7">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para registrar la salida de un alimento,  primero se debe seleccionar el tipo de alimento correspondiente y luego elegir el alimento específico que se desea sacar. A continuación, se aplica la cantidad del alimento, que se añadirá al listado de salidas. Este procedimiento se repite para cada uno de los alimentos que se estan saliendo del sistema.
                                            Después de ingresar la cantidad, se debe registrar la hora y el día del ingreso para llevar un control preciso de los tiempos de salida. Igualmente se selecciona el tipo de salida que se esta realizando. Además, es importante agregar una descripción de la salida, que puede incluir información adicional como el motivo de la salida o cualquier detalle relevante que facilite la gestión del inventario.
                                            Este proceso asegura que todos los alimentos que salgan estén debidamente documentados, lo que contribuye a un manejo más eficiente y organizado del inventario.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes7" role="tabpanel" aria-labelledby="preguntas-frecuentes-tab7">
                        <p>Aquí puedes agregar las Preguntas Frecuentes sobre el Inventario de Alimentos:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo puedo visualizar el inventario actual de alimentos?</h6>
                            <p style="text-align: justify;">Para visualizar el inventario actual, accede a la opción "Stock Alimentos" en el módulo de inventario. Allí podrás ver una lista completa de los alimentos almacenados con detalles como la cantidad disponible, cantidad apartada, marca e imagen del producto.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué información se muestra en la lista de Stock de Alimentos?</h6>
                            <p style="text-align: justify;">La lista de Stock de Alimentos incluye información clave como la cantidad disponible de cada alimento, cantidad apartada, conteo total, la marca del producto y una imagen para identificar visualmente cada alimento.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registra la entrada de un nuevo alimento en el inventario?</h6>
                            <p style="text-align: justify;">Para registrar una entrada, selecciona el tipo de alimento, elige el alimento específico, ingresa la cantidad, registra la fecha y hora del ingreso, y proporciona una descripción del ingreso. Este proceso garantiza que los nuevos alimentos se agreguen correctamente al inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es necesario proporcionar una descripción al registrar una entrada de alimento?</h6>
                            <p style="text-align: justify;">Sí, es recomendable proporcionar una descripción al registrar una entrada, ya que esto permite agregar detalles adicionales como el proveedor o el motivo del ingreso, lo que facilita una mejor gestión del inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se registran las salidas de alimentos del inventario?</h6>
                            <p style="text-align: justify;">Para registrar una salida, selecciona el tipo de alimento, elige el alimento específico, ingresa la cantidad, registra la fecha y hora de salida, selecciona el tipo de salida y proporciona una descripción. Esto asegura que el sistema documente correctamente las salidas del inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué detalles se deben proporcionar al registrar una salida de alimento?</h6>
                            <p style="text-align: justify;">Al registrar una salida, debes especificar el tipo de alimento, la cantidad, la fecha y hora de salida, el tipo de salida, y proporcionar una descripción que incluya detalles como el motivo de la salida. Esto garantiza un control preciso de las existencias.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo modificar las cantidades de alimentos después de haber registrado una entrada o salida?</h6>
                            <p style="text-align: justify;">Una vez que se ha registrado una entrada o salida de alimentos, no se puede modificar directamente. En caso de errores, se debe registrar una nueva entrada o salida con las correcciones correspondientes.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo generar reportes del inventario de alimentos?</h6>
                            <p style="text-align: justify;">Sí, el sistema permite generar reportes detallados del inventario de alimentos, proporcionando una visión clara de las entradas, salidas y el stock disponible para una gestión eficiente.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUtensilios" tabindex="-1" aria-labelledby="modalUtensiliosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modalUtensiliosLabel">Utensilios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-general-tabUtensilios" data-bs-toggle="tab" data-bs-target="#descripcion-generalUtensilios" type="button" role="tab" aria-controls="descripcion-generalUtensilios" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-tabUtensilios" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentesUtensilios" type="button" role="tab" aria-controls="preguntas-frecuentesUtensilios" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-generalUtensilios" role="tabpanel" aria-labelledby="descripcion-general-tabUtensilios">
                        <p class="text-justify">
                            El módulo de Utensilios permite registrar de manera eficiente los distintos utensilios en el sistema de gestión. Este registro es fundamental para asegurar la disponibilidad de los utensilios necesarios en una variedad de aplicaciones, incluyendo la entrada y salida de utensilios, la planificación de eventos y el uso en la preparación de menús.
                        </p>
                        <div class="accordion" id="accordionExample5">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
                                        Registrar Utensilio
                                    </button>
                                </h2>
                                <div id="collapseOne5" class="accordion-collapse collapse show" data-bs-parent="#accordionExample5">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Al registrar un utensilio en el sistema, se debe seleccionar una imagen que identifique el producto. En caso de no contar con una imagen específica, se utilizará una imagen predeterminada para asegurar que cada utensilio esté visualmente representado.
                                            A continuación, se selecciona el tipo de utensilio, el cual debe estar previamente registrado en el sistema. Esto garantiza que todos los utensilios se clasifiquen de manera adecuada. Después, se escribe el nombre del utensilio para proporcionar una identificación clara y precisa.
                                            Por último, es fundamental seleccionar el material del utensilio (por ejemplo, plástico, acero inoxidable, vidrio, etc.). Este paso es esencial para garantizar una correcta administración de los recursos y facilitar la gestión del inventario, así como la planificación de eventos y su uso adecuado.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo5" aria-expanded="false" aria-controls="collapseTwo5">
                                        Consultar y Modificar Utensilios
                                    </button>
                                </h2>
                                <div id="collapseTwo5" class="accordion-collapse collapse" data-bs-parent="#accordionExample5">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Una vez que los utensilios han sido registrados, el apartado de consulta permite visualizar toda la información relacionada con cada producto. Esto incluye detalles como el nombre del utensilio, su tipo, el material del que está hecho, y la imagen asociada. Esta funcionalidad es esencial para el seguimiento y la gestión eficiente del inventario.
                                            Si es necesario, también se pueden modificar los datos de un utensilio. Esto resulta útil en situaciones donde se requiera actualizar información, como cambios en el material o el tipo de utensilio. Además, si un utensilio ya no es necesario, se tiene la opción de eliminarlo del sistema, asegurando que solo se mantengan activos los registros pertinentes para la operación.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentesUtensilios" role="tabpanel" aria-labelledby="preguntas-frecuentes-tabUtensilios">
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo registro un nuevo utensilio en el sistema?</h6>
                            <p style="text-align: justify;">Para registrar un utensilio, debes seleccionar una imagen que lo identifique, elegir el tipo de utensilio previamente registrado, escribir el nombre del utensilio y seleccionar el material del que está hecho. Si no cuentas con una imagen específica, el sistema usará una imagen predeterminada.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué información es necesaria para registrar un utensilio?</h6>
                            <p style="text-align: justify;">Al registrar un utensilio, necesitas proporcionar una imagen (o usar la predeterminada), seleccionar el tipo de utensilio, escribir el nombre, y elegir el material del utensilio (plástico, acero inoxidable, vidrio, etc.).</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo modificar los datos de un utensilio ya registrado?</h6>
                            <p style="text-align: justify;">Sí, puedes modificar los datos de un utensilio registrado, como su tipo, material o nombre. Esto es útil si necesitas actualizar información o corregir errores en el registro inicial.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo consulto los utensilios registrados en el sistema?</h6>
                            <p style="text-align: justify;">Para consultar los utensilios registrados, accede a la sección de consulta donde podrás ver todos los utensilios con detalles como el nombre, tipo, material y la imagen asociada a cada uno.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es posible eliminar un utensilio del sistema?</h6>
                            <p style="text-align: justify;">Sí, si un utensilio ya no es necesario, puedes eliminarlo del sistema para mantener un registro actualizado y organizado de los utensilios disponibles.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal6" tabindex="-1" aria-labelledby="modal6Label" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal6Label">Inventario de Utensilios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTabInventario" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-inventario-tab" data-bs-toggle="tab" data-bs-target="#descripcion-inventario" type="button" role="tab" aria-controls="descripcion-inventario" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-inventario-tab" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes-inventario" type="button" role="tab" aria-controls="preguntas-frecuentes-inventario" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="descripcion-inventario" role="tabpanel" aria-labelledby="descripcion-inventario-tab">
                        <p class="text-justify">
                            El módulo de Inventario de Utensilios permite gestionar y controlar las existencias de utensilios en el comedor universitario. A través de este módulo, puedes visualizar el inventario actual, registrar nuevas entradas de utensilios, actualizar las cantidades existentes y generar reportes para un mejor seguimiento del stock.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title" id="modal6Label">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionExample7">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne7" aria-expanded="true" aria-controls="collapseOne7">
                                    Stock de Utensilios
                                </button>
                            </h2>
                            <div id="collapseOne7" class="accordion-collapse collapse show" data-bs-parent="#accordionExample7">
                                <div class="accordion-body">
                                    <p class="text-justify">
                                        A través de la opción Stock Utensilios, se puede acceder a la lista completa de utensilios almacenados en el comedor. Los utensilios estarán organizados con información clave como la cantidad disponible, cantidad apartada, conteo total, material, imagen del utensilio.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo7" aria-expanded="false" aria-controls="collapseTwo7">
                                    Registrar Entrada de Utensilios
                                </button>
                            </h2>
                            <div id="collapseTwo7" class="accordion-collapse collapse" data-bs-parent="#accordionExample7">
                                <div class="accordion-body">
                                    <p class="text-justify">
                                        Para registrar la entrada de un utensilio, primero se debe seleccionar el tipo de utensilio correspondiente y luego elegir el utensilio específico que se desea ingresar. A continuación, se aplica la cantidad del utensilio, que se añadirá al listado de ingresos. Este procedimiento se repite para cada uno de los utensilios que se estén ingresando al sistema.

                                        Después de ingresar la cantidad, se debe registrar la hora y el día del ingreso para llevar un control preciso de los tiempos de llegada. Además, es importante agregar una descripción del ingreso, que puede incluir información adicional como el proveedor, el motivo del ingreso o cualquier detalle relevante que facilite la gestión del inventario.

                                        Este proceso asegura que todos los utensilios ingresados estén debidamente documentados, lo que contribuye a un manejo más eficiente y organizado del inventario.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree7" aria-expanded="false" aria-controls="collapseThree7">
                                    Registrar Salida de Utensilios
                                </button>
                            </h2>
                            <div id="collapseThree7" class="accordion-collapse collapse" data-bs-parent="#accordionExample7">
                                <div class="accordion-body">
                                    <p class="text-justify">
                                        Para registrar la salida de un utensilio, primero se debe seleccionar el tipo de utensilio correspondiente y luego elegir el utensilio específico que se desea sacar. A continuación, se aplica la cantidad del utensilio, que se añadirá al listado de salidas. Este procedimiento se repite para cada uno de los utensilios que estén saliendo del sistema.

                                        Después de ingresar la cantidad, se debe registrar la hora y el día de la salida para llevar un control preciso de los tiempos. Igualmente se selecciona el tipo de salida que se está realizando. Además, es importante agregar una descripción de la salida, que puede incluir información adicional como el motivo de la salida o cualquier detalle relevante que facilite la gestión del inventario.

                                        Este proceso asegura que todos los utensilios que salgan estén debidamente documentados, lo que contribuye a un manejo más eficiente y organizado del inventario.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes-inventario" role="tabpanel" aria-labelledby="preguntas-frecuentes-inventario-tab">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con el inventario de utensilios. Por ejemplo:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo consulto el stock de utensilios almacenados?</h6>
                            <p style="text-align: justify;">Para consultar el stock, puedes acceder a la opción "Stock Utensilios", donde verás una lista completa de los utensilios almacenados, con detalles como la cantidad disponible, cantidad apartada, material, imagen y conteo total de cada utensilio.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué pasos debo seguir para registrar la entrada de nuevos utensilios?</h6>
                            <p style="text-align: justify;">Para registrar la entrada de utensilios, selecciona el tipo de utensilio y luego el utensilio específico que ingresará. Ingresa la cantidad, registra la fecha y hora de la entrada, y agrega una descripción del ingreso para mantener un registro detallado.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo registrar la salida de utensilios del inventario?</h6>
                            <p style="text-align: justify;">Sí, para registrar la salida, selecciona el tipo de utensilio, el utensilio específico, e ingresa la cantidad que se está sacando. También debes registrar la fecha y hora de salida, así como el motivo de la salida para un control adecuado del inventario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Es posible modificar la cantidad de utensilios disponibles en el inventario?</h6>
                            <p style="text-align: justify;">Sí, puedes actualizar las cantidades existentes de utensilios al registrar nuevas entradas o salidas. Esto asegura que el inventario siempre esté actualizado y refleje correctamente los cambios en las existencias.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se asegura el sistema de un manejo eficiente del inventario de utensilios?</h6>
                            <p style="text-align: justify;">El sistema permite registrar y consultar cada movimiento de entrada y salida de utensilios, asegurando que todas las operaciones estén documentadas y organizadas, lo que facilita la gestión eficiente del inventario y evita desajustes.</p>
                        </div>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo se gestionan los utensilios que están dañados o en mal estado?</h6>
                            <p style="text-align: justify;">Para los utensilios dañados, se recomienda marcar su estado en el sistema. Esto permite llevar un control de los utensilios que requieren reparación o reemplazo, y así mantener el inventario en condiciones óptimas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Reportes Estadísticos -->
<div class="modal fade" id="modal8" tabindex="-1" aria-labelledby="modal8Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modal8Label">Reportes Estadísticos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTabReportes" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-reportes-tab" data-bs-toggle="tab" data-bs-target="#descripcion-reportes" type="button" role="tab" aria-controls="descripcion-reportes" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="preguntas-frecuentes-reportes-tab" data-bs-toggle="tab" data-bs-target="#preguntas-frecuentes-reportes" type="button" role="tab" aria-controls="preguntas-frecuentes-reportes" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="descripcion-reportes" role="tabpanel" aria-labelledby="descripcion-reportes-tab">
                        <p class="text-justify">
                            El módulo de reportes estadísticos proporciona a los usuarios información detallada sobre el funcionamiento del sistema. Aquí podrás consultar estadísticas sobre la asistencia de estudiantes, consumo de alimentos, y gestión de utensilios.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title" id="modal8Label">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionReportes">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReportesOne" aria-expanded="true" aria-controls="collapseReportesOne">
                                        Generar Reporte
                                    </button>
                                </h2>
                                <div id="collapseReportesOne" class="accordion-collapse collapse show" data-bs-parent="#accordionReportes">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para generar un reporte estadístico, accede al módulo y selecciona los parámetros deseados. Haz clic en <strong>"Generar Reporte"</strong> para obtener la información en formato PDF.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReportesTwo" aria-expanded="false" aria-controls="collapseReportesTwo">
                                        Consultar Reportes Generados
                                    </button>
                                </h2>
                                <div id="collapseReportesTwo" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Puedes consultar todos los reportes generados anteriormente. Tendrás acceso a los detalles de cada reporte, incluyendo la fecha de generación y los parámetros utilizados.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="preguntas-frecuentes-reportes" role="tabpanel" aria-labelledby="preguntas-frecuentes-reportes-tab">
                        <p>Aquí puedes colocar las Preguntas Frecuentes relacionadas con los reportes estadísticos. Por ejemplo:</p>
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué tipo de reportes estadísticos puedo generar?</h6>
                            <p style="text-align: justify;">En el módulo de reportes estadísticos, puedes generar reportes sobre la asistencia de estudiantes, el consumo de alimentos y la gestión de utensilios, permitiendo un análisis detallado de la operación del comedor.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo puedo personalizar los parámetros de un reporte?</h6>
                            <p style="text-align: justify;">Para personalizar un reporte, accede al módulo y selecciona los parámetros que deseas incluir, como rangos de fechas, tipos de alimentos o utensilios, y luego haz clic en "Generar Reporte".</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿En qué formato se generan los reportes estadísticos?</h6>
                            <p style="text-align: justify;">Los reportes estadísticos se generan en formato PDF, lo que facilita su visualización e impresión.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo acceder a reportes generados anteriormente?</h6>
                            <p style="text-align: justify;">Sí, puedes consultar todos los reportes generados anteriormente en el módulo de reportes estadísticos. Tendrás acceso a los detalles de cada reporte, incluyendo la fecha de generación y los parámetros utilizados.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué debo hacer si un reporte no se genera correctamente?</h6>
                            <p style="text-align: justify;">Si un reporte no se genera correctamente, verifica que hayas seleccionado los parámetros adecuados. Si el problema persiste, contacta al soporte técnico para obtener asistencia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaTipolUtensilios" tabindex="-1" aria-labelledby="modalUtensiliosLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modalUtensiliosLabel">Tipos de Utensilios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTabUtensilios" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-utensilios-tab" data-bs-toggle="tab" data-bs-target="#descripcion-utensilios" type="button" role="tab" aria-controls="descripcion-utensilios" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="gestion-utensilios-tab" data-bs-toggle="tab" data-bs-target="#gestion-utensilios" type="button" role="tab" aria-controls="gestion-utensilios" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-utensilios" role="tabpanel" aria-labelledby="descripcion-utensilios-tab">
                        <p class="text-justify">
                        El módulo de Tipos de Utensilios facilita el registro eficiente de las distintas categorías de utensilios en el sistema de servicio nutricional. Este registro es esencial para asegurar la correcta clasificación de cada utensilio, lo que permite una identificación precisa al realizar registros, generar reportes o ejecutar búsquedas filtradas.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title" id="modalUtensiliosLabel">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionUtensilios">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUtensiliosOne" aria-expanded="true" aria-controls="collapseUtensiliosOne">
                                        Registrar Tipos de Utensilios
                                    </button>
                                </h2>
                                <div id="collapseUtensiliosOne" class="accordion-collapse collapse show" data-bs-parent="#accordionUtensilios">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para registrar un tipo de utensilio sencillamente se presiona el boton de <strong>Nuevo Tipo de Utensilio</strong> y se agrega el nombre para el registro.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUtensiliosTwo" aria-expanded="false" aria-controls="collapseUtensiliosTwo">
                                        Gestionar Tipos de Utensilios 
                                    </button>
                                </h2>
                                <div id="collapseUtensiliosTwo" class="accordion-collapse collapse" data-bs-parent="#accordionUtensilios">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Si es requerido se puede modificar el nombre del tipo de utensilio, al igual que su eliminacion si es requerido, no obstante si ya el tipo ha sido utilizado en un registro de utensilio no podra ser eliminado.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Utensilios -->
                    <div class="tab-pane fade" id="gestion-utensilios" role="tabpanel" aria-labelledby="gestion-utensilios-tab">
                    <div class="item" style="margin-bottom: 15px;">
                        <h6>¿Cómo registro un nuevo tipo de utensilio en el sistema?</h6>
                        <p style="text-align: justify;">Para registrar un nuevo tipo de utensilio, simplemente haz clic en el botón "Nuevo Tipo de Utensilio" y agrega el nombre del tipo en el formulario correspondiente.</p>
                    </div>

                    <div class="item" style="margin-bottom: 15px;">
                        <h6>¿Puedo modificar el nombre de un tipo de utensilio una vez registrado?</h6>
                        <p style="text-align: justify;">Sí, es posible modificar el nombre de un tipo de utensilio existente accediendo a la opción de edición en el módulo de gestión de tipos de utensilios.</p>
                    </div>

                    <div class="item" style="margin-bottom: 15px;">
                        <h6>¿Qué sucede si intento eliminar un tipo de utensilio que ya ha sido utilizado?</h6>
                        <p style="text-align: justify;">Si el tipo de utensilio ya ha sido utilizado en algún registro, no podrá ser eliminado para mantener la integridad de los datos relacionados.</p>
                    </div>

                    <div class="item" style="margin-bottom: 15px;">
                        <h6>¿Es posible buscar utensilios específicos por su tipo?</h6>
                        <p style="text-align: justify;">Sí, el sistema permite realizar búsquedas filtradas por tipo de utensilio, lo que facilita la identificación y gestión de los utensilios almacenados.</p>
                    </div>

                    <div class="item" style="margin-bottom: 15px;">
                        <h6>¿Qué sucede si registro incorrectamente un tipo de utensilio?</h6>
                        <p style="text-align: justify;">Si registras un tipo de utensilio incorrecto, puedes editar su nombre o, si aún no ha sido utilizado en registros, eliminarlo del sistema.</p>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaTipoAlimentos" tabindex="-1" aria-labelledby="modalAlimentosLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modalAlimentosLabel">Tipos de Alimentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTabAlimentos" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-alimentos-tab" data-bs-toggle="tab" data-bs-target="#descripcion-alimentos" type="button" role="tab" aria-controls="descripcion-alimentos" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="gestion-alimentos-tab" data-bs-toggle="tab" data-bs-target="#gestion-alimentos" type="button" role="tab" aria-controls="gestion-alimentos" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-alimentos" role="tabpanel" aria-labelledby="descripcion-alimentos-tab">
                        <p class="text-justify">
                        El módulo de Tipos de Alimentos permite la clasificación y gestión de los diferentes alimentos que se registran en el sistema de servicio nutricional. Esto asegura que cada alimento esté correctamente categorizado, facilitando el manejo de inventarios y la generación de reportes o búsquedas filtradas.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title" id="modalAlimentosLabel">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionAlimentos">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAlimentosOne" aria-expanded="true" aria-controls="collapseAlimentosOne">
                                        Registrar Tipos de Alimentos
                                    </button>
                                </h2>
                                <div id="collapseAlimentosOne" class="accordion-collapse collapse show" data-bs-parent="#accordionAlimentos">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para registrar un nuevo tipo de alimento, haz clic en el botón <strong>Nuevo Tipo de Alimento</strong> y agrega el nombre correspondiente en el formulario.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAlimentosTwo" aria-expanded="false" aria-controls="collapseAlimentosTwo">
                                        Gestionar Tipos de Alimentos
                                    </button>
                                </h2>
                                <div id="collapseAlimentosTwo" class="accordion-collapse collapse" data-bs-parent="#accordionAlimentos">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Puedes modificar el nombre de un tipo de alimento registrado. Si el tipo de alimento ya ha sido utilizado en algún registro, no podrá ser eliminado.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas Frecuentes -->
                    <div class="tab-pane fade" id="gestion-alimentos" role="tabpanel" aria-labelledby="gestion-alimentos-tab">
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo registro un nuevo tipo de alimento en el sistema?</h6>
                            <p style="text-align: justify;">Para registrar un nuevo tipo de alimento, haz clic en el botón "Nuevo Tipo de Alimento" y completa el formulario con el nombre del tipo.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo modificar el nombre de un tipo de alimento una vez registrado?</h6>
                            <p style="text-align: justify;">Sí, puedes modificar el nombre del tipo de alimento accediendo a la opción de edición en el módulo de gestión de tipos de alimentos.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué sucede si intento eliminar un tipo de alimento que ya ha sido utilizado?</h6>
                            <p style="text-align: justify;">No podrás eliminar un tipo de alimento que ya ha sido registrado en algún inventario o reporte para asegurar la consistencia de los datos.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿El sistema permite buscar alimentos por su tipo?</h6>
                            <p style="text-align: justify;">Sí, el sistema permite búsquedas filtradas por tipo de alimento, facilitando la gestión de inventarios y reportes.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué debo hacer si registro incorrectamente un tipo de alimento?</h6>
                            <p style="text-align: justify;">Puedes editar o eliminar el tipo de alimento, siempre y cuando no haya sido utilizado en ningún registro.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaTipoSalidas" tabindex="-1" aria-labelledby="modalSalidasLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-azul4">
                    <h5 class="modal-title title" id="modalSalidasLabel">Tipos de Salidas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs justify-content-center" id="myTabSalidas" role="tablist" style="border-bottom: none;">
                    <li class="nav-item" role="presentation" style="margin-right: 50px;">
                        <button class="nav-link active" id="descripcion-salidas-tab" data-bs-toggle="tab" data-bs-target="#descripcion-salidas" type="button" role="tab" aria-controls="descripcion-salidas" aria-selected="true">
                            Descripción General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="margin-left: 50px;">
                        <button class="nav-link" id="gestion-salidas-tab" data-bs-toggle="tab" data-bs-target="#gestion-salidas" type="button" role="tab" aria-controls="gestion-salidas" aria-selected="false">
                            Preguntas Frecuentes
                        </button>
                    </li>
                </ul>

                <!-- Línea debajo del tab activo -->
                <div class="tab-line text-center">
                    <div class="linea-activa"></div>
                </div>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Descripción General -->
                    <div class="tab-pane fade show active" id="descripcion-salidas" role="tabpanel" aria-labelledby="descripcion-salidas-tab">
                        <p class="text-justify">
                            El módulo de Tipos de Salidas permite registrar y gestionar las distintas categorías de salidas de alimentos o utensilios del inventario. Estas salidas pueden deberse a diversas razones, como descomposición de alimentos, oxidación de utensilios o cualquier otro factor que justifique la baja de un ítem del sistema.
                        </p>
                        <div class="w-100 text-center">
                            <h6 class="modal-title">Funciones</h6>
                        </div>

                        <!-- Acordeón -->
                        <div class="accordion" id="accordionSalidas">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSalidasOne" aria-expanded="true" aria-controls="collapseSalidasOne">
                                        Registrar Tipo de Salida
                                    </button>
                                </h2>
                                <div id="collapseSalidasOne" class="accordion-collapse collapse show" data-bs-parent="#accordionSalidas">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Para registrar un tipo de salida, simplemente presiona el botón <strong>Nuevo Tipo de Salida</strong> y agrega una descripción que explique el motivo de la baja.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-azul10 blanco" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSalidasTwo" aria-expanded="false" aria-controls="collapseSalidasTwo">
                                        Gestionar Tipos de Salida
                                    </button>
                                </h2>
                                <div id="collapseSalidasTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSalidas">
                                    <div class="accordion-body">
                                        <p class="text-justify">
                                            Los tipos de salida se pueden modificar o eliminar si aún no han sido utilizados en registros de salidas. Si ya se han utilizado, no podrán ser eliminados para preservar la integridad de los datos.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Salidas -->
                    <div class="tab-pane fade" id="gestion-salidas" role="tabpanel" aria-labelledby="gestion-salidas-tab">
                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Cómo registro un nuevo tipo de salida en el sistema?</h6>
                            <p style="text-align: justify;">Para registrar un nuevo tipo de salida, haz clic en el botón "Nuevo Tipo de Salida" y agrega la descripción correspondiente en el formulario.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Puedo modificar el motivo de una salida registrada?</h6>
                            <p style="text-align: justify;">Sí, es posible modificar la descripción de un tipo de salida si este no ha sido utilizado en registros.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué sucede si intento eliminar un tipo de salida ya utilizado?</h6>
                            <p style="text-align: justify;">No se permite eliminar un tipo de salida que ya ha sido utilizado en registros de salidas para mantener la integridad de los datos.</p>
                        </div>

                        <div class="item" style="margin-bottom: 15px;">
                            <h6>¿Qué razones comunes de salida existen?</h6>
                            <p style="text-align: justify;">Algunas razones comunes son la descomposición de alimentos, la oxidación de utensilios o daños en productos almacenados.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


</html>