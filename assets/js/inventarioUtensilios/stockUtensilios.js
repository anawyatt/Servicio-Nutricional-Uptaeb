    tablaUtensilios();
    let mostrarS;
    $('#ani').hide(1000);

    function tablaUtensilios() {
        $.ajax({
            method: "post",
            url: "", 
            dataType: "json",
            data: { mostrarS : true },
            success(data) {
                 $('#ani').show(2000);
                let lista = data;
                let tabla = "";
                lista.forEach(row => {        
                    tabla += `
                    <tr>
                    <td class=""><img src="${row.imgUtensilios}" width="70" height="70"alt="Profile" class=" mb-2"></td>
                    <td class="">${row.nombre}</td>
                    <td class="">${row.material}</td>
                    <td class="">${row.stock}</td>
                </tr>
                    `;
                });
                $('#tbody').html(tabla);
                mostrarS = $('.tabla').DataTable();
                
            }
        });
}

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

$('#iu1').addClass('active');
$('#iu3').addClass('active');
$('.iu3').addClass('active');
