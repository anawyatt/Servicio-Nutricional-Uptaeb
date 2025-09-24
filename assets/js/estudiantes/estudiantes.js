//Consulta de Permisos
let permisos, modificarPermiso, eliminarPermiso, registrarPermiso;
$.ajax({
  method: "POST",
  url: "",
  dataType: "json",
  data: { getPermisos: "a" },
  success(data) {
    permisos = data;
  },
}).then(function () {
  registrarPermiso =
    typeof permisos.registrar === "undefined" ? "disabled" : "";
  modificarPermiso =
    typeof permisos.modificar === "undefined" ? "disabled" : "";
  eliminarPermiso = typeof permisos.eliminar === "undefined" ? "disabled" : "";
  $("#enviar").attr(registrarPermiso, "");
});

function quitarBotones() {
  if (typeof permisos.registrar == "undefined") {
    console.log(permisos);
    $(".agregar").remove();
    $(".agregar").addClass("d-none");
  }
}

// Inicializar DataTables con server-side processing
function mostrarTabla() {
  $("#ani").hide();

  // Mostrar el spinner de carga
  $("#loading-spinner").show();

  tabla = $(".tabla").DataTable({
    processing: true, // Mostrar indicador de procesamiento
    serverSide: true, // Habilitar server-side processing
    ajax: {
      url: "", // Tu URL del controlador
      type: "POST",
      data: function (d) {
        // Agregar parámetros adicionales si es necesario
        d.verEstudiantes = true;
        return d;
      },
      dataSrc: function (json) {
        // Ocultar spinner y mostrar tabla cuando los datos llegan
        $("#loading-spinner").fadeOut(500, function () {
          $("#ani").show(1000);
        });
        return json.data;
      },
      error: function (xhr, status, error) {
        console.error("Error en la petición AJAX: ", status, error);
        // Ocultar spinner en caso de error
        $("#loading-spinner").fadeOut(500, function () {
          $("#ani").show(1000);
        });
      },
    },
    columns: [
      {
        data: "cedEstudiante",
        render: function (data, type, row) {
          return formatearCedula(data);
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return `${row.nombre} ${row.apellido}`;
        },
      },
      { data: "carrera" },
      { data: "seccion" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return `
            <a class="btn btn-sm btn-icon text-primary aling-center flex-center ver" 
                        data-bs-toggle="modal" 
                        data-bs-target="#consultarStudy" 
                        title="Ver Estudiantes" 
                        href="#" 
                        id="${row.cedulaEncriptada}">
                        <span class="btn-inner pi">
                            <i class="bi bi-eye icon-24 t" width="20"></i>
                        </span>
              </a>
          `;
        },
      },
    ],
    pageLength: 10, // Registros por página por defecto
    lengthMenu: [10, 25, 50, 100], // Opciones de paginación
    searching: true, // Habilitar búsqueda
    ordering: true, // Habilitar ordenamiento
    info: true, // Mostrar información de la paginación
    autoWidth: false,
    responsive: true,
    destroy: true,
    language: {
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrado de _MAX_ registros en total)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      processing: "Procesando...",
      loadingRecords: "Cargando registros...",
    },
  });
}

mostrarTabla();
// Ya no necesitas la función mostrarTabla() porque DataTables maneja todo automáticamente

function formatearCedula(cedula) {
  cedula = cedula.toString().replace(/\D/g, "");

  const prefijo = "V- ";

  const formato = cedula.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

  return prefijo + formato;
}

let id;
// Mostrar informacion
$(document).on("click", ".ver", function () {
  id = this.id;
  $.ajax({
    method: "post",
    url: "",
    dataType: "json",
    data: { verEstudiantes_informacion: true, id: id },
    success(data) {
      let tabli1 = " ",
        tabli2 = " ",
        tabli3 = " ";

      tabli1 = `
                        <tr>
                        <td class="">${formatearCedula(
                          data[0].cedEstudiante
                        )}</td>
                        <td class="">${data[0].nombre} ${
        data[0].segNombre
      } </td>
                        <td class="">${data[0].apellido} ${
        data[0].segApellido
      }</td>
                        
                    </tr>`;

      tabli2 = `
                        <tr>
                        <td class="">${data[0].sexo}</td>
                        <td class="">${data[0].telefono}</td>
                        <td class="">${data[0].nucleo}</td>
                        <td class="">${data[0].carrera}</td>
                        </tr>`;

      tabli3 = `
                    <tr>
                    <td class="">${data[0].seccion}</td>
                    <td class="">${data[0].horario}</td>
                    </tr>`;

      $("#info1").html(tabli1);
      $("#info2").html(tabli2);
      $("#info3").html(tabli3);
    },
  });
});

$(document).ready(function () {
  $("a.protected-agregar").click(function (event) {
    event.preventDefault();

    Swal.fire({
      title: '<h5 class="azul5">Ingrese el código</h5>',
      html: `
                    <div class="input-group">
                        <input type="password" class="form-control " id="codigoInput" placeholder="Código">
                        <span class="input-group-text bg-primary blanco" id="togglePassword"><i class="bi bi-eye-fill"></i></span>
                    </div>
                    `,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
      preConfirm: () => {
        const input = Swal.getPopup().querySelector("#codigoInput").value;
        if (!input) {
          Swal.showValidationMessage("Debe ingresar un código");
        }
        return input;
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const userCode = result.value;
        verificarCodigo(userCode).then((correcto) => {
          if (correcto) {
            const target = $(this).data("bs-target");
            $(target).data("allow-show", true);
            $(target).modal("show");
          } else {
            Swal.fire({
              icon: "error",
              title: "Código incorrecto.",
              text: "No tienes permiso para abrir esta acción.",
            });
          }
        });
      }
    });

    // Toggle password visibility
    $(document).on("click", "#togglePassword", function () {
      const input = $("#codigoInput");
      const type = input.attr("type") === "password" ? "text" : "password";
      input.attr("type", type);

      // Toggle the icon between eye and eye-slash
      const icon = $(this).find("i");
      if (icon.hasClass("bi-eye-fill")) {
        icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
      } else {
        icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
      }
    });
  });

  $("#agregar").on("show.bs.modal", function (event) {
    const allowShow = $(this).data("allow-show");
    if (!allowShow) {
      event.preventDefault();
    }
    $(this).data("allow-show", false);
  });

  function verificarCodigo(userCode) {
    return $.ajax({
      url: "",
      type: "POST",
      dataType: "JSON",
      data: {
        verificarcodigo: "mostrar",
        codigoIngresado: userCode,
      },
    })
      .then((response) => {
        return response.correcto;
      })
      .catch(() => {
        return false;
      });
  }
});

document
  .getElementById("descargarArchivoExceldeEjemplo")
  .addEventListener("click", function (event) {
    var boton = event.target;

    // Ocultar el botón
    boton.style.display = "none";

    // Ruta del archivo Excel que quieres que se descargue
    var rutaArchivo = "assets/js/estudiantes/PlantillaEjemplo.xlsx";
    console.log(rutaArchivo);

    // Crea un enlace temporal para descargar el archivo
    var enlace = document.createElement("a");
    enlace.href = rutaArchivo;
    enlace.download = "PlantillaEjemplo.xlsx";
    document.body.appendChild(enlace);
    enlace.click();
    document.body.removeChild(enlace);

    // Reaparecer el botón después de 15 segundos
    setTimeout(function () {
      boton.style.display = "inline";
    }, 15000); // 15000 milisegundos = 15 segundos
  });

$(document).ready(function () {
  let isUploading = false;
  let ajaxRequest;

  // Cuando se selecciona un archivo
  $("#file").on("change", function () {
    if ($(this).val()) {
      $("#uploadButton").prop("disabled", false);
      // Validar archivo inmediatamente cuando se selecciona
      validarArchivoAntesDeProcesar();
    } else {
      $("#uploadButton").prop("disabled", true);
    }
  });

  /**
   * Función para validar el archivo antes de procesarlo
   */
  function validarArchivoAntesDeProcesar() {
    const fileInput = document.getElementById("file");
    const file = fileInput.files[0];

    if (!file) return;

    // Crear FormData para enviar el archivo
    const formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'validar_archivo');

    // Mostrar mensaje de validación
    Swal.fire({
      title: 'Validando archivo...',
      text: 'Por favor espere mientras se valida el archivo Excel.',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Enviar archivo para validación
    $.ajax({
      url: "", // URL de tu controlador
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        try {
          const result = typeof response === 'string' ? JSON.parse(response) : response;
          
          Swal.close(); // Cerrar loading

          if (result.valido) {
            // Archivo válido - guardar los datos procesados para uso posterior
            window.datosExcelProcesados = result.datos;
            
            Swal.fire({
              icon: 'success',
              title: 'Archivo válido',
              text: 'El archivo Excel es válido y está listo para ser procesado.',
              timer: 2000,
              showConfirmButton: false
            });
            $("#uploadButton").prop("disabled", false);
          } else {
            // Archivo inválido
            Swal.fire({
              icon: 'error',
              title: 'Archivo inválido',
              text: result.mensaje,
              confirmButtonText: 'Entendido'
            });
            $("#uploadButton").prop("disabled", true);
            // Limpiar el input file
            $("#file").val('');
            // Limpiar datos procesados
            window.datosExcelProcesados = null;
          }
        } catch (e) {
          Swal.close();
          console.error('Error parsing validation response:', e);
          Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            text: 'No se pudo validar el archivo. Inténtelo nuevamente.'
          });
          $("#uploadButton").prop("disabled", true);
          $("#file").val('');
          window.datosExcelProcesados = null;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.close();
        console.error('Error en validación:', textStatus, errorThrown);
        
        let errorMsg = "Error al validar el archivo: ";
        if (jqXHR.status === 0) {
          errorMsg += "No se pudo conectar con el servidor.";
        } else if (jqXHR.status == 404) {
          errorMsg += "Recurso no encontrado (404).";
        } else if (jqXHR.status == 500) {
          errorMsg += "Error interno del servidor (500).";
        } else {
          errorMsg += jqXHR.responseText || "Error desconocido.";
        }

        Swal.fire({
          icon: 'error',
          title: 'Error de validación',
          text: errorMsg
        });
        
        $("#uploadButton").prop("disabled", true);
        $("#file").val('');
        window.datosExcelProcesados = null;
      }
    });
  }

  // Procesar el archivo cuando se envía el formulario
  $("#uploadForm").on("submit", function (event) {
    event.preventDefault();

    if (isUploading) return;

    // Confirmar antes de procesar
    Swal.fire({
      title: '¿Procesar archivo Excel?',
      text: 'Se procesarán todos los registros del archivo. Esta acción puede tomar algunos minutos.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, procesar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        procesarArchivo();
      }
    });
  });

  /**
   * Función para procesar el archivo Excel
   */
function procesarArchivo() {
    isUploading = true;
    $("#uploadButton").prop("disabled", true);
    $("#cancelButton").show();
    $(".progress").show();
    

    var file = document.getElementById("file").files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: "array" });
      var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
      var excelData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

      var headers = excelData[0];
      var jsonData = excelData.slice(1).map((row) => {
        let obj = {};
        headers.forEach((header, index) => {
          obj[header.trim()] = row[index];
        });
        return obj;
      });

      var dataToSend = JSON.stringify(jsonData);
    
      ajaxRequest = $.ajax({
        url: "", // URL del controlador
        method: "POST",
        data: { data: dataToSend},
        xhr: function () {
          var xhr = new window.XMLHttpRequest();

          xhr.onreadystatechange = function () {
            if (xhr.readyState === 3 || xhr.readyState === 4) {
              var responses = xhr.responseText.split("\n");
              responses.forEach(function (response) {
                if (response.trim() !== "") {
                  try {
                    var parsedResponse = JSON.parse(response);
                    if (parsedResponse.progress) {
                      $("#Barra_de_Proceso").css(
                        "width",
                        parsedResponse.progress + "%"
                      );
                      $("#Barra_de_Proceso").text(
                        parsedResponse.progress + "%"
                      );
                    }
                  } catch (e) {
                    console.error("Error parsing JSON:", e);
                    console.error("Response Text:", response);
                  }
                }
              });
            }
          };

          return xhr;
        },
        success: function (responseText) {

          var finalResponses = responseText.split("\n");
          var finalResponse = finalResponses[finalResponses.length - 1].trim();

          try {
            var response = JSON.parse(finalResponse);

            if (response.status === "success") {
              let message =
                "<b>Estudiantes registrados exitosamente:</b><br>" +
                response.totalProcessed +
                "<br><br>";

              if (response.alreadyRegistered.length > 0) {
                message +=
                  "<b>Cédulas con datos actualizados:</b><br>" +
                  response.alreadyRegistered.join(", ") +
                  "<br><br>";
              }

              if (response.incompleteData.length > 0) {
                message +=
                  '<b style="color:red;">Cédulas con datos incompletos:</b><br>' +
                  response.incompleteData.join(", ") +
                  "<br><br>";
              }

              // Mostrar errores de validación si existen
              if (response.errors && response.errors.length > 0) {
                message +=
                  '<b style="color:red;">Errores de validación:</b><br>' +
                  response.errors.map(error => `• ${error}`).join("<br>") +
                  "<br>";
              }

              // Determinar el ícono basado en si hay errores
              let icon = "success";
              let title = "Proceso completado";
              
              if (response.errors && response.errors.length > 0) {
                if (response.totalProcessed === 0) {
                  icon = "error";
                  title = "Proceso completado con errores";
                } else {
                  icon = "warning";
                  title = "Proceso completado con advertencias";
                }
              }

              Swal.fire({
                icon: icon,
                title: title,
                html: message,
                width: '600px', // Hacer el modal más ancho para mostrar mejor los errores
              });
            } else if (response.status === "error") {
              Swal.fire({
                icon: "error",
                title: "Error en el registro",
                text: response.message || "Hubo un problema en el servidor.",
              });
            }
          } catch (e) {
            console.error("Error parsing final JSON:", e);
            console.error("Final Response Text:", finalResponse);

            Swal.fire({
              icon: "error",
              title: "Error inesperado",
              text: "No se pudo procesar la respuesta del servidor.",
            });
          }

          resetForm();
          mostrarTabla();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          let errorMsg = "";

          if (jqXHR.status === 0) {
            errorMsg = "No se pudo conectar con el servidor. Verifique su conexión a Internet.";
          } else if (jqXHR.status == 404) {
            errorMsg = "El recurso solicitado no fue encontrado (404).";
          } else if (jqXHR.status == 500) {
            errorMsg = "Error interno del servidor (500).";
          } else if (textStatus === "parsererror") {
            errorMsg = "La respuesta JSON no pudo ser parseada.";
          } else if (textStatus === "timeout") {
            errorMsg = "El tiempo de ejecución excedió el límite permitido.";
          } else {
            errorMsg = "Error no identificado: " + jqXHR.responseText;
          }

          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: errorMsg || "Algo salió mal!",
          });

          resetForm();
          mostrarTabla();
        },
      });
      
    };

    reader.readAsArrayBuffer(file);
}

  $("#cancelButton").on("click", function () {
    Swal.fire({
      title: "¿Estás seguro de que deseas cancelar el proceso?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, cancelar",
      cancelButtonText: "No, continuar",
    }).then((result) => {
      if (result.isConfirmed) {
        if (ajaxRequest) {
          ajaxRequest.abort();
        }
        resetForm();
      }
    });
  });

  function resetForm() {
    $("#uploadForm")[0].reset();
    $("#uploadButton").prop("disabled", true);
    $("#cancelButton").hide();
    isUploading = false;
    $(".progress").hide();
    $("#Barra_de_Proceso").css("width", "0%");
    $("#Barra_de_Proceso").text("0%");
    // Limpiar datos procesados
    window.datosExcelProcesados = null;
  }
});

$("#estu1").addClass("active");
