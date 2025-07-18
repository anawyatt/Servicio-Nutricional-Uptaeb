const fileInput0 = document.getElementById('fileInput0');
const container0 = document.getElementById('container0');
let error_imagen=false;
let error_tipoU= false;
let error_utensilio=false;
let error_material=false;
let error_veriTU = false;
let error_veriU = false;
let dupli_utensilio = false;

        const defaultImage = new Image();
        defaultImage.src = 'assets/images/imagen.png';
        container0.appendChild(defaultImage);

fileInput0.addEventListener('change', function() {
      chequeoImagen();
  });

 $("#tipoU").on('change', function() {
    chequeo_tipoU();
    verificarTipoU();
    verificarUtensilio()
 });

 $("#utensilio").focusout(function(){
    chequeo_utensilio();
    verificarUtensilio()
 });
 $("#utensilio").on('keyup', function(){
    chequeo_utensilio();
    verificarUtensilio()
 });

 $("#material").on('change', function() {
  chequeo_material();
    verificarUtensilio()
});

 $("#cancelar").on('click', function() {
    primary();
 });



 $("#registrar").on("click", function(e){
 	  e.preventDefault();

 	    error_imagen=false;
      error_tipoU= false;
      error_utensilio=false;
      error_material=false;
      error_veriTU = false;
      error_veriU = false;
     
      chequeo_tipoU();
      chequeo_utensilio();
      verificarTipoU();
      
      chequeo_material();

      let imagen = $("#fileInput0")[0].files.length ? $("#fileInput0")[0].files[0] : null;

      if (!imagen) {
        imgState = 'NO';
      }
      else {
        imgState = 'SI';
      }
                       
                
      if (error_imagen ===false && error_tipoU === false && error_utensilio ===false && error_veriU === false && error_veriTU === false && error_material === false ) {
        dupli_utensilio = false;
        verificarUtensilio();

        if (dupli_utensilio === false) {
        
              let datos = new FormData();
              let tipoUr = cambiarFormato($("#tipoU").val());
              let utensilior =cambiarFormato( $("#utensilio").val());
              let materialr = cambiarFormato($("#material").val());
              
              if (imagen !== null) {
                datos.append("imagen", imagen);
              }
                    datos.append("imgState", imgState);
                    datos.append("tipoUr", tipoUr);
                    datos.append("utensilior", utensilior);
                    datos.append("materialr", materialr);
                    
                console.log("datos"); 
                registrar(datos);   
        }


      }else{
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">Ingrese los Datos Correctamente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
                width:'38%',
            })
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
  if (fileInput0.files.length === 0) {
              container0.innerHTML = ''; // Limpiar el contenedor
              container0.appendChild(defaultImage); 
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> Ingrese una imagen (JPG, PNG)!');
              $(".error1").show();
              $('#fileInput0').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
             fileInput0.classList.add('changed');
             error_imagen = true;
 
  } 
  else{
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


// validar utensilio


    function chequeo_utensilio() {
        var chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
        var utensilio = $("#utensilio").val();
        if (chequeo.test(utensilio) && utensilio !== '') {
         $(".error3").html("");
         $(".error3").hide();
         $('#utensilio').removeClass('errorBorder');
         $('.bar3').addClass('bar');
         $('.ic3').removeClass('l');
         $('.ic3').addClass('labelPri');
         $('.letra3').removeClass('labelE');
         $('.letra3').addClass('label-char');
        } else {
         $(".error3").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el utensilio!');
         $(".error3").show();
         $('#utensilio').addClass('errorBorder');
         $('.bar3').removeClass('bar');
         $('.ic3').addClass('l');
         $('.ic3').removeClass('labelPri');
         $('.letra3').addClass('labelE');
         $('.letra3').removeClass('label-char');
           error_utensilio = true;
        }
    }

// validar material

  
   function chequeo_material() {

        var material = $("#material").val();
        if (material != 'Seleccionar') {
         $(".error4").html("");
         $(".error4").hide();
         $('#material').removeClass('errorBorder');
         $('.bar4').addClass('bar');
         $('.ic4').removeClass('l');
         $('.ic4').addClass('labelPri');
         $('.letra4').removeClass('labelE');
         $('.letra4').addClass('label-char');
        } else {
         $(".error4").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese el material!');
         $(".error4").show();
         $('#material').addClass('errorBorder');
         $('.bar4').removeClass('bar');
         $('.ic4').addClass('l');
         $('.ic4').removeClass('labelPri');
         $('.letra4').addClass('labelE');
         $('.letra4').removeClass('label-char');
        
         error_material = true;
        }
    }


 // Otros..............

 function primary(){
 	     container0.innerHTML = ''; // Limpiar el contenedor
         container0.appendChild(defaultImage); 
 	     $(".error1, .error2, .error3, .error4, .error5").html("");
         $(".error1, .error2, .error3, .error4, .error5").hide();
         $('#fileInput0, #utensilio, #material').removeClass('errorBorder');
          $('#tipoU').removeClass('is-invalid');
         $('.bar1, .bar2, .bar3, .bar4, .bar5').addClass('bar');
         $('.ic1, .ic2, .ic3, .ic4, .ic5').removeClass('l');
         $('.ic1, .ic2, .ic3, .ic4, .ic5').addClass('labelPri');
         $('.letra, .letra2, .letra3, .letra4, .letra5').removeClass('labelE');
         $('.letra, .letra2, .letra3, .letra4, .letra5').addClass('label-char');
         $('#tipoU, #material').val('Seleccionar').trigger('change.select2');
         fileInput0.classList.remove('changed');

 }

 ////---------------------------MOSTRAR SELECT TIPO DE UTENSILIOS -------------------------------
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


$(document).ready(function() {
    $("#tipoU").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sele'),
        selectionCssClass: "input"
        
    });

    $("#material").select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#sel34'),
      selectionCssClass: "input",
      width:'100%'
  });

});



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
                      title:'<b class="text-rojo">El tipo de utensilio ha sido anulado recientemente!</b>',
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

  function verificarUtensilio() {
    let tipoU = cambiarFormato($("#tipoU").val());
    let utensilio = cambiarFormato($("#utensilio").val());
    let material = cambiarFormato($("#material").val());

    if (tipoU !== 'Seleccionar' && utensilio.length >= 3 && material.length >= 3) {
        $.ajax({
            type: "POST",
            url: '', 
            dataType: "json",
            data: { tipoU, utensilio, material },
            success: function(data) {
              if (data.resultado === 'existe') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: `El utensilio <b class="fw-bold text-rojo">${utensilio}</b> del material <b class="fw-bold text-rojo">${material}</b> ya está registrado!`,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true, 
                });
            
                $('#tipoU').addClass('is-invalid');
                $('#utensilio, #material').addClass('errorBorder');
                $('.bar2, .bar3, .bar4').removeClass('bar');
                $('.ic2, .ic3, .ic4').addClass('l').removeClass('labelPri');
                $('.letra2, .letra3, .letra4').addClass('labelE').removeClass('label-char');
                $("#registrar").prop("disabled", true);
                dupli_utensilio = true;
            } else if (data.resultado === 'no existe') {
                
                $('#tipoU').removeClass('is-invalid');
                $('#utensilio, #material').removeClass('errorBorder');
                $('.bar2, .bar3, .bar4').addClass('bar');
                $('.ic2, .ic3, .ic4').removeClass('l').addClass('labelPri');
                $('.letra2, .letra3, .letra4').removeClass('labelE').addClass('label-char');
                $("#registrar").prop("disabled", false);
            }
            }
        });
    }
}
              


   // REGISTRAR ----------------------------------------------------


function registrar(datos){
    let token = $('[name="csrf_token"]').val();
    datos.append('csrfToken', token); 
    if(token) {
	 $.ajax({
      url: "",
      type: "POST",
      data: datos,
      processData: false,
      contentType: false,
      success: function(datos) {
        datos = typeof datos === 'string' ? JSON.parse(datos) : datos;
        
      if(datos.mensaje.resultado === 'registrado' && datos.newCsrfToken ){

        Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Utensilio Registrado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
            $('.formu').trigger('reset'); 
            
            primary();
      }      
      }, complete(){
      
        container0.innerHTML = ''; 
        container0.appendChild(defaultImage);
      }

    });
  }
}
                  
$('#ute1').addClass('active');
$('#ute2').addClass('text-primary');
$('.ute2').addClass('active')

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



