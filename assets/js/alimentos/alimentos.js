
const fileInput0 = document.getElementById('fileInput0');
const container0 = document.getElementById('container0');
let error_imagen=false;
let error_tipoA= false;
let error_alimento=false;
let error_marca=false;
let error_unidad=false;
let error_veriTA = false;
let error_veriA = false;
let timer;


// Agregar imagen por defecto
        const defaultImage = new Image();
        defaultImage.src = 'assets/images/imagen.png'; // Ruta de la imagen por defecto
        container0.appendChild(defaultImage);

fileInput0.addEventListener('change', function() {
     chequeoImagen();
  });

 $("#tipoA").on('change', function() {
    chequeo_tipoA();
    verificarTipoA();
    verificarAlimento()
 });

 $("#alimento").focusout(function(){
    chequeo_alimento();
 });
 $("#alimento").on('keyup', function(){
    chequeo_alimento();
    clearTimeout(timer); 
         timer = setTimeout(function () {
           verificarAlimento()
         }, 500);
 });

 $("#marca").focusout(function(){
    chequeo_marca();
 });
 $("#marca").on('keyup', function(){
    chequeo_marca();
    clearTimeout(timer); 
         timer = setTimeout(function () {
           verificarAlimento()
         }, 500);
 });

 $("#unidad").on('change', function() {
    chequeo_unidad();
 });

 $('#marca').hide();
      $(document).ready(function(){
            $('#acMarca').change(function(){
                if($(this).is(':checked')){
                    $('#marca').show();
                    $("#marca").focusout(function(){
                      chequeo_marca();
                      });
                 $("#marca").on('keyup', function(){
                     chequeo_marca();
                      clearTimeout(timer); 
                      timer = setTimeout(function () {
                         verificarAlimento()
                      }, 500);
                  });
                } else {
                    $('#marca').hide();
                }
            });
        });        
 

 $("#cancelar").on('click', function() {
    primary();
 });



$("#registrar").on("click", function(e) {
    e.preventDefault();

    error_tipoA = false;
    error_alimento = false;
    error_unidad = false;
    error_veriTA = false;
    error_veriA = false;
    error_imagen=false;

    chequeo_tipoA();
    chequeo_alimento();
    chequeo_unidad();
    chequeoImagen();
    verificarTipoA();
    verificarAlimento();

    let men;
    let imagen = $("#fileInput0")[0].files.length ? $("#fileInput0")[0].files[0] : null;

    if (!imagen) {
        men = 'NO';
    } else {
        men = 'SI';
    }

    if ($('#acMarca').is(':checked')) {
        error_marca = false;
        chequeo_marca();

        if (!error_imagen && !error_tipoA && !error_alimento && !error_unidad && !error_veriA && !error_veriTA && !error_marca) {
            let datos = new FormData();
            let tipoA = cambiarFormato($("#tipoA").val());
            let alimento = cambiarFormato($("#alimento").val());
            let marca = cambiarFormato($("#marca").val());
            let unidad = $("#unidad").val();

            if (imagen !== null) {
                datos.append("imagen", imagen); 
            }

            datos.append("men", men);
            datos.append("tipoA", tipoA);
            datos.append("alimento", alimento);
            datos.append("marca", marca);
            datos.append("unidad", unidad);

            registrar(datos);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<span class=" text-rojo">Ingrese los Datos Correctamente!</span>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: 3000,
                width: '38%',
            });
        }
    } else {
        if (!error_imagen &&!error_tipoA && !error_alimento && !error_unidad && !error_veriA && !error_veriTA) {
            $('#marca').hide();

            let datos = new FormData();
            let tipoA = cambiarFormato($("#tipoA").val());
            let alimento = cambiarFormato($("#alimento").val());
            let marca = cambiarFormato('Sin Marca');
            let unidad = $("#unidad").val();

            if (imagen !== null) {
                datos.append("imagen", imagen); // Solo agregamos la imagen si está presente
            }

            datos.append("men", men);
            datos.append("tipoA", tipoA);
            datos.append("alimento", alimento);
            datos.append("marca", marca);
            datos.append("unidad", unidad);

            registrar(datos);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '<span class=" text-rojo">Ingrese los Datos Correctamente!</span>',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: 3000,
                width: '38%',
            });
        }
    }
});





// VALIDAIONES 

// Cambiar Formato -------------------------------------------

function cambiarFormato(texto) {
        // Dividir la cadena en palabras utilizando espacios
        const palabras = texto.split(" ");
        let palabrasFormateadas = [];
    
        // Recorrer las palabras
        for (let i = 0; i < palabras.length; i++) {
            // Eliminar espacios en blanco adicionales y formatear cada palabra
            if (palabras[i].trim() !== "") {
                palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
            }
        }
    
        // Unir las palabras formateadas nuevamente en una cadena
        return palabrasFormateadas.join(" ");
    }


// validar Imagen---------------------------------------------

 function chequeoImagen(){
 if (fileInput0.files.length > 0) {
    validarPesoImagen0(fileInput0);
 
    const file = fileInput0.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        const image = document.createElement('img');
        image.src = e.target.result;
        container0.innerHTML = '';
        container0.appendChild(image);
    };

    if (file.type.startsWith('image/')) {
        reader.readAsDataURL(file);
             $(".error1").html("");
             $(".error1").hide();
             $('#fileInput0').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
              fileInput0.classList.remove('changed');
    } else {
              container0.innerHTML = ''; // Limpiar el contenedor
              container0.appendChild(defaultImage); 
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la imagen con formato (JPG, PNG)!');
              $(".error1").show();
              $('#fileInput0').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
              fileInput0.classList.add('changed');
            
        fileInput0.value = '';
        error_imagen = true;
    }
  }
    
    }


function validarPesoImagen0(input) {
    if (input.files && input.files[0]) {
    const imagen = input.files[0];
    const pesoMb = imagen.size / 1024 / 1024; // Convertir el tamaño a MB

    if (pesoMb > 2) {
              container0.innerHTML = ''; // Limpiar el contenedor
              container0.appendChild(defaultImage); 
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> La imagen excede el peso máximo de 2MB!');
              $(".error1").show();
              $('#fileInput0').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
              input.classList.add('changed');
             input.value = "";
             error_imagen = true;
    
               
    } else {
             $(".error1").html("");
             $(".error1").hide();
             $('#fileInput0').removeClass('errorBorder');
             $('.bar1').addClass('bar');
             $('.ic1').removeClass('l');
             $('.ic1').addClass('labelPri');
             $('.letra').removeClass('labelE');
             $('.letra').addClass('label-char');
              fileInput0.classList.remove('changed');
     }
   }
  }

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


// validar alimento


    function chequeo_alimento() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var alimento = $("#alimento").val();
        if (chequeo.test(alimento) && alimento !== '') {
         $(".error3").html("");
         $(".error3").hide();
         $('#alimento').removeClass('errorBorder');
         $('.bar3').addClass('bar');
         $('.ic3').removeClass('l');
         $('.ic3').addClass('labelPri');
         $('.letra3').removeClass('labelE');
         $('.letra3').addClass('label-char');
        } else {
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el alimento!');
         $(".error3").show();
         $('#alimento').addClass('errorBorder');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
           error_alimento = true;
        }
    }

// validar marca

  
   function chequeo_marca() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var marca = $("#marca").val();
        if (chequeo.test(marca) && marca !== '') {
         $(".error4").html("");
         $(".error4").hide();
         $('#marca').removeClass('errorBorder');
         $('.bar4').addClass('bar');
         $('.ic4').removeClass('l');
         $('.ic4').addClass('labelPri');
         $('.letra4').removeClass('labelE');
         $('.letra4').addClass('label-char');
        } else {
         $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la marca!');
         $(".error4").show();
         $('#marca').addClass('errorBorder');
         $('.bar4').removeClass('bar');
         $('.ic4').addClass('l');
         $('.ic4').removeClass('labelPri');
         $('.letra4').addClass('labelE');
         $('.letra4').removeClass('label-char');
        
         error_marca = true;
        }
    }

// validar unidad

function chequeo_unidad() { 
        var unidad = $("#unidad").val();
        if (unidad != 'Seleccionar') {
         $(".error5").html("");
         $(".error5").hide();
         $('#unidad').removeClass('is-invalid');
         $('.bar5').addClass('bar');
         $('.ic5').removeClass('l');
         $('.ic5').addClass('labelPri');
         $('.letra5').removeClass('labelE');
         $('.letra5').addClass('label-char');
        } else {
         $(".error5").html('<i  class="bi bi-exclamation-triangle-fill"></i> Seleccione la unidad de medida!');
         $(".error5").show();
         $('#unidad').addClass('is-invalid');
         $('.bar5').removeClass('bar');
         $('.ic5').addClass('l');
         $('.ic5').removeClass('labelPri');
         $('.letra5').addClass('labelE');
         $('.letra5').removeClass('label-char');
         error_unidad = true;
        }
    }

 // Otros..............

 function primary(){
 	     container0.innerHTML = ''; // Limpiar el contenedor
         container0.appendChild(defaultImage); 
 	     $(".error1, .error2, .error3, .error4, .error5").html("");
         $(".error1, .error2, .error3, .error4, .error5").hide();
         $('#fileInput0, #alimento, #marca').removeClass('errorBorder');
          $('#tipoA, #unidad').removeClass('is-invalid');
         $('.bar1, .bar2, .bar3, .bar4, .bar5').addClass('bar');
         $('.ic1, .ic2, .ic3, .ic4, .ic5').removeClass('l');
         $('.ic1, .ic2, .ic3, .ic4, .ic5').addClass('labelPri');
         $('.letra, .letra2, .letra3, .letra4, .letra5').removeClass('labelE');
         $('.letra, .letra2, .letra3, .letra4, .letra5').addClass('label-char');
         $('#tipoA, #unidad').val('Seleccionar').trigger('change.select2');
         $('#marca').hide();
         $('.check').removeClass('is-invalid')
         fileInput0.classList.remove('changed');

 }

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

$(document).ready(function() {
    $("#tipoA").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel'),
        selectionCssClass: "input",
        width:'100%'
    });

    $("#unidad").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel2'),
        selectionCssClass: "input",
        width:'100%'
    });
});



            function verificarTipoA(){
               
                 let tipoA = $("#tipoA").val();
                 if (tipoA != 'Seleccionar') {
                   $.ajax({
                          type: "POST",
                          url: '',
                          dataType: "json",
                          data:{ valida:'si', tipoA},
                          success(data){
		                	data = typeof data === 'string' ? JSON.parse(data) : data;
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
                    let marca;
                    let tipoA = cambiarFormato($("#tipoA").val());
                    let alimento = cambiarFormato($("#alimento").val());
                
                    // Verifica el estado de #acMarca en el momento de la llamada a la función
                    if ($('#acMarca').is(':checked')) {
                        marca = cambiarFormato($("#marca").val());
                    } else {
                        marca = 'Sin Marca';
                    }
                
                    if (tipoA !== 'Seleccionar' && alimento.length >= 3 && marca.length >= 3) {
                        $.ajax({
                            type: "POST",
                            url: '',
                            dataType: "json",
                            data: { tipoA, alimento, marca },
                            success(data) {
			                    data = typeof data === 'string' ? JSON.parse(data) : data;
                                if (data.resultado === 'existe') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'El alimento <b class="fw-bold text-rojo">' + alimento + '</b> de la marca <b class="fw-bold text-rojo">' + marca + '</b> ya está registrado!',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: 3000,
                                    });
                                    $('#tipoA').addClass('is-invalid');
                                    $('#alimento, #marca').addClass('errorBorder');
                                    $('.bar2, .bar3, .bar4').removeClass('bar');
                                    $('.ic2, .ic3, .ic4').addClass('l');
                                    $('.ic2, .ic3, .ic4').removeClass('labelPri');
                                    $('.letra2, .letra3, .letra4').addClass('labelE');
                                    $('.letra2, .letra3, .letra4').removeClass('label-char');
                                    error_veriA = true;
                                } else {
                                    $('#tipoA').removeClass('is-invalid');
                                    $('#alimento, #marca').removeClass('errorBorder');
                                    $('.bar2, .bar3, .bar4').addClass('bar');
                                    $('.ic2, .ic3, .ic4').removeClass('l');
                                    $('.ic2, .ic3, .ic4').addClass('labelPri');
                                    $('.letra2, .letra3, .letra4').removeClass('labelE');
                                    $('.letra2, .letra3, .letra4').addClass('label-char');
                                }
                            }
                        });
                    }
                }
                


   // REGISTRAR ----------------------------------------------------

function registrar(datos){
    let token = $('[name="csrf_token"]').val();
    datos.append('csrfToken', token); // Agregar el token CSRF a los datos del formulario
    if(token) {
	$.ajax({
		url: "",
		type: "POST",
		data: datos,
		processData: false,
		contentType: false,
		success: function(data) {
			// Asegurarse de que 'data' sea un objeto
			data = typeof data === 'string' ? JSON.parse(data) : data;

			if (data.resultado == 'El archivo no es una imagen válida (JPEG, PNG)!' || 
			    data.resultado == 'La imagen no debe superar los 2MB!' || 
			    data.resultado == 'La imagen está dañada o no se puede procesar!') {

				container0.innerHTML = ''; 
				container0.appendChild(defaultImage); 
				$('.error1').html('<i class="bi bi-exclamation-triangle-fill"></i> ' + data.resultado + '!');
				$(".error1").show();
				$('#fileInput0').addClass('errorBorder');
				$('.bar1').removeClass('bar');
				$('.ic1').addClass('l');
				$('.ic1').removeClass('labelPri');
				$('.letra').addClass('labelE');
				$('.letra').removeClass('label-char');
				fileInput0.classList.add('changed');

				Swal.fire({
					toast: true,
					position: 'top-end',
					icon: 'error',
					title: data.resultado,
					showConfirmButton: false,
					timer: 2500,
					timerProgressBar: true,
				});
			} else if (data.mensaje.resultado === 'registrado' && data.newCsrfToken) {
                console.log(data);
                $('[name="csrf_token"]').val(data.newCsrfToken); // Actualizar el token CSRF en el formulario
				Swal.fire({
					toast: true,
					position: 'top-end',
					icon: 'success',
					title: 'Alimento Registrado Exitosamente!',
					showConfirmButton: false,
					timer: 2500,
					timerProgressBar: true,
				});
				$('.formu').trigger('reset'); 
				primary();
			}
		}
	});

    }
}
 
      



$('#ali1').addClass('active');
$('#ali2').addClass('text-primary');
$('.ali2').addClass('active')

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