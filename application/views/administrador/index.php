<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<center><h2>Levantamiento de requerimientos Sinaloa</h2></center>

			<div id="tabla_usuario">
				<?php foreach ($subsecretaria as $key => $value) { ?>

					<!-- Acordeón -->
					<?php if ($value['idsubsecretaria'] == 1 ): ?>
						<div class="accordion bg-success" id="accordionExample1">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 2 ): ?>
						<div class="accordion bg-warning" id="accordionExample2">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 3 ): ?>
						<div class="accordion bg-info" id="accordionExample3">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 4 ): ?>
						<div class="accordion bg-danger" id="accordionExample4">
					<?php endif ?>
					<?php if ($value['idsubsecretaria'] == 5 ): ?>
						<div class="accordion bg-warning" id="accordionExample5">
					<?php endif ?>
						<div class="card">
							<div class="card-header" id="headingOne">
								<h5 class="mb-0">
									<button class="btn btn-link" onclick="traerUsuarios(<?=  $value['idsubsecretaria']?>)" type="button" data-toggle="collapse" data-target="#collapse<?= $value['idsubsecretaria']?>" aria-expanded="true" aria-controls="collapse<?= $value['idsubsecretaria']?>">
											<p><?= $value['subsecretaria']?></p>
									</button>
								</h5>
							</div>

							<div id="collapse<?= $value['idsubsecretaria']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample<?= $value['idsubsecretaria']?>">
								<div id="card<?=$value['idsubsecretaria']?>" class="card-body">

								</div>
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
