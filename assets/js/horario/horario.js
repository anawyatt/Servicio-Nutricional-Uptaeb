let error_horario = false;

// Función para manejar la interfaz de usuario cuando el horario es válido
function applyValidStyle() {
    $(".error1").html("").hide();
    $('#horario').removeClass('errorBorder');
    $('.bar1').addClass('bar');
    $('.ic1').removeClass('l').addClass('labelPri');
    $('.letra1').removeClass('labelE').addClass('label-char');
}

// Validar horario
function chequeo_horario() { 
    const horario = $("#horario").val();
    if (horario != 'Seleccionar') {
        applyValidStyle();
        error_horario = false;
    } else {
        $(".error1").html('<i class="bi bi-exclamation-triangle-fill"></i> Seleccione el tipo de alimento!').show();
        $('#horario').addClass('errorBorder');
        $('.bar1').removeClass('bar');
        $('.ic1').addClass('l').removeClass('labelPri');
        $('.letra1').addClass('labelE').removeClass('label-char');
        error_horario = true;
    }
}

// Resetea la interfaz de usuario a su estado primario
function primary() {
    applyValidStyle();
    $('#horario').removeClass('is-invalid');
}

function ingresar() {
    const horario = $('#horario').val();

    $.ajax({
        type: "post",
        url: '',
        dataType: 'json',
        data: { ingresar: true, horario },
        success: function(data) {
            if (data.resultado == 'success' && data.url) {
                location = data.url;
                primary();
            }
        }
    });
}

// Event listeners
$("#horario").on('change', chequeo_horario);

$("#registrar").on('click', function() {
    error_horario = false;
    chequeo_horario();

    if (!error_horario) {
        ingresar();
    } else {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '<span class=" text-rojo">Seleccione el horario de comida!</span>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: 3000,
            width: '38%'
        });
    }
});