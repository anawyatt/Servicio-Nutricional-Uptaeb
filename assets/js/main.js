var noNotificacionesHTML = "";
const userCedula = window.userCedulaGlobal; // Asumiendo que esta variable está definida

notificaciones();

function notificaciones() {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { obtenerNotificaciones: true },
        success(data) {
            let listaNotificaciones = data || [];
            let unreadCount = 0;

            document.getElementById('nota').innerHTML = '';

            if (listaNotificaciones.length > 0) {
                listaNotificaciones.forEach(row => {
                    renderNotification(row); 
                    if (row.leida == 0) {
                        unreadCount++;
                    }
                });
            } else {
                showNoNotificationsMessage();
            }
            
            // Actualiza el contador con el número de notificaciones NO LEÍDAS
            document.getElementById('notificacionCount').innerText = unreadCount;
        },
        error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error al cargar notificaciones:", textStatus, errorThrown);
        }
    });
};

document.getElementById('leerTodas').addEventListener('click', function() {
    let notificacionesNoLeidas = document.querySelectorAll('#nota .noti-unread');
    if (notificacionesNoLeidas.length === 0) {
        return;
    }

    // 1. Actualización visual inmediata y conteo
    const totalToMark = notificacionesNoLeidas.length;
    notificacionesNoLeidas.forEach((notificacionElement) => {
        notificacionElement.classList.remove('noti-unread');
        notificacionElement.classList.add('noti-read');
        // También puedes cambiar el data-leida para consistencia, si lo usas
        notificacionElement.setAttribute('data-leida', 1); 
    });
    updateNotificationCount(-totalToMark);

    // 2. Llamada AJAX para marcar todas
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { marcarTodasLeidas: true }
    }).done(function(response) {
        if (response.success) {
            console.log('Todas las notificaciones marcadas como leídas en el servidor.');
        }
    }).fail(function() {
        console.error('Error al marcar todas como leídas en el servidor.');
    });
});

document.getElementById('nota').addEventListener('click', function(event) {
    let closeButton = event.target.closest('.delete-notification');
    let notificacionElement = event.target.closest('.noti');
    
    if (!notificacionElement) return; // No es un elemento de notificación

    let notificacionId = notificacionElement.getAttribute('data-id');
    let isUnread = notificacionElement.getAttribute('data-leida') === '0';

    if (closeButton) {
        event.stopPropagation(); 
        
        // 🚨 CAMBIO CLAVE: Reemplazo de confirm() por Swal.fire()
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción eliminará la notificación permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Rojo
            cancelButtonColor: '#1659d6ff', // Gris
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, procedemos con la eliminación
                
                // 1. Eliminación visual inmediata
                notificacionElement.remove();

                // 2. Si era no leída, decrementa el contador
                if (isUnread) {
                    updateNotificationCount(-1);
                }

                // 3. Llamada AJAX para ELIMINAR
                $.ajax({
                    method: "post",
                    url: "",
                    dataType: "json",
                    data: { eliminarNotificacion: true, notificacionId: notificacionId }
                }).done(function() {
                    // Opcional: Mostrar un pequeño mensaje de éxito después de eliminar
                    // Swal.fire('Eliminada!', 'La notificación ha sido eliminada.', 'success');
                }).fail(function() {
                     console.error(`Error al eliminar la notificación ${notificacionId}.`);
                     // Opcional: Mostrar un mensaje de error si la eliminación falla en el servidor
                     Swal.fire('Error', 'Hubo un problema al intentar eliminar la notificación.', 'error');
                });
                
                // 4. Revisar si hay que mostrar el mensaje de "No hay notificaciones"
                if (document.querySelectorAll('#nota .noti').length === 0) {
                    showNoNotificationsMessage();
                }
            }
        });

    } else {
        // Lógica para MARCAR COMO LEÍDA (al hacer clic en el cuerpo)
        if (isUnread) {
            // 1. Actualización visual
            notificacionElement.classList.remove('noti-unread');
            notificacionElement.classList.add('noti-read');
            notificacionElement.setAttribute('data-leida', 1);
            
            // 2. Actualización de contador
            updateNotificationCount(-1); 

            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { marcarLeida: true, notificacionId: notificacionId }
            });
        }
    }
});



// Conexión al servidor Node.js/Socket.IO en el puerto 3000
const socket = io('http://localhost:3000'); 

socket.on('connect', () => {
    console.log('✅ Conectado al servidor de notificaciones Socket.IO.');

    if (userCedula) {
        socket.emit('register_cedula', userCedula); 
    }
});

socket.on('disconnect', () => {
    console.log('❌ Desconectado de Socket.IO.');
});

// Escucha el evento 'nueva_notificacion_push' que envía Node.js.
socket.on('nueva_notificacion_push', (data) => {
    console.log('🔔 Notificación en tiempo real recibida!', data);
    
    // Aseguramos que la notificación en tiempo real se considere NO LEÍDA (leida: 0)
    data.leida = 0; 
    
    renderNotification(data); 
    updateNotificationCount(1);
});



/**
 * Renderiza la notificación en el DOM.
 * @param {object} data - Objeto con idNotificaciones, titulo, mensaje, fechaNoti, tipo, leida.
 */
function renderNotification(data) {

    // Si había un mensaje de "No hay notificaciones", lo eliminamos.
    if(noNotificacionesHTML !== "" && document.getElementById('nota').children.length === 0) {
        document.getElementById('nota').innerHTML = '';
        noNotificacionesHTML = "";
    }

    // 🚨 CAMBIO CLAVE: Usar data.leida (0 o 1) para determinar la clase CSS
    const isUnread = data.leida == 0;
    const statusClass = isUnread ? 'noti-unread' : 'noti-read';

    const tipoNotificacion = data.tipo || 'general'; 
    const metadata = {
        'Menu': { icon: 'bi-cup-fill', colorClass: 'bg-primary' }, 
        'Evento': { icon: 'bi-calendar-event-fill', colorClass: 'bg-warning' }, 
        'solicitud': { icon: 'bi-person-check', colorClass: 'bg-primary' }, 
        'alerta': { icon: 'bi-exclamation-triangle-fill', colorClass: 'bg-danger' },
        'sistema': { icon: 'bi-gear-fill', colorClass: 'bg-info' }, 
        'exito': { icon: 'bi-check-circle-fill', colorClass: 'bg-success' }, 
        'general': { icon: 'bi-bell-fill', colorClass: 'bg-secondary' } 
    };
    
    const meta = metadata[tipoNotificacion] || metadata['general'];
    const iconClass = meta.icon;
    const iconColorClass = meta.colorClass; 

    // ✅ Lógica de Formato de Fecha/Hora (Tu código original)
    let fechaNotiRaw = data.fechaNoti;
    if (!fechaNotiRaw) {
        const ahora = new Date();
        const año = ahora.getFullYear();
        const mes = String(ahora.getMonth() + 1).padStart(2, '0');
        const dia = String(ahora.getDate()).padStart(2, '0');
        const hora = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        fechaNotiRaw = `${año}-${mes}-${dia} ${hora}:${minutos}:00`;
    }

    if (fechaNotiRaw.includes('T')) {
        fechaNotiRaw = fechaNotiRaw.replace('T', ' ').replace(/(Z|[+-]\d{2}:\d{2})$/, '');
    }

    const [fechaPart, horaPart = '00:00:00'] = fechaNotiRaw.split(' ');

    const hoyLocal = new Date();
    const año = hoyLocal.getFullYear();
    const mes = String(hoyLocal.getMonth() + 1).padStart(2, '0');
    const dia = String(hoyLocal.getDate()).padStart(2, '0');
    const fechaHoy = `${año}-${mes}-${dia}`;

    const mostrarFechaHora = (fechaPart === fechaHoy)
        ? horaPart.slice(0, 5)
        : fechaPart;


    let notificacionHTML = `
     <div class="noti ${statusClass} d-flex" data-id="${data.idNotificaciones}" data-leida="${data.leida}"> 
          
          <div class="content flex-grow-1">
              <div class="d-flex align-items-center mb-1">
                  <i class="bi ${iconClass} title-icon me-2" style="color: var(--bs-primary, #007bff);"></i> 
                  <h6 class="fw-bold text-primary noti-title mb-0">${sanitize(data.titulo)}</h6>
              </div>
              <p class="mb-0 text-muted small noti-message">${sanitize(data.mensaje)}</p>
          </div>
          
          <div class="ms-auto text-end d-flex flex-column justify-content-between align-items-end flex-shrink-0">
              <button class="delete-notification p-0 btn-link" aria-label="Eliminar" style="border:none; background:none;">
                  <i class="bi bi-x-lg" style="font-size: 0.8rem; color: #007bff;" title="Eliminar Notificación"></i>
              </button>
              <small class="text-secondary fw-light noti-time mt-3">${mostrarFechaHora}</small>
          </div>
      </div>`;

    document.getElementById('nota').insertAdjacentHTML('afterbegin', notificacionHTML);

}

function showNoNotificationsMessage() {
    noNotificacionesHTML = `
        <div class="text-center p-4">
            <h5 class="text-muted">No hay notificaciones</h5>
        </div>`;
    document.getElementById('nota').innerHTML = noNotificacionesHTML;
}

/**
 * Sanitiza el texto para prevenir ataques XSS.
 * @param {string} text - El texto a sanitizar.
 * @returns {string} El texto HTML seguro.
 */
function sanitize(text) {
    let div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Actualiza el contador de notificaciones no leídas en la interfaz.
 * @param {number} delta - El cambio a aplicar al contador (+1, -1, o -N).
 */
function updateNotificationCount(delta) {
    let notificacionCount = document.getElementById('notificacionCount');
    let currentCount = parseInt(notificacionCount.innerText) || 0;

    let newCount = Math.max(0, currentCount + delta);
    
    notificacionCount.innerText = newCount;

    if (newCount === 0) {
        if (document.querySelectorAll('#nota .noti').length === 0) {
             showNoNotificationsMessage();
        }
    }
}




document.addEventListener('DOMContentLoaded', function () {
  const dropdown = document.querySelector('.sub-drop.dropdown-menu');
  if (dropdown) {
    dropdown.addEventListener('click', e => e.stopPropagation());
  }

  const cerrar = document.getElementById('cerrarDropdown');
  if (cerrar) {
    cerrar.addEventListener('click', () => {
      const dropdownEl = bootstrap.Dropdown.getInstance(
        document.getElementById('notification-drop')
      );
      if (dropdownEl) dropdownEl.hide(); // cierra manualmente el dropdown
    });
  }
});