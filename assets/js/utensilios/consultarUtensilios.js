$(document).ready(function() {
  // Variables globales
  let permisos, modificarPermiso, eliminarPermiso, registrarPermiso;
  let id = '';
  const fileInput0 = document.getElementById('fileInput0');
  const container0 = document.getElementById('container0');
  const defaultImage = new Image();
  defaultImage.src = 'assets/images/imagen.png';
  
  let error_imagen = false;
  let error_utensilio = false;
  let error_material = false;
  let error_veriTU = false;

  // Inicialización
  container0.appendChild(defaultImage);
  $('#ani').hide(1000);
  $('.editarImagen').hide(1000);
  $('#ute1').addClass('active');
  $('#ute3').addClass('text-primary');
  $('.ute3').addClass('active');
  tablaUtensilios();
  mostrarTipoU();
  inicializarSelect2();

  // Obtener permisos
  $.ajax({
      method: 'POST',
      url: "",
      dataType: 'json',
      data: { getPermisos: 'a' },
      success(data) { permisos = data; }
  }).then(function() {
      registrarPermiso = (typeof permisos.registrar === 'undefined') ? 'disabled' : '';
      modificarPermiso = (typeof permisos.modificar === 'undefined') ? 'disabled' : '';
      eliminarPermiso = (typeof permisos.eliminar === 'undefined') ? 'disabled' : '';
      $('#enviar').attr(registrarPermiso, '');
  });

let mostrarU = $('.tabla').DataTable({
    // Definición de las columnas para Utensilios
    "columns": [
        {
            // Columna 1: Imagen del Utensilio (imgUtensilios)
            "data": "imgUtensilios",
            "render": function (data) {
                return `<img src="${data}" width="70" height="70" alt="Profile" class="mb-2">`;
            },
            "orderable": false,
            "className": ""
        },
        // Columna 2: Nombre (nombre)
        { "data": "nombre", "className": "" },
        // Columna 3: Material (material)
        { "data": "material", "className": "" },
        {
            // Columna 4: Acciones (idUtensilios)
            "data": "idUtensilios",
            "className": "text-center accion",
            "render": function (data) {
                // 'data' es el idUtensilios en este caso
                return `
                <a id="${data}" class="btn btn-sm btn-icon text-info flex-end text-center informacion" 
                    data-bs-toggle="modal" data-bs-target="#infoUtensilio" data-bs-toggle="tooltip" 
                    title="Información Utensilio" href="#">
                    <span class="btn-inner pi">
                        <i class="bi bi-eye icon-24 t" width="20"></i>
                    </span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-primary flex-end text-center editar"  
                    data-bs-toggle="tooltip" title="Modificar Utensilio" href="#">
                    <span class="btn-inner pi">
                        <i class="bi bi-pencil icon-24 t" width="20"></i>
                    </span>
                </a>
                <a id="${data}" class="btn btn-sm btn-icon text-danger text-center borrar" 
                    data-bs-toggle="modal" data-bs-toggle="tooltip" title="Anular Utensilio" href="#" type="button">
                    <i class="bi bi-trash icon-24 t" width="20"></i>
                </a>`;
            },
            "orderable": false
        }
    ],
    "order": [[1, "asc"]]
});

function tablaUtensilios() {
    $.ajax({
        method: "post",
        url: "",
        dataType: "json",
        data: { mostrarU: true },
        success(data) {
            $('#ani').show(2000);
            
            mostrarU.clear().rows.add(data).draw();
            mostrarU.on('draw.dt', function () {
                quitarBotones();
            });
            quitarBotones();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al cargar utensilios: ", textStatus, errorThrown);
        }
    });
}

  function quitarBotones() {
      if (typeof permisos.modificar == 'undefined') {
          $(".editar").remove();
      }
      if (typeof permisos.eliminar == 'undefined') {
          $(".borrar").remove();
      }
  }

  // Funciones de inicialización
  function inicializarSelect2() {
      $("#tipoU").select2({
          theme: 'bootstrap-5',
          dropdownParent: $('#sel'),
          selectionCssClass: "input",
          width: '100%'
      });
      
      $("#material").select2({
          theme: 'bootstrap-5',
          dropdownParent: $('#sel34'),
          selectionCssClass: "input",
          width: '100%'
      });
  }

  function mostrarTipoU() {
      $.ajax({
          url: '',
          type: 'POST',
          dataType: 'JSON',
          data: { select: 'mostrarU' },
          success(response) {
              let opciones = '';
              response.forEach(fila => {
                  opciones += `<option value="${fila.idTipoU}">${fila.tipo}</option>`;
              });
              $('#tipoU').html(opciones);
          }
      });
  }

  // Funciones de validación

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


  function chequeo_utensilio() {
      const chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
      const utensilio = $("#utensilio").val();
      
      if (chequeo.test(utensilio)) {
          limpiarError('error3', 'utensilio', 'errorBorder', 3);
      } else {
          mostrarError('error3', 'utensilio', 'errorBorder', 3, 'Ingrese el utensilio!');
          error_utensilio = true;
      }
  }

  function chequeo_material() {
      const chequeo = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s]{3,}$/;
      const material = $("#material").val();
      
      if (chequeo.test(material)) {
          limpiarError('error4', 'material', 'errorBorder', 4);
      } else {
          mostrarError('error4', 'material', 'errorBorder', 4, 'Ingrese el material!');
          error_material = true;
      }
  }

  function verificarTipoU() {
    const tipoU = $("#tipoU").val();
    if (tipoU !== 'Seleccionar') {
        $.ajax({
            type: "POST",
            url: '',
            dataType: "json",
            data: { valida: 'si', tipoU },
            success(data) {
                if (data.resultado === 'no esta') {
                    mostrarTipoU();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '<b class="text-rojo">El tipo de utensilio ha sido anulado recientemente!</b>',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    error_veriTU = true;
                }
                
            }
        });
    }
}


  // Funciones de ayuda
  function cambiarFormato(texto) {
      const palabras = texto.split(" ");
      let palabrasFormateadas = [];
      
      for (let i = 0; i < palabras.length; i++) {
          if (palabras[i].trim() !== "") {
              palabrasFormateadas.push(
                  palabras[i].charAt(0).toUpperCase() + 
                  palabras[i].slice(1).toLowerCase()
              );
          }
      }
      return palabrasFormateadas.join(" ");
  }

  function resetearImagen() {
      container0.innerHTML = '';
      container0.appendChild(defaultImage);
  }

  function limpiarErrorImagen() {
      $(".error1").html("").hide();
      $('#fileInput0').removeClass('errorBorder');
      $('.bar1').addClass('bar');
      $('.ic1').removeClass('l');
      $('.ic1').addClass('labelPri');
      $('.letra').removeClass('labelE');
      $('.letra').addClass('label-char');
      fileInput0.classList.remove('changed');
  }

  function limpiarError(errorClass, inputId, inputClass, num) {
      $(`.${errorClass}`).html("").hide();
      $(`#${inputId}`).removeClass(inputClass);
      $(`.bar${num}`).addClass('bar');
      $(`.ic${num}`).removeClass('l').addClass('labelPri');
      $(`.letra${num}`).removeClass('labelE').addClass('label-char');
  }

  function mostrarError(errorClass, inputId, inputClass, num, mensaje) {
      $(`.${errorClass}`).html(`<i class="bi bi-exclamation-triangle-fill"></i> ${mensaje}`).show();
      $(`#${inputId}`).addClass(inputClass);
      $(`.bar${num}`).removeClass('bar');
      $(`.ic${num}`).addClass('l').removeClass('labelPri');
      $(`.letra${num}`).addClass('labelE').removeClass('label-char');
  }

  function primary() {
      resetearImagen();
      limpiarErrorImagen();
      $(".error1, .error2, .error3, .error4, .error5").html("").hide();
      $('#fileInput0, #utensilio').removeClass('errorBorder');
      $('#tipoU,#material').removeClass('is-invalid');
      $('.bar1, .bar2, .bar3, .bar4, .bar5').addClass('bar');
      $('.ic1, .ic2, .ic3, .ic4, .ic5').removeClass('l').addClass('labelPri');
      $('.letra, .letra2, .letra3, .letra4, .letra5').removeClass('labelE').addClass('label-char');
      $('.check').removeClass('is-invalid');
      fileInput0.classList.remove('changed');
  }

  // Funciones CRUD
  function modificar(materialU) {
      const tipoU = cambiarFormato($("#tipoU").val());
      const utensilio = cambiarFormato($("#utensilio").val());
      const material = cambiarFormato(materialU);
      const id = $('#idd').val();
      let token = $('[name="csrf_token"]').val();
    if(token) {
        console.log('Token CSRF enviado:', token);
      $.ajax({
          type: "POST",
          url: '',
          dataType: "json",
          data: { modificarINFO: 'SI', id, tipoU, utensilio, material, csrfToken: token },
          success(dato) {
            
              if (dato.mensaje.resultado === 'existe') {
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: `El utensilio <b class="fw-bold text-rojo">${utensilio}</b> con el material <b class="fw-bold text-rojo">${material}</b> ya está registrado!`,
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
                  $('.error3').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El utensilio ya está registrado!').show();
                  $('.error4').html(' <i  class="bi bi-exclamation-triangle-fill"></i> El material ya está registrado!').show();
                  $('#material').addClass('is-invalid');
                  $('#utensilio').addClass('errorBorder');
                  $('.bar3, .bar4').removeClass('bar');
                  $('.ic3, .ic4').addClass('l').removeClass('labelPri');
                  $('.letra3, .letra4').addClass('labelE').removeClass('label-char');
              } else if (dato.mensaje.resultado === 'modificado' && dato.newCsrfToken) {
                $('[name="csrf_token"]').val(dato.newCsrfToken);
                  $('.cerrar2').click();
                  
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Utensilio Modificado Exitosamente!',
                      showConfirmButton: false,
                      timer: 2500,
                      timerProgressBar: true,
                  });
                  delete mostrarU;
                  tablaUtensilios();
                  primary();
              }
          }
      });
    }
  }

  function verificarUtensilio() {
      const utensilio = cambiarFormato($("#utensilio").val());
      const material = cambiarFormato($("#material").val());
      const id = $('#idd').val();

      $.ajax({
          type: "POST",
          url: '',
          dataType: "json",
          data: { verificarUtensilios:true, id, utensilio, material},
          success(dato) {
            
              if (dato.resultado === 'existe') {
                  mostrarError('error3', 'utensilio', 'errorBorder', 3, 'El utensilio ya está registrado!');
                  mostrarError('error4', 'material', 'is-invalid', 4, 'El material ya está registrado!');
                    
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: `El utensilio <b class="fw-bold text-rojo">${utensilio}</b> con el material <b class="fw-bold text-rojo">${material}</b> ya está registrado!`,
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
                 error_utensilio = true;

              } 
              else if (dato.resultado === 'no existe') {
                 limpiarError('error4', 'material', 'is-invalid', 4);
                 limpiarError('error3', 'utensilio', 'errorBorder', 3);
                    error_utensilio = false;
              }
          }
      });
  }

  function verificarIMG(){
    let fileInput = $("#fileInput0")[0];
    let imagen = fileInput.files.length ? fileInput.files[0] : null;

    if (imagen) {
        let formData = new FormData();
        formData.append("imagen", imagen);
        formData.append("validarIMG", true);

        $.ajax({
            type: "POST",
            url: '', 
            data: formData,
            dataType: "json",
            processData: false, 
            contentType: false, 
            success(data){
                data = typeof data === 'string' ? JSON.parse(data) : data;
                
                if (
                    data.resultado === 'El archivo no es una imagen válida (JPEG, PNG)!' ||
                    data.resultado === 'La imagen no debe superar los 2MB!' ||
                    data.resultado === 'La imagen está dañada o no se puede procesar!' ||
                    data.resultado === 'No se recibió imagen'
                ) {
                    container0.innerHTML = ''; // Limpiar el contenedor
                    container0.appendChild(defaultImage); 
                    $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> ' + data.resultado + '!');
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
                        icon:'error',
                        title:data.resultado,
                        showConfirmButton:false,
                        timer:3000,
                        timerProgressBar:3000,
                    });

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
                    error_imagen = false;
                }
            }
        });
    }
}


  function modificarImagen() {
      const datos = new FormData();
      const files = $("#fileInput0")[0].files;
      const id = $('#idd').val();
      let token = $('[name="csrf_token"]').val();

      datos.append("imagen", files[0]);
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
              // Asegurar que data sea un objeto
              if (typeof data === 'string') {
                  try {
                      data = JSON.parse(data);
                  } catch (e) {
                      // Si no es JSON válido, mostrar error genérico
                      Swal.fire({
                          toast: true,
                          position: 'top-end',
                          icon: 'error',
                          title: 'Error inesperado en la respuesta del servidor.',
                          showConfirmButton: false,
                          timer: 2500,
                          timerProgressBar: true,
                      });
                      return;
                  }
              }
              // Manejo de errores de imagen dañada, tipo o tamaño
              if (
                data.mensaje.resultado === 'El archivo no es una imagen válida (JPEG, PNG)!' ||
                data.mensaje.resultado === 'La imagen no debe superar los 2MB!' ||
                data.mensaje.resultado === 'La imagen está dañada o no se puede procesar!' ||
                data.mensaje.resultado === 'No se recibió imagen'
              ) {
               container0.innerHTML = ''; 
              container0.appendChild(defaultImage); 
              $('.error1').html(' <i  class="bi bi-exclamation-triangle-fill"></i> '+data.mensaje.resultado+'');
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
                  title: data.mensaje.resultado,
                  showConfirmButton: false,
                  timer: 2500,
                  timerProgressBar: true,
                });
              }
              if (data.mensaje.resultado === 'imagen modificada' && data.newCsrfToken) {
                $('[name="csrf_token"]').val(data.newCsrfToken);
                error_imagen = false;
                $('.cerrar2').click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Imagen del Utensilio Modificado Exitosamente!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
                delete mostrarU;
                tablaUtensilios();
                resetearImagen();
                primary();
              }
          }
      });
    }
  }

  function valModificar(idd) {
      $.ajax({
          url: "",
          dataType: 'json',
          method: "POST",
          data: { modificar: 'modificar', id: idd },
          success(data) {
              if (data.resultado === "no se puede") {
                  $('#editarUtensilio').modal('hide');
                  $('#cerrar2').click();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;">
                      El Utensilio ya está registrado en el inventario de Utensilios.`,
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
              }
              if (data.resultado === "se puede") {
                  $('#editarUtensilio').modal('show');
              }
          }
      });
  }

  function valAnular() {
      $.ajax({
          url: "",
          dataType: 'json',
          method: "POST",
          data: { modificar: 'modificar', id },
          success(data) {
              if (data.resultado === "no se puede") {
                  $('#eliminaT').modal('hide');
                  $('#cerrar3').click();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
                      El tipo de utensilio está registrado a un utensilio.`,
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
              }
              if (data.resultado === "se puede") {
                  $('#borrarUtensilio').modal('show');
              }
          }
      });
  }

  // Event Listeners
  fileInput0.addEventListener('change', function() {
    chequeoImagen(); 
    verificarIMG();
  });
    let timer;

  $("#tipoU").on('change', verificarTipoU);


  $("#material").on('change', function(){
     chequeo_material()
     verificarUtensilio()
 });
   $("#utensilio").on('keyup', function(){
    chequeo_utensilio();
        clearTimeout(timer); 
         timer = setTimeout(function () {
           verificarUtensilio()
         }, 500);
 });
  
  $("#edita").on("click", function(e) {
      e.preventDefault();
      error_utensilio = false;
      error_veriTU = false;
      error_material = false;
      
      chequeo_utensilio();
      verificarTipoU();
      chequeo_material();

      
      
      if (!error_utensilio && !error_veriTU && !error_material) {
          const material = $('#material').val();
          modificar(material);
      } else {
          mostrarErrorDatos();
      }
  });
  
  $("#editarIMG").on("click", function(e) {
    e.preventDefault();

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
  
  $(".editarI").on("click", function() {
      $('.editarImagen').show(900);
      $('.editarInfo').hide(900);
  });
  
  $(".cance, .limpiar").on("click", function() {
      primary();
      $('.formIMG').trigger('reset');
      $('.editarInfo').show(900);
      $('.editarImagen').hide(900);
  });
  
  $('.cerrar2').on("click", function() {
      $('.editarInfo').show();
      $('.editarImagen').hide();
      primary();
      $('.formIMG').trigger('reset');
  });
  
  $('#borrar').click(function(e) {
    let token = $('[name="csrf_token"]').val();
    if(token){

      e.preventDefault();
      $.ajax({
          url: '',
          method: 'post',
          dataType: 'json',
          data: { id, borrar: 'borrar' , csrfToken: token},
          success(data) {
              if (data.mensaje.resultado === 'eliminado') {
                $('[name="csrf_token"]').val(data.newCsrfToken);
                  $('#cerrar3').click();
                  delete mostrarU;
                  tablaUtensilios();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: 'Utensilio Anulado Exitosamente!',
                      showConfirmButton: false,
                      timer: 2500,
                      timerProgressBar: true,
                  });
              }
          }
      });
    } 
  });

  $(document).on('click', '.informacion', function() {
      const id = this.id;
      $.ajax({
          method: "post",
          url: "",
          dataType: "json",
          data: { infoUtensilio: true, id: id },
          success(data) {
              const tabli1 = `
                  <tr>
                      <td class="">${data[0].tipo}</td>
                      
                  </tr>`;
              
              const tabli2 = `
                  <tr>
                      <td class="">${data[0].nombre}</td>
                      <td class="">${data[0].material}</td>
                      
                  </tr>`;
              
              const imag = `<img src="${data[0].imgUtensilios}" width="250" height="250" alt="Profile" class="mb-2">`;
              
              $('#info1').html(tabli1);
              $('#info2').html(tabli2);
              $('#imag').html(imag);
          }
      });
  });
  
  $(document).on('click', '.editar', function() {
      const iD = this.id;
      $.ajax({
          method: "post",
          url: "",
          dataType: "json",
          data: { infoUtensilio: true, id: iD },
          success(data) {
              if (data.resultado === 'ya no existe') {
                  $('.cerrar2').click();
                  delete mostrarU;
                  tablaUtensilios();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: '<span class="text-rojo">el utensilio fue anulado recientemente!</span>',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
              } else {
                  valModificar(data[0].idUtensilios);
                  $("#material").val(data[0].material).trigger('change');
                  $("#tipoU").val(data[0].idTipoU).trigger('change');
                  $("#utensilio").val(data[0].nombre);
                  $('#image').html(`<img src="${data[0].imgUtensilios}" align="center" width="300">`);
                  $("#idd").val(data[0].idUtensilios);
              }
          }
      });
  });
  
  $(document).on('click', '.limpiar', function() {
      const iD = $('#idd').val();
      $.ajax({
          method: "post",
          url: "",
          dataType: "json",
          data: { infoUtensilio: true, id: iD },
          success(data) {
              if (data.resultado === 'ya no existe') {
                  $('.cerrar2').click();
                  delete mostrarU;
                  tablaUtensilios();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: '<span class="text-rojo">el utensilio fue anulado recientemente!</span>',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
              } else {
                  $("#material").val(data[0].material).trigger('change');
                  $("#tipoU").val(data[0].idTipoU).trigger('change');
                  $("#utensilio").val(data[0].nombre);
                  $('#image').html(`<img src="${data[0].imgUtensilios}" align="center" width="300">`);
              }
          }
      });
  });
  
  $(document).on('click', '.borrar', function() {
      id = this.id;
      $.ajax({
          url: "",
          dataType: 'json',
          method: "POST",
          data: { infoUtensilio: 'anular', id },
          success(data) {
              if (data.resultado === 'ya no existe') {
                  $('#borrarUtensilio').modal('hide');
                  delete mostrarU;
                  tablaUtensilios();
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      title: '<span class="text-rojo">El utensilio fue anulado recientemente!</span>',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: 3000,
                  });
              } else {
                  valAnular();
                  $('.eliminarU').html(`¿Deseas anular el utensilio <b class="text-primary">${data[0].nombre}</b> con el material <b class="text-primary">${data[0].material}</b> ?`);
              }
          }
      });
  });

  function mostrarErrorDatos() {
      Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: '<span class="text-rojo">Ingrese los Datos Correctamente!</span>',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: 3000,
          width: '38%',
      });
  }
});

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