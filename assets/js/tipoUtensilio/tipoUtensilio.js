    
$(document).ready(function () {
    // Variables globales
    let permisos, modificarPermiso, eliminarPermiso, registrarPermiso;
    let tabla = null;
    let id = '';
    let error_tipo = false;
    let error_val = false;
    let error_tipo2 = false;

    // Inicialización
    $('#ani').hide(1000);
    $('#tipoU1').addClass('active');
    rellenar();

    // Obtener permisos
    $.ajax({
        method: 'POST',
        url: "",
        dataType: 'json',
        data: { getPermisos: 'a' },
        success(data) { permisos = data; }
    }).then(function () {
        registrarPermiso = (typeof permisos.registrar === 'undefined') ? 'disabled' : '';
        modificarPermiso = (typeof permisos.modificar === 'undefined') ? 'disabled' : '';
        eliminarPermiso = (typeof permisos.eliminar === 'undefined') ? 'disabled' : '';
        $('#enviar').attr(registrarPermiso, '');
    });

    // Función para quitar botones según permisos
    function quitarBotones() {
        if (typeof permisos.registrar == 'undefined') {
            $(".agrega").remove();
        }
        if (typeof permisos.modificar == 'undefined') {
            $(".editar").remove();
        }
        if (typeof permisos.eliminar == 'undefined') {
            $(".borrar").remove();
        }
        if (typeof permisos.eliminar == 'undefined' && typeof permisos.modificar == 'undefined') {
            $(".accion").remove();
        }
    }

    // Rellenar tabla con datos
    function rellenar() {
        $.ajax({
            method: "POST",
            url: "",
            dataType: "json",
            data: { tipoU: true },
            success(data) {
                $('#ani').show(2000);

                if (data.resultado || data.error) {
                    $('.tbody').html(`<tr><td colspan="2">${data.resultado || data.error}</td></tr>`);
                    if (tabla) tabla.clear().draw();
                    return;
                }

                let filas = data.map(row => [
                    row.tipo,
                    `<td class="text-center accion">
                        <a class="btn btn-sm btn-icon text-primary editar editar_tipo" 
                           data-bs-toggle="tooltip" title="Modificar Tipo de Utensilio" 
                           href="#" id="${row.idTipoU}">
                            <span class="btn-inner pi"><i class="bi bi-pencil icon-24 t"></i></span>
                        </a>
                        <a class="btn btn-sm btn-icon text-danger borrar" 
                           data-bs-toggle="tooltip" title="Eliminar Tipo de Utensilio" 
                           href="#" id="${row.idTipoU}">
                            <span class="btn-inner pi"><i class="bi bi-trash icon-24 t"></i></span>
                        </a>
                    </td>`
                ]);

                if (!tabla) {
                    tabla = $('.tabla2').DataTable({
                        autoWidth: false,
                        responsive: true,
                        data: filas,
                        columns: [
                            { title: "Tipos de Utensilios" },
                            { title: "Acciónes", orderable: false }
                        ]
                    });
                    tabla.on('draw.dt', quitarBotones);
                } else {
                    tabla.clear();
                    tabla.rows.add(filas);
                    tabla.draw();
                }
                quitarBotones();
            },
            error() {
                $('.tbody').html(`<tr><td colspan="2">Error al cargar los tipos de utensilios.</td></tr>`);
                if (tabla) tabla.clear().draw();
            }
        });
    }

    function danger() {
        $('.error1').html(' <i class="bi bi-exclamation-triangle-fill"></i> El tipo de utensilio ya existe!');
        $(".error1").show();
        $('.tipo').addClass('errorBorder');
        $('.bar1').removeClass('bar');
        $('.ic1').addClass('l');
        $('.ic1').removeClass('labelPri');
        $('.letra').addClass('labelE');
        $('.letra').removeClass('label-char');
    }

    function primary() {
        $(".error1").html("");
        $(".error1").hide();
        $('.tipo').removeClass('errorBorder');
        $('.bar1').addClass('bar');
        $('.ic1').removeClass('l');
        $('.ic1').addClass('labelPri');
        $('.letra').removeClass('labelE');
        $('.letra').addClass('label-char');
    }

    function danger1() {
        $(".error2").show();
        $('.error2').html(' <i class="bi bi-exclamation-triangle-fill"></i> El tipo de utensilio ya existe!');
        $('.tipo2').addClass('errorBorder');
        $('.bar2').removeClass('bar');
        $('.ic2').addClass('l');
        $('.ic2').removeClass('labelPri');
        $('.letra2').addClass('labelE');
        $('.letra2').removeClass('label-char');
    }

    function primary2() {
        $(".error2").html("");
        $(".error2").hide();
        $('.tipo2').removeClass('errorBorder');
        $('.bar2').addClass('bar');
        $('.ic2').removeClass('l');
        $('.ic2').addClass('labelPri');
        $('.letra2').removeClass('labelE');
        $('.letra2').addClass('label-char');
    }

    function val_tipo() {
        var chequeo = /^[a-zA-ZÀ-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{3,}$/;
        var nombre = $("#tipo").val().trim();
        var errorContainer = $(".error1");
        var tipoInput = $('.tipo');
        var bar1 = $('.bar1');
        var ic1 = $('.ic1');
        var letra = $('.letra');
    
        if (chequeo.test(nombre)) {
            errorContainer.html("").hide();
            tipoInput.removeClass('errorBorder');
            bar1.addClass('bar');
            ic1.removeClass('l').addClass('labelPri');
            letra.removeClass('labelE').addClass('label-char');
            return true;
        } else {
            errorContainer.html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese el tipo de utensilio, solo Caracteres!').show();
            tipoInput.addClass('errorBorder');
            bar1.removeClass('bar');
            ic1.addClass('l').removeClass('labelPri');
            letra.addClass('labelE').removeClass('label-char');
            return false;
        }
    }

    function val_tipo2() {
        var chequeo = /^[a-zA-ZÀ-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{3,}$/;
        var nombre = $("#tipo2").val();
        
        if (chequeo.test(nombre)) {
            primary2();
            return true;
        } else {
            $(".error2").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese el tipo de utensilio, solo Caracteres!');
            $(".error2").show();
            $('.tipo2').addClass('errorBorder');
            $('.bar2').removeClass('bar');
            $('.ic2').addClass('l');
            $('.ic2').removeClass('labelPri');
            $('.letra2').addClass('labelE');
            $('.letra2').removeClass('label-char');
            error_tipo2 = true;
            return false;
        }
    }

    function capitalizarYEliminarEspaciosExtras(texto) {
        const palabras = texto.split(" ");
        let palabrasFormateadas = [];
    
        for (let i = 0; i < palabras.length; i++) {
            if (palabras[i].trim() !== "") {
                palabrasFormateadas.push(palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1).toLowerCase());
            }
        }
        return palabrasFormateadas.join(" ");
    }
    
    function validar_tipos(callback) {
        const tipo = $("#tipo").val().trim();
    
        if (!val_tipo()) {
            error_tipo = true;
            callback(false);
            return;
        }
    
        $.ajax({
            url: "",
            method: "POST",
            dataType: "json",
            data: { validar: true, tipo },
            success(data) {
                if (data.resultado === 'Ya existe') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: `El tipo de utensilio <b class="fw-bold text-rojo">${tipo}</b> ya está registrado, ingrese otro tipo!`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    danger();
                    error_val = true;
                    callback(false);
                } else {
                    primary();
                    error_val = false;
                    callback(true);
                }
            },
            error() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al validar el tipo de utensilio. Inténtelo de nuevo.',
                });
                callback(false);
            }
        });
    }

    function validar_tipos2(callback) {
        const tipo2 = $("#tipo2").val().trim();

        if (!val_tipo2()) {
            error_tipo2 = true;
            callback(false);
            return;
        }

        $.ajax({
            url: "",
            method: "POST",
            dataType: "json",
            data: { validar: true, tipo: tipo2 },
            success(data) {
                if (data.resultado === 'Ya existe') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: `El tipo de utensilio <b class="fw-bold text-rojo">${tipo2}</b> ya está registrado, ingrese otro tipo!`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    danger1();
                    error_val = true;
                    callback(false);
                } else {
                    primary2();
                    error_val = false;
                    callback(true);
                }
            },
            error() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al validar el tipo de utensilio. Inténtelo de nuevo.',
                });
                callback(false);
            }
        });
    }

    function registrar() {
        const tipo = capitalizarYEliminarEspaciosExtras($("#tipo").val());
        $("#registrar").prop("disabled", true);
        let token = $('[name="csrf_token"]').val();
        if(token){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "",
                    data: { registrar: true, tipo, csrfToken: token },
                    success(data) {
                        if (data.mensaje.resultado === 'exitoso' && data.newCsrfToken) {
                            $('.limpiar').click();
                            $('#cerrar').click();
                            $('[name="csrf_token"]').val(data.newCsrfToken);
                            
                            primary();
                            delete mostrar;
                            rellenar();
                            
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: `El tipo de utensilio ha sido <b class="text-primary fw-bold">${tipo}</b> Registrado Exitosamente!`,
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                            });
                        } else if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error || 'Hubo un error inesperado.',
                            });
                        }
                    },
                    complete() {
                        $("#registrar").prop("disabled", false);
                    }
                });
        }
    }
    

    function modificar() {
        $("#modificar").prop("disabled", true);
        const tipo2 = capitalizarYEliminarEspaciosExtras($("#tipo2").val());
        let token = $('[name="csrf_token"]').val();
        if(token){
        $.ajax({
            type: "post",
            url: "",
            dataType: 'json',
            data: { tipo2, id , csrfToken: token},
            success(data) {
                if (data.resultado === 'ya no existe') {
                    $('#cerrar2').click();
                    delete mostrar;
                    rellenar();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '<span class="text-rojo">El tipo de utensilio fue eliminado recientemente!</span>',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                } else if (data.resultado === 'error2') {
                    danger1();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'El tipo de utensilio <b class="fw-bold text-rojo">' + tipo2 + '</b> ya esta registrado, ingrese otro tipo!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                } else {
                    $('#cerrar2').click();
                    primary2();
                    delete mostrar;
                    rellenar();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'El tipo de utensilio <b class="text-primary fw-bold">' + tipo2 + '</b> fue Modificado Exitosamente!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                    });
                }
            },
            complete() {
                $("#modificar").prop("disabled", false);
            }
        });
        }
    }

    function valModificar() {
        $.ajax({
            url: "",
            dataType: 'json',
            method: "POST",
            data: { modificar: 'modificar', id },
            success(data) {
                if (data.resultado === "no se puede") {
                    $('#editarTipos').modal('hide');
                    $('#cerrar2').click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: `<b class="fw-bold text-rojo">No se puede Modificar!</b><b style="font-size:13px!important;"> 
                        El tipo de utensilio ya está esta asociado a un utensilio.`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                }

                if (data.resultado === "se puede") {
                    $('#editarTipos').modal('show');
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
                    $('#borrarTipos').modal('hide');
                    $('#cerrar3').click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: `<b class="fw-bold text-rojo">No se puede Anular!</b><b style="font-size:13px!important;">
                        El tipo de Utensilio está registrado a un utensilio. `,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                }
                if (data.resultado === "se puede") {
                    $('#borrarTipos').modal('show');
                }
            }
        });
    }

    $("#tipo").focusout(val_tipo);
    $("#tipo").on('keyup', function() {
        validar_tipos(function(){});
}   );

    $("#registrar").on("click", function (e) {
        e.preventDefault();
        error_tipo = false;
        error_val = false;
        
        if (!val_tipo()) {
            error_tipo = true;
        }
        
        if (!error_tipo) {
            validar_tipos(function (esValido) {
                if (esValido && !error_tipo && !error_val) {
                    registrar();
                } else {
                    mostrarErrorDatos();
                }
            });
        } else {
            mostrarErrorDatos();
        }
    });

    function mostrarErrorDatos() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '<span class="text-rojo">Ingrese los Datos Correctamente!</span>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            width: '38%',
        });
    }

    $("#tipo2").focusout(val_tipo2);
    $("#tipo2").on('keyup', function() {
        val_tipo2();
        validar_tipos2(function(){});
    });

    $("#editar").on("click", function (e) {
        e.preventDefault();
        error_tipo2 = false;
        val_tipo2();

        if (!error_tipo2) {
            modificar();
        } else {
            mostrarErrorDatos();
        }
    });

    // Eliminar
    $('#borrar').click((e) => {
        e.preventDefault();
        let token = $('[name="csrf_token"]').val();
        $("#borrar").prop("disabled", true);
        if (token) {
        
        $.ajax({
            url: '',
            method: 'post',
            dataType: 'json',
            data: { eliminar: 'borrar', id, csrfToken: token},
            success(data) {
                $('#cerrar3').click();
                delete mostrar;
                rellenar();
    
                if (data.resultado === 'ya no existe') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '<span class="text-rojo">El tipo de utensilio fue eliminado recientemente!</span>',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: 3000,
                    });
                } else if (data.resultado === 'Tipo Utensilio esta asociado a utensilios') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Hay utensilios relacionados con este tipo de utensilio.',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                    });
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tipo de utensilio Eliminado Exitosamente!',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                    });
                }
            },
            complete() {
                $("#borrar").prop("disabled", false);
            }
        });
    }
    });
    

    // Eventos delegados
    $(document).on('click', '.limpiar', primary);
    $(document).on('click', '.resetear', function () {
        id = $('#idd').val();
        $.ajax({
            method: "post",
            url: "",
            dataType: "json",
            data: { info: true, id: id },
            success(data) {
                primary2();
                $(".tipo2").val(data[0].tipo);
            }
        });
    });

    $(document).on('click', '.editar', function () {
        id = this.id;
        $.ajax({
            method: "post",
            url: "",
            dataType: "json",
            data: { info: true, id: id },
            success(data) {
                valModificar();
                $(".tipo2").val(data[0].tipo);
                $('#idd').val(data[0].idTipoU);
            }
        });
    });

    $(document).on('click', '.borrar', function () {
        id = this.id;
        $.ajax({
            url: "",
            dataType: 'json',
            method: "POST",
            data: { info: true, id: id },
            success(data) {
                valAnular();
                $('.eliminarR').html('¿Deseas anular el tipo de utensilio <b class="text-primary">' + data[0].tipo + '</b> ?');
            }
        });
    });

      

    // Quitar botones después de un tiempo
    setTimeout(quitarBotones, 500);
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