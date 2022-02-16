<?php

defined('BASEPATH') or exit('No direct script access allowed');
define("URI", "agenda_whatsapp");
define("FOLDER_VIEW", "agenda_whatsapp");

class Agenda_whatsapp extends MY_Controller implements CriteriaPattern
{
	function __construct()
	{

		parent::__construct();
		$this->load->model('orders_model');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$idPerfil = $this->session->userdata('id_perfil');

		if (!$this->ion_auth->is_grupo($idPerfil, '22')) {
			$this->session->set_flashdata('flashMessage', 7);
			redirect('user/account');
		}

//		$this->data['list'] = json_encode($this->CriteriaSearch(
//			[
//				'currentEstatus' => 1,
//				'sendScheduler' => 1,
//				'draw' => intval($this->input->get("draw")) ?? 1,
//				'offset' => intval($this->input->get("start"))  ?? 0,
//				'limit' => intval($this->input->get("length")) ?? 10,
//				'dateInit' => $this->input->get("dateInit") ? DateTime::createFromFormat('d/m/Y', $this->input->get("dateInit"))->format('Y-m-d') : DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('Y-m-d'),
//				'dateEnd' => $this->input->get("dateEnd") ? DateTime::createFromFormat('d/m/Y', $this->input->get("dateEnd"))->format('Y-m-d') : DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('Y-m-d'),
//				'id_empresa' => $this->input->get('id_empresa') ? (int)$this->input->get('id_empresa') : 0,
//				'orderFields' => [['idOrder', 'DESC']]
//			])
//		);

		$this->render(FOLDER_VIEW . '/index');
	}

	public function CriteriaSearch($filters)
	{
		$response = new stdClass;

		$response->total = $this->orders_model->count($filters['dateInit'], $filters['dateEnd'], $filters['id_empresa'], $filters['currentEstatus'], '', $filters['sendScheduler']);
		$response->filtered = $filtered = count($this->orders_model->find('', $filters['limit'], $filters['offset'], $filters['orderFields'], $filters['dateInit'], $filters['dateEnd'], $filters['id_empresa'], '', $filters['currentEstatus'], '', '', $filters['sendScheduler']));
		$response->data  = $this->orders_model->find('', $filters['limit'], $filters['offset'], $filters['orderFields'], $filters['dateInit'], $filters['dateEnd'], $filters['id_empresa'], '', $filters['currentEstatus'], '', '', $filters['sendScheduler']);

		return $response;
	}
}
