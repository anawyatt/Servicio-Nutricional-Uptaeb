
var noNotificacionesHTML = ""; 
const userCedula = window.userCedulaGlobal; 

notificaciones();

// =========================================================
// 1. FUNCIONES AJAX PARA CARGAR Y MANEJAR EL ESTADO DE LAS NOTIFICACIONES
// =========================================================

function notificaciones() {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { obtenerNotificaciones: true },
        success(data) {
            let listaGenerales = data || [];
            let contador = 0;

            document.getElementById('nota').innerHTML = '';

            const todasLasNotificaciones = [...listaGenerales];

            if (todasLasNotificaciones.length > 0) {
                todasLasNotificaciones.forEach(row => {
                    renderNotification(row, false); 
                    contador++;
                });
            } else {
                showNoNotificationsMessage();
            }
        
            document.getElementById('notificacionCount').innerText = contador;
        },
        error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error al cargar notificaciones:", textStatus, errorThrown);
        }
    });
};

document.getElementById('leerTodas').addEventListener('click', function() {
    let notificaciones = document.querySelectorAll('#nota .noti');
    if (notificaciones.length === 0) {
        return;
    }

    let notificacionCountElement = document.getElementById('notificacionCount');

    // 💡 Mejora UX: Mostrar un mensaje temporal de "Leyendo..." mientras se procesan.
    let originalText = notificacionCountElement.innerText;
    notificacionCountElement.innerText = '...'; 

    // Usamos Promise.all para esperar a que todas las AJAX terminen (opcional, pero mejor)
    const ajaxPromises = [];

    notificaciones.forEach((notificacionElement) => {
        let notificacionId = notificacionElement.getAttribute('data-id');

        // Eliminación visual inmediata
        notificacionElement.remove();
        
        // Llamada AJAX para marcar como leída
        const promise = $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { marcarTodasLeidas: true }
        }).fail(function() {
             console.error(`Error al marcar ${notificacionId} como leída.`);
        });
        ajaxPromises.push(promise);
    });

    Promise.all(ajaxPromises).finally(() => {
        updateNotificationCount(-notificaciones.length); // Resta el total
        if (parseInt(notificacionCountElement.innerText) === 0) {
            showNoNotificationsMessage();
        }
    });
});

document.getElementById('nota').addEventListener('click', function(event) {
    let closeButton = event.target.closest('.delete-notification');
    let notificacionElement = event.target.closest('.noti');
    
    if (closeButton) {
        event.stopPropagation(); 

        if (notificacionElement) {
            let notificacionId = notificacionElement.getAttribute('data-id');

            notificacionElement.remove();
            updateNotificationCount(-1);

            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { marcarLeida: true, notificacionId: notificacionId }
            });
        }
    } else if (notificacionElement) {
        // Lógica para MARCAR COMO LEÍDA (al hacer clic en el cuerpo)
        if (notificacionElement.classList.contains('noti-unread')) {
            notificacionElement.classList.remove('noti-unread');
            notificacionElement.classList.add('noti-read'); 
            updateNotificationCount(-1); // Reducir el contador de no leídas

            let notificacionId = notificacionElement.getAttribute('data-id');
            
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { marcarLeida: true, notificacionId: notificacionId }
            });
        }
    }
});


// =========================================================
// 2. GESTIÓN DE SOCKET.IO Y NOTIFICACIONES EN TIEMPO REAL
// =========================================================

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
    // Renderiza como nueva (isNew: true)
    renderNotification(data, true); 
    updateNotificationCount(1);
});

// =========================================================
// 3. FUNCIONES DE UTILIDAD (RENDERING, CONTADOR, SANITIZACIÓN)
// =========================================================

/**
 * Renderiza la notificación en el DOM.
 * @param {object} data - Objeto con idNotificaciones, titulo, mensaje, y el nuevo campo 'tipo' o 'categoria'.
 * @param {boolean} isNew - Indica si es una notificación en tiempo real (true) para aplicar estilos de "no leído".
 */
function renderNotification(data, isNew) {

    // Si había un mensaje de "No hay notificaciones", lo eliminamos.
    if(noNotificacionesHTML !== "" && isNew) {
        document.getElementById('nota').innerHTML = '';
        noNotificacionesHTML = "";
    }

    // Determina la clase CSS para el estado
    const statusClass = isNew ? 'noti-unread' : 'noti-read';
    
    // Asumiendo que 'data' tiene un campo 'tipo' (ej. 'solicitud', 'sistema', 'nuevo')
    // 💡 Asegúrate de que tu backend envíe el campo 'tipo' (o cámbialo a 'categoria' si prefieres)
    const tipoNotificacion = data.tipo || 'general'; // Valor por defecto
    
    // Formateo de la hora
    const now = new Date();
    const hora = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Mapeo de tipos a estilos (usa colores de Bootstrap: primary, danger, success, warning)
    const metadata = {
        'solicitud': { icon: 'bi-person-check', colorClass: 'bg-primary' }, // Azul: Solicitudes/Acciones
        'alerta': { icon: 'bi-exclamation-triangle-fill', colorClass: 'bg-danger' }, // Rojo: Errores/Alertas críticas
        'sistema': { icon: 'bi-gear-fill', colorClass: 'bg-info' }, // Celeste: Mantenimiento/Info del sistema
        'exito': { icon: 'bi-check-circle-fill', colorClass: 'bg-success' }, // Verde: Operaciones exitosas
        'general': { icon: 'bi-bell-fill', colorClass: 'bg-secondary' } // Gris: Notificaciones genéricas
    };
    
   const meta = metadata[tipoNotificacion] || metadata['general'];
const iconClass = meta.icon;
const iconColorClass = meta.colorClass; 

// ✅ Si no viene fechaNoti, usar fecha/hora actual
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

// 🕐 Si viene formato ISO, reemplazar la T
if (fechaNotiRaw.includes('T')) {
  fechaNotiRaw = fechaNotiRaw.replace('T', ' ').replace(/(Z|[+-]\d{2}:\d{2})$/, '');
}

// 📅 Separar fecha y hora
const [fechaPart, horaPart = '00:00:00'] = fechaNotiRaw.split(' ');

// 📆 Fecha local de hoy (formato YYYY-MM-DD)
const hoyLocal = new Date();
const año = hoyLocal.getFullYear();
const mes = String(hoyLocal.getMonth() + 1).padStart(2, '0');
const dia = String(hoyLocal.getDate()).padStart(2, '0');
const fechaHoy = `${año}-${mes}-${dia}`;

// ✅ Mostrar hora si es de hoy, fecha si no lo es
const mostrarFechaHora = (fechaPart === fechaHoy)
  ? horaPart.slice(0, 5)
  : fechaPart;

let notificacionHTML = `
  <div class="noti ${statusClass} d-flex" data-id="${data.idNotificaciones}"> 
      
      <div class="content flex-grow-1">
          <div class="d-flex align-items-center mb-1">
              <i class="bi ${iconClass} title-icon me-2" style="color: var(--bs-primary, #007bff);"></i> 
              <h6 class="fw-bold text-primary noti-title mb-0">${sanitize(data.titulo)}</h6>
          </div>
          <p class="mb-0 text-muted small noti-message">${sanitize(data.mensaje)}</p>
      </div>
      
      <div class="ms-auto text-end d-flex flex-column justify-content-between align-items-end flex-shrink-0">
          <button class="delete-notification p-0 btn-link" aria-label="Cerrar" data-id="${data.idNotificaciones}" style="border:none; background:none;">
              <i class="bi bi-x-lg" style="font-size: 0.8rem; color: #007bff;"></i>
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
    
    // Asegura que el contador nunca sea negativo
    let newCount = Math.max(0, currentCount + delta);
    
    notificacionCount.innerText = newCount;

    // Asegurar que el mensaje de "No hay notificaciones" se muestre si el contador llega a 0
    if (newCount === 0) {
        showNoNotificationsMessage();
    }
}