$(document).ready(function () {
  let str = $("#itxt_idpreguntas").val();
  array_ids = str.split(",");
  array_ids_ok = [];

  for (var i = 0; i < array_ids.length; i++) {
    let array_aux = new Object();
    let todo = array_ids[i];
    let arr_todo = todo.split("/");
    let idpregunta = arr_todo[0];
    let tipo = arr_todo[1];
    array_aux["tipo"] = tipo;
    array_aux["idpregunta"] = idpregunta;
    array_aux["valores"] = [];
    array_aux["valores_string"] = '';
    array_ids_ok.push(array_aux);
  }


  let array_aux_file = new Object();
  array_aux_file["tipo"] = 'archivo';
  array_aux_file["archivo"] = '';
  array_ids_ok.push(array_aux_file);

});

$('#ifile_aplicar').change(function() {
 //console.log(this);
 var input = this;
 if (input.files && input.files[0]) {
 var file = input.files[0];
 var fileType = file.type;

   if ((fileType== 'application/pdf' || fileType== 'image/jpeg' || fileType== 'image/png' || fileType== 'image/jpg') && file.size<10000000) {
     pdffile_url=URL.createObjectURL(file);

         if (fileType.search('application/vnd')==0 ) {
           $('#image_aplicar').attr('src', '');
         }
         else {
           if (fileType.search('application/msword')==0 ) {
             $('#image_aplicar').attr('src', '');
           }
           else {
             $('#image_aplicar').attr('src', pdffile_url);
           }
         }
   }
   else {
     $('#ifile_aplicar').val("");
     $('#image_aplicar').attr('src', '');
     Helpers.alert("El formato del archivo seleccionado no está permitido o excede el tamaño máximo permitido (10MB), por favor seleccione otro.", "error");
   }
 }
});

$(document).on('blur','.textarea_blur', function(e) {
  e.preventDefault();
  e.stopImmediatePropagation(); // evita que se ejecute 2 veces el evento

  let idpregunta = $(this).data('idpregunta');
  let valor = $(this).val();

  for (var i = 0; i < array_ids_ok.length; i++) {
    if((array_ids_ok[i]['tipo'] == 1) || (array_ids_ok[i]['tipo'] == '1')){ // sólo textarea
      if(array_ids_ok[i]['idpregunta'] == idpregunta){
        array_ids_ok[i]['valores'] = valor;
      }
    }
  }

  // console.info("array_ids_ok final textarea");
  // console.info(array_ids_ok);

});


$(document).on('change','.checkbox_change',function(e) {
     e.preventDefault();
     e.stopImmediatePropagation(); // evita que se ejecute 2 veces el evento

     let idpregunta = $(this).data('idpregunta');
     idpregunta = String(idpregunta);

     let valor = $(this).val();

     // console.info("idpregunta: "+idpregunta);

     // console.info("array_ids");
     // console.info(array_ids);

     // console.info("array_ids_ok");
     // console.info(array_ids_ok);


     let index =  array_ids.indexOf(idpregunta);
     // console.info("index: "+index);


     /*
     let index_ok =  array_ids_ok.indexOf(idpregunta);
     console.info("index_ok: "+index_ok);
     */

      // var arr = $("[name="+idpregunta+"]").map(function(){
      //    return $(this).val();
      //  }).get();
      //  console.log(arr.length);
      //  if (arr.length == 2) {
      //
      //  }
       // let valor = arr.join('/');

     if($(this).is(":checked")) {
        /*
        let valor = $(this).val();
        alert("idpregunta: "+idpregunta);
        alert("valor: "+valor);
        let str_concat = idpregunta+'-'+valor;

        let actual = $("#itxt_idpregunta_"+idpregunta).val();
        let nuevo = actual+'/'+str_concat;
        $("#itxt_idpregunta_"+idpregunta).val(nuevo);
        */



        let array_aux = [];
        for (var i = 0; i < array_ids_ok.length; i++) {
          if(array_ids_ok[i]['idpregunta'] == idpregunta){
            array_aux['idpregunta'] = idpregunta;
            array_aux['valor'] = valor;
            if (array_ids_ok[i]['tipo']==3) {
                  array_ids_ok[i]['valores'].splice(0);
                  array_ids_ok[i]['valores'].push(array_aux);
            }
            else {
              array_ids_ok[i]['valores'].push(array_aux);
            }

          }
        }

     }else{
       for (var i = 0; i < array_ids_ok.length; i++) {
         if(array_ids_ok[i]['idpregunta'] == idpregunta){

           for (var j = 0; j < array_ids_ok[i]['valores'].length; j++) {
             if(array_ids_ok[i]['valores'][j]['valor'] == valor){
               array_ids_ok[i]['valores'].splice(j);
               // console.info(array_ids_ok);
             }
           }


           // array_aux['idpregunta'] = idpregunta;
           // array_aux['valor'] = valor;

           // array_ids_ok[i]['valores'].splice(array_aux);


         }
       }
     }

     // console.info("array_ids_ok final");
     // console.info(array_ids_ok);
});


$("#btn_encuesta_guardar").click(function(e){
  e.preventDefault();
  if(!Aplicar.validar()){
      Helpers.alert("Complemente la información faltante", "error");
  }else{

    Aplicar.guardar();
  }
});


  let Aplicar = {

    validar : () => {

      $('.requerido').each(function(i, elem){
        // console.log(elem.type);
        switch (elem.type) {
          case "textarea":
            $(elem).css({'border':'1px solid rgb(169, 169, 169)'});
          break;
          case "checkbox":
            $('#label_'+elem.name).html('');
          break;
          case "select-one":
            $('#label_'+elem.name).html('');
          break;
        }
      });

      let error = 0;
      let arr_respuestas = [];
      let array_preguntas = [];
      $('.requerido').each(function(i, elem){
        let idpregunta = $(elem).data('idpregunta');

        if($("input[type='textarea']") || $("input[type='text']")){
          i++;
          if($("#textarea"+i).data('tamanio') != undefined && $("#textarea"+i).val().length > $("#textarea"+i).data('tamanio')){
            $("#span"+i).html("El texto no puede ser mayor a "+$("#textarea"+i).data('tamanio')+" carateres");
            error++;
          }
        }

          switch (elem.type) {
            case "textarea":
            if($(elem).val() == ''){
              $(elem).css({'border':'1px solid red'});
              error++;
            }  else {
              $('#label_'+elem.name).html('');
            }
            break;
            case "checkbox":
              // let idpregunta = $(elem).data('idpregunta');

                if(array_preguntas.includes(idpregunta)){
                  // console.log("if includes");
                }else{
                  array_preguntas.push(idpregunta);
                  // console.log("else includes");
                  if(!$("input[name="+elem.name+"]:checked").val()) {
                      $('#label_'+elem.name).html('seleccione <br />');
                      error++;
                  } else {
                    $('#label_'+elem.name).html('');
                  }
                }

            break;
            case "radio":
              // let idpregunta = $(elem).data('idpregunta');

                if(array_preguntas.includes(idpregunta)){
                  // console.log("if includes");
                }else{
                  array_preguntas.push(idpregunta);
                  // console.log("else includes");
                  if(!$("input[name="+elem.name+"]:checked").val() && $("input[name="+elem.name+"]").data('idpregunta') != 26 && $("input[name="+elem.name+"]").data('idpregunta') != 28 ) {
                      $('#label_'+elem.name).html('seleccione <br />');
                      error++;
                  } else {
                    $('#label_'+elem.name).html('');
                  }
                }

            break;
            case "select-one":
              // let idpregunta = $(elem).data('idpregunta');

                if(array_preguntas.includes(idpregunta)){
                  // console.log("if includes");
                }else{
                  array_preguntas.push(idpregunta);
                  if($(elem).val() =="0") {
                      $('#label_'+elem.name).html('seleccione <br />');
                      error++;
                  } else {
                    $('#label_'+elem.name).html('');
                  }
                }

            break;
            case "text":
            if($(elem).val() == ''){
              $(elem).css({'border':'1px solid red'});
              error++;
            } else {
              $(elem).css({'border':'1px solid #ccc '});
            }
            break;

          }

        });
        if(error > 0){
          return false;
        }else{
          return true;
        }
    },

    guardar : () => {
      // console.info("Para enviar");
      // console.info(array_ids_ok);
      for (var i = 0; i < array_ids_ok.length; i++) {
          let valores = array_ids_ok[i]['valores'];
          // console.info("valores");
          // console.info(valores);
          // let valores_ok = JSON.stringify(valores);
          // array_ids_ok[i]['valores'] = valores_ok;

          if((array_ids_ok[i]['tipo'] == 2) || (array_ids_ok[i]['tipo'] == '2')){ // sólo checkbox
            let string_ok = '';
            for (var j = 0; j < valores.length; j++) {
              // console.info("valores[j]['valor']");
              // console.info(valores[j]['valor']);
              let valor = valores[j]['valor'];
              // console.info("valor: "+valor);
              string_ok = string_ok+valor+'/';
              // array_ids_ok[i]['valores'][j] = JSON.stringify(array_ids_ok[i]['valores'][j]);
              // Object.assign({}, array_ids_ok[i]['valores'][j]);
              // $.extend({}, array_ids_ok[i]['valores']);
              // var arr = array_ids_ok[i]['valores'];
              // var obj = _.extend({}, a);
              // Object.setPrototypeOf(arr, Object.prototype); // now no longer an array, still an object
              // console.log(obj);
            }
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = string_ok;
            $("#itxt_aplicar_idpregunta_"+array_ids_ok[i]['idpregunta']).val(string_ok);
          }

          if((array_ids_ok[i]['tipo'] == 3) || (array_ids_ok[i]['tipo'] == '3')){ // sólo checkbox
            let string_ok = '';
            for (var j = 0; j < valores.length; j++) {
              let valor = valores[j]['valor'];
              string_ok = string_ok+valor+'/';
            }
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = string_ok;
            $("#itxt_aplicar_idpregunta_"+array_ids_ok[i]['idpregunta']).val(string_ok);
          }

          if((array_ids_ok[i]['tipo'] == 4) || (array_ids_ok[i]['tipo'] == '4')){ // sólo select
            let string_ok = '';
            for (var j = 0; j < valores.length; j++) {
              let valor = valores[j]['valor'];
              string_ok = string_ok+valor+'/';
            }
            string_ok = string_ok.substring(0, string_ok.length - 1);
            array_ids_ok[i]['valores_string'] = string_ok;
            $("#itxt_aplicar_idpregunta_"+array_ids_ok[i]['idpregunta']).val(string_ok);
          }

          /*
          for (var j = 0; j < array_ids_ok[i]['valores'].length; j++) {
            if(array_ids_ok[i]['valores'][j]['valor'] == valor){
              array_ids_ok[i]['valores'].splice(j);
            }
          }
          */
      }

      var file_data = $('.image').prop('files')[0];
      if(file_data == undefined) {
        Helpers.alert("Seleccione archivo", "error");
      }else{
        /*
        var form_data = new FormData();
        form_data.append('file', file_data);
        console.info("form_data");
        console.info(form_data);
        for (var m = 0; m < array_ids_ok.length; m++) {
          if(array_ids_ok[m]['tipo'] == 'archivo'){
            array_ids_ok[m]['archivo'] = file_data
          }
        }// for
        console.info("array_ids_ok");*/
        // console.info(array_ids_ok);
        // return false;


        Aplicar.guardar_ok(array_ids_ok);
      }
      return false;





      // Aplicar.guardar_ok(array_ids_ok);
      /*
      var data=paqueteDeDatos
      if(Object.keys(data).length === 0){
        Helpers.alert("Seleccione archivo", "error");
      }else{
        Aplicar.guardar_ok(array_ids_ok, data);
      }
      */
      // console.info(data_img);

      // return false;


    },

    guardar_ok : (array_ids_ok) => {
      // let array_aux = new Object();
      // array_aux["datos"] = array_ids_ok;
      var form_data = new FormData($("#form_cuestionario_doc")[0]);
      var ruta = base_url+"Encuesta/guardar";
      $.ajax({
        // async: true,
        url: ruta,
        type: 'POST',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,

        data: form_data,
        beforeSend: function( xhr ) {
          $("#wait").modal("show");
        }
      })
      .done(function(data) {

        $("#wait").modal("hide");
        if (data.estatus) {
          bootbox.alert(data.respuesta, function(){
            window.location.href = base_url;
        });
        }
        else {
          Helpers.alert(data.respuesta, "error");
        }

      })
      .fail(function(jqXHR, textStatus, errorThrown, data) {
        $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
      });
    }

  };
