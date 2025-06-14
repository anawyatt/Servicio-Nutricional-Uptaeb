$(document).ready(function () {

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
    $(".accion").remove() 
    $(".accion").addClass('d-none');
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
            data: { mostrar: true },
            success(data) {
              $('#ani').show(2000);
                let lista = data;
                let tabla = "";
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
                    <td class="">${row.nombreModulo}</td>
                    `+ resultado +`
                    <td  class="text-center accion">
                    <a class="btn btn-sm btn-icon text-primary flex-end editar" data-bs-toggle="modal" data-bs-target="#ediatarModulos"data-bs-toggle="tooltip" title="Modificar Rol" href="#" id="${row.idModulo}" >
                                <span class="btn-inner pi">
                                  <i class="bi bi-pencil icon-24 t" width="20"></i>
                                </span>
                            </a>
                    </td>
                           
                </tr>
                    `;
                });
                $('#tbody_modulos').html(tabla);
                mostrar = $('.tabla').DataTable();

                mostrar.on('draw.dt', function () {
                    quitarBotones();
                   });
      
                  quitarBotones();
            }
        });
    }

$("#editar").on("click", function(e){ 
      
modificar();
})

$(document).ready(function() {
    $("#nombre_modulos_edit").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel'),
        selectionCssClass: "input",
        width:'100%'
    });
});





        let id;
    // SELECCIONA ITEM
    $(document).on('click', '.editar', function () {
        id = this.id;
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { select: true, id: id },
            success(data) {
                $("#nombre_modulos_edit").val(data[0].status);
                $('#idd').val(data[0].idModulo);
            }
        });
    });

 
    $(document).on('click', '.resetear', function () {
        id =$('#idd').val();
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { select: true, id: id },
            success(data) {
              primary2();
                $("#nombre_modulos_edit").val(data[0].status);
            }
        });
    });


      function modificar(){
        const nuevonombreModulo = $("#nombre_modulos_edit").val();
        
        $.ajax({
            type: "post",
            url: "", 
            dataType: 'json',
            data: {
                nombreEdit: nuevonombreModulo, 
                id: id
            },
            success(data) {
              $('#cerrar2').click();
                    delete mostrar;
                        rellenar();
                        Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon:'success',
                           title:'Módulo  Modificado Exitosamente!',
                           showConfirmButton:false,
                           timer:2500,
                           timerProgressBar:true,
                       })
            }
        });
   
      }

//------------ ELIMINAR AJAX----------------------------------------



})

$('#m1').addClass('active');