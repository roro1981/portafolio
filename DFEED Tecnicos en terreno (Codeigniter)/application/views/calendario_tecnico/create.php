<?php
$arrayDayWeek = array(
	1 => 'Lunes',
	2 => 'Martes',
	3 => 'Miercoles',
	4 => 'Jueves',
	5 => 'Viernes',
	6 => 'Sabado',
	0 => 'Domingo'
);

?>
<div class="list">
	<ol class="breadcrumb" style="margin-top: 4px;">
		<li title="Volver a la página anterior">
			<i class="fa fa-arrow-left"></i>
			<a href="/calendario_tecnico"><strong style="color:black;"> Volver</strong></a>
		</li>
		<li><a href="/calendario_tecnico"><strong>Mantenedores</strong></a></li>
		<li><a href="/calendario_tecnico"><strong>Calendario del T&eacute;cnico</strong></a></li>
		<li class="active"><strong> Crear </strong></li>
	</ol>
</div>

<div class="container-fluid">
	<div class="col-sm-10 offset-sm-1">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-info-circle"></i> Por favor ingrese los datos solicitados:</h3>
			</div>
			<div class="panel-body">
				<?php
				if (isset($edit)) {
					echo form_open('calendario_tecnico/edit/' . $array_post['Id'], array('id' => 'edit-form', 'class' => 'form-horizontal'));
					echo form_hidden('array_post[Id]', $array_post['Id']);
				} else {
					echo form_open('calendario_tecnico/create', array('class' => 'form-horizontal'));
				}
				?>

				<div class="form-group">
					<label for="array_post[NameCalendar]" class="col-sm-4 control-label morado">Nombre del calendario</label>
					<div class="col-sm-8">
						<?php echo form_input(
							array(
								'type' => 'text',
								'name' => 'array_post[NameCalendar]',
								'maxlength'     => '45',
								'autocomplete' => 'off',
								'title' => 'Ingrese solo caracteres alfabéticos sin acento',
								'class' => 'form-control',
								'value' => set_value('array_post[NameCalendar]', isset($array_post['NameCalendar']) ? $array_post['NameCalendar'] : '')
							)
						); ?>

					</div>
				</div>

				<div class="form-group">
					<?php echo form_error('array_post[NameCalendar]'); ?>
				</div>

				<div class="form-group">
					<label for="array_post[Description]" class="col-sm-4 control-label morado">Descripci&oacute;n del calendario</label>
					<div class="col-sm-8">
						<?php echo form_input(
							array(
								'type' => 'text',
								'name' => 'array_post[Description]',
								'maxlength'     => '45',
								'autocomplete' => 'off',
								'title' => 'Ingrese solo caracteres alfabéticos sin acento ',
								'class' => 'form-control',
								'value' => set_value('array_post[Description]', isset($array_post['Description']) ? $array_post['Description'] : '')
							)
						); ?>

					</div>
				</div>

				<div class="form-group">
					<?php echo form_error('array_post[Description]'); ?>
				</div>
				<hr>
				<div class="form-group">
					<div class="col-sm-10 offset-sm-1">
						<table class="table table-bordered">
							<caption style="text-align:center">Informaci&oacute;n de la jornada laboral</caption>
							<thead>
								<tr>
									<td align="center" class="morado" colspan="2" rowspan="2"><strong>D&iacute;as</strong></td>
									<td align="center" class="morado" colspan="3"><strong>Inicio de jornada</strong></td>
									<td align="center" class="morado" colspan="3"><strong>Fin de jornada</strong></td>
								</tr>
								<tr>
									<td align="center" class="morado"><strong>hora</strong></td>
									<td align="center" class="morado"><strong></strong></td>
									<td align="center" class="morado"><strong>minutos</strong></td>
									<td align="center" class="morado"><strong>hora</strong></td>
									<td align="center" class="morado"><strong></strong></td>
									<td align="center" class="morado"><strong>minutos</strong></td>
								</tr>

							</thead>
							<tbody>
								<?php foreach ($arrayDayWeek as $day => $nameDay) {

									if (!isset($timeSelected['ExistDay'][$day])) {
										$timeSelected['ExistDay'][$day] = 0;
										$timeSelected['StartHour'][$day] = "";
										$timeSelected['EndHour'][$day] = "";
										$timeSelected['StartMinute'][$day] = "";
										$timeSelected['EndMinute'][$day] = "";
									}

									$check_selected = $timeSelected['ExistDay'][$day] == 1 ? TRUE : FALSE;

								?>
									<tr class="active">
										<td align="center">
											<div class="checkbox">
												<label>
													<?php echo form_checkbox(array('name' => 'array_post[checkDay][]', 'value' => $day, 'checked' => $check_selected)); ?>
												</label>
											</div>
										</td>
										<td class="morado"><strong><?= $nameDay ?></strong></td>
										<td align="center">
											<?php echo form_dropdown(array('name' => "array_post[startHour][$day]", 'class' => 'form-control'), $array_horas, $timeSelected['StartHour'][$day]); ?>
										</td>
										<td align="center">:</td>
										<td align="center">
											<?php echo form_dropdown(array('name' => "array_post[startMinute][$day]", 'class' => 'form-control'), $array_minutos, $timeSelected['StartMinute'][$day]); ?>
										</td>
										<td align="center">
											<?php echo form_dropdown(array('name' => "array_post[endHour][$day]", 'class' => 'form-control'), $array_horas, $timeSelected['EndHour'][$day]); ?>
										</td>
										<td align="center">:</td>
										<td align="center">
											<?php echo form_dropdown(array('name' => "array_post[endMinute][$day]", 'class' => 'form-control'), $array_minutos, $timeSelected['EndMinute'][$day]); ?>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="form-buttons">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
							<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Borrar</button>
						</div>
					</div>
				</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {

		<?php $message_form = $this->session->flashdata('message_form');
		$message_type_form = $this->session->flashdata('message_type_form');

		if (isset($message_form)) { ?>
			swal("Alerta", "<?= $message_form ?>", "<?= $message_type_form ?>");
		<?php	} ?>


		$("input[type='checkbox']").on('change', function() {
			$(this).closest('tr').find('select').attr('disabled', !($(this).prop('checked')));
			if (!$(this).prop('checked')) {
				$(this).closest('tr').find('select').val("");
			}
		});

		$("input:checkbox").each(
			function() {
				$(this).closest('tr').find('select').attr('disabled', !($(this).prop('checked')));
			}
		);

	});
</script>