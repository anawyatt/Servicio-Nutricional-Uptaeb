// Declaraciones y referencias DOM agrupadas
const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const registerBtn2 = document.getElementById('register2');
const loginBtn2 = document.getElementById('login2');

// Variables globales
let error_usuario = false;
let error_clave = false;
let pwShown = 0;
let isLoginInProgress = false; // Variable para controlar múltiples clics

// Función para limpiar validaciones
function limpiarValidaciones() {
    $(".error1, .error2").html("").hide();
    $('.cedula, .clave').removeClass('errorBorder');
    $('.bar1, .bar2').addClass('bar');
    $('.ic1, .ic2, .ojo').removeClass('l').addClass('labelPri');
    $('.letra, .letra2').removeClass('labelE').addClass('label-char');
}

// Funciones de navegación
function switchToRegister() {
    container.classList.add("active");
    $('#borrarL').click();
    limpiarValidaciones();
}

function switchToLogin() {
    container.classList.remove("active");
    $('#borrarR').click();
    limpiarValidaciones();
}

// Event listeners para navegación
registerBtn.addEventListener('click', switchToRegister);
loginBtn.addEventListener('click', switchToLogin);
registerBtn2.addEventListener('click', switchToRegister);
loginBtn2.addEventListener('click', switchToLogin);

// Funciones para controlar visibilidad de contraseña
function show() {
    const p = document.getElementById('clave');
    p.setAttribute('type', 'text');
    $('.eyeSi').removeClass('d-none');
    $('.eyeNo').addClass('d-none');
}

function hide() {
    const p = document.getElementById('clave');
    p.setAttribute('type', 'password');
    $('.eyeSi').addClass('d-none');
    $('.eyeNo').removeClass('d-none');
}

// Event listener para el botón de visualización de contraseña
document.getElementById("eye").addEventListener("click", function() {
    pwShown = pwShown === 0 ? 1 : 0;
    pwShown === 1 ? show() : hide();
}, false);

// Funciones de validación
function chequeo_usuario() {
    const campo = /^[0-9]{6,8}$/;
    const cedulaPaciente = $(".cedula").val();
    
    if (campo.test(cedulaPaciente) && cedulaPaciente !== '') {
        $(".error1").html("").hide();
        $('.cedula').removeClass('errorBorder');
        $('.bar1').addClass('bar');
        $('.ic1').removeClass('l').addClass('labelPri');
        $('.letra').removeClass('labelE').addClass('label-char');
        error_usuario = false;
    } else {
        $(".error1").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese el Usuario!').show();
        $('.cedula').addClass('errorBorder');
        $('.bar1').removeClass('bar');
        $('.ic1').addClass('l').removeClass('labelPri');
        $('.letra').addClass('labelE').removeClass('label-char');
        error_usuario = true;
    }
}

function chequeo_clave() {
    const chequeo = /^[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/;
    const nombre = $(".clave").val();
    
    if (chequeo.test(nombre) && nombre !== '') {
        $(".error2").hide().html("");
        $('.clave').removeClass('errorBorder');
        $('.bar2').addClass('bar');
        $('.ic2, .ojo').removeClass('l').addClass('labelPri');
        $('.letra2').removeClass('labelE').addClass('label-char');
        error_clave = false;
    } else {
        $(".error2").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese la Contraseña!').show();
        $('.clave').addClass('errorBorder');
        $('.bar2').removeClass('bar');
        $('.ic2, .ojo').addClass('l').removeClass('labelPri');
        $('.letra2').addClass('labelE').removeClass('label-char');
        error_clave = true;
    }
}

// Función para mostrar errores generales
function mostrarError(mensaje = "Error de Usuario o Contraseña!") {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: `<span class="text-rojo">${mensaje}</span>`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        width: '38%',
    });

    $('.cedula, .clave').addClass('errorBorder');
    $('.bar1, .bar2').removeClass('bar');
    $('.ic1, .ic2, .ojo').addClass('l').removeClass('labelPri');
    $('.letra, .letra2').addClass('labelE').removeClass('label-char');
}

function limpiarErrores() {
    $('.cedula, .clave').removeClass('errorBorder');
    $('.bar1, .bar2').addClass('bar');
    $('.ic1, .ic2, .ojo').removeClass('l').addClass('labelPri');
    $('.letra, .letra2').removeClass('labelE').addClass('label-char');
}

function validarLogin() {
    let cedula = $(".cedula").val().trim();
    let clave = $(".clave").val();

    limpiarErrores();

    if (!cedula || !clave) {
        mostrarError("Por favor, ingresa cédula y contraseña.");
        return false;
    }
    return true;
}

function ingresar() {
    // Verificar si ya hay un login en progreso
    if (isLoginInProgress) {
        return;
    }

    if (!validarLogin()) return;

    // Marcar que el login está en progreso
    isLoginInProgress = true;
    
    const btnLogin = $('#iniciar');
    btnLogin.prop('disabled', true);

    $.ajax({
        type: "POST",
        url: '', 
        dataType: 'json',
        data: {
            cedula: $(".cedula").val().trim(),
            clave: $(".clave").val()
        },
        success: function(data) {
            btnLogin.prop('disabled', false);
            isLoginInProgress = false; // Liberar el bloqueo

            if (data.resultado === 'error') {
                mostrarError(data.mensaje || "Error desconocido");
            } else if (data.resultado === 'success' && data.url) {
                console.log("Redirigiendo a:", data.url);
                window.location.href = data.url;  
            } else {
                mostrarError("Respuesta inesperada del servidor.");
            }
        },
        error: function(xhr, status, error) {
            btnLogin.prop('disabled', false);
            isLoginInProgress = false; // Liberar el bloqueo en caso de error
            mostrarError("Error en la conexión con el servidor.");
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

// Event listeners de validación
$(document).ready(function() {
    // Ocultar mensajes de error inicialmente
    $(".error1, .error2").hide();
    
    // Event listeners para validación de campos
    $(".cedula").on('focusout keyup', chequeo_usuario);
    $(".clave").on('focusout keyup', chequeo_clave);
    
    // Event listener para iniciar sesión con protección contra múltiples clics
    $('#iniciar').on('click', function(e) {
        e.preventDefault();
        
        // Evitar múltiples clics si ya hay un proceso en curso
        if (isLoginInProgress) {
            return;
        }
        
        error_usuario = false;
        error_clave = false;
        
        chequeo_usuario();
        chequeo_clave();

        if (!error_usuario && !error_clave) {
            ingresar();
        } else {
            mostrarError();
        }
    });
});