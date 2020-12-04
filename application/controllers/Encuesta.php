<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuesta extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('appweb');
    $this->load->model('Encuesta_model');
    $this->load->model('Respuestas_model');
    $this->load->model('Aplicar_model');
    $this->load->model('Administrador_model');
  }


  function get_xidusuario(){
    if(verifica_sesion_redirige($this)){

      $usuario = $this->session->userdata[DATOSUSUARIO];
      $result = $this->Encuesta_model->get_xidusuario($usuario["idusuario"]);
      // $result2 = $result;
      // $arr_columnas = array("id","nvisitas","cct","nombre_ct","turno", "nombre_nivel","nombre_modalidad","domicilio");
      $arr_columnas = array(
        "id"=>array("type"=>"text", "width"=>"5", "header"=>"Folio"),
        "fcreacion"=>array("type"=>"hidden", "width"=>"0", "header"=>"Fecha de aplicación"),
        "n_documento"=>array("type"=>"text", "width"=>"75", "header"=>"Nombre del documento"),
        'estatus'=>array("type"=>"text", "width"=>"10", "header"=>"Estatus documento"),
        "a_adjunto"=>array("type"=>"button", "width"=>"10", "header"=>"Evidencia")
      );


      $response = array(
        "result" => $result,
        "array_columnas" => $arr_columnas,
        "total" => count($result)

      );

      envia_datos_json(200, $response, $this);
    }// verifica_sesion_redirige()
  }// get_xidusuario()


  public function aplicar(){
    $idusuario = $this->input->post('id_usuario_area');
    if(verifica_sesion_redirige($this)){
      $usuario = (($idusuario!='')? $idusuario :$this->session->userdata[DATOSUSUARIO]);
      $tipo = (($idusuario!='')?2:$usuario["tipo"]);
      $data["titulo"] = "";
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["idusuario"] = (($idusuario!='')? $idusuario :$usuario["tipo"]);
      $data["usuario"] = trae_datos_user($this,"");

      $array_preguntas = $this->Encuesta_model->get_cuestions();
      $array_preguntas_ok = array();
      // echo "<pre>"; print_r($array_preguntas); die();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta($pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
      }

      // echo "despues";

      $data['array_preguntas'] = $array_preguntas_ok;
      // echo "<pre>"; print_r($data); die();
      pagina_basica($this, "encuesta/aplicar", $data);
    }// verifica_sesion_redirige()
  }// aplicar()

  public function editar($id_aplica){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      // $id_aplica = $this->input->post('id_aplicar');
      // echo "<pre>";print_r($usuario);die();
      $data["id_aplicar"] = $id_aplica;
      $data["titulo"] = "";
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["usuario"] = trae_datos_user($this,"");

      $array_preguntas = $this->Encuesta_model->get_cuestions();
      $array_preguntas_ok = array();
      // echo "<pre>"; print_r($array_preguntas); die();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta_resp($pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
        // $pregunta['array_respuesta'] = $this->Respuestas_model->get_response_xidpregunta($pregunta['idpregunta'],$id_aplica);
        // array_push($array_preguntas_ok, $pregunta);
      }

      // echo "despues";
      // echo "<pre>"; print_r($array_preguntas_ok); die();
      $data['array_preguntas'] = $array_preguntas_ok;
      $data['array_respuetas'] = $this->Respuestas_model->get_response($id_aplica);
      $data['tipoUsuario'] = $tipo;
      // echo "<pre>";print_r($data);die();
      // $str_view_edit = $this->load->view("encuesta/editar", $data, TRUE);
      pagina_basica($this, "encuesta/editar", $data);
      // $response = array(
      //   "str_view_edit" => $str_view_edit
      // );
      // envia_datos_json(200, $response, $this);
    }// verifica_sesion_redirige()
  }// editar()

  public function get_cuestions(){
    if(verifica_sesion_redirige($this)){
      $preguntas = $this->Encuesta_model->get_cuestions();
      $data['array_preguntas'] = $preguntas;
      pagina_basica($this, "encuesta/aplicar", $data);
    }
  }// get_cuestions()



  public function guardar(){
     // echo "<pre>";print_r($_POST['idusuario']);die();
     // $nombre_archivo = str_replace(" ", "_", $_FILES['ifile_aplicar']['name']);
     echo "<pre>";print_r($_FILES);die();
     if(verifica_sesion_redirige($this)){
      $band = TRUE;
      $estatus_arch = TRUE;
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $idusuario_aux = (($_POST['idusuario']!='ENCUESTADOR')?$_POST['idusuario']:$usuario['idusuario']);
      unset($_POST['idusuario']);
      // echo "<pre>";print_r($usuario);die();
       switch ($usuario['idsubsecretaria']) {
       case '1':
        $subsecretaria = 'multi_areas_'.$usuario['username'];
         break;
        case '2':
        $subsecretaria = 'of_titular_'.$usuario['username'];
          break;
          case '3':
        $subsecretaria = 'direc_gen_serv_admin_'.$usuario['username'];
            break;
          case '4':
        $subsecretaria = 'subse_edu_basic_'.$usuario['username'];
            break;
          case '5':
        $subsecretaria = 'subse_plan_educ_'.$usuario['username'];
            break;
       default:
         $subsecretaria = 'otra_subsecreatria_'.$usuario['username'];
         break;
     }
      $array_respuestas = array('array_datos' => array());
      // echo "<pre>";print_r($_POST);die();
      $aux_cont=0;
      foreach ($_POST as $key => $value) {
        if (is_int($key)) {
          if (array_search($key, array_column($array_respuestas['array_datos'], 'idpregunta'))==FALSE) {
            array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
          }
        }
        else {
          $arr_cand =explode('_', $key);
          if ($key == 'otro_input') {
           array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => 6,'valores_string' => $value));
          }
          else {
            if (array_search(end($arr_cand), array_column($array_respuestas['array_datos'], 'idpregunta'))==FALSE) {
              array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
            }
          }
        }
        $aux_cont++;
      }
       // echo "<pre>";print_r($array_respuestas);
       //  die();
     $i = strlen($_FILES['ifile_aplicar']['name']);
              for ($j=$i; $j > 1 ; $j--) {
               $extension = $_FILES['ifile_aplicar']['name'];
               $extension = substr($extension,$j);
               if (stristr($extension, '.')) {
                  $extension_archivo = $extension;
                 break;
               }
              }

               $fecha = date_create();
              $idfecha = date_timestamp_get($fecha);

              $nuevo_nombre_archivo = $subsecretaria.'_'.$idfecha.$extension_archivo;


      // $id_aplica = $this->Aplicar_model->insert_aplica($usuario['idusuario']);
      // $estatus_insert = $this->Respuestas_model->insert_respuestas($array_respuestas,$id_aplica,$ruta_archivos_save);

      // echo "<pre>";print_r($idusuario_aux);die();
      $id_aplica = $this->Respuestas_model->insert_respuestas($array_respuestas,$nuevo_nombre_archivo, $idusuario_aux);

      if ($id_aplica > 0) {
        if ($nuevo_nombre_archivo!='') {
              $ruta_archivos = "evidencias/{$idusuario_aux}/{$id_aplica}/";
              // $ruta_archivos_save = "evidencias/{$usuario['idusuario']}/{$id_aplica}/$nombre_archivo";




              if(!is_dir($ruta_archivos)){
                mkdir($ruta_archivos, 0777, true);}
                // $_FILES['userFile']['name']     = $_FILES['ifile_aplicar']['name'];
                $_FILES['userFile']['name']     = $nuevo_nombre_archivo;
                $_FILES['userFile']['type']     = $_FILES['ifile_aplicar']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['ifile_aplicar']['tmp_name'];
                $_FILES['userFile']['error']    = $_FILES['ifile_aplicar']['error'];
                $_FILES['userFile']['size']     = $_FILES['ifile_aplicar']['size'];

                $uploadPath              = $ruta_archivos;
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'gif|bmp|jpg|png|jpeg|pdf';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $estatus_arch = TRUE;
                }
                else {
                  $estatus_arch = FALSE;
                }
            }
        if ($estatus_arch) {
          $data = array('estatus' => $estatus_arch, 'respuesta' => "El requerimiento se guardó correctamente.");
          envia_datos_json(200,$data, $this);
          // echo "<pre>"; print_r($data); die();
        }
        else {
            $data = array('estatus' => $estatus_arch, 'respuesta' => "Falló al insertar archivo.");
            envia_datos_json(200,$data, $this );
        }
      }
      else {
        $data = array('estatus' => $id_aplica, 'respuesta' => "Falló al insertar idaplica.");
        envia_datos_json(200,$data, $this );
      }
    }
  }// guardar()

  public function editar_insert(){
     if(verifica_sesion_redirige($this)){
      $band = TRUE;
      $estatus_arch = TRUE;
      $usuario = $this->session->userdata[DATOSUSUARIO];
      // echo "<pre>"; print_r($_POST); die();
     switch ($usuario['idsubsecretaria']) {
       case '1':
        $subsecretaria = 'multi_areas_'.$usuario['username'];
         break;
        case '2':
        $subsecretaria = 'of_titular_'.$usuario['username'];
          break;
          case '3':
        $subsecretaria = 'direc_gen_serv_admin_'.$usuario['username'];
            break;
          case '4':
        $subsecretaria = 'subse_edu_basic_'.$usuario['username'];
            break;
          case '5':
        $subsecretaria = 'subse_plan_educ_'.$usuario['username'];
            break;
       default:
         $subsecretaria = 'otra_subsecreatria_'.$usuario['username'];
         break;
     }
      $array_respuestas = array('array_datos' => array());
      $aux_cont = 0;
      foreach ($_POST as $key => $value) {
        if (is_int($key)) {
          if (array_search($key, array_column($array_respuestas['array_datos'], 'idpregunta'))==FALSE) {
            array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
          }
        }
        else {
          $arr_cand =explode('_', $key);
          if ($key != 'aplicar') {
            $id_aplica = $_POST['id_aplicar'];
          }
          if ($key == 'otro_input') {
           array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => 6,'valores_string' => $value));
          }
          else {
            if (array_search(end($arr_cand), array_column($array_respuestas['array_datos'], 'idpregunta'))==FALSE) {
              array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
            }
          }
        }
        unset($array_respuestas['array_datos'][0]);
        $aux_cont++;
      }
  // echo '<pre>'; print_r($array_respuestas); die();
    //    foreach ($_POST as $key => $value) {
    //     if ($key == 4) {

    //     array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
    //     }
    //      if ($value == 'Otro <input type="text" name="otro_input">') {
    //          unset($array_respuestas['array_datos'][2]);
    //     }

    //     if (is_int($key)) {
    //       if ($band==TRUE) {
    //         array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
    //       }
    //       else {
    //         $band=TRUE;
    //       }
    //     }
    //     else {
    //       if ($key=='id_aplicar') {
    //         $id_aplica =$value;
    //       }
    //       else {
    //         if ($band==TRUE) {
    //           $arr_cand =explode('_', $key);
    //          if ($key=='otro_input') {
    //          array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => 3,'valores_string' => $value));
    //         }
    //         array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
    //        unset($array_respuestas['array_datos'][4]);
    //         $band=FALSE;
    //       }
    //       else {
    //         $band=TRUE;
    //       }
    //     }
    //   }
    // }

    $i = strlen($_FILES['ifile_aplicar']['name']);
    if ($i > 0) {
       for ($j=$i; $j > 1 ; $j--) {
               $extension = $_FILES['ifile_aplicar']['name'];
               $extension = substr($extension,$j);
               if (stristr($extension, '.')) {
                  $extension_archivo = $extension;
                 break;
               }
              }

               $fecha = date_create();
              $idfecha = date_timestamp_get($fecha);

              $nuevo_nombre_archivo = $subsecretaria.'_'.$id_aplica.'_'.$idfecha.$extension_archivo;
    } else{
       $nuevo_nombre_archivo = $_FILES['ifile_aplicar']['name'];
    }





      // $id_aplica = $this->Aplicar_model->insert_aplica($usuario['idusuario']);
      // $estatus_insert = $this->Respuestas_model->insert_respuestas($array_respuestas,$id_aplica,$ruta_archivos_save);
      $respuesta_estatus = $this->Respuestas_model->update_respuestas($array_respuestas,$nuevo_nombre_archivo ,$id_aplica,$usuario['idusuario']);

      if ($id_aplica > 0) {
        if ($nuevo_nombre_archivo!='') {

          $files = glob("evidencias/{$usuario['idusuario']}/{$id_aplica}/*"); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
            }
              $ruta_archivos = "evidencias/{$usuario['idusuario']}/{$id_aplica}/";





              if(!is_dir($ruta_archivos)){
                mkdir($ruta_archivos, 0777, true);}
                // $_FILES['userFile']['name']     = $_FILES['ifile_aplicar']['name'];
                $_FILES['userFile']['name']     = $nuevo_nombre_archivo;
                $_FILES['userFile']['type']     = $_FILES['ifile_aplicar']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['ifile_aplicar']['tmp_name'];
                $_FILES['userFile']['error']    = $_FILES['ifile_aplicar']['error'];
                $_FILES['userFile']['size']     = $_FILES['ifile_aplicar']['size'];

                $uploadPath              = $ruta_archivos;
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'gif|bmp|jpg|png|jpeg|pdf';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $estatus_arch = TRUE;
                }
                else {
                  $estatus_arch = FALSE;
                }
            }
        if ($estatus_arch) {
          $data = array('estatus' => $estatus_arch, 'respuesta' => "El requerimiento se editó correctamente.", 'usuario' => $usuario['tipo']);
          envia_datos_json(200,$data, $this);
        }
        else {
            $data = array('estatus' => $estatus_arch, 'respuesta' => "Falló al insertar archivo.");
            envia_datos_json(200,$data, $this );
        }
      }
      else {
        $data = array('estatus' => $id_aplica, 'respuesta' => "Falló al insertar idaplica.");
        envia_datos_json(200,$data, $this );
      }
    }
  }// editar_insert()

  public function mostrar($idaplicar){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      $data["titulo"] = "";
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["usuario"] = trae_datos_user($this,"");
        $data['tipoUsuario'] = $tipo;
      // $idaplicar = $this->input->post('idaplicar');
      // echo $idaplicar; die();

      $array_preguntas = $this->Encuesta_model->get_cuestions_mostrar();
      $array_preguntas_ok = array();
      foreach ($array_preguntas as $key => $pregunta) {

        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta_mostrar($pregunta['idpregunta']);
        $pregunta['array_contesto'] = $this->Encuesta_model->get_encuestaxidusuario1($idaplicar, $pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
      }
      // echo "<pre>"; print_r( $pregunta['array_contesto']);die();
        $nombreUsuario = ($pregunta['array_contesto'] != NULL) ? $pregunta['array_contesto'][0]['Usuario'] : '';
      $array_final = array();
// echo "<pre>"; print_r($array_preguntas_ok);die();
      foreach ($array_preguntas_ok as $key => $pregunta_ok) {
        // echo "<pre>"; print_r($pregunta_ok);
        $array_final_aux['idpregunta'] = $pregunta_ok['idpregunta'];
        $array_final_aux['pregunta'] = $pregunta_ok['pregunta'];
        $array_final_aux['idtipopregunta'] = $pregunta_ok['idtipopregunta'];
        $array_final_aux['tamanio_campo'] = $pregunta_ok['tamanio_campo'];
        $array_final_aux['npregunta'] = $pregunta_ok['npregunta'];
        $array_final_aux['instructivo'] = $pregunta_ok['instructivo'];
        $array_final_aux['respuesta'] = $pregunta_ok['respuesta'];
        $array_final_aux['idtipousuario'] = $pregunta_ok['idtipousuario'];

        if($pregunta_ok['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){
          // $array_opciones = $pregunta_ok['array_complemento'];
          $array_final_aux['array_final'] = $this->verifica_sicontesto($pregunta_ok['array_complemento'], $pregunta_ok['array_contesto']);
        }elseif ($pregunta_ok['idtipopregunta'] == PREGUNTA_UNAOPCION) {

          $array_final_aux['array_final'] = $this->verifica_sicontesto($pregunta_ok['array_complemento'], $pregunta_ok['array_contesto']);
          // echo "<pre>"; print_r($array_final_aux['array_final']);
        }elseif ($pregunta_ok['idtipopregunta'] == PREGUNTA_ABIERTA) {
          $array_final_aux['respuesta'] = (isset($pregunta_ok['array_contesto'][0]['respuesta']))?$pregunta_ok['array_contesto'][0]['respuesta']:'';
          // echo "<pre>"; print_r($pregunta_ok['respuesta']);
        }
        array_push($array_final, $array_final_aux);
      }
      $respuesta_slc = $this->Encuesta_model->respuestas_slc($idaplicar);
 // die();
      $array_observaciones = $this->Administrador_model->getObservaciones($idaplicar);
      $data['respuesta_slc'] = $respuesta_slc;
      $data['array_datos'] = $array_final;
      $array_file = $this->Encuesta_model->get_file_path($idaplicar);
      $data['file_path'] = (count($array_file)>0)?$array_file[0]['url_comple']:'';
      $data['nombreUsuario'] = $nombreUsuario;
      $data['idaplicar'] = $idaplicar;
      $data['array_observaciones'] = $array_observaciones;
      // echo "<pre>"; print_r($data);
      // die();
      pagina_basica($this, "encuesta/mostrar", $data);
    }// verifica_sesion_redirige()
  }// mostrar()

  private function verifica_sicontesto($array_opciones, $array_opciones_contesto){
    $array_complementos_contesto = array();

    foreach ($array_opciones_contesto as $key => $opcion_contesto) {
      array_push($array_complementos_contesto, $opcion_contesto['complemento']);
    }

    $array_final = array();
    foreach ($array_opciones as $key => $opcion_catalogo) {
      $array_aux = array();
      $array_aux['idpregunta'] = $opcion_catalogo['idpregunta'];
      $array_aux['complemento'] = $opcion_catalogo['complemento'];
      $array_aux['orden'] = $opcion_catalogo['orden'];
      $array_aux['checked'] = '';
// echo "<pre>";print_r($opcion_catalogo['complemento']);die();
      if (in_array($opcion_catalogo['complemento'], $array_complementos_contesto)) {
          $array_aux['checked'] = 'checked';

          if ($opcion_catalogo['complemento']=='Otro <input type="text" name="otro_input">') {
            $array_aux['input_otro'] = $array_complementos_contesto[1];
            // echo "<pre>";print_r($array_aux);die();
          }
      }
      array_push($array_final, $array_aux);
    }
    // echo "<pre>";print_r($array_final);die();
    return $array_final;
  }// verifica_sicontesto()

  public function eliminar(){
      $idaplicar = $this->input->post('idaplicar');
      $result = $this->Encuesta_model->eliminar($idaplicar);
      // echo $idaplicar; die();
      $response = array(
        "result" => $result
      );

      envia_datos_json(200, $response, $this);
  }// mostrar()


  public function get_arch_evidencia(){
      $idaplicar = $this->input->post('id_aplica');
      $result = $this->Encuesta_model->get_url_evidencia($idaplicar);
      $nombre = $this->Encuesta_model->get_nombre_evidencia($idaplicar);
      // echo $idaplicar; die();
      $response = array(
        "result" => $result,
        "nombre" => $nombre
      );

      envia_datos_json(200, $response, $this);
  }// mostrar()

}// class
