<style>  
.fondo1 {
    background:#ffc8e3;
}

.fondo2 {
    background:#bfffbf;
}

.fondo3 {
    background:#c4ffff;
}

.fondo4 {
    background:#d7d7ff;
}

.fondo5 {
    background:#fcfdc1;
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<center><h2>Levantamiento de requerimientos Sinaloa</h2></center>

			<div id="tabla_usuario">
				<?php foreach ($subsecretaria as $key => $value) { ?>

					<!-- Acordeón -->
					<div  class="fondo<?=  $value['idsubsecretaria']?>">
						<p><a data-toggle="collapse"  onclick="traerUsuarios(<?=  $value['idsubsecretaria']?>)" href="#subsecretaria<?= $value['idsubsecretaria']?>" aria-expanded="false" aria-controls="subsecretaria<?= $value['idsubsecretaria']?>">
				
									<?= $value['subsecretaria']?></a>
								
								</p>

							<div class="collapse" id="subsecretaria<?= $value['idsubsecretaria']?>">
								<div id="card<?=$value['idsubsecretaria']?>" class="card-body">

								</div>
							</div>
							</div>
					<!-- fin Acordeón -->

				<?php } ?>
			</div>

			<div id="exampleModal_ver_evidencia" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header  bgcolor-2">
        <button type="button" class="close color-6" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <center>
        <h4 class="modal-title color-6" id="exampleModalLongTitle">Archivo evidencia</h4>
        <h5>Nombre del documento: <label id="n_formato"></label></h5>
      </center>

      </div>
      <div class="modal-body">
        <iframe id="iframe_cont" src="" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>


		</div>
	</div><!-- row -->
</div><!-- container-fluid -->


<script src="<?= base_url('assets/js/administrador/administrador.js') ?>"></script>
