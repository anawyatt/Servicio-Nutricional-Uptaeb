document.addEventListener('DOMContentLoaded', () => {
  function setupEyeToggle(eyeId, inputId) {
    const eye = document.getElementById(eyeId);
    const input = document.getElementById(inputId);
    if (!eye || !input) return;
    const eyeSi = eye.querySelector('.eyeSi');
    const eyeNo = eye.querySelector('.eyeNo');

    eye.addEventListener('click', () => {
      if (input.type === 'password') {
        input.type = 'text';
        eyeSi.classList.remove('d-none');
        eyeNo.classList.add('d-none');
      } else {
        input.type = 'password';
        eyeSi.classList.add('d-none');
        eyeNo.classList.remove('d-none');
      }
    });
  }

  setupEyeToggle('eye1', 'nuevaClave');
  setupEyeToggle('eye2', 'confirmarClave');
});


let error_codigo = true;
let error_clave = true;
let error_confirmar = true;

function validarCodigo() {
    const chequeo = /^[0-9]{6}$/; 
    const codigo = $(".codigo").val().trim();

    if (chequeo.test(codigo) && codigo !== '') {
        $(".error1").html("").hide();
        $(".codigo").removeClass("errorBorder");
        $(".bar1").addClass("bar");
        $(".ic1").removeClass("l").addClass("labelPri");
        $(".letra").removeClass("labelE").addClass("label-char");
        error_codigo = false;
    } else {
        $(".error1").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese un código válido de 6 dígitos');
        $(".error1").show();
        $(".codigo").addClass("errorBorder");
        $(".bar1").removeClass("bar");
        $(".ic1").addClass("l").removeClass("labelPri");
        $(".letra").addClass("labelE").removeClass("label-char");
        error_codigo = true;
    }
}




function validarClave() {
    const clave = $(".clave1").val().trim();
    const chequeo = /^[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;

    if (chequeo.test(clave)) {
        $(".error2").html("").hide();
        $(".clave1").removeClass("errorBorder");
        $(".bar2").addClass("bar");
        $(".ic2").removeClass("l").addClass("labelPri");
        $(".letra2").removeClass("labelE").addClass("label-char");
        error_clave = false;
    } else {
        $(".error2").html('<i class="bi bi-exclamation-triangle-fill"></i> La clave debe tener al menos 8 caracteres, incluyendo letras y números');
        $(".error2").show();
        $(".clave1").addClass("errorBorder");
        $(".bar2").removeClass("bar");
        $(".ic2").addClass("l").removeClass("labelPri");
        $(".letra2").addClass("labelE").removeClass("label-char");
        error_clave = true;
    }
}


function validarConfirmacion() {
    const clave = $(".clave1").val().trim();
    const confirmar = $(".clave2").val().trim();
    const regex = /^[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;

    if (confirmar === "") {
        $(".error3").html('<i class="bi bi-exclamation-triangle-fill"></i> Confirme la contraseña');
        $(".error3").show();
        error_confirmar = true;

    } else if (!regex.test(confirmar)) {
        $(".error3").html('<i class="bi bi-exclamation-triangle-fill"></i>La clave debe tener al menos 8 caracteres, incluyendo letras y números');
        $(".error3").show();
        error_confirmar = true;

    } else if (confirmar !== clave) {
        $(".error3").html('<i class="bi bi-exclamation-triangle-fill"></i> Las contraseñas no coinciden');
        $(".error3").show();
        error_confirmar = true;

    } else {
        $(".error3").html("").hide();
        error_confirmar = false;
    }
}




$("#formnuevaClave").on("submit", function (e) {
    e.preventDefault();
     console.log("Formulario enviado, JS funciona!");
     alert("Formulario capturado por JS");

    validarCodigo();
    validarClave();
    validarConfirmacion();

    if (error_codigo || error_clave || error_confirmar) return;

    const codigo = $("#codigo").val().trim();
    const nuevaClave = $("#nuevaClave").val().trim();
    const confirmarClave = $("#confirmarClave").val().trim();
    const token = $("#token").val();

    if (!codigo || !nuevaClave || !confirmarClave) {
        Swal.fire({
            icon: 'warning',
            title: 'Por favor, complete todos los campos',
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
        return;
    }

    if (nuevaClave !== confirmarClave) {
        Swal.fire({
            icon: 'warning',
            title: 'Las contraseñas no coinciden',
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "", 
        data: { 
            codigo, 
            nuevaClave, 
            confirmarClave, 
            token 
        },
        dataType: "json",
        success: function (response) {
            if (response.resultado === "ok") {
                Swal.fire({
                    icon: 'success',
                    title: response.mensaje || 'Contraseña actualizada correctamente',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
                setTimeout(() => location.href = response.url, 3000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: response.mensaje || response.error || 'Error desconocido',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error de red',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
});

$(".codigo").on("input", validarCodigo);
$(".clave1").on("input", validarClave);
$(".clave2").on("input", validarConfirmacion);