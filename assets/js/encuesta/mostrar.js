
      $('#encuestadoSelect').change(function() {
        encuestado = $('#encuestadoSelect').val();
         if (encuestado == 6) {
        $('#encuestadoOtro').removeClass('ocultar');
        }else{
         $('#encuestadoOtro').addClass('ocultar');
        }

      });

      $('#guardarNotas').click(function () {
        accion = $('#accionSelect').val();
        encuestado = $('#encuestadoSelect').val();
        especificacion = $('#especificacionAccion').val();
        justificacion = $('#justificacionAccion').val();
        notas = $('#notasAdicionales').val();
        idaplicar = $('#idaplicar').val();
        encuestadoOtro = null;
        tema = $('#temaSelect').val();
        sostenimiento = $('#sostenimientoSelect').val();

        if (encuestado == 6) {
        $('#encuestadoOtro').removeClass('ocultar');
        encuestadoOtro = $('#encuestadoOtro').val();
        }

        var ruta = base_url+"Administrador/guardarNotas";
        $.ajax({
          url: ruta,
          type: 'POST',
          data: {accion:accion, especificacion:especificacion, justificacion:justificacion,notas:notas, encuestado:encuestado, encuestadoOtro:encuestadoOtro, tema:tema, sostenimiento:sostenimiento, idaplicar:idaplicar},
          success : function(data) {
           bootbox.alert('Se guardaron correctamente las observaciones', function(){
            window.location.href = base_url+"encuesta/"+idaplicar;
          });
         }
       });


      });
