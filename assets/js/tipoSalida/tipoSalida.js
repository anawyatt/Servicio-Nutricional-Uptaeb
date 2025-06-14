
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

let tabla ;
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
        console.log(response);

        let lista = '';
        response.forEach(fila => {
          lista += `
       <tr>
                <td class="text-left">${fila.tipoSalida}</td>
              <td class="text-center d-grid gap-2 d-flex justify-content-lg-center accion" >
                  <a class="btn btn-sm btn-icon text-primary flex-end modificar" data-bs-toggle="tooltip" title="Modificar Tipo de Salida" href="#" type="button" id="${fila.idTipoSalidas}" >
                    <span class="btn-inner pi"><i class="bi bi-pencil icon-24 t" width="20"></i></span>
                  </a>
                  <a class="btn btn-sm btn-icon text-danger eliminar"  data-bs-toggle="tooltip" title="Anular Tipo de Salida" href="#"  type="button" id="${fila.idTipoSalidas}">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                  </a>
              </td>
       </tr>
          `
        })
      
        $('#tbody').html(lista);
        tabla = $('.tabla').DataTable();
         tabla.on('draw.dt', function () {
              quitarBotones();
             });

            quitarBotones();
      }
    })
  }

function cambiarFormato(texto) {
   // Dividir la cadena en palabras utilizando espacios
   const palabras = texto.split(" ");
   let palabrasFormateadas = [];
 
   // Recorrer las palabras
   for (let i = 0; i < palabras.length; i++) {
       // Eliminar espacios en blanco adicionales y formatear cada palabra
       if (palabras[i].trim() !== "") {
           palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
       }
   }
 
   // Unir las palabras formateadas nuevamente en una cadena
   return palabrasFormateadas.join(" ");
 }


//----------------------- VALIDAR REGISTRAR -----------------------------------
let error_tipoS= false;
let error_val =false;
$(".error1").hide();

      $("#tipoS").focusout(function(){
         val_tipoS();
         validar_tipoS();
      });

      $("#tipoS").on('keyup', function() {
         val_tipoS();
         validar_tipoS();
      });

       $("#registrar").on("click", function(e){ 
        error_tipoS= false;
        error_val=false;

        validar_tipoS();
        val_tipoS()

        if (error_tipoS == false && error_val == false) {
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
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i>¡El tipo de Salida ya existe!');
              $(".error1").show();
              $('#tipoS').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
       }

       function primary(){
             $(".error1").html("");
             $(".error1").hide();
             $('#tipoS').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
       }

      function val_tipoS() {
          var chequeo = /^[a-zA-ZÀ-ÿ\s\-\_]{3,}$/;
          var nombre = $("#tipoS").val();
          if (chequeo.test(nombre) && nombre !== '') {
             $(".error1").html("");
             $(".error1").hide();
             $('#tipoS').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
          } else {
              $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i>¡Ingrese el tipo de Salida, solo Caracteres!');
              $(".error1").show();
              $('#tipoS').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
              error_tipoS = true;
          }
      }

      function validar_tipoS(){
      const tipoS = $("#tipoS").val();
       $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{tipoS},
         success(data){
                 if (data.resultado == 'error tipo') {
                     Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'error',
                           title:'El tipo de Salida <b class="fw-bold text-rojo">'+tipoS+'</b> ya esta registrado, ingrese otro tipo de Salida!',
                           showConfirmButton:false,
                           timer:3000,
                           timerProgressBar:3000,
                        })
                     danger();
                    error_val=true;
                  } 
                   else{
                   primary();
     
                 }

            }
       })
    }

   
// REGISTRAR 

function registrar(){
     $("#registrar").prop("disabled", true);
     const tipoS = cambiarFormato($("#tipoS").val());
    
            $.ajax({
                type: "post",
                url: "", 
                dataType: 'JSON',
                data: { registrar:true,
                  tipoS
                },
                success(data) {
                  if (data.resultado== 'registrado') {
                      primary()
                        $('.limpiar.cierra').click();
                        $('.formu').trigger('reset'); 
                        delete tabla;
                        mostrarTabla();
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'success',
                           title:'El tipo de Salida <b class="text-primary fw-bold">'+tipoS+'</b> Registrado Exitosamente!',
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

//----------------------- VALIDAR Modificar -----------------------------------
let error_tipoS2= false;

      $(".error2").hide();

      $("#tipoS2").focusout(function(){
         val_tipoS2();
      });

      $("#tipoS2").on('keyup', function() {
         val_tipoS2();
      });

      $("#editar").on("click", function(e){ 
        error_tipoS2 = false;  
        val_tipoS2();  
    
        if (error_tipoS2 === false) {  
            modificarTipoSalida();
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<span class="text-rojo">¡Ingrese los Datos Correctamente!</span>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: 3000,
                width: '38%',
            });
        }
    });
        function danger1(){
             $(".error2").show();
             $('.error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> ¡El tipo de Salida ya existe!');
             $('#tipoS2').addClass('errorBorder');
             $('.bar2').removeClass('bar');
             $('.ic2').addClass('l');
             $('.ic2').removeClass('labelPri');
             $('.letra2').addClass('labelE');
             $('.letra2').removeClass('label-char');
       }

       function primary2(){
              $(".error2").html("");
              $(".error2").hide();
              $('#tipoS2').removeClass('errorBorder');
              $('.bar2').addClass('bar');
              $('.ic2').removeClass('l');
              $('.ic2').addClass('labelPri');
              $('.letra2').removeClass('labelE');
              $('.letra2').addClass('label-char');
       }

      
function val_tipoS2() {
  var chequeo = /^[a-zA-ZÀ-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{3,}$/; 
  var nombre = $("#tipoS2").val();
  
  if (chequeo.test(nombre) && nombre !== '') {
      $(".error2").html("");
      $(".error2").hide();
      $('#tipoS2').removeClass('errorBorder');
      $('.bar2').addClass('bar');
      $('.ic2').removeClass('l');
      $('.ic2').addClass('labelPri');
      $('.letra2').removeClass('labelE');
      $('.letra2').addClass('label-char');
      error_tipoS2 = false; 
  } else {
      $(".error2").html('<i class="bi bi-exclamation-triangle-fill"></i> ¡Ingrese el tipo de Salida, solo Caracteres!');
      $(".error2").show();
      $('#tipoS2').addClass('errorBorder');
      $('.bar2').removeClass('bar');
      $('.ic2').addClass('l');
      $('.ic2').removeClass('labelPri');
      $('.letra2').addClass('labelE');
      $('.letra2').removeClass('label-char');
      error_tipoS2 = true; 
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
      if(id== 1){
        $('#modificarTS').modal('hide');
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span >¡El Tipo de Salida <b class=" text-rojo" >Menú</b> no puede ser modificado!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
      }
      else{
        if (data.resultado === "no se puede"){
          $('#modificarTS').modal('hide');
          $('#cerrar2').click();
              Swal.fire({
                 toast: true,
                 position: 'top-end',
                 icon:'error',
                 title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">
                 El Tipo de Salida ya está registrado en las salidas de los alimentos. `,
                 showConfirmButton:false,
                 timer:3000,
                 timerProgressBar:3000,
             })
              
            }
            if(data.resultado === "se puede"){
             $('#modificarTS').modal('show');
            }
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
    $('#tipoS2').val(data[0].tipoSalida);
    $('#idd').val(data[0].idTipoSalidas);
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
    $('#tipoS2').val(data[0].tipoSalida);
    }

   })

  });


 //--------------------------------------------------------------------------

 function modificarTipoSalida(){
  $("#editar").prop("disabled", false);
  let tipoS2 = cambiarFormato($('#tipoS2').val());

  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'json',
    data:{tipoS2 , id},
    success(data){
      if (data.resultado === 'ya no existe') {
      $('#cerrar2').click();
       delete tabla;
       mostrarTabla();
       Swal.fire({
              toast: true,
              position: 'top-end',
              icon:'error',
              title:'El Tipo de salida <b class="fw-bold text-rojo">'+tipoS+'</b> fue anulado recientemente!',
              showConfirmButton:false,
              timer:3000,
              timerProgressBar:3000,
          })
      }
      else{
           if (data.resultado === "error tipo"){
           Swal.fire({
              toast: true,
              position: 'top-end',
              icon:'error',
              title:'El Tipo de salida <b class="fw-bold text-rojo">'+tipoS2+'</b> ya está registrado, ingrese otro tipo de salida!',
              showConfirmButton:false,
              timer:3000,
              timerProgressBar:3000,
          })
            $('#error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El salida ya existe!');
           danger1()
         } 
         else {
          console.log(data);
          $('#cerrar2').click();
          delete tabla;
          mostrarTabla();
          Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'success',
             title:'<b class="text-primary fw-bold">'+tipoS2+'</b> Modificado Exitosamente!',
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



//------------ ELIMINAR AJAX----------------------------------------

  function valAnular(){
   id = this.id 
   console.log(id);
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {modificar: 'modificar', id},
    success(data){
      if(id== 1){
        $('#eliminaT').modal('hide');
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span >¡El Tipo de Salida <b class=" text-rojo" >Menú</b> no puede ser anulado!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
      }
      else{
        if (data.resultado === "no se puede" ){
          $('#eliminaT').modal('hide');
          $('#cerrar3').click();
              Swal.fire({
                 toast: true,
                 position: 'top-end',
                 icon:'error',
                 title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
                 El Tipo de Salida ya está registrado en las salidas de los alimentos. `,
                 showConfirmButton:false,
                 timer:3000,
                 timerProgressBar:3000,
             })
              
            }
            if(data.resultado === "se puede"){
             $('#eliminaT').modal('show');
            }

      }

     
           } 
   })

  }

  $(document).on('click', '.eliminar', function() {
    id = this.id;
     valAnular()
    $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {mostrar: 'anular', id},
    success(data){
     
      if (data[0].tipoSalida != 'Menú') {
          $('.eliminarTS').html( '¿Deseas Anular <b class="text-primary">'+data[0].tipoSalida+'</b> del tipo de Salida?');
      }
  
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  
  $('#borrar').click((e)=>{
    $("#borrar").prop("disabled", true);
    e.preventDefault();
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{id , borrar: 'borrar'},
      success(data){
        console.log(data);
        if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete tabla;
         mostrarTabla();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">¡El Tipo de Salida fue anulado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
        else{
        $('#cerrar3').click();
        delete tabla;
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
    })

$('#tipoS1').addClass('active');
