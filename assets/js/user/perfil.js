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
           data: { 
            info: "mostrarInfo",
             iD },
           success(data) {
            console.log("Respuesta:", data); 
                $("#nombre").val(data.nombre);
                $("#apellido").val(data.apellido);
                $("#correo").val(data.correo);
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
    error_clave = false;
    error_clave2 = false;
    error_clave3 = false;

    chequeo_clave1();
    chequeo_clave2(); 
    chequeo_clave3();

  if (error_clave == false && error_clave2 == false && error_clave3 == false ) {
   modificarContraseña();
  }else {
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
         $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i>La clave debe tener al menos 8 caracteres, incluyendo letras, caracteres especiales y números.');
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

   function chequeo_clave3() {
    var chequeo = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;
    var nuevaClave = $("#clave2").val();      
    var confirmarClave = $("#clave3").val();  

    let coincide = (nuevaClave === confirmarClave);
    let valida = chequeo.test(confirmarClave) && confirmarClave !== '';

    if (valida && coincide) {
        $(".error6").html("");
        $(".error6").hide();
        $('#clave3').removeClass('errorBorder');
        $('.bar6').addClass('bar');
        $('.ic6').removeClass('l');
        $('.ic6').addClass('labelPri');
        $('.letra6').removeClass('labelE');
        $('.letra6').addClass('label-char');
        error_clave3 = false;
    } else {
        let mensaje = '<i class="bi bi-exclamation-triangle-fill"></i> ';
        if (!valida) {
            mensaje += 'La clave debe tener al menos 8 caracteres, incluyendo letras, caracteres especiales y números.';
        } else if (!coincide) {
            mensaje += 'La confirmación no coincide con la nueva clave.';
        }

        $(".error6").html(mensaje);
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


       function modificarUsuario() {
            let nombre = cambiarFormato($("#nombre").val());
            let apellido = cambiarFormato($("#apellido").val());
            let correo = cambiarFormato($("#correo").val());
            let token = $('[name="csrf_token"]').val();

            $.ajax({
                type: "post",
                url: "", 
                dataType: "json",
                data: {
                    nombre: nombre,
                    apellido: apellido,
                    correo: correo,
                    csrfToken: token
                },
                success(data) {
                    if (data.respuesta.resultado === 'success' && data.respuesta.url && data.newCsrfToken) {
                        $('[name="csrf_token"]').val(data.newCsrfToken); 
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Modificación exitosa!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        setTimeout(function () {
                            window.location.href = data.respuesta.url; 
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.respuesta.mensaje || 'Ocurrió un error inesperado',
                        });
                    }
                },
                error(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la petición',
                        text: error || 'No se pudo conectar con el servidor',
                    });
                    console.error(xhr.responseText);
                }
            });
        }



             function modificarContraseña() {
              let clave = $("#clave1").val(); 
              let nuevaClave = $("#clave2").val(); 
              let repetirClave = $("#clave3").val(); 
              let token = $('[name="csrf_token"]').val();
          
              $.ajax({
                  type: "post",
                  url: "", 
                  dataType: "json",
                  data: {
                      clave: clave,
                      nuevaClave: nuevaClave,
                      repetirClave: repetirClave,
                      csrfToken: token
                  },
                  success(data) {
                      if (data.respuesta2.resultado === 'error') {
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
                      } else if (data.respuesta2.resultado === 'no son iguales') {
                          Swal.fire({
                              toast: true,
                              position: 'top-end',
                              icon: 'error',
                              title: '<span class="text-rojo">Las nuevas contraseñas no coinciden!</span>',
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
                      } else if (data.respuesta2.resultado === 'clave Editada correctamente.' && data.respuesta2.url && data.newCsrfToken) {
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
                            $('[name="csrf_token"]').val(data.newCsrfToken);
          
                        
                      }
                  }
              });
          }
          

 // ------------------------------ IMAGEN -------------------------------

 $("#eliminarIMG").on("click", function () {
    borrarIMG();
});

function borrarIMG() {
    let token = $('[name="csrf_token"]').val();
    $.ajax({
        type: "post",
        url: "", 
        dataType: "json",
        data: { borrar: true, csrfToken: token },
        success(data) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.respuesta3.resultado === 'success' ? 'success' : 'error',
                title: data.respuesta3.mensaje,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            if (data.respuesta3.resultado === 'success' && data.newCsrfToken) {
                const nuevaImg = data.img || "assets/images/perfil/user.png";
                $("#imgPerfil").attr("src", nuevaImg + "?v=" + new Date().getTime());

                if (nuevaImg.includes("user.png")) {
                    $("#eliminarIMG").hide();
                }
                $('[name="csrf_token"]').val(data.newCsrfToken); 

                setTimeout(() => {
                location.reload();
                }, 1600);
            }
        }
    });
}

const fileInput0 = document.getElementById('imagen');  
const container0 = document.getElementById('container0'); 
const defaultImage = document.createElement('img'); 
defaultImage.src = "assets/images/perfil/user.png";  
let error_imagen = false;  

function validarPesoImagen0(input) {
    if (input.files && input.files[0]) {
        const imagen = input.files[0];
        const pesoMb = imagen.size / 1024 / 1024; // tamaño en MB

        if (pesoMb > 2) {
            container0.innerHTML = '';
            container0.appendChild(defaultImage);
            $(".error0").html('<i class="bi bi-exclamation-triangle-fill"></i> La imagen excede el peso máximo de 2MB!');
            $(".error0").show();
            $('#imagen').addClass('errorBorder');
            error_imagen = true;
            input.value = "";
            return false;
        } else {
            $(".error0").html("");
            $(".error0").hide();
            $('#imagen').removeClass('errorBorder');
            error_imagen = false;
            return true;
        }
    }
    return false;
}

function validarExtension(file) {
    const extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
    const nombreArchivo = file.name.toLowerCase();
    const extension = nombreArchivo.split('.').pop();
    return extensionesPermitidas.includes(extension);
}

function validarContenidoImagen(file) {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => resolve(true);   // cargó bien => es imagen válida
        img.onerror = () => resolve(false); // error => no es imagen válida

        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}


async function chequeoImagen() {
    if (fileInput0.files.length > 0) {
        if (!validarPesoImagen0(fileInput0)) return;

        const file = fileInput0.files[0];

        if (!validarExtension(file)) {
            container0.innerHTML = '';
            container0.appendChild(defaultImage);
            $(".error0").html('<i class="bi bi-exclamation-triangle-fill"></i> Solo formatos de imagen permitidos (JPG, PNG, GIF)');
            $(".error0").show();
            $('#imagen').addClass('errorBorder');
            error_imagen = true;
            fileInput0.value = "";
            return;
        }

        const esImagenValida = await validarContenidoImagen(file);
        if (!esImagenValida) {
            container0.innerHTML = '';
            container0.appendChild(defaultImage);
            $(".error0").html('<i class="bi bi-exclamation-triangle-fill"></i> El archivo no es una imagen válida');
            $(".error0").show();
            $('#imagen').addClass('errorBorder');
            error_imagen = true;
            fileInput0.value = "";
            return;
        }

        // Si todo ok, mostrar imagen
        const reader = new FileReader();
        reader.onload = function(e) {
            container0.innerHTML = '';
            const image = document.createElement('img');
            image.src = e.target.result;
            image.classList.add('rounded-circle', 'mb-2');
            image.width = 250;
            image.height = 250;
            container0.appendChild(image);
            $(".error0").html("");
            $(".error0  ").hide();
            $('#imagen').removeClass('errorBorder');
            error_imagen = false;
        };
        reader.readAsDataURL(file);
    }
}

$("#imagen").on("change", function () {
    chequeoImagen();
});

$("#editarIMG").click((e) => {
    if (error_imagen) {
        Swal.fire({
            icon: 'error',
            title: 'Imagen inválida',
            text: 'Por favor selecciona una imagen válida y con tamaño menor a 2MB.'
        });
        return;
    }

    const datos = new FormData();
    datos.append("accion", "imagenPerfil");
    if ($("#imagen")[0].files[0]) {
        datos.append("imagen", $("#imagen")[0].files[0]);
        datos.append("csrfToken", $('[name="csrf_token"]').val());
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
            const res = JSON.parse(response);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: res.respuesta4.resultado === 'success' ? 'success' : 'error',
                title: res.respuesta4.mensaje,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            });

            if (res.respuesta4.resultado === 'success' && res.respuesta4.img && res.newCsrfToken) {
                $('[name="csrf_token"]').val(res.newCsrfToken);
                $("#imgPerfil").attr("src", res.img + "?v=" + new Date().getTime());
            }

            setTimeout(() => {
                location.reload();
            }, 1600);
        }
    });
}
