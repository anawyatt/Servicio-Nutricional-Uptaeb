
 $('#exportBtn').click(function(){

    const confirmText = 'Aceptar';
    const cancelText = 'Cancelar';

    Swal.fire({
        title: '¿Deseas Exportar la Base de Datos?',
        icon: 'question',
        showCancelButton: true,
        width: '35%',
        cancelButtonText: cancelText,
        confirmButtonText: confirmText,
    }).then((result) => {
        if (result.isConfirmed) {
            exportarBD();
        }
    });

  
 });

$('#importBtn').click(function(){

  const confirmText = 'Aceptar';
    const cancelText = 'Cancelar';

    Swal.fire({
        title: '¿Deseas Importar la Base de Datos?',
        icon: 'question',
        showCancelButton: true,
        width: '35%',
        cancelButtonText: cancelText,
        confirmButtonText: confirmText,
    }).then((result) => {
        if (result.isConfirmed) {
           importarBD();
        }
    });

  
 });


function exportarBD(){
  $.ajax({
          type: "POST",
          url: '',
          dataType: 'json',
          data: {
              exportarBaseDatos:true
          },
          success: function (data) {
             
            if(data.resultado == 'exportación BD exitosa'){
              $('#msjEI').html(data.msj);
               Swal.fire({
                    toast: true,
                    position: 'center',
                    icon:'success',
                    title:'Exportación de la Base de Datos exitosa!',
                    showConfirmButton:false,
                    timer:2500,
                    timerProgressBar:true,
               })

            }
            else if(data.resultado == 'ERROR exportación BD'){
               Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<span class=" text-rojo">Error en la exportación de la Base de Datos!</span>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: 3000,
                width: '38%',
            });

            }
            console.log(data);
          }
      });
}

 function importarBD(){
  $.ajax({
          type: "POST",
          url: '',
          dataType: 'json',
          data: {
              importarBaseDatos:true
          },
          success: function (data) {

            if(data.resultado == 'importación BD exitosa'){
              $('#msjEI').html(data.msj);
               Swal.fire({
                    toast: true,
                    position: 'center',
                    icon:'success',
                    title:'Importación de la Base de Datos exitosa!',
                    showConfirmButton:false,
                    timer:2500,
                    timerProgressBar:true,
               }) 
               setTimeout(function () {
                location.reload(true);
               }, 2000);
            }
             else if(data.resultado == 'No existe el archivo'){
               Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<span class=" text-rojo">No existe el archivo para la importación!</span>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: 3000,
                width: '38%',
            });
          }
        }
      });
}

mensaje();
function mensaje(){
  $.ajax({
      type: "POST",
      url: '',
      dataType: 'json',
      data: { mensaje: true },
      success: function (data) {
          console.log(data);
          if(data.length > 0){
              $('#msjEI').html(data[0].acciones);
          } 
      }
  });
}
