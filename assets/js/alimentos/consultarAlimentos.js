
let permisos, modificarPermiso, eliminarPermiso, registrarPermiso;
$.ajax({
    method: 'POST', url: "", dataType: 'json', data: { getPermisos: 'a' },
    success(data) { permisos = data; }
}).then(function () {
    registrarPermiso = (typeof permisos.registrar === 'undefined') ? 'disabled' : '';
    modificarPermiso = (typeof permisos.modificar === 'undefined') ? 'disabled' : '';
    eliminarPermiso = (typeof permisos.eliminar === 'undefined') ? 'disabled' : '';
    $('#enviar').attr(registrarPermiso, '');
});

function quitarBotones(){

if (typeof permisos.modificar == 'undefined') {
console.log(permisos)
$(".editar").remove()   
}

if (typeof permisos.eliminar == 'undefined') {
console.log(permisos)
$(".borrar").remove()   
}
}

    let mostrarA = $('.tabla').DataTable({
    "columns": [
        { "data": "codigo", "className": "text-center" },
        {
            "data": "imgAlimento",
            "render": function (data) {
                return `<img src="${data}" width="70" height="70" alt="Profile" class="mb-2">`;
            },
            "orderable": false
        },
        { "data": "nombre" },
        { "data": "marca" },
        {
            "data": "idAlimento",
            "className": "text-center accion",
            "render": function (data) {
                return `
                <a id="${data}" class="btn btn-sm btn-icon text-info flex-end text-center informacion" data-bs-toggle="modal" data-bs-target="#infoAlimento" data-bs-toggle="tooltip" title="informacion Alimento" href="#">
                    <span class="btn-inner pi"><i class="bi bi-eye icon-24 t" width="20"></i></span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-primary flex-end text-center editar" data-bs-toggle="tooltip" title="Modificar Alimento" href="#">
                    <span class="btn-inner pi"><i class="bi bi-pencil icon-24 t" width="20"></i></span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-danger text-center borrar"  data-bs-toggle="tooltip" title="Anular Alimento" href="#" type="button">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                </a>`;
            },
            "orderable": false
        }
    ],
    "order": [[0, "asc"]]  // Ordena por la primera columna
});

$('#ani').hide(1000);

function tablaAlimentos() {
    let tipoA = $('#tipoA2').val();
    $.ajax({
        method: "post",
        url: "", 
        dataType: "json",
        data: { mostrarAlimentos: true, tipoA },
        success(data) {
            $('#ani').show(2000);
            mostrarA.clear().rows.add(data).draw();
            mostrarA.on('draw.dt', function () {
                quitarBotones();
            });
            quitarBotones();
        }
    });
}






// MOSTRAR INFORMACIÓN ------------------------------------------


        $(document).on('click', '.informacion', function () {
           let id = this.id;
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { infoAlimento: true, id: id},
                success(data) {
                      let tabli1=" ", tabli2=" ";
                  
                      let imag='';
        
                       tabli1=  `
                            <tr>
                            <td class="">${data[0].tipo}</td>
                            <td class="">${data[0].codigo}</td>
                            <td class="">${data[0].nombre}</td>
                            
                        </tr>`;
        
                        tabli2=  `
                            <tr>
                            <td class="">${data[0].marca}</td>
                            <td class="">${data[0].unidadMedida}</td>
                            </tr>`;



                        imag=`<img src="${data[0].imgAlimento}" width="250" height="250"alt="Profile" class=" mb-2">`
        
                       
                            $('#info1').html(tabli1);
                            $('#info2').html(tabli2);
                            $('#imag').html(imag);
                
        }
    });
               

            });


 
function valModificar(idd){
   let id = idd ;
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {modificar: 'modificar', id},
    success(data){

      if (data.resultado === "no se puede"){
         $('#editarAlimento').modal('hide');
         $('#cerrar2').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">
                El alimento ya está registrado en los inventarios de alimentos. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#editarAlimento').modal('show');
           }
           } 
   })

  }

         $(document).on('click', '.editar', function () {
          let  iD = this.id;
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { infoAlimento: true, id: iD},
                success(data) {

                   if (data.resultado === 'ya no existe') {
                             $('.cerrar2').click();
                              delete mostrar;
                             tablaAlimentos();
                               Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<span class=" text-rojo">el alimento fue anulado recientemente!</span>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                   })
                            }
                            else{
                              valModificar(data[0].idAlimento);

                              if (data[0].marca === 'Sin Marca') {
                                  $("#acMarca").attr("checked", false);
                                  $('#marca').hide()
                                  $('#cant').hide()
                                  $("#marca").val(' ');
                                  $("#cantidad").val(' ');
                               }
                               else{

                                  $('#marca').show();
                                  $('#cant').show();
                                  $("#marca").val(data[0].marca);
                                  $("#cantidad").val(data[0].cantidad);
                                  $("#acMarca").attr("checked", true);
                              }

                    $("#tipoA").val(data[0].idTipoA).trigger('change');
                    $("#alimento").val(data[0].nombre);
                    $("#unidad").val(data[0].unidad).trigger('change');
                   $('#image').html(`<img src="${data[0].imgAlimento}" align="center" width="300">`);
                    $("#idd").val(data[0].idAlimento);
                   }

            
                }
            });
        });

         $(document).on('click', '.limpiar', function () {
          let  iD = $('#idd').val();
            $.ajax({
                method: "post",
                url: "",
                dataType: "json",
                data: { infoAlimento: true, id: iD},
                success(data) {

                   if (data.resultado === 'ya no existe') {
                             $('.cerrar2').click();
                             delete mostrar;
                             tablaAlimentos();
                               Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title:'<span class=" text-rojo">el alimento fue anulado recientemente!</span>',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                   })
                            }
                            else{
                  
                               if (data[0].marca === 'Sin Marca') {
                                  $("#acMarca").attr("checked", false);
                                  $('#marca').hide()
                                  $('#cant').hide()
                                  $("#marca").val(' ');
                                  $("#cantidad").val(' ');
                               }
                               else{

                                  $('#marca').show();
                                  $('#cant').show();
                                  $("#marca").val(data[0].marca);
                                  $("#cantidad").val(data[0].cantidad);
                                  $("#acMarca").attr("checked", true);
                              }

                              $("#tipoA").val(data[0].idTipoA).trigger('change');
                              $("#alimento").val(data[0].nombre);
                              $("#unidad").val(data[0].unidad).trigger('change');
                              $('#image').html(`<img src="${data[0].imgAlimento}" align="center" width="300">`);
                   
                         }
                     }
            });
        });

// ------------------ VALIDACIONES

 $(document).ready(function(){
            $('#acMarca').change(function(){
                if($(this).is(':checked')){
                    $('#marca').show();
                    $('#cant').show();
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
                  $("#cantidad").focusout(function(){
                      chequeo_cantidad();
                      
                      });
                  $("#cantidad").on('keyup', function(){
                      chequeo_cantidad();
                               verificarAlimento()
                    });
                } else {
                    $('#marca').hide();
                    $('#cant').hide();
                }
            });
        });        


$('.editarImagen').hide();

 $(".editarI").on("click", function(){

$('.editarImagen').show(2000)
$('.editarInfo').hide(1500)

  })

$(".cance").on("click", function(){
  primary();
$('.formIMG').trigger('reset'); 
$('.editarInfo').show(2000)
$('.editarImagen').hide(1500)

  })

$('.cerrar2').on("click", function(){
$('.editarInfo').show()
$('.editarImagen').hide()
 primary();
  $('.formIMG').trigger('reset'); 

})


  const fileInput0 = document.getElementById('fileInput0');
const container0 = document.getElementById('container0');
let error_imagen=false;
let error_alimento=false;
let error_marca=false;
let error_veriTA = false;
let error_unidad = false;
let error_cantidad = false;
let timer;


// Agregar imagen por defecto
        const defaultImage = new Image();
        defaultImage.src = 'assets/images/imagen.png'; // Ruta de la imagen por defecto
        container0.appendChild(defaultImage);

fileInput0.addEventListener('change', function() {
      chequeoImagen();
  });

 $("#tipoA").on('change', function() {
    verificarTipoA();
 });

 $("#alimento").focusout(function(){
    chequeo_alimento();
    verificarAlimento();
 });
 $("#alimento").on('keyup', function(){
    chequeo_alimento();
     clearTimeout(timer); 
         timer = setTimeout(function () {
           verificarAlimento()
         }, 500);
 });

  $("#unidad").on('change', function() {
           verificarAlimento();
 });


 $("#edita").on("click", function(e){
    e.preventDefault();
      error_alimento=false;
      error_veriTA = false;
      chequeo_alimento();
      verificarTipoA()

               if($('#acMarca').is(':checked')){
                       error_marca=false;
                       error_cantidad = false;
                       chequeo_marca();
                       chequeo_cantidad();
        
                 if (error_alimento ===false  && error_veriTA ===false && error_marca === false && error_cantidad === false ) {
                      let marcaAlimento=$('#marca').val();
                      modificar(marcaAlimento);
                  }
                  else{
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
                   
                }
                else{

                  if ( error_alimento ===false   && error_veriTA ===false ) {
                     let marcaAlimento='Sin marca';
                     modificar(marcaAlimento);
                }
                else{
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
              }
 });

$("#editarIMG").on("click", function(e){
      e.preventDefault();
      chequeoImagen();
      error_imagen=false;
      if (error_imagen === false) {
        modificarImagen();
      }
      else{
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon:'error',
                          title:'<span class=" text-rojo">Ingrese la imagen Correctamente!</span>',
                          showConfirmButton:false,
                          timer:3000,
                          timerProgressBar:3000,
                          width:'38%',
                      })
                 }
});
 

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

    // validar cantidad
      function chequeo_cantidad() {
        var chequeo = /^(0|[1-9]\d{0,2})(\.\d{1,2})?$/; // Permite números desde 0 hasta 999 con hasta dos decimales
        var cantidad = $("#cantidad").val();
        if (chequeo.test(cantidad) && cantidad !== '') {
         $(".error6").html("");
         $(".error6").hide();
         $('#cantidad').removeClass('errorBorder');
         $('.bar6').addClass('bar');
         $('.ic6').removeClass('l');
         $('.ic6').addClass('labelPri');
         $('.letra6').removeClass('labelE');
         $('.letra6').addClass('label-char');
        } else {
         $(".error6").html('<i  class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad neta!');
         $(".error6").show();
         $('#cantidad').addClass('errorBorder');
         $('.bar6').removeClass('bar');
         $('.ic6').addClass('l');
         $('.ic6').removeClass('labelPri');
         $('.letra6').addClass('labelE');
         $('.letra6').removeClass('label-char');
           error_cantidad = true;
        }
    }




 // Otros..............

 function primary(){
       container0.innerHTML = ''; // Limpiar el contenedor
         container0.appendChild(defaultImage); 
       $(".error1, .error2, .error3, .error4, .error5").html("");
         $(".error1, .error2, .error3, .error4, .error5").hide();
         $('#fileInput0, #alimento, #marca, #cantidad').removeClass('errorBorder');
          $('#tipoA, #unidad').removeClass('is-invalid');
         $('.bar1, .bar2, .bar3, .bar4, .bar5, .bar6').addClass('bar');
         $('.ic1, .ic2, .ic3, .ic4, .ic5, .ic6').removeClass('l');
         $('.ic1, .ic2, .ic3, .ic4, .ic5, .ic6').addClass('labelPri');
         $('.letra, .letra2, .letra3, .letra4, .letra5, .letra6').removeClass('labelE');
         $('.letra, .letra2, .letra3, .letra4, .letra5, .letra6').addClass('label-char');
         $('.check').removeClass('is-invalid')
          fileInput0.classList.remove('changed');

 }

 ////---------------------------MOSTRAR SELECT TIPO DE ALIMENTOS -------------------------------
mostrarTipoA();
let select;
select=$('#tipoA');

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
        $('#tipoA').html(opE);
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

    $("#tipoA2").select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#sel3'),
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
                    let alimento = cambiarFormato($("#alimento").val());
                    let unidad;
                    let  iD = $('#idd').val();
                    if($('#cantidad').val() === ''){
                        unidad = $("#unidad").val();
                    } else {
                        unidad = $('#cantidad').val() + ' ' + $("#unidad").val();
                    }
                    // Verifica el estado de #acMarca en el momento de la llamada a la función
                    if ($('#acMarca').is(':checked')) {
                        marca = cambiarFormato($("#marca").val());
                    } else {
                        marca = 'Sin Marca';
                    }
                
                    if (alimento.length >= 3 && marca.length >= 3) {
                        $.ajax({
                            url: '',
                            type: 'POST',
                            dataType: 'JSON',
                            data: { verificarAlimento:true, id:iD, alimento, marca, unidad },
                            success(data) {
			                   
                                if (data.resultado === 'existe') {
                                    
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'error',
                                         title: 'El alimento <b class="fw-bold text-rojo">' + alimento + '</b>' +   (marca !== 'Sin Marca' ? ' de la marca <b class="fw-bold text-rojo">' + marca + '</b>' : '') +  ' ya está registrado!',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: 3000,
                                    });
                                   
                                    $('#alimento, #marca,  #cantidad').addClass('errorBorder');
                                    $(' .bar3, .bar4, .bar5, .bar6').removeClass('bar');
                                    $(' .ic3, .ic4, .ic5, .ic6').addClass('l');
                                    $(' .ic3, .ic4, .ic5, .ic6').removeClass('labelPri');
                                    $(' .letra3, .letra4, .letra5, .letra6').addClass('labelE');
                                    $(' .letra3, .letra4, .letra5, .letra6').removeClass('label-char');
                                      $('#unidad').addClass('is-invalid');

                                       if(marca === 'Sin Marca'){
                                        $('#marca, #cantidad').removeClass('errorBorder');
                                        $('.bar4, .bar6').addClass('bar');
                                        $('.ic4, .ic6').removeClass('l');
                                        $('.ic4, .ic6').addClass('labelPri');
                                        $('.letra4, .letra6').removeClass('labelE');
                                        $('.letra4, .letra6').addClass('label-char');

                                      }
                                } else {
                                   
                                    $('#alimento, #marca').removeClass('errorBorder');
                                    $(' .bar3, .bar4, .bar5, .bar6').addClass('bar');
                                    $(' .ic3, .ic4, .ic5, .ic6').removeClass('l');
                                    $(' .ic3, .ic4, .ic5, .ic6').addClass('labelPri');
                                    $(' .letra3, .letra4, .letra5, .letra6').removeClass('labelE');
                                    $(' .letra3, .letra4, .letra5, .letra6').addClass('label-char');
                                      $('#unidad').removeClass('is-invalid');
                                }
                            }
                        });
                    }
                }
                
// ---------------- MODIFICAR ------------------------

function modificar(marcaA){
  let tipoA = cambiarFormato($("#tipoA").val());
  let alimento =cambiarFormato( $("#alimento").val());
  let marca = cambiarFormato(marcaA);
  let unidad;

                    if($('#cantidad').val() === ''){
                        unidad = $("#unidad").val();
                    } else {
                        unidad = $('#cantidad').val() + ' ' + $("#unidad").val();
                    }
  let id= $('#idd').val();
  let token = $('[name="csrf_token"]').val();
  if(token) {
    console.log('Token CSRF enviado:', token);
   $.ajax({
      type: "POST",
      url: '',
      dataType: "json",
      data:{modificarINFO:'SI', id, tipoA, alimento, marca, unidad, csrfToken: token},
      success(dato){

                        if (dato.mensaje.resultado === 'existe') {
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  icon:'error',
                                  title: 'El alimento <b class="fw-bold text-rojo">' + alimento + '</b>' +   (marca !== 'Sin Marca' ? ' de la marca <b class="fw-bold text-rojo">' + marca + '</b>' : '') +  ' ya está registrado!',
                                  showConfirmButton:false,
                                  timer:3000,
                                  timerProgressBar:3000,
                                })
                                $('#alimento, #marca, #cantidad').addClass('errorBorder');
                                $(' .bar3, .bar4, .bar5, .bar6').removeClass('bar');
                                $(' .ic3, .ic4, .ic5, .ic6').addClass('l');
                                $(' .ic3, .ic4, .ic5, .ic6').removeClass('labelPri');
                                $(' .letra3, .letra4, .letra5, .letra6').addClass('labelE');
                                $(' .letra3, .letra4, .letra5, .letra6').removeClass('label-char');
                                $('#unidad').addClass('is-invalid');
                                  
                                     if(marca === 'Sin Marca'){
                                        $('#marca, #cantidad').removeClass('errorBorder');
                                        $('.bar4, .bar6').addClass('bar');
                                        $('.ic4, .ic6').removeClass('l');
                                        $('.ic4, .ic6').addClass('labelPri');
                                        $('.letra4, .letra6').removeClass('labelE');
                                        $('.letra4, .letra6').addClass('label-char');

                                      }

                            }
                            else if (dato.mensaje.resultado === 'modificado' && dato.newCsrfToken) {
                               $('[name="csrf_token"]').val(dato.newCsrfToken);
                               console.log(dato);
                               $('.cerrar2').click();
                               Swal.fire({
                                      toast: true,
                                      position: 'top-end',
                                      icon:'success',
                                      title:'Alimento Modificado Exitosamente!',
                                      showConfirmButton:false,
                                      timer:2500,
                                      timerProgressBar:true,
                                   })
                               delete mostrarA;
                               tablaAlimentos()
                                   primary();
                             }
        
      }
    });
  }
}


                  
  
      
function modificarImagen() {
    var datos = new FormData();
    var files = $("#fileInput0")[0].files;
    let id=$('#idd').val();
    let token = $('[name="csrf_token"]').val();

    datos.append("imagen", files[0]); // Solo toma el primer archivo si hay varios
    datos.append("id", id);
   

    if(token) {
       datos.append("csrfToken", token);
       console.log('Token CSRF enviado:', token);

    $.ajax({
        url: "",
        type: "POST",
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
          data = typeof data === 'string' ? JSON.parse(data) : data;
			if (data.resultado == 'El archivo no es una imagen válida (JPEG, PNG)!' || 
			    data.resultado == 'La imagen no debe superar los 2MB!' || 
			    data.resultado == 'La imagen está dañada o no se puede procesar!') {

			      	container0.innerHTML = ''; 
              container0.appendChild(defaultImage); 
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> '+data.resultado+'');
              $(".error1").show();
              $('#fileInput0').addClass('errorBorder');
              $('.bar1').removeClass('bar');
              $('.ic1').addClass('l');
              $('.ic1').removeClass('labelPri');
              $('.letra').addClass('labelE');
              $('.letra').removeClass('label-char');
             fileInput0.classList.add('changed');
             error_imagen = true;

				Swal.fire({
					toast: true,
					position: 'top-end',
					icon: 'error',
					title: data.resultado,
					showConfirmButton: false,
					timer: 2500,
					timerProgressBar: true,
				});
			}
      else if(data.mensaje.resultado === 'imagen modificado' && data.newCsrfToken) {
                console.log(data)
                $('[name="csrf_token"]').val(data.newCsrfToken);
                $('.cerrar2').click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Imagen del alimento Modificado Exitosamente!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
                delete mostrar;
                tablaAlimentos();
                container0.innerHTML = ''; // Limpiar el contenedor
                container0.appendChild(defaultImage);
                primary();
      }
      }
          
    });
  }
}


// ---------------------------- ANULAR



//------------ ELIMINAR AJAX----------------------------------------
function valAnular(idd){
   let id = idd ;
   $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {modificar: 'modificar', id},
    success(data){

      if (data.resultado === "no se puede"){
         $('#borrarAlimento').modal('hide');
         $('#cerrar3').click();
             Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
                El alimento ya está registrado en los inventarios de alimentos. `,
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
             
           }
           if(data.resultado === "se puede"){
            $('#borrarAlimento').modal('show');
           }
           } 
   })

  }
  

  $(document).on('click', '.borrar', function() {
    id = this.id;
    valAnular(id);
    $.ajax({
    url: "",
    dataType: 'json',
    method: "POST",
    data: {infoAlimento: 'anular', id},
    success(data){
       if (data.resultado === 'ya no existe') {
        $('#cerrar3').click();
         delete mostrarA;
         tablaAlimentos();
         Swal.fire({
                toast: true,
                position: 'top-end',
                icon:'error',
                title:'<span class=" text-rojo">El alimento fue anulado recientemente!</span>',
                showConfirmButton:false,
                timer:3000,
                timerProgressBar:3000,
            })
        }
        else{
           if (data[0].marca === 'Sin Marca') {
              $('.eliminarA').html( '¿Deseas anular el alimento <b class="text-primary">'+data[0].nombre+'</b> ?');
           }
           else{
              $('.eliminarA').html( '¿Deseas anular el alimento <b class="text-primary">'+data[0].nombre+'</b> de la marca <b class="text-primary">'+data[0].marca+'</b> ?');
            }
        }
     
   
  
    }

   })

  });

  //-----------------------------------------------------------------------------------------
  
  $('#borrar').click((e)=>{
    let token = $('[name="csrf_token"]').val();
    if(token){
      console.log('Token CSRF enviado:', token);
    e.preventDefault();
    $.ajax({
      url: '',
      method: 'post',
      dataType: 'json',
      data:{id , borrar: 'borrar', csrfToken: token},
      success(data){
        console.log(data);
      if (data.mensaje.resultado === 'eliminado' && data.newCsrfToken){
        $('[name="csrf_token"]').val(data.newCsrfToken);
        $('#cerrar3').click();
        delete mostrarA;
        tablaAlimentos();
          Swal.fire({
               toast: true,
               position: 'top-end',
               icon:'success',
               title:'Alimento Anulado Exitosamente!',
               showConfirmButton:false,
               timer:2500,
               timerProgressBar:true,
            })
      }
    }
  })
}
    })


// -------------- FILTRO DE BUSQUEDA

$('#tipoA2').on('change', function() { 
     tablaAlimentos();
  })


////---------------------------MOSTRAR SELECT TIPO DE ALIMENTOS -------------------------------
mostrarTipoA2();
let selectA;
selectA=$('#tipoA2');
let input;
input= ' <option value="Seleccionar">Seleccionar</option>';

function mostrarTipoA2(){
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
        $('#tipoA2').html(input + opE);
      }
    })
  }

$(document).ready(function () {
   // Ocultar por defecto si el checkbox no está marcado
   if (!$('.activarFiltro').is(':checked')) {
       $('.buscar').hide();
       tablaAlimentos();
   }
   // Manejar cambios en el checkbox
   $('.activarFiltro').change(function () {
       if ($(this).is(':checked')) {
           $('.buscar').show();
       } else {
           $('.buscar').hide();
           $('#tipoA2').val('Seleccionar').trigger('change.select2');
         tablaAlimentos();
       }
   });

});

$('#ali1').addClass('active');
$('#ali3').addClass('text-primary');
$('.ali3').addClass('active')

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