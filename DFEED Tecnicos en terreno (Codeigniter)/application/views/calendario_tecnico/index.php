<?php
// variables enviadas por POST.
$search_value;
$lista_calendarios;
$pagination;

?>

<div class="list">
	<ol class="breadcrumb" style="margin-top: 4px;">
		<li title="Volver a la página anterior">
			<i class="fa fa-arrow-left"></i>
			<a href="/calendario_tecnico">
				<strong style="color:black;"> Volver</strong>
			</a>
		</li>
		<li><a href="/calendario_tecnico"><strong>Calendarios de T&eacute;cnico</strong></a></li>
		<li class="active"><strong> Buscar </strong></li>
	</ol>

	<div class="container-fluid menu-content">
		<div class="container">
			<div class="row">
				<div class="col-md-3 button-content">
					<a href="<?php echo site_url('calendario_tecnico/create'); ?>" class="btn btn-default">
						<i class="fa fa-calendar-plus-o morado" aria-hidden="true"></i> Crear</a>
				</div>
				<div class="col-md-6">
					<?php echo form_open(site_url('calendario_tecnico/index'), array('method' => 'get')); ?>
					<div class="input-group">
						<?php echo form_input(array('type' => 'text', 'name' => 'value', 'class' => 'form-control', 'placeholder' => 'Filtro', 'value' => $search_value, 'id' => 'search-value', 'autocomplete' => 'off')) ?>
						<div class="input-group-append">
							&nbsp;&nbsp;
							<button class="btn btn-default morado" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
							&nbsp;&nbsp;
							<button id="btn_clear_find" class="btn btn-info" type="button"><i class="fa fa-eraser" aria-hidden="true"></i></button>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container ">
		<div class="row">
			<div class="col-md-12 mt-4">

				<?php if (count($lista_calendarios) > 0) { ?>

					<div class="table-responsive">
						<?php echo form_open(site_url('calendario_tecnico/delete'), array('id' => 'list-form')) ?>
						<input type="hidden" name="id_eliminar" id="id_eliminar" value="">

						<table class="table table-hover table-bordered" id="list-table">

							<thead style="background-color: #702670;color: white;">
								<tr>
									<th>Nombre de el calendario</th>
									<th>Descripci&oacute;n de el calendario</th>
									<th class="with-icon">Editar</th>
									<th class="with-icon">Eliminar</th>
									<th class="with-icon">Status</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($lista_calendarios as  $array_post) :

									if ($array_post['Active'] == 1) {
										$title_td = "Desactivar";
										$uri_td = "calendario_tecnico/deactivate";
										$class_td = "btn-success";
									} else {
										$title_td = "Activar";
										$uri_td = "calendario_tecnico/activate";
										$class_td = "btn-danger";
									}
								?>

									<tr>
										<td><?php echo $array_post['NameCalendar'] ?></td>
										<td><?php echo $array_post['Description'] ?></td>
										<td>
											<a title="Editar" class="nav-link" href="<?php echo site_url('calendario_tecnico/edit/' . $array_post['Id']) ?>">
												<i class="fa fa-pencil-square-o " aria-hidden="true"></i>
											</a>
										</td>
										<td>
											<a title="Eliminar" class="nav-link" href="" data-title="Eliminar periodo" data-message="¿Estás seguro que deseas eliminar el Calendario Tecnico <?php echo $array_post['NameCalendar'] ?>?" data-function="deleteCalendario" data-param="<?php echo $array_post['Id'] ?>" data-toggle="modal" data-target="#normal-modal">
												<i class="fa fa-trash" aria-hidden="true"></i>
											</a>
										</td>
										<td>
											<a class="btn <?= $class_td ?> btn-sm" href="<?php echo site_url($uri_td . '/' . $array_post['Id']) ?>" title="<?= $title_td ?>" href="#" role="button"><?= $title_td ?></a>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>

				<?php } else {

					if ($search_value != "") {
						echo "<p class='message-no-data'>No existen resultados con los criterios de búsqueda ingresados.</p>";
						echo "<p class='message-no-data link'><a href='" . site_url('calendario_tecnico/index') . "'>Volver al inicio</a></p>";
					} else {
						echo "<p class='message-no-data'>El sistema aun no registra informaci&oacute;n.</p>";
					}
				} ?>

			</div>
		</div>

		<div class="row">
			<div class="col-md-12 pagination-content">
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<?php echo $pagination; ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(function() {

		<?php if ($search_value) : ?>
			$("#search-value").focus();
			$("#search-value").val($("#search-value").val());
		<?php endif ?>

		$("#btn_clear_find").on("click", function() {
			window.location.href = "/calendario_tecnico/index";
		});

		//mensaje.
		<?php $message_form = $this->session->flashdata('message_form');
		$message_type_form = $this->session->flashdata('message_type_form');

		if (isset($message_form)) { ?>
			swal("Alerta", "<?= $message_form ?>", "<?= $message_type_form ?>");
		<?php	} ?>


	});

	$(document).on('click', '#accept-button-modal.deleteCalendario', function() {
		let id_eliminar = ($(this).data('param'));
		let formulario = $('#list-form');
		$('#id_eliminar').val(id_eliminar);
		formulario.submit();
		$('#normal-modal').modal('hide');

	})
</script>
