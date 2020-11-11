<style type="text/css">
  .ocultar{
    display: none;
  }
</style>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading bg-color-1 text-center">
      <h3 class="panel-title">Mostrar requerimiento <?= ($tipoUsuario == 'ADMINISTRADOR') ? '/ '. $nombreUsuario : ''?></h3>
    </div><!-- .panel-heading -->
    <div class="panel-body">

      <?php $aux=0;  foreach ($array_datos as $key => $dato) {?>
        <?php if($dato['idtipousuario'] == $_SESSION['datos_usuario_ceeo']['idtipousuario'] || $_SESSION['datos_usuario_ceeo']['idtipousuario'] == U_ADMINISTRADOR ){ ?>
        <div class="row margintop10">
          <div class='col-xs-12'>
            <label><?= $dato['npregunta'] ?>.- <?= $dato['pregunta'] ?></label> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= $dato['instructivo'] ?>"></i>
          </div>
          <?php if($dato['idtipopregunta'] == PREGUNTA_ABIERTA){ ?>
            <div class='col-xs-12'>
              <textarea class='form-control' style="height: 120px;" rows='2' readonly><?= (isset($dato['respuesta']))?$dato['respuesta']:'' ?></textarea>
            </div><!-- .col-xs-12 -->
          <?php } ?>
          <?php if($dato['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){ ?>
            <!--  -->
            <?php foreach ($dato['array_final'] as $key => $opcion) { ?>
              <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input disabled class='requerido' type='checkbox' <?= ( (isset($opcion['checked'])) && (strlen($opcion['checked'])>0) )?'checked':'' ?> > <?= $opcion['complemento'] ?>
                </label>
              </div>
            <?php } ?>
            <!--  -->
          <?php } ?>

          <?php if($dato['idtipopregunta'] == PREGUNTA_UNAOPCION){ ?>
            <!--  -->

            <?php foreach ($dato['array_final'] as $key => $opcion) { ?>
              <div class='col-xs-12'>
                <label class='checkbox-inline'>
                  <input disabled class='requerido' type='radio' <?= ( (isset($opcion['checked'])) && (strlen($opcion['checked'])>0) )?'checked':'' ?> >
                  <?=($opcion['complemento']=='Otro <input type="text" name="otro_input">')? 'Otro <input type="text" readonly name="otro_input" value="'.((isset($opcion['input_otro']))?$opcion['input_otro']:'').'">':$opcion['complemento']?>
                </label>
              </div>
            <?php } ?>
            <!--  -->
          <?php } ?>
          <?php if($dato['idtipopregunta'] == PREGUNTA_UNAOPCION_SLC){?>
                <div class='col-xs-12'>
                <select class="requerido" data-idpregunta="<?= $dato['idpregunta'] ?>" name="<?= $dato['idpregunta'] ?>" disabled>
                  <option value="<?= $respuesta_slc[$aux]['respuesta'] ?>" selected><?= $respuesta_slc[$aux]['complemento']?></option>
                </select>
                <label id="label_<?= $dato['idpregunta'] ?>" class="error"></label>
                </div>
              <?php $aux++; } ?>

        </div><!-- .row -->
        <br>
          <?php }
    } ?>

      <div class="row margintop10">
        <?php
        $porciones = explode(".", $file_path);
        $extension = $porciones[1];
        if( ($extension == 'pdf') || $extension == 'PDF' ){ ?>
          <!-- <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'> -->
            <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'>
              <label>Archivo adjunto:</label><br>
              <iframe src="https://docs.google.com/viewer?url=<?= base_url($file_path) ?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>
            </div><!-- .col-lg-8 -->
          <?php }else { ?>
            <!-- <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'> -->
              <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'>
                <label>Archivo adjunto:</label><br>

                <a href="<?= base_url($file_path) ?>" target="_blank"><img src="<?= base_url($file_path) ?>" class="img-responsive"></a>

              </div><!-- .col-lg-8 -->
            <?php } ?>
            <!-- se comenta por que no sabemos si se van a utilizar o no -->
            <?php // if ($tipoUsuario == 'ADMINISTRADOR') { ?>
              <?php //foreach ($array_observaciones as $key => $adminDatos){ ?>

                <!-- sección nueva de administrador -->
                <!-- <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <input type="number" id="idaplicar" value="<?=$idaplicar;?>" style="display: none;">

                    <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>
                      <label>¿Quién llena el requerimiento?</label>
                      <br>
                      <?php if ($adminDatos['responsableDocumento'] == null){ ?>

                        <select id="encuestadoSelect"  class="selectpicker">
                          <option name="encuestado" value="1">El interesado</option>
                          <option name="encuestado" value="2">El director(a)</option>
                          <option name="encuestado" value="3">El padre de familia</option>
                          <option name="encuestado" value="4">El supervisor</option>
                          <option name="encuestado" value="5">Personal de la Secretría</option>
                          <option name="encuestado" value="6">Otro</option>
                          <input type="text" class="ocultar" id="encuestadoOtro">
                        </select>
                      <?php } else { ?>
                        <select id="encuestadoSelect"  class="selectpicker">
                            <option name="encuestado" value="1" <?= ($adminDatos['responsableDocumento'] == 1) ? 'selected' :'' ?>>El interesado</option>
                            <option name="encuestado" value="2" <?= ($adminDatos['responsableDocumento'] == 2) ? 'selected' :'' ?>>El director(a)</option>
                            <option name="encuestado" value="3" <?= ($adminDatos['responsableDocumento'] == 3) ? 'selected' :'' ?>>El padre de familia</option>
                            <option name="encuestado" value="4" <?= ($adminDatos['responsableDocumento'] == 4) ? 'selected' :'' ?>>El supervisor</option>
                            <option name="encuestado" value="5" <?= ($adminDatos['responsableDocumento'] == 5) ? 'selected' :'' ?>>Personal de la Secretría</option>
                            <option name="encuestado" value="6" <?= ($adminDatos['responsableDocumento'] == 6) ? 'selected' :'' ?>>Otro</option>
                            <input type="text" id="encuestadoOtro" class="ocultar" value="<?=$adminDatos['otroResponsable']?>">
                        </select>
                      <?php } ?>
                    </div>

                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                      <br>
                    <label>Especificar Acción</label>
                    <textarea type="text" id="especificacionAccion" style="height: 100px;" class="form-control textarea_blur"><?=$adminDatos['especificarMejora']?></textarea>
                    <label>Justificación de la Acción de Mejora</label>
                    <textarea type="text" id="justificacionAccion" style="height: 100px;"  class="form-control textarea_blur"><?=$adminDatos['justificarMejora']?></textarea>
                    <label>Notas adicionales</label>
                    <textarea type="text" id="notasAdicionales" style="height: 100px;"  class="form-control textarea_blur"><?=$adminDatos['notasAdicionales']?></textarea>
                    <br>
                  </div>
                    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'>
                      <a id="guardarNotas" class="btn btn-info btn-block">Guardar</a>
                    </div>
                  </div>
                </div> -->
                <!-- sección nueva de administrador -->
              <!-- <?php // } ?>
            <?php //} ?> -->
            <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'></div>
          </div><!-- .row -->


          <div class="row margintop10">
            <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10'></div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2'>
              <?php   if ($tipoUsuario == 'ADMINISTRADOR' ) { ?>

                <a href="<?= base_url('Administrador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } else {?>
                <a href="<?= base_url('Encuestador') ?>" class="btn btn-info btn-block">Regresar</a>
              <?php } ?>
            </div>
          </div><!-- .row -->

        </div><!-- .panel-body -->
      </div><!-- .panel -->

    </div><!-- container -->

    <script src="<?= base_url('assets/js/encuesta/mostrar.js') ?>"></script>
