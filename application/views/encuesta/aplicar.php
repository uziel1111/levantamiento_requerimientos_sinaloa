<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Levantamiento de requerimiento</h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <div id="div_contenedor_preguntas">


      <form id='form_cuestionario_doc' enctype="multipart/form-data">

      <?php $array_idpreguntas = array();  $i = 0;?>
      <?php //echo'<pre>'; print_r($_SESSION['datos_usuario_ceeo']['idusuario']); die();  ?>
        <input type="hidden" name="idusuario" id="idusuario" value ="<?=$idusuario?>">
      <?php foreach ($array_preguntas as $key => $pregunta) { array_push($array_idpreguntas, $pregunta['idpregunta'].'/'.$pregunta['idtipopregunta'] ); ?>
        <?php if($pregunta['idtipousuario'] == U_ENCUESTADOR || $_SESSION['datos_usuario_ceeo']['idtipousuario'] == U_ADMINISTRADOR ){ ?>
        <div class="row margintop10">
            <div class='col-xs-12'>
        <label><?= $pregunta['npregunta'] ?>.- <?= $pregunta['pregunta'] ?></label> <?php if ($pregunta['instructivo'] != null) { ?><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $pregunta['instructivo'] ?>"></i><?php } ?>
            </div>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
              <?php if ($pregunta['npregunta']==14  || $pregunta['npregunta']==25 || $pregunta['npregunta']==23  || $pregunta['npregunta']==27 || $pregunta['npregunta']==10){ $i++;?>
                <div class='col-xs-12'>
                <?php if($pregunta['tamanio_campo'] > 80) {?>
                  <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>" style="height: <?= ($pregunta['tamanio_campo'] == 250)?'60px':'120px'?>;"  data-tamanio ="<?= $pregunta['tamanio_campo']?>"  maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>"></textarea>
                  <?php } else { ?>
                    <input type="text" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control textarea_blur' name="<?= $pregunta['idpregunta'] ?>"  data-tamanio ="<?= $pregunta['tamanio_campo']?>" style="width: <?= ($pregunta['tamanio_campo'] < 80)?'80px':'100%'?>;"    maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>"/>
                  <?php } ?>
                  <span style="color:red" id="span<?=$i?>"></span>
                </div>
              <?php } else { $i++;?>
              <div class='col-xs-12'>
              <?php if($pregunta['tamanio_campo'] > 80) {?>
                <textarea data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' rows='2' name="<?= $pregunta['idpregunta'] ?>" style="height: <?= ($pregunta['tamanio_campo'] == 250)?'60px':'120px'?>;"  data-tamanio ="<?= $pregunta['tamanio_campo']?>"  maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>"></textarea>
                <?php } else { ?>
                  <input type="text" data-idpregunta="<?= $pregunta['idpregunta'] ?>" class='form-control requerido textarea_blur' name="<?= $pregunta['idpregunta'] ?>"  data-tamanio ="<?= $pregunta['tamanio_campo']?>" style="width: <?= ($pregunta['tamanio_campo'] < 80)?'80px':'100%'?>;"    maxlength="<?= $pregunta['tamanio_campo']?>" id="textarea<?=$i?>"/>
                  <?php } ?>
                <span style="color:red" id="span<?=$i?>"></span>
              </div>
            <?php } } ?>
            <?php if($pregunta['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($key==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                <label class='checkbox-inline'>
                  <input class='requerido checkbox_change' type='checkbox' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION){ ?>

              <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                <div class='col-xs-12'>
                  <?php if($key==0)  { ?>
                  <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value="">
                <?php } ?>
                <label class='checkbox-inline'>
                  <input class='requerido checkbox_change' type='radio' data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>" value='<?= $complemento['complemento'] ?>'> <?= $complemento['complemento'] ?>
                </label>
                <label id="label_<?= $pregunta['idpregunta'] ?>" class="error"></label>
                </div>
              <?php } ?>
            <?php } ?>

            <?php if($pregunta['idtipopregunta'] == PREGUNTA_UNAOPCION_SLC){ ?>
                <div class='col-xs-12'>
                  <?php if($key==0)  { ?>
                  <!-- <input type="hidden" id="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" name="itxt_aplicar_idpregunta_<?= $pregunta['idpregunta'] ?>" value=""> -->
                <?php } ?>
                <select class="requerido form-control" data-idpregunta="<?= $pregunta['idpregunta'] ?>" name="<?= $pregunta['idpregunta'] ?>">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($pregunta['array_complemento'] as $key => $complemento) { ?>
                  <option value="<?= $complemento['orden'] ?>"><?= $complemento['complemento'] ?></option>
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

      <iframe class="img-fluid" alt="Responsive image" id="image_aplicar" name="image_aplicar" src="" ></iframe>
      <!-- <iframe id="image_aplicar" name="image_aplicar" src="" width="100%" height="500" style="border: none;"></iframe> -->
      <input type="file" id="ifile_aplicar" name="ifile_aplicar" value="" class="image"  accept="image/*, .pdf, .PDF">
<label style="color: red;">*Sólo se aceptan archivos .PDF, .JPG, .JPEG, .PNG</label>
      <div class="row margintop10">
        <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'></div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
          <a href="<?= base_url() ?>" class="btn btn-info btn-block">Regresar</a>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
            <button id="btn_encuesta_guardar" type='button' class='btn btn-primary btn-block'>Guardar</button>
        </div>

      </div><!-- .row -->

      </form>



      </div><!-- div_contenedor_preguntas -->

    </div><!-- .panel-body -->
  </div><!-- .panel -->

</div><!-- container -->

<script src="<?= base_url('assets/js/encuesta/aplicar.js') ?>"></script>
