let error_correo = false;

$(".correo").on("focusout keyup", function () {
    chequeo_correo();
});

$(document).ready(function () {
    $("#recuperar").off("click").on("click", function () {
        error_correo = false;
        chequeo_correo();

        if (!error_correo) {
            $("#recuperar").prop("disabled", true);
            recuperarCorreo();
        } else {
            mostrarToast('error', 'Ingrese el Correo electrónico!');
        }
    });
});

function chequeo_correo() {
    const campo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[cC][oO][mM]$/;
    const correo = $(".correo").val();

    if (campo.test(correo)) {
        $(".error3").hide().html("");
        $('.correo').removeClass('errorBorder');
        $('.bar3').addClass('bar');
        $('.ic3').removeClass('l').addClass('labelPri');
        $('.letra3').removeClass('labelE').addClass('label-char');
    } else {
        $(".error3").html("<i class='bi bi-exclamation-triangle-fill'></i> Ingrese el Correo Correctamente <b>(ej: User2024@gmail.com)</b> !");
        $(".error3").show();
        $('.correo').addClass('errorBorder');
        $('.bar3').removeClass('bar');
        $('.ic3').addClass('l').removeClass('labelPri');
        $('.letra3').addClass('labelE').removeClass('label-char');
        error_correo = true;
    }
}

function recuperarCorreo() {
    const correo = $('.correo').val();

    $('.loadingAnimation').show();
    $("#recuperar").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: "",
        dataType: "json",
        data: { 
            enviar: true, 
            correo
         },
        success(data) {
            if (data.resultado === 'error') {
                mostrarToast('error', data.mensaje);
            } else if (data.resultado === 'no existe') {
                mostrarToast('error', 'Error, ingrese correctamente el correo electrónico.');
            } else if (data.resultado === 'ok') {
                $('#borrarR').click(); 
                mostrarToast('success', 'Correo enviado. Revisa tu bandeja de entrada.');
            } else {
                mostrarToast('error', 'Ocurrió un error inesperado.');
            }

            $('.loadingAnimation').hide();
            $("#recuperar").prop("disabled", false);
        },
        error() {
            mostrarToast('error', 'Error de red. Intenta nuevamente.');
            $('.loadingAnimation').hide();
            $("#recuperar").prop("disabled", false);
        }
    });
}

function mostrarToast(icon, title) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon,
        title: `<span class="text-${icon === 'error' ? 'rojo' : 'verde'}">${title}</span>`,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        width: '38%',
    });
}
