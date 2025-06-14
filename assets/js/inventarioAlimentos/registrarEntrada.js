
let error_tipoA= false;
let error_alimento=false;
let error_cantidad= false;
let error_fecha=false;
let error_descripcion=false;
let error_veriTA = false;
let error_veriA = false;
let error_tabla=false;
let error_hora=false;
let hoy= $('#fecha');
let horaA=$('#hora');
const tableContainer = document.getElementById('totalA');

$('#ani').hide(0);
$("#tipoA").on('change', function() {
	verificarTipoA()
    mostrarAlimento($(this).val());
    chequeo_tipoA()
     if ($(this).val() == 'Seleccionar') {
      $('#unidad').val('');
    }
 });

$("#alimento").on('change', function() {
	verificarAlimento()
	chequeo_alimento()
   if ($(this).val() == 'Seleccionar') {
      $('#unidad').val('');
    }

	mostrar($(this).val());

	    let alimento = $('#alimento').val();
        let alimentoDuplicado = false;
        $('.tabla tbody tr').each(function() {
            let idAlimento = $(this).find('#idAlimento').val();
            if (alimento === idAlimento) {
                alimentoDuplicado = true;
                return false;  
            }
        });

        if (alimentoDuplicado) {
        	Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">El alimento ya está en la tabla!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> El alimento ya existe en la tabla!');
         $(".error3").show();
         $('#alimento').addClass('is-invalid');
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

$("#descripcion").focusout(function(){
    chequeo_descripcion();
 });

 $("#descripcion").on('keyup', function(){
    chequeo_descripcion();
 });

  $("#cancelar").on('click', function() {
  	primary();
  	setTodayDate(hoy);
    colocarHoraActualEnCampo(horaA)
    $('#descripcion').val(' ');
    $('#ani').hide();
    vaciarTabla();
 });


   $("#cancelarInventario").on('click', function() {
    primary2();
 });

$("#agregarInventario").on('click', function() {
   error_tipoA = false;
   error_alimento = false;
   error_cantidad = false;
   error_veriTA = false;
   error_veriA = false;

    verificarTipoA();
    chequeo_tipoA();
    verificarAlimento();
    chequeo_alimento();
    chequeo_cantidad();

        let alimento = $('#alimento').val();
        let alimentoDuplicado = false;
        $('.tabla tbody tr').each(function() {
            let idAlimento = $(this).find('#idAlimento').val();
            if (alimento === idAlimento) {
                alimentoDuplicado = true;
                return false;  // Salir del bucle each
            }
        });

        if (alimentoDuplicado) {
        	       Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">El alimento ya está en la tabla!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> El alimento ya existe en la tabla!');
         $(".error3").show();
         $('#alimento').addClass('is-invalid');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
        } else {
         if (!error_tipoA && !error_alimento && !error_veriA  && !error_veriTA  && !error_cantidad ) {
             let cantidad = $('#cantidad').val();
             let unidad=$('#unidad').val();
             if (cantidad > 0 && cantidad !== '') {
                         mostrarInfo(alimento, cantidad, unidad);
            $('#ani').show(1000);
             }
         
        }
    }
});

$('body').on('click','#quitarFila',function(e){
	Swal.fire({
            title: '¿Deseas eliminar este alimento de la tabla?',
            icon: 'question',
            showCancelButton: true,
            width: '35%',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar',
        }).then((result) => {
            if (result.isConfirmed) {
               $(this).closest('tr').remove();
               validarTabla()
            }
        });
  
  e.preventDefault();
});

$("#registrar").on('click', function() {
  error_fecha=false;
  error_descripcion=false;
  error_tabla=false;
  error_hora=false;
  chequeo_fecha();
  chequeo_descripcion();
  validarTabla();
  chequeo_hora();

  if (!error_fecha && !error_descripcion && !error_tabla && !error_hora) {
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


////---------------------------MOSTRAR SELECT TIPO DE ALIMENTOS -------------------------------
mostrarTipoA();
let select;
select=$('#tipoA');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoA(){
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
        $('#tipoA').html(input + opE);
      }
    })
  }


////---------------------------MOSTRAR SELECT  DE ALIMENTOS -------------------------------
let select2;
select2 = $('#alimento');
let input2;
input2 = ' <option value="Seleccionar">Seleccionar</option>';

function mostrarAlimento(a) {
 
    let tipoA = a;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {select2: 'mostrar', tipoA},
      success(response) {
        let opE = '';
        response.forEach(fila => {
          let imgSrc = fila.imgAlimento.toLowerCase().replace(' ', '_');
          if (fila.marca === 'Sin Marca') {
            opE += `<option value="${fila.idAlimento}" data-img_src="${imgSrc}">${fila.nombre}</option>`;
          } else {
            opE += `<option value="${fila.idAlimento}" data-img_src="${imgSrc}">${fila.nombre} - ${fila.marca}</option>`;
          }
        });
        $('#alimento').html(input2 + opE);
      }
    });
 
}

$(document).ready(function() {
  $("#tipoA").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel'),
    selectionCssClass: "input",
    width: '100%',
    templateResult: formatState,
    templateSelection: formatState
  });

  $("#alimento").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel2'),
    selectionCssClass: "input",
    width: '100%',
    templateResult: formatState,
    templateSelection: formatState
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
      
      setTodayDate(hoy);
      colocarHoraActualEnCampo(horaA)

     function setTodayDate(fech) {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
            var year = today.getFullYear();
            var todayFormatted = `${year}-${month}-${day}`;
            let fecha= fech;
            fecha.val(todayFormatted);
        }



// --------------------- MOSTRAR HORA -------------------

function colocarHoraActualEnCampo(hor) {
    let ahora = new Date();

    let hora = ahora.getHours().toString().padStart(2, '0'); 
    let minutos = ahora.getMinutes().toString().padStart(2, '0');

    let horaActual = `${hora}:${minutos}`;

       let time= hor;
       time.val(horaActual);
}


 function preventDateDeletion(event) {
            event.preventDefault(); 
             colocarHoraActualEnCampo(horaA)
            setTodayDate(hoy);
        }



// ----------------------- VALIDACIONES -----------------------------

// validar Tipo de alimento

 function chequeo_tipoA() { 
        var tipoA = $("#tipoA").val();
        if (tipoA != 'Seleccionar') {
         $(".error2").html("");
         $(".error2").hide();
         $('#tipoA').removeClass('is-invalid');
         $('.bar2').addClass('bar');
         $('.ic2').removeClass('l');
         $('.ic2').addClass('labelPri');
         $('.letra2').removeClass('labelE');
         $('.letra2').addClass('label-char');
        } else {
         $(".error2").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el tipo de alimento!');
         $(".error2").show();
         $('#tipoA').addClass('is-invalid');
         $('.bar2').removeClass('bar');
         $('.ic2').addClass('l');
         $('.ic2').removeClass('labelPri');
         $('.letra2').addClass('labelE');
         $('.letra2').removeClass('label-char');
         error_tipoA = true;
        }
    }


    function chequeo_alimento() { 
        var alimento = $("#alimento").val();
        if (alimento != 'Seleccionar') {
         $(".error3").html("");
         $(".error3").hide();
         $('#alimento').removeClass('is-invalid');
         $('.bar3').addClass('bar');
         $('.ic3').removeClass('l');
         $('.ic3').addClass('labelPri');
         $('.letra3').removeClass('labelE');
         $('.letra3').addClass('label-char');
        } else {
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione el alimento!');
         $(".error3").show();
         $('#alimento').addClass('is-invalid');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
         error_alimento = true;
        }
    }

    
    function chequeo_cantidad() {
        var chequeo = /^[1-9]\d*$/;
        var cantidad = $("#cantidad").val();
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
         $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de alimentos!');
         $(".error4").show();
         $('#cantidad').addClass('errorBorder');
         $('.bar4').removeClass('bar');
         $('.ic4').addClass('l');
         $('.ic4').removeClass('labelPri');
         $('.letra4').addClass('labelE');
         $('.letra4').removeClass('label-char');
           error_cantidad = true;
        }
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
        var partesHora = horaIngresada.split(':');
        var hora = parseInt(partesHora[0], 10);
        var minutos = parseInt(partesHora[1], 10);

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



            function verificarTipoA(){
               
                 let tipoA = $("#tipoA").val();
                 if (tipoA != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida:'si', tipoA},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete select;
                                mostrarTipoA();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El tipo de alimento  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                 $('#unidad').val('');
                                error_veriTA = true;
                          	}
                              
                            
                            }
                          })
                        }
                  
  
                }


                 function verificarAlimento(){
               
                 let alimento = $("#alimento").val();
                 if (alimento != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida2:'si', alimento},
                          success(data){
                          	if (data.resultado === 'no esta') {
                          		 delete select;
                                mostrarTipoA();
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<b class="text-rojo">El  alimento  ha sido anulado recientemente!</b>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                 $('#unidad').val('');
                              
                                error_veriA = true;
                          	}
                              
                            
                            }
                          })
                        }
                  
  
                }


     function primary (){
     	 $(".error2, .error3, .error4, .error5, .error6, .error8").html("");
         $(".error2, .error3, .error4, .error5, .error6, .error8").hide();
         $('#tipoA, #alimento, #cantidad, #fecha, #descripcion, #hora').removeClass('is-invalid');
          $('#cantidad, #fecha, #descripcion, #hora').removeClass('errorBorder');
         $('.bar2, .bar3, .bar4, .bar5, .bar6, .bar7,.bar8').addClass('bar');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').removeClass('l');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').addClass('labelPri');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').removeClass('labelE');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').addClass('label-char');
         $('#tipoA, #alimento').val('Seleccionar').trigger('change.select2');
     }

     function primary2 (){
     	 $(".error2, .error3, .error4").html("");
         $(".error2, .error3, .error4").hide();
         $('#tipoA, #alimento').removeClass('is-invalid');
         $('#cantidad').removeClass('errorBorder');
         $('.bar2, .bar3, .bar4').addClass('bar');
         $('.ic2, .ic3, .ic4').removeClass('l');
         $('.ic2, .ic3, .ic4').addClass('labelPri');
         $('.letra2, .letra3, .letra4').removeClass('labelE');
         $('.letra2, .letra3, .letra4').addClass('label-char');
         $('#tipoA, #alimento').val('Seleccionar').trigger('change.select2');
     }

function newAlimento(idA,imagen, codigo, alimento, marca, cantidad, unidad){
let unidadMedida;
if (unidad === 'Unidad' && cantidad > 1) {
 unidadMedida = unidad + 'es';
}
else{
  unidadMedida = unidad;
}
if (unidad !== 'Unidad' && cantidad > 1) {
   unidadMedida = unidad + 's';
}
let newAlimento = `

    <tr>
       <td class='d-none'><input class='d-none' id='idAlimento' value='${idA}'></td>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${codigo}</td>
       <td>${alimento}</td>
       <td>${marca}</td>
       <td>${cantidad} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
       <td>
          <a id='quitarFila'  class="btn btn-sm btn-icon text-danger text-center "   data-bs-toggle="tooltip" title="Borrar Alimento"   type="button">
                 <i class="bi bi-trash icon-24 t" width="20"></i>
          </a>
       </td>
    
    </tr>`;
    return newAlimento;

}

 function mostrar(alimento){
	let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idAlimento}, 
      success(data){
      $('#unidad').val(data[0].unidadMedida)

      }
    })

  }

function mostrarInfo(alimento, cantidad, unidad){
	let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idAlimento}, 
      success(data){
      let newRow= newAlimento(data[0].idAlimento,data[0].imgAlimento, data[0].codigo, data[0].nombre, data[0].marca, cantidad, unidad);
      $('.tabla tbody').append(newRow);
      $('#cancelarInventario').click()
      tableContainer.scrollTop = tableContainer.scrollHeight;

      }
    })

  }

             function validarTabla() {
                if ($('.tabla tbody tr').length === 0) {
                   $('#ani').hide(1000)
                   error_tabla=true;
                } 
            }
        
            validarTabla();

            function vaciarTabla() {
            const tabla = document.getElementById('tabla').getElementsByTagName('tbody')[0];
            while (tabla.firstChild) {
                tabla.removeChild(tabla.firstChild);
            }
        }


/// -------------------- REGISTRAR ENTRADA DE ALIMENTOS -----------------------

//---------------------- Registrar -------------------------------
function registrar(){

	var fecha = $("#fecha").val();
	var descripcion = $("#descripcion").val();
  var hora =$('#hora').val();
   let token = $('[name="csrf_token"]').val();
   if(token){
    console.log('Token CSRF encontrado: ' + token);
	$.ajax({
		url:"",
		method:"post",
		dataType:"json",
		data:{registrar:true, fecha, hora , descripcion, csrfToken: token},
    success(data){
       let datos = typeof data === "string" ? JSON.parse(data) : data;
      if(datos.mensaje && datos.newCsrfToken) {
              registrarDetalle(datos.mensaje.id);
              Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Entrada de Alimentos Registrado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
             primary();
             $('#cancelar').click();
             $('.tabla tbody tr').remove();
             $('#ani').hide();
              $('[name="csrf_token"]').val(datos.newCsrfToken);
              console.log('Token CSRF renovado: ' + datos.newCsrfToken);
          
       }
    }
	});
}
}

//----------------------------- REGISTRAR DETALLE -----------------------------

  function registrarDetalle(id) {
    $('.tabla tbody tr').each(function () {
      let alimento = $(this).find('#idAlimento').val();
      let cantidad = $(this).find('#cantidadA').val();
        $.ajax({
		   url:"",
		   method:"post",
		   dataType:"json",
		   data:{alimento, cantidad, id},
		     success(data){
            console.log(data);
         }
		})
      })
   }


$('#ia1').addClass('active');
$('#ia2').addClass('active');
$('.ia2').addClass('active')
$('#ea2').addClass('text-primary');
$('.ea2').addClass('active')

setInterval(function() {
  $.ajax({
     url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {renovarToken: true, csrfToken:  $('[name="csrf_token"]').val()}, 
      success(data){
      if (data.newCsrfToken) {
      $('[name="csrf_token"]').val(data.newCsrfToken);
        console.log('Token CSRF renovado');
      } else {
        console.log('No se pudo renovar el token CSRF');
      }
    },
    error: function(err) {
      console.error('Error renovando token CSRF:', err);
    }
  });
}, 240000);