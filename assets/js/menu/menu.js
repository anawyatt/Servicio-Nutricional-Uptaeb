

    let error_tipoA= false;
    let error_alimento=false;
    let error_cantidad= false;
    let error_horarioC = false;
    let error_fecha = false;
    let error_cantidadE= false;
    let error_descrip = false;
    let error_veriTA = false;
    let error_veriA = false;
    let error_tabla=false;
    let error_validarFH = false;
    let hoyA= $('#feMenu');
    const tableContainer = document.getElementById('totalA');
    const tableContainer2 = document.getElementById('totalD');


    $('#disponibilidad').hide();
    $('#tablaD').hide();

    $('#ani').hide(0);
    $("#tipoA").on('change', function() {
	    verificarTipoA()
      mostrarAlimento($(this).val());
      chequeo_tipoA()
    });

    $("#alimento").on('change', function() {
	    verificarAlimento()
	    chequeo_alimento()

	    mostrar($(this).val());
	    mostrarCantidadDisponible($(this).val());

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

$('input[type="checkbox"]').on('change', function(e) {
  // Desmarcar todos los checkboxes excepto el seleccionado
  $('input[type="checkbox"]').not(this).prop('checked', false);

  // Verificar si no hay ningún checkbox seleccionado
  if ($('input[type="checkbox"]:checked').length == 0) {
    e.preventDefault(); // Prevenir comportamiento por defecto
    validarCheck();  // Llamar a la función de validación cuando no hay selección
  } else {
    e.preventDefault(); // Prevenir comportamiento por defecto
    validarCheck();  // Llamar a la función de validación
    validarFH();     // Llamar a la función adicional cuando hay selección
  }
});


    $("#cantidad").focusout(function(){
      chequeo_cantidad();
    });

    $("#cantidad").on('keyup', function(){
     chequeo_cantidad();
    });

    $("#feMenu").focusout(function(){
      chequeo_fecha();
      validarFH();
    });

    $("#feMenu").on('keyup', function(){
      chequeo_fecha();
      validarFH();
    });

    $("#cantPlatos").focusout(function(){
      chequeo_cantidadE();
    });
  
    $("#cantPlatos").on('keyup', function(){
      chequeo_cantidadE();
    });

    $("#descripcion").focusout(function(){
      chequeo_descripcion();
    });

    $("#descripcion").on('keyup', function(){
      chequeo_descripcion();
    });


    $("#cancelar").on('click', function() {
  	 primary();
  	setTodayDate(hoyA);
    vaciarTabla()
    $('#ani').hide();
     $('#tablaD').hide();
     $('#descripcion').val('');
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
    error_horarioC = false;

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

    $('body').on('click', '#quitarFila', function(e) {
      var claseAEliminar = $(this).attr('value');
      console.log(claseAEliminar);

      console.log(claseAEliminar) // Obtener el valor del atributo 'value' del botón

        Swal.fire({
        title: '¿Deseas eliminar este alimento de la tabla?',
        icon: 'question',
        showCancelButton: true,
        width: '35%',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Eliminar todos los <tr> que tengan la clase igual al valor del botón
            $('.table tbody .' + claseAEliminar).remove();

            validarTabla();
        }
    });

    e.preventDefault();
});



$("#registrar").on('click', function() {
  error_fecha=false;
  error_horarioC = false;
  error_cantidadE= false;
  error_descrip = false;
  error_tabla=false;
  error_validarFH=false;
  
 
  chequeo_fecha();
  chequeo_cantidadE();
  chequeo_descripcion();
  validarTabla();
  validarCheck()
  validarFH()

  if (!error_fecha && !error_horarioC &&  !error_cantidadE && !error_descrip && !error_tabla && !error_validarFH) {
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

 


////---------------------------MOSTRAR SELECT DE ALIMENTOS -------------------------------
let select2;
select2 = $('#alimento');
let input2;
input2 = ' <option value="Seleccionar">Seleccionar</option>';

function mostrarAlimento(a) {
  if (a !== 'Seleccionar') {
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
  } else {
    $('#alimento').val('Seleccionar').trigger('change.select2');
  }
}

$(document).ready(function() {
  $("#tipoA").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel'),
    selectionCssClass: "input",
    width: 'resolve', 
  
  });

  $("#alimento").select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#sel2'),
    selectionCssClass: "input",
    width:  'resolve',
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
      
      setTodayDate(hoyA);

      function setTodayDate(fech) {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
        var year = today.getFullYear();
        var todayFormatted = `${year}-${month}-${day}`;
        let fecha= fech;
        fecha.val(todayFormatted);
    }  
  



// ----------------------- VALIDACIONES -----------------------------

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
      var chequeo = /^[1-9]\d*$/; // Regex para asegurarse de que solo se ingresen números enteros positivos
      var cantidad = $("#cantidad").val();
      let alimento = $('.alimento').val();
    
      disponible(alimento).then(mostrarCantidadDisponible => {
        console.log(mostrarCantidadDisponible);
        console.log(alimento);
    
        // Verifica si la cantidad ingresada es válida (solo números enteros positivos)
        if (!chequeo.test(cantidad) || cantidad === 0) {
          $(".error4").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de alimentos, solo números!');
          $(".error4").show();
          $('#cantidad').addClass('errorBorder');
          $('.bar4').removeClass('bar');
          $('.ic4').addClass('l');
          $('.ic4').removeClass('labelPri');
          $('.letra4').addClass('labelE');
          $('.letra4').removeClass('label-char');
          $('#agregarInventario').prop('disabled', true);
          error_cantidad = true;
        } 
        // Verifica si la cantidad es mayor a la disponible
        else if (cantidad > mostrarCantidadDisponible) {
          $(".error4").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese una cantidad igual o inferior a lo que está disponible!');
          $(".error4").show();
          $('#cantidad').addClass('errorBorder');
          $('.bar4').removeClass('bar');
          $('.ic4').addClass('l');
          $('.ic4').removeClass('labelPri');
          $('.letra4').addClass('labelE');
          $('.letra4').removeClass('label-char');
          $('#agregarInventario').prop('disabled', true);
          error_cantidad = true;
        } 
        // Si la cantidad es válida y no es mayor que la disponible
        else {
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
    
    function validarCheck() {
      const checkboxes = $('input[type=checkbox]');
      const errorElement = $('.error5');
      let selected = false;
    
      checkboxes.on('change', function() {
        if ($(this).is(':checked')) {
          checkboxes.not(this).prop('checked', false).removeClass('is-invalid');
          selected = true;
        } else {
          selected = false;
        }
    
        if (selected) {
          errorElement.html('');
          checkboxes.removeClass('is-invalid');
        } else {
          errorElement.html('<i class="bi bi-exclamation-triangle-fill"></i> ¡Seleccione un horario para el menú!');
          checkboxes.addClass('is-invalid');
        }
      });
    
      if ($('input[type=checkbox]:checked').length == 0) {
        errorElement.html('<i class="bi bi-exclamation-triangle-fill"></i> ¡Seleccione un horario para el menú!');
        checkboxes.addClass('is-invalid');
        error_horarioC = true;
      } else {
        errorElement.html('');
        checkboxes.removeClass('is-invalid');
      }
    }
     
    function chequeo_fecha() {
      const fecha = Date.parse($("#feMenu").val());
        Date.parse($("#feMenu").val());
        const hoy = Date.now();
            if (fecha !== '' &&  fecha >= hoy){
                $(".error6").html("");
                $(".error6").hide();
                $('#feMenu').removeClass('errorBorder');
                $('.bar6').addClass('bar');
                $('.ic6').removeClass('l');
                $('.ic6').addClass('labelPri');
                $('.letra6').removeClass('labelE');
                $('.letra6').addClass('label-char');
            } else {
               $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la Fecha, No debe ser menor a la fecha de hoy!');
               $(".error6").show();
               $('#feMenu').addClass('errorBorder');
               $('.bar6').removeClass('bar');
               $('.ic6').addClass('l');
               $('.ic6').removeClass('labelPri');
               $('.letra6').addClass('labelE');
               $('.letra6').removeClass('label-char');
               error_fecha = true;
            }
    }

    function chequeo_cantidadE() {
      const chequeo = /^[1-9]\d*$/;
      const cantidadE = $("#cantPlatos").val();
      if (chequeo.test(cantidadE) && cantidadE !== 0) {
       $(".error7").html("");
       $(".error7").hide();
       $('#cantPlatos').removeClass('errorBorder');
       $('.bar7').addClass('bar');
       $('.ic7').removeClass('l');
       $('.ic7').addClass('labelPri');
       $('.letra7').removeClass('labelE');
       $('.letra7').addClass('label-char');
      } else {
       $(".error7").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de comensales!');
       $(".error7").show();
       $('#cantPlatos').addClass('errorBorder');
       $('.bar7').removeClass('bar');
       $('.ic7').addClass('l');
       $('.ic7').removeClass('labelPri');
       $('.letra7').addClass('labelE');
       $('.letra7').removeClass('label-char');
       error_cantidadE = true;
      }
    }

    function chequeo_descripcion() {
      const chequeo = /^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{5,}$/;
      const descripcion = $("#descripcion").val();
      if (chequeo.test(descripcion) && descripcion !== '') {
       $(".error8").html("");
       $(".error8").hide();
       $('#descripcion').removeClass('errorBorder');
       $('.bar8').addClass('bar');
       $('.ic8').removeClass('l');
       $('.ic8').addClass('labelPri');
       $('.letra8').removeClass('labelE');
       $('.letra8').addClass('label-char');
      } else {
       $(".error8").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la descripción del menú!');
       $(".error8").show();
       $('#descripcion').addClass('errorBorder');
       $('.bar8').removeClass('bar');
       $('.ic8').addClass('l');
       $('.ic8').removeClass('labelPri');
       $('.letra8').addClass('labelE');
       $('.letra8').removeClass('label-char');
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
                              
                                error_veriA = true;
                          	}
                              
                            
                            }
                          })
                        }
                }

                function validarFH(){
                  let feMenu = $("#feMenu").val();
                  let horarioComida = $("input[name='opcion']:checked").val();

                  if (feMenu != '' && horarioComida != '' ) {
                    $.ajax({
                           type: "POST",
                           url: '',
                           dataType: "json",
                           data:{ validar:'si', 
                            feMenu,
                            horarioComida
                            },
                            success: function(response) {
                              if (response.resultado === "error") {
                                 Swal.fire({
                                   toast: true,
                                   position: 'top-end',
                                   icon:'error',
                                   title: response.mensaje,
                                   showConfirmButton:false,
                                   timer:3000,
                                   timerProgressBar:3000,
                                 })
                                 $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> El menú ya esta registrado en esa fecha y horario!');
                                 $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> El menú ya esta registrado en esa fecha y horario!');
                                 $(".error5, .error6").show();
                                 $('#feMenu').addClass('errorBorder');
                                 $('.bar6').removeClass('bar');
                                 $('.ic6').addClass('l');
                                 $('.ic6').removeClass('labelPri');
                                 $('.letra').addClass('labelE');
                                 $('.letra').removeClass('label-char');
                                 error_validarFH = true;
                             
                              }
                              else{
                                
                                 $(".error5, .error6").hide();
                                 $('#feMenu').removeClass('errorBorder');
                                 $('.bar6').addClass('bar');
                                 $('.ic6').removeClass('l');
                                 $('.ic6').addClass('labelPri');
                                 $('.letra').removeClass('labelE');
                                 $('.letra').addClass('label-char');


                               }
                                
                             }
                           })
                        }
           
                       }

               

     function primary (){
     	 $(".error2, .error3, .error4, .error5, .error6, .error7, .error8").html("");
         $(".error2, .error3, .error4, .error5, .error6, .error7, .error8").hide();
         $('#tipoA, #alimento, #cantidad, #feMenu, #cantPlatos, #descripcion').removeClass('is-invalid');
         $('#cantidad, #feMenu, #cantPlatos, #descripcion').removeClass('errorBorder');
         $('.bar2, .bar3, .bar4, .bar5, .bar6, .bar7, .bar8').addClass('bar');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').removeClass('l');
         $('.ic2, .ic3, .ic4, .ic5, .ic6, .ic7, .ic8').addClass('labelPri');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').removeClass('labelE');
         $('.letra2, .letra3, .letra4, .letra5, .letra6, .letra7, .letra8').addClass('label-char');
         $('#tipoA, #alimento').val('Seleccionar').trigger('change.select2');
         $('#cantPlatos, #descripcion').val('');
         $('input[type=checkbox]').prop('checked', false);
         $('#disponibilidad').hide();
          $('#agregarInventario').prop('disabled', false);;
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
       $('#disponibilidad').hide();
        $('#agregarInventario').prop('disabled', false);
   }

     function primary3(){
      $('.error5').html('');
        $('#tablita #horarioComida #horarioC').each(function () {
             $(this).find('.checkHorarioComida').removeClass('is-invalid') ;
         })
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

    <tr class='${codigo}'>
       <td class='d-none'><input class='d-none' id='idAlimento' value='${idA}'></td>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${alimento}</td>
       <td>${marca}</td>
       <td>${cantidad} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
       <td>
          <a id='quitarFila'  class="btn btn-sm btn-icon text-danger text-center " value='${codigo}'   data-bs-toggle="tooltip" title="Borrar Alimento"   type="button" >
                 <i class="bi bi-trash icon-24 t" width="20"></i>
          </a>
       </td>
    
    </tr>`;

    console.log(newAlimento);
    return newAlimento;

    }

    function mostrarLoQueQueda(imagen, codigo, cantidad, restar, unidad){
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


let total= cantidad - restar;

let newAlimento = `

    <tr class='${codigo}'>
       <td><img src="${imagen}" width="70" height="70"alt="Profile" class=" mb-2"></td>
       <td>${codigo}</td>
       <td>${total} ${unidadMedida}<input class='d-none' id='cantidadA' value='${cantidad}'></td>
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
      if ($('#alimento').val() === 'Seleccionar') {
      	 $('#unidad').val(' ');
      }
      else{
      	$('#unidad').val(data[0].unidadMedida);
      }
      
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
          let newRow2= mostrarLoQueQueda(data[0].imgAlimento, data[0].codigo,data[0].stock, cantidad,unidad)
          $('#tablaD').show(1000);
          $('.tabla tbody').append(newRow);
          $('.tabla2 tbody').append(newRow2);
          $('#cancelarInventario').click();
          tableContainer.scrollTop = tableContainer.scrollHeight;
          tableContainer2.scrollTop = tableContainer2.scrollHeight;
    
          }
        })
    
    }

    function mostrarCantidadDisponible(alimento){
	let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {muestra:true, idAlimento}, 
      success(data){
         if ($('#alimento').val() === 'Seleccionar') {
      	  	$('#dispo').val('');
      	  }
      	  	else{
              let unidadMedida;
              if (data[0].unidadMedida === 'Unidad' && data[0].stock > 1) {
                 unidadMedida = data[0].unidadMedida + 'es';
              }
              if (data[0].unidadMedida !== 'Unidad' && data[0].stock > 1) {
                   unidadMedida = data[0].unidadMedida + 's';
              }
               else{
                   unidadMedida = data[0].unidadMedida;
              }
              $('#disponibilidad').show(100);
      	  		$('#dispo').val(data[0].stock + ' '+unidadMedida);
      	  	}

      	  	let cantidad = data[0].stock;

      	  	 return cantidad
      }
    })

    }


  function disponible(alimento) {
  return new Promise((resolve, reject) => {
    let idAlimento = alimento;
    $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: { muestra: true, idAlimento }, 
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



    function registrar(){
        $("#registrar").prop("disabled", true);
        let feMenu = $("#feMenu").val();
        let horarioComida = $("input[name='opcion']:checked").val();
        let cantPlatos = $("#cantPlatos").val();
        let descripcion = $("#descripcion").val();
        let token = $('[name="csrf_token"]').val();

            if(token){
         console.log(token);

          $.ajax({
         url:"",
         method:"post",
         dataType:"json",
         data:{
          registrar:true,
          feMenu,
          horarioComida,
          cantPlatos,
          descripcion,
          csrfToken: token
         },
         success: function(data) {
             if (data.resultado == 'exitoso' && data.menuId && data.salidaId && data.newCsrfToken) {
    registrarDetalle(data.menuId, data.salidaId);

  $('[name="csrf_token"]').val(data.newCsrfToken);


              Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Menú Registrado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
             primary();
             $('#cancelar').click();
             $('.tabla tbody tr').remove();
             $('#ani').hide();
          
       }
  
        }  
        ,complete() {
                    $("#registrar").prop("disabled", false);
        }
      })
      }
     }
    


    function registrarDetalle(menuId, salidaId) {
      $('.tabla tbody tr').each(function () {
      let alimento = $(this).find('#idAlimento').val();
      let cantidad = $(this).find('#cantidadA').val();

      $.ajax({
        url:"",
        method:"post",
        dataType:"json",
        data:{
          alimento,
          cantidad,
          menuId,
          salidaId
        },
       success(data){
         console.log(data);
       }
  })
 })
    }



$('#me1').addClass('active');
$('#me2').addClass('text-primary');
$('.me2').addClass('active');


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
