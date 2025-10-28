let permisos, modificarPermiso, eliminarPermiso, registrarPermiso;
$.ajax({
    method: 'POST', url: "", dataType: 'json', data: { getPermisos: 'a' },
    success(data) { permisos = data; }
}).then(function () {
    registrarPermiso = (typeof permisos.registrar === 'undefined') ? 'disabled' : '';
    modificarPermiso = (typeof permisos.modificar === 'undefined') ? 'disabled' : '';
    eliminarPermiso = (typeof permisos.eliminar === 'undefined') ? 'disabled' : '';
    $('#enviar').attr(registrarPermiso, '');
});

function quitarBotones(){

if (typeof permisos.modificar == 'undefined') {
console.log(permisos)
$(".editar").remove()   
}

if (typeof permisos.eliminar == 'undefined') {
console.log(permisos)
$(".borrar").remove()   
}
}

 // Inicializar DataTable
 $('#ani2').hide(1000);
 tablaEvento();

let mostrarE = $('.tabla').DataTable({
 "ordering": false, // respeta el orden del SQL
  "columns": [
    { 
      "data": "feMenu", 
      "render": function (data) {
        let [anio, mes, dia] = data.split("-");
        return `${dia}-${mes}-${anio}`;
      },
      "className": "text-center"
     },
     { "data": "horarioComida", "className": "text-center" },
     { "data": "cantPlatos", "className": "text-center" },
     { "data": "nomEvent", "className": "text-center" },
     {
         "data": "idEvento",
         "render": function (data, type, row) {
             return `
                 <td class="text-center accion">
                     <a id="${data}" class="btn btn-sm btn-icon text-info flex-end text-center informacion" data-bs-toggle="modal" data-bs-target="#infoEvento" data-bs-toggle="tooltip" title="Información Evento" href="#" type="button">
                         <span class="btn-inner pi">
                             <i class="bi bi-eye icon-24 t" width="20"></i>
                         </span>
                     </a>
                     <a id="${data}" class="btn btn-sm btn-icon text-primary flex-end text-center editar" data-bs-toggle="tooltip" title="Modificar Evento" href="#" type="button">
                         <span class="btn-inner pi">
                             <i class="bi bi-pencil icon-24 t" width="20"></i>
                         </span>
                     </a>
                     <a id="${data}" class="btn btn-sm btn-icon text-danger text-center borrar" data-bs-toggle="tooltip" title="Eliminar Evento" href="#" type="button">
                         <i class="bi bi-trash icon-24 t" width="20"></i>
                     </a>
                     <a id="${data}" class="btn btn-sm btn-icon text-primary text-center pdf" data-bs-toggle="modal" data-bs-target="#pdfEvento" data-bs-toggle="tooltip" title="Descargar Evento" href="#" type="button">
                         <i class="ri-download-line icon-24 t" width="20"></i>
                     </a>
                 </td>`;
         },
         "className": "text-center"
     }
 ]
});

// Función para rellenar la tabla
function tablaEvento() {
 let fechaInicio = $('#fecha').val();
 let fechaFin = $('#fecha2').val();

 $.ajax({
     method: "post",
     url: "",
     dataType: "json",
     data: { mostrarEvento: true, fechaInicio, fechaFin },
     success(data) {
         $('#ani2').show(2000);
         mostrarE.clear().rows.add(data).draw();
         mostrarE.on('draw.dt', function () {
             quitarBotones();
         });
         quitarBotones();
     }
 });
}





 //------------------------- FILTRO DE BUSQUEDA -----------------
 $('#fecha, #fecha2').on('change', function() { 
    errorFF=false
    validarFechaFiltros();
    tablaEvento() ;
  })

let errorFF=false


 $(document).ready(function () {
 
   if (!$('.activarFiltro').is(':checked')) {
       $('.buscar').hide();
       tablaEvento() ;
   }
  
   $('.activarFiltro').change(function () {
       if ($(this).is(':checked')) {
           $('.buscar').show();
       } else {
           $('.buscar').hide();
           $('#fecha').val("");
           $('#fecha2').val("");
           tablaEvento() ;
           priFi()
       }
   });

});

            function priFi(){
                $(".error1,.error2").html("");
                $(".error1,.error2").hide();
                $('#fecha,#fecha2').removeClass('errorBorder');
                $('.bar1,.bar2').addClass('bar');
                $('.ic1,.ic2').removeClass('l');
                $('.ic1,.ic2').addClass('labelPri');
                $('.letra1,.letra2').removeClass('labelE');
                $('.letra1,.letra2').addClass('label-char');
            }


function validarFechaFiltros(){
  var fechaInicio =new Date($('#fecha').val());
  var fechaFin=new Date($('#fecha2').val());


               if (fechaInicio > fechaFin) {
                   Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">Fechas inválidas!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                   })
                        $(".error1,.error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> La fecha fin no debe ser menor a la fecha de inicio!');
                        $(".error1,.error2").show();
                        $('#fecha, #fecha2').addClass('errorBorder');
                        $('.bar1,.bar2').removeClass('bar');
                        $('.ic1,.ic2').addClass('l');
                        $('.ic1,.ic2').removeClass('labelPri');
                        $('.letra1,.letra2').addClass('labelE');
                        $('.letra1,.letra2').removeClass('label-char');
                    errorFF=true
                }
                else{
                errorFF=false
                priFi()
                }
                
}

// MOSTRAR INFORMACIÓN ------------------------------------------

 $(document).on('click', '.informacion', function () {
    let id = this.id;
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { infoEvento: true, id: id },
        success(data) {
           console.log(data);

            let tipoA = '';
            let grupos = {};

            data.forEach(fila => {
                if (!grupos[fila.tipo]) {
                    grupos[fila.tipo] = [];
                }
                grupos[fila.tipo].push(fila);
            });

            Object.keys(grupos).forEach(tipo => {
                let filas = grupos[tipo];

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

function mostrarAlimentos(idTipoA, idEvento) {
  $.ajax({
      method: "post",
      url: "", 
      dataType: "json",
      data: { infoAlimento: true, idTipoA, idEvento },
      success(data) {

        let tablita ='';
        let feMenu = new Date(data[0].feMenu);
        let dia = feMenu.getUTCDate().toString().padStart(2, '0'); // Usar getUTCDate()
        let mes = (feMenu.getUTCMonth() + 1).toString().padStart(2, '0'); // Usar getUTCMonth()
        let anio = feMenu.getUTCFullYear(); // Usar getUTCFullYear()

        let fechaFormateada = `${dia}-${mes}-${anio}`;

        tablita = `
                  <tr>
                  <td class="text-center">${fechaFormateada}</td>
                  <td class="">${data[0].horarioComida}</td>
                  <td class="">${data[0].cantPlatos}</td>
                </tr>
                  `;
        
        tablita1 = `
                  <tr>
                  <td class="">${data[0].nomEvent}</td>
                  <td class="">${data[0].descripEvent}</td>
                </tr>
                  `;

        tablita2 = `
                  <tr>
                  <td class="">${data[0].descripcion}</td>
                </tr>
                  `;

         $('#tbody3').html(tablita);
         $('#tbody4').html(tablita1);
         $('#tbody5').html(tablita2);


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


//-------------------------------------- MODIFICAR INFORMACIÓN ------------------------------------------


$('#alimento1').hide(100);

$(document).on('click', '#alimentoB', function (){
   idAli = this.id;
   $('#menu1').hide(1000);
   $('#alimento1').show(1000);
}); 


 $(document).on('click', '#menuB', function (){
     idMen = this.id;
     $('#alimento1').hide(1000);
     $('#menu1').show(1000);
 }); 

 $(document).on('click', '.cut', function (){
   $('#alimento1').hide(0);
   $('#menu1').show(1000);
}); 


function valModificar(idd){
  let id = idd ;
  $.ajax({
   url: "",
   dataType: 'json',
   method: "POST",
   data: {modificar: 'modificar', id},
   success(data){

     if (data.resultado === "no se puede"){
        $('#modificarEvento').modal('hide');
        $('#cerrar2').click();
            Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'error',
               title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">
               El evento ya fue realizado. `,
               showConfirmButton:false,
               timer:3000,
               timerProgressBar:3000,
           })
            
          }
          if(data.resultado === "se puede"){
           $('#modificarEvento').modal('show');
          }
          } 
  })

 }

 $(document).on('click', '.editar', function () {
  let id = this.id;
  valModificar(id);

  $.ajax({
      method: "post",
      url: "", 
      dataType: "json",
      data: { infoEvento: true, id: id },
      success: function(data) {
          let alimentos = '';
          let requests = [];

          data.forEach(fila => {
              requests.push(
                  $.ajax({
                      method: "post",
                      url: "", 
                      dataType: "json",
                      data: { infoAlimento: true, idTipoA: fila.idTipoA, idEvento: id },
                      success: function(data) {
                          console.log('Datos del alimento:', data); 
                          if (data.resultado === 'error evento') {
                              $('.cerrar2').click();
                              tablaEvento();
                              Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon: 'error',
                                  title: '<span class=" text-rojo">¡El evento fue anulado recientemente!</span>',
                                  showConfirmButton: false,
                                  timer: 3000,
                                  timerProgressBar: true,
                              });
                          } else {
                              $("#idd").val(data[0].idEvento);
                              $("#feMenu").val(data[0].feMenu);
                              $("#cantPlatos").val(data[0].cantPlatos);
                              $("#nomEvent").val(data[0].nomEvent);
                              $("#descripEvent").val(data[0].descripEvent);
                              $("#descripcion").val(data[0].descripcion);
                              $("#idSalidaA").val(data[0].idSalidaA);
                              $("#idMenu").val(data[0].idMenu);
                              $('input[name="opcion"]').prop('checked', false);
                              $('input[name="opcion"][value="' + data[0].horarioComida + '"]').prop('checked', true);
                              
                              alimentos += procesarAlimento(data);
                          }
                      }
                  })
              );
          });

          $.when.apply($, requests).done(function() {
              $('.tbody33').html(alimentos);
         });
      }
  });
});

$(document).on('click', '.resetear', function () {
  let id = $("#idd").val();
  $.ajax({
      method: "post",
      url: "", 
      dataType: "json",
      data: { infoEvento: true, id: id },
      success: function(data) {

          let alimentos = '';
          let requests = [];

          data.forEach(fila => {
              requests.push(
                  $.ajax({
                      method: "post",
                      url: "", 
                      dataType: "json",
                      data: { infoAlimento: true, idTipoA: fila.idTipoA, idEvento: id },
                      success: function(data) {
                          console.log('Datos del alimento:', data); 
                          if (data.resultado === 'error evento') {
                              $('.cerrar2').click();
                              tablaEvento();
                              Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon: 'error',
                                  title: '<span class=" text-rojo">¡El evento fue anulado recientemente!</span>',
                                  showConfirmButton: false,
                                  timer: 3000,
                                  timerProgressBar: true,
                              });
                          } else {
                              $("#feMenu").val(data[0].feMenu);
                              $("#cantPlatos").val(data[0].cantPlatos);
                              $("#descripcion").val(data[0].descripcion);
                              $("#idSalidaA").val(data[0].idSalidaA);
                              $("#idMenu").val(data[0].idMenu);
                              $("#nomEvent").val(data[0].nomEvent);
                              $("#descripEvent").val(data[0].descripEvent);
                              $('input[name="opcion"]').prop('checked', false);
                              $('input[name="opcion"][value="' + data[0].horarioComida + '"]').prop('checked', true);
                              
                              alimentos += procesarAlimento(data);
                          }
                      }
                  })
              );
          });

          $.when.apply($, requests).done(function() {
              console.log('Alimentos generados:', alimentos); 
              $('.tbody33').html(alimentos);
          });
      }
  });
});

function procesarAlimento(data) {
    let alimento1 = '';
    let lista1 = data;
    console.log(lista1);

    lista1.forEach(fila => {
        let unidadMedida;
        let cont;
        if (fila.marca === 'Sin Marca') {
          cont='';
        if (fila.unidadMedida === 'Unidad' && fila.cantidad > 1) {
            unidadMedida = fila.unidadMedida + 'es';
        } else {
            unidadMedida = fila.unidadMedida;
        }
       
        } else {
        cont =  `- ${fila.unidadMedida}  `;
        unidadMedida = 'Unidad';
        if (fila.cantidad > 1) {
            unidadMedida = 'Unidades';
        }
       }
      

        alimento1 += `
            <tr class='${fila.idAlimento}'>
                <td class='d-none'><input class='d-none idAlimento2' value='${fila.idAlimento}'></td>
                <td><img src="${fila.imgAlimento}" width="50" height="50" alt="Profile" class="mb-2"></td>
                <td>${fila.nombre}  ${cont}</td>
                <td>${fila.marca} </td>
                <td>${fila.cantidad} ${unidadMedida}<input class='d-none' id='cantidadA' value='${fila.cantidad}'></td>
                <td>
                    <a id='quitarFila' class="btn btn-sm btn-icon text-danger text-center" value='${fila.idAlimento}' data-bs-toggle="tooltip" title="Borrar Alimento" type="button">
                        <i class="bi bi-trash icon-24 t" width="20"></i>
                    </a>
                </td>
            </tr>
        `;
    });

    return alimento1;
}



 $('#disponibilidad').hide();
 $('#tablaD').hide();
 $('#ani').show();
 $("#tipoA").on('change', function() {
  if ($(this).val() == 'Seleccionar') {
       $('#disponibilidad').hide();
      $('#unidad').val('');
      $('#cantidad').val('');
      $('#alimento').val('Seleccionar').trigger('change.select2');
    }
   verificarTipoA()
   mostrarAlimento($(this).val());
   chequeo_tipoA()
 });

 $("#alimento").on('change', function() {
  if ($(this).val() == 'Seleccionar') {
       $('#disponibilidad').hide();
      $('#unidad').val('');
      $('#cantidad').val('');
    }
   verificarAlimento()
   chequeo_alimento()

   mostrar2($(this).val());
   mostrarCantidadDisponible($(this).val());

   let alimento = $('#alimento').val();
     let alimentoDuplicado = false;
     $('#tabla3 tbody tr').each(function() {
         let idAlimento = $(this).find('.idAlimento2').val();
         if (alimento === idAlimento) {
             alimentoDuplicado = true;
             return false;  
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
     }
});


$('input[type="checkbox"]').on('change', function(e) {
  // Desmarcar todos los checkboxes excepto el seleccionado
  $('input[type="checkbox"]').not(this).prop('checked', false);

  // Verificar si no hay ningún checkbox seleccionado
  if ($('input[type="checkbox"]:checked').length == 0) {
    e.preventDefault(); // Prevenir comportamiento por defecto
    validarCheck();  // Llamar a la función de validación cuando no hay selección
  } else {
    e.preventDefault(); // Prevenir comportamiento por defecto
    validarCheck();  // Llamar a la función de validación
    validarFH();     // Llamar a la función adicional cuando hay selección
  }
});

 $("#cantidad").focusout(function(){
   chequeo_cantidad();
 });

 $("#cantidad").on('keyup', function(){
  chequeo_cantidad();
 });

 $("#feMenu").focusout(function(){
   chequeo_fecha();
   validarFH();
 });

 $("#feMenu").on('keyup', function(){
   chequeo_fecha();
   validarFH();
 });

 $("#cantPlatos").focusout(function(){
   chequeo_cantidadE();
 });

 $("#cantPlatos").on('keyup', function(){
   chequeo_cantidadE();
 });
 
 $("#nomEvent").focusout(function(){
  chequeo_nombreE();
});
$("#nomEvent").on('keyup', function(){
  chequeo_nombreE();
});

$("#descripEvent").focusout(function(){
  chequeo_descripE();
});
$("#descripEvent").on('keyup', function(){
  chequeo_descripE();
});
 $("#descripcion").focusout(function(){
   chequeo_descripcion();
 });

 $("#descripcion").on('keyup', function(){
   chequeo_descripcion();
 });


 $("#cancelar, .limpiar").on('click', function() {
  primary();
 setTodayDate(hoyA);
 vaciarTabla()
 $('#ani').hide();
  $('#tablaD').hide();
  $('#descripcion').val('');
 });


$("#cancelarInventario").on('click', function() {
primary2();
});

$("#agregarInventario").on('click', function() {
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
  $('#tabla3 tbody tr').each(function() {
      let idAlimento = $(this).find('.idAlimento2').val();
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
                   primary2();
                   mostrarInfo(alimento, cantidad, unidad);
       }
   
  }
}
});

$('body').on('click', '#quitarFila', function(e) {
  var claseAEliminar = $(this).attr('value');
  console.log(claseAEliminar);  // Obtener el valor del atributo 'value' del botón

  Swal.fire({
      title: '¿Deseas eliminar este alimento de la tabla?',
      icon: 'question',
      showCancelButton: true,
      width: '35%',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Aceptar',
  }).then((result) => {
      if (result.isConfirmed) {
      
          $('.tables tbody .' + claseAEliminar).remove();
          modiAli();  
          validarTabla(); 
      }
  });

 e.preventDefault();
});

$("#editar").on("click", function(e){
e.preventDefault();
error_fecha = false;
error_cantidadE= false;
error_nombreE= false;
error_descripE = false;
error_horarioC = false;
error_descrip = false;
error_tabla= false;
error_validarFH=false;


  chequeo_fecha();
  chequeo_cantidadE();
  chequeo_nombreE();
  chequeo_descripE();
  validarCheck();
  chequeo_descripcion();
  validarTabla();
  validarFH();

if(!error_fecha && !error_cantidadE && !error_nombreE && !error_descripE && !error_horarioC  &&!error_descrip && 
  !error_tabla && !error_validarFH ){
   modificar();
}
else{
         Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'<span class=" text-rojo">Ingrese los Datos Correctamente!</span>',
             showConfirmButton:false,
             timer:3000,
             timerProgressBar:3000,
             width:'38%',
         })
    }
  

  })
function modiAli() {
  let feMenu = $("#feMenu").val();
  let horarioComida = $("input[name='opcion']:checked").val();
  let cantPlatos = $("#cantPlatos").val();
  let idMenu = $('#idMenu').val();
  let nomEvent = $("#nomEvent").val();
  let descripEvent = $("#descripEvent").val();
  let id = $('#idd').val();
  let descripcion = $("#descripcion").val();
  let idSalidaA = $('#idSalidaA').val();

  let token = $('[name="csrf_token"]').val();
      if(token){
              console.log(token);

  $.ajax({
      type: "post",
      url: "", 
      dataType: "json",
      data: {
                  modificarE:true,
                  feMenu,
                  cantPlatos,
                  nomEvent,
                  descripEvent,
                  horarioComida,
                  descripcion,
                  idEvento: id,
                  idSalidaA,
                  idMenu,
                  csrfToken: token   
      },
      success(response) {
          if (response.resultado === "error") {
              Swal.fire({
                  toast: true,
                  position: 'top-end',
                  icon: 'error',
                  title: response.mensaje,
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
              });
          } else {
             $('[name="csrf_token"]').val(response.newCsrfToken);
              console.log('Alimento devuelto al stock');
          }
      }
  });
}
}



            

function modificar() {
      $("#editar").prop("disabled", false);
      let feMenu = $("#feMenu").val();
      let horarioComida = $("input[name='opcion']:checked").val();
      let cantPlatos = $("#cantPlatos").val();
      let idMenu = $('#idMenu').val();
      let nomEvent = $("#nomEvent").val();
      let descripEvent = $("#descripEvent").val();
      let id = $('#idd').val();
      let descripcion = $("#descripcion").val();
      let idSalidaA = $('#idSalidaA').val();
      let token = $('[name="csrf_token"]').val();
    
      if(token){
       console.log(token);

          $.ajax({
              type: "post",
              url: "", 
              dataType: "json",
              data: {
                  modificarE:true,
                  feMenu,
                  cantPlatos,
                  nomEvent,
                  descripEvent,
                  horarioComida,
                  descripcion,
                  idEvento: id,
                  idSalidaA,
                  idMenu,
                  csrfToken: token            
                  },
            success(response) {
                if (response.resultado === "error" && response.newCsrfToken) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: response.mensaje,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                    $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> El evento ya esta registrado en esa fecha y horario!');
                    $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> El evento ya esta registrado en esa fecha y horario!');
                    $(".error5, .error6").show();
                    $('#feMenu').addClass('errorBorder');
                    $('.bar6').removeClass('bar');
                    $('.ic6').addClass('l');
                    $('.ic6').removeClass('labelPri');
                    $('.letra').addClass('labelE');
                    $('.letra').removeClass('label-char');
                    error_validarFH = true;
                    } 
                    else {
                    actualizarDetalle();  
                    $('[name="csrf_token"]').val(response.newCsrfToken); 
                    $('#cerrar2').click();
                    tablaEvento(); 
                    vaciarTabla();
                    Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon:'success',
                      title:'El Evento Fue Modificado Exitosamente!',
                      showConfirmButton:false,
                      timer:2500,
                      timerProgressBar:true,
                    });  
                }
              
            },
            complete() {
                $("#editar").prop("disabled", false);  
            }
              
        });
          }
      }


  function actualizarDetalle() {
    let idMenu = $('#idMenu').val();
    let idSalidaA = $('#idSalidaA').val();
    let alimentosEnviados = [];  


  $('#tabla3 tbody tr').each(function () {
      let alimento = $(this).find('.idAlimento2').val();
      let cantidad = $(this).find('#cantidadA').val();

     
         // Verificar si el alimento ya ha sido enviado, para evitar duplicados
         if (!alimentosEnviados.includes(alimento) && cantidad > 0) {  // Solo si la cantidad es mayor a 0
          alimentosEnviados.push(alimento);  // Añadir el alimento a la lista de procesados

          $.ajax({
              url: "",  
              method: "post",
              dataType: "json",
              data: {
                  cantidad,
                  idMenu,
                  alimento,
                  idSalidaA
              },
              success(data) {
                  console.log(data);
              }
          });
      }
  });
}

           

     function primary (){
      $(".error2, .error3, .error4, .error5, .error6, .error7, .error8, .error9, error10").html("");
       $(".error2, .error3, .error4, .error5, .error6, .error7, .error8, .error9, .error10").hide();
       $('#tipoA, #alimento, #cantidad, #feMenu, #cantPlatos, #nomEvent, #descripEvent, #descripcion').removeClass('is-invalid');
        $('#cantidad, #feMenu, #cantPlatos, #nomEvent, #descripEvent, #descripcion').removeClass('errorBorder');
       $('.bar2, .bar3, .bar4, .bar5, .bar6, .bar7, .bar8, .bar9, .bar10').addClass('bar');
       $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8, .ic9, .ic10').removeClass('l');
       $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8, .ic9, .ic10').addClass('labelPri');
       $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8, .letra9, .letra10').removeClass('labelE');
       $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8, .letra9, .letra10').addClass('label-char');
       $('#tipoA, #alimento').val('Seleccionar').trigger('change.select2');
       $('#cantPlatos, #nomEvent, #descripEvent, #descripcion').val('');
       $('input[type=checkbox]').prop('checked', false);
       $('#disponibilidad').hide();
       $('#agregarInventario').prop('disabled', false);
        $('input[type=checkbox]').removeClass('is-invalid')

   }


function primary2 (){
$(".error2, .error3, .error4").html("");
$(".error2, .error3, .error4").hide();
$('#tipoA, #alimento').removeClass('is-invalid');
$('#cantidad').removeClass('errorBorder');
$('.bar2, .bar3, .bar4').addClass('bar');
$('.ic2, .ic3, .ic4').removeClass('l');
$('.ic2, .ic3, .ic4').addClass('labelPri');
$('.letra2, .letra3, .letra4').removeClass('labelE');
$('.letra2, .letra3, .letra4').addClass('label-char');
$('#tipoA, #alimento').val('Seleccionar').trigger('change.select2');
$('#disponibilidad').hide();
$('#agregarInventario').prop('disabled', false);
 $('input[type=checkbox]').removeClass('is-invalid')
}

function primary3(){
$('.error5').html('');
$('#tablita #horarioComida #horarioC').each(function () {
    $(this).find('.checkHorarioComida').removeClass('is-invalid') ;
})
}



let error_tipoA= false;
let error_alimento=false;
let error_cantidad= false;
let  error_fecha = false;
let error_cantidadE= false;
let error_nombreE= false;
let error_descripE = false;
let error_horarioC = false;
let error_descrip = false;
let error_veriTA = false;
let error_veriA = false;
let error_tabla=false;
let error_validarFH = false;
let hoyA= $('#feMenu');
const tableContainer = document.getElementById('tablas1');
const tableContainer2 = document.getElementById('totalD');


// ----------------------- VALIDACIONES -----------------------------

function chequeo_tipoA() { 
var tipoA = $("#tipoA").val();
if (tipoA != 'Seleccionar') {
$(".error2").html("");
$(".error2").hide();
$('#tipoA').removeClass('is-invalid');
$('.bar2').addClass('bar');
$('.ic2').removeClass('l');
$('.ic2').addClass('labelPri');
$('.letra2').removeClass('labelE');
$('.letra2').addClass('label-char');
} else {
$(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el tipo de alimento!');
$(".error2").show();
$('#tipoA').addClass('is-invalid');
$('.bar2').removeClass('bar');
$('.ic2').addClass('l');
$('.ic2').removeClass('labelPri');
$('.letra2').addClass('labelE');
$('.letra2').removeClass('label-char');
error_tipoA = true;
}
}


function chequeo_alimento() { 
var alimento = $("#alimento").val();
if (alimento != 'Seleccionar') {
$(".error3").html("");
$(".error3").hide();
$('#alimento').removeClass('is-invalid');
$('.bar3').addClass('bar');
$('.ic3').removeClass('l');
$('.ic3').addClass('labelPri');
$('.letra3').removeClass('labelE');
$('.letra3').addClass('label-char');
} else {
$(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el alimento!');
$(".error3").show();
$('#alimento').addClass('is-invalid');
$('.bar3').removeClass('bar');
$('.ic3').addClass('l');
$('.ic3').removeClass('labelPri');
$('.letra3').addClass('labelE');
$('.letra3').removeClass('label-char');
error_alimento = true;
}
}

function chequeo_cantidad() {
var chequeo = /^[1-9]\d*$/;
let alimento = $('.alimento').val();
var cantidad = $("#cantidad").val();

disponible(alimento).then(mostrarCantidadDisponible => {
console.log(mostrarCantidadDisponible);
console.log(alimento);

if (chequeo.test(cantidad) && cantidad !== 0) {
$(".error4").html("");
$(".error4").hide();
$('#cantidad').removeClass('errorBorder');
$('.bar4').addClass('bar');
$('.ic4').removeClass('l');
$('.ic4').addClass('labelPri');
$('.letra4').removeClass('labelE');
$('.letra4').addClass('label-char');
} else {
$(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de alimentos!');
$(".error4").show();
$('#cantidad').addClass('errorBorder');
$('.bar4').removeClass('bar');
$('.ic4').addClass('l');
$('.ic4').removeClass('labelPri');
$('.letra4').addClass('labelE');
$('.letra4').removeClass('label-char');
error_cantidad = true;
}

if (cantidad > mostrarCantidadDisponible) {
$(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese una cantidad igual o inferior a lo que está disponible!');
$(".error4").show();
$('#cantidad').addClass('errorBorder');
$('.bar4').removeClass('bar');
$('.ic4').addClass('l');
$('.ic4').removeClass('labelPri');
$('.letra4').addClass('labelE');
$('.letra4').removeClass('label-char');
$('#agregarInventario').prop('disabled', true);
error_cantidad = true;
} else {
$(".error4").html("");
$(".error4").hide();
$('#cantidad').removeClass('errorBorder');
$('.bar4').addClass('bar');
$('.ic4').removeClass('l');
$('.ic4').addClass('labelPri');
$('.letra4').removeClass('labelE');
$('.letra4').addClass('label-char');
$('#agregarInventario').prop('disabled', false);
}
}).catch(error => {
console.error('Error al obtener la cantidad disponible:', error);
});
}

function chequeo_fecha() {
    const fecha = Date.parse($("#feMenu").val());
    const hoy = new Date();
    hoy.setHours(0,0,0,0); 

    if (!isNaN(fecha) && fecha >= hoy) {
        $(".error5").html("");
        $(".error5").hide();
        $('#feMenu').removeClass('errorBorder');
        $('.bar5').addClass('bar');
        $('.ic5').removeClass('l');
        $('.ic5').addClass('labelPri');
        $('.letra5').removeClass('labelE');
        $('.letra5').addClass('label-char');
        error_fecha = false;
    } else {
        $(".error5").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese la Fecha, No debe ser menor a la fecha de hoy!');
        $(".error5").show();
        $('#feMenu').addClass('errorBorder');
        $('.bar5').removeClass('bar');
        $('.ic5').addClass('l');
        $('.ic5').removeClass('labelPri');
        $('.letra5').addClass('labelE');
        $('.letra5').removeClass('label-char');
        error_fecha = true;
    }
}

$("#feMenu").on("change", chequeo_fecha);

function chequeo_cantidadE() {
    const chequeo = /^[1-9]\d*$/;
    const cantidadE = $("#cantPlatos").val();
    if (chequeo.test(cantidadE) && cantidadE !== 0) {
    $(".error6").html("");
    $(".error6").hide();
    $('#cantPlatos').removeClass('errorBorder');
    $('.bar6').addClass('bar');
    $('.ic6').removeClass('l');
    $('.ic6').addClass('labelPri');
    $('.letra6').removeClass('labelE');
    $('.letra6').addClass('label-char');
    } else {
    $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de comensales!');
    $(".error6").show();
    $('#cantPlatos').addClass('errorBorder');
    $('.bar6').removeClass('bar');
    $('.ic6').addClass('l');
    $('.ic6').removeClass('labelPri');
    $('.letra6').addClass('labelE');
    $('.letra6').removeClass('label-char');
    error_cantidadE = true;
    }
}

function chequeo_nombreE() {
  const chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
  const nomEvent = $("#nomEvent").val();
  if (chequeo.test(nomEvent) && nomEvent !== '') {
   $(".error7").html("");
   $(".error7").hide();
   $('#nomEvent').removeClass('errorBorder');
   $('.bar7').addClass('bar');
   $('.ic7').removeClass('l');
   $('.ic7').addClass('labelPri');
   $('.letra7').removeClass('labelE');
   $('.letra7').addClass('label-char');
  } else {
   $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el nombre del Evento!');
   $(".error7").show();
   $('#nomEvent').addClass('errorBorder');
   $('.bar7').removeClass('bar');
   $('.ic7').addClass('l');
   $('.ic7').removeClass('labelPri');
   $('.letra7').addClass('labelE');
   $('.letra7').removeClass('label-char');
     error_nombreE = true;
  }
}

function chequeo_descripE() {
  const chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
  const descripE = $("#descripEvent").val();
  if (chequeo.test(descripE) && descripE !== '') {
   $(".error8").html("");
   $(".error8").hide();
   $('#descripEvent').removeClass('errorBorder');
   $('.bar8').addClass('bar');
   $('.ic8').removeClass('l');
   $('.ic8').addClass('labelPri');
   $('.letra8').removeClass('labelE');
   $('.letra8').addClass('label-char');
  } else {
   $(".error8").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción del evento!');
   $(".error8").show();
   $('#descripEvent').addClass('errorBorder');
   $('.bar8').removeClass('bar');
   $('.ic8').addClass('l');
   $('.ic8').removeClass('labelPri');
   $('.letra8').addClass('labelE');
   $('.letra8').removeClass('label-char');
     error_descripE = true;
  }
}

function validarCheck() {
const checkboxes = $('input[type=checkbox]');
const errorElement = $('.error9');
let selected = false;

checkboxes.on('change', function() {
if ($(this).is(':checked')) {
 checkboxes.not(this).prop('checked', false).removeClass('is-invalid');
 selected = true;
} else {
 selected = false;
}

if (selected) {
 errorElement.html('');
 checkboxes.removeClass('is-invalid');
} else {
 errorElement.html('<i class="bi bi-exclamation-triangle-fill"></i> ¡Seleccione un horario para el menú!');
 checkboxes.addClass('is-invalid');
}
});

if ($('input[type=checkbox]:checked').length == 0) {
errorElement.html('<i class="bi bi-exclamation-triangle-fill"></i> ¡Seleccione un horario para el menú!');
checkboxes.addClass('is-invalid');
error_horarioC = true;
} else {
errorElement.html('');
checkboxes.removeClass('is-invalid');
}
}


function chequeo_descripcion() {
const chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
const descripcion = $("#descripcion").val();
if (chequeo.test(descripcion) && descripcion !== '') {
$(".error10").html("");
$(".error10").hide();
$('#descripcion').removeClass('errorBorder');
$('.bar10').addClass('bar');
$('.ic10').removeClass('l');
$('.ic10').addClass('labelPri');
$('.letra10').removeClass('labelE');
$('.letra10').addClass('label-char');
} else {
$(".error10").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción del menú!');
$(".error10").show();
$('#descripcion').addClass('errorBorder');
$('.bar10').removeClass('bar');
$('.ic10').addClass('l');
$('.ic10').removeClass('labelPri');
$('.letra10').addClass('labelE');
$('.letra10').removeClass('label-char');
error_descripcion = true;
}
}




      function verificarTipoA(){
      
        let tipoA = $("#tipoA").val();
        if (tipoA != 'Seleccionar') {
          $.ajax({
                 type: "POST",
                 url: '',
                 dataType: "json",
                 data:{ valida:'si', tipoA},
                 success(data){
                   if (data.resultado === 'no esta') {
                       mostrarTipoA();
                       Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">El tipo de alimento  ha sido anulado recientemente!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                       })
                     
                       error_veriTA = true;
                   }
                     
                   
                   }
                 })
               }
         

      }


      function verificarAlimento(){

      
        let alimento = $("#alimento").val();
        if (alimento != 'Seleccionar') {
          $.ajax({
                 type: "POST",
                 url: '',
                 dataType: "json",
                 data:{ valida2:'si', alimento},
                 success(data){
                   if (data.resultado === 'no esta') {
                       mostrarTipoA();
                       Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'error',
                         title:'<b class="text-rojo">El  alimento  ha sido anulado recientemente!</b>',
                         showConfirmButton:false,
                         timer:3000,
                         timerProgressBar:3000,
                       })
                     
                       error_veriA = true;
                   }
                     
                   
                   }
                 })
               }
      }

      function validarFH(){
         let feMenu = $("#feMenu").val();
         let horarioComida = $("input[name='opcion']:checked").val();
         let id = $('#idd').val();
         const fecha = Date.parse($("#feMenu").val());
         const hoy = new Date();

          if ( !isNaN(fecha) && fecha >= hoy && horarioComida != '' ) {
           $.ajax({
                  type: "POST",
                  url: '',
                  dataType: "json",
                  data:{ validar:'si', 
                   feMenu,
                   horarioComida, 
                   id
                   },
                   success: function(response) {
                     if (response.resultado === "error") {
                        Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title: response.mensaje,
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                        })
                        $("#editar").prop("disabled", true);
                        $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> El menú ya esta registrado en esa fecha y horario!');
                        $(".error9").html('<i  class="bi bi-exclamation-triangle-fill"></i> El menú ya esta registrado en esa fecha y horario!');
                        $(".error5, .error9").show();
                        $('#feMenu').addClass('errorBorder');
                        $('.bar9').removeClass('bar');
                        $('.ic9').addClass('l');
                        $('.ic9').removeClass('labelPri');
                        $('.letra').addClass('labelE');
                        $('.letra').removeClass('label-char');
                        error_validarFH = true;
                    
                     }
                     else{
                       $("#editar").prop("disabled", false);
                        $(".error5, .error9").hide();
                        $('#feMenu').removeClass('errorBorder');
                        $('.bar9').addClass('bar');
                        $('.ic9').removeClass('l');
                        $('.ic9').addClass('labelPri');
                        $('.letra').removeClass('labelE');
                        $('.letra').addClass('label-char');


                      }
                       
                    }
                  })
               }
  
      }

 



    ////---------------------------MOSTRAR SELECT TIPO DE ALIMENTOS -------------------------------
mostrarTipoA();
let select;
select=$('#tipoA');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoA(){
 $.ajax({
   url: '',
   type: 'POST',
   dataType: 'JSON',
   data: {select: 'mostrar'}, 
   success(response){

     let opE = '';
     response.forEach(fila => {
       opE += `<option  value="${fila.idTipoA}">${fila.tipo} </option> `
     })
     $('#tipoA').html(input + opE);
   }
 })
}




////---------------------------MOSTRAR SELECT DE ALIMENTOS -------------------------------
let select2;
select2 = $('#alimento');
let input2;
input2 = ' <option value="Seleccionar">Seleccionar</option>';

function mostrarAlimento(a) {
 let tipoA = a;
 $.ajax({
   url: '',
   type: 'POST',
   dataType: 'JSON',
   data: {select2: 'mostrar', tipoA},
   success(response) {
     let opE = '';
     response.forEach(fila => {
       let imgSrc = fila.imgAlimento.toLowerCase().replace(' ', '_');
       if (fila.marca === 'Sin Marca') {
         opE += `<option value="${fila.idAlimento}" data-img_src="${imgSrc}">${fila.nombre}</option>`;
       } else {
            opE += `<option value="${fila.idAlimento}" data-img_src="${imgSrc}">${fila.nombre} - ${fila.marca} - ${fila.unidadMedida}</option>`;
        }
     });
     $('#alimento').html(input2 + opE);
   }
 });
}

$(document).ready(function() {
$("#tipoA").select2({
 theme: 'bootstrap-5',
 dropdownParent: $('#sel'),
 selectionCssClass: "input",
 width: '100%'
});

$("#alimento").select2({
 theme: 'bootstrap-5',
 dropdownParent: $('#sel2'),
 selectionCssClass: "input",
 width: '100%',
 templateResult: formatState,
 templateSelection: formatState
});

function formatState(state) {
 if (!state.id) {
   return state.text;
 }
 let imgSrc = $(state.element).data('img_src');
 if (imgSrc) {
   let $state = $(`
     <span>
       <img src="${imgSrc}" class="img-flag" style="width: 25px; height: 25px; margin-right: 10px;" />
       ${state.text}
     </span>
   `);
   return $state;
 }
 return state.text;
}
});
      

function newAlimento(idAlimento,imagen, alimento, marca, cantidad, unidad, contNeto){
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
  
      <tr class='${idAlimento}'>
         <td class='d-none'><input class='d-none idAlimento2'  value='${idAlimento}'></td>
         <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
         <td>${alimento} ${cont}</td>
         <td>${marca} </td>
         <td>${cantidad} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
         <td>
            <a id='quitarFila'  class="btn btn-sm btn-icon text-danger text-center " value='${idAlimento}'   data-bs-toggle="tooltip" title="Borrar Alimento"   type="button" >
                   <i class="bi bi-trash icon-24 t" width="20"></i>
            </a>
         </td>
      
      </tr>`;
  
      console.log(newAlimento);
      return newAlimento;
  
      }
  
function mostrarLoQueQueda(imagen, codigo, nombre, cantidad, restar, unidad, marca) {
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

  function mostrar2(alimento){
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
        let idAlimento = alimento;
          $.ajax({
            url: '',
            type: 'POST',
            dataType: 'JSON',
            data: {muestra:true, idAlimento}, 
            success(data){
            let newRow= newAlimento(data[0].idAlimento,data[0].imgAlimento, data[0].nombre, data[0].marca, cantidad, data[0].unidadMedida, data[0].unidadMedida);
            let newRow2= mostrarLoQueQueda(data[0].imgAlimento, data[0].codigo, data[0].nombre, data[0].stock, cantidad,data[0].unidadMedida, data[0].marca);
            $('#tablaD').show(1000);
             $('#ani').show(1000);
            $('#tabla3 tbody').append(newRow);
            $('.tabla2 tbody').append(newRow2);
            $('#cancelarInventario').click();
            tableContainer.scrollTop = tableContainer.scrollHeight;
            tableContainer2.scrollTop = tableContainer2.scrollHeight;
      
            }
          })
      
      }
  
      function mostrarCantidadDisponible(alimento){
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
               if ($('#tabla3 tbody tr').length === 0) {
                   $('#tablaD').hide(1000);
                  error_tabla=true;
               } 
           }
       
           validarTabla();

           function vaciarTabla() {
           const tabla = document.getElementById('tabla3').getElementsByTagName('tbody')[0];
           while (tabla.firstChild) {
               tabla.removeChild(tabla.firstChild);
           }

           const tabla2 = document.getElementById('tabla2').getElementsByTagName('tbody')[0];
           while (tabla2.firstChild) {
               tabla2.removeChild(tabla2.firstChild);
           }
       }








// ---------------------------- ANULAR

function valAnulacion(idd){
    let id = idd;
    $.ajax({
     url: "",
     dataType: 'json',
     method: "POST",
     data: {valAnulacion: true, id: id },
     success: function(data) {
 
       if (data.resultado === "no se puede"){
          $('#borrarE').modal('hide');
          $('#cerrar3').click();
              Swal.fire({
                 toast: true,
                 position: 'top-end',
                 icon:'error',
                 title: `<b class="fw-bold text-rojo">No se puede Eliminar!</b><b style="font-size:13px!important;">
                Este evento ya fue realizado. `,
                 showConfirmButton:false,
                 timer:3000,
                 timerProgressBar:3000,
             })
              
            }
             if (data.resultado === "se puede") {
              $('#borrarE').modal('show');
            }
            } 
    })
 
   }
 

 //------------ ELIMINAR AJAX----------------------------------------
 
   $(document).on('click', '.borrar', function() {
    let id = this.id;

     $.ajax({
     url: "",
     dataType: 'json',
     method: "POST",
     data: {infoEvento: 'anular', id},

     success: function(data) {
      if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         tablaEvento();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">El evento fue eliminado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
         else{
               valAnulacion(id);
               $('#idE').val(id);
               $('.eliminarE').html( '¿Deseas eliminar el evento <b class="azul5">'+data[0].nomEvent+'</b> ?');
            
         }
      
     }
 
    })
 
   });
 


   //-----------------------------------------------------------------------------------------
   
   $('#borrar').click((e)=>{

    let idE= $('#idE').val();
    let token = $('[name="csrf_token"]').val();

     if (token) {                 
      console.log(token);
       e.preventDefault();

          console.log('Botón eliminar clickeado, enviando AJAX...');
 
     e.preventDefault();
     $.ajax({
       url: '',
       method: 'post',
       dataType: 'json',
       data:{
        eliminar: true, 
        id : idE ,
        borrar: 'borrar',
        csrfToken: token
        },
       success(data){
         console.log(data);
        if (data.resultado === 'eliminado' && data.newCsrfToken ) {
          $('[name="csrf_token"]').val(data.newCsrfToken);             
         $('#cerrar3').click();
         tablaEvento();
           Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'success',
                title:'Evento Eliminado Exitosamente!',
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

     $('#idEvento').val(id);
 })

function exportarReporte(){

   let idEvento = $('#idEvento').val();
   $('.loadingAnimation').show();
   
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
   
   let inputIdEvento = document.createElement('input');
   inputIdEvento.type = 'hidden';
   inputIdEvento.name = 'idEvento';
   inputIdEvento.value = idEvento;
   form.appendChild(inputIdEvento);

   // Añadir y enviar el formulario
   document.body.appendChild(form);
   form.submit();
   document.body.removeChild(form); // Limpiar el formulario

   $('#clos').click();

   // Ocultar la animación después de un tiempo, ya que la descarga es asíncrona respecto al JS
   setTimeout(() => {
       $('.loadingAnimation').hide();
   }, 3000); 
}

$('#reportebtn').click(()=>{
   exportarReporte();
})

$('#evento1').addClass('active');
$('#even3').addClass('text-primary');
$('.even3').addClass('active');

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