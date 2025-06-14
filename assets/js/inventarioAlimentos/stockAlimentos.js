
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
                let total = row.stock + row.reservado;

                if (row.unidadMedida === 'Unidad' && row.stock > 1) {
                    unidadMedida = row.unidadMedida + 'es';
                } else if (row.unidadMedida !== 'Unidad' && row.stock > 1) {
                    unidadMedida = row.unidadMedida + 's';
                } else {
                    unidadMedida = row.unidadMedida;
                }

                tabla += `
                    <tr>
                        <td class="text-center">${row.codigo}</td>
                        <td><img src="${row.imgAlimento}" width="70" height="70" alt="Profile" class="mb-2"></td>
                        <td>${row.nombre}</td>
                        <td>${row.marca}</td>
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

function exportarReporte(){
    let tipoA = $('#tipoA2').val();
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte:true, tipoA}, 
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
    templateResult: formatState,
    templateSelection: formatState
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
            