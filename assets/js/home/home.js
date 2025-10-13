
 //Calendario

function calen(menus) {
    var calendarEl = document.getElementById('calendar');
  var eventos = [];

  menus.forEach(function (data) {

                 let fechaM = new Date(data.feMenu);
                 let dia = (fechaM.getDate() + 1).toString().padStart(2, '0');
                 let mes = (fechaM.getMonth() + 1).toString().padStart(2, '0');
                 let anio = fechaM.getFullYear();

                 let fechaFormateadaM = `${dia}-${mes}-${anio}`;
      
       let hora;
      if (data.horarioComida == 'Desayuno') {
        hora ='07:30:00'
      }
      else if (data.horarioComida == 'Almuerzo') {
         hora ='12:00:00';
      }
      else if (data.horarioComida == 'Merienda') {
         hora ='16:00:00';
      }
      else if (data.horarioComida == 'Cena') {
         hora ='19:00:00';
      }
      var inicioEvento = data.feMenu + 'T' + hora;
      var horaFormateada = formatearHora(hora);
      let titulo;

      if(data.nomEvent==null && data.descripEvent==null){
        titulo='<strong class ="azul5 text-center" >Menú - '+ data.horarioComida + '</strong>'
      }
      else{
        titulo='<strong class ="azul5 text-center" >Evento - '+ data.horarioComida + '</strong>'
      }
     
        eventos.push({
          title: titulo ,
          start: inicioEvento,
          extendedProps: {
            fecha: fechaFormateadaM,
            hora: horaFormateada,
            evento: data.nomEvent,
            descripcionEvento: data.descripEvent,
            cantEstudiantes: data.cantPlatos,
            menu: data.descripcion,
          }
       });
        });

    // Función para formatear la hora que se muestra en el pulsor de 24 horas a 12 horas
    function formatearHora(hora) {
      const [hour, minutes] = hora.split(':');
      const amPm = hour >= 12 ? 'PM' : 'AM';
      const formaHour = (hour % 12) || 12;
      return `${formaHour}:${minutes} ${amPm}`;
    }

      var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es', // Establecer el idioma a español
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Agenda'
      },
      headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      navLinks: true,
      businessHours: true,
      editable: true,
      selectable: true,
      dayMaxEvents: true,

      eventContent: function (a) {
        // hora formateada para mostrar en calendario
        var formaTime = a.event.start.toLocaleTimeString('en-US', {
          hour: 'numeric',
          minute: '2-digit',
          hour12: true
        });

        // contenido del evento del calendario 
        var content = '<div class="fc-content">';
        content += '<span class="blue-dot"></span>';
        content += formaTime + ' ' + a.event.title;
        content += '</div>';

        return {domNodes: $(content) };
      },

      eventMouseEnter: function (info) {
        var popoverContent = '';
         popoverContent += '<strong class ="azul5">' + 'Fecha: ' + '</strong>' + info.event.extendedProps.fecha + '<br>';
         popoverContent += '<strong class ="azul5">' + 'Hora: ' + '</strong>' + info.event.extendedProps.hora + '<br>';
         popoverContent += '<hr>';
        if(info.event.extendedProps.evento != null && info.event.extendedProps.descripcionEvento != null){
        popoverContent += '<strong class ="azul5">' + 'Evento: ' + '</strong>' + info.event.extendedProps.evento + '<br>';
        popoverContent += '<strong class ="azul5">' + 'Descripción: ' + '</strong>' + info.event.extendedProps.descripcionEvento + '<br>';
        popoverContent += '<hr>';
        }

        popoverContent += '<strong class ="azul5">' + 'Menu: '+ '</strong>'  + info.event.extendedProps.menu + '<br>';
        popoverContent += '<strong class ="azul5">' + 'Cantidad de Platos: ' + '</strong>' + info.event.extendedProps.cantEstudiantes + '<br>';
        
        $(info.el).popover({
          title: info.event.title,
          content: popoverContent,
          trigger: 'hover',
          placement: 'auto',
          container: 'body',
          html: true
        });

        $(info.el).popover('show');
      },

      eventMouseLeave: function (info) {
        $(info.el).popover('dispose');
      },

      events: eventos,

      eventClick: function (info) {
        console.log(info);
        console.log(info.event.title);
        console.log(info.event.start);
        console.log(info.event.extendedProps.descripcion);
      },
    });

    calendar.render();
  }

function obtenerDatosParaMenu() {
  $.ajax({
    url: '', 
    type: 'POST',
    dataType: 'JSON',
    data: { mostrar9: true },
    success: function (data) {
      calen(data);
    }
  });
}



$(document).ready(function () {
  obtenerDatosParaMenu();
});

////------------- CANTIDAD ------------------------

cantEstudiantes()
cantMenus()
cantEventos()
cantAlimentos()
cantUtensilios()

     function cantEstudiantes(){
          $.ajax({
              type: "POST",
              url: '',
              dataType: "json",
              data:{
              mostrar1:true
              },
              success(data){
              $('.estudianteC').html(data[0].cantidad);
          }
        })
    }

    function cantMenus(){
          $.ajax({
              type: "POST",
              url: '',
              dataType: "json",
              data:{
              mostrar3:true
              },
              success(data){
              $('.menuC').html(data[0].cantidad);
          }
        })
    }


    function cantEventos(){
          $.ajax({
              type: "POST",
              url: '',
              dataType: "json",
              data:{
              mostrar4:true
              },
              success(data){
              $('.eventoC').html(data[0].cantidad);
          }
        })
    }

    function cantAlimentos(){
          $.ajax({
              type: "POST",
              url: '',
              dataType: "json",
              data:{
              mostrar5:true
              },
              success(data){
              $('.alimentoC').html(data[0].cantidad);
          }
        })
    }


    function cantUtensilios(){
          $.ajax({
              type: "POST",
              url: '',
              dataType: "json",
              data:{
              mostrar6:true
              },
              success(data){
              $('.utensilioC').html(data[0].cantidad);
          }
        })
    }

// ----------------- GRAFICO DE ALIMENTOS -----------------

alimentos();
function alimentos() {
  $.ajax({
    url: '',
    type: 'POST',
    dataType: 'JSON',
    data: { mostrar8: true },
    success(response) {
      var tipo = [];
      var cantidad = [];

      if (response.length > 0) {
        response.forEach(fila => {
          if (fila.cantidad != 0) {
            tipo.push(fila.horarioComida);
            cantidad.push(fila.cantidad);
          }
        });
      }
      circulo(tipo, cantidad);
    }
  });
}

//----------------------------------------------------------------

function circulo(tipo, cantidad) {
      // Preparar los datos del gráfico en el formato requerido por ECharts
      var chartData = tipo.map((t, index) => {
        return {
          value: cantidad[index],
          name: t
        };
      });

      // Opciones del gráfico
      var options = {
        tooltip: {
          trigger: 'item'
        },
        legend: {
          top: '5%',
          left: 'center'
        },
        series: [{
          name: ' Menus',
          type: 'pie',
          radius: ['40%', '70%'],
          avoidLabelOverlap: false,
          label: {
            show: false,
            position: 'center'
          },
          emphasis: {
            label: {
              show: true,
              fontSize: '18',
              fontWeight: 'bold'
            }
          },
          labelLine: {
            show: false
          },
          data: chartData
        }]
      };

      // Inicializar el gráfico
      var chart = echarts.init(document.querySelector("#trafficChart"));

      // Asignar opciones al gráfico
      chart.setOption(options);

      // Cambiar colores
      var customColors = ['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#427dc', '#001a51', '#049ff9', '#a2c8de', '#3665b6'];
      chart.setOption({
        series: [{
          itemStyle: {
            color: function(params) {
              return customColors[params.dataIndex % customColors.length];
            }
          }
        }]
      });
    }

    // Llama a la función alimentos para cargar y mostrar el gráfico
    document.addEventListener("DOMContentLoaded", alimentos);


$('#h1').addClass('active');


//---------------- GRAFICO ASISTENCIAS ------------------
document.addEventListener("DOMContentLoaded", () => {
  function grafico(horario, fecha, cantidad) {
    // Extraemos todas las fechas únicas y horarios únicos
    const uniqueDates = [...new Set(fecha)];
    const uniqueHorarios = [...new Set(horario)];

    // Inicializamos un objeto para almacenar las cantidades por fecha y horario
    const dataByHorario = uniqueHorarios.reduce((acc, h) => {
      acc[h] = Array(uniqueDates.length).fill(0);
      return acc;
    }, {});

    // Llenamos el objeto con las cantidades correspondientes
    fecha.forEach((f, i) => {
      const dateIndex = uniqueDates.indexOf(f);
      const horarioName = horario[i];
      dataByHorario[horarioName][dateIndex] += cantidad[i];
    });

    // Convertimos el objeto en una estructura que ApexCharts puede usar
    const series = uniqueHorarios.map(horarioName => ({
      name: horarioName,
      data: dataByHorario[horarioName]
    }));

    new ApexCharts(document.querySelector("#reportsChart"), {
      series: series,
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: false
        },
      },
      xaxis: {
        categories: uniqueDates,
        type: 'datetime',
      },
      yaxis: {
        title: {
          text: 'Cantidad'
        }
      },
      tooltip: {
        x: {
          format: 'dd/MM/yy'
        },
      },
      plotOptions: {
        bar: {
          horizontal: false,
        },
      },
      fill: {
        opacity: 1
      },
      legend: {
        position: 'top',
        horizontalAlign: 'left',
        offsetX: 40
      },
      colors:['#0662c5', '#5fc1ff', '#049ff9', '#201db8', '#266dbe', '#427dc', '#001a51', '#049ff9', '#a2c8de', '#3665b6'], // Aquí defines tus colores personalizados
    }).render();
  }

  function asistencias() {
    $.ajax({
      url: '', // Cambia esto a la URL correcta de tu backend PHP
      type: 'POST',
      dataType: 'JSON',
      data: { mostrar7: true },
      success(data) {
        var horario = [];
        var cantidad = [];
        var fecha = [];

        if (data.length > 0) {
          data.forEach(fila => {
            if (fila.cantidad != 0) {
              horario.push(fila.horarioComida);
              cantidad.push(fila.cantidad);
              fecha.push(fila.fecha);
            }
          });
        }
      
        grafico(horario, fecha, cantidad);
      }
    });
  }

  asistencias();
});
