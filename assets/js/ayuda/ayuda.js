$(document).ready(function() {
    
    // Ocultar los ítems al cargar la página
    $('#contenedor-items .item').hide();
    
    const $noResultsMessage = $('#no-results-message');

    // Cambiamos el evento de 'keyup' a 'input'
    $('#buscar').on('input', function() { // <--- CAMBIO AQUÍ

        var searchValue = $(this).val().toLowerCase();
        
        // 1. Ocultar el mensaje (Añadir la clase d-none)
        $noResultsMessage.addClass('d-none'); // Esconde el mensaje

        // Esta sección es la que regresa al estado inicial
        if (searchValue.length === 0) {
            $('.cards').fadeIn();
            $('#contenedor-items .item').fadeOut(); 
            return; // Detiene la función
        } else {
            $('.cards').fadeOut();
        }

        let resultsFound = false; 

        // Bucle de búsqueda
        $('#contenedor-items .item').each(function() {
            var titleText = $(this).find('h6').text().toLowerCase();
            
            if (titleText.indexOf(searchValue) > -1) {
                $(this).fadeIn();
                resultsFound = true; 
            } else {
                $(this).fadeOut();
            }
        });
        
        // 2. Mostrar el mensaje solo si NO se encontró NADA
        if (!resultsFound) {
            // Eliminar d-none para que se aplique d-flex y se muestre
            $noResultsMessage.removeClass('d-none'); 
        }
    });
});