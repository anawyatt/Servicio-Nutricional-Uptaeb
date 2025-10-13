$(document).ready(function () {
  // Referencias a elementos DOM que se usan múltiples veces
  const $fechaI = $("#fechaI");
  const $fechaF = $("#fechaF");
  const $error1 = $("#error1");
  const $error2 = $("#error2");
  const $basicAddon1 = $("#basic-addon1");
  const $basicAddon2 = $("#basic-addon2");

  // Estado de los errores
  let errorFI = false;
  let errorFF = false;

  // Configuración inicial de la interfaz
  $("#ani").hide(1000);

  // Manejo de filtros
  function setupFilters() {
    const $activarFiltro = $("#cbx");
    const $buscar = $(".buscar");

    // Estado inicial
    if (!$activarFiltro.is(":checked")) {
      $buscar.hide();
    }

    if (!$("#cbx").is(":checked")) {
      $(".buscar2").hide();
    }

    // Manejar cambios en el checkbox principal
    $activarFiltro.change(function () {
      if ($(this).is(":checked")) {
        $buscar.show();
      } else {
        $buscar.hide();
        $fechaI.val("");
        $fechaF.val("");
        mostrarTabla();
         ocultarError($fechaF, $error2, ".bar2", ".ic2", ".letra2");
         ocultarError($fechaI, $error1, ".bar1", ".ic1", ".letra1");
      }
    });
  }

  // Inicializar DataTable una sola vez
  // Inicializar DataTable con server-side processing
  // Inicializar DataTable con server-side processing
  const tabla = $(".tabla").DataTable({
    processing: true,
    serverSide: true,
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, 100],
      [10, 25, 50, 100],
    ],
    columns: [
      {
        data: "imagen",
        orderable: false,
      },
      { data: "modulo" },
      {
        data: "acciones",
        orderable: false,
      },
      { data: "fecha" },
      { data: "hora" },
    ],
    order: [[3, "desc"]], // Ordenar por fecha descendente por defecto
    ajax: {
      url: "",
      type: "POST",
      data: function (d) {
        // Agregar parámetros personalizados
        d.tabla = "tabla";
        d.fechaInicio = $fechaI.val();
        d.fechaFin = $fechaF.val();
        return d;
      },
      dataSrc: function (json) {
        // Procesar los datos antes de mostrarlos
        if (json.data) {
          json.data = json.data.map((fila) => ({
            imagen: `<img src="${fila.img}" width="70" height="70" alt="Profile" class="rounded-circle mb-2"> <span style='margin-left:5px!important;'>${fila.nombre} ${fila.apellido}</span>`,
            modulo: fila.modulo,
            acciones: `<a class="btn btn-sm btn-icon text-primary text-center d-flex align-items-center justify-content-center ver" 
                   data-bs-toggle="modal" 
                   data-bs-target="#bitacora" 
                   title="Ver Acciones de la bitacora" 
                   href="#" 
                   data-cedula="${fila.cedula}" 
                   data-idbitacora="${fila.idBitacora}">
                   <span class="btn-inner pi">
                     <i class="bi bi-eye icon-24 t" width="20"></i>
                   </span>
                 </a>`,
            fecha: formatearFecha(fila.fecha),
            hora: formatearHora(fila.hora),
          }));
        }
        return json.data;
      },
    },
    language: {
      processing: "Procesando...",
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    autoWidth: false,
  });

  function mostrarTabla() {
    // Recargar la tabla con los nuevos parámetros de fecha
    // Esto forzará a que se ejecute nuevamente la función data() del ajax
    tabla.ajax.reload();
    $("#ani").show(2000);
  }
// === VALIDACIÓN FECHA INICIO ===
function validarFechaInicio() {
  const fechaInicio = new Date($fechaI.val());
  const fechaActual = new Date();

  if (fechaInicio > fechaActual) {
    mostrarError(
      "Fecha Inicio inválida!",
      "Ingrese la Fecha, No debe ser mayor a la fecha de hoy!",
      $fechaI,
      $error1,
      ".bar1",
      ".ic1",
      ".letra1"
    );
    errorFI = true;
  } else {
    ocultarError($fechaI, $error1, ".bar1", ".ic1", ".letra1");
    errorFI = false;
  }

  return !errorFI;
}

// === VALIDACIÓN FECHA FIN ===
function validarFechaFin() {
  const fechaInicio = new Date($fechaI.val());
  const fechaFin = new Date($fechaF.val());
  const fechaActual = new Date();

  if (fechaFin > fechaActual) {
    mostrarError(
      "Fecha Fin inválida!",
      "Ingrese la Fecha, No debe ser mayor a la fecha de hoy!",
      $fechaF,
      $error2,
      ".bar2",
      ".ic2",
      ".letra2"
    );
    errorFF = true;
  } else if (fechaInicio > fechaFin) {
    mostrarError(
      "Fecha Fin inválida!",
      "La fecha no debe ser menor a la fecha de inicio!",
      $fechaF,
      $error2,
      ".bar2",
      ".ic2",
      ".letra2"
    );
    errorFF = true;
  } else {
    ocultarError($fechaF, $error2, ".bar2", ".ic2", ".letra2");
    errorFF = false;
  }

  return !errorFF;
}

// === FUNCIONES DE UTILIDAD ===
function mostrarError(titulo, mensaje, $campo, $error, barClass, icClass, letraClass) {
  Swal.fire({
    toast: true,
    position: "top-end",
    icon: "error",
    title: `<b class="text-rojo">${titulo}</b>`,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: 3000,
  });

  // Mensaje de error
  $error.html(`<i class="bi bi-exclamation-triangle-fill"></i> ${mensaje}`).show();

  // Estilos visuales de error
  $campo.addClass("errorBorder");
  $(barClass).removeClass("bar");
  $(icClass).addClass("l").removeClass("labelPri");
  $(letraClass).addClass("labelE").removeClass("label-char");
}

function ocultarError($campo, $error, barClass, icClass, letraClass) {
  // Oculta y limpia error
  $error.html("").hide();

  // Restaura estilos visuales
  $campo.removeClass("errorBorder");
  $(barClass).addClass("bar");
  $(icClass).removeClass("l").addClass("labelPri");
  $(letraClass).removeClass("labelE").addClass("label-char");
}

  // Función para formatear fechas
  function formatearFecha(fechaStr) {
    const fecha = new Date(fechaStr);
    return `${
      fecha.getDate() + 1
    }-${fecha.getMonth() + 1}-${fecha.getFullYear()}`;
  }

  // Función para formatear horas
  function formatearHora(horaStr) {
    const hora = new Date(`01/01/2000 ${horaStr}`);
    return hora.toLocaleString("en-US", {
      hour: "numeric",
      minute: "numeric",
      hour12: true,
    });
  }

  // Función principal para cargar y mostrar datos

  // Función para ver detalles de bitácora
  function verDetalleBitacora() {
    $(document).on("click", ".ver", function () {
      const id = $(this).data("cedula");
      const idBitacora = $(this).data("idbitacora");

      $.ajax({
        method: "POST",
        url: "",
        dataType: "JSON",
        data: { verBitacora: true, id: id, idBitacora: idBitacora },
        success: function (data) {
          console.log("funciona", data);
          let tabli1 = "";
          let tabli2 = "";

          data.forEach((fila) => {
            // Formatear fecha y hora
            const fechaFormateada = formatearFecha(fila.fecha);
            const horaFormateada = new Date(
              `01/01/2000 ${fila.hora}`
            ).toLocaleTimeString("en-US", {
              hour: "numeric",
              minute: "numeric",
              hour12: true,
            });

            // Construir tablas
            tabli1 += `
                <tr>
                  <td>${fila.acciones}</td>
                </tr>`;

            tabli2 += `
                <tr>
                  <td>${fila.modulo}</td>
                  <td>${fechaFormateada}</td>
                  <td>${horaFormateada}</td>
                </tr>`;
          });

          // Crear tablas con scroll responsivo
          const tableTemplate = (content) =>
            `<div style="overflow-x: auto; max-width: 100%;"><table class="table">${content}</table></div>`;

          $("#info1").html(tableTemplate(tabli1));
          $("#info2").html(tableTemplate(tabli2));
        },
        error: function (xhr, status, error) {
          console.error("Error en AJAX:", error);
        },
      });
    });
  }

  // Inicialización y eventos
  function init() {
    setupFilters();
    mostrarTabla();
    verDetalleBitacora();

    // Eventos para cambios en fechas
    $fechaI.add($fechaF).on("change", function () {
      validarFechaInicio();
      validarFechaFin();
      mostrarTabla();
    });

    // Activar tab inicial
    $("#b1").addClass("active");
  }

  // Iniciar todo
  init();
});
