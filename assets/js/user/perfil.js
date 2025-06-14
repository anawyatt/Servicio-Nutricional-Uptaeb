$('#account').on('click',function(){
  primary2();
  $('#form2').addClass('d-none');
  $('#form1').addClass('d-block');
  $('#form2').removeClass('d-block');
  $('#form1').removeClass('d-none');
  document.getElementById("account").classList.add("active");
  document.getElementById("account").classList.remove("done");
   document.getElementById("personal").classList.remove("active");
   document.getElementById("personal").classList.add("done");
})

$('#personal').on('click',function(){
  primary();
  $('#form2').addClass('d-block');
  $('#form2').removeClass('d-none');
  $('#form1').removeClass('d-block');
  $('#form1').addClass('d-none');
   document.getElementById("account").classList.remove("active");
   document.getElementById("account").classList.add("done");
   document.getElementById("personal").classList.add("active");
   document.getElementById("personal").classList.remove("done");
})



let iD;

mostrar();
function mostrar(){
       iD = this.id;
       $.ajax({
           method: "post",
           url: "",
           dataType: "json",
           data: { info: "mostrarInfo", iD },
           success(data) {
               $("#nombre").val(data[0].nombre);
               $("#apellido").val(data[0].apellido);
               $("#correo").val(data[0].correo);
       
           }
       });
}



$("#editarUser").on("click", function(e){
  error_nombre =false;
  error_apellido = false;
  error_correo = false;

  chequeo_nombre() 
  chequeo_apellido()
  chequeo_correo() 
  
  if (error_nombre == false && error_apellido == false && error_correo == false ) {
   modificarUsuario();
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



// EDITAR PERFIL

let error_nombre = false;
let error_apellido = false;
let  error_correo = false;

$("#nombre").focusout(function(){
         chequeo_nombre();
      });
 $("#nombre").on('keyup', function(){
         chequeo_nombre();
      });
 $("#apellido").focusout(function(){
         chequeo_apellido();
      });
 $("#apellido").on('keyup', function(){
         chequeo_apellido();
      });

 $("#correo").focusout(function(){
         chequeo_correo();
      });
 $("#correo").on('keyup', function(){
         chequeo_correo();
      });

 $('.limpiar').on('click',function(){
  primary();
  mostrar();
 })

        function chequeo_nombre() {
    const chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,10}$/;
    const nombre = $("#nombre").val();
    if (chequeo.test(nombre) && nombre !== '') {
     $(".error1").html("");
     $(".error1").hide();
     $('#nombre').removeClass('errorBorder');
     $('.bar1').addClass('bar');
     $('.ic1').removeClass('l');
     $('.ic1').addClass('labelPri');
     $('.letra1').removeClass('labelE');
     $('.letra1').addClass('label-char');
    } else {
     $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el Nombre, solo Caracteres!');
     $(".error1").show();
     $('#nombre').addClass('errorBorder');
     $('.bar1').removeClass('bar');
     $('.ic1').addClass('l');
     $('.ic1').removeClass('labelPri');
     $('.letra1').addClass('labelE');
     $('.letra1').removeClass('label-char');
       error_nombre = true;
    }
        }

        function chequeo_apellido() {
            const chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,12}$/;
            const apellido = $("#apellido").val();
            if (chequeo.test(apellido) && apellido !== '') {
             $(".error2").html("");
             $(".error2").hide();
             $('#apellido').removeClass('errorBorder');
             $('.bar2').addClass('bar');
             $('.ic2').removeClass('l');
             $('.ic2').addClass('labelPri');
             $('.letra2').removeClass('labelE');
             $('.letra2').addClass('label-char');
            } else {
             $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el apellido, solo Caracteres!');
             $(".error2").show();
             $('#apellido').addClass('errorBorder');
             $('.bar2').removeClass('bar');
             $('.ic2').addClass('l');
             $('.ic2').removeClass('labelPri');
             $('.letra2').addClass('labelE');
             $('.letra2').removeClass('label-char');
             error_apellido = true;
            }
        }

        function chequeo_correo() {
            const chequeo = /^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/;
            const correo = $("#correo").val();
            if (chequeo.test(correo) && correo !== '') {
             $(".error3").html("");
             $(".error3").hide();
             $('#correo').removeClass('errorBorder');
             $('.bar3').addClass('bar');
             $('.ic3').removeClass('l');
             $('.ic3').addClass('labelPri');
             $('.letra3').removeClass('labelE');
             $('.letra3').addClass('label-char');
            } else {
             $(".error3").html("<i  class='bi bi-exclamation-triangle-fill'></i> Ingrese el Correo Correctamente <b>(user13@gmail.com)</b> !");
             $(".error3").show();
             $('#correo').addClass('errorBorder');
             $('.bar3').removeClass('bar');
             $('.ic3').addClass('l');
             $('.ic3').removeClass('labelPri');
             $('.letra3').addClass('labelE');
             $('.letra3').removeClass('label-char');
             error_correo = true;
            }
        }


    

      function primary(){
             $(".error1, .error2, .error3").html("");
             $(".error1, .error2, .error3").hide();
             $('#nombre, #apellido, #correo').removeClass('errorBorder');
             $('.bar1, .bar2').addClass('bar');
             $('.ic1, .ic2, .ic3').removeClass('l');
             $('.ic1, .ic2, .ic3').addClass('labelPri');
             $('.letra1, .letra2, .letra3').removeClass('labelE');
             $('.letra1, .letra2, .letra3').addClass('label-char');

      }

// CAMBIO DE CONTRASEÑA

 $("#clave1").focusout(function(){
         chequeo_clave1();
      });
 $("#clave1").on('keyup', function(){
         chequeo_clave1();
      });
 $("#clave2").focusout(function(){
         chequeo_clave2();
      });
 $("#clave2").on('keyup', function(){
         chequeo_clave2();
      });

 $("#clave3").focusout(function(){
         chequeo_clave3();
      });
 $("#clave3").on('keyup', function(){
         chequeo_clave3();
      });

 $('.limpiar3').on('click',function(){
  primary2();
 })

 $("#password").on("click", function(e) {
  error_clave2 = false;
  error_clave3 = false;

  if (!reset_password_mode) {
      error_clave = false;
      chequeo_clave1(); // Solo verificar la clave actual si no está en modo de recuperación
  }

  chequeo_clave2(); // Verificar nueva contraseña
  chequeo_clave3(); // Verificar repetir contraseña

  if ((!reset_password_mode && !error_clave) && !error_clave2 && !error_clave3) {
      modificarContraseña();
  } else if (reset_password_mode && !error_clave2 && !error_clave3) {
      modificarContraseña(); // En modo recuperación, solo chequeamos clave2 y clave3
  } else {
      Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: '<span class="text-rojo">Ingrese los Datos Correctamente!</span>',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: 3000,
          width: '38%',
      });
  }
});


 // clave
 function show() {
   var p = document.getElementById('clave1');
   p.setAttribute('type', 'text');
   $('.eyeSi').removeClass('d-none');
       $('.eyeNo').addClass('d-none');
}

function hide() {
   var p = document.getElementById('clave1');
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
}, false);



// clave 2

function show2() {
   var p = document.getElementById('clave2');
   p.setAttribute('type', 'text');
   $('.eyeSi2').removeClass('d-none');
       $('.eyeNo2').addClass('d-none');
}

function hide2() {
   var p = document.getElementById('clave2');
   p.setAttribute('type', 'password');
   $('.eyeSi2').addClass('d-none');
   $('.eyeNo2').removeClass('d-none');
}

var pwShown = 0;

document.getElementById("eye2").addEventListener("click", function () {
   if (pwShown == 0) {
       pwShown = 1;
       show2();
      
   } else {
       pwShown = 0;
       hide2();
   }
}, false);

// clave 3

function show3() {
   var p = document.getElementById('clave3');
   p.setAttribute('type', 'text');
   $('.eyeSi3').removeClass('d-none');
       $('.eyeNo3').addClass('d-none');
}

function hide3() {
   var p = document.getElementById('clave3');
   p.setAttribute('type', 'password');
   $('.eyeSi3').addClass('d-none');
   $('.eyeNo3').removeClass('d-none');
}

var pwShown = 0;

document.getElementById("eye3").addEventListener("click", function () {
   if (pwShown == 0) {
       pwShown = 1;
       show3();
      
   } else {
       pwShown = 0;
       hide3();
   }
}, false);

let error_clave =false;
let  error_clave2 = false;
let error_clave3 = false;

       
      function chequeo_clave1()  {
        var chequeo=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;
        var nombre = $("#clave1").val();
        if (chequeo.test(nombre) && nombre !== '') {
         $(".error4").html("");
         $(".error4").hide();
         $('#clave1').removeClass('errorBorder');
         $('.bar4').addClass('bar');
         $('.ic4').removeClass('l');
         $('.ic4').addClass('labelPri');
         $('.letra4').removeClass('labelE');
         $('.letra4').addClass('label-char');
        } else {
         $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"</i> Ingrese la Contraseña Actual!');
         $(".error4").show();
         $('#clave1').addClass('errorBorder');
         $('.bar4').removeClass('bar');
         $('.ic4').addClass('l');
         $('.ic4').removeClass('labelPri');
         $('.letra4').addClass('labelE');
         $('.letra4').removeClass('label-char');
         error_clave = true;
        }
      }

      function chequeo_clave2()  {
        var chequeo=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;
        var nombre = $("#clave2").val();
        if (chequeo.test(nombre) && nombre !== '') {
         $(".error5").html("");
         $(".error5").hide();
         $('#clave2').removeClass('errorBorder');
         $('.bar5').addClass('bar');
         $('.ic5').removeClass('l');
         $('.ic5').addClass('labelPri');
         $('.letra5').removeClass('labelE');
         $('.letra5').addClass('label-char');
        } else {
         $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"</i>La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial permitido (*-_.,;()"@#$=).');
         $(".error5").show();
         $('#clave2').addClass('errorBorder');
         $('.bar5').removeClass('bar');
         $('.ic5').addClass('l');
         $('.ic5').removeClass('labelPri');
         $('.letra5').addClass('labelE');
         $('.letra5').removeClass('label-char');
         error_clave2 = true;
        }
      }

      function chequeo_clave3()  {
        var chequeo=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;
        var nombre = $("#clave3").val();
        if (chequeo.test(nombre) && nombre !== '') {
         $(".error6").html("");
         $(".error6").hide();
         $('#clave3').removeClass('errorBorder');
         $('.bar6').addClass('bar');
         $('.ic6').removeClass('l');
         $('.ic6').addClass('labelPri');
         $('.letra6').removeClass('labelE');
         $('.letra6').addClass('label-char');
        } else {
         $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"</i>La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial permitido (*-_.,;()"@#$=).');
         $(".error6").show();
         $('#clave3').addClass('errorBorder');
         $('.bar6').removeClass('bar');
         $('.ic6').addClass('l');
         $('.ic6').removeClass('labelPri');
         $('.letra6').addClass('labelE');
         $('.letra6').removeClass('label-char');
         error_clave3 = true;
        }
      }
    

       function primary2(){
         $(".error4, .error5, .error6").html("");
         $(".error4, .error5, .error6 ").hide();
         $('#clave1, #clave2, #clave3').removeClass('errorBorder');
         $('.bar4, .bar5, .bar6').addClass('bar');
         $('.ic4, .ic5, .ic6').removeClass('l');
         $('.ic4, .ic5, .ic6').addClass('labelPri');
         $('.letra4, .letra5, .letra6').removeClass('labelE');
         $('.letra4, .letra5, .letra6').addClass('label-char');

       }


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

    
    document.getElementById('imagen').addEventListener('change', function(event) {
        const file = event.target.files[0]; 
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
            }
            reader.readAsDataURL(file); 
        }
    });


       function modificarUsuario(){

                let nombre = cambiarFormato($("#nombre").val());
                let apellido = cambiarFormato($("#apellido").val());
                let correo = cambiarFormato($("#correo").val());
            
                $.ajax({
                    type: "post",
                    url: "", 
                    dataType: "json",
                    data: {
                        nombre: nombre,
                        apellido: apellido,
                        correo: correo,
                        },
                        success(data){
                            if (data.resultado == 'success' && data.url) {
                
          
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon:'success',
                                title:'Modificación exitosa!',
                                showConfirmButton:false,
                                timer:2000,
                                timerProgressBar:true,
              
                            })
                             setTimeout(function () {
                                 location = data.url;
                             }, 2000);
                         
                          }
                            }
                 
                         })
             }


             function modificarContraseña() {
              let clave = $("#clave1").val(); // Contraseña antigua
              let nuevaClave = $("#clave2").val(); // Nueva contraseña
              let repetirClave = $("#clave3").val(); // Repetir nueva contraseña
          
              // Si el modo de recuperación de contraseña está activo, no pedir la antigua contraseña
              if (typeof reset_password_mode !== 'undefined' && reset_password_mode === true) {
                  clave = null; // No se enviará la contraseña actual en modo de recuperación
              }
          
              $.ajax({
                  type: "post",
                  url: "", 
                  dataType: "json",
                  data: {
                      clave: clave,
                      nuevaClave: nuevaClave,
                      repetirClave: repetirClave,
                  },
                  success(data) {
                      if (data.resultado === 'error') {
                          Swal.fire({
                              toast: true,
                              position: 'top-end',
                              icon: 'error',
                              title: '<span class="text-rojo">Contraseña incorrecta!</span>',
                              showConfirmButton: false,
                              timer: 3000,
                              timerProgressBar: 3000,
                              width: '38%',
                          });
                          $("#error4").html('<i class="bi bi-exclamation-triangle-fill"></i> La contraseña es incorrecta!');
                          $("#error4").show();
                          $('#clave1').addClass('is-invalid');
                          $('#clave1').removeClass('is-valid');
                          $('.bie').addClass('danger');
                          $('.bie').removeClass('pri');
                      } else if (data.resultado === 'no son iguales') {
                          Swal.fire({
                              toast: true,
                              position: 'top-end',
                              icon: 'error',
                              title: '<span class="text-rojo">Las contraseñas no son iguales!</span>',
                              showConfirmButton: false,
                              timer: 3000,
                              timerProgressBar: 3000,
                              width: '38%',
                          });
                          $("#error5, #error6").html('<i class="bi bi-exclamation-triangle-fill"></i> La contraseña debe tener de 8-12 caracteres!');
                          $("#error5, #error6").show();
                          $('#clave3, #clave2').addClass('is-invalid');
                          $('#clave3, #clave2').removeClass('is-valid');
                          $('.bie3, .bie2').addClass('danger');
                          $('.bie3, .bie2').removeClass('pri');
                      } else if (data.resultado === 'clave Editada correctamente.' && data.url ) {
                          Swal.fire({
                              toast: true,
                              position: 'top-end',
                              icon: 'success',
                              title: 'Cambio de Contraseña exitosa!',
                              showConfirmButton: false,
                              timer: 2000,
                              timerProgressBar: true,
                          });
                           $('.limpiar3').click()
          
                          // Si está en modo recuperación, cerrar la sesión y redirigir al login
                          if (typeof reset_password_mode !== 'undefined' && reset_password_mode === true) {
                              setTimeout(function() {
                                   location = data.url; // Redirigir al login
                              }, 2000); // Espera de 2 segundos antes de la redirección
                          } else {
                              $('.limpiar3').click(); // Limpiar los campos si no está en modo recuperación
                          }
                      }
                  }
              });
          }
          

 // ------------------------------ IMAGEN -------------------------------


      $("#eliminarIMG").on("click", function(){
        borrarIMG();
     })

     function borrarIMG(){

      $.ajax({
          type: "post",
          url: "", 
          dataType: "json",
          data: {
              borrar : true
              },
              success(data){
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon:'success',
                      title:'Imagen eliminada Exitosamente!',
                      showConfirmButton:false,
                      timer:1000,
                      timerProgressBar:true,
    
                  })
                   setTimeout(function () {
                    location.reload(true);
                   }, 1000);
               
                }
       
               })
            }


      $("#editarIMG").click((e) => {
        var datos = new FormData();
        datos.append("accion", "imagenPerfil");
        if ($("#imagen")[0].files[0] != null) {
        datos.append("imagen", $("#imagen")[0].files[0]);
        }
          editarIMg(datos);
        }); 

      
        function editarIMg(datos) {
          $.ajax({
          url: "",
          type: "POST",
          contentType: false,
          data: datos,
          processData: false,
          cache: false,
          success: function(response) {
          var res = JSON.parse(response);
                 Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon:'success',
                      title:'Imagen Editada Exitosamente!',
                      showConfirmButton:false,
                      timer:1500,
                      timerProgressBar:true,
                  })
                  
                   setTimeout(function () {
                    location.reload(true);
                   }, 1500);
}
});
}