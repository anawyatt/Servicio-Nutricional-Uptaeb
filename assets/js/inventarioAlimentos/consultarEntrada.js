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
});

function quitarBotones(){

if (typeof permisos.eliminar == 'undefined') {
console.log(permisos)
$(".borrar").remove()   
}
}

    let mostrarEA = $('.tabla').DataTable({
    "columns": [
        {
            "data": "fecha",
            "className": "text-center",
            "render": function formatDate(data) {
                let fecha = new Date(data);
                if (isNaN(fecha)) {
                    return "Fecha inválida";
                }

                let dia = fecha.getUTCDate().toString().padStart(2, '0'); // Día del mes
                let mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0'); // Mes
                let anio = fecha.getUTCFullYear(); // Año
                return `${dia}-${mes}-${anio}`;
            }
            
            
        },
        {
            "data": "hora",
            "className": "text-center",
            "render": function(data) {
                let hora = new Date(`01/01/2000 ${data}`);
                return hora.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
            }
        },
        { "data": "descripcion" },
        {
            "data": "idEntradaA",
            "className": "text-center",
            "render": function(data) {
                return `
                <a id="${data}" class="btn btn-sm btn-icon text-info flex-end text-center informacion" data-bs-toggle="modal" data-bs-target="#infoEAlimento" data-bs-toggle="tooltip" title="informacion de la Entrada de Alimentos" href="#">
                    <span class="btn-inner pi"><i class="bi bi-eye icon-24 t" width="20"></i></span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-danger text-center borrar" data-bs-toggle="tooltip" title="Anular Entrada de Alimentos" href="#" type="button">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-primary text-center pdf" data-bs-toggle="modal" data-bs-target="#pdfEAlimento" data-bs-toggle="tooltip" title="Descargar Entrada de Alimentos" href="#" type="button">
                    <i class="ri-download-line icon-24 t" width="20"></i>
                </a>`;
            },
            "orderable": false
        }
    ],
    "order": [[0, "asc"]]  // Ordena por la primera columna
});

$('#ani').hide(1000);

function tablaEntradaAlimentos() {
    var fechaInicio = $('#fecha').val();
    var fechaFin = $('#fecha2').val();
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { mostrarEntradaA: true, fechaInicio, fechaFin },
        success(data) {
            console.log(data);
            $('#ani').show(2000);
            mostrarEA.clear().rows.add(data).draw();
            mostrarEA.on('draw.dt', function () {
            quitarBotones(); });
             if (data.length > 0) {
                quitarBotones();
               $('#botonPDF').prop('disabled', false);
  
            }
            else if (data.length == 0) {
               $('#botonPDF').prop('disabled', true);
            }
           
        }
    });
}


// MOSTRAR INFORMACIÓN ------------------------------------------
$(document).on('click', '.informacion', function () {
    let id = this.id;
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { infoTipoAlimento: true, id: id },
        success(data) {

            let tipoA = '';
            let grupos = {};

            // Agrupamos por tipo
            data.forEach(fila => {
                if (!grupos[fila.tipo]) {
                    grupos[fila.tipo] = [];
                }
                grupos[fila.tipo].push(fila);
            });

            // Armamos la tabla para cada tipo
            Object.keys(grupos).forEach(tipo => {
                let filas = grupos[tipo];

                // Verificamos si alguna fila tiene marca válida para mostrar "Cont. Neto"
                let mostrarContNeto = filas.some(f => f.marca && f.marca !== "Sin Marca");
                let totalColumnas = 4 + (mostrarContNeto ? 1 : 0);

                tipoA += `
                    <table class="table table-hover table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th colspan="${totalColumnas}" class="blanco fw-bold text-center">${tipo}</th>
                            </tr>
                            <tr>
                                <th class="blanco">Imagen</th>
                                <th class="blanco">Alimento</th>
                                <th class="blanco">Marca</th>
                                ${mostrarContNeto ? `<th class="blanco">Cont. Neto</th>` : ""}
                                <th class="blanco">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="infoA_${filas[0].idTipoA}" class="infoA"></tbody>
                    </table>
                `;

                mostrarAlimentos(filas[0].idTipoA, id);
            });

            $('#tablas').html(tipoA);
        }
    });
});


function mostrarAlimentos(idTipoA, idInventarioA) {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { infoAlimento: true, idTipoA, idInventarioA },
        success(data) {

            let tablita ='';
            let fecha = new Date(data[0].fecha);
            if (isNaN(fecha)) {
                return "Fecha inválida";
            }

            let dia = fecha.getUTCDate().toString().padStart(2, '0'); 
            let mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0'); 
            let anio = fecha.getUTCFullYear();
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
            let alimento = '';
            let lista = data;

            // Detectar si este tipo de alimento usa columna Cont. Neto
            let mostrarContNeto = lista.some(f => f.marca && f.marca !== "Sin Marca");

            lista.forEach(fila => { 
                let unidadMedida;

                if (fila.marca === 'Sin Marca') {
                    if (fila.unidadMedida === 'Unidad' && fila.cantidad > 1) {
                        unidadMedida = fila.unidadMedida + 'es';
                    } else {
                        unidadMedida = fila.unidadMedida;
                    }
                    
                } else {
                    unidadMedida = 'Unidad';
                    if (fila.cantidad > 1) {
                        unidadMedida = 'Unidades';
                    }
                }

                // Si la tabla requiere columna Cont. Neto, siempre insertamos <td>
                let contNetoColumna = "";
                if (mostrarContNeto) {
                    contNetoColumna = (fila.marca !== "Sin Marca") 
                        ? `<td>${fila.unidadMedida}</td>` 
                        : `<td class="text-muted">N/A</td>`; // vacío o N/A
                }

                alimento += `
                    <tr>
                        <td><img src="${fila.imgAlimento}" width="70" height="70" alt="Profile" class="mb-2"></td>
                        <td>${fila.nombre}</td>
                        <td>${fila.marca}</td>
                        ${contNetoColumna}
                        <td>${fila.cantidad} ${unidadMedida}</td>
                    </tr>
                `;
            });

            $(`#infoA_${idTipoA}`).html(alimento);
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
         $('#borrarEAlimento').modal('hide');
         $('#cerrar3').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
               Estos alimentos ya estan siendo utilizados en el Servicio Nutricional. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#borrarEAlimento').modal('show');
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
    data: {infoTipoAlimento: 'anular', id},
    success(data){
       if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete mostrarEA;
         tablaAlimentos();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">La entrada de alimentos fue anulado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
        else{
              valAnulacion(id);
              $('.eliminarI').html( '¿Deseas anular esta entrada de alimentos ?');
           
        }
     
   
  
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  
  $('#borrar').click((e)=>{
 let token = $('[name="csrf_token"]').val();
 if(token){
    console.log(token);
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
        tablaEntradaAlimentos();
          Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Entrada de Alimento Anulado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
      }
    }
  })
    }
    })


  ///-----------------------DESCARGAR PDF 1

   $(document).on('click', '.pdf', function() {
       id = this.id;

       $('#idEntradaAA').val(id);
   })

function exportarReporte(){
  
    let idEntradaA = $('#idEntradaAA').val();
    $('.loadingAnimation').show();
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte:true, idEntradaA}, 
      success(data){
         if(data.respuesta == "guardado"){
            console.log(data.ruta)
            descargarArchivo(data.ruta);
            abrirArchivo(data.ruta);
             $('#clos').click();
        }else{
            console.log('ERROR WE')
        }
        $('.loadingAnimation').hide();

      } })
}

function descargarArchivo(ruta){
let link=document.createElement('a');
link.href = ruta;
link.download = ruta.substr(ruta.lastIndexOf('/') + 1);
link.click();
}

function abrirArchivo(ruta){
    window.open(ruta, '_blank');
}

$('#reportebtn').click(()=>{
    exportarReporte();
})


/// ------------- DESCARGAR PDF 2

$('#reportebtn2').click(()=>{
    exportarReporte2();
})


function exportarReporte2(){
     var fechaI= $('#fecha').val();
      var fechaF= $('#fecha2').val();
     $('.loadingAnimation').show();
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte2:true, fechaI, fechaF}, 
      success(data){
         if(data.respuesta == "guardado"){
            console.log(data.ruta)
            descargarArchivo2(data.ruta);
            abrirArchivo2(data.ruta);
             $('#clos').click();
        }else{
            console.log('ERROR WE')
        }
        $('.loadingAnimation').hide();
      } })
}


function descargarArchivo2(ruta){
let link=document.createElement('a');
link.href = ruta;
link.download = ruta.substr(ruta.lastIndexOf('/') + 1);
link.click();
}

function abrirArchivo2(ruta){
    window.open(ruta, '_blank');
}


 //------------------------- FILTRO DE BUSQUEDA -----------------
 $('#fecha, #fecha2').on('change', function() { 
    errorFI=false
    errorFF=false
    validarFechaIncio()
    validarFechaFin()
    tablaEntradaAlimentos() ;
  })


let errorFI=false
let errorFF=false


 $(document).ready(function () {
   // Ocultar por defecto si el checkbox no está marcado
   if (!$('.activarFiltro').is(':checked')) {
       $('.buscar').hide();
      tablaEntradaAlimentos() ;
   }
   // Manejar cambios en el checkbox
   $('.activarFiltro').change(function () {
       if ($(this).is(':checked')) {
           $('.buscar').show();
       } else {
           $('.buscar').hide();
           $('#fecha').val("");
           $('#fecha2').val("");
          tablaEntradaAlimentos() ;
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


$('#ia1').addClass('active');
$('#ia2').addClass('active');
$('.ia2').addClass('active')
$('#ea3').addClass('text-primary');
$('.ea3').addClass('active')

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