
     $.ajax({
          type: "post",
          url: '',
          dataType: 'json',
          data: {
              inactividad:true
          },
          success: function (data) {
            let n=1800;
             var id=window.setInterval(function(){
             document.onmousemove=function(){
                n=1800
             };
                n--;
             if (n == -2) {
                location.href=data.url;
             }
             },1200);
          }
      });
