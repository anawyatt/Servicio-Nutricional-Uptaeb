
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

    tablaEntradaUtensilios();
    let mostrarEU;
    $('#ani').hide(1000);

    function tablaEntradaUtensilios() {
      var fechaInicio= $('#fecha').val();
      var fechaFin= $('#fecha2').val();
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { mostrarEU: true, fechaInicio, fechaFin},
            success(data) {
                 $('#ani').show(2000);
                let lista = data;
                let tabla = "";
                lista.forEach(row => {

                 let fecha = new Date(row.fecha);
                 let dia = fecha.getUTCDate().toString().padStart(2, '0'); // Usar getUTCDate()
                 let mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0'); // Usar getUTCMonth()
                 let anio = fecha.getUTCFullYear(); // Usar getUTCFullYear()

                 let fechaFormateada = `${dia}-${mes}-${anio}`;
                  let hora = new Date(`01/01/2000 ${row.hora}`);
                  let horaFormateada = hora.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                

                  tabla += `
                    <tr>
                    <td class="text-center">${fechaFormateada}</td>
                    <td class="text-center">${horaFormateada}</td>
                    <td class="">${row.descripcion}</td>
                    <td class="text-center ">
                    <a id="${row.idEntradaU }" class="btn btn-sm btn-icon text-info flex-end text-center informacion" data-bs-toggle="modal" data-bs-target="#infoEUtensilios"data-bs-toggle="tooltip" title="informacion de la Entrada de Utensilios" href="#" >
                                <span class="btn-inner pi">
                               <i class="bi bi-eye icon-24 t" width="20"></i>
                                </span>
                            </a>
                    <a id="${row.idEntradaU }" class="btn btn-sm btn-icon text-danger text-center borrar"   data-bs-toggle="tooltip" title="Anular Entrada de Utensilios" href="#"  type="button">
                            <i class="bi bi-trash icon-24 t" width="20"></i>
                            </a>

                    <a id="${row.idEntradaU }" class="btn btn-sm btn-icon text-primary text-center pdf" data-bs-toggle="modal" data-bs-target="#pdfEUtensilios"   data-bs-toggle="tooltip" title="Descargar Entrada de Utensilios" href="#"  type="button">
                            <i class="ri-download-line icon-24 t" width="20"></i>
                            </a>
                    </td>
                </tr>
                    `;
                });
                $('#tbody').html(tabla);
                mostrarEU = $('.tabla').DataTable();
                mostrarEU.on('draw.dt', function () {
                    quitarBotones();
                });
      
                  quitarBotones();
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

    e.preventDefault();
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{id , borrar: 'borrar'},
      success(data){
        console.log(data);
      if (data.resultado === 'eliminado'){
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
    })


  ///-----------------------DESCARGAR PDF 1

   $(document).on('click', '.pdf', function() {
       id = this.id;

       $('#idEntradaUU').val(id);
   })

function exportarReporte(){
  
    let idEntradaU = $('#idEntradaUU').val();
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte:true, idEntradaU}, 
      success(data){
         if(data.respuesta == "guardado"){
            console.log(data.ruta)
            descargarArchivo(data.ruta);
            abrirArchivo(data.ruta);
             $('#clos').click();
        }else{
            console.log('ERROR WE')
        }
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