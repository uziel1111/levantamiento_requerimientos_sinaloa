/* jshint esversion: 6 */
let Helpers = {

  alert : (mensaje, tipo) => {
    let icono = "";
    if(tipo == "error"){
      icono = "<i class='fa fa-times-circle' style='font-size:24px;color:red'></i><br>";
    }else if ("success") {
      icono = "<i class='fa fa-check-circle' style='font-size:24px;color:green'></i><br>";
    }

    bootbox.alert({
      message: '<b>'+icono+''+mensaje+'</b>',
      size: 'small',
      buttons: {
        ok: {
          label: 'Aceptar',
          className:'btn btn-primary'
        }
      }
    });
  },


  error_ajax : function(jqXHR, textStatus, errorThrown){
    if (jqXHR.status === 0) {
      Helpers.alert("Not connect: Verify Network", "error");
    } else if (jqXHR.status == 404) {
      Helpers.alert("Requested page not found [404]", "error");
    } else if (jqXHR.status == 500) {
      Helpers.alert("Internal Server Error [500]", "error");
    } else if (textStatus === "parsererror") {
      Helpers.alert("Requested JSON parse failed", "error");
    } else if (textStatus === "timeout") {
      Helpers.alert("Time out error", "error");
    } else if (textStatus === "abort") {
      Helpers.alert("Ajax request aborted", "error");
    } else {
      Helpers.alert("Uncaught Error: "+qXHR.responseText, "error");
    }

  }

};
