<div class="card-body">
	<div class="row">
		<div class="col-12 col-md-12" style="border: 1px dashed #bdbebf; padding: 20px; border-radius: .25rem;">
			<div class="row">
				<?php if ($isFromTelefonica) : ?>
					<div class="col-12 col-sm-4">
						<div class="form-group">
							<label for="id_empresa">Empresa:</label>
							<select id="id_empresa" name="id_empresa" class="form-control"></select>
							<?= form_error('id_empresa'); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="datepicker_desde">Desde:</label>
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
							</span>
							<input type="text" id="datepicker_desde" class="form-control" readonly="" name="datepicker_desde" value="<?= date('01/m/Y') ?>">
						</div>
					</div>
				</div>

				<div class="col-12 col-sm-4">
					<div class="form-group">
						<label for="datepicker_hasta">Hasta:</label>
						<div class="input-group">
							<span class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
							</span>
							<input type="text" id="datepicker_hasta" class="form-control" readonly="" name="datepicker_hasta" value="<?= date('d/m/Y') ?>">
						</div>
					</div>
				</div>

				<div class="col-12 text-right">
					<button class="btn btn-primary" type="button" id="btnFilter">
						<i class="fa fa-search"></i> Buscar
					</button>
				</div>



			</div>

			<div class="row">
				<div class="col-12">
					<label>
						Órdenes agendadas por whatsapp:
						<span class="badge badge-pill badge-dark" id="cantOrdersPending">0</span>
					</label>
					<div class="table-responsive">
						<table style="cursor:pointer" id="datatable" cellspacing="0" width="100%" style="width: 100%;" class="table table-hover">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="./assets/js/orders/agendaWhatsapp.js?v1.0"></script>