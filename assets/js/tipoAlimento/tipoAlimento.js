
//------------------------------- FUNCION MOSTRAR AJAX ------------------------------//
 //Consulta de Permisos
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
  if (typeof permisos.registrar == 'undefined') {
    console.log(permisos)
    $(".agregar").remove()   
     $(".agregar").addClass('d-none');
  }

  if (typeof permisos.modificar == 'undefined') {
    console.log(permisos)
    $(".modificar").remove()   
    $(".modificar").addClass('d-none');
  }

  if (typeof permisos.eliminar == 'undefined') {
    console.log(permisos)
    $(".eliminar").remove()   
    $(".eliminar").addClass('d-none');
  }

  if (typeof permisos.eliminar == 'undefined' && typeof permisos.modificar == 'undefined' ) {
    console.log(permisos)
    $(".accion").remove() 
    $(".accion").addClass('d-none');
  }
}

let tablaI ;
mostrarTabla();
$('#ani').hide(1000);


  function mostrarTabla(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra: 'mostrar', tabla: 'tabla'}, 
      success(response){
    $('#ani').show(2000);

    let lista = '';
    response.forEach(fila => {
      lista += `
        <tr>
            <td class="text-left">${fila.tipo}</td>
            <td class="text-center d-grid gap-2 d-flex justify-content-lg-center accion" >
                <a class="btn btn-sm btn-icon text-primary flex-end modificar" data-bs-toggle="tooltip" title="Modificar Tipo de Alimento" href="#" type="button" id="${fila.idTipoA}">
                    <span class="btn-inner pi"><i class="bi bi-pencil icon-24 t" width="20"></i></span>
                </a>
                <a class="btn btn-sm btn-icon text-danger eliminar" data-bs-toggle="tooltip" title="Anular Tipo de Alimento" href="#" type="button" id="${fila.idTipoA}">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                </a>
            </td>
        </tr>`;
    });

    if ($.fn.DataTable.isDataTable('.tabla')) {
        $('.tabla').DataTable().clear().destroy();
    }

    $('#tbody').html(lista);

    tablaI = $('.tabla').DataTable({
        destroy: true
    });

    tablaI.on('draw.dt', function () {
        quitarBotones();
    });

    quitarBotones();
}

    })
  }

function cambiarFormato(texto) {
   
   const palabras = texto.split(" ");
   let palabrasFormateadas = [];
 
   for (let i = 0; i < palabras.length; i++) {
       if (palabras[i].trim() !== "") {
           palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
       }
   }

   return palabrasFormateadas.join(" ");
 }


//----------------------- VALIDAR REGISTRAR -----------------------------------
let error_tipoA= false;
let error_val =false;
let timer;
$(".error1").hide();

      $("#tipoA").focusout(function(){
         val_tipoA();
      });

      $("#tipoA").on('keyup', function() {
         val_tipoA();
         clearTimeout(timer); 
         timer = setTimeout(function () {
           validar_tipoA();
         }, 500);
      });

       $("#registrar").on("click", function(e){ 
        error_tipoA= false;
        error_val=false;
        validar_tipoA();
        val_tipoA()

        if (error_tipoA == false && error_val == false) {
            registrar();
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

       $(document).on('click', '.limpiar', function () {
        primary();
       })

         function danger(){
              $(".error1").show();
              $('.tipoA').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
        }

       function primary(){
             $(".error1").html("");
             $(".error1").hide();
             $('.tipoA').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
       }

      function val_tipoA() {
          var chequeo = /^[a-zA-ZÀ-ÿ\s\-\_]{5,}$/;
          var nombre = $("#tipoA").val();
          if (chequeo.test(nombre) && nombre !== '') {
             primary();
          } else {
              $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el tipo de Alimento, solo Caracteres!');
              danger();
              error_tipoA = true;
          }
      }

      function validar_tipoA(){
      const tipoA = $("#tipoA").val();
       $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{tipoA},
         success(data){
                 if (data.resultado == 'error tipo') {
                     Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'error',
                           title:'El tipo de alimento <b class="fw-bold text-rojo">'+tipoA+'</b> ya esta registrado, ingrese otro tipo de Alimento!',
                           showConfirmButton:false,
                           timer:3000,
                           timerProgressBar:3000,
                        })
                     danger();
                     $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El tipo de alimento ya existe!');
                    error_val=true;
                  } 
                   else{
                    error_val=false;
                   primary();
                 }
                  $("#registrar").prop("disabled", false);

            }
       })
    }

   
// REGISTRAR 

function registrar(){
     $("#registrar").prop("disabled", true);
     const tipoA = cambiarFormato($("#tipoA").val());
     let token = $('[name="csrf_token"]').val();
     if(token){
        console.log(token);
            $.ajax({
                type: "post",
                url: "", 
                dataType: 'JSON',
                data: { registrar:true,tipoA, csrfToken: token },
                success(data) {
                   if (data.mensaje.resultado== 'registrado' && data.newCsrfToken) {
                        console.log(data);
                      primary()
                        $('#cerrarR').click();
                        $('.formu').trigger('reset'); 
                       $('[name="csrf_token"]').val(data.newCsrfToken);
                        delete tablaI;
                        mostrarTabla();
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'success',
                           title:'El tipo de Alimento <b class="text-primary fw-bold">'+tipoA+'</b> Registrado Exitosamente!',
                           showConfirmButton:false,
                           timer:2500,
                           timerProgressBar:true,
                       })
                  }

                    
                },complete() {
                    $("#registrar").prop("disabled", false);
                }
            });
          }
        }

//----------------------- VALIDAR Modificar -----------------------------------
let error_tipoA2= false;

      $(".error2").hide();

      $("#tipoA2").focusout(function(){
         val_tipoA2();
      });

      $("#tipoA2").on('keyup', function() {
         val_tipoA2();
         clearTimeout(timer); 
         timer = setTimeout(function () {
           validar_tipoA2();
         }, 500);
      });

       $("#editar").on("click", function(e){ 
        error_tipoA2= false;
        val_tipoA2();

        if (error_tipoA2 == false) {
           modificarTipoAlimento();
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
        function danger1(){
             $(".error2").show();
             $('.tipoA2').addClass('errorBorder');
             $('.bar2').removeClass('bar');
             $('.ic2').addClass('l');
             $('.ic2').removeClass('labelPri');
             $('.letra2').addClass('labelE');
             $('.letra2').removeClass('label-char');
       }

       function primary2(){
              $(".error2").html("");
              $(".error2").hide();
              $('.tipoA2').removeClass('errorBorder');
              $('.bar2').addClass('bar');
              $('.ic2').removeClass('l');
              $('.ic2').addClass('labelPri');
              $('.letra2').removeClass('labelE');
              $('.letra2').addClass('label-char');
       }

      function val_tipoA2() {
          var chequeo = /^[a-zA-ZÀ-ÿ\s\-\_]{5,}$/;
          var nombre = $("#tipoA2").val();
          if (chequeo.test(nombre) && nombre !== '') {
              primary2()
          } else {
             $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el tipo de alimento, solo Caracteres!');
             danger1();
             error_tipoA2 = true;
          }
      }


var id;

// MODIFICAR

function valModificar(){
   id = this.id 
   console.log(id);
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {modificar: 'modificar', id},
    success(data){

      if (data.resultado === "no se puede"){
         $('#modificarTA').modal('hide');
         $('#cerrar2').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">
                El tipo de alimento está registrado en los alimentos. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#modificarTA').modal('show');
           }
           } 
   })

  }

$(document).on('click', '.modificar', function() {
   id = this.id 
   console.log(id);
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {mostrar: 'modificar', id},
    success(data){ 
      valModificar();
    $('#tipoA2').val(data[0].tipo);
    $('#idd').val(data[0].idTipoA);
    }

   })

  });


$(document).on('click', '.resetear', function() {
   id = $('#idd').val();
   console.log(id);
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {mostrar: 'modificar', id},
    success(data){ 
      primary2();
    $('#tipoA2').val(data[0].tipo);
    }

   })

  });


  function validar_tipoA2(){
      let tipoA2 = cambiarFormato($('#tipoA2').val());
       $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{tipoA2 , id},
         success(data){
          if (data.resultado === "error tipo2"){
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'El Tipo de alimento <b class="fw-bold text-rojo">'+tipoA2+'</b> ya está registrado, ingrese otro tipo de alimento!',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
            
              $('#error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El tipo de alimento ya existe!');
             danger1()
           } 
           else{
               primary2();
            }

            }
       })
    }



 //--------------------------------------------------------------------------

  function modificarTipoAlimento(){
    $("#editar").prop("disabled", false);
    let tipoA2 = cambiarFormato($('#tipoA2').val());
    let token = $('[name="csrf_token"]').val();
  if(token){
    console.log(token);
    $.ajax({
      url: '',
      method: 'POST',
      dataType: 'json',
      data:{tipoA2 , id, csrfToken: token},
      success(data){
        if (data.resultado === 'ya no existe') {
        $('#cerrar2').click();
         delete tablaI;
         mostrarTabla();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'El Tipo de alimento  fue anulado recientemente!',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
        else{
             if (data.resultado === "error tipo2"){
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'El Tipo de alimento <b class="fw-bold text-rojo">'+tipoA2+'</b> ya está registrado, ingrese otro tipo de alimento!',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
              $('#error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El tipo de alimento ya existe!');
             danger1()
           } 
          else if (data.mensaje.resultado === "Editado correctamente" && data.newCsrfToken) {
            $('[name="csrf_token"]').val(data.newCsrfToken);
            console.log(data);
            $('#cerrar2').click();
            delete tablaI;
            mostrarTabla();
            Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'<b class="text-primary fw-bold">'+tipoA2+'</b> Modificado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
            primary2()
          }
           else if (data.mensaje.resultado === "no hubo cambios" && data.newCsrfToken) {
            $('[name="csrf_token"]').val(data.newCsrfToken);
            console.log(data);
            $('#cerrar2').click();
            Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'warning',
               title:'No hubo cambios en el tipo de alimento <b class="text-primary fw-bold">'+tipoA2+'</b>!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
            primary2()
          }

        }
        
    },
  complete() {
      $("#editar").prop("disabled", false);
  }
    })
  }

  }



//------------ ELIMINAR AJAX----------------------------------------
  function valEliminar(){
   id = this.id 
   console.log(id);
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {modificar: 'modificar', id},
    success(data){

      if (data.resultado === "no se puede"){
         $('#eliminaT').modal('hide');
         $('#cerrar3').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
                El tipo de alimento está registrado en los alimentos. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#eliminaT').modal('show');
           }
           } 
   })

  }
  

  $(document).on('click', '.eliminar', function() {
    id = this.id;

    $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {mostrar: 'anular', id},
    success(data){
      valEliminar();
    $('.eliminarTA').html( '¿Deseas Anular <b class="text-primary">'+data[0].tipo+'</b> del tipo de alimentos?');
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  
  $('#borrar').click((e)=>{
    $("#borrar").prop("disabled", true);
    e.preventDefault();
   let token = $('[name="csrf_token"]').val();
    if(token){
      console.log(token);
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{id , borrar: 'borrar', csrfToken: token},
      success(data){
        console.log(data);
        if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete tablaI;
         mostrarTabla();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">El tipo de alimento fue anulado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
         else if (data.mensaje.resultado === 'anulado correctamente.' && data.newCsrfToken) {
       $('[name="csrf_token"]').val(data.newCsrfToken);
        $('#cerrar3').click();
        delete tablaI;
        mostrarTabla();
          Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Anulado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
      }
    },complete(){
      $("#borrar").prop("disabled", false);
  }
  })
}
    })

$('#tipoA1').addClass('active');

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