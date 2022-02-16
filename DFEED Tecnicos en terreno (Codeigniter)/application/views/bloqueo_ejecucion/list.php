<div class="card-header">
	<div class="row">
		<div class="col-10">
			<h4 class="card-title m-0 font-weight-bold">
				<i class="fa fa-briefcase"></i> Listado de bloqueos
			</h4>
		</div>
		<div class="col-2 text-right">
			<button class="btn btn-primary btn-sm btn-add-bloqueo" data-toggle="modal" data-target="#manageBloqueo" data-toggle2="tooltip" data-placement="left" title="Añadir bloqueo">
				<i class="fas fa-plus"></i>
			</button>
		</div>
	</div>
</div>

<div class="card-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table id="datatable" cellspacing="0" width="100%" style="width: 100%;" class="table table-hover">
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="manageBloqueo" tabindex="-1" aria-labelledby="manageBloqueo" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/bloqueo/save" method="post" id="form_save_bloqueo" >
				<div class="modal-header">
					<h5 class="modal-title" id="manageBloqueoLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group row">
								<label for="nombreEmpresa" class="col-sm-4 col-form-label text-right">
									Tipo de bloqueo :
								</label>
								<div class="col-sm-7">
									<select class="form-control" name="typeBloqueo" id="typeBloqueo">
										<option value="0">Selecciona</option>
										<option value="1">Dia de la semana</option>
										<option value="2">Fecha</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label id="tipoBloqueo" class="col-sm-4 col-form-label text-right"></label>
								<div id="bloqueVal" class="col-sm-7" ></div>
							</div>

							<div class="form-group row">
								<div class="col-sm-7 col-sm-offset-4">
									<div class="custom-control custom-switch">
										<input type="checkbox" class="custom-control-input" name="estatusBloqueo" id="estatusBloqueo" checked>
										<label class="custom-control-label" for="estatusBloqueo">
											Estatus
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="array_post[colorTiempoRestante]" class="col-sm-4 control-label morado text-right">Comentario</label>
								<div class="col-sm-7">
									<input name="comentarioBloque" id="comentarioBloque" class=" form-control text-center" />
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
						<i class="fas fa-times"></i> Cerrar
					</button>
					<button type="submit" class="btn btn-sm btn-primary">
						<i class="fas fa-save"></i> Guardar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="/assets/js/bloqueo/list.js?v=1.4"></script>
