$(document).ready(function() {
    // Ocultar todos los elementos al cargar la página
    $('#contenedor-items .item').hide();

    $('#buscar').on('keyup', function() {
        
        var searchValue = $(this).val().toLowerCase();  // Convertir la entrada a minúsculas

        // Si el valor de búsqueda está vacío, ocultar todos los elementos
        if (searchValue.length === 0) {
            $('.cards').fadeIn();
            $('#contenedor-items .item').fadeOut();  // Ocultar todos los elementos
            return;  // Salir de la función para evitar procesar más
        }else{
            $('.cards').fadeOut();
        }

        // Filtrar los elementos según la búsqueda
        $('#contenedor-items .item').each(function() {
            // Comprobar si el texto en el título coincide con el valor ingresado
            var titleText = $(this).find('h6').text().toLowerCase();
            
            // Mostrar u ocultar los elementos en función de la coincidencia
            if (titleText.indexOf(searchValue) > -1) {
                $(this).fadeIn();  // Mostrar el elemento si coincide
            } else {
                $(this).fadeOut();  // Ocultar el elemento si no coincide
            }
        });
    });
});