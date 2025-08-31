$(document).ready(function () {

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
    $(".agrega").remove()   
    }
    
    if (typeof permisos.modificar == 'undefined') {
    console.log(permisos)
    $(".editar").remove()   
    }
    
    if (typeof permisos.eliminar == 'undefined') {
    console.log(permisos)
    $(".borrar").remove()   
    }
    if (typeof permisos.eliminar == 'undefined' && typeof permisos.modificar == 'undefined' ) {
    console.log(permisos)
    $(".accion").remove()  
    }
    }


    /* --- FUNCIÓN PARA RELLENAR LA TABLA --- */
$('#ani').hide(1000);
    rellenar();
    let mostrar='';
   function rellenar() {
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { muestra: true },
        success(data) {
            $('#ani').show(2000);
            let lista = data;
            let tabla = "";
            lista.forEach(row => {
                tabla += `
                <tr>
                    <td class="">${row.nombreRol}</td>
                    <td class="text-center accion">
                        <a class="btn btn-sm btn-icon text-primary editar editar-rol" data-bs-toggle="tooltip" title="Modificar Rol" href="#" id="${row.idRol}">
                            <span class="btn-inner pi">
                                <i class="bi bi-pencil icon-24 t" width="20"></i>
                            </span>
                        </a>
                        <a class="btn btn-sm btn-icon text-danger borrar" data-bs-toggle="tooltip" title="Eliminar Rol" href="#" type="button"  id="${row.idRol}">
                            <span class="btn-inner pi">
                                <i class="bi bi-trash icon-24 t" width="20"></i>
                            </span>
                        </a>
                    </td>
                </tr>`;
            });

             if ($.fn.DataTable.isDataTable('.tabla2')) {
                  $('.tabla2').DataTable().clear().destroy();
             }

            $('.tbody').html(tabla);
             mostrar = $('.tabla2').DataTable({
                destroy: true
             });
             
             mostrar.on('draw.dt', function () {
                    quitarBotones();
                   });
      
                  quitarBotones();
        }
    });
}


    //quitar
    setTimeout(function() {
        quitarBotones();
    }, 500); 
    
//----------------------- VALIDAR REGISTRAR -----------------------------------
let error_rol= false;
let error_val =false;
let timer;
$("#error1").hide();

      $("#rol").focusout(function(){
         val_rol();
      });

      $("#rol").on('keyup', function() {
         val_rol();
         clearTimeout(timer); 
         timer = setTimeout(function () {
           validar_roles();
         }, 500);
      });

       $("#registrar").on("click", function(e){ 
        error_rol= false;
        error_val=false;
        validar_roles();
        val_rol();

        if (error_rol == false && error_val === false) {
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
              $('.rol').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
         }

       function primary(){
             $(".error1").html("");
             $(".error1").hide();
             $('.rol').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
              ocultarSpinner();
       }

      function val_rol() {
          var chequeo = /^[a-zA-ZÀ-ÿ\s\-\_]{3,}$/;
          var nombre = $("#rol").val();
          if (chequeo.test(nombre) && nombre !== '') {
            primary();
          } else {
              danger()
              $(".error1").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el rol, solo Caracteres!');
             error_rol = true;
          }
      }

      function validar_roles(){
      const rol = $("#rol").val();
       $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{rol},
         success(data){
                 if (data.resultado == 'error2') {
                    ocultarSpinner();
                     Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'error',
                           title:'El Rol <b class="fw-bold text-rojo">'+rol+'</b> ya esta registrado, ingrese otro rol!',
                           showConfirmButton:false,
                           timer:3000,
                           timerProgressBar:3000,
                        })
                     danger();
                     $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El rol ya existe!');
                      
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

    function capitalizarYEliminarEspaciosExtras(texto) {
        const palabras = texto.split(" ");
        let palabrasFormateadas = [];
    
        // Recorrer las palabras
        for (let i = 0; i < palabras.length; i++) {
            if (palabras[i].trim() !== "") {
                palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
            }
        }
        return palabrasFormateadas.join(" ");
    }

    // REGISTRAR

    function registrar() {
        const rol = capitalizarYEliminarEspaciosExtras($("#rol").val());
        let token = $('[name="csrf_token"]').val();

        $("#registrar").prop("disabled", true);

        if(token){
         mostrarSpinner();
         console.log(token);
        $.ajax({
            type: "post",
            dataType: 'JSON',
            url: "",
            data: { registrar:true, rol: rol, csrfToken: token },
            success(data) {
                if (data.mensaje.resultado == 'exitoso' && data.newCsrfToken){
                     console.log(data);
                    $('.limpiar').click();
                    $('#cerrar').click();
                    $('[name="csrf_token"]').val(data.newCsrfToken);
                    primary();
                    delete mostrar;
                    rellenar();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon:'success',
                        title:'El Rol <b class="text-primary fw-bold">'+rol+'</b> Registrado Exitosamente!',
                        showConfirmButton:false,
                        timer:2500,
                        timerProgressBar:true,
                    });
                }
            },
            complete() {
              
                ocultarSpinner();
                $("#registrar").prop("disabled", false);
            }
        });
        }
    }
    
    function mostrarSpinner() {
      
        $('#spinner').addClass('d-flex justify-content-center align-items-center').show();
    }
    
    function ocultarSpinner() {
 
        $('#spinner').removeClass('d-flex justify-content-center align-items-center').hide();
    }
    
//----------------------- VALIDAR Modificar -----------------------------------
let error_rol2= false;
$("#error2").hide();

      $("#rol2").focusout(function(){
         val_rol2();
      });

      $("#rol2").on('keyup', function() {
         val_rol2();
         clearTimeout(timer); 
         timer = setTimeout(function () {
           validar_roles2();
         }, 500);
      });

       $("#editar").on("click", function(e){ 
        error_rol2= false;
        val_rol2();

        if (error_rol2 == false) {
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
        function danger1(){
             $(".error2").show();
             $('.rol2').addClass('errorBorder');
             $('.bar2').removeClass('bar');
             $('.ic2').addClass('l');
             $('.ic2').removeClass('labelPri');
             $('.letra2').addClass('labelE');
             $('.letra2').removeClass('label-char');
       }

       function primary2(){
              $(".error2").html("");
              $(".error2").hide();
              $('.rol2').removeClass('errorBorder');
              $('.bar2').addClass('bar');
              $('.ic2').removeClass('l');
              $('.ic2').addClass('labelPri');
              $('.letra2').removeClass('labelE');
              $('.letra2').addClass('label-char');
       }

      function val_rol2() {
          var chequeo = /^[a-zA-ZÀ-ÿ\s\-\_]{3,}$/;
          var nombre = $("#rol2").val();
          if (chequeo.test(nombre) && nombre !== '') {
            primary2()
          } else {
             $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el rol, solo Caracteres!');
             danger1()
             error_rol2 = true;
          }
      }


        let id;
    // SELECCIONA ITEM
    $(document).on('click', '.editar', function () {
        id = this.id;
        valModificar(id);
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { info: true, id: id },
                success(data) {
                    $('#ediatarModulos').modal('show');
                    $(".rol2").val(data[0].nombreRol);
                    $('#idd').val(data[0].idRol);
                }
            });
    });
    
    
    function valModificar(a) {
        id = a;
        console.log(id);
        $.ajax({
            url: "",
            dataType: 'json',
            method: "POST",
            data: {modificar: 'modificar', id},
            success(data) {
                if (data.resultado === "no se puede") {
                    $('#ediatarModulos').modal('hide');
                    $('#cerrar2').click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">El rol ya está registrado en las cuentas de los usuarios.`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                }
            }
        });
    }


    $(document).on('click', '.resetear', function () {
        id =$('#idd').val();
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { info: true, id: id },
            success(data) {
              primary2();
                $(".rol2").val(data[0].nombreRol);
            }
        });
    });

    function validar_roles2(){
      const rol2 = $("#rol2").val();
       $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{rol2, id},
         success(data){
                 if (data.resultado == 'errorRol') {
                     danger1();
                     $('.error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El rol ya existe!');
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'error',
                           title:'El rol <b class="fw-bold text-rojo">'+rol2+'</b> ya esta registrado, ingrese otro rol!',
                           showConfirmButton:false,
                           timer:3000,
                           timerProgressBar:3000,
                        })
                    }
                   else{
                   primary2();
                   }

            }
       })
    }

      function modificar(){
         const rol2 = capitalizarYEliminarEspaciosExtras($("#rol2").val());
         let token = $('[name="csrf_token"]').val();
         if(token){
            console.log(token);
        $.ajax({
            type: "post",
            url: "", 
            dataType: 'json',
            data: {
                rol2, id, csrfToken: token
            },
            success(data) {
              if (data.resultado === 'ya no existe') {
                $('#cerrar2').click();
                 delete mostrar;
                 rellenar();
                 Swal.fire({
                       toast: true,
                       position: 'top-end',
                       icon:'error',
                       title:'<span class=" text-rojo">El rol fue eliminado recientemente!</span>',
                       showConfirmButton:false,
                       timer:3000,
                       timerProgressBar:3000,
                 })
              }
              else{
                   if (data.resultado == 'errorRol') {
                     danger1();
                     $('.error2').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El rol ya existe!');
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'error',
                           title:'El rol <b class="fw-bold text-rojo">'+rol2+'</b> ya esta registrado, ingrese otro rol!',
                           showConfirmButton:false,
                           timer:3000,
                           timerProgressBar:3000,
                        })
                    } else if(data.mensaje.resultado == 'Rol actualizado exitosamente' && data.newCsrfToken) {
                          console.log(data);
                          $('[name="csrf_token"]').val(data.newCsrfToken);
                       $('#cerrar2').click();
                       primary2();
                       delete mostrar;
                        rellenar();
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'success',
                           title:'El rol <b class="text-primary fw-bold">'+rol2+'</b> Modificado Exitosamente!',
                           showConfirmButton:false,
                           timer:2500,
                           timerProgressBar:true,
                       })
                    }
                     else if(data.mensaje.resultado == 'no hubo cambios' && data.newCsrfToken) {
                          console.log(data);
                          $('[name="csrf_token"]').val(data.newCsrfToken);
                       $('#cerrar2').click();
                       primary2();
                       delete mostrar;
                        rellenar();
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'warning',
                           title:'No hubo cambios en el rol <b class="text-primary fw-bold">'+rol2+'</b>!',
                           showConfirmButton:false,
                           timer:2500,
                           timerProgressBar:true,
                       })
                    }

              }
            }
        });
    }
}

//------------ ELIMINAR AJAX----------------------------------------

$(document).on('click', '.borrar', function() {
    id = this.id;
     
    let nombreRol = $(this).closest('tr').find('td:first').text();
    let rolActual = $("#rol_session").text();
    console.log("nombreRol:", nombreRol);
    console.log("rolActual:", rolActual);

    if (nombreRol == 'super usuario' || nombreRol == 'Super Usuario') {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'No se puede eliminar el rol <b class="fw-bold text-rojo">Super Usuario</b> !',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
        });
    } else if(nombreRol == rolActual){
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'No tienes permiso para eliminar el rol con el que la sesión está abierta!',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
        }); 
    }
    else {
       mostrarModalR(id)
       
    }
});


function mostrarModalR(b) {
    id = b;
    verificarRolUsuario(id) 
            $.ajax({
                url: "",
                dataType: 'json',
                method: "POST",
                data: { info: true, id: id },
                success(data) {
                    $('.eliminarR').html('¿Deseas Eliminar el rol <b class="text-primary">' + data[0].nombreRol + '</b> ?');
                }
            });
}

function verificarRolUsuario(id) {
    $.ajax({
        url: "",
        dataType: 'json',
        method: "POST",
        data: { verificarRolUsuario: true, id: id },
        success(data) {
            if (data.resultado === 'usuarios_asociados') {
                $('#borrarModulos').modal('hide');
                $('#cerrar3').click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '<span class="text-rojo">No puede eliminar este rol, tiene usuarios asociados</span>',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: 3000,
                });
               
            } else if (data.resultado === 'se puede') {
                $('#borrarModulos').modal('show');
            }
        }
    });
}



  $('#borrar').click((e)=>{
    e.preventDefault();
    let token = $('[name="csrf_token"]').val();
   if(token){
    console.log(token);
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{eliminar: 'borrar', id, csrfToken: token},
      success(data){
        console.log(data);
        if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete mostrar;
         rellenar();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">El rol fue eliminado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
       
        }else if(data.mensaje.resultado === 'anulado correctamente.' && data.newCsrfToken) {
        console.log(data);
            $('[name="csrf_token"]').val(data.newCsrfToken);
        $('#cerrar3').click();
         delete mostrar;
         rellenar();
          Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Rol Eliminado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
      }
    }
  })
   }
    })

})



$('#r1').addClass('active');

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