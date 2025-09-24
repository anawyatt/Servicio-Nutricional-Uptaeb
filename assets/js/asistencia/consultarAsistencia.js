$('#as1').addClass('active');
$('#as3').addClass('text-primary');
$('.as3').addClass('active')

  // Cuando el checkbox de filtrar cambia
$('#cbx').change(function() {
    if ($(this).is(':checked')) {
        console.log('Activado');
        // Mostrar los switches
        $('#mostrar').show();
    } else {
        console.log('Desactivado');
        // Ocultar los switches
        $('#mostrar').hide();

        // Resetear selects
        $('#selectFecha').val('Seleccionar').trigger('change.select2');
        $('#selectHorario').val('Seleccionar').trigger('change.select2');

        // Ocultar sección de tabla filtrada
        $('#muestraU').hide(1000);

        // Limpiar tabla y recargar con los datos principales
        if (typeof tabla !== "undefined") {
            tabla.clear().draw();
        }

        // Llamar a la función principal
        rellenar();
    }
});

$('#mostrar').hide();

  $('#mostrar').hide();

  rellenar();
  $('#ani').hide(1000);

  let tabla = $('.tabla').DataTable({
    "columns": [
        { "data": "Cedula" },
        { 
            "data": null,
            "render": function(data, type, row) {
                return data.Nombre + ' ' + data.Apellido; 
            }
        },
        { "data": "Carrera" },
        { "data": "HorarioDeComida" }
    ]
});


  function rellenar() {
      let fecha = $('#selectFecha').val();
      let horarioComida = $('#selectHorario').val();
      $.ajax({
          method: "post",
          url: "", 
          dataType: "json",
          data: {mostrar: true, fecha, horarioComida},
          success(data) {
            console.log(data);
             $('#ani').show(2000);
            if (data.length > 0) {
              tabla.clear().rows.add(data).draw();
               $('#botonPDF').prop('disabled', false);
  
            }
            else if (data.length == 0) {
               $('#botonPDF').prop('disabled', true);
            }
             }
      });
  }

  function buscarUltimafecha() {
    $.ajax({
        method: "post",
        url: "", // <-- agrega tu ruta aquí
        dataType: "json",
        data: { mostrarUltimaVez: true },
        success(data) {
            console.log('esta es data', data);

            if (data.length > 0) {
                $('#ani').show(2000);
                let fecha = new Date(data[0].FechaAsistencia);
                let dia = fecha.getDate().toString().padStart(2, '0');
                let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                let anio = fecha.getFullYear();
                let fechaFormateada = `${dia}-${mes}-${anio}`;
                $('#ultima').val(fechaFormateada);

                tabla.clear().rows.add(data).draw();
                $('#botonPDF').prop('disabled', false);
            } else {
                $('#botonPDF').prop('disabled', true);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", status, error, xhr.responseText);
        }
    });
}


  $('#muestraU').hide(0);
  $('#ultimo_Registro').change(function() {
      if ($(this).is(':checked')) {
        console.log('entro');
          buscarUltimafecha();
          $('#muestraU').show(0);
          $('#porFecha').prop('checked', false);
          $('#porHorario').prop('checked', false);
          $('#selectHorario').hide(1000);
          $('#selectFecha').hide(1000);
      } else {
          $('#muestraU').hide(1000);
          rellenar();
      }
  });

  $('#sel2').hide(0);
  $('#porFecha').change(function() {
      if ($(this).is(':checked')) {
          $('#sel2').show(1000);
          $('#muestraU').hide(1000);
          $('#ultimo_Registro').prop('checked', false);
          $("#selectFecha").on('change', function() {
              mostrarHorarios($(this).val());
              rellenar();
          });
      } else {
          $('#selectFecha').val('Seleccionar').trigger('change.select2');
          rellenar();
          $('#sel2').hide(1000);
      }
  });

  $('#sel3').hide(0);
  $('#porHorario').change(function() {
      if ($(this).is(':checked')) {
          $('#sel3').show(1000);
          $('#muestraU').hide(1000);
          $('#ultimo_Registro').prop('checked', false);
          $("#selectHorario").on('change', function() {
              rellenar();
          });
      } else {
          $('#sel3').hide(1000);
          $('#selectHorario').val('Seleccionar').trigger('change.select2');
          rellenar();
      }
  });

  $("#selectFecha").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel2'),
      selectionCssClass: "input",
      width: '100%'
  });

  $("#selectHorario").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel3'),
      selectionCssClass: "input",
      width: '100%'
  });

  // ---------------------------MOSTRAR SELECT FECHA -------------------------------
  mostrarFechas();
  let select;
  select = $('#selectFecha');
  let input = '<option value="Seleccionar">Seleccionar</option>';

  function mostrarFechas() {
      $.ajax({
          url: '',
          type: 'POST',
          dataType: 'JSON',
          data: {select: 'mostrar'}, 
          success(response) {
              let opE = '';
              response.forEach(fila => {
                  let fecha = new Date(fila.fecha);
                  let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                  let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                  let anio = fecha.getFullYear();
                  let fechaFormateada = `${dia}-${mes}-${anio}`;
                  opE += `<option value="${fila.fecha}">${fechaFormateada}</option>`;
              });
              $('#selectFecha').html(input + opE);
          }
      });
  }

  // ---------------------------MOSTRAR SELECT HORA -------------------------------
  let select2;
  select2 = $('#selectHorario');
  let input2 = '<option value="Seleccionar">Seleccionar</option>';
  let muestraF = $('#selectFecha').val();
  mostrarHorarios(muestraF);

  function mostrarHorarios(fech) {
      let fecha = fech;
      $.ajax({
          url: '',
          type: 'POST',
          dataType: 'JSON',
          data: {select2: 'mostrar', fecha}, 
          success(response) {
              let opE = '';
              response.forEach(fila => {
                  opE += `<option value="${fila.horarioComida}">${fila.horarioComida}</option>`;
              });
              $('#selectHorario').html(input2 + opE);
          }
      });
  }

//-------------- PDF --------------------------//


// DESCARGAR PDF 2//
$(document).ready(function() {
  $('#reportebtn').click(function() {
      exportarReporte();
  });

  function exportarReporte() {
      
      $('#reportebtn').prop('disabled', true);
      $('.loadingAnimation').show();

      if ($('#ultimo_Registro').is(':checked')) {
          $.ajax({
              url: '',
              type: 'POST',
              dataType: 'JSON',
              data: { reporte2: true },
              success(data) {
                  if (data.respuesta == "guardado") {
                      console.log(data.ruta);
                      descargarArchivo(data.ruta);
                      abrirArchivo(data.ruta);
                      $('#clos').click();
                  } else {
                      console.log('ERROR');
                  }

                  
                  $('#reportebtn').prop('disabled', false);
                  $('.loadingAnimation').hide();
              },
              error() {
        
                  console.log('Error en la solicitud');
                  $('#reportebtn').prop('disabled', false);
                  $('.loadingAnimation').hide();
              }
          });
      } else {
          var fecha = $('#selectFecha').val();
          var horario = $('#selectHorario').val();
          $.ajax({
              url: '',
              type: 'POST',
              dataType: 'JSON',
              data: { reporte: true, fecha, horario },
              success(data) {
                  if (data.respuesta == "guardado") {
                      console.log(data.ruta);
                      descargarArchivo(data.ruta);
                      abrirArchivo(data.ruta);
                      $('#clos').click();
                  } else {
                      console.log('Error');
                  }
                  
                  $('#reportebtn').prop('disabled', false);
                  $('.loadingAnimation').hide();
              },
              error() {
                  
                  console.log('Error en la solicitud');
                  $('#reportebtn').prop('disabled', false);
                  $('.loadingAnimation').hide();
              }
          });
      }
  }

  function descargarArchivo(ruta) {
      let link = document.createElement('a');
      link.href = ruta;
      link.download = ruta.substr(ruta.lastIndexOf('/') + 1);
      link.click();
  }

  function abrirArchivo(ruta) {
      window.open(ruta, '_blank');
  }
});

