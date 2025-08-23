    tablaAlimentos();
    let mostrarS;
    $('#ani').hide(1000);

    function tablaAlimentos() {
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { mostrarStock: true },
            success(data) {
                 $('#ani').show(2000);
                let lista = data;
                let tabla = "";
                lista.forEach(row => {
                     let unidadMedida;
                     let total = row.stock + row.reservado;
                    if (row.unidadMedida === 'Unidad' && row.stock > 1) {
                        unidadMedida = row.unidadMedida + 'es';
                     }
                     else{
                       unidadMedida = row.unidadMedida;
                     }
                     if (row.unidadMedida !== 'Unidad' && row.stock > 1) {
                        unidadMedida = row.unidadMedida + 's';
                     }
                    tabla += `
                    <tr>
                    <td class="text-center">${row.codigo}</td>
                    <td class=""><img src="${row.imgAlimento}" width="70" height="70"alt="Profile" class=" mb-2"></td>
                    <td class="">${row.nombre}</td>
                    <td class="">${row.marca}</td>
                    <td class="">${row.stock} ${unidadMedida}</td>
                    <td class="">${row.reservado} ${unidadMedida}</td>
                     <td class="">${total} ${unidadMedida}</td>
                    
                </tr>
                    `;
                });
                $('#tbody').html(tabla);
                mostrarS = $('.tabla').DataTable();
                
            }
        });
}


 ///-----------------------DESCARGAR PDF

function exportarReporte(){
  
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte:true}, 
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



$('#ia1').addClass('active');
$('#ia3').addClass('active');
$('.ia3').addClass('active')
            