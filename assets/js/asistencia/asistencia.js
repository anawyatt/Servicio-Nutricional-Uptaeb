jQuery(document).ready(function(){
  $("#error1ce").hide();

  var error_cedulaEstudiantes = false;

  $("#inputCedula").focusout(function(){
    chequeo_cedulaEstudiantes();
    
  });

  $("#inputCedula").on('keyup', function(){
   clearTimeout(timer); 
         timer = setTimeout(function () {
              chequeo_cedulaEstudiantes();
         }, 500);
 });

  $(".borra").on('click', function(){
   $('.form-Study').trigger('reset');
   $('#inputCedula').val('');
   primary();
 });


  function danger(){
    $("#error1ce").show();
    $('#inputCedula').addClass('errorBorder');
    $('.bar1CE').removeClass('bar');
    $('.ic1').addClass('l');
    $('.ic1').removeClass('labelPri');
    $('.letra').addClass('labelE');
    $('.letra').removeClass('label-char');
}

function primary(){
   $("#error1ce").html("");
   $("#error1ce").hide();
   $('#inputCedula').removeClass('errorBorder');
   $('.bar1CE').addClass('bar');
   $('.ic1').removeClass('l');
   $('.ic1').addClass('labelPri');
   $('.letra').removeClass('labelE');
   $('.letra').addClass('label-char');
}

  function chequeo_cedulaEstudiantes() {
      var campo = /^[0-9]{6,8}$/
      var cedulaEstudiantes = $("#inputCedula").val();
      if (campo.test(cedulaEstudiantes) && cedulaEstudiantes !== ''){
         $("#error1ce").html("");
         $("#error1ce").hide();
         $('#inputCedula').removeClass('errorBorder');
         $('.bar1CE').addClass('bar');
         $('.ic1').removeClass('l');
         $('.ic1').addClass('labelPri');
         $('.letra').removeClass('labelE');
         $('.letra').addClass('label-char');
      }else{
         $("#error1ce").show();
         $("#error1ce").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la Cédula del Estudiante');
         $('#inputCedula').addClass('errorBorder');
         $('.bar1CE').removeClass('bar');
         $('.ic1').addClass('l');
         $('.ic1').removeClass('labelPri');
         $('.letra').addClass('labelE');
         $('.letra').removeClass('label-char');
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<b class="text-rojo"> Ingrese la Cedula!</b>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
              })
         error_cedulaEstudiantes = true;
      }}

    
  let id;
  let estudianteId;
  let menuId;
  
  $(document).on('click', '.buscar', function () {

    error_cedulaEstudiantes = false;
    chequeo_cedulaEstudiantes();

    if(error_cedulaEstudiantes === false){
           id = $("#inputCedula").val(); 
           buscarEstudiante(id);
    }
  });

  function buscarEstudiante(id) {
    console.log('Buscando estudiante con cédula:', id);
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: {verEstudiantes: true, id: id},
        success(data) {
            console.log(data);
            if (data.length > 0) {
                $("#nombre").val(data[0].nombre);
                $("#segundoNombre").val(data[0].segNombre);
                $("#apellido").val(data[0].apellido);
                $("#segundoApellido").val(data[0].segApellido);
                if (data[0].sexo == 'F') {
                  $("#sexo").val('Femenino');
                }
                if (data[0].sexo == 'M') {
                  $("#sexo").val('Maculino');
                }
                $("#telefono").val(data[0].telefono);
                $("#carrera").val(data[0].carrera);
                $("#seccion").val(data[0].seccion);
                $("#horario").val(data[0].horario);
                estudianteId = id;
                primary()
            } else {
              danger()
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'No se encontró ningún estudiante con la cedula <b class="fw-bold text-rojo"> V-'+ id +'</b>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
              })

              $("#error1ce").html('<i  class="bi bi-exclamation-triangle-fill"></i> No existe esta cedula!');
              $("#error1ce").show();
                console.log('No se encontró ningún estudiante con esa cédula.');
                $('.form-Study').trigger('reset');
            }
        },
        error(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
  }



//////////////////////////////////////////CAMARA QR/////////////////////////////////////
let scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    mirror: true,
    captureImage: false,
    backgroundScan: true,
    refractoryPeriod: 2000,
  });
  
  let cameras = [];
  
  function getCameras() {
    return Instascan.Camera.getCameras().then(function(availableCameras) {
        if (availableCameras.length > 0) {
            cameras = availableCameras;
            console.log("Cámaras disponibles:", cameras);
        } else {
            console.error('No se encontraron cámaras.');
        }
    }).catch(function(e) {
        console.error("Error al obtener las cámaras:", e);
    });
  }
  
  function startCamera() {
    if (cameras.length > 0) {
        scanner.start(cameras[0]).catch(function(err) {
            console.error("Error al iniciar la cámara:", err);
            showErrorMessage(); // Mostrar mensaje de error
            setTimeout(startCamera, 2000); // Intenta reiniciar la cámara después de 2 segundos
        });
    } else {
        console.error('No hay cámaras disponibles para iniciar.');
        showErrorMessage(); // Mostrar mensaje de error
    }
  }
  
  function stopCamera() {
    scanner.stop().then(() => {
        console.log("Cámara apagada.");
    }).catch(err => {
        console.error("Error al detener la cámara:", err);
    });
  }
  
  function showErrorMessage() {
    $("#error-message").show(); // Mostrar el mensaje de error
    $(".contenedor").show(); // Asegurar que el contenedor esté visible
  }
  
  $("#flexSwitchCheckDefault").change(function() {
    if ($(this).is(':checked')) {
        startCamera();
        console.log("Cámara encendida.");
        $(".contenedor").show(); 
    } else {
        stopCamera();
        $(".contenedor").hide(); 
    }
  });
  
  scanner.addListener('scan', function(content) {
    
    var sonido = $("#lectura")[0];
    sonido.play();
  
    
    $("#qr-detection").removeClass("hidden");
    setTimeout(() => {
        $("#qr-detection").addClass("hidden");
    }, 2000); 
  
    
    var cedula = content.match(/^\d+/)[0];
    
    $(".input.cedula").val(cedula);
    buscarEstudiante(cedula);  
    $("#flexSwitchCheckDefault").prop('checked', false); 
    $("#flexSwitchCheckDefault").change();  
  });
  
  // Inicializar cámaras al cargar la página
  getCameras().then(() => {
    if ($("#flexSwitchCheckDefault").is(':checked')) {
        startCamera();
    }
  });
  
//////////////////////////////////////////fin QR/////////////////////////////////////



$(document).ready(function() {
    $('a.protected').click(function(event) {
        event.preventDefault();

        Swal.fire({
            title: '<h5 class="azul5 mt-2">Ingrese el código De seguridad</h5>',
            html: `
            <div class="input-group">
                <input type="password" class="form-control" id="codigoInput" placeholder="Código">
                <h4 class="input-group-text bg-primary blanco" type="button" id="togglePassword"><i class="bi bi-eye-fill"></i></h4>
            </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const input = Swal.getPopup().querySelector('#codigoInput').value;
                if (!input) {
                    Swal.showValidationMessage('Debe ingresar un código');
                }
                return input;
            },
            didRender: () => {
               
                $('#togglePassword').off('click').on('click', function() {
                    const input = $('#codigoInput');
                    const type = input.attr('type') === 'password' ? 'text' : 'password';
                    input.attr('type', type);
                    const icon = $(this).find('i');
                    if (icon.hasClass('bi-eye-fill')) {
                        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                    } else {
                        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const userCode = result.value;
                verificarCodigo(userCode).then(correcto => {
                    if (correcto) {
                        const target = $(this).data('bs-target');
                        $(target).data('allow-show', true); // Marcamos que está permitido mostrar el modal
                        $(target).modal('show');
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
    });

    $('#estudiantes').on('show.bs.modal', function(event) {
        const allowShow = $(this).data('allow-show');
        if (!allowShow) {
            event.preventDefault(); // Evita que el modal se abra
        }
        $(this).data('allow-show', false); // Reinicia la bandera
    });

    $('#justificativo').on('show.bs.modal', function(event) {
        const allowShow = $(this).data('allow-show');
        if (!allowShow) {
            event.preventDefault(); // Evita que el modal se abra
        }
        $(this).data('allow-show', false); // Reinicia la bandera
    });

    function verificarCodigo(userCode) {
        return $.ajax({
            url: '',
            type: 'POST',
            dataType: 'JSON',
            data: {
                verificarcodigo: 'mostrar',
                codigoIngresado: userCode
            }
        }).then(response => {
            return response.correcto;
        }).catch(() => {
            return false;
        });
    }
});








document.addEventListener('DOMContentLoaded', function() {
  const readOnlyInputs = document.querySelectorAll('.readonly-input');
  readOnlyInputs.forEach(function(input) {
      input.setAttribute('readonly', 'readonly');
      input.addEventListener('keydown', function(e) {
          e.preventDefault();
      });
      input.addEventListener('paste', function(e) {
          e.preventDefault();
      });
  });
});

/* Registros Y validaciones De asistencia */

  let horario; 


  // Vincular la función de búsqueda al evento change de los checkboxes
  $('input[name="opcion"]').change(function() {
      // Desmarcar otros checkboxes y obtener el valor seleccionado
      $('input[name="opcion"]').not(this).prop('checked', false);
      horario = $(this).val();
      
      if ($(this).is(':checked')) {
        obtenerPlatosDisponibles();
          if (horario) {
              idMenu();
          } else {
              console.log('No se seleccionó ningún menú');
              $('#contador-container').hide();
          }
      } else {
        $('#contador-container').hide();
        
      }
  });

function idMenu() {
      var horario = $('input[name="opcion"]:checked').val();
      console.log('horario de comida', horario);
      $.ajax({
          method: "post",
          url: "", 
          dataType: "json",
          data: { vermenu: true, horario: horario },
          success: function(data) {
              console.log(data);
              if (data.length > 0) {
                
                  menuId = data[0].idMenu;
                  console.log('ID del menú:', menuId);
              } else {
                  Swal.fire({
                      title: "¡Menú No Disponible!",
                      text: "El Horario que fue Selecionado No se Encuentra Disponible, Verifique si Hay un Menú Planificado para Hoy",
                      icon: "error"
                  });
              }
          },
      });
  }

  let error_val = false;
  let error_Hor = false;
  
  function validarQueNoSeRepita(callback) {
      $.ajax({
          type: "POST",
          url: "",
          dataType: 'JSON',
          data: {
              verificar: true,
              horarioComida: horario,
              id: estudianteId
          },
          success: function(data) {
             
              if (data.resultado === 'ya ingreso al comedor') {
                  Swal.fire({
                      title: "¡Ingreso No Permitido!",
                      text: "Este Estudiante Ya Ingresó al Comedor.",
                      icon: "error"
                  });
                  error_val = true;
                  callback(false);
              } else {
                  error_val = false;
                  callback(true);
              }
          }
      }); 
  }
  
  function validarPorhorario(callback) {
      $.ajax({
          type: "POST",
          url: "",
          dataType: 'JSON',
          data: {
              verificar: true,
              id: estudianteId
          },
          success: function(data) {
            
              if (data.resultado === 'no puede comer'){

                  Swal.fire({
                      title: "¡Horario De Clase No Disponible!",
                      text: "El Estudiante No puede Acceder al Comedor ya que no le Corresponde por su Horario",
                      icon: "error"
                  });
                  error_Hor = true;
                  callback(false);
              } else {
                  error_Hor = false;
                  callback(true);
              }
          }
      }); 
  }
  
  function registrar() {
      $(document).on('click', '.confirmar', function () {
        var id = $('#inputCedula').val(); 
        var horario = $('input[name="opcion"]:checked').val();
        let token= $('input[name="csrf_token"]').val();
        if (!id || !horario) {
            Swal.fire({
                title: "Datos incompletos",
                text: "Por favor, ingresa la cédula y selecciona un horario de comida.",
                icon: "warning"
            });
            return; 
        }
        console.log('token csrf:', token);
          validarQueNoSeRepita(function (validar1) {
              if (validar1) {
                  validarPorhorario(function (validar2) {
                      if (validar2) {
                          var platosDisponibles = parseInt($('#comidaDisponible').val());
                          if (platosDisponibles > 0) {
                              Swal.fire({
                                  title: "¿Estás seguro?",
                                  text: "Confirma si los datos del estudiante son correctos",
                                  icon: "warning",
                                  showCancelButton: true,
                                  confirmButtonColor: "#3085d6",
                                  cancelButtonColor: "#d33",
                                  confirmButtonText: "Confirmar"
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      $.ajax({
                                          type: "POST",
                                          url: "",
                                          dataType: 'JSON',
                                          data: {
                                              registrar: true,
                                              id: estudianteId,
                                              idmenu: menuId,
                                              csrfToken: token
                                          },
                                          success: function(data) {
                                              if (data.mensaje.resultado === 'registro exitoso' && data.newCsrfToken) {
                                                  Swal.fire({
                                                      title: "¡Éxito!",
                                                      text: "El Estudiante puede acceder al Comedor",
                                                      icon: "success",
                                                      scrollbarPadding: false,
                                                  });
                                                  $('.form-Study').trigger('reset');
                                                  $('#inputCedula').val('');
                                                  $('[name="csrf_token"]').val(data.newCsrfToken);
                                                  obtenerPlatosDisponibles();
                                              } else {
                                                  Swal.fire({
                                                      title: "Error",
                                                      text: "No se pudo registrar la asistencia",
                                                      icon: "error"
                                                  });
                                              }
                                          },
                                          error: function(jqXHR, textStatus, errorThrown) {
                                              Swal.fire({
                                                  title: "Error",
                                                  text: "Hubo un problema con la solicitud. Asegúrate de que los campos de cédula y menú estén seleccionados.",
                                                  icon: "error"
                                              });
                                          }
                                      });
                                  }
                              });
                          } else {
                              Swal.fire({
                                  title: "Límite alcanzado",
                                  text: "Haz alcanzado el límite de platos disponibles, no puedes acceder más estudiantes al comedor.",
                                  icon: "warning"
                              });
                          }
                      }
                  });
              }
          });
      });
  }



  

registrar();

function obtenerPlatosDisponibles() {
    var horario = $('input[name="opcion"]:checked').val();
    if (!horario) {
        console.log("No se ha seleccionado un horario.");
        return;
    }

    $.ajax({
        method: "POST",
        url: "", 
        dataType: "json",
        data: {
            verPlatosDisponibles: true,
            horarioComida: horario
        },
        success: function(data) {
            console.log("Platos disponibles:", data);
            if (data.length > 0) {
                var platosDisponibles = data[0].platosDisponibles;
                $('#comidaDisponible').val(platosDisponibles);
                $('#contador-container').show();

                if (platosDisponibles == 0) {
                    Swal.fire({
                        title: "Límite alcanzado",
                        text: "Haz alcanzado el límite de platos disponibles, no puedes acceder más estudiantes al comedor.",
                        icon: "warning"
                    });
                    $('.confirmar').prop('disabled', true);
                } else {
                    $('.confirmar').prop('disabled', false);
                }
            } else {
                console.log("No hay datos disponibles.");
                $('#contador-container').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
            $('#contador-container').hide();
        }
    });
 }








/* Excepcion 1 */

mostrarNucleo()
let select3;
select3=$('#nucleoStudy');
let input3;
input3= ' <option value="Seleccionar"> Seleccionar Nucleo</option>';
function mostrarNucleo(){
    $.ajax({
    url: '',
    type: 'POST',
    dataType: 'JSON',
    data: {select3: 'mostrar'}, 
    success(response){
        let opE = '';
        response.forEach(fila => {
        opE += `<option  value="${fila.nucleo}">${fila.nucleo}</option> `
        })
        $('#nucleoStudy').html(input3 + opE);
        }
    })
}

$(document).ready(function() {
    $("#nucleoStudy").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#selectC'),
        selectionCssClass: "input",
        width: '100%'
    });


});


mostrarCarreras()
let select2;
select2=$('#carreraStudy');
let input2;
input2= ' <option value="Seleccionar"> Seleccionar Carrera</option>';

function mostrarCarreras(){
    $.ajax({
    url: '',
    type: 'POST',
    dataType: 'JSON',
    data: {select2: 'mostrar'}, 
    success(response){
        let opE = '';
        response.forEach(fila => {
        opE += `<option  value="${fila.carrera}">${fila.carrera}</option> `
        })
        $('#carreraStudy').html(input2 + opE);
        }
    })
}

$(document).ready(function() {
    $("#carreraStudy").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#selectC'),
        selectionCssClass: "input",
        width: '100%'
    });

    $("#sexoStudy").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#selS'),
        selectionCssClass: "input",
        width: '100%'
    });



});




$(document).ready(function() {
  // Cuando el checkbox cambia
  $('#mostrarOtraSecion').change(function() {
      if ($(this).is(':checked')) {
          // Mostrar el select
          $('#selectS2').show();
          mostrarSeccion('#seccionStudy2');
      } else {
          // Ocultar el select
          $('#selectS2').hide();
          $('#seccionStudy2').val('Seleccionar').trigger('change');
          $('#horariosContainer').find('.horario-section-2').remove();
      }
  });

  // Inicializar en oculto por defecto
  $('#selectS2').hide();

  // Llamar a la función mostrarSeccion para el primer select
  mostrarSeccion('#seccionStudy');

  // Inicializar Select2 para el primer select
  $("#seccionStudy").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#selectS'),
      selectionCssClass: "input",
      width: '100%'
  });

  // Inicializar Select2 para el segundo select
  $("#seccionStudy2").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#selectS2'),
      selectionCssClass: "input",
      width: '100%'
  });

  // Añadir eventos de cambio para ambos selects
  $('#seccionStudy').change(function() {
      var seccion = $(this).val();
      if (seccion !== 'Seleccionar') {
          mostrarHorarios(seccion, 1);
      } else {
          $('#horariosContainer').find('.horario-section-1').remove();
      }
  });

  $('#seccionStudy2').change(function() {
      var seccion = $(this).val();
      if (seccion !== 'Seleccionar') {
          mostrarHorarios(seccion, 2);
      } else {
          $('#horariosContainer').find('.horario-section-2').remove();
      }
  });

  function mostrarSeccion(selectId) {
      $.ajax({
          url: '',
          type: 'POST',
          dataType: 'JSON',
          data: { select: 'mostrar' },
          success(response) {
              let opE = '';
              response.forEach(fila => {
                  opE += `<option value="${fila.idSeccion}">${fila.seccion} </option>`;
              });
              $(selectId).html('<option value="Seleccionar">Seleccionar Sección</option>' + opE);
          }
      });
  }

  function mostrarHorarios(seccion, sectionNumber) {
      $.ajax({
          method: "POST",
          url: "", 
          dataType: "json",
          data: { mostrarHorario: true, seccion: seccion },
          success(data) {
              if (data.length > 0) {
                  let horarioHtml = `<div class="horario-section-${sectionNumber}">
                      <p>Sección ${sectionNumber}: ${data[0].seccion}</p>
                      <spam>Horario: ${data[0].horario}</spam>
                  </div>`;
                  $('#horariosContainer').find(`.horario-section-${sectionNumber}`).remove();
                  $('#horariosContainer').append(horarioHtml);
              } else {
                  console.log('No se seleccionó ninguna sección.');
                  $('#horariosContainer').find(`.horario-section-${sectionNumber}`).remove();
              }
          },
          error(xhr, status, error) {
              console.error("Error en la solicitud AJAX:", status, error);
          }
      });
  }
});



// Función para mostrar las secciones


//----------------------- EXCEPCIÓN 1 --------------------------
let error_cedula =false;
let error_nombre=false;
let error_apellido=false;
let error_sexo =false;
let error_nucleo =false;
let error_carrera=false;
let error_seccion = false;
let error_seccion2=false;
let error_justificativo=false;
let error_veriCE=false;


 

 $("#cedulaStudy").focusout(function(){
    chequeo_cedula();
     verificarCedula();
   });
   $("#cedulaStudy").on('keyup', function() {
    
    learTimeout(timer); 
         timer = setTimeout(function () {
           chequeo_cedula();
    verificarCedula();
         }, 500);
   });
$("#nombreStudy").focusout(function(){
    chequeo_nombre();
   });
   $("#nombreStudy").on('keyup', function(){
    chequeo_nombre();
   });
$("#apellidoStudy").focusout(function() {
    chequeo_apellido();
   });
   $("#apellidoStudy").on('keyup', function() {
    chequeo_apellido();
   });

   $("#sexoStudy").focusout(function() {
    chequeo_sexo();
   });
   
   $("#sexoStudy").on('change', function() {
    chequeo_sexo();
   });

 $("#nucleoStudy").focusout(function() {
    chequeo_nucleo();
   });
   
   $("#nucleoStudy").on('change', function() {
    chequeo_nucleo();
   });

    $("#carreraStudy").focusout(function() {
    chequeo_carrera();
   });
   $("#carreraStudy").on('change', function() {
    chequeo_carrera();
   });

    $("#seccionStudy").focusout(function() {
    chequeo_seccion();
   });
   $("#seccionStudy").on('change', function() {
    chequeo_seccion();
   });

    $('#mostrarOtraSecion').change(function() {
        if ($(this).is(':checked')) {

        $("#seccionStudy2").focusout(function() {
          chequeo_seccion2();
        });
        $("#seccionStudy2").on('change', function() {
           chequeo_seccion2();
        });
      }
    });


   $("#justificativo").focusout(function(){
    chequeo_justificativo();
   });
   $("#justificativo2").on('keyup', function(){
    chequeo_justificativo();
   });

$(".borrarE1").on('click', function(){
   primaryE1()
   $('.formu').trigger('reset');
});

   $("#registrarE1").on('click', function() {
    error_cedula =false;
    error_nombre=false;
    error_apellido=false;
    error_sexo =false;
    error_nucleo =false;
    error_carrera=false;
    error_seccion = false;
    error_seccion2=false;
    error_justificativo=false;
    error_veriCE=false;
    chequeo_cedula()
    chequeo_nombre()
    chequeo_apellido()
    chequeo_sexo() 
    chequeo_nucleo()
    chequeo_carrera()
    chequeo_seccion()
    chequeo_seccion2()
    chequeo_justificativo()
    verificarCedula()

    if (error_cedula === false && error_nombre === false && error_apellido == false && error_sexo == false && error_nucleo == false && error_carrera == false && error_seccion == false && error_seccion2 == false && error_justificativo == false && error_veriCE=== false) {
      registrarExcepcion1();
    }
    else{
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon:'error',
        title:'<b class="text-rojo">Ingrese los Datos!</b>',
        showConfirmButton:false,
        timer:3000,
        timerProgressBar:3000,
      })
    }

   });

//---- VALIDACIONES --------


 function chequeo_cedula() {
    var campo = /^[0-9]{6,8}$/;
      var cedula = $("#cedulaStudy").val();
      if (campo.test(cedula) && cedula !== ''){
         $(".error1e").html("");
         $(".error1e").hide();
         $('#cedulaStudy').removeClass('errorBorder');
         $('.bar1e').addClass('bar');
         $('.ic1e').removeClass('l');
         $('.ic1e').addClass('labelPri');
         $('.letra1e').removeClass('labelE');
         $('.letra1e').addClass('label-char');
      }else{
         $(".error1e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cédula de identidad!');
         $(".error1e").show();
         $('#cedulaStudy').addClass('errorBorder');
         $('.bar1e').removeClass('bar');
         $('.ic1e').addClass('l');
         $('.ic1e').removeClass('labelPri');
         $('.letra1e').addClass('labelE');
         $('.letra1e').removeClass('label-char');
         error_cedula = true;
      }
      }

      function chequeo_nombre() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var nombre = $("#nombreStudy").val();
        if (chequeo.test(nombre) && nombre !== '') {
         $(".error2e").html("");
         $(".error2e").hide();
         $('#nombreStudy').removeClass('errorBorder');
         $('.bar2e').addClass('bar');
         $('.ic2e').removeClass('l');
         $('.ic2e').addClass('labelPri');
         $('.letra2e').removeClass('labelE');
         $('.letra2e').addClass('label-char');
        } else {
         $(".error2e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el nombre!');
         $(".error2e").show();
         $('#nombreStudy').addClass('errorBorder');
         $('.bar2e').removeClass('bar');
         $('.ic2e').addClass('l');
         $('.ic2e').removeClass('labelPri');
         $('.letra2e').addClass('labelE');
         $('.letra2e').removeClass('label-char');
           error_nombre = true;
        }
      }

       function chequeo_apellido() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var apellido = $("#apellidoStudy").val();
        if (chequeo.test(apellido) && apellido !== '') {
         $(".error3e").html("");
         $(".error3e").hide();
         $('#apellidoStudy').removeClass('errorBorder');
         $('.bar3e').addClass('bar');
         $('.ic3e').removeClass('l');
         $('.ic3e').addClass('labelPri');
         $('.letra3e').removeClass('labelE');
         $('.letra3e').addClass('label-char');
        } else {
         $(".error3e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el apellido!');
         $(".error3e").show();
         $('#apellidoStudy').addClass('errorBorder');
         $('.bar3e').removeClass('bar');
         $('.ic3e').addClass('l');
         $('.ic3e').removeClass('labelPri');
         $('.letra3e').addClass('labelE');
         $('.letra3e').removeClass('label-char');
           error_apellido = true;
        }
      }

      function chequeo_sexo() { 
        var sexo = $("#sexoStudy").val();
        if (sexo != 'Seleccionar') {
         $(".errorsexo").html("");
         $(".errorsexo").hide();
         $('#sexoStudy').removeClass('is-invalid');
         $('.bar4e').addClass('bar');
         $('.ic4eS').removeClass('l');
         $('.ic4eS').addClass('labelPri');
         $('.letra4e').removeClass('labelE');
         $('.letra4e').addClass('label-char');
        } else {
         $(".errorsexo").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el Sexo!');
         $(".errorsexo").show();
         $('#sexoStudy').addClass('is-invalid');
         $('.bar4e').removeClass('bar');
         $('.ic4eS').addClass('l');
         $('.ic4eS').removeClass('labelPri');
         $('.letra4e').addClass('labelE');
         $('.letra4e').removeClass('label-char');
           error_sexo = true;
        }
      }


      function chequeo_nucleo() { 
        var nucleo = $("#nucleoStudy").val();
        if (nucleo != 'Seleccionar') {
         $(".error42e").html("");
         $(".error42e").hide();
         $('#nucleoStudy').removeClass('is-invalid');
         $('.bar42e').addClass('bar');
         $('.ic42e').removeClass('l');
         $('.ic42e').addClass('labelPri');
         $('.letra42e').removeClass('labelE');
         $('.letra42e').addClass('label-char');
        } else {
         $(".error42e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el Nucleo Donde Pertenece El estudainte!');
         $(".error42e").show();
         $('#nucleoStudy').addClass('is-invalid');
         $('.bar42e').removeClass('bar');
         $('.ic42e').addClass('l');
         $('.ic42e').removeClass('labelPri');
         $('.letra42e').addClass('labelE');
         $('.letra42e').removeClass('label-char');
           error_nucleo = true;
        }
      }

      function chequeo_carrera() { 
        var carrera = $("#carreraStudy").val();
        if (carrera != 'Seleccionar') {
         $(".error5e").html("");
         $(".error5e").hide();
         $('#carreraStudy').removeClass('is-invalid');
         $('.bar5e').addClass('bar');
         $('.ic5e').removeClass('l');
         $('.ic5e').addClass('labelPri');
         $('.letra5e').removeClass('labelE');
         $('.letra5e').addClass('label-char');
        } else {
         $(".error5e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione La Carrera La cual Pertecene El Estudiante!');
         $(".error5e").show();
         $('#carreraStudy').addClass('is-invalid');
         $('.bar5e').removeClass('bar');
         $('.ic5e').addClass('l');
         $('.ic5e').removeClass('labelPri');
         $('.letra5e').addClass('labelE');
         $('.letra5e').removeClass('label-char');
           error_carrera = true;
        }
      }

      function chequeo_seccion() { 
        var seccion = $("#seccionStudy").val();
        if (seccion != 'Seleccionar') {
         $(".error6e").html("");
         $(".error6e").hide();
         $('#seccionStudy').removeClass('is-invalid');
         $('.bar6e').addClass('bar');
         $('.ic6e').removeClass('l');
         $('.ic6e').addClass('labelPri');
         $('.letra6e').removeClass('labelE');
         $('.letra6e').addClass('label-char');
        } else {
         $(".error6e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione La Seccion Que pertenece el Estudiante!');
         $(".error6e").show();
         $('#seccionStudy').addClass('is-invalid');
         $('.bar6e').removeClass('bar');
         $('.ic6e').addClass('l');
         $('.ic6e').removeClass('labelPri');
         $('.letra6e').addClass('labelE');
         $('.letra6e').removeClass('label-char');
           error_seccion = true;
        }
      }

      function chequeo_seccion2() { 
        var seccion2 = $("#seccionStudy2").val();
        var checkbox = $("#mostrarOtraSecion").is(':checked'); // Verifica si el checkbox está seleccionado
    
        if (checkbox) { // Solo validar si el checkbox está seleccionado
            if (seccion2 != 'Seleccionar') {
                $(".error7e").html("");
                $(".error7e").hide();
                $('#seccionStudy2').removeClass('is-invalid');
                $('.bar7e').addClass('bar');
                $('.ic7e').removeClass('l');
                $('.ic7e').addClass('labelPri');
                $('.letra7e').removeClass('labelE');
                $('.letra7e').addClass('label-char');
                error_seccion2 = false;
            } else {
                $(".error7e").html('<i class="bi bi-exclamation-triangle-fill"></i> Seleccione la sección a la que pertenece el estudiante');
                $(".error7e").show();
                $('#seccionStudy2').addClass('is-invalid');
                $('.bar7e').removeClass('bar');
                $('.ic7e').addClass('l');
                $('.ic7e').removeClass('labelPri');
                $('.letra7e').addClass('labelE');
                $('.letra7e').removeClass('label-char');
                error_seccion2 = true;
            }
        } else {
            // Si el checkbox no está seleccionado, restablece el campo y oculta errores
            $(".error7e").html("");
            $(".error7e").hide();
            $('#seccionStudy2').removeClass('is-invalid');
            $('.bar7e').removeClass('bar');
            $('.ic7e').removeClass('l');
            $('.ic7e').removeClass('labelPri');
            $('.letra7e').removeClass('labelE');
            $('.letra7e').addClass('label-char');
            error_seccion2 = false; // No hay error porque la selección no es obligatoria
        }
    }
    
      function chequeo_justificativo() {
        var chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
        var justificativo = $("#justificativo2").val();
        if (chequeo.test(justificativo) && justificativo !== '') {
         $(".error8e").html("");
         $(".error8e").hide();
         $('#justificativo2').removeClass('errorBorder');
         $('.bar8e').addClass('bar');
         $('.ic8e').removeClass('l');
         $('.ic8e').addClass('labelPri');
         $('.letra8e').removeClass('labelE');
         $('.letra8e').addClass('label-char');
        } else {
         $(".error8e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción!');
         $(".error8e").show();
         $('#justificativo2').addClass('errorBorder');
         $('.bar8e').removeClass('bar');
         $('.ic8e').addClass('l');
         $('.ic8e').removeClass('labelPri');
         $('.letra8e').addClass('labelE');
         $('.letra8e').removeClass('label-char');
           error_justificativo = true;
        }
    }

             function verificarCedula(){
                     let cedula = $("#cedulaStudy").val();
                     if (cedula.length > 5) {
                       $.ajax({
                              type: "POST",
                              url: '',
                              dataType: "json",
                              data:{ mostrarC:'si', 
                                 cedula
                               },
                              success(date){
              
                                 if (date.resultado === "error Cedula"){
                                    Swal.fire({
                                      toast: true,
                                      position: 'top-end',
                                      icon:'error',
                                      title:'La Cedula  <b class="fw-bold text-rojo"> V-'+cedula+'</b> ya está registrada, ingrese otra Cedula!',
                                      showConfirmButton:false,
                                      timer:3000,
                                      timerProgressBar:3000,
                                    })
                                    $(".error1e").html('<i  class="bi bi-exclamation-triangle-fill"></i> La cedula ya existe!');
                                    $(".error1e").show();
                                    $('#cedulaStudy').addClass('errorBorder');
                                    $('.bar1e').removeClass('bar');
                                    $('.ic1e').addClass('l');
                                    $('.ic1e').removeClass('labelPri');
                                    $('.letra1e').addClass('labelE');
                                    $('.letra1e').removeClass('label-char');
                                    error_veriCE = true;
                                
                                 }
                                 else{
                                    $(".error1e").hide();
                                    $('#cedulaStudy').removeClass('errorBorder');
                                    $('.bar1e').addClass('bar');
                                    $('.ic1e').removeClass('l');
                                    $('.ic1e').addClass('labelPri');
                                    $('.letra1e').removeClass('labelE');
                                    $('.letra1e').addClass('label-char');
                                  }
                                   
                                }
                              })
                           }
              
                          }



function primaryE1(){
         $(".errorsexo, .error1e, .error2e, .error3e, .error4e, .error42e, .error5e, .error6e, .error7e, .error8e").html("");
         $(".errorsexo, .error1e, .error2e, .error3e, .error4e, .error42e, .error5e, .error6e, .error7e, .error8e").hide();
         $('#cedulaStudy, #nombreStudy, #apellidoStudy, #justificativo2').removeClass('errorBorder');
         $('#sexoStudy, #nucleoStudy, #carreraStudy, #seccionStudy, #seccionStudy2').removeClass('is-invalid');
         $('.bar1e, .bar2e, .bar3e, .bar4e, .bar42e, .bar5e, .bar6e, .bar7e, .bar8e').addClass('bar');
         $('.ic1e, .ic2e, .ic3e, .ic4e, .ic42e, .ic5e, .ic6e, .ic7e, .ic8e, ic4eS').removeClass('l');
         $('.ic1e, .ic2e, .ic3e, .ic4e, .ic42e, .ic5e, .ic6e, .ic7e, .ic8e, ic4eS').addClass('labelPri');
         $('.letra1e, .letra2e, .letra3e, .letra4e, .letra42e, .letra5e, .letra6e, .letra7e, .letra8e').removeClass('labelE');
         $('.letra1e, .letra2e, .letra3e, .letra4e, .letra42e, .letra5e, .letra6e, .letra7e, .letra8e').addClass('label-char');
          $('#sexoStudy, #nucleoStudy, #carreraStudy, #seccionStudy, #seccionStudy2').val('Seleccionar').trigger('change.select2');
}

function registrarExcepcion1() {
    $("#registrarE1").prop("disabled", true); 

    let cedula = $('#cedulaStudy').val();
    let nombre = $('#nombreStudy').val();
    let apellido = $('#apellidoStudy').val();
    let sexo = $('#sexoStudy').val();
    let nucleo = $('#nucleoStudy').val();
    let carrera = $('#carreraStudy').val();
    let seccion = $('#seccionStudy').val();
    let seccion2 = $('#seccionStudy2').val();
    let justificativo = $('#justificativo2').val();
    let token= $('input[name="csrf_token"]').val();

    $.ajax({
        type: "POST",
        url: "", 
        dataType: "json",
        data: {
            cedula, 
            nombre, 
            apellido,
            sexo, 
            nucleo, 
            carrera, 
            seccion, 
            seccion2, 
            justificativo,
            csrfToken: token,
            excepcion1: true
        },
        beforeSend: function() {
            
            $("#registrarE1").prop("disabled", true);
        },
        success: function(data) {
            if(data.mensaje.resultado == 'registro del Estudiante' && data.newCsrfToken) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'El Estudiante <b class="text-primary fw-bold">' + nombre + ' ' + apellido + '</b> Registrado Exitosamente!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });
            $('.formu').trigger('reset'); 
            $('#nucleoStudy').val('Seleccionar').trigger('change.select2');
            $('#carreraStudy').val('Seleccionar').trigger('change.select2');
            $('#seccionStudy').val('Seleccionar').trigger('change.select2');
            $('#seccionStudy2').val('Seleccionar').trigger('change.select2');
            $('#horariosContainer').empty();
            $('input[name="csrf_token"]').val(data.newCsrfToken);
            $('#cerrar').click();
        }
            
        },
        complete: function() {
            $("#registrarE1").prop("disabled", false);
        }
    });
}




//-------------- Excepcion 2 ----------------

 $("#cedula2").focusout(function(){
     verificarCedula2();
     chequeo_cedula2();
   });

 $("#cedula2").on('keyup', function() {
    
    clearTimeout(timer); 
         timer = setTimeout(function () {
             chequeo_cedula2();
    verificarCedula2();
         }, 500);

   });

   $("#justificativo3").focusout(function(){
    chequeo_Justificativo3();
   });
   $("#justificativo3").on('keyup', function(){
    chequeo_Justificativo3();
   });

   let error_justificativo4 = false;
   let error_cedula22=false;

   function chequeo_Justificativo3() {
    var chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
    var justificativo3 = $("#justificativo3").val();
    if (chequeo.test(justificativo3) && justificativo3 !== '') {
     $(".error9J").html("");
     $(".error9J").hide();
     $('#justificativo3').removeClass('errorBorder');
     $('.bar8e').addClass('bar');
     $('.ic22').removeClass('l');
     $('.ic22').addClass('labelPri');
     $('.letra22').removeClass('labelE');
     $('.letra22').addClass('label-char');
    } else {
     $(".error9J").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción!');
     $(".error9J").show();
     $('#justificativo3').addClass('errorBorder');
     $('.bar8e').removeClass('bar');
     $('.ic22').addClass('l');
     $('.ic22').removeClass('labelPri');
     $('.letra22').addClass('labelE');
     $('.letra22').removeClass('label-char');
       error_justificativo4 = true;
    }
}


function chequeo_cedula2() {
    var campo = /^[0-9]{6,8}$/;
      var cedula = $("#cedula2").val();
      if (campo.test(cedula) && cedula !== ''){
         $(".error9e").html("");
         $(".error9e").hide();
         $('#cedula2').removeClass('errorBorder');
         $('.bar9e').addClass('bar');
         $('.ic9e').removeClass('l');
         $('.ic9e').addClass('labelPri');
         $('.letra9e').removeClass('labelE');
         $('.letra9e').addClass('label-char');
      }else{
         $(".error9e").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cédula de identidad!');
         $(".error9e").show();
         $('#cedula2').addClass('errorBorder');
         $('.bar9e').removeClass('bar');
         $('.ic9e').addClass('l');
         $('.ic9e').removeClass('labelPri');
         $('.letra9e').addClass('labelE');
         $('.letra9e').removeClass('label-char');
         error_cedula22 = true;
      }
}

     function primaryE2(){
         $(".error9e, .error9J").html("");
         $(".error9e, .error9J").hide();
         $('#cedula2, #justificativo3').removeClass('errorBorder');
         $('.bar9e, .bar8e').addClass('bar');
         $('.ic9e, .ic22').removeClass('l');
         $('.ic9e, .ic22').addClass('labelPri');
         $('.letra9e, .letra22').removeClass('labelE');
         $('.letra9e, .letra22').addClass('label-char');
     }

$(".borrarE2").on('click', function(){
   $('.formu').trigger('reset');
   primaryE2()
 });


 $("#registrarE2").on('click', function() {
    error_Cedula2 =false;
    error_cedula22=false;
    error_justificativo4=false;
    verificarCedula2();
    chequeo_cedula2();
    chequeo_Justificativo3();

    if (error_cedula22 == false &&  error_justificativo4 == false && error_Cedula2 == false) {
      registrarExcepcion2();
    }
    else{
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon:'error',
        title:'<b class="text-rojo">¡Verifica los datos ingresados!</b>',
        showConfirmButton:false,
        timer:3000,
        timerProgressBar:3000,
      })
    }
   });

   let error_Cedula2 =false;
   function verificarCedula2(){
    let cedula = $("#cedula2").val();
    if (cedula.length > 5) {
        $.ajax({
            type: "POST",
            url: '',
            dataType: "json",
            data: { mostrarCed: 'si', cedula: cedula },
            success: function(data) {
                if (data.resultado === "error Cedula") {
                     Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'El estudiante de la cédula <b class="fw-bold text-rojo"> V-' + cedula + '</b> no existe, ingrese otra cédula!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                    $(".error9e").html('<i class="bi bi-exclamation-triangle-fill"></i> La cédula no existe!');
                    $(".error9e").show();
                    $('#cedula2').addClass('errorBorder');
                    $('.bar9e').removeClass('bar');
                    $('.ic9e').addClass('l');
                    $('.ic9e').removeClass('labelPri');
                    $('.letra9e').addClass('labelE');
                    $('.letra9e').removeClass('label-char');
                    error_Cedula2 = true;
                } else {
                    $(".error9e").hide();
                    $('#cedula2').removeClass('errorBorder');
                    $('.bar9e').addClass('bar');
                    $('.ic9e').removeClass('l');
                    $('.ic9e').addClass('labelPri');
                    $('.letra9e').removeClass('labelE');
                    $('.letra9e').addClass('label-char');
                   
                }
            },
        });
    }
}

let error_Exc = false;

function validarQueNoSeRepita2(callback) {
    let cedula = $("#cedula2").val();
    $.ajax({
        type: "POST",
        url: "",
        dataType: 'JSON',
        data: {
            verificar: true,
            horarioComida: horario,
            cedula: cedula
        },
        success: function(data) {
            console.log(data);
            if (data.resultado === 'ya ingreso al comedor2') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'El estudiante de la cédula <b class="fw-bold text-rojo"> V-' + cedula + '</b>!',
                    text: 'Ya Ingreso Al Comedor',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: 3000,
                });
                error_Exc = true;
                callback(false);
            } else {
                error_Exc = false;
                callback(true);
            }
        },
        error: function() {
            callback(true);
        }
    });
}

function registrarExcepcion2() {
    validarQueNoSeRepita2(function(validar) {
        console.log("Resultado de validarQueNoSeRepita2:", validar);
        if (validar) {
            let cedula = $('#cedula2').val();
            let justificativo = $('#justificativo3').val();
            let platosDisponibles = parseInt($('#comidaDisponible').val());
            let token= $('input[name="csrf_token"]').val();

            if (platosDisponibles > 0) {
                $.ajax({
                    type: "POST",
                    url: "",
                    dataType: "json",
                    data: {
                        excepcion2: true,
                        cedula: cedula,
                        idmenu: menuId,
                        justificativo: justificativo,
                        csrfToken: token,
                        
                    },
                    beforeSend: function() {
                        $("#registrarE2").prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.mensaje.resultado == 'registro del Estudiante 2' && data.newCsrfToken) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Asistencia Registrada Exitosamente!',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            scrollbarPadding: false,
                        });
                        $('.formu').trigger('reset'); 
                        $('input[name="csrf_token"]').val(data.newCsrfToken);  
                        obtenerPlatosDisponibles();
                        
                        $('#cerrarModal2').click();
                    }
                    },
                    complete: function() {
                        $("#registrarE2").prop("disabled", false);
                    }
                });
            } else {
                Swal.fire({
                    title: "Límite alcanzado",
                    text: "Haz alcanzado el límite de platos disponibles, no puedes registrar más excepciones.",
                    icon: "warning"
                });
            }
        } else {
            console.log("No se pudo registrar, ya ingresó al comedor");
        }
    });
}




}); /* Fin*/



$('#as1').addClass('active');
$('#as2').addClass('text-primary');
$('.as2').addClass('active')


setInterval(function() {
  $.ajax({
     url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {renovarToken: true, csrfToken:  $('[name="csrf_token"]').val()}, 
      success(data){
      if (data.newCsrfToken) {
      $('[name="csrf_token"]').val(data.newCsrfToken);
        console.log('Token CSRF renovado');
      } else {
        console.log('No se pudo renovar el token CSRF');
      }
    },
    error: function(err) {
      console.error('Error renovando token CSRF:', err);
    }
  });
}, 240000);