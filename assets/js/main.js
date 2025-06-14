let noNotificacionesHTML = "";
notificaciones();
function notificaciones() {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { notificaciones: 'notificaciones' },
        success(data) {
            let listaGenerales = data.generales;
            
            let listaFiltradas = data.filtradas;
            let contador = 0;
        
            document.getElementById('nota').innerHTML = '';

            if (Array.isArray(listaFiltradas) && listaFiltradas.length >= 0) {
                listaGenerales.forEach(row => {
                    let notificacionHTML = `
                    <div class="noti position-relative p-3 border-bottom" data-id="${row.idNotificaciones}" style="background-color: #f9f9f9;">
                        <div class="content">
                            <h6 class="mb-1 font-weight-bold" style="color: #333;">${row.titulo}</h6>
                            <p class="mb-0 text-muted">${row.mensaje}</p>
                        </div>
                        <button class="btn btn-sm btn-primary position-absolute top-0 end-0 mt-2 me-2 delete-notification dropdown-item" data-id="${row.idNotificaciones}" style="width: 24px; height: 24px; padding: 0; border-radius: 50%; font-size: 16px; color: #fff; border: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>`;
                    contador++;
                    document.getElementById('nota').insertAdjacentHTML('afterbegin', notificacionHTML);
                });
                listaFiltradas.forEach(row => {
                    let notificacionHTML = `
                    <div class="noti position-relative p-3 border-bottom" data-id="${row.idNotificaciones}" style="background-color: #f9f9f9;">
                        <div class="content">
                            <h6 class="mb-1 font-weight-bold" style="color: #333;">${row.titulo}</h6>
                            <p class="mb-0 text-muted">${row.mensaje}</p>
                        </div>
                        <button class="btn btn-sm btn-primary position-absolute top-0 end-0 mt-2 me-2 delete-notification dropdown-item" data-id="${row.idNotificaciones}" style="width: 24px; height: 24px; padding: 0; border-radius: 50%; font-size: 16px; color: #fff; border: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>`;
                    contador++;
                    document.getElementById('nota').insertAdjacentHTML('afterbegin', notificacionHTML);

                    
                });
            } else {
                listaGenerales.forEach(row => {
                    let notificacionHTML = `
                    <div class="noti position-relative p-3 border-bottom" data-id="${row.idNotificaciones}" style="background-color: #f9f9f9;">
                        <div class="content">
                            <h6 class="mb-1 font-weight-bold" style="color: #333;">${row.titulo}</h6>
                            <p class="mb-0 text-muted">${row.mensaje}</p>
                        </div>
                        <button class="btn btn-sm btn-primary position-absolute top-0 end-0 mt-2 me-2 delete-notification dropdown-item" data-id="${row.idNotificaciones}" style="width: 24px; height: 24px; padding: 0; border-radius: 50%; font-size: 16px; color: #fff; border: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>`;
                    contador++;
                    document.getElementById('nota').insertAdjacentHTML('afterbegin', notificacionHTML);
                });
            }

            if(listaGenerales == ""){
                noNotificacionesHTML = `
                <div class="text-center p-4">
                    <h5 class="text-muted">No hay notificaciones</h5>
                </div>`;
                document.getElementById('nota').innerHTML = noNotificacionesHTML;
            }
    
            document.getElementById('notificacionCount').innerText = contador;
        }
    });
};

document.getElementById('leerTodas').addEventListener('click', function() {
    // Obtener todas las notificaciones visibles
    let notificaciones = document.querySelectorAll('#nota .noti');

    // Si no hay notificaciones, salir
    if (notificaciones.length === 0) {
        return;
    }

    // Contador para las notificaciones eliminadas
    let totalNotificaciones = notificaciones.length;

    // Iterar sobre cada notificación
    notificaciones.forEach((notificacionElement) => {
        let notificacionId = notificacionElement.getAttribute('data-id');

        // Eliminar la notificación del DOM inmediatamente
        notificacionElement.remove();

        // Actualizar el contador de notificaciones
        let notificacionCount = document.getElementById('notificacionCount');
        notificacionCount.innerText = parseInt(notificacionCount.innerText) - 1;

        // Realizar la solicitud AJAX para marcar la notificación como leída
        $.ajax({
            method: "post",
            url: "",  // Coloca la URL correcta de tu servidor para marcar la notificación como leída
            dataType: "json",
            data: { notificacionId: notificacionId },
            success: function() {
                // La notificación ha sido marcada como leída en el servidor
            },
            error: function() {
                console.error("Error al marcar la notificación como leída.");
            }
        });
    });

    // Verificar si se han eliminado todas las notificaciones
    if (totalNotificaciones > 0) {
        noNotificacionesHTML = `
            <div class="text-center p-4">
                <h5 class="text-muted">No hay notificaciones</h5>
            </div>`;
        document.getElementById('nota').innerHTML = noNotificacionesHTML;
    }
    
});
const ws = new WebSocket("ws://localhost:8080");

function onOpen() {
    console.log('Conectado al servidor WebSocket');
}

function onMessage(event) {
    try {
        let data = JSON.parse(event.data);

        if (data.type === 'nueva_notificacion') {
            addNotification(data);
        }
    } catch (error) {
        console.error("Error al procesar el mensaje:", error);
    }
}

function addNotification(data) {

    if(noNotificacionesHTML != ""){
        document.getElementById('nota').innerHTML = '';
    }

    let notificacionHTML = `
        <div class="noti position-relative p-3 border-bottom" data-id="${data.idNotificaciones}" style="background-color: #f9f9f9;">
            <div class="content">
                <h6 class="mb-1 font-weight-bold" style="color: #333;">${sanitize(data.titulo)}</h6>
                <p class="mb-0 text-muted">${sanitize(data.mensaje)}</p>
            </div>
            <button class="btn btn-sm btn-primary position-absolute top-0 end-0 mt-2 me-2 delete-notification dropdown-item" 
                    data-id="${data.idNotificaciones}" 
                    style="width: 24px; height: 24px; padding: 0; border-radius: 50%; font-size: 16px; color: #fff; border: none; 
                    display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                <i class="bi bi-x"></i>
            </button>
        </div>`;

    document.getElementById('nota').insertAdjacentHTML('afterbegin', notificacionHTML);

    updateNotificationCount(1);
}

function sanitize(text) {
    let div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function updateNotificationCount(delta) {
    let notificacionCount = document.getElementById('notificacionCount');
    notificacionCount.innerText = parseInt(notificacionCount.innerText) + delta;
}

function onClose() {
    console.log('Desconectado del servidor WebSocket');
    
}

function onError(error) {
    console.error('Error en WebSocket: ' + error);
}

function connectWebSocket() {
    const ws = new WebSocket("ws://localhost:8080");
    
    ws.onopen = onOpen;
    ws.onmessage = onMessage;
    ws.onclose = onClose;
    ws.onerror = onError;
}

connectWebSocket();


document.getElementById('nota').addEventListener('click', function(event) {
    let notificacionElement = event.target.closest('.noti');
    if (notificacionElement) {
        let notificacionId = notificacionElement.getAttribute('data-id');
        
        // Eliminar la notificación del DOM
        notificacionElement.remove();

        // Actualizar el contador de notificaciones
        let notificacionCount = document.getElementById('notificacionCount');
        notificacionCount.innerText = parseInt(notificacionCount.innerText) - 1;

        // Verificar si ya no quedan notificaciones
        let remainingNotificaciones = document.querySelectorAll('.noti').length;
        if (remainingNotificaciones === 0) {
            noNotificacionesHTML = `
                <div class="text-center p-4">
                    <h5 class="text-muted">No hay notificaciones</h5>
                </div>`;
            document.getElementById('nota').innerHTML = noNotificacionesHTML;
        }

        // Enviar solicitud AJAX para notificación leída o eliminada
        $.ajax({
            method: "post",
            url: "",  // Coloca la URL correcta de tu servidor
            dataType: "json",
            data: { notificacionId: notificacionId },
            success() {
                // Manejo del éxito de la solicitud si es necesario
            }
        });
    }
});