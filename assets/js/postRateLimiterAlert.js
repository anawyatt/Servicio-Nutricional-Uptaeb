$(document).ajaxComplete(function(event, xhr, settings) {
    try {
        const response = JSON.parse(xhr.responseText);
        if (response.estado === 'bloqueado') {
            const espera = Math.min(response.espera || 5, 3); // máximo 3 segundos
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: '¡Demasiados intentos!',
                html: `<b>${response.mensaje}</b><br><br>
                    <small>Intentos: ${response.intentos} <br> Espera: ${response.espera} segundos</small>. En caso de que los intentos sigan aumentando sera bloqueado por 5 minutos.`,
                timer: espera * 1000,
                timerProgressBar: true,
                showConfirmButton: false,
                willClose: () => {
                    if (response.intentos >= 15) {
                        window.location.reload();
                    }
                }
            });
        }
    } catch (e) {
        // Ignorar errores de parseo
    }
});
