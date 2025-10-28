
let permisos, eliminarPermiso;


$.ajax({
    method: 'POST',
    url: "", 
    dataType: 'json', 
    data: { getPermisos: true },
    success(data) { 
      permisos = data; 
    }
}).then(function () {
    eliminarPermiso = (typeof permisos.eliminar === 'undefined') ? 'disabled' : '';
    $('#enviar').attr(registrarPermiso, '');
});

function quitarBotones(){

if (typeof permisos.eliminar == 'undefined') {
console.log(permisos)
$(".borrar").remove()   
}
}

  let mostrarEU; // Se mantiene, pero se inicializará después

$('#ani').hide(1000);

// 1. Inicialización de DataTables fuera de la función
mostrarEU = $('.tabla').DataTable({
    "columns": [
        // Columna de Fecha (Columna 0)
        { 
            "data": "fecha", 
            "className": "text-center",
            "render": function (data) {
                // Lógica de formato de fecha
                let fecha = new Date(data);
                let dia = fecha.getUTCDate().toString().padStart(2, '0');
                let mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0');
                let anio = fecha.getUTCFullYear();
                return `${dia}-${mes}-${anio}`;
            }
        },
        // Columna de Hora (Columna 1)
        {
            "data": "hora", 
            "className": "text-center",
            "render": function (data) {
                // Lógica de formato de hora
                let hora = new Date(`01/01/2000 ${data}`);
                return hora.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
            }
        },
        // Columna de Descripción (Columna 2)
        { 
            "data": "descripcion",
            "className": "" // Sin clase adicional en el ejemplo original
        },
        // Columna de Acciones (Botones) (Columna 3)
        {
            "data": "idEntradaU",
            "className": "text-center accion",
            "render": function (data) {
                // Estructura HTML de los botones
                return `
                <a id="${data}" class="btn btn-sm btn-icon text-info flex-end text-center informacion" data-bs-toggle="modal" data-bs-target="#infoEUtensilios" data-bs-toggle="tooltip" title="informacion de la Entrada de Utensilios" href="#" >
                    <span class="btn-inner pi">
                        <i class="bi bi-eye icon-24 t" width="20"></i>
                    </span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-danger text-center borrar" data-bs-toggle="tooltip" title="Anular Entrada de Utensilios" href="#" type="button">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-primary text-center pdf" data-bs-toggle="modal" data-bs-target="#pdfEUtensilios" data-bs-toggle="tooltip" title="Descargar Entrada de Utensilios" href="#" type="button">
                    <i class="ri-download-line icon-24 t" width="20"></i>
                </a>`;
            },
            "orderable": false // Las acciones generalmente no son ordenables
        }
    ],
    "order": [[0, "desc"]] // Ordenar por la columna de fecha (0) descendente
});


// Función para obtener y mostrar los datos
function tablaEntradaUtensilios() {
    var fechaInicio = $('#fecha').val();
    var fechaFin = $('#fecha2').val();
    $.ajax({
        method: "post",
        url: "", // Asegúrate de que esta URL sea correcta
        dataType: "json",
        data: { mostrarEU: true, fechaInicio, fechaFin },
        success(data) {
            $('#ani').show(2000); 

            // 2. Usar DataTables API para limpiar, añadir y dibujar
            mostrarEU.clear().rows.add(data).draw();

            // Configurar el evento draw para llamar a quitarBotones
            mostrarEU.off('draw.dt').on('draw.dt', function () {
                quitarBotones();
            });

            // Llamar a quitarBotones la primera vez
            quitarBotones();
        },
        error(xhr, status, error) {
            // Manejo de errores (opcional)
            console.error("Error al cargar la tabla de utensilios:", status, error);
             $('#ani').hide(1000);
        }
    });
}

// Llamar a la función para cargar la tabla al inicio (si es necesario)
// tablaEntradaUtensilios();
// MOSTRAR INFORMACIÓN ------------------------------------------

      $(document).on('click', '.informacion', function () {
    let id = this.id;
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: {infoTipoUtensilio: true, id: id },
        success(data) {

            let tipoU = '';
            let lista = data;
            lista.forEach(fila => { 
                tipoU += `
                    <table class="table table-hover table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th colspan="5" class='blanco fw-bold text-center'>${fila.tipo}</th>
                            </tr>
                            <tr>
                                <th class="blanco">Imagen</th>
                                <th class="blanco">Utensilio</th>
                                <th class="blanco">Material</th>
                                <th class="blanco">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="infoU_${fila.idTipoU}" class="infoU"></tbody>
                    </table>
                `;

              
                mostrarUtensilios(fila.idTipoU, id);
            });

            $('#tablas').html(tipoU);
        }
    });
});

function mostrarUtensilios(idTipoU, idInventarioU) {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { infoUtensilio: true, idTipoU, idInventarioU },
        success(data) {

                  let tablita ='';
                 let fecha = new Date(data[0].fecha);
                 let dia = fecha.getUTCDate().toString().padStart(2, '0'); // Usar getUTCDate()
                 let mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0'); // Usar getUTCMonth()
                 let anio = fecha.getUTCFullYear(); // Usar getUTCFullYear()

                 let fechaFormateada = `${dia}-${mes}-${anio}`;
                  let hora = new Date(`01/01/2000 ${data[0].hora}`);
                  let horaFormateada = hora.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

          tablita = `
                    <tr>
                    <td class="text-center">${fechaFormateada}</td>
                    <td class="text-center">${horaFormateada}</td>
                    <td class="">${data[0].descripcion}</td>
                  </tr>
                    `;

           $('#tbody3').html(tablita);

          // ------------------ DETALLE ----------
            let utensilio = '';
            let lista = data;

            lista.forEach(fila => { 


              utensilio += `
                    <tr>
                        <td><img src="${fila.imgUtensilios}" width="70" height="70" alt="Profile" class="mb-2"></td>
                        <td>${fila.nombre}</td>
                        <td>${fila.material}</td>
                        <td>${fila.cantidad}</td>
                    </tr>
                `;
            });

            $(`#infoU_${idTipoU}`).html(utensilio);
        }
    });
}



 

// ---------------------------- ANULAR

function valAnulacion(idd){
   let id = idd ;
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {valAnulacion: true, id},
    success(data){

      if (data.resultado === "no se puede"){
         $('#borrarEUtensilios').modal('hide');
         $('#cerrar3').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
               Estos utensilios ya estan siendo utilizados en el Servicio Nutricional. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#borrarEUtensilios').modal('show');
           }
           } 
   })

  }



//------------ ELIMINAR AJAX----------------------------------------

  $(document).on('click', '.borrar', function() {
    id = this.id;

    $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {infoTipoUtensilio: 'anular', id},
    success(data){
       if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete mostrarEU;
         tablaAlimentos();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">La entrada de utensilios fue anulado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
        else{
              valAnulacion(id);
              $('.eliminarI').html( '¿Deseas anular esta entrada de utensilios?');
           
        }
     
   
  
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  
  $('#borrar').click((e)=>{
    let token = $('[name="csrf_token"]').val();
    if(token){

    e.preventDefault();
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{id , borrar: 'borrar', csrfToken: token},
      success(data){
        console.log(data);
      if (data.mensaje.resultado === 'eliminado' && data.newCsrfToken){
        $('[name="csrf_token"]').val(data.newCsrfToken);
        $('#cerrar3').click();
        tablaEntradaUtensilios();
          Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Entrada de Utensilio Anulado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
      }
    }
  })
}
})


  ///-----------------------DESCARGAR PDF 1 (Un solo reporte)

    $(document).on('click', '.pdf', function() {
        id = this.id;

        $('#idEntradaUU').val(id);
    })

function exportarReporte(){
  
    let idEntradaU = $('#idEntradaUU').val();
    
    // Crear un formulario temporal para la petición POST
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; 
    
    // Añadir los datos como campos ocultos
    let inputReporte = document.createElement('input');
    inputReporte.type = 'hidden';
    inputReporte.name = 'reporte'; 
    inputReporte.value = 'true';
    form.appendChild(inputReporte);
    
    let inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'idEntradaU';
    inputId.value = idEntradaU;
    form.appendChild(inputId);

    // Añadir y enviar el formulario
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form); // Limpiar el formulario
    
    $('#clos').click(); // Cerrar modal si aplica
}

$('#reportebtn').click(()=>{
    exportarReporte();
})


/// ------------- DESCARGAR PDF 2 (Reporte Total por fecha)

$('#reportebtn2').click(()=>{
    exportarReporte2();
})


function exportarReporte2(){
      var fechaI= $('#fecha').val();
      var fechaF= $('#fecha2').val();

    // Crear un formulario temporal para la petición POST
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; 

    // Añadir los datos como campos ocultos
    let inputReporte2 = document.createElement('input');
    inputReporte2.type = 'hidden';
    inputReporte2.name = 'reporte2'; 
    inputReporte2.value = 'true';
    form.appendChild(inputReporte2);
    
    let inputFechaI = document.createElement('input');
    inputFechaI.type = 'hidden';
    inputFechaI.name = 'fechaI';
    inputFechaI.value = fechaI;
    form.appendChild(inputFechaI);

    let inputFechaF = document.createElement('input');
    inputFechaF.type = 'hidden';
    inputFechaF.name = 'fechaF';
    inputFechaF.value = fechaF;
    form.appendChild(inputFechaF);

    // Añadir y enviar el formulario
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form); // Limpiar el formulario
    
    $('#clos').click(); // Cerrar modal si aplica
}




 //------------------------- FILTRO DE BUSQUEDA -----------------
 $('#fecha, #fecha2').on('change', function() { 
    errorFI=false
    errorFF=false
    validarFechaIncio()
    validarFechaFin()
    tablaEntradaUtensilios() ;
  })


let errorFI=false
let errorFF=false


 $(document).ready(function () {
   // Ocultar por defecto si el checkbox no está marcado
   if (!$('.activarFiltro').is(':checked')) {
       $('.buscar').hide();
       tablaEntradaUtensilios() ;
   }
   // Manejar cambios en el checkbox
   $('.activarFiltro').change(function () {
       if ($(this).is(':checked')) {
           $('.buscar').show();
       } else {
           $('.buscar').hide();
           $('#fecha').val("");
           $('#fecha2').val("");
           tablaEntradaUtensilios() ;
       }
   });

});


function validarFechaIncio(){
  var fechaInicio =new Date($('#fecha').val());
  var fechaActual = new Date();

            
                if (fechaInicio > fechaActual) {
                   Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">Fecha Inicio inválida!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                   })
               $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la Fecha, No debe ser mayor a la fecha de hoy!');
               $(".error1").show();
               $('#fecha').addClass('errorBorder');
               $('.bar1').removeClass('bar');
               $('.ic1').addClass('l');
               $('.ic1').removeClass('labelPri');
               $('.letra1').addClass('labelE');
               $('.letra1').removeClass('label-char');
               errorFI=true
                }
                else{
                $(".error1").html("");
                $(".error1").hide();
                $('#fecha').removeClass('errorBorder');
                $('.bar1').addClass('bar');
                $('.ic1').removeClass('l');
                $('.ic1').addClass('labelPri');
                $('.letra1').removeClass('labelE');
                $('.letra1').addClass('label-char');

                }
}


function validarFechaFin(){
  var fechaInicio =new Date($('#fecha').val());
  var fechaFin=new Date($('#fecha2').val());
  var fechaActual = new Date();

               if (fechaFin > fechaActual) {
                   Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">Fecha Fin inválida!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                   })
               $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la Fecha, No debe ser mayor a la fecha de hoy!');
               $(".error2").show();
               $('#fecha2').addClass('errorBorder');
               $('.bar2').removeClass('bar');
               $('.ic2').addClass('l');
               $('.ic2').removeClass('labelPri');
               $('.letra2').addClass('labelE');
               $('.letra2').removeClass('label-char');
                    errorFF=true
                }
                 else if (fechaInicio > fechaFin) {
                   Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">Fecha Fin inválida!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                   })
                        $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> La fecha no debe ser menor a la fecha de inicio!');
                        $(".error2").show();
                        $('#fecha2').addClass('errorBorder');
                        $('.bar2').removeClass('bar');
                        $('.ic2').addClass('l');
                        $('.ic2').removeClass('labelPri');
                        $('.letra2').addClass('labelE');
                        $('.letra2').removeClass('label-char');
                    errorFF=true
                }
                else{
                $(".error2").html("");
                $(".error2").hide();
                $('#fecha2').removeClass('errorBorder');
                $('.bar2').addClass('bar');
                $('.ic2').removeClass('l');
                $('.ic2').addClass('labelPri');
                $('.letra2').removeClass('labelE');
                $('.letra2').addClass('label-char');

                }
                
}

$('#iu1').addClass('active');
$('#iu2').addClass('active');
$('.iu2').addClass('active')
$('#eu3').addClass('text-primary');
$('.eu3').addClass('active')


  setInterval(function() {
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {renovarToken: true, csrfToken:  $('[name="csrf_token"]').val()}, 
        success(data){
        if (data.newCsrfToken) {
        $('[name="csrf_token"]').val(data.newCsrfToken);
            console.log('Token CSRF renovado');
        } else {
            console.log('No se pudo renovar el token CSRF');
        }
        },
        error: function(err) {
        console.error('Error renovando token CSRF:', err);
        }
    });
    }, 240000);