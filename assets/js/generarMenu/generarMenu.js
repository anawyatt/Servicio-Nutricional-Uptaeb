document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll('.btnHorario');
    const inputHidden = document.getElementById('horarioSeleccionado');
    const btnGenerar = document.getElementById('generar');
    const contenedorHorario = document.getElementById('tablita22');
    let seleccionado = null;
    let error_horario = true;

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            if (boton === seleccionado) {
                boton.classList.remove('active');
                seleccionado = null;
                inputHidden.value = "";
            } else {
                botones.forEach(b => b.classList.remove('active'));
                boton.classList.add('active');
                seleccionado = boton;
                inputHidden.value = boton.getAttribute('data-value');
            }
            chequeo_horario();
        });
    });

    function chequeo_horario() {
        const horarioSeleccionado = inputHidden.value;
        const errorElement = document.querySelector('.error30');

        if (horarioSeleccionado && horarioSeleccionado !== "") {
            errorElement.innerHTML = "";
            errorElement.style.display = 'none';
            contenedorHorario.classList.remove('error-border-container'); 
            
            botones.forEach(b => b.classList.remove('error-btn')); 
            
            error_horario = false; 
        } else {
            errorElement.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Seleccione un horario para el Menú.';
            errorElement.style.display = 'block';
            contenedorHorario.classList.add('error-border-container'); 
            
            const activo = document.querySelector('.btnHorario.active');
            if (!activo) {
                 botones.forEach(b => b.classList.add('error-btn'));
            } else {
                 botones.forEach(b => b.classList.remove('error-btn'));
            }
            
            error_horario = true;
        }
    }

    btnGenerar.addEventListener('click', (e) => {
        chequeo_horario();
        chequeo_cantidadPlatos();

        if (!error_horario && !error_cantidadE) {
            informacion();
        } else {
            e.preventDefault();
        }
    });

    let error_cantidadE = true;
    $("#cantPlatos2").focusout(function(){
        chequeo_cantidadPlatos();
    });
    
    $("#cantPlatos2").on('keyup', function(){
        chequeo_cantidadPlatos();
    });

    function chequeo_cantidadPlatos() {
        const chequeo = /^[1-9]\d*$/;
        const cantidadE = $("#cantPlatos2").val();
        if (chequeo.test(cantidadE) && parseInt(cantidadE) > 0) {
            $(".error20").html("");
            $(".error20").hide();
            $('#cantPlatos2').removeClass('errorBorder');
            $('.bar20').addClass('bar');
            $('.ic20').removeClass('l');
            $('.ic20').addClass('labelPri');
            $('.letra20').removeClass('labelE');
            $('.letra20').addClass('label-char');
            error_cantidadE = false;
        } else {
            $(".error20").html('<i class="bi bi-exclamation-triangle-fill"></i> Ingrese la cantidad de Platos!');
            $(".error20").show();
            $('#cantPlatos2').addClass('errorBorder');
            $('.bar20').removeClass('bar');
            $('.ic20').addClass('l');
            $('.ic20').removeClass('labelPri');
            $('.letra20').addClass('labelE');
            $('.letra20').removeClass('label-char');
            error_cantidadE = true;
        }
    }
});


//--------------------------- OBTENER ALIMENTOS, REGISTRO DE ENTRADAS Y MENUS ----------------------


function informacion(){

  let horarioComida=$('#horarioSeleccionado').val();
  let cantPlatos=$('#cantPlatos2').val(); 
console.log('datos a enviar: ', cantPlatos, horarioComida);
 $.ajax({
      url: '',
      type: 'POST',
      dataType: 'JSON',
      data: {informacionAlimentos:true, horarioComida, cantPlatos}, 
      success(data){

        if(data){
            console.log('Informacion para Generar Menus:', data);
        }
  
      }

    })
}