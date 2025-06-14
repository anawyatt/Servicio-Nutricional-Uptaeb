
     $.ajax({
          type: "POST",
          url: '',
          dataType: 'json',
          data: {
              descuentoAlimentos:true
          },
          success: function (data) {
            console.log(data.info);
          }
      });
