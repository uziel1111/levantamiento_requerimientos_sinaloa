
	function traerUsuarios(id) {
    if (!$("#subsecretaria"+id).hasClass("in")) {
		$.ajax({
			url: 'Administrador/getUsuario',
			type: 'POST',
			data: {id: id},
			success : function(data) {
				$('#card'+id).html(data);
			}
    });
  }
	}

	function traerArchivos(id) {
    if (!$("#collapse"+id).hasClass("in")) {
		$.ajax({
			url: 'Administrador/getArchivos',
			type: 'POST',
			data: {id: id},
			success : function(data) {
				$('#archivos'+id).html(data);
			}
    });
  }
	}

	function mostrar_encuesta(idaplicar, usuario) {
		 let form = document.createElement("form");

    form.name="form_mostrar";
    form.method = "POST";
    form.target = "_parent";
    form.action = base_url+"encuesta/"+idaplicar;
    document.body.appendChild(form);
    form.submit();
	}

	function ver_ev(id_aplica){
   var ruta = base_url+"Encuesta/get_arch_evidencia";
   $.ajax({
     async: true,
     url: ruta,
     method: 'POST',
     data: {"id_aplica":id_aplica},
     beforeSend: function( xhr ) {
       $("#wait").modal("show");
     }
   })
   .done(function( data ) {
     $("#wait").modal("hide");

     $("#iframe_cont").empty();
     $("#iframe_cont").append(data.result);
     $("#iframe_cont").prop("src", data.result);
     $("#n_formato").empty();
     $("#n_formato").html(data.nombre);


      $("#exampleModal_ver_evidencia").modal("show");

   })
   .fail(function(jqXHR, textStatus, errorThrown) {
     console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });

  };

  function deshabilitar_ev(idaplicar,iduser) {
  	ruta = base_url+'Administrador/deshabilitar_req';
  	$.ajax({
  		url: ruta,
  		type: 'POST',
  		dataType: 'json',
  		data: {id: idaplicar},
  		 beforeSend: function( xhr ) {
       $("#wait").modal("show");
     }
  	})
  	.done(function(data) {
  		if (data) {
  		alert('El requerimiento se ha deshabilitado exitosamente');
  		traerArchivos(iduser);
			location.reload();
  		// console.log($('#p' + iduser).text());
  		}else{
  		alert('Error al deshabilitado');
  		}

  		 $("#wait").modal("hide");
  	})
  	 .fail(function(jqXHR, textStatus, errorThrown) {
     console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });
  }

  function editar_ev(idaplicar) {
  	 let form = document.createElement("form");

    form.name="form_editar";
    form.method = "POST";
    form.target = "_parent";

    form.action = base_url+"encuesta/edith/"+idaplicar;
    document.body.appendChild(form);
    form.submit();

  }

	function eliminar_ev(idaplicar,iduser) {
  	ruta = base_url+'Administrador/eliminar_req';
  	$.ajax({
  		url: ruta,
  		type: 'POST',
  		dataType: 'json',
  		data: {id: idaplicar},
  		 beforeSend: function( xhr ) {
       $("#wait").modal("show");
     }
  	})
  	.done(function(data) {
  		if (data) {
  		alert('El requerimiento se ha eliminado exitosamente');
  		traerArchivos(iduser);
			location.reload();
  		// console.log($('#p' + iduser).text());
  		}else{
  		alert('Error al eliminar');
  		}

  		 $("#wait").modal("hide");

  	})
  	 .fail(function(jqXHR, textStatus, errorThrown) {
     console.error("Error in read()"); console.table(e);
     $("#wait").modal("hide"); Helpers.error_ajax(jqXHR, textStatus, errorThrown);
   });
  }

	function agregar_req(id) {
		let form = document.createElement("form");
		var element1 = document.createElement("input");
      element1.type = "hidden";
      element1.name="id_usuario_area";
      element1.value = id;

	 form.name="form_crear";
	 form.method = "POST";
	 form.target = "_parent";

	 form.action = base_url+"encuesta/crear/"+id;
	 document.body.appendChild(form);
	 form.appendChild(element1);
	 form.submit();

	}
