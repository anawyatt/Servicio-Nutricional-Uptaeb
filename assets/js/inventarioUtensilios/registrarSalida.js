
let error_tipoU= false;
let error_utensilio=false;
let error_cantidad= false;
let error_fecha=false;
let error_tipoS=false;
let error_descripcion=false;
let error_veriTU = false;
let error_veriU = false;
let error_veriTS = false;
let error_tabla=false;
let error_hora=false;
$('#disponibilidad').hide();

$('#tablaD').hide();

$('#ani').hide(0);
$("#tipoU").on('change', function() {
	verificarTipoU()
    mostrarUtensilio($(this).val());
    chequeo_tipoU()
 });

$("#utensilio").on('change', function() {
	verificarUtensilio()
	chequeo_utensilio()

  
	mostrarCantidadDisponible($(this).val());

	    let utensilio = $('#utensilio').val();
        let utensilioDuplicado = false;
        $('.tabla tbody tr').each(function() {
            let idUtensilios = $(this).find('#idUtensilios').val();
            if (utensilio === idUtensilios) {
              utensilioDuplicado = true;
                return false;  
            }
        });

        if (utensilioDuplicado) {
        	Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">El utensilio ya está en la tabla!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> El utensilio ya existe en la tabla!');
         $(".error3").show();
         $('#utensilio').addClass('is-invalid');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
        }
 });


$("#cantidad").focusout(function(){
    chequeo_cantidad();
 });

 $("#cantidad").on('keyup', function(){
    chequeo_cantidad();
 });

$("#fecha").focusout(function(){
    chequeo_fecha();
 });

 $("#fecha").on('keyup', function(){
    chequeo_fecha();
 });

 $("#hora").focusout(function(){
    chequeo_hora();
 });

 $("#hora").on('keyup', function(){
    chequeo_hora();
 });

 $("#tipoS").on('change', function() {
	verificarTipoS();
    chequeo_tipoS();
 });


$("#descripcion").focusout(function(){
    chequeo_descripcion();
 });

 $("#descripcion").on('keyup', function(){
    chequeo_descripcion();
 });

  $("#cancelar").on('click', function() {
  	 primary();
  	setTodayDate();
    vaciarTabla()
    $('#tablaD').hide();
    $('#ani').hide();
    $('#descripcion').val('');
 });

   $("#cancelarInventario").on('click', function() {
    primary2();
 });

$("#agregarInventario").on('click', function() {
    error_tipoU = false;
    error_utensilio = false;
    error_cantidad = false;
    error_veriTU = false;
    error_veriU = false;

    verificarTipoU();
    chequeo_tipoU();
    verificarUtensilio();
    chequeo_utensilio();
    chequeo_cantidad();

        let utensilio = $('#utensilio').val();
        let utensilioDuplicado = false;
        $('.tabla tbody tr').each(function() {
            let idUtensilios = $(this).find('#idUtensilios').val();
            if (utensilio === idUtensilios) {
              utensilioDuplicado = true;
                return false; 
            }
        });

        if (utensilioDuplicado) {
        	       Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">El utensilio ya está en la tabla!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> El utensilio ya existe en la tabla!');
         $(".error3").show();
         $('#utensilio').addClass('is-invalid');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
        } else {
         if (!error_tipoU && !error_utensilio && !error_veriU  && !error_veriTU  && !error_cantidad ) {
             let cantidad = $('#cantidad').val();
             let unidad=$('#unidad').val();
             if (cantidad > 0 && cantidad !== '') {
                         mostrarInfo(utensilio, cantidad, unidad);
            $('#ani').show(1000);
             }
         
        }
    }
});

$('body').on('click','#quitarFila',function(e){
  var claseUEliminar = $(this).attr('value');

	      Swal.fire({
            title: '¿Deseas eliminar este utensilio de la tabla?',
            icon: 'question',
            showCancelButton: true,
            width: '35%',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar',
        }).then((result) => {
            if (result.isConfirmed) {
              $('.table tbody .' + claseUEliminar).remove();
               validarTabla()
            }
        });
  
  e.preventDefault();
});

$("#registrar").on('click', function() {
  error_fecha=false;
  error_descripcion=false;
  error_tabla=false;
  error_veriTS= false;
  error_tipoS=false;
  error_hora=false;
  chequeo_tipoS()
  verificarTipoS();
  chequeo_fecha();
  chequeo_hora();
  chequeo_descripcion();
  validarTabla();

  if (!error_fecha && !error_tipoS && !error_veriTS  && !error_descripcion && !error_tabla && !error_hora) {
     registrar();

  }
  else{
  	  Swal.fire({
        toast: true,
        position: 'top-end',
        icon:'error',
        title:'<span class=" text-rojo">Ingrese los datos Correctamente!</span>',
        showConfirmButton:false,
        timer:3000,
        timerProgressBar:3000,
        width:'38%',
     })
  }
 });


////---------------------------MOSTRAR SELECT TIPO DE utensilio -------------------------------
mostrarTipoU();
let select;
select=$('#tipoU');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoU(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select: 'mostrar'}, 
      success(response){
        let opE = '';
        response.forEach(fila => {
          opE += `<option  value="${fila.idTipoU}">${fila.tipo} </option> `
        })
        $('#tipoU').html(input + opE);
      }
    })
  }


////---------------------------MOSTRAR SELECT DE utensilio -------------------------------
let select2;
select2 = $('#utensilio');
let input2;
input2 = ' <option value="Seleccionar">Seleccionar</option>';

function mostrarUtensilio(a) {
  if (a !== 'Seleccionar') {
    let tipoU = a;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select2: 'mostrar', tipoU},
      success(response) {
        let opE = '';
        response.forEach(fila => {
          let imgSrc = fila.imgUtensilios.toLowerCase().replace(' ', '_');
         
            opE += `<option value="${fila.idUtensilios}" data-img_src="${imgSrc}">${fila.nombre} - ${fila.material}</option>`;
          
        });
        $('#utensilio').html(input2 + opE);
      }
    });
  } else {
    $('#utensilio').val('Seleccionar').trigger('change.select2');
  }
}



 ////---------------------------MOSTRAR SELECT DE TIPO DE SALIDA -------------------------------
 mostrarTipoS();
let select3;
select3=$('#tipoS');
let input3;
input2= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoS(){
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select3: true}, 
      success(response){

        let opE = '';
        response.forEach(fila => {
        
        		opE += `<option  value="${fila.idTipoSalidas}">${fila.tipoSalida} </option> `
        	
        })
        $('#tipoS').html(input2 + opE);
      }
    })
    }


$(document).ready(function() {
  $("#tipoU").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel'),
    selectionCssClass: "input",
    width: '100%'
  });

  $("#utensilio").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel2'),
    selectionCssClass: "input",
    width: '100%',
    templateResult: formatState,
    templateSelection: formatState
  });


  $("#tipoS").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel3'),
        selectionCssClass: "input",
        width:'100%'
    });

  function formatState(state) {
    if (!state.id) {
      return state.text;
    }
    let imgSrc = $(state.element).data('img_src');
    if (imgSrc) {
      let $state = $(`
        <span>
          <img src="${imgSrc}" class="img-flag" style="width: 25px; height: 25px; margin-right: 10px;" />
          ${state.text}
        </span>
      `);
      return $state;
    }
    return state.text;
  }
});

// ------------------------ MOSTRAR FECHA-------------------
      setTodayDate();

     function setTodayDate() {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
            var year = today.getFullYear();
            var todayFormatted = `${year}-${month}-${day}`;
            document.getElementById('fecha').value = todayFormatted;
        }

        function preventDateDeletion(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto (borrar el campo)
            setTodayDate(); // Restablecer la fecha de hoy
        }


        setTodayTime();

        setTodayTime();

        function setTodayTime() {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var nowFormatted = `${hours}:${minutes}`;
            $('#hora').val(nowFormatted);
        }

        function preventTimeDeletion(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto (borrar el campo)
            setTodayTime(); // Restablecer la hora actual
        }

        // Asignar el evento de prevenir borrado
        $('#hora').on('keydown', preventTimeDeletion);

// ----------------------- VALIDACIONES -----------------------------

// validar Tipo de utensilio

 function chequeo_tipoU() { 
        var tipoU = $("#tipoU").val();
        if (tipoU != 'Seleccionar') {
         $(".error2").html("");
         $(".error2").hide();
         $('#tipoU').removeClass('is-invalid');
         $('.bar2').addClass('bar');
         $('.ic2').removeClass('l');
         $('.ic2').addClass('labelPri');
         $('.letra2').removeClass('labelE');
         $('.letra2').addClass('label-char');
        } else {
         $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el tipo de utensilio!');
         $(".error2").show();
         $('#tipoU').addClass('is-invalid');
         $('.bar2').removeClass('bar');
         $('.ic2').addClass('l');
         $('.ic2').removeClass('labelPri');
         $('.letra2').addClass('labelE');
         $('.letra2').removeClass('label-char');
         error_tipoU = true;
        }
    }


    function chequeo_utensilio() { 
        var utensilio = $("#utensilio").val();
        if (utensilio != 'Seleccionar') {
         $(".error3").html("");
         $(".error3").hide();
         $('#utensilio').removeClass('is-invalid');
         $('.bar3').addClass('bar');
         $('.ic3').removeClass('l');
         $('.ic3').addClass('labelPri');
         $('.letra3').removeClass('labelE');
         $('.letra3').addClass('label-char');
        } else {
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el utensilio!');
         $(".error3").show();
         $('#utensilio').addClass('is-invalid');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
         error_utensilio = true;
        }
    }

   function chequeo_cantidad() {
  var chequeo = /^[1-9]\d*$/;
  let utensilio = $('.utensilio').val();
  var cantidad = $("#cantidad").val();

  disponible(utensilio).then(mostrarCantidadDisponible => {
    console.log(mostrarCantidadDisponible);
    console.log(utensilio);

    if (chequeo.test(cantidad) && cantidad !== 0) {
      $(".error4").html("");
      $(".error4").hide();
      $('#cantidad').removeClass('errorBorder');
      $('.bar4').addClass('bar');
      $('.ic4').removeClass('l');
      $('.ic4').addClass('labelPri');
      $('.letra4').removeClass('labelE');
      $('.letra4').addClass('label-char');
    } else {
      $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de utensilio!');
      $(".error4").show();
      $('#cantidad').addClass('errorBorder');
      $('.bar4').removeClass('bar');
      $('.ic4').addClass('l');
      $('.ic4').removeClass('labelPri');
      $('.letra4').addClass('labelE');
      $('.letra4').removeClass('label-char');
      error_cantidad = true;
    }

    if (cantidad > mostrarCantidadDisponible) {
      $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese una cantidad igual o inferior a lo que está disponible!');
      $(".error4").show();
      $('#cantidad').addClass('errorBorder');
      $('.bar4').removeClass('bar');
      $('.ic4').addClass('l');
      $('.ic4').removeClass('labelPri');
      $('.letra4').addClass('labelE');
      $('.letra4').removeClass('label-char');
      $('#agregarInventario').prop('disabled', true);
      error_cantidad = true;
    } else {
      $(".error4").html("");
      $(".error4").hide();
      $('#cantidad').removeClass('errorBorder');
      $('.bar4').addClass('bar');
      $('.ic4').removeClass('l');
      $('.ic4').addClass('labelPri');
      $('.letra4').removeClass('labelE');
      $('.letra4').addClass('label-char');
      $('#agregarInventario').prop('disabled', false);
    }
  }).catch(error => {
    console.error('Error al obtener la cantidad disponible:', error);
  });
}

      

     
    function chequeo_fecha() {
        var fecha = Date.parse($("#fecha").val());
        Date.parse($("#fecha").val());
        var hoy = Date.now();
            if (fecha !== '' &&  fecha <= hoy){
                $(".error5").html("");
                $(".error5").hide();
                $('#fecha').removeClass('errorBorder');
                $('.bar5').addClass('bar');
                $('.ic5').removeClass('l');
                $('.ic5').addClass('labelPri');
                $('.letra5').removeClass('labelE');
                $('.letra5').addClass('label-char');
            } else {
               $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la Fecha, No debe ser mayor a la fecha de hoy!');
               $(".error5").show();
               $('#fecha').addClass('errorBorder');
               $('.bar5').removeClass('bar');
               $('.ic5').addClass('l');
               $('.ic5').removeClass('labelPri');
               $('.letra5').addClass('labelE');
               $('.letra5').removeClass('label-char');
               error_fecha = true;
            }
        }

        function chequeo_hora() {
          var horaIngresada = $("#hora").val();
          
          if (horaIngresada !== '') {
              $(".error8").html("");
              $(".error8").hide();
              $('#hora').removeClass('errorBorder');
              $('.bar8').addClass('bar');
              $('.ic8').removeClass('l');
              $('.ic8').addClass('labelPri');
              $('.letra8').removeClass('labelE');
              $('.letra8').addClass('label-char');
          } else {
              $(".error8").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese una hora!');
              $(".error8").show();
              $('#hora').addClass('errorBorder');
              $('.bar8').removeClass('bar');
              $('.ic8').addClass('l');
              $('.ic8').removeClass('labelPri');
              $('.letra8').addClass('labelE');
              $('.letra8').removeClass('label-char');
              error_hora = true;
          }
      }



      function chequeo_tipoS() { 
        var tipoS = $("#tipoS").val();
        if (tipoS != 'Seleccionar') {
         $(".error7").html("");
         $(".error7").hide();
         $('#tipoS').removeClass('is-invalid');
         $('.bar7').addClass('bar');
         $('.ic7').removeClass('l');
         $('.ic7').addClass('labelPri');
         $('.letra7').removeClass('labelE');
         $('.letra7').addClass('label-char');
        } else {
         $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el tipo de salida!');
         $(".error7").show();
         $('#tipoS').addClass('is-invalid');
         $('.bar7').removeClass('bar');
         $('.ic7').addClass('l');
         $('.ic7').removeClass('labelPri');
         $('.letra7').addClass('labelE');
         $('.letra7').removeClass('label-char');
         error_tipoS = true;
        }
    }


     function chequeo_descripcion() {
        var chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
        var descripcion = $("#descripcion").val();
        if (chequeo.test(descripcion) && descripcion !== '') {
         $(".error6").html("");
         $(".error6").hide();
         $('#descripcion').removeClass('errorBorder');
         $('.bar6').addClass('bar');
         $('.ic6').removeClass('l');
         $('.ic6').addClass('labelPri');
         $('.letra6').removeClass('labelE');
         $('.letra6').addClass('label-char');
        } else {
         $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción del inventario!');
         $(".error6").show();
         $('#descripcion').addClass('errorBorder');
         $('.bar6').removeClass('bar');
         $('.ic6').addClass('l');
         $('.ic6').removeClass('labelPri');
         $('.letra6').addClass('labelE');
         $('.letra6').removeClass('label-char');
           error_descripcion = true;
        }
    }



            function verificarTipoU(){
               
                 let tipoU = $("#tipoU").val();
                 if (tipoU != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida:'si', tipoU},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete select;
                                mostrarTipoU();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El tipo de utensilio  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                              
                                error_veriTU = true;
                          	}
                              
                            
                            }
                          })
                        }
                  
  
                }


                 function verificarUtensilio(){
               
                 let utensilio = $("#utensilio").val();
                 if (utensilio != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida2:'si', utensilio},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete select;
                               mostrarTipoU();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El  utensilio  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                              
                                error_veriU = true;
                          	}
                              
                            
                            }
                          })
                        }
                  
  
                }



                 function verificarTipoS(){
               
                 let tipoS = $("#tipoS").val();
                 if (tipoS != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida3:'si', tipoS},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete select3;
                                mostrarTipoS();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El tipo de salida  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                              
                                error_veriTS = true;
                          	}
                              
                            
                            }
                          })
                        }
                  
  
                }



     function primary (){
     	 $(".error2, .error3, .error4, .error5, .error6, .error7, .error8").html("");
         $(".error2, .error3, .error4, .error5, .error6, .error7, .error8").hide();
         $('#tipoU, #utensilio, #cantidad, #fecha,#tipoS, #descripcion, #hora').removeClass('is-invalid');
          $('#cantidad, #fecha, #descripcion, #hora').removeClass('errorBorder');
         $('.bar2, .bar3, .bar4, .bar5, .bar6, .bar7, .bar7').addClass('bar');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').removeClass('l');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').addClass('labelPri');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').removeClass('labelE');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').addClass('label-char');
         $('#tipoU, #utensilio, #tipoS').val('Seleccionar').trigger('change.select2');
         $('#disponibilidad').hide();
         $('#agregarInventario').prop('disabled', false);
     }

     function primary2 (){
     	 $(".error2, .error3, .error4").html("");
         $(".error2, .error3, .error4").hide();
         $('#tipoU, #utensilio').removeClass('is-invalid');
         $('#cantidad').removeClass('errorBorder');
         $('.bar2, .bar3, .bar4').addClass('bar');
         $('.ic2, .ic3, .ic4').removeClass('l');
         $('.ic2, .ic3, .ic4').addClass('labelPri');
         $('.letra2, .letra3, .letra4').removeClass('labelE');
         $('.letra2, .letra3, .letra4').addClass('label-char');
         $('#tipoU, #utensilio').val('Seleccionar').trigger('change.select2');
         $('#disponibilidad').hide();
         $('#agregarInventario').prop('disabled', false);$('#agregarInventario').prop('disabled', false);
     }

function newUtensilio(idU,imagen, utensilio, material, cantidad){
let newUtensilio = `

    <tr>
       <td class='d-none'><input class='d-none' id='idUtensilios' value='${idU}'></td>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${utensilio}</td>
       <td>${material}</td>
       <td>${cantidad}<input class='d-none' id='cantidadU' value='${cantidad}'></td>
       <td>
          <a id='quitarFila'  class="btn btn-sm btn-icon text-danger text-center "   data-bs-toggle="tooltip" title="Borrar utensilio"   type="button">
                 <i class="bi bi-trash icon-24 t" width="20"></i>
          </a>
       </td>
    
    </tr>`;
    return newUtensilio;

}

function mostrarLoQueQueda(imagen, codigo, cantidad, restar){

let total= cantidad - restar;

let newUtensilio = `

    <tr class='${codigo}'>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${codigo}</td>
       <td>${total}<input class='d-none' id='cantidadU' value='${cantidad}'></td>
    </tr>`;
    return newUtensilio;
}

function mostrarInfo(utensilio, cantidad){
	let idUtensilios = utensilio;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idUtensilios}, 
      success(data){

      let newRow= newUtensilio(data[0].idUtensilios,data[0].imgUtensilios, data[0].nombre, data[0].material, cantidad);
      let newRow2= mostrarLoQueQueda(data[0].imgUtensilios, data[0].codigo,data[0].stock, cantidad)
      $('#tablaD').show(1000);
      $('.tabla tbody').append(newRow);
      $('.tabla2 tbody').append(newRow2);
      $('#cancelarInventario').click()

      }
    })

  }

  function mostrarCantidadDisponible(utensilio){
	let idUtensilios = utensilio;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idUtensilios}, 
      success(data){
         if ($('#utensilio').val() === 'Seleccionar') {
      	  	$('#cantidad').val('');
      	  }
      	  	else{
      	  		$('#disponibilidad').show(100);
              $('#dispo').val(data[0].stock);
      	  	}

      	  	let cantidad = data[0].stock;

      	  	 return cantidad
      }
    })

  }


  function disponible(utensilio) {
  return new Promise((resolve, reject) => {
    let idUtensilios = utensilio;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: { muestra: true, idUtensilios }, 
      success(data) {
        let cantidad = data[0].stock;
        resolve(cantidad);
      },
      error(err) {
        reject(err);
      }
    });
  });
}

             function validarTabla() {
                if ($('.tabla tbody tr').length === 0) {
                   $('#ani').hide(1000)
                   $('#tablaD').hide(1000);
                   error_tabla=true;
                } 
            }
        
            validarTabla();

            function vaciarTabla() {
            const tabla = document.getElementById('tabla').getElementsByTagName('tbody')[0];
            while (tabla.firstChild) {
                tabla.removeChild(tabla.firstChild);
            }

            const tabla2 = document.getElementById('tabla2').getElementsByTagName('tbody')[0];
            while (tabla2.firstChild) {
                tabla2.removeChild(tabla2.firstChild);
            }
        }


/// -------------------- REGISTRAR ENTRADA DE utensilio -----------------------

//---------------------- Registrar -------------------------------
function registrar(){

	var fecha = $("#fecha").val();
	var hora = $("#hora").val();
	var tipoS = $("#tipoS").val();
	var descripcion = $("#descripcion").val();
  let token = $('[name="csrf_token"]').val();
   if(token) {
	$.ajax({
		url:"",
		method:"post",
		dataType:"json",
		data:{registrar:true, fecha, hora,tipoS, descripcion, csrfToken: token},
    success(data){
      if(data.mensaje && data.newCsrfToken){
              registrarDetalle(data.mensaje.id);
           
              Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Salida de utensilio Registrado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
             primary();
             $('#cancelar').click();
             $('.tabla tbody tr').remove();
             $('#ani').hide();
             $('[name="csrf_token"]').val(data.newCsrfToken);
             console.log('Token CSRF renovado:', data.newCsrfToken);
             
        }
       }

	});
}
}

//----------------------------- REGISTRAR DETALLE -----------------------------

  function registrarDetalle(id) {
    $('.tabla tbody tr').each(function () {
      let utensilio = $(this).find('#idUtensilios').val();
      let cantidad = $(this).find('#cantidadU').val();
        $.ajax({
		   url:"",
		   method:"post",
		   dataType:"json",
		   data:{utensilio, cantidad, id},
		     success(data){
		     	console.log(data);
           $('#descripcion').val('');
		     }
		})
   })
  }

  $('#iu1').addClass('active');
$('#iu4').addClass('active');
$('.iu4').addClass('active')
$('#su2').addClass('text-primary');
$('.su2').addClass('active')

