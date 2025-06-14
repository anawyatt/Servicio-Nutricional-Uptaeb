let permisos, modificarPermiso;
$.ajax({
    method: 'POST', url: "", dataType: 'json', data: { getPermisos: 'a' },
    success(data) { permisos = data; }
}).then(function () {
    modificarPermiso = (typeof permisos.modificar === 'undefined') ? 'disabled' : '';
    $('#enviar').attr(registrarPermiso, '');
});

function quitarBotones(){
  if (typeof permisos.modificar == 'undefined') {
       $("#actualiza").remove()   
  }
}

  $('#ani').hide(0);
  
    rellenarRoles();
    rellenarModulos();

    function rellenarRoles(){ 
        $.ajax({
            type: "post",
            url: "", 
            dataType: "json",
            data: {mostrar: "labs"},
            success(data){
                let tabla = "";
         
                data.forEach(row => {
                    tabla += `     
                            <td class="text-center title fw-bold" id="${row.idRol}">${row.nombreRol}</td>                      
                       `;
                });
           
                $('#thead #theadTR').html(' <th class="text-center title fw-bold">Módulos</th>'+ tabla);
                
             
            }
        });
    }

    function rellenarModulos(){ 
        console.log("rellenar modulos")
        $.ajax({
            type: "post",
            url: "", 
            dataType: "json",
            data: {mostrarr: "labss"},
            success(data){
                 $('#ani').show(2000);
                 let tabla = "";
                data.forEach(row => {
                    tabla += `    
                    
                    <tr id="cnt_${row.idModulo}" class="modulo_permiso">
                    <td class="modulo-nombre" id="modulo_${row.idModulo}">${row.nombreModulo}</td>   
                    </tr> 
                                    
                       `;
                });
                $('#tbody').html(tabla);
               
                data.forEach(row => {
                    rellenarModulosPermisos(row.idModulo);
                });
            }
        });
    }

    function rellenarModulosPermisos(idModulo) {
        let id = idModulo;
    
        $.ajax({
            method: "post",
            url: "",
            dataType: "json",
            data: { permisos: 'xd', id },
            success: function (data) {
                let rolSesion = $('#rol_session').text(); 
    
                let idSuperUserRole = data.find(item => item.nombreRol === 'super usuario' || item.nombreRol === 'Super Usuario')?.idRol;
    
                console.log(idSuperUserRole)
                let rolesUnicos = [...new Set(data.map(item => item.idRol))];
    
                let contenido = '';
                rolesUnicos.forEach(idRol => {
                    let permisosHTML = '';
    
                    let permisosRol = data.filter(item => item.idRol === idRol);
    
                    const permisosSVG = {
                        consultar: `<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 576 512"><path fill="#007aff" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></i>`,
                        registrar: `<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="#007aff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></i>`,
                        modificar: `<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512"><path fill="#007aff" d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg></i>`,
                        eliminar: `<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  viewBox="0 0 448 512"><path fill="#007aff" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg></i>`,
                        Exportar: `<i class="ri-arrow-up-line icon-24 text-primary"></i>`,
                        Importar: `<i class="ri-arrow-down-line icon-24 text-primary"></i>`,
                    };
    
                    const permisosText = {
                        consultar: `<span class="text-primary " style='font-size:12px!important;'>Consultar</span>`,
                        registrar: `<span class="text-primary " style='font-size:12px!important;'>Registrar</span>`,
                        modificar: `<span class="text-primary " style='font-size:12px!important;'>Modificar</span>`,
                        eliminar: `<span class="text-primary " style='font-size:12px!important;'>Eliminar</span>`,
                        Exportar: `<span class="text-primary " style='font-size:12px!important;'>Exportar</span>`,
                        Importar: `<span class="text-primary " style='font-size:12px!important;'>Importar</span>`,
                    };
    
                    permisosRol.forEach(row => {
                        let isChecked = row.status == 1 ? 'checked' : '';
                        let isSuperUser = (idRol === idSuperUserRole);
                        let isRolSesion = (row.nombreRol === rolSesion);

                        let svgIcon = permisosSVG[row.nombrePermiso];
                        let texts = permisosText[row.nombrePermiso];

                        let moduloHome= id === 1 && row.nombrePermiso ==='consultar' ;
                        let isDisabled = isSuperUser || isRolSesion || moduloHome ? 'disabled' : '';
    
                        permisosHTML += `
                            <!-- ${row.nombrePermiso} -->
                            <div class="d-flex  align-items-end gap-1">                             
                                <input class="${row.nombrePermiso}_${row.idModulo}${row.idRol} form-check-input  " type="checkbox" ${isChecked} id="${row.nombrePermiso}_${row.idPermiso}" ${isDisabled}>
                                ${svgIcon ? svgIcon : `<img width="16px" src="assets/images/${row.nombrePermiso}.png" alt="">`}
                                ${texts ? texts : `${row.nombrePermiso}`}
                            </div>
                        `;
                    });
                    let nombrePermiso = permisosRol.length > 0 ? permisosRol[0].nombrePermiso : 'Sin permisos';
                    contenido += `
                        <td rol="${idRol}" class="text-center   rolesss">
                            ${permisosHTML}
                        </td>
                    `;
                });
    
                $('#cnt_' + id + ' .modulo-nombre').after(contenido);
                $('.color').css('fill', '#3cbabf')
                quitarBotones();
            }
        });
    
    }
    
    
     //quitar
     setTimeout(function() {
        quitarBotones();
    }, 500); 
    

    $('#enviarPermisos').click(() => {
        let datos_permisos = [];
        let token = $('[name="csrf_token"]').val();
    
        $('.modulo_permiso').each(function () {
      
            $(this).find('input[type="checkbox"]').each(function () {
                let idPermiso = $(this).attr('id').split('_')[1];
                let status = $(this).prop('checked') ? '1' : '0';
    
                datos_permisos.push({
                    idPermiso,
                    status
                });
            });
        });

        if(token){
           console.log('Token CSRF:', token);
        $.ajax({
            method: 'POST',
            url: '',  
            data: {
                datos_permisos, csrfToken: token,
            },
            success: function (data) {
                 let response = typeof data === "string" ? JSON.parse(data) : data;
                if (response.error) {
                     Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon:'error',
                        title:'<span class=" text-rojo">Error al Guardar Permisos!</span>',
                        showConfirmButton:false,
                        timer:3000,
                        timerProgressBar:3000,
                    })
                } else if(response.newCsrfToken) {
                    console.log('Token CSRF actualizado:', response.newCsrfToken);
                    $('#cerrarM').click();
                     $('.resetear').click();
                    $('[name="csrf_token"]').val(response.newCsrfToken);
                     Swal.fire({
                         toast: true,
                         position: 'top-end',
                         icon:'success',
                         title:'<b class="text-primary fw-bold">Permisos</b> Actualizados Exitosamente!',
                         showConfirmButton:false,
                         timer:2500,
                         timerProgressBar:true,
                       })

                }
            }
        });
    }
    });

 $('#tbody').on('change', 'input[type="checkbox"]', function() {
    activo($(this)); 

    if (!$(this).is(':checked')) {
        validarDesactivar($(this)); 
    }
});

function validarDesactivar(checkbox) {
    const confirmText = 'Aceptar';
    const cancelText = 'Cancelar';

    Swal.fire({
        title: '¿Deseas desactivar este permiso?',
        icon: 'question',
        showCancelButton: true,
        width: '35%',
        cancelButtonText: cancelText,
        confirmButtonText: confirmText,
    }).then((result) => {
        if (!result.isConfirmed) {
            checkbox.prop('checked', true);
        }
    });
}

function activo(checkbox) {
    var clases = checkbox.attr('class').split(' '); 
    console.log(clases);
    var primeraClase = clases[0];  
    var numero = primeraClase.split('_')[1];
    
    var consultar = $('.consultar_' + numero);
    var modificar = $('.modificar_' + numero);
    var eliminar = $('.eliminar_' + numero);
    if (primeraClase.includes('consultar')) {
        if (!checkbox.is(':checked')) {
            modificar.prop('checked', false);
            eliminar.prop('checked', false);
        }
    } else if (primeraClase.includes('modificar') || primeraClase.includes('eliminar')) {
        if (checkbox.is(':checked')) {
            consultar.prop('checked', true);
        } 
    }
}



    $(document).on('click', '.limpiar', function() {
        rellenarModulos();
    })

    $('#p1').addClass('active');

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