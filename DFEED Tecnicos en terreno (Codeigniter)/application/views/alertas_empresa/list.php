<style>
	/* Important part */
	.modal-dialog{
		overflow-y: initial !important
	}
	.modal-body{
		height: 80vh;
		overflow-y: auto;
	}
</style>

<div class="card-header">
	<div class="row">
		<div class="col-10">
			<h4 class="card-title m-0 font-weight-bold">
				<i class="fa fa-briefcase"></i> Listado de Alertas
			</h4>
		</div>
		<div class="col-2 text-right">
            <!--
			<button class="btn btn-primary btn-sm btn-add-encuesta" data-toggle="modal" data-target="#manageAlerta" data-toggle2="tooltip" data-placement="left" title="Añadir Alerta">
				<i class="fas fa-plus"></i>
			</button>
-->
		</div>
	</div>
</div>


<div class="card-body">
<div class="row">
		<div class="col-12">
			<?= form_open(site_url('alertas_empresa/index'), array('method' => 'get')); ?>
			<div class="row">

				<?php if ($isFromTelefonica) : ?>
					<div class="col-xs-12 col-md-4">
						<div class="form-group">
							<select id="id_empresa" name="id_empresa" class="form-control" ></select>
							<?= form_error('id_empresa'); ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="col-xs-12 col-md-4 d-flex justify-content-center">
					<div class="form-group">
						<div class="input-group">
							<button class="btn btn-success" type="submit">
								<i class="fas fa-search"></i>
								Buscar
							</button>
<!--							<button class="btn btn-success mx-1" type="submit">-->
<!--								<i class="fas fa-search"></i>-->
<!--								Cambio Estado Masivo-->
<!--							</button>-->
						</div>
					</div>
				</div>
			</div>
			<?= form_close(); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table id="datatable" cellspacing="0" width="100%" style="width: 100%;" class="table table-hover">
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Modal lista destinatarios-->
<div class="modal fade" id="manageLista" tabindex="-1" aria-labelledby="manageLista" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="manageListaLabel">Destinatarios</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarModal2">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div class="table-responsive">
											<table id="datatableLista" cellspacing="0" width="100%" style="width: 100%;" class="table table-hover">
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary cerrarModal" data-dismiss="modal" id="cerrarModal">
						<i class="fas fa-times"></i> Cerrar
					</button>
					<button type="button" class="btn btn-sm btn-primary btn-add-destinatario" data-toggle="modal" data-target="#manageDestinatario" data-toggle2="tooltip" data-placement="left" title="Añadir manageDestinatario">
						<i class="fas fa-plus"></i> Añadir Destinatario
					</button>

				</div>
		</div>
	</div>
</div>


<!-- Modal agregar destinatario -->
<div class="modal fade" id="manageDestinatario" tabindex="-1" aria-labelledby="manageDestinatario" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form  method="post" id="form_save_destinatario">
				<div class="modal-header">
					<h5 class="modal-title" id="manageDestinatarioLabel"><i class="fas fa-plus"> </i>  Agregar destinatario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
       	        <div class="modal-body">
					<div class="row" id="rowModal">
						<div class="col-lg-12">
							<!-- datos destinatario -->
							<div class="my-4 text-center">
								<h4>Datos de Destinatario</h4>
							</div>

							<div class="form-group row">
								<label for="correoDeEnvio" class="col-sm-4 col-form-label text-sm-right">
								Correo de envío:
								</label>
								<div class="col-sm-7">
								<input type="text" required class="form-control" name="correoDeEnvio" id="correoDeEnvio">
								</div>
							</div>
                            <div class="form-group row">
								<label for="phoneDeEnvio" class="col-sm-4 col-form-label text-sm-right">
								Teléfono de envío:
								</label>
								<div class="col-sm-7">
								<input type="text" required class="form-control" name="phoneDeEnvio" id="phoneDeEnvio">
								</div>
							</div>
                            <input type="text" hidden class="form-control" name="idAlertRelEmpresa" id="idAlertRelEmpresa">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
						<i class="fas fa-times"></i> Cerrar
					</button>
					<button type="submit" class="btn btn-sm btn-primary" id="guardar-encuesta">
						<i class="fas fa-save"></i> Guardar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="/assets/js/alertas_empresa/list.js?v=1.1"></script>