<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bloqueo_ejecucion extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('bloqueo_ejecucion_model');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$breadcumb = '<ol class="breadcrumb">
			<li class="breadcrumb-item" onclick="history.back()">
				<a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="Volver a la página anterior" >
					<strong><i class="fas fa-arrow-left"></i> Volver</strong>
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/bloqueo">
					<strong>Bloqueo</strong>
				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				<strong>
					Listado
				</strong>
			</li>
		</ol>';

		$this->render('/bloqueo_ejecucion/list', 'master', $breadcumb);
	}

	public function list()
	{
		// Datatables Variables
		$bddColumnsName = [
			'idSchBlock',
			'blockType',
			'DATE_FORMAT(blockValue, "%d/%m/%Y")',
			'statusBlock',
			'commentBlock'
		];
		$draw      = intval($this->input->get("draw"));
		$offset    = intval($this->input->get("start"));
		$limit     = intval($this->input->get("length"));
		//$columns    = $this->input->get("columns");
		$orderBy    = $this->input->get("order") ? $this->input->get("order") : [];
		$search     = $this->input->get("search") ? $this->input->get("search")['value'] : '';

		$orderFields = [['id', 'ASC']];
		if (!empty($bddColumnsName)) {
			$orderFields = [];
			foreach ($orderBy as $k => $col) {
				$colName = $bddColumnsName[$col['column']]; // nombre de la columna en bdd
				$colDir  = $col['dir'];    // direccion del orden
				$orderFields[] = [$colName, $colDir];
			}
		}

		$total  = $this->bloqueo_ejecucion_model->count();
		$filtered = $this->bloqueo_ejecucion_model->count($search);
		$data = $this->bloqueo_ejecucion_model->find($search, $limit, $offset, $orderFields);

		$output = array(
			"draw"              => $draw,
			"recordsTotal"      => $total,
			"recordsFiltered"   => $filtered,
			"data"              => $data
		);
		echo json_encode($output);

		exit();
	}

	public function create()
	{

		$blockType = $this->input->post('blockType')
			? trim($this->input->post('blockType'))
			: '';

		$commentBlock = $this->input->post('commentBlock')
			? trim($this->input->post('commentBlock'))
			: '';

		$statusBlock  = $this->input->post('statusBlock')
			? ($this->input->post('statusBlock') === 'true' ? TRUE : FALSE)
			: 0;

		$blockValue = $this->input->post('blockValue')
			? trim($this->input->post('blockValue'))
			: '';

		$code = 0;
		$message = 'OK';

		$blockValue = intval($blockType) == 2 ? DateTime::createFromFormat('d/m/Y', $blockValue)->format('Y-m-d') : $blockValue;


		if (empty($blockType) || $blockType == 0 || $blockValue == '') {
			$code    = 400;
			$message = 'Debe ingresar el tipo de bloqueo';
		} else {
			$bloqueo_data = array(
				'blockType' => $blockType,
				'commentBlock' => $commentBlock,
				'statusBlock' => $statusBlock,
				'blockValue' => $blockValue,
				'createdAt' => date('Y-m-d H:i:s')
			);

			$create = $this->bloqueo_ejecucion_model->create($bloqueo_data);
			if (!$create) {
				$code    = 500;
				$message = 'No se pudo crear la provincia';
			} else {
				$code = 0;
				$message = 'Provincia creada correctamente.';
			}
		}

		$response = new stdClass;
		$response->code = $code;
		$response->message = $message;
		echo json_encode($response);
	}

	public function edit($id)
	{
	
		$id = preg_replace('/[^0-9]/s', '', $id);
		$blockType = $this->input->post('blockType')
			? trim($this->input->post('blockType'))
			: '';

		$commentBlock = $this->input->post('commentBlock')
			? trim($this->input->post('commentBlock'))
			: '';

		$statusBlock  = $this->input->post('statusBlock')
			? ($this->input->post('statusBlock') === 'true' ? TRUE : FALSE)
			: 0;

		$blockValue = $this->input->post('blockValue')
			? trim($this->input->post('blockValue'))
			: '';

		$blockValue = intval($blockType) == 2 ? DateTime::createFromFormat('d/m/Y', $blockValue)->format('Y-m-d') : $blockValue;

		$code = 0;
		$message = 'OK';

		if (empty($id)) {
			$code    = 400;
			$message = 'Debe ingresar un id de bloqueo';
		} else if (empty($blockType)) {
			$code    = 400;
			$message = 'Debe ingresar el tipo de bloqueo';
		} else {
			$bloqueo_data = array(
				'blockType' => $blockType,
				'commentBlock' => $commentBlock,
				'statusBlock' => $statusBlock,
				'blockValue' => $blockValue
			);

			$create = $this->bloqueo_ejecucion_model->edit($id, $bloqueo_data);
			if (!$create) {
				$code    = 500;
				$message = 'No se pudo modificar el bloqueo';
			} else {
				$code = 0;
				$message = 'Bloqueo modificado correctamente.';
			}
		}

		$response = new stdClass;
		$response->code = $code;
		$response->message = $message;
		echo json_encode($response);
	}

	public function delete($id = 0)
	{
	

		$id = preg_replace('/[^0-9]/s', '', $id);
		$code = 0;
		$message = 'OK';
		if (empty($id)) {
			$code    = 400;
			$message = 'Debe ingresar un id de bloqueo';
		} else {
			// Busco la empresa
			$dataBloqueo = $this->bloqueo_ejecucion_model->get($id);
			if (empty($dataBloqueo)) {
				$code    = 404;
				$message = 'Bloqueo no encontrado o ya eliminada.';
			} else {
				$id_bloqueo = $dataBloqueo["idSchBlock"];
				$result = $this->bloqueo_ejecucion_model->delete($id);
				if (!$result) {
					$code    = 500;
					$message = 'No se pudo eliminar el Bloqueo';
				} else {
					$code = 0;
					$message = "Bloqueo : {$id_bloqueo} eliminado correctamente.";
				}
			}
		}

		$response = new stdClass;
		$response->code = $code;
		$response->message = $message;
		echo json_encode($response);
	}

	public function get($id = 0)
	{
		$response = new stdClass;
		if (empty($id)) {
			$response->code = 400;
			$response->message = 'Debe enviar id de bloqueo';
		} else {
			$data = $this->bloqueo_ejecucion_model->get($id);
			if (empty($data)) {
				$response->code = 404;
				$response->message = 'Bloqueo no existe';
			} else {
				$response->code = 200;
				$response->message = 'OK';
				$response->data = $data;
			}
		}

		echo json_encode($response);
	}

	public function diaFechaBloqueo($dia, $fecha){
		$data = $this->bloqueo_ejecucion_model->validDiaFechaBloqueo($dia, $fecha);

		$response = new stdClass;
		$response->code = is_null($data) ? 0 : 1;
		$response->message = $data;
		echo json_encode($response);
	}
}
