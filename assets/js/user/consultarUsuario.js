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
$(document).ready(function (){
    rellenar();
    let mostrar;
    $('#ani').hide(1000);

    function rellenar() {
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { mostrar: true },
            success(data) {
                 $('#ani').show(2000);
                let lista = data;
                let tabla = "";
                let resultado='';
                lista.forEach(row => {
                  console.log(row.status)
                   if (row.status === 1) { 

                       resultado =`<td class="text-center gray3"><span class="badge bg-primary blanco"> Activo </span></td> `;
                   }
                   else if (row.status === 2) {
                       resultado =`<td class="text-center gray3"><span class="badge bg-danger blanco"> Inactivo </span></td> `;
                    }
                    tabla += `
                    <tr>
                    <td class="text-center"><img src="${row.img}" width="50" height="50"alt="Profile" class="rounded-circle mb-2"></td>
                    <td class="">${row.cedula}</td>
                    <td class="">${row.nombre}</td>
                    <td class="">${row.apellido }</td>
                     `+ resultado +`
                    <td class="text-center accion">
                    <a id="${row.cedula}" class="btn btn-sm btn-icon text-info flex-end text-center infoUsuario" data-bs-toggle="modal" data-bs-target="#infoUsuario"data-bs-toggle="tooltip" title="informacion Usuario" href="#" >
                                <span class="btn-inner pi">
                               <i class="bi bi-eye icon-24 t" width="20"></i>
                                </span>
                            </a>
                    <a id="${row.cedula}" class="btn btn-sm btn-icon text-primary flex-end text-center editar" data-bs-toggle="modal" data-bs-target="#editarUsuario"data-bs-toggle="tooltip" title="Modificar Usuario" href="#" >
                                <span class="btn-inner pi">
                                <i class="bi bi-pencil icon-24 t" width="20"></i>
                                </span>
                            </a>
                    <a id="${row.cedula}" class="btn btn-sm btn-icon text-danger text-center borrar" data-bs-toggle="modal" data-bs-target="#borrarUsuario"  data-bs-toggle="tooltip" title="Anular Usuario" href="#"  type="button">
                            <i class="bi bi-trash icon-24 t" width="20"></i>
                            </a>
                    </td>
                </tr>
                    `;
                });
                $('#tbody_usuario').html(tabla);
                mostrar = $('.tabla').DataTable();
                mostrar.on('draw.dt', function () {
                    quitarBotones();
                   });
      
                  quitarBotones();
            }
        });

   ////---------------------------MOSTRAR SELECT ROLES -------------------------------
   mostrarRol();
   let select;
   select=$('#rol');
   let input;
   input= ' <option value="Seleccionar"> Seleccionar Rol</option>';
   
   function mostrarRol(){
       $.ajax({
         url: '',
         type: 'POST',
         dataType: 'JSON',
         data: {select2: 'mostrar'}, 
         success(response){
   
           let opE = '';
           response.forEach(fila => {
             opE += `<option  value="${fila.idRol}">${fila.nombreRol} </option> `
           })
           $('#rol').html(input + opE);
         }
       })
     }
   
     $(document).ready(function() {
       $("#rol").select2({
         theme: 'bootstrap-5',
         dropdownParent: $('#selectR'),
         selectionCssClass: "input",
         width: '100%'
       });

       $(".estado").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#selectR'),
        selectionCssClass: "input",
        width: '100%'
      });
    
     });

    
    

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

                
        let id;
        // Mostrar informacion 
        $(document).on('click', '.infoUsuario', function () {
            id = this.id;
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { verUsuario: true, id: id},
                success(data) {
                      let tabli1=" ", tabli2=" ";
                      let imag='';
        
                       tabli1=  `
                            <tr>
                            <td class="">${data.cedula}</td>
                            <td class="">${data.nombre}</td>
                            <td class="">${data.segNombre}</td>
                            <td class="">${data.apellido}</td>
                            <td class="">${data.segApellido}</td>
                        </tr>`;
        
                        tabli2=  `
                            <tr>
                            <td class="">${data.correo}</td>
                            <td class="">${data.telefono}</td>
                             <td class="">${data.nombreRol}</td>
                            </tr>`;



                        imag=`<img src="${data.img}" width="200" height="200"alt="Profile" class="rounded-circle mb-2">`
        
                       
                            $('#info1').html(tabli1);
                            $('#info2').html(tabli2);
                            $('#imag').html(imag);
                
        }
    });
               

            });


        let iD;
        // Mostrar informacion 
        $(document).on('click', '.editar', function () {
            iD = this.id;
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { verUsuario: true, id: iD},
                success(data) {

                   if (data.resultado === 'error usuario') {
                             $('.cerrar2').click();
                             rellenar();
                               Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<span class=" text-rojo">el usuario fue anulado recientemente!</span>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                   })
                            }
                            else{

                            
                    $("#cedula").val(data.cedula);
                    $("#nombre").val(data.nombre);
                    $("#segNombre").val(data.segNombre);
                    $("#apellido").val(data.apellido);
                    $("#segApellido").val(data.segApellido);
                    $("#correo").val(data.correo);
                    $("#telefono").val(data.telefono);
                    $("#rol").val(data.idRol).trigger('change');
                     $(".statusUser").val(data.status).trigger('change');
                     $("#idd").val(data.cedula);
                   }

            
                }
            });
        });

        $(document).on('click', '.resetear', function () {
           let id= $('#idd').val();
            $.ajax({
                type: "post",
                url: "",
                dataType: "json",
                data: { verUsuario: true, id: id },
                success(data) {
                  primary();
                    $("#cedula").val(data.cedula);
                    $("#nombre").val(data.nombre);
                    $("#segNombre").val(data.segNombre);
                    $("#apellido").val(data.apellido);
                    $("#segApellido").val(data.segApellido);
                    $("#correo").val(data.correo);
                    $("#telefono").val(data.telefono);
                    $("#rol").val(data.idRol);
                    $(".statusUser").val(data.status);
                }
            });
        });


        $("#nombre").focusout(function(){
          chequeo_nombre();
         });
         $("#nombre").on('keyup', function(){
          chequeo_nombre();
         });
      
         $("#segNombre").focusout(function(){
          chequeo_segNombre();
         });
         $("#segNombre").on('keyup', function(){
          chequeo_segNombre();
         });
      
         $("#apellido").focusout(function() {
          chequeo_apellido();
         });
         $("#apellido").on('keyup', function() {
          chequeo_apellido();
         });
      
         $("#segApellido").focusout(function() {
          chequeo_segApellido();
         });
         $("#segApellido").on('keyup', function() {
          chequeo_segApellido();
         });
      
         $("#correo").focusout(function() {
          chequeo_correo();
         });
         $("#correo").on('keyup', function() {
          chequeo_correo();
         });
      
         $("#telefono").focusout(function() {
          chequeo_telefono();
         });
         $("#telefono").on('keyup', function() {
          chequeo_telefono();
         });

$("#editar").on("click", function(e){
            e.preventDefault();
            error_nombre = false;
            error_segNombre = false;
            error_apellido = false;     
            error_segApellido = false;  
            error_correo = false;
            error_telefono=false;

            chequeo_nombre()
            chequeo_segNombre()
            chequeo_apellido()
            chequeo_segApellido()
            chequeo_correo()
            chequeo_telefono()

            if( error_nombre ==false && error_segNombre ==false && error_apellido==false && error_segApellido ==false && error_correo == false && error_telefono ==false ){
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

            function modificar(){

                let cedula = $("#cedula").val();
                let nombre = cambiarFormato($("#nombre").val());
                let segNombre = cambiarFormato($("#segNombre").val());
                let apellido =cambiarFormato( $("#apellido").val());
                let segApellido= cambiarFormato($("#segApellido").val());
                let correo = cambiarFormato($("#correo").val());
                let telefono = $("#telefono").val();
                let idRol = $("#rol").val();
                let estado=$('.statusUser').val();
                let token = $('[name="csrf_token"]').val();
                
                if(token){
                  console.log(token);
                $.ajax({
                    type: "post",
                    url: "", 
                    dataType: "json",
                    data: {
                      modificar: true,
                        cedula,
                        nombre, 
                        segNombre, 
                        apellido, 
                        segApellido, 
                        correo, 
                        telefono, 
                        idRol, 
                        estado,
                        csrfToken: token
                        },
                        success(data){
                          console.log(data);
                              if (data.resultado === "error correo" && data.newCsrfToken){
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'El Correo Electrónico  <b class="fw-bold text-rojo">'+correo+'</b> ya existe, ingrese otra Correo Electrónico!',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> El correo ya existe!');
                                $(".error6").show();
                                $('.correo').addClass('errorBorder');
                                $('.bar6').removeClass('bar');
                                $('.ic6').addClass('l');
                                $('.ic6').removeClass('labelPri');
                                $('.letra6').addClass('labelE');
                                $('.letra6').removeClass('label-char');
                                $('#val2').prop('disabled', true);
                               
                            
                             }
                             else if (data.resultado === "error telefono"){
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'El Nº de Teléfono  <b class="fw-bold text-rojo">'+telefono+'</b> ya existe, ingrese otro Nº de teléfono!',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> El telefono ya existe!');
                                $(".error7").show();
                                $('.telefono').addClass('errorBorder');
                                $('.bar7').removeClass('bar');
                                $('.ic7').addClass('l');
                                $('.ic7').removeClass('labelPri');
                                $('.letra7').addClass('labelE');
                                $('.letra7').removeClass('label-char');
                                $('#val2').prop('disabled', true);
                               
                            
                             }
                             else{
                              $('[name="csrf_token"]').val(data.newCsrfToken);
                              $('.cerrar2').click();
                            delete mostrar;
                            rellenar();
                             Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'success',
                                  title:'El Usuario <b class="text-primary fw-bold">'+nombre+' '+apellido+'</b> Modificado Exitosamente!',
                                  showConfirmButton:false,
                                  timer:2500,
                                  timerProgressBar:true,
                
                              })
                             }
                    
                           }
                           
                 
                         })
                 }
                   }

                 function primary(){
                    $(".error2, .error3, .error4, .error5,  .error6, .error7").html("");
                    $(".error2, .error3, .error4, .error5,  .error6, .error7").hide();
                    $('#nombre, #segNombre, #apellido, #segApellido, #correo, #telefono').removeClass('errorBorder');
                    $('.bar2, .bar3, .bar4, .bar5, .bar6, .bar7').addClass('bar');
                    $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7').removeClass('l');
                    $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7').addClass('labelPri');
                    $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7').removeClass('labelE');
                    $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7').addClass('label-char');
                  

                   }

// VALIDACIONES 

   let error_nombre = false;
   let error_segNombre = false;
   let error_apellido = false;     
   let error_segApellido = false;     
   let error_correo = false;
   let error_veriCO = false;
   let error_veriT=false;
   

   function chequeo_nombre() {
    var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
    var nombre = $("#nombre").val();
    if (chequeo.test(nombre) && nombre !='') {
     $(".error2").html("");
     $(".error2").hide();
     $('#nombre').removeClass('errorBorder');
     $('.bar2').addClass('bar');
     $('.ic2').removeClass('l');
     $('.ic2').addClass('labelPri');
     $('.letra2').removeClass('labelE');
     $('.letra2').addClass('label-char');
    } else {
     $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el nombre!');
     $(".error2").show();
     $('#nombre').addClass('errorBorder');
     $('.bar2').removeClass('bar');
     $('.ic2').addClass('l');
     $('.ic2').removeClass('labelPri');
     $('.letra2').addClass('labelE');
     $('.letra2').removeClass('label-char');
      $('#val1').prop('disabled', true);
       error_nombre = true;
    }
  }

  function chequeo_segNombre() {
    var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
    var nombre = $("#segNombre").val();
    if (chequeo.test(nombre)  || nombre.length == 0) {
     $(".error3").html("");
     $(".error3").hide();
     $('#segNombre').removeClass('errorBorder');
     $('.bar3').addClass('bar');
     $('.ic3').removeClass('l');
     $('.ic3').addClass('labelPri');
     $('.letra3').removeClass('labelE');
     $('.letra3').addClass('label-char');
    } else {
     $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el segundo nombre!');
     $(".error3").show();
     $('#segNombre').addClass('errorBorder');
     $('.bar3').removeClass('bar');
     $('.ic3').addClass('l');
     $('.ic3').removeClass('labelPri');
     $('.letra3').addClass('labelE');
     $('.letra3').removeClass('label-char');
      $('#val1').prop('disabled', true);
       error_segNombre = true;
    }
  }

  function chequeo_apellido() {
    var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
    var apellido = $("#apellido").val();
    if (chequeo.test(apellido) && apellido !== '') {
     $(".error4").html("");
     $(".error4").hide();
     $('#apellido').removeClass('errorBorder');
     $('.bar4').addClass('bar');
     $('.ic4').removeClass('l');
     $('.ic4').addClass('labelPri');
     $('.letra4').removeClass('labelE');
     $('.letra4').addClass('label-char');
    } else {
     $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el apellido!');
     $(".error4").show();
     $('#apellido').addClass('errorBorder');
     $('.bar4').removeClass('bar');
     $('.ic4').addClass('l');
     $('.ic4').removeClass('labelPri');
     $('.letra4').addClass('labelE');
     $('.letra4').removeClass('label-char');
     $('#val1').prop('disabled', true);
       error_apellido = true;
    }
  }

  function chequeo_segApellido() {
    var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
    var apellido = $("#segApellido").val();
    if (chequeo.test(apellido) || apellido.length == 0) {
     $(".error5").html("");
     $(".error5").hide();
     $('#segApellido').removeClass('errorBorder');
     $('.bar5').addClass('bar');
     $('.ic5').removeClass('l');
     $('.ic5').addClass('labelPri');
     $('.letra5').removeClass('labelE');
     $('.letra5').addClass('label-char');
    } else {
     $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el segundo apellido!');
     $(".error5").show();
     $('#segApellido').addClass('errorBorder');
     $('.bar5').removeClass('bar');
     $('.ic5').addClass('l');
     $('.ic5').removeClass('labelPri');
     $('.letra5').addClass('labelE');
     $('.letra5').removeClass('label-char');
     $('#val1').prop('disabled', true);
       error_segApellido = true;
    }
  }

  function chequeo_correo() {
    var campo = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/;
    var correo = $("#correo").val();
    if (campo.test(correo) ) {
     $(".error6").html("");
     $(".error6").hide();
     $('#correo').removeClass('errorBorder');
     $('.bar6').addClass('bar');
     $('.ic6').removeClass('l');
     $('.ic6').addClass('labelPri');
     $('.letra6').removeClass('labelE');
     $('.letra6').addClass('label-char');
    } else {
     $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el correo correctamente <b>(user2024@gmail.com)</b"');
     $(".error6").show();
     $('#correo').addClass('errorBorder');
     $('.bar6').removeClass('bar');
     $('.ic6').addClass('l');
     $('.ic6').removeClass('labelPri');
     $('.letra6').addClass('labelE');
     $('.letra6').removeClass('label-char');
      $('#val2').prop('disabled', true);
       error_correo= true;
    }
  }

  function chequeo_telefono() {
    var campo = /^0\d{10}$/;
    var telefono = $("#telefono").val();
    if (campo.test(telefono) ) {
     $(".error7").html("");
     $(".error7").hide();
     $('#telefono').removeClass('errorBorder');
     $('.bar7').addClass('bar');
     $('.ic7').removeClass('l');
     $('.ic7').addClass('labelPri');
     $('.letra7').removeClass('labelE');
     $('.letra7').addClass('label-char');
    } else {
     $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el número de teléfono <b>(04000000000)</b"');
     $(".error7").show();
     $('#telefono').addClass('errorBorder');
     $('.bar7').removeClass('bar');
     $('.ic7').addClass('l');
     $('.ic7').removeClass('labelPri');
     $('.letra7').addClass('labelE');
     $('.letra7').removeClass('label-char');
      $('#val2').prop('disabled', true);
       error_telefono= true;
    }
  }


        
 //------------ ELIMINAR AJAX----------------------------------------

  $(document).on('click', '.borrar', function() {
    iD = this.id;

    $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: { verUsuario: true, id: iD },
    success(data){
    $('.eliminarU').html( '¿Deseas anular al usuario <b class="text-primary">'+data.nombre+' '+data.apellido+'</b> del sistema?');
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  

  $('#borrar').click((e)=>{
   $("#borrar").prop("disabled", true);
   let token = $('[name="csrf_token"]').val();
    
  if (token) {                                 
    console.log(token);
    e.preventDefault();
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
     data: { 
      eliminar: true, 
      iD: iD, 
      csrfToken: token
    },
      success(data){
        if (data.resultado === 'eliminado' && data.newCsrfToken) {
        $('[name="csrf_token"]').val(data.newCsrfToken);
        $('#cerrarU').click();
         rellenar();
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
        else if (data.resultado === 'error usuario') {
        $('#cerrarU').click();
         rellenar();
         Swal.fire({
          toast: true,
          position: 'top-end',
          icon:'error',
          title:'<span class=" text-rojo">el usuario fue anulado recientemente!</span>',
          showConfirmButton:false,
          timer:3000,
          timerProgressBar:3000,
      })
         
      }
    },complete(){
      $("#borrar").prop("disabled", false);
    }
  })
}
})

}
})



$('#u1').addClass('active');
$('#u3').addClass('text-primary');
$('.u3').addClass('active');

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
