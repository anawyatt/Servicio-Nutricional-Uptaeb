document.addEventListener("DOMContentLoaded", () => {
    // ------------------- VARIABLES GLOBALES DE VALIDACIÓN -------------------
    const botones = document.querySelectorAll('.btnHorario');
    const inputHidden = document.getElementById('horarioSeleccionado');
    const btnGenerar = document.getElementById('generar');
    const contenedorHorario = document.getElementById('tablita22');
    let seleccionado = null;
    let error_horario = true;
    let error_cantidadE = true;

    // ------------------- LÓGICA DE SELECCIÓN DE HORARIO -------------------
    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            if (boton === seleccionado) {
                boton.classList.remove('active');
                seleccionado = null;
                inputHidden.value = "";
            } else {
                botones.forEach(b => b.classList.remove('active'));
                boton.classList.add('active');
                seleccionado = boton;
                inputHidden.value = boton.getAttribute('data-value');
            }
            chequeo_horario();
        });
    });

    function chequeo_horario() {
        const horarioSeleccionado = inputHidden.value;
        const errorElement = document.querySelector('.error30');

        if (horarioSeleccionado && horarioSeleccionado !== "") {
            errorElement.innerHTML = "";
            errorElement.style.display = 'none';
            contenedorHorario.classList.remove('error-border-container'); 
            botones.forEach(b => b.classList.remove('error-btn')); 
            error_horario = false; 
        } else {
            errorElement.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Seleccione un horario para el Menú.';
            errorElement.style.display = 'block';
            contenedorHorario.classList.add('error-border-container'); 
            
            const activo = document.querySelector('.btnHorario.active');
            if (!activo) {
                botones.forEach(b => b.classList.add('error-btn'));
            } else {
                botones.forEach(b => b.classList.remove('error-btn'));
            }
            
            error_horario = true;
        }
    }

    // ------------------- LÓGICA DE CANTIDAD DE PLATOS -------------------
    $("#cantPlatos2").focusout(function(){
        chequeo_cantidadPlatos();
    });
    
    $("#cantPlatos2").on('keyup', function(){
        chequeo_cantidadPlatos();
    });

    function chequeo_cantidadPlatos() {
        const chequeo = /^[1-9]\d*$/;
        const cantidadE = $("#cantPlatos2").val();
        if (chequeo.test(cantidadE) && parseInt(cantidadE) > 0) {
            $(".error20").html("");
            $(".error20").hide();
            $('#cantPlatos2').removeClass('errorBorder');
            $('.bar20').addClass('bar');
            $('.ic20').removeClass('l');
            $('.ic20').addClass('labelPri');
            $('.letra20').removeClass('labelE');
            $('.letra20').addClass('label-char');
            error_cantidadE = false;
        } else {
            $(".error20").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de Platos!');
            $(".error20").show();
            $('#cantPlatos2').addClass('errorBorder');
            $('.bar20').removeClass('bar');
            $('.ic20').addClass('l');
            $('.ic20').removeClass('labelPri');
            $('.letra20').addClass('labelE');
            $('.letra20').removeClass('label-char');
            error_cantidadE = true;
        }
    }

    // ------------------- EVENTO GENERAR MENÚ -------------------
    btnGenerar.addEventListener('click', (e) => {
        chequeo_horario();
        chequeo_cantidadPlatos();

        if (!error_horario && !error_cantidadE) {
            informacion(); // Llama a la función AJAX para obtener sugerencias
        } else {
            e.preventDefault();
        }
    });

    // ------------------- MANEJO DE SELECCIÓN DE MENÚ (DELEGACIÓN DE EVENTOS) -------------------
    // Este listener DEBE ir dentro de DOMContentLoaded o después de que se cargue jQuery.
    $('body').on('click', '.btn-seleccionar-menu', function() {
        // 1. Obtener los datos del menú del atributo data
        const rawData = $(this).attr('data-menu-data');
        
        // 2. Convertir la entidad HTML de vuelta a comillas, y parsear el JSON
        const menuData = JSON.parse(rawData.replace(/&quot;/g, '"'));

        // 3. Ejecutar la función para cargar los datos
        cargarMenuSeleccionado(menuData);
    });

}); // FIN document.addEventListener("DOMContentLoaded"

//--------------------------- OBTENER ALIMENTOS, REGISTRO DE ENTRADAS Y MENUS ----------------------


function informacion(){
    let horarioComida=$('#horarioSeleccionado').val();
    let cantPlatos=$('#cantPlatos2').val(); 

    console.log('datos a enviar: ', cantPlatos, horarioComida);

    $('#menuFormContent').hide(); 
    $('#loadingSpinner').show(); 
    $("#generar").prop("disabled", true);
    $("#cerrar2").prop("disabled", true); 

    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {informacionAlimentos:true, horarioComida, cantPlatos}, 
        success(data){
            if(data && data.resultado === 'exito'){
                console.log('Informacion para Generar Menus:', data);
                $('#generarMenu').modal('hide'); 
                mostrarSugerenciasMenu(data, horarioComida, cantPlatos); 
                $('#sugerenciasMenu').modal('show'); 
            } else {
                console.error('Error al obtener sugerencias de menú o resultado no exitoso:', data);
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '<span class="text-rojo">Error al Generar Menú</span>', 
                    text:  'Ocurrió un error inesperado. Inténtelo de nuevo.',
                    showConfirmButton: false,
                    timer: 8000,
                    timerProgressBar: true,
                    width: '350px',
                });
            }
        },
        error: function(xhr, status, error) {            
            if (xhr.status === 0 || status === 'timeout') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '<span class="text-rojo">¡Error de Conexión!</span>',
                    text: 'No se pudo conectar con el servidor. Por favor, revise su conexión a Internet.',
                    showConfirmButton: false,
                    timer: 8000,
                    timerProgressBar: true,
                    width: '450px',
                });
            }
        },
        complete: function() { 
            $('#loadingSpinner').hide();
            $('#menuFormContent').show(); 
            $("#generar").prop("disabled", false);
            $("#cerrar2").prop("disabled", false); 
        }
    })
}

function mostrarSugerenciasMenu(data, horarioSeleccionado, numPlatos) {
    // 1. Actualizar encabezado del modal
    $('#menuHorario').html(`Menú para ${horarioSeleccionado}`);
    $('#menuPlatos').text(numPlatos);

    const $listaSugerencias = $('#listaSugerencias');
    $listaSugerencias.empty(); // Limpiar sugerencias previas

    // 2. Generar el acordeón para cada sugerencia
    if (data.sugerencias_multiples && data.sugerencias_multiples.length > 0) {
        data.sugerencias_multiples.forEach((sugerencia, index) => {
            const collapseId = `collapseOption${index + 1}`;
            const headingId = `headingOption${index + 1}`;
            const optionNumber = index + 1;
            
            // Serializamos los datos completos del menú para pasarlos al botón
            const menuData = JSON.stringify({
                ingredientes: sugerencia.ingredientes,
                descripcion: sugerencia.descripcion_ia,
                cantPlatos: numPlatos,
                horario: horarioSeleccionado
            }).replace(/"/g, '&quot;'); // Escapar comillas para el atributo HTML

            // Creamos el elemento del acordeón completo
            const accordionItem = `
                <div class="accordion-item shadow-sm mb-3 rounded">
                    <h2 class="accordion-header" id="${headingId}">
                        <button class="accordion-button bg-azul7 azul4 fw-bold ${index === 0 ? '' : 'collapsed'}" 
                                type="button" data-bs-toggle="collapse"
                                data-bs-target="#${collapseId}" 
                                aria-expanded="${index === 0 ? 'true' : 'false'}" 
                                aria-controls="${collapseId}">
                            Menú Opción ${optionNumber}
                        </button>
                    </h2>
                    <div id="${collapseId}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                        aria-labelledby="${headingId}"
                        data-bs-parent="#listaSugerencias">
                        <div class="accordion-body">
                            <h6 class="azul fw-bold">Descripción:</h6>
                            <p>${sugerencia.descripcion_ia}</p>
                            <h6 class="azul fw-bold">Justificación:</h6>
                            <p>${sugerencia.justificacion_ia}</p> 
                            
                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" 
                                        class="btn btn-primary btn-seleccionar-menu" 
                                        data-menu-data="${menuData}">
                                    Seleccionar Menú
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $listaSugerencias.append(accordionItem);
        });

        // Opcional: Mostrar las justificaciones globales
     
        
    } else {
        // En caso de que no haya sugerencias
        $listaSugerencias.html('<div class="alert alert-warning" role="alert">No se encontraron sugerencias de menú.</div>');
    }
}


/**
 * Lógica para cargar los datos del menú seleccionado a los campos del formulario principal.
 * @param {Object} menuData - Datos del menú seleccionado.
 */
function cargarMenuSeleccionado(menuData) {
    const { ingredientes, descripcion, cantPlatos, horario } = menuData;

    // 1. VACIAR Y OCULTAR TABLAS PREVIAS
    vaciarTabla(); // Reutiliza tu función
    $('#tablaD').hide();
    $('#ani').hide();

    // 2. LLENAR CAMPOS DE CABECERA
    
    $('#cantPlatos').val(cantPlatos);
    
    $('#descripcion').val(descripcion); 
    $('input[name="opcion"]').prop('checked', false);
    $('input[name="opcion"][value="' + horario + '"]').prop('checked', true);


    // 3. LLENAR LA TABLA DE ALIMENTOS
    
    // Iteramos sobre los ingredientes y llamamos a mostrarInfo por cada uno
    ingredientes.forEach(ingrediente => {
        const idAlimento = ingrediente.idAlimento;
        const cantidad = ingrediente.cantidad_requerida;
        const unidad = ingrediente.unidadMedida_sugerida; 
        
        // La función mostrarInfo tiene un AJAX interno para obtener datos adicionales
        mostrarInfo(idAlimento, cantidad, unidad);
    });

    // 4. CERRAR EL MODAL DE SUGERENCIAS
    $('#sugerenciasMenu').modal('hide');
    
    // 5. MOSTRAR LA TABLA (Se refuerza, aunque ya se hace en mostrarInfo)
    $('#tablaD').show(1000);
    $('#ani').show(1000);
}

// ------------------- FUNCIONES AUXILIARES (DEJADAS AL FINAL) -------------------

function validarTabla() {
    if ($('.tabla tbody tr').length === 0) {
        $('#ani').hide(1000)
        $('#tablaD').hide(1000);
    } 
}

function vaciarTabla() {
    const tabla = document.getElementById('tabla').getElementsByTagName('tbody')[0];
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }

    const tabla2 = document.getElementById('tabla2').getElementsByTagName('tbody')[0];
    while (tabla2.firstChild) {
        tabla2.removeChild(tabla2.firstChild);
    }
}