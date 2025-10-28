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

    let form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; 

    let inputReporte = document.createElement('input');
    inputReporte.type = 'hidden';
    inputReporte.name = 'reporte'; 
    inputReporte.value = 'true';
    form.appendChild(inputReporte);
    
   
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    $('#clos').click();
}


$('#reportebtn').click(()=>{
    exportarReporte();
});

$('#iu1').addClass('active');
$('#iu3').addClass('active');
$('.iu3').addClass('active');
