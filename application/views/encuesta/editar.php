<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Edición de requerimiento</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form id='form_cuestionario_doc' enctype="multipart/form-data">

        <input type="text" name="id_aplicar" value="<?=$id_aplicar ?>" hidden>

      <?php $array_idpreguntas = array(); $i=0;?>

      <?php foreach ($array_preguntas as $keyp => $pregunta) { array_push($array_idpreguntas, $pregunta['idpregunta'].'/'.$pregunta['idtipopregunta'] ); ?>
        <?php if($pregunta['idtipousuario'] == $_SESSION['datos_usuario_ceeo']['idtipousuario'] || $_SESSION['datos_usuario_ceeo']['idtipousuario'] == U_ADMINISTRADOR ){ ?>
        <input type="hidden" id="tipo_usuario" value = "<?= $_SESSION['datos_usuario_ceeo']['idtipousuario'] ?>">
        <div class="row margintop10">
            <div class='col-xs-12'>
              <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label>  <?php if ($pregunta['instructivo'] != null) { ?><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $pregunta['instructivo'] ?>"></i><?php } ?>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <?php if ($pregunta['npregunta']==14  || $pregunta['npregunta']==25 || $pregunta['npregunta']==23  || $pregunta['npregunta']==27 ){ $i++;?>
                <div class='col-xs-12'>
                <?php if($pregunta['tamanio_campo'] > 80) {?>
                  <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>" style="height: <?= ($pregunta['tamanio_campo'] == 250)?'60px':'120px'?>;"  data-tamanio ="<?= $pregunta['tamanio_campo']?>"  maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>"><?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?></textarea>
                  <?php } else { ?>
                    <input type="text"  style="width: <?= ($pregunta['tamanio_campo'] < 80)?'80px':'100%'?>;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' name="<?= $pregunta['idpregunta'] ?>" data-tamanio ="<?= $pregunta['tamanio_campo']?>"  maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>" value="<?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?>" />
                    <?php } ?>
                    <span style="color:red" id="span<?=$i?>"></span>
                </div>
              <!-- <div class='col-xs-12'>
                <textarea style="height: 120px;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"><?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?></textarea>
              </div> -->
              <?php } else { $i++;?>
              <div class='col-xs-12'>
              
              <?php if($pregunta['tamanio_campo'] > 80) {?>
                <textarea data-tamanio ="<?= $pregunta['tamanio_campo']?>"  style="height: <?= ($pregunta['tamanio_campo'] == 250)?'60px':'120px'?>;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>"  id="textarea<?=$i?>" ><?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?></textarea>
                <?php } else { ?>
                  <input type="text" data-tamanio ="<?= $pregunta['tamanio_campo']?>"   style="width: <?= ($pregunta['tamanio_campo'] < 80)?'80px':'100%'?>;" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' name="<?= $pregunta['idpregunta'] ?>"  id="textarea<?=$i?>"  value="<?php foreach ($array_respuetas as $key => $value){ if ($value['idpregunta']==$pregunta['idpregunta']){ echo $value['respuesta']; } } ?>" />
                  <?php } ?>
                  <span style="color:red" id="span<?=$i?>"></span>
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
                        > <?= ($complemento['complemento']=='Otro <input type="text" name="otro_input">')? 'Otro <input type="text" name="otro_input" value="'.$array_respuetas[$keyp+(($array_respuetas[1]['idpregunta']==26)?4:2)]['complemento'].'">':$complemento['complemento'] ?>
                    
                      </label>
                      <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION_SLC){ ?>
                <div class='col-xs-12'>
                <select class="requerido form-control" data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>">
                  <option value="0">Seleccione una opción</option>
                  <?php $i=0; foreach ($pregunta['array_complemento'] as $key => $complemento) {
                     if ($array_respuetas[$keyp+(($array_respuetas[1]['idpregunta']==26)?3:1)]['respuesta'] == ($complemento['orden'])) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                    $i++;
                    ?>
                  <option value="<?= $complemento['orden'] ?>" <?= $selected ?> ><?= $complemento['complemento']?></option>
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
