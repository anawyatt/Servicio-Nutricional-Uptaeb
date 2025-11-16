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
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {informacionAlimentos:true, horarioComida, cantPlatos}, 
        success(data){
            if(data && data.resultado === 'exito'){
                console.log('Informacion para Generar Menus:', data);
                $('#generarMenu').modal('hide'); // Ocultar modal de generación
                mostrarSugerenciasMenu(data, horarioComida, cantPlatos); 
                $('#sugerenciasMenu').modal('show'); // Mostrar modal de sugerencias
            } else {
                console.error('Error al obtener sugerencias de menú o resultado no exitoso:', data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', status, error);
        }
    })
}

/**
 * Muestra las sugerencias de menú en el modal #sugerenciasMenu.
 */
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
        if (data.justificaciones_globales && data.justificaciones_globales.length > 0) {
            // Usamos párrafos para evitar puntos de lista (li)
            const justificacionesHtml = data.justificaciones_globales.map(justificacion => `<p class="mb-1">${justificacion}</p>`).join('');
            
            const alertHtml = `
                <div id="alerts" data-aos="fade-up" data-aos-delay="1000" class="mb-3">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h6 class="fw-bold mb-2">Justificaciones Generales:</h6>
                        
                        <div style="font-size: 13px!important;" align="justify">
                            ${justificacionesHtml}
                        </div>
                        
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            `;
            $listaSugerencias.prepend(alertHtml);
        }
        
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

function newAlimento(idA,imagen, codigo, alimento, marca, cantidad, unidad, contNeto) {
// ... (Tu función newAlimento sin cambios) ...
let unidadMedida;
let cont;

if (marca === 'Sin Marca') {
  cont = '';
if (unidad === 'Unidad' && cantidad > 1) {
  unidadMedida = unidad + 'es';
}
else{
  unidadMedida = unidad;
}
}
else{
  unidadMedida = 'Unidad';
  if (cantidad > 1) {
    unidadMedida = 'Unidades';
  }
  cont = `- ${contNeto}`;
}
let newAlimento = `

    <tr class='${codigo}'>
       <td class='d-none'><input class='d-none' id='idAlimento' value='${idA}'></td>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${alimento} ${cont}</td>
       <td>${marca}</td>
       <td>${cantidad} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
       <td>
          <a id='quitarFila'  class="btn btn-sm btn-icon text-danger text-center " value='${codigo}'   data-bs-toggle="tooltip" title="Borrar Alimento"   type="button" >
                 <i class="bi bi-trash icon-24 t" width="20"></i>
          </a>
       </td>
    
    </tr>`;

    console.log(newAlimento);
    return newAlimento;

    }

function mostrarLoQueQueda(imagen, codigo, cantidad, restar, unidad, marca,nombre){
// ... (Tu función mostrarLoQueQueda sin cambios) ...
let unidadMedida;

if (marca === 'Sin Marca') {
if (unidad === 'Unidad' && cantidad > 1) {
 unidadMedida = unidad + 'es';
}
else{
  unidadMedida = unidad;
}
}
else{
  unidadMedida = 'Unidad';
  if (cantidad > 1) {
   unidadMedida = 'Unidades';
  }
}


let total= cantidad - restar;

let newAlimento = `

    <tr class='${codigo}'>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${nombre}</td>
       <td>${total} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
    </tr>`;
    return newAlimento;
    }

function mostrar(alimento){
// ... (Tu función mostrar sin cambios) ...
  let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idAlimento}, 
      success(data){
      if ($('#alimento').val() === 'Seleccionar') {
          $('#unidad').val(' ');

      }
      else{
        if(data[0].marca === 'Sin Marca'){
            $('#unidad').val(data[0].unidadMedida)
        }else{
          $('#unidad').val('Unidades')
        }
      }
      
      }
    })

    }

function mostrarInfo(alimento, cantidad, unidad){
// ... (Tu función mostrarInfo sin cambios) ...
      let idAlimento = alimento;
        $.ajax({
          url: '',
          type: 'POST',
          dataType: 'JSON',
          data: {muestra:true, idAlimento}, 
          success(data){
          let newRow= newAlimento(data[0].idAlimento,data[0].imgAlimento, data[0].codigo, data[0].nombre, data[0].marca, cantidad, unidad, data[0].unidadMedida);
          let newRow2= mostrarLoQueQueda(data[0].imgAlimento, data[0].codigo,data[0].stock, cantidad,unidad, data[0].marca, data[0].nombre);
          
          // Asumiendo que 'tableContainer' y 'tableContainer2' están definidos globalmente o de alguna forma accesible
          // const tableContainer = document.getElementById('tabla').parentElement; 
          // const tableContainer2 = document.getElementById('tabla2').parentElement; 
          
          $('#tablaD').show(1000);
          $('.tabla tbody').append(newRow);
          $('.tabla2 tbody').append(newRow2);
          
          if (typeof $('#cancelarInventario').click === 'function') {
              $('#cancelarInventario').click();
          }

          // Descomentar si usas estos contenedores
          // tableContainer.scrollTop = tableContainer.scrollHeight;
          // tableContainer2.scrollTop = tableContainer2.scrollHeight;
          }
        })
    
    }

function mostrarCantidadDisponible(alimento){
// ... (Tu función mostrarCantidadDisponible sin cambios) ...
  let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idAlimento}, 
      success(data){
        console.log('disponible', data);
        let unidad;

            if ($('#alimento').val() === 'Seleccionar') {
                  $('#dispo').val('');
            }
            else{
              
              if (data[0].marca === 'Sin Marca') {
              if (data[0].unidadMedida === 'Unidad' && data[0].stock > 1) {
                unidad = data[0].unidadMedida + 'es';
              }
              if (data[0].unidadMedida !== 'Unidad') {
                  unidad = data[0].unidadMedida;
                  
              }
              
              }
              else {
               unidad = 'Unidad';
                if (data[0].stock > 1) {
                  unidad = 'Unidades';
                }
              }
                $('#disponibilidad').show(100);
                $('#dispo').val(data[0].stock + ' '+unidad);
              }

            let cantidad = data[0].stock;

              return cantidad
      }
    })

  }


function disponible(alimento) {
// ... (Tu función disponible sin cambios) ...
  return new Promise((resolve, reject) => {
    let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: { muestra: true, idAlimento }, 
      success(data) {

        let cantidad = data[0].stock;
        resolve(cantidad);
      },
      error(err) {
        reject(err);
      }
    });
  });
}

function validarTabla() {
// ... (Tu función validarTabla sin cambios) ...
    if ($('.tabla tbody tr').length === 0) {
        $('#ani').hide(1000)
        $('#tablaD').hide(1000);
        // error_tabla=true; // Asumiendo que error_tabla es global o definida
    } 
}

// Llama la función al inicio (asumiendo que está fuera de DOMContentLoaded)
// validarTabla(); 

function vaciarTabla() {
// ... (Tu función vaciarTabla sin cambios) ...
    const tabla = document.getElementById('tabla').getElementsByTagName('tbody')[0];
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }

    const tabla2 = document.getElementById('tabla2').getElementsByTagName('tbody')[0];
    while (tabla2.firstChild) {
        tabla2.removeChild(tabla2.firstChild);
    }
}

// ------------------- OTROS LISTENERS -------------------

$('body').on('click', '#quitarFila', function(e) {
// ... (Tu listener de quitarFila sin cambios) ...
    var claseAEliminar = $(this).attr('value');
    console.log(claseAEliminar);

    console.log(claseAEliminar) 

    Swal.fire({
      title: '¿Deseas eliminar este alimento de la tabla?',
      icon: 'question',
      showCancelButton: true,
      width: '35%',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Aceptar',
    }).then((result) => {
      if (result.isConfirmed) {
          // Eliminar todos los <tr> que tengan la clase igual al valor del botón
          $('.table tbody .' + claseAEliminar).remove();

          validarTabla();
      }
    });

    e.preventDefault();
});

$("#agregarInventario").on('click', function() {
// ... (Tu listener de agregarInventario sin cambios) ...
    // Nota: Algunas variables como error_tipoA, error_alimento, etc. deben ser accesibles globalmente.
    // Si están definidas dentro de DOMContentLoaded, asegúrate de que este listener también lo esté.
    // Para simplificar, he dejado esta sección tal cual la proporcionaste.
    error_tipoA = false;
    error_alimento = false;
    error_cantidad = false;
    error_veriTA = false;
    error_veriA = false;
    error_horarioC = false;

    verificarTipoA();
    chequeo_tipoA();
    verificarAlimento();
    chequeo_alimento();
    chequeo_cantidad();

        let alimento = $('#alimento').val();
        let alimentoDuplicado = false;
        $('.tabla tbody tr').each(function() {
            let idAlimento = $(this).find('#idAlimento').val();
            if (alimento === idAlimento) {
                alimentoDuplicado = true;
                return false;  // Salir del bucle each
            }
        });

        if (alimentoDuplicado) {
              Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon:'error',
                    title:'<span class=" text-rojo">El alimento ya está en la tabla!</span>',
                    showConfirmButton:false,
                    timer:3000,
                    timerProgressBar:3000,
                    width:'38%',
                })
          $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> El alimento ya existe en la tabla!');
          $(".error3").show();
          $('#alimento').addClass('is-invalid');
          $('.bar3').removeClass('bar');
          $('.ic3').addClass('l');
          $('.ic3').removeClass('labelPri');
          $('.letra3').addClass('labelE');
          $('.letra3').removeClass('label-char');
        } else {
          if (!error_tipoA && !error_alimento && !error_veriA  && !error_veriTA  && !error_cantidad ) {
              let cantidad = $('#cantidad').val();
              let unidad=$('#unidad').val();
              if (cantidad > 0 && cantidad !== '') {
                  mostrarInfo(alimento, cantidad, unidad);
            $('#ani').show(1000);
             }
          
        }
    }
});