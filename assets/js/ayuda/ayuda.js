$(document).ready(function() {
    
    $('#contenedor-items .item').hide();

    $('#buscar').on('keyup', function() {
        
        var searchValue = $(this).val().toLowerCase();

        if (searchValue.length === 0) {
            $('.cards').fadeIn();
            $('#contenedor-items .item').fadeOut(); 
            return; 
        } else {
           
            $('.cards').fadeOut();
        }

       
        $('#contenedor-items .item').each(function() {
            var titleText = $(this).find('h6').text().toLowerCase();
            
            if (titleText.indexOf(searchValue) > -1) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    });
});