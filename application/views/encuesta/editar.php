<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Edición de requerimiento</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form id='form_cuestionario_doc' enctype="multipart/form-data">

        <input type="text" name="id_aplicar" value="<?=$id_aplicar ?>" hidden>

      <?php $array_idpreguntas = array(); ?>

      <?php foreach ($array_preguntas as $key => $pregunta) { array_push($array_idpreguntas, $pregunta['idpregunta'].'/'.$pregunta['idtipopregunta'] ); ?>
        <?php if($pregunta['idtipousuario'] == $_SESSION['datos_usuario_ceeo']['idusuario'] || $_SESSION['datos_usuario_ceeo']['idusuario'] == U_ADMINISTRADOR ){ ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $pregunta['instructivo'] ?>"></i>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <?php if ($pregunta['npregunta']==17 || $pregunta['npregunta']==10){?>
              <div class='col-xs-12'>
                <textarea style="height: 120px;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"><?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?></textarea>
              </div>
              <?php } else {?>
              <div class='col-xs-12'>
                <textarea style="height: 120px;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"><?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?></textarea>
              </div>
            <?php } } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>

              <?php foreach ($pregunta['array_complemento'] as $keyx => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($keyx==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                      <label class='checkbox-inline'>
                        <input class='requerido checkbox_change' type='checkbox' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'
                        <?php foreach ($array_respuetas as $keyr => $valuer): ?>
                          <?php if ($valuer['idpregunta']==$pregunta['idpregunta'] ){ ?>
                            <?php if ($valuer['complemento']==$complemento['complemento']){ ?>
                               <?="checked"?>
                               <?php }else {?>
                                 <?=""?>
                               <?php }
                             }?>
                        <?php endforeach; ?>
                        > <?= $complemento['complemento'] ?>
                      </label>
                      <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key1 => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($key1==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                      <label class='checkbox-inline'>
                        <input class='requerido checkbox_change' type='radio' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'
                        <?php foreach ($array_respuetas as $keyr => $valuer): ?>
                          <?php if ($valuer['idpregunta']==$pregunta['idpregunta'] ){ ?>
                            <?php if ($valuer['complemento']==$complemento['complemento']){ ?>
                               <?="checked"?>
                               <?php }else {?>
                                 <?=""?>
                               <?php }
                             }?>
                        <?php endforeach; ?>
                        > <?= ($complemento['complemento']=='Otro <input type="text" name="otro_input">')? 'Otro <input type="text" name="otro_input" value="'.$array_respuetas[$key+2]['complemento'].'">':$complemento['complemento'] ?>
                      </label>
                      <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION_SLC){ ?>
                <div class='col-xs-12'>
                <select class="requerido" data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($pregunta['array_complemento'] as $key => $complemento) {
                     if ($array_respuetas[$key]['respuesta'] == ($complemento['orden']-1)) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                    ?>
                  <option value="<?= $complemento['orden'] ?>" <?= $selected ?> ><?= $complemento['complemento'] ?></option>
                  <?php } ?>
                </select>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>

        </div><!-- .row -->
        <br>
        <?php } ?>
      <?php } ?>

      <?php $separado_por_comas1 = implode(",", $array_idpreguntas); ?>
      <input type="hidden" id="itxt_idpreguntas" value="<?= $separado_por_comas1 ?>">

      <iframe class="img-fluid" alt="Responsive image" id="image_aplicar" name="image_aplicar" src="<?=($array_respuetas[0]['idpregunta']=='')? base_url($array_respuetas[0]['url_comple']):'' ?>" ></iframe>
      <!-- <iframe id="image_aplicar" name="image_aplicar" src="<?=($array_respuetas[0]['idpregunta']=='')? 'https://docs.google.com/viewer?url='.base_url().$array_respuetas[0]['url_comple'].'&embedded=true' :'' ?>" width="100%" height="500" style="border: none;"></iframe> -->
      <input type="file" id="ifile_aplicar" src="img_submit.png" name="ifile_aplicar" value="" class="image" accept="image/*, .pdf, .PDF">

      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <!-- <a href="<?= base_url('Encuestador') ?>" class="btn btn-info btn-block">Regresar</a> -->
           <?php   if ($tipoUsuario == 'ADMINISTRADOR' ) { ?>

                <a href="<?= base_url('Administrador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } else {?>
                <a href="<?= base_url('Encuestador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } ?>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
            <button id="btn_encuesta_editar" type='button' class='btn btn-primary btn-block'>Guardar</button>
        </div>

      </div><!-- .row -->
      </form>



      </div><!-- div_contenedor_preguntas -->

    </div><!-- .panel-body -->
  </div><!-- .panel -->

</div><!-- container -->

<script src="<?= base_url('assets/js/encuesta/editar.js') ?>"></script>
