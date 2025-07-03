   function cambiarFormato(texto) {
   // Dividir la cadena en palabras utilizando espacios
   const palabras = texto.split(" ");
   let palabrasFormateadas = [];
 
   // Recorrer las palabras
   for (let i = 0; i < palabras.length; i++) {
       // Eliminar espacios en blanco adicionales y formatear cada palabra
       if (palabras[i].trim() !== "") {
           palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
       }
   }
 
   // Unir las palabras formateadas nuevamente en una cadena
   return palabrasFormateadas.join(" ");
   }

   function show() {
    var p = document.getElementById('clave');
    p.setAttribute('type', 'text');
    $('.eyeSi').removeClass('d-none');
        $('.eyeNo').addClass('d-none');
   }

   function hide() {
    var p = document.getElementById('clave');
    p.setAttribute('type', 'password');
    $('.eyeSi').addClass('d-none');
    $('.eyeNo').removeClass('d-none');
   }

   var pwShown = 0;

   document.getElementById("eye").addEventListener("click", function () {
    if (pwShown == 0) {
        pwShown = 1;
        show();
       
    } else {
        pwShown = 0;
        hide();
    }
   }     , false);

                  ////---------------------------MOSTRAR SELECT ROLES -------------------------------
let select = $('#rol');
let input = '<option value="Seleccionar"> Seleccionar Rol</option>';


function mostrarRol() {
  $.ajax({
    url: '', 
    type: 'POST',
    dataType: 'JSON',
    data: { select: 'mostrar' },
    success(response) {
      console.log(response);
      let opE = '';
      response.forEach(fila => {
        opE += `<option value="${fila.idRol}">${fila.nombreRol}</option>`;
      });
      select.html(input + opE);
      select.trigger('change');
    },
    error(xhr, status, error) {
      console.error("Error en la carga de roles:", error);
    }
  });
}

mostrarRol();

$(document).ready(function () {
  $("#rol").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#selectR'),
    selectionCssClass: "input",
    width: '100%'
  });
});


        
  
 

   let error_cedula = false;
   let error_nombre = false;
   let error_segNombre = false;
   let error_apellido = false;     
   let error_segApellido = false;     
   let error_correo = false;
   let error_rol = false;
   let error_veriCE = false;
   let error_veriCO = false;
   let error_veriT=false;
   let error_veriR=false;

   $("#error1").hide();
   $("#error2").hide();
   $("#error3").hide();
   $("#error4").hide();
   $("#error5").hide();
   $("#error6").hide();

   $("#cedula").focusout(function(){
    chequeo_cedula();
     verificarCedula();
   });
   $("#cedula").on('keyup', function() {
    chequeo_cedula();
    verificarCedula();
   });

   $("#nombre").focusout(function(){
    chequeo_nombre();
   });
   $("#nombre").on('keyup', function(){
    chequeo_nombre();
   });

   $("#segNombre").focusout(function(){
    chequeo_segNombre();
   });
   $("#segNombre").on('keyup', function(){
    chequeo_segNombre();
   });

   $("#apellido").focusout(function() {
    chequeo_apellido();
   });
   $("#apellido").on('keyup', function() {
    chequeo_apellido();
   });

   $("#segApellido").focusout(function() {
    chequeo_segApellido();
   });
   $("#segApellido").on('keyup', function() {
    chequeo_segApellido();
   });

   $("#correo").focusout(function() {
    chequeo_correo();
     verificarCorreo()
   });
   $("#correo").on('keyup', function() {
    chequeo_correo();
    verificarCorreo()
   });

   $("#telefono").focusout(function() {
    chequeo_telefono();
    verificarTelefono()
   });
   $("#telefono").on('keyup', function() {
    chequeo_telefono();
    verificarTelefono()
   });

   $(".rol").focusout(function() {
    chequeo_rol();
    verificarRol();
   });
   $(".rol").on('change', function() {
    chequeo_rol();
    verificarRol();
   });

 $(document).on('click', '.limpiar', function(e) {
   primary();
  })

  $(document).on('click', '.can', function(e) {
   $('#val1').prop('disabled', true);
  })
  $(document).on('click', '.can2', function(e) {
   $('#val2').prop('disabled', true);
  })
   $(document).on('click', '.can3', function(e) {
   $('#enviar').prop('disabled', true);
  })

 $(".form1").on('keyup', function() {
   
   let cedula=$('#cedula').val();
   let nombre =$('#nombre').val();
   let segNombre=$('#segNombre').val();
   let apellido = $('#apellido').val();
   let segApellido=$('#segApellido').val();
    var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;

   if (cedula !== '' &&  nombre !== '' && (chequeo.test(segNombre) || segNombre.length == 0)   && apellido !== '' && (chequeo.test(segApellido) || segApellido.length == 0)) {
      $('#val1').prop('disabled', false);
      }
   });

 $(".form2").on('keyup', function() {
   
   let correo=$('#correo').val();
   let telefono =$('#telefono').val();

   if (correo !== '' &&  telefono !== '' ) {
      $('#val2').prop('disabled', false);
   }
 });


  $("#enviar").on("click", function(e){
              
            error_cedula = false;
            error_nombre = false;
            error_segNombre = false;
            error_apellido = false;     
            error_segApellido = false;  
            error_correo = false;
            error_telefono=false;
            error_rol = false;
            error_veriCE = false;
            error_veriCO = false;
            error_veriT=false;
            error_veriR=false;

            chequeo_cedula()
            chequeo_nombre()
            chequeo_segNombre()
            chequeo_apellido()
            chequeo_segApellido()
            chequeo_correo()
            chequeo_telefono()
            chequeo_rol()
            verificarCedula()
            verificarCorreo()
            verificarTelefono()
            verificarRol()

            if(error_cedula == false && error_nombre ==false && error_segNombre ==false && error_apellido==false && error_segApellido ==false && error_correo == false && error_telefono ==false &&
              error_rol== false && error_veriCE === false && error_veriCO === false && error_veriR === false && error_veriT === false){
                registrar();
            }
            else{
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">Ingrese los Datos Correctamente!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
                 }
               
          
               })
          
                function registrar(){
                 $("#enviar").prop("disabled", true);

                let cedula = $("#cedula").val();
                let nombre = cambiarFormato($("#nombre").val());
                let segNombre = cambiarFormato($("#segNombre").val());
                let apellido =cambiarFormato( $("#apellido").val());
                let segApellido= cambiarFormato($("#segApellido").val());
                let correo = cambiarFormato($("#correo").val());
                let telefono = $("#telefono").val();
                let clave = $("#clave").val();
                let idRol = $("#rol").val();
                let token = $('[name="csrf_token"]').val();

                  if(token){
                  console.log(token);

                $.ajax({
                    type: "post",
                    url: "", 
                    dataType: "json",
                    data: {
                       registrar: true,
                        cedula, 
                        nombre, 
                        segNombre, 
                        apellido, 
                        segApellido, 
                        correo, 
                        telefono, 
                        clave, 
                        idRol,
                        csrfToken: token
                        },
                        success(data){
                          if (data.mensaje.resultado== 'registro exitoso' && data.newCsrfToken) {
                            $('[name="csrf_token"]').val(data.newCsrfToken);
                             Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'success',
                                  title:'El Usuario <b class="text-primary fw-bold">'+nombre+' '+apellido+'</b> Registrado Exitosamente!',
                                  showConfirmButton:false,
                                  timer:2500,
                                  timerProgressBar:true,
                
                              })
                           }
                               $('.formu').trigger('reset');
                               primary();
                    
                           },
                           complete() {
                            $("#enviar").prop("disabled", false);
                           }
                           
                 
                         })
                }
                   }


                   
      function chequeo_cedula() {
    var campo = /^[0-9]{6,8}$/;
      var cedula = $("#cedula").val();
      if (campo.test(cedula) && cedula !== ''){
         $(".error1").html("");
         $(".error1").hide();
         $('#cedula').removeClass('errorBorder');
         $('.bar1').addClass('bar');
         $('.ic1').removeClass('l');
         $('.ic1').addClass('labelPri');
         $('.letra').removeClass('labelE');
         $('.letra').addClass('label-char');
      }else{
         $('#val1').prop('disabled', true);
         $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cédula de identidad!');
         $(".error1").show();
         $('#cedula').addClass('errorBorder');
         $('.bar1').removeClass('bar');
         $('.ic1').addClass('l');
         $('.ic1').removeClass('labelPri');
         $('.letra').addClass('labelE');
         $('.letra').removeClass('label-char');
         error_cedula = true;
      }
      }

      function chequeo_nombre() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var nombre = $("#nombre").val();
        if (chequeo.test(nombre) && nombre !== '') {
         $(".error2").html("");
         $(".error2").hide();
         $('#nombre').removeClass('errorBorder');
         $('.bar2').addClass('bar');
         $('.ic2').removeClass('l');
         $('.ic2').addClass('labelPri');
         $('.letra2').removeClass('labelE');
         $('.letra2').addClass('label-char');
        } else {
         $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el nombre!');
         $(".error2").show();
         $('#nombre').addClass('errorBorder');
         $('.bar2').removeClass('bar');
         $('.ic2').addClass('l');
         $('.ic2').removeClass('labelPri');
         $('.letra2').addClass('labelE');
         $('.letra2').removeClass('label-char');
          $('#val1').prop('disabled', true);
           error_nombre = true;
        }
      }

      function chequeo_segNombre() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var nombre = $("#segNombre").val();
        if (chequeo.test(nombre) || nombre.length == 0) {
         $(".error3").html("");
         $(".error3").hide();
         $('#segNombre').removeClass('errorBorder');
         $('.bar3').addClass('bar');
         $('.ic3').removeClass('l');
         $('.ic3').addClass('labelPri');
         $('.letra3').removeClass('labelE');
         $('.letra3').addClass('label-char');
        } else {
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el segundo nombre!');
         $(".error3").show();
         $('#segNombre').addClass('errorBorder');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
          $('#val1').prop('disabled', true);
           error_segNombre = true;
        }
      }

      function chequeo_apellido() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var apellido = $("#apellido").val();
        if (chequeo.test(apellido) && apellido !== '') {
         $(".error4").html("");
         $(".error4").hide();
         $('#apellido').removeClass('errorBorder');
         $('.bar4').addClass('bar');
         $('.ic4').removeClass('l');
         $('.ic4').addClass('labelPri');
         $('.letra4').removeClass('labelE');
         $('.letra4').addClass('label-char');
        } else {
         $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el apellido!');
         $(".error4").show();
         $('#apellido').addClass('errorBorder');
         $('.bar4').removeClass('bar');
         $('.ic4').addClass('l');
         $('.ic4').removeClass('labelPri');
         $('.letra4').addClass('labelE');
         $('.letra4').removeClass('label-char');
         $('#val1').prop('disabled', true);
           error_apellido = true;
        }
      }

      function chequeo_segApellido() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var apellido = $("#segApellido").val();
        if (chequeo.test(apellido) || apellido.length == 0) {
         $(".error5").html("");
         $(".error5").hide();
         $('#segApellido').removeClass('errorBorder');
         $('.bar5').addClass('bar');
         $('.ic5').removeClass('l');
         $('.ic5').addClass('labelPri');
         $('.letra5').removeClass('labelE');
         $('.letra5').addClass('label-char');
        } else {
         $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el segundo apellido!');
         $(".error5").show();
         $('#segApellido').addClass('errorBorder');
         $('.bar5').removeClass('bar');
         $('.ic5').addClass('l');
         $('.ic5').removeClass('labelPri');
         $('.letra5').addClass('labelE');
         $('.letra5').removeClass('label-char');
         $('#val1').prop('disabled', true);
           error_segApellido = true;
        }
      }

      function chequeo_correo() {
        var campo = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/;
        var correo = $("#correo").val();
        if (campo.test(correo) ) {
         $(".error6").html("");
         $(".error6").hide();
         $('#correo').removeClass('errorBorder');
         $('.bar6').addClass('bar');
         $('.ic6').removeClass('l');
         $('.ic6').addClass('labelPri');
         $('.letra6').removeClass('labelE');
         $('.letra6').addClass('label-char');
        } else {
         $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el correo correctamente <b>(user2024@gmail.com)</b"');
         $(".error6").show();
         $('#correo').addClass('errorBorder');
         $('.bar6').removeClass('bar');
         $('.ic6').addClass('l');
         $('.ic6').removeClass('labelPri');
         $('.letra6').addClass('labelE');
         $('.letra6').removeClass('label-char');
          $('#val2').prop('disabled', true);
           error_correo= true;
        }
      }

      function chequeo_telefono() {
        var campo = /^0\d{10}$/;
        var telefono = $("#telefono").val();
        if (campo.test(telefono) ) {
         $(".error7").html("");
         $(".error7").hide();
         $('#telefono').removeClass('errorBorder');
         $('.bar7').addClass('bar');
         $('.ic7').removeClass('l');
         $('.ic7').addClass('labelPri');
         $('.letra7').removeClass('labelE');
         $('.letra7').addClass('label-char');
        } else {
         $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese un número de teléfono válido sin espacios, por ejemplo: <b>04120000000</b>');
         $(".error7").show();
         $('#telefono').addClass('errorBorder');
         $('.bar7').removeClass('bar');
         $('.ic7').addClass('l');
         $('.ic7').removeClass('labelPri');
         $('.letra7').addClass('labelE');
         $('.letra7').removeClass('label-char');
          $('#val2').prop('disabled', true);
           error_telefono= true;
        }
      }

      function chequeo_rol() { 
        var rol = $(".rol").val();
        if (rol != 'seleccionar') {
         $(".error8").html("");
         $(".error8").hide();
         $('.rol').removeClass('errorBorder');
         $('.bar8').addClass('bar');
         $('.ic8').removeClass('l');
         $('.ic8').addClass('labelPri');
         $('.letra8').removeClass('labelE');
         $('.letra8').addClass('label-char');
           $('#enviar').prop('disabled', false);
        } else {
         $(".error8").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el rol del usuario!');
         $(".error8").show();
         $('.rol').addClass('errorBorder');
         $('.bar8').removeClass('bar');
         $('.ic8').addClass('l');
         $('.ic8').removeClass('labelPri');
         $('.letra8').addClass('labelE');
         $('.letra8').removeClass('label-char');
           $('#enviar').prop('disabled', true);
           error_rol = true;
        }
      }

                 function primary(){
                    $(".error1, .error2, .error3, .error4, .error5,  .error6, .error7, .error8").html("");
                    $(".error1, .error2, .error3, .error4, .error5,  .error6, .error7, .error8").hide();
                    $('#cedula, #nombre, #segNombre, #apellido, #segApellido, #correo, #telefono, .rol ').removeClass('errorBorder');
                    $('.bar1, .bar2, .bar3, .bar4, .bar5, .bar6, .bar7, .bar8').addClass('bar');
                    $('.ic1, .ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').removeClass('l');
                    $('.ic1, .ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').addClass('labelPri');
                    $('.letra, .letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').removeClass('labelE');
                    $('.letra, .letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').addClass('label-char');
                    $('.rol').val('Seleccionar').trigger('change.select2');

                   }

                   function verificarCedula(){
                     let cedula = $("#cedula").val();
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
                                    $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> La cedula ya existe!');
                                    $(".error1").show();
                                    $('#cedula').addClass('errorBorder');
                                    $('.bar1').removeClass('bar');
                                    $('.ic1').addClass('l');
                                    $('.ic1').removeClass('labelPri');
                                    $('.letra').addClass('labelE');
                                    $('.letra').removeClass('label-char');
                                    error_veriCE = true;
                                
                                 }
                                 else{
                                    $(".error1").show();
                                    $('#cedula').removeClass('errorBorder');
                                    $('.bar1').addClass('bar');
                                    $('.ic1').removeClass('l');
                                    $('.ic1').addClass('labelPri');
                                    $('.letra').removeClass('labelE');
                                    $('.letra').addClass('label-char');
                                  }
                                   
                                }
                              })
                           }
              
                          }

                    

                function verificarCorreo(){
               
                 let correo = $("#correo").val();
                 if (correo.length > 15) {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ muestra2:'si', 
                           correo
                           },
                          success(date){
          
                               if (date.resultado === "error correo"){
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'El Correo Electrónico  <b class="fw-bold text-rojo">'+correo+'</b> ya existe, ingrese otra correo electrónico!',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> El correo ya existe!');
                                $(".error6").show();
                                $('#correo').addClass('errorBorder');
                                $('.bar6').removeClass('bar');
                                $('.ic6').addClass('l');
                                $('.ic6').removeClass('labelPri');
                                $('.letra6').addClass('labelE');
                                $('.letra6').removeClass('label-char');
                                $('#val2').prop('disabled', true);
                                error_veriCO = true;
                            
                             }
                             else{
                               $(".error6").hide();
                               $('#correo').removeClass('errorBorder');
                               $('.bar6').addClass('bar');
                               $('.ic6').removeClass('l');
                               $('.ic6').addClass('labelPri');
                               $('.letra6').removeClass('labelE');
                               $('.letra6').addClass('label-char');
                              }
                            }
                          })
                        }
                  
          
                    }


              function verificarTelefono(){
               
                 let telefono = $("#telefono").val();
                 if (telefono.length > 11) {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ muestra3:'si', 
                           telefono
                         },
                          success(date){
          
                               if (date.resultado === "error telefono"){
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'El Nº de Teléfono  <b class="fw-bold text-rojo">'+telefono+'</b> ya existe, ingrese otro Nº de teléfono!',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> El télefono ya existe!');
                                $(".error7").show();
                                $('#telefono').addClass('errorBorder');
                                $('.bar7').removeClass('bar');
                                $('.ic7').addClass('l');
                                $('.ic7').removeClass('labelPri');
                                $('.letra7').addClass('labelE');
                                $('.letra7').removeClass('label-char');
                                $('#val2').prop('disabled', true);
                                error_veriT = true;
                            
                             }
                             else{
                                $(".error7").hide();
                                $('#telefono').removeClass('errorBorder');
                                $('.bar7').addClass('bar');
                                $('.ic7').removeClass('l');
                                $('.ic7').addClass('labelPri');
                                $('.letra7').removeClass('labelE');
                                $('.letra7').addClass('label-char');
                              }
                            }
                          })
                        }
                  
          
                    }


     

              function verificarRol() {
                let idRol = $("#rol").val();

                if (idRol !== 'seleccionar') {
                  $.ajax({
                    type: "POST",
                    url: '', // Tu URL de controlador
                    dataType: "json",
                    data: { valida: 'si', idRol },
                    success(response) {
                      // Si el rol fue eliminado o no existe
                      if (response.resultado === "error rol") {
                        Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'error',
                          title: '<b class="text-rojo">El Rol ha sido eliminado recientemente!</b>',
                          showConfirmButton: false,
                          timer: 3000,
                          timerProgressBar: true,
                        });

                        error_veriR = true;

                        // Restablecer el select
                        $("#rol").val("Seleccionar").trigger("change");
                      } 
                      // Si el rol existe y es válido
                      else if (response.resultado === "existe rol") {
                        error_veriR = false;
                        // No recargues los roles ni elimines la selección
                      } 
                      // Respuesta inesperada
                      else {
                        console.warn("Respuesta inesperada:", response);
                      }
                    },
                    error(xhr, status, error) {
                      console.error("Error en la verificación del rol:", error);
                    }
                  });
                }
              }


    
            


                   
$('#u1').addClass('active');
$('#u2').addClass('text-primary');
$('.u2').addClass('active');


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