
$('.cardi, .grafis, .AEcard,.MEcard, .Acard, .Ucard, .graf').hide();

// -------------------------- validar los cards ---------------------------------

$('#reporteEstudiante').on('click', function() {
  verificarEA();
  $('#grafos').removeClass('grafos');
  $('#grafos').addClass('grafis');
})

$('#reporteMenuEvento').on('click', function() {
  verificarME();
  $('#grafos').removeClass('grafos');
  $('#grafos').addClass('grafis');
})

$('#reporteAlimento').on('click', function() {
  verificarIA();
  $('#grafos').removeClass('grafos');
  $('#grafos').addClass('grafis');
})

$('#reporteUtensilio').on('click', function() {
  verificarIU();
  $('#grafos').removeClass('grafos');
  $('#grafos').addClass('grafis');
})

function verificarEA(){
  $.ajax({
    type: "POST",
    url: '',
    dataType: "json",
    data:{ verificarEA:true},
    success(data){
      if (data.resultado === 'no existe') {
        $('.cardi, .grafis, .AEcard,.MEcard, .Acard, .Ucard, .graf').hide(1000)
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'<b class="text-rojo">No hay Asistencias!</b>',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
          })
      }
      else if (data.resultado === 'existe'){
        $('.graf, .MEcard, .Acard, .Ucard, #sel0, #graf1, #graf2, #graf3, #graf4, #graf5, #graf6, #botonB').hide(1000)
        $('.cardi, .AEcard, .grafis').show(1200);
        $('#fil').addClass('d-none');
        $('#asisEstu, #selectFecha').val('Seleccionar').trigger('change.select2');
      }
      }
    })
}

function verificarME(){
  $.ajax({
    type: "POST",
    url: '',
    dataType: "json",
    data:{ verificarME:true},
    success(data){
      if (data.resultado === 'no existe menu' && data.resultado === 'no existe evento') {
        $('.cardi, .grafis, .AEcard,.MEcard, .Acard, .Ucard, .graf').hide(1000)
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'<b class="text-rojo">No hay Menus ni Eventos!</b>',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
          })
      }
      else if (data.resultado === 'existe menu' || data.resultado === 'existe evento'){
        $('.graf, .AEcard, .Acard, .Ucard, #sel0, #graf1, #graf2, #graf3, #graf4, #graf5, #graf6, #botonB').hide(1000);
        $('.cardi, .MEcard,.grafis').show(1200);
        $('#fil').addClass('d-none');
        $('#menuEvent, #selectFecha').val('Seleccionar').trigger('change.select2');
        
        }
      }
      
      
    })
}

function verificarIA(){
  $.ajax({
    type: "POST",
    url: '',
    dataType: "json",
    data:{ verificarIA:true},
    success(data){
      if (data.resultado === 'no existe entrada') {
        $('.cardi, .grafis, .AEcard,.MEcard, .Acard, .Ucard, .graf').hide(1000);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'<b class="text-rojo">No hay Inventario de Alimentos!</b>',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
          })
      }
      else if (data.resultado === 'existe entrada' || data.resultado === 'existe salida' ){
        $('.graf, .MEcard, .AEcard, .Ucard, #sel0, #graf1, #graf2, #graf3, #graf4, #graf5, #graf6, #botonB').hide(1000)
        $('.cardi, .Acard, .grafis').show(1200)
        $('#fil').addClass('d-none');
        $('#alimento, #selectFecha').val('Seleccionar').trigger('change.select2');
      }
      }
    })
}

function verificarIU(){
  $.ajax({
    type: "POST",
    url: '',
    dataType: "json",
    data:{ verificarIU:true},
    success(data){
      if (data.resultado === 'no existe entrada') {
        $('.cardi, .grafis, .AEcard,.MEcard, .Acard, .Ucard, .graf').hide(1000);
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon:'error',
            title:'<b class="text-rojo">No hay Inventario de Utensilios!</b>',
            showConfirmButton:false,
            timer:3000,
            timerProgressBar:3000,
          })
      }
      else if (data.resultado === 'existe entrada' || data.resultado === 'existe salida' ){
        $('.graf, .MEcard, .Acard, .AEcard, #sel0, #graf1, #graf2, #graf3, #graf4, #graf5, #graf6, #botonB').hide(1000)
        $('.cardi, .Ucard, .grafis').show(1200)
        $('#fil').addClass('d-none');
        $('#utensilio, #selectFecha').val('Seleccionar').trigger('change.select2');
      }
      }
    })
}

//--------------------- Agregar el select 2 -----------------------------------------


$(document).ready(function() {
  $("#asisEstu").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel'),
      selectionCssClass: "input",
      width:'100%'
  });

  $("#menuEvent").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel2'),
      selectionCssClass: "input",
      width:'100%'
  });

  $("#alimento").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel3'),
      selectionCssClass: "input",
      width:'100%'
  });

  $("#utensilio").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel4'),
      selectionCssClass: "input",
      width:'100%'
  });

  $("#selectFecha").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel0'),
      selectionCssClass: "input",
      width:'100%'
  });

});

//------------------------------ BUSCAR POR FILTROS ------------
$('.fecha').change(function() {
  if($('.fecha').val()=='Seleccionar'){
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
  }
 
  $('.graf').hide(1000);
});


//----------------------- Agregar las funciones de los reportes a las opciones de los selects ------------

$('#asisEstu').on('change', function() {
  $('.graf').hide(1000)
  $('#selectFecha').val('Seleccionar').trigger('change.select2');
  if ($('#asisEstu').val() == 1) {
     asistenciasEstudiantes();
     mostrarFechasAsistencias()
   
  }
  else if ($('#asisEstu').val() == 2) {
    asistenciasEstudiantesSexo()
    mostrarFechasAsistencias()
  }
  else if ($('#asisEstu').val() == 3) {
   asistenciasEstudiantesNucleo()
   mostrarFechasAsistencias()
  }
  else if ($('#asisEstu').val() == 4) {
    asistenciasEstudiantesPNF()
    mostrarFechasAsistencias()
  }
  else if ($('#asisEstu').val() == 5) {
    asistenciasEstudiantesJustificativo()
    mostrarFechasAsistenciasJustificados()
  }
  else{
    $('.graf').hide(1000)
    $('#fil').addClass('d-none');
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
  }

})

$('#menuEvent').on('change', function() {
  $('.graf').hide(1000)
  $('#selectFecha').val('Seleccionar').trigger('change.select2');
  if ($('#menuEvent').val() == 1) {
    menus()
    mostrarFechasMenus()
  }
  else if ($('#menuEvent').val() == 2) {
    eventos()
    mostrarFechasEventos()
  }
  else if ($('#menuEvent').val() == 3) {
    cantidadMenuActivos()
    mostrarFechasMenus()
  }
  else if ($('#menuEvent').val() == 4) {
    alimentosMasUtilizados()
    mostrarFechasMenus()
  }
  else if ($('#menuEvent').val() == 5) {
    eventosConMayorAlimentos()
    mostrarFechasEventos()
  }
  else{
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
   $('.graf').hide(1000)
    $('#fil').addClass('d-none');
   }
})

$('#alimento').on('change', function() {
  $('.graf').hide(1000)
  $('#selectFecha').val('Seleccionar').trigger('change.select2');
  if ($('#alimento').val() == 1) {
    entradaAlimentos();
    mostrarFechasEntradaAlimentos()
  }
  else if ($('#alimento').val() == 2) {
    alimentosMasIngresados()
    mostrarFechasEntradaAlimentos()
    
  }
  else if ($('#alimento').val() == 3) {
    salidaAlimentosMenu();
    mostrarFechasSalidaAlimentos()
    
  }
  else if ($('#alimento').val() == 4) {
    salidaAlimentosMerma();
    mostrarFechasSalidaAlimentos()
  }
  else{
    $('.graf').hide(1000)
    $('#fil').addClass('d-none');
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
    
  }

});

$('#utensilio').on('change', function() {
  $('.graf').hide(1000)
  $('#selectFecha').val('Seleccionar').trigger('change.select2');
  if ($('#utensilio').val() == 1) {
    entradaUtensilios();
    mostrarFechasEntradaUtensilios()
  }
  else if ($('#utensilio').val() == 2) {
    utensiliosMasIngresados();
    mostrarFechasEntradaUtensilios()
  }
  else if ($('#utensilio').val() == 3) {
    salidaUtensilios();
    mostrarFechasSalidaUtensilios()
  }
  else{
     $('.graf').hide(1000)
    $('#fil').addClass('d-none');
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
  }

});

$('#selectFecha').on('change', function() {
    $('#grafos').removeClass('grafos');
    $('#grafos').addClass('grafis');
});


//--------- control del filtrado de fecha

$('#sel0').hide(0);
$('#botonB').hide(0);
$('#cbx').change(function() {
   if ($(this).is(':checked')) {
       $('#sel0').show(1000);
       $('#botonB').show(1000);
   } else {
      $('.graf').hide(1000)
      $('#selectFecha, #asisEstu, #utensilio, #alimento, #menuEvent').val('Seleccionar').trigger('change.select2');
      $('#sel0').hide(1000);
      $('#botonB').hide(1000);
      $('#grafos').removeClass('grafos');
      $('#grafos').addClass('grafis');
   }
});


$('#botonB').on('click', function() {
  if ($('#asisEstu').val() == 1) {
    asistenciasEstudiantes();
  }
  else if ($('#asisEstu').val() == 2) {
    asistenciasEstudiantesSexo()
  }
  else if ($('#asisEstu').val() == 3) {
   asistenciasEstudiantesNucleo()
  }
  else if ($('#asisEstu').val() == 4) {
    asistenciasEstudiantesPNF()
  }
  else if ($('#asisEstu').val() == 5) {
    asistenciasEstudiantesJustificativo()
  }
  else if ($('#menuEvent').val() == 1) {
    menus()
  }
  else if ($('#menuEvent').val() == 2) {
    eventos()
  }
  else if ($('#menuEvent').val() == 3) {
    cantidadMenuActivos()
  }
  else if ($('#menuEvent').val() == 4) {
    alimentosMasUtilizados()
  }
  else if ($('#menuEvent').val() == 5) {
    eventosConMayorAlimentos()
  }
  else if ($('#alimento').val() == 1) {
    entradaAlimentos();
  }
  else if ($('#alimento').val() == 2) {
    alimentosMasIngresados()
  }
  else if ($('#alimento').val() == 3) {
    salidaAlimentosMenu();
  }
  else if ($('#alimento').val() == 4) {
    salidaAlimentosMerma();
  }
  else if ($('#utensilio').val() == 1) {
    entradaUtensilios();
  }
  else if ($('#utensilio').val() == 2) {
    utensiliosMasIngresados();
  }
  else if ($('#utensilio').val() == 3) {
    salidaUtensilios();
  }
})
 





// --------------------- LLENAR SELECTS -------------------
let select;
select=$('#selectFecha');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarFechasAsistencias(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select1A: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  function mostrarFechasAsistenciasJustificados(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select1AJ: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  function mostrarFechasMenus(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select2M: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.feMenu);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.feMenu}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  function mostrarFechasEventos(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select2E: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.feMenu);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.feMenu}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }


 function mostrarFechasEntradaAlimentos(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select3EA: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  function mostrarFechasSalidaAlimentos(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select3SA: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }



  function mostrarFechasEntradaUtensilios(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select4EU: 'mostrar'}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  function mostrarFechasSalidaUtensilios(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select4SU: 'mostrar'}, 
      success(response){
        let opE = '';
        response.forEach(fila => {
                 let fecha = new Date(fila.fecha);
                 let dia = (fecha.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fecha.getFullYear();

                 let fechaFormateada = `${dia}-${mes}-${anio}`;

          opE += `<option  value="${fila.fecha}">${fechaFormateada} </option> `
        })
        $('#selectFecha').html(input + opE);
      }
    })
  }

  //------------------------------ REPORTES -------------------------------------------

  // --------------------- asistencias y estudiantes -------------

  function asistenciasEstudiantes(){
    let fecha = $('#selectFecha').val();
  
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {reporteAsistenciasEstudiantes: true, fecha}, 
        success(response){
  
              var nombre= [];
              var cantidad =[];
  
                  if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                 $('#fil').removeClass('d-none');
  
                 response.forEach(fila => {
                if (fila.cantidad != 0) {
                   nombre.push(fila.nombre);
                   cantidad.push(fila.cantidad);
                 }
  
                });
  
                  $('#grafico1').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf1').show(1500)
                    $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                    graficoBarra(nombre,'N° de Asistencias', cantidad, '','#graf1')
                    }
                  })
                  $('#grafico2').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf2').show(1500)
                    $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                    graficoPastel(nombre, cantidad,'#graf2')
                    }
                  })
                  $('#grafico3').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf3').show(1500)
                    $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                    graficoDonut(nombre,cantidad, '#graf3')
                    }
                  })
                  $('#grafico4').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf4').show(1500)
                    $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                    graficoLineas(nombre, cantidad, '', '#graf4')
                    }
                  })
                  $('#grafico5').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(nombre, cantidad, '', '#graf5')
                    }
                  })
                  $('#grafico6').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf6').show(1500)
                    $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                    graficoRadar(nombre, cantidad, '', '#graf6')
                    }
                  })
            }
              else{
                 $('#grafos').removeClass('grafos');
                 $('#grafos').addClass('grafis');
                 $('#fil').addClass('d-none');
                 $('#sel0, #botonB').hide(0);
                 Swal.fire({
                   toast: true,
                   position: 'top-end',
                   icon:'error',
                   title:'No hay <b class="text-rojo fw-bold"> Asistencias</b> registradas!',
                   showConfirmButton:false,
                   timer:2500,
                   timerProgressBar:true,
                })
              }
  
              
          }
         });
  
  }

  
  function asistenciasEstudiantesSexo(){
   let fecha = $('#selectFecha').val();
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {reporteAsistenciasPorSexo: true, fecha}, 
        success(response){
  
              var nombre= [];
              var cantidad =[];
  
                  if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                 $('#fil').removeClass('d-none');
  
                 response.forEach(fila => {
                if (fila.cantidad != 0) {
                   nombre.push(fila.nombre);
                   cantidad.push(fila.cantidad);
                 }
  
                });
  
                   $('#grafico1').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf1').show(1500)
                    $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                    graficoBarra(nombre,'N° de Asistencias', cantidad, '','#graf1')
                    }
                  })
                  $('#grafico2').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf2').show(1500)
                    $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                    graficoPastel(nombre, cantidad,'#graf2')
                    }
                  })
                  $('#grafico3').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf3').show(1500)
                    $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                    graficoDonut(nombre,cantidad, '#graf3')
                    }
                  })
                  $('#grafico4').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf4').show(1500)
                    $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                    graficoLineas(nombre, cantidad, '', '#graf4')
                    }
                  })
                  $('#grafico5').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(nombre, cantidad, '', '#graf5')
                    }
                  })
                  $('#grafico6').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf6').show(1500)
                    $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                    graficoRadar(nombre, cantidad, '', '#graf6')
                    }
                  })
            }
              else{
                $('#grafos').removeClass('grafos');
                $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                $('#sel0, #botonB').hide(0);
              Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'error',
               title:'No hay <b class="text-rojo fw-bold"> Asistencias</b> registradas!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
              }
  
              
          }
         });
  
  }
  
  function asistenciasEstudiantesNucleo(){
     let fecha = $('#selectFecha').val();
     $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {reporteAsistenciasPorNucleo: true, fecha}, 
        success(response){
  
              var nombre= [];
              var cantidad =[];
  
                  if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                 $('#fil').removeClass('d-none');
  
                 response.forEach(fila => {
                if (fila.cantidad != 0) {
                   nombre.push(fila.nombre);
                   cantidad.push(fila.cantidad);
                 }
  
                });
  
                   $('#grafico1').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf1').show(1500)
                    $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                    graficoBarra(nombre,'N° de Asistencias', cantidad, '','#graf1')
                    }
                  })
                  $('#grafico2').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf2').show(1500)
                    $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                    graficoPastel(nombre, cantidad,'#graf2')
                    }
                  })
                  $('#grafico3').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf3').show(1500)
                    $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                    graficoDonut(nombre,cantidad, '#graf3')
                    }
                  })
                  $('#grafico4').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf4').show(1500)
                    $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                    graficoLineas(nombre, cantidad, '', '#graf4')
                    }
                  })
                  $('#grafico5').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(nombre, cantidad, '', '#graf5')
                    }
                  })
                  $('#grafico6').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf6').show(1500)
                    $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                    graficoRadar(nombre, cantidad, '', '#graf6')
                    }
                  })
            }
              else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
                    Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'error',
               title:'No hay <b class="text-rojo fw-bold"> Asistencias</b> registradas!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
              }
  
              
          }
         });
  
  }
  
  function asistenciasEstudiantesPNF(){
    let fecha = $('#selectFecha').val();
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {reporteAsistenciasPorPNF: true, fecha}, 
        success(response){
  
              var nombre= [];
              var cantidad =[];
  
                  if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                  $('#fil').removeClass('d-none');
  
                 response.forEach(fila => {
                if (fila.cantidad != 0) {
                   nombre.push(fila.nombre);
                   cantidad.push(fila.cantidad);
                 }
  
                });
  
                   $('#grafico1').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf1').show(1500)
                    $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                    graficoBarra(nombre,'N° de Asistencias', cantidad, '','#graf1')
                    }
                  })
                  $('#grafico2').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf2').show(1500)
                    $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                    graficoPastel(nombre, cantidad,'#graf2')
                    }
                  })
                  $('#grafico3').on('click', function() {
                    if ($('#grafos').hasClass('grafos')) { 
                    $('.graf, #graf3').show(1500)
                    $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                    graficoDonut(nombre,cantidad, '#graf3')
                    }
                  })
                  $('#grafico4').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf4').show(1500)
                    $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                    graficoLineas(nombre, cantidad, '', '#graf4')
                    }
                  })
                  $('#grafico5').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(nombre, cantidad, '', '#graf5')
                    }
                  })
                  $('#grafico6').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf6').show(1500)
                    $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                    graficoRadar(nombre, cantidad, '', '#graf6')
                    }
                  })
            }
              else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
                    Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'error',
               title:'No hay <b class="text-rojo fw-bold"> Asistencias</b> registradas!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
              }
  
              
          }
         });
  
  }
  
  
  function asistenciasEstudiantesJustificativo(){
      let fecha = $('#selectFecha').val();
    $.ajax({
        url: '',
        type: 'POST',
        dataType: 'JSON',
        data: {reporteAsistenciasPorJustificativo: true, fecha}, 
        success(response){
  
              var cantidad =[];
  
                  if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                  $('#fil').removeClass('d-none');
  
                 response.forEach(fila => {
                if (fila.cantidad != 0 ) {
                   cantidad.push(fila.cantidad);
                 }
  
                });
  
                   $('#grafico1').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf1').show(1500)
                    $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                    graficoBarra(' ','N° de Asistencias', cantidad, '','#graf1')
                    }
                  })
                  $('#grafico2').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf2').show(1500)
                    $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                    graficoPastel(' ', cantidad,'#graf2')
                    }
                  })
                  $('#grafico3').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf3').show(1500)
                    $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                    graficoDonut(' ',cantidad, '#graf3')
                    }
                  })
                  $('#grafico4').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf4').show(1500)
                    $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                    graficoLineas(' ', cantidad, '', '#graf4')
                    }
                  })
                  $('#grafico5').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(' ', cantidad, '', '#graf5')
                    }
                  })
                  $('#grafico6').on('click', function() { 
                    if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf6').show(1500)
                    $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                    graficoRadar(' ', cantidad, '', '#graf6')
                    }
                  })
            }
              else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
                    Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'error',
               title:'No hay <b class="text-rojo fw-bold"> Asistencias</b> registradas!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
              }
  
              
          }
         });
  
  }


  /// ---------------------- menus y eventos ----------------------

function menus(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteMenus: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Menus', cantidad, '','#graf1')
                }
                })
                $('#grafico2').on('click', function() { 
                 if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                 }
                })
                $('#grafico3').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                 }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                   if ($('#grafos').hasClass('grafos')) {
                    $('.graf, #graf5').show(1500)
                    $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                    graficoArea(nombre, cantidad, '', '#graf5')
                   }
                })
                $('#grafico6').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                }
                })
          }
            else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
                  Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Menús</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function eventos(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteEventos: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                 }
                })
                $('#grafico2').on('click', function() { 
                 if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                 }
                })
                $('#grafico3').on('click', function() { 
                 if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                 }
                })
                $('#grafico4').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                 }
                })
                $('#grafico5').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                 }
                })
                $('#grafico6').on('click', function() { 
                 if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                 }
                })
          }
            else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
                  Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Eventos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function cantidadMenuActivos(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteCantidadMenuActivos: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() {
                if ($('#grafos').hasClass('grafos')) { 
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                 }
                })
                $('#grafico4').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                 }
                })
                $('#grafico5').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                }
                })
                $('#grafico6').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                 }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                 $('#grafos').addClass('grafis');
                 $('#fil').addClass('d-none');
                 $('#sel0, #botonB').hide(0);
            Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Menús</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function alimentosMasUtilizados(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteAlimentosMasUtilizados: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                  $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                  $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                 }
                })
                $('#grafico3').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                 }
                })
                $('#grafico4').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                 }
                })
                $('#grafico6').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                 }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                 $('#grafos').addClass('grafis');
                 $('#fil').addClass('d-none');
                 $('#sel0, #botonB').hide(0);
                  Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Menús</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function eventosConMayorAlimentos(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteEventosConMayorAlimentos: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                 }
                })
                $('#grafico2').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                }
                })
                $('#grafico3').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                 }
                })
                $('#grafico4').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                 }
                })
                $('#grafico5').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                }
                })
                $('#grafico6').on('click', function() { 
                if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                 }
                })
          }
            else{
                   $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                   $('#fil').addClass('d-none');
                   $('#sel0, #botonB').hide(0);
          Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold">Eventos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}



//------------------------ alimentos ---------------------------


function entradaAlimentos(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteEntradaAlimentos: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

            if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                  Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Alimentos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
            })
            }

            
        }
       });

}


function alimentosMasIngresados(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteAlimentosMasIngresados: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Alimentos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() {
                  if ($('#grafos').hasClass('grafos')) { 
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
            Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Alimentos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function salidaAlimentosMenu(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteSalidaAlimentosMenu: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                 Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Alimentos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function salidaAlimentosMerma(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteSalidaAlimentosMerma: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
            Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Alimentos</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

//---------------------- utensilios ---------------------------------

function entradaUtensilios(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteEntradaUtensilios: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                 Swal.fire({
             toast: true,
             position: 'top-end',
            icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Utensilios</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function utensiliosMasIngresados(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteUtensiliosMasIngresados: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                 Swal.fire({
             toast: true,
             position: 'top-end',
              icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Utensilios</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}

function salidaUtensilios(){
  let fecha = $('#selectFecha').val();
  $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporteSalidaUtensilios: true, fecha}, 
      success(response){

            var cantidad =[];
            var nombre =[];

                if (response.length > 0) {
                $('#grafos').addClass('grafos');
                  $('#grafos').removeClass('grafis');
                $('#fil').removeClass('d-none');

               response.forEach(fila => {
              if (fila.cantidad != 0) {
                 cantidad.push(fila.cantidad);
                 nombre.push(fila.nombre);
               }

              });

                $('#grafico1').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf1').show(1500)
                  $('#graf2, #graf3, #graf4, #graf5, #graf6').hide(1000)
                  graficoBarra(nombre,'N° de Eventos', cantidad, '','#graf1')
                  }
                })
                $('#grafico2').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf2').show(1500)
                  $('#graf1, #graf3, #graf4, #graf5, #graf5').hide(1000)
                  graficoPastel(nombre, cantidad,'#graf2')
                  }
                })
                $('#grafico3').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf3').show(1500)
                  $('#graf1, #graf2, #graf4, #graf5, #graf6').hide(1000)
                  graficoDonut(nombre,cantidad, '#graf3')
                  }
                })
                $('#grafico4').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf4').show(1500)
                  $('#graf1, #graf3, #graf3, #graf5, #graf6').hide(1000)
                  graficoLineas(nombre, cantidad, '', '#graf4')
                  }
                })
                $('#grafico5').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf5').show(1500)
                  $('#graf1, #graf3, #graf3, #graf4, #graf6').hide(1000)
                  graficoArea(nombre, cantidad, '', '#graf5')
                  }
                })
                $('#grafico6').on('click', function() { 
                  if ($('#grafos').hasClass('grafos')) {
                  $('.graf, #graf6').show(1500)
                  $('#graf1, #graf2, #graf3, #graf4, #graf5').hide(1000)
                  graficoRadar(nombre, cantidad, '', '#graf6')
                  }
                })
          }
            else{
                 $('#grafos').removeClass('grafos');
                   $('#grafos').addClass('grafis');
                $('#fil').addClass('d-none');
                 Swal.fire({
             toast: true,
             position: 'top-end',
             icon:'error',
             title:'No hay <b class="text-rojo fw-bold"> Utensilios</b> registrados!',
             showConfirmButton:false,
             timer:2500,
             timerProgressBar:true,
          })
            }

            
        }
       });

}




     
// ------------- PDF ------------------------------


function exportarReporte(a,b,c){
  let grafica =a.val();
  let tipo = b;
  let fecha = c;
  console.log(grafica)
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {reporte:true, grafica, tipo, fecha}, 
      success(data){
         if(data.respuesta == "guardado"){
            console.log(data.ruta)
            descargarArchivo(data.ruta);
            abrirArchivo(data.ruta);
             $('#clos').click();
        }else{
            console.log('ERROR WE')
        }
      },
      complete() {
           $('.loadingAnimation').hide();
   
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
 
 
 $('#reportebtn').on('click', function() {
   html2canvas(document.querySelector("#reporteIMG")).then(canvas => {
     const imageDataUrl = canvas.toDataURL();
     console.log(imageDataUrl);
     let grafica=$('#imagenCap').val(imageDataUrl);
     let tipo;
     let fecha = $('#selectFecha').val();
 
 
   if ($('#asisEstu').val() == 1) {
      tipo ='AE1';
   }
   if ($('#asisEstu').val() == 2) {
      tipo ='AE2';
   }
   if ($('#asisEstu').val() == 3) {
     tipo ='AE3';
   }
   if ($('#asisEstu').val() == 4) {
      tipo ='AE4';
   }
   if ($('#asisEstu').val() == 5) {
      tipo ='AE5';
   }
   
   if ($('#menuEvent').val() == 1) {
       tipo ='ME1';
   }
   if ($('#menuEvent').val() == 2) {
       tipo ='ME2';
   }
   if ($('#menuEvent').val() == 3) {
       tipo ='ME3';
   }
   if ($('#menuEvent').val() == 4) {
       tipo ='ME4';
   }
   if ($('#menuEvent').val() == 5) {
       tipo ='ME5';
   }
  
   if ($('#alimento').val() == 1) {
      tipo ='A1';
   }
   if ($('#alimento').val() == 2) {
       tipo ='A2';
     
   }
   if ($('#alimento').val() == 3) {
       tipo ='A3';
     
   }
   if ($('#alimento').val() == 4) {
       tipo ='A4';
   }
 
  if ($('#utensilio').val() == 1) {
       tipo ='U1';
   }
   if ($('#utensilio').val() == 2) {
       tipo ='U2';
   }
   if ($('#utensilio').val() == 3) {
       tipo ='U3';
   }
 
     exportarReporte(grafica, tipo, fecha);
   });
   $('.loadingAnimation').show();
 });

  /// ----------------------- GRÁFICOS ----------------------------

var chart = null;

function graficoBarra(reporte, subtitulo, cantidad, titulo, grafico) {
  if (chart !== null) {
    chart.destroy();
    chart = null;
  }

  var options = {
    series: [{
      name: subtitulo,
      data: cantidad
    }],
    chart: {
      height: 350,
      type: 'bar',
    },
    plotOptions: {
      bar: {
        borderRadius: 10,
        dataLabels: {
          position: 'top',
        },
      }
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val;
      },
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ["#ababab"]
      }
    },
    xaxis: {
      categories: reporte,
      position: 'top',
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      crosshairs: {
        fill: {
          type: 'gradient',
          gradient: {
            colorFrom: '#0662c5',
            colorTo: '#0854A0',
            stops: [0, 100],
            opacityFrom: 0.4,
            opacityTo: 0.5,
          }
        }
      },
      tooltip: {
        enabled: true,
      }
    },
    yaxis: {
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false,
      },
      labels: {
        show: false,
        formatter: function (val) {
          return val ;
        }
      }
    },
    title: {
      text: titulo,
      floating: true,
      offsetY: 330,
      align: 'center',
      style: {
        color: '#0662c5',
        fontSize: '15px'
      }
    },
    colors: ['#0662c5', '#0A3361', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9' , '#a2c8de', '#3665b6']
  };

  chart = new ApexCharts(document.querySelector(grafico), options);
  chart.render();
}




var chartPastel = null;

function graficoPastel(reporte, cantidad, grafico) {
  if (chartPastel !== null) {
    chartPastel.destroy();
    chartPastel = null;
  }

  var options = {
    series: cantidad,
    chart: {
      height: 350,
      type: 'pie',
      toolbar: {
        show: true
      }
    },
    labels: reporte,
     colors: ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9' , '#a2c8de', '#3665b6']
  };

  chartPastel = new ApexCharts(document.querySelector(grafico), options);
  chartPastel.render();
}




var chartDonut = null;

function graficoDonut(reporte, cantidad, grafico) {
  if (chartDonut !== null) {
    chartDonut.destroy();
    chartDonut = null;
  }

  var options = {
    series: cantidad,
    chart: {
      height: 350,
      type: 'donut',
      toolbar: {
        show: true
      }
    },
    labels: reporte,
    colors: ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9' , '#a2c8de', '#3665b6']
  };

  chartDonut = new ApexCharts(document.querySelector(grafico), options);
  chartDonut.render();
}


var chartArea = null;

function graficoArea(reporte, cantidad, titulo, grafico) {
  if (chartArea !== null) {
    chartArea.destroy();
    chartArea = null;
  }

  var options = {
    series: [{
      name: 'Área',
      data: cantidad
    }],
    chart: {
      height: 350,
      type: 'area',
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val;
      },
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ["#ababab"]
      }
    },
    xaxis: {
      categories: reporte,
    },
    title: {
      text: titulo,
      floating: true,
      offsetY: 330,
      align: 'center',
      style: {
        color: '#3cbabf',
        fontSize: '15px'
      }
    },
    colors: ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9' , '#a2c8de', '#3665b6']
  };

  chartArea = new ApexCharts(document.querySelector(grafico), options);
  chartArea.render();
}


var chartLineas = null;

function graficoLineas(reporte, cantidad, titulo, grafico) {
  if (chartLineas !== null) {
    chartLineas.destroy();
    chartLineas = null;
  }

  var options = {
    series: [{
      name: 'Línea',
      data: cantidad
    }],
    chart: {
      height: 350,
      type: 'line',
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val;
      },
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ["#ababab"]
      }
    },
    xaxis: {
      categories: reporte,
    },
    title: {
      text: titulo,
      floating: true,
      offsetY: 330,
      align: 'center',
      style: {
        color: '#3cbabf',
        fontSize: '15px'
      }
    },
    colors: ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9', '#a2c8de', '#3665b6']
  };

  chartLineas = new ApexCharts(document.querySelector(grafico), options);
  chartLineas.render();
}

var chartRadar = null;

function graficoRadar(reporte, cantidad, titulo, grafico) {
  if (chartRadar !== null) {
    chartRadar.destroy();
    chartRadar = null;
  }

  var options = {
    series: [{
      name: 'Valor',
      data: cantidad
    }],
    chart: {
      height: 350,
      type: 'radar',
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val;
      },
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ["#ababab"]
      }
    },
    xaxis: {
      categories: reporte,
    },
    title: {
      text: titulo,
      floating: true,
      offsetY: 330,
      align: 'center',
      style: {
        color: '#3cbabf',
        fontSize: '15px'
      }
    },
    colors: ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#0400ff', '#001a51', '#049ff9',  '#a2c8de', '#3665b6']
  };

  chartRadar = new ApexCharts(document.querySelector(grafico), options);
  chartRadar.render();
}



$('#rep1').addClass('active');
