
    let mostrarS;
    $('#ani').hide(1000);
    

   function tablaAlimentos() {
    let tipoA = $('#tipoA2').val();

    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { mostrarAlimentos: true, tipoA },
        success(data) {
            $('#ani').show(2000);

            let lista = data;
            let tabla = "";

            lista.forEach(row => {
                let unidadMedida;
                let contNeto;
                let total = row.stock + row.reservado;

                if (row.marca === 'Sin Marca') {
                  contNeto = '';
                if (row.unidadMedida === 'Unidad' && row.stock > 1) {
                   unidadMedida = row.unidadMedida + 'es';
                } else {
                   unidadMedida = row.unidadMedida;
                }
                } else {
                 contNeto = row.unidadMedida;
                 unidadMedida = 'Unidad';
                  if(  row.stock > 1) {
                   unidadMedida = 'Unidades';
                  }
                }
                  


                tabla += `
                    <tr>
                        <td>${row.tipo}</td>
                        <td class="text-center">${row.codigo}</td>
                        <td><img src="${row.imgAlimento}" width="70" height="70" alt="Profile" class="mb-2"></td>
                        <td>${row.nombre}</td>
                        <td>${row.marca}</td>
                        <td>${contNeto}</td>
                        <td>${row.stock} ${unidadMedida}</td>
                        <td>${row.reservado} ${unidadMedida}</td>
                        <td>${total} ${unidadMedida}</td>
                    </tr>
                `;
            });
            if ($.fn.DataTable.isDataTable('.tabla')) {
                $('.tabla').DataTable().clear().destroy();
            }

            $('#tbody').html(tabla);
            $('.tabla').DataTable();
        }
    });
}

 ///-----------------------DESCARGAR PDF
$('#reportebtn').click(()=>{
    $('.loadingAnimation').show(); 
    exportarReporte();
    setTimeout(() => {
         $('.loadingAnimation').hide(); 
    }, 3000); 
})

function exportarReporte(){
    let tipoA = $('#tipoA2').val();
    
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; 
    
    let inputReporte = document.createElement('input');
    inputReporte.type = 'hidden';
    inputReporte.name = 'reporte'; 
    inputReporte.value = 'true';
    form.appendChild(inputReporte);
    
    let inputTipoA = document.createElement('input');
    inputTipoA.type = 'hidden';
    inputTipoA.name = 'tipoA';
    inputTipoA.value = tipoA;
    form.appendChild(inputTipoA);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form); 

    $('#clos').click();
}

//---------------------------- FILTRO DE BUSQUEDA ---------------------------

// -------------- FILTRO DE BUSQUEDA


$('#tipoA2').on('change', function() { 
   verificarTipoA();
   tablaAlimentos();
 })

 $(document).ready(function() {
  $("#tipoA2").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel'),
    selectionCssClass: "input",
    width: '100%',
  });
});

///-------------------------- VERIFICAR LA EXISTENCIA DEL TIPO DE ALIMENTO -------------\

          function verificarTipoA(){
               
                 let tipoA = $("#tipoA2").val();
                 if (tipoA != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida:'si', tipoA},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete selectA;
                                mostrarTipoA2();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El tipo de alimento  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                          	}
                            
                            }
                          })
                        }
                  
  
                }

////---------------------------MOSTRAR SELECT TIPO DE ALIMENTOS -------------------------------
mostrarTipoA2();
let selectA;
selectA=$('#tipoA2');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoA2(){
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
       $('#tipoA2').html(input + opE);
     }
   })
 }

$(document).ready(function () {
  // Ocultar por defecto si el checkbox no está marcado
  if (!$('.activarFiltro').is(':checked')) {
      $('.buscar').hide();
      tablaAlimentos();
  }
  // Manejar cambios en el checkbox
  $('.activarFiltro').change(function () {
      if ($(this).is(':checked')) {
          $('.buscar').show();
      } else {
          $('.buscar').hide();
          $('#tipoA2').val('Seleccionar').trigger('change.select2');
        tablaAlimentos();
      }
  });

});

$('#ia1').addClass('active');
$('#ia3').addClass('active');
$('.ia3').addClass('active')
            