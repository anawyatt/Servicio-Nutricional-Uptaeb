

$("#cambiar").on('click', function() {
      cambiar();
})

$(document).ready(function() {
    $("#Chorario").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel1'),
        selectionCssClass: "input",
        width:'100%'
    });
});


mostrar();

function mostrar(){

     $.ajax({
          type: "post",
          url: '',
          dataType: 'json',
          data: {
              mostrarHorariosComida:true
          },
          success: function (data) {
             $('#Chorario').val(data.horario).trigger('change');
          }
      });
}


function cambiar(){
    let horariosC =$('#Chorario').val();

     $.ajax({
          type: "post",
          url: '',
          dataType: 'json',
          data: {
              ingresarSistem:true, horariosC
          },
          success: function (data) {
              if (data.resultado == 'success' && data.url) {
                  location = data.url;
              }

        
          }
      });
}