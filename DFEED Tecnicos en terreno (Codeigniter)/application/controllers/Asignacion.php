<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . '/libraries/Classes/PHPExcel.php';
require_once APPPATH . '/libraries/Classes/fpdf.php';
require_once APPPATH . '/libraries/dBug.php';
//require_once INTERFACE_HOME_PATH . '/application/libraries/Classes/html2pdf.php';
require_once APPPATH . '/libraries/TCPDF/config/tcpdf_config.php';
require_once APPPATH . '/libraries/TCPDF/tcpdf.php';

require_once APPPATH . '/helpers/PdfHelper.php';
include_once APPPATH . '/third_party/mpdf/mpdf.php';
//error_reporting(1);

ini_set('display_errors', 1);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set('America/Santiago');
ini_set('upload_max_filesize', '400M');
ini_set('post_max_size', '400M');
ini_set('max_input_time', 500);
ini_set('max_execution_time', 500);
ini_set('memory_limit', '512M');

class Asignacion extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('tracking_model');
		$this->load->model('tecnicos_model');
		$this->load->model('orders_model');
		$this->load->model('formdynamic_model');
		$this->load->model('ticket_model');
		$this->load->model('notificaciones_model');
		$this->load->model('empresa_model');
		$this->load->model('menu_model');
		$this->load->model('functions_model');

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}

		$idPerfil = $this->session->userdata('id_perfil');
		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));



		if (!$this->menu_model->existMenuInPerfil($idPerfil, $idMenus)) {
			$this->session->set_flashdata('flashMessage', 7);
			redirect('user/account');
		}
	}

	public function asignar()
	{
		$idPerfil = $this->session->userdata('id_perfil');

		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));
		$idFunctions = $this->functions_model->validateFunction(
			strtoupper(__FUNCTION__), $idMenus
		);

		if(count($idFunctions) == 0){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('tracking/tickets');
		}

		if (!$this->functions_model->existFunctionInPerfil($idPerfil, $idFunctions)) {
			$this->session->set_flashdata('flashMessage', 7);
			redirect('tracking/tickets');
		}

		$ticket     = $this->input->get('ticket')     ?? '';
		$type       = $this->input->get('type')       ?? '';
		$id_empresa = $this->input->get('id_empresa') ?? 0;

		$idCompanySelected = $this->selectCompany;
		if (!empty($id_empresa) && $this->isFromTelefonica) {
			$idCompanySelected = $id_empresa;
		}
		$data['selectCompany'] = $idCompanySelected;

		$data['title'] = "Asignar Ticket";
		$data['flashMessage'] = $this->session->flashdata('flashMessage');

		$data['sla'] = $this->tracking_model->getSla();
		$data['ticketsOpen'] = $this->tracking_model->getTicketOpen($ticket, $idCompanySelected);
		$data['form'] = $this->ticket_model->get_formAct_dropdown();
		$data['status']        = $this->tracking_model->getSkillsDropdown();


		$breadcumb = '
        <div class="list">
            <ol class="breadcrumb" style="margin-top: 4px;">
                <li title="Volver a la página anterior">
                    <a href="javascript:goBack()">
                        <strong><i class="fa fa-arrow-left"></i> Volver</strong>
                    </a>
                </li>
                <li><a href="/tracking/asignar"><strong>Asignar</strong></a></li>
                <li class="active"><strong>' . $data['title'] . '</strong></li>
            </ol>
        </div>';

		$this->data = $data;
		$this->render('tracking/asignar', 'master', $breadcumb);
	}

	public function ordenesFueraCalendario(){
		$response = new stdClass;
		$response->code = 0;
		$response->message = 'OK';

		$idTickets = $this->input->post("idTickets") ? $this->input->post("idTickets") : array();
		$id_tech  = $this->input->post("idTech")   ? (int)$this->input->post("idTech")   : 0;

		if ($id_tech != 0) {
			$final = stripslashes($this->tracking_model->ordenesFueraCalendario($idTickets, $id_tech));
			$corcheteAbierto = (str_replace('"[', '[', $final));
			$corcheteCerrado = (str_replace(']"', ']', $corcheteAbierto));
			$response->message = json_decode($corcheteCerrado);
		} else {
			$response->code = 1;
			$response->message = 'Debe enviar la orden y técnico a asignar';
		}

		print_r(json_encode($response));
	}

	public function getTechAvailableForOrder()
	{

		$response = new stdClass;
		$response->code = 0;
		$response->message = "Consulta exitosa";

		$idOrder = $this->input->post("idOrder")
			? (int)preg_replace('/[^0-9]/s', '', $this->input->post("idOrder"))
			: 0;

		$id_empresa = $this->input->post("id_empresa")
			? (int) $this->input->post("id_empresa")
			: 0;

		if (!empty($idOrder)) {

			$detail = $this->tracking_model->getOrderZoneAndSlot($idOrder);

			$data["idPool"] = $detail["idPool"];
			$data["IdZona"] = $detail["idZona"];
			$data['id_empresa'] = $id_empresa;
//            $data["workingPeriod"] = $detail["workingPeriod"];
//
//            $skills = $this->tracking_model->getOrdersSkills($idOrder);
//
//            $idskills = [];
//            foreach ($skills as $key => $value) {
//                $idskills[] = $value["idSkill"];
//            }
//
//            $data["idSkills"] = implode(",", $idskills);

			$tecnicos = $this->tracking_model->getTechAvailableForOrder($data, $idOrder);

			if (empty($tecnicos)) {
				$response->code = 1;
				$response->message = "No hay técnicos disponibles con las caracteristicas de la orden";
			} else {
				$response->data = $tecnicos;
			}
		} else {
			$response->code = 1;
			$response->message = "Campos enviados no son validos";
		}



		echo json_encode($response);
	}

	public function reasignar()
	{

		$idPerfil = $this->session->userdata('id_perfil');

		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));
		$idFunctions = $this->functions_model->validateFunction(
			strtoupper(__FUNCTION__), $idMenus
		);

		if(count($idFunctions) == 0){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('tracking/tickets');
		}

		if (!$this->functions_model->existFunctionInPerfil($idPerfil, $idFunctions)) {
			$this->session->set_flashdata('flashMessage', 7);
			redirect('tracking/tickets');
		}

		$dataFilter["ticket"] = addslashes(trim($_REQUEST["asignar"]["ticket"]));
		$dataFilter["type"] = addslashes(trim($_REQUEST["asignar"]["type"]));

		$user_id = $this->session->userdata('user_id');

		$data['title'] = "Reasignar Orden";
		$data['flashMessage'] = $this->session->flashdata('flashMessage');

		$data['sla'] = $this->tracking_model->getSla();
		$data['ticketsOpen'] = $this->tracking_model->getTicketAsignados($gruposUser, $dataFilter);
		$data['form'] = $this->ticket_model->get_formAct_dropdown();

		$data['sites'] = $this->ticket_model->getSite();
		$data['zonas'] = $this->tracking_model->getZonal();
		$data['ciudad'] = $this->tracking_model->getCiudad();
		$data['pagination'] = $this->pagination->create_links();
		$this->data = $data;
		$this->render('tracking/reasignar');
	}

	public function getDetailTicket()
	{

		$ticket = $_POST["idTicket"];

		$data['ticket'] = $this->tracking_model->getIncIdencia($ticket);
		// $data['detailTicket'] = $this->tracking_model->getDetailIncIdencia($ticket);

		$this->load->view('tracking/detailTicketAsignar', array('data' => $data));
	}

	public function getDetailTicketForm()
	{

		$ticket = $_POST["idTicket"];

		// //echo $ticket;
		$data['ticket'] = $this->tracking_model->getIncIdencia($ticket);
		$data['detailTicket'] = $this->tracking_model->getDetailIncIdenciaForm($ticket);

		// print_r($data['ticket']);
		//print_r($data['detailTicket']);
		// $this->data = $data;
		// //$this->render('tracking/historicoTicked');
		// //$this->load->view('tracking/historicoTicked');
		//  $this->load->view('tracking/asignarDetailTicket', array('data' => $data));
		//$data['getTechAvailable'] = $this->tracking_model->getTechAvailable();
		// $data['ticketsOpen'] = $this->tracking_model->getTicketOpen();
		//$this->render('tracking/asignarDetailTicket');
		$this->load->view('tracking/asignarDetailTicketForm', array('data' => $data));
	}

	public function getDetailTicketForIdTech()
	{

		$idTech = $_POST["idTech"];
		$data['ticket'] = $this->tracking_model->getIncIdenciaIdTech($idTech);
		$ticket = $data['ticket'][0]['id'];
		$data['detailTicket'] = $this->tracking_model->getDetailIncIdencia($ticket);
		$this->data = $data;
		$this->load->view('tracking/asignarDetailTicket', array('data' => $data));
	}

	public function delete()
	{
		$idPerfil = $this->session->userdata('id_perfil');

		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));
		$idFunctions = $this->functions_model->validateFunction(
			strtoupper(__FUNCTION__), $idMenus
		);

		if(count($idFunctions) == 0){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('user/account');
		}

		if (!$this->functions_model->existFunctionInPerfil($idPerfil, $idFunctions)) {
			$this->session->set_flashdata('flashMessage', 7);
			redirect('user/account');
		}

		if ($user = $this->input->post('user')) {
			$result = $this->tracking_model->delete($user['id'][0]);
			if ($result) {
				$this->session->set_flashdata('flashMessage', 0);
			} else {
				$this->session->set_flashdata('flashMessage', -1);
			}
		}
		redirect('tracking/tickets');
	}

	public function showModal()
	{

		$incident = $this->input->post('incident');
		$idTech = $this->input->post('idTech');
		$data['ticket'] = $this->tracking_model->getIncident($incident);
		$data['positionTech'] = $this->tracking_model->getPositionTech($idTech);
		$data['positionClient'] = $this->tracking_model->getPositionClient($incident);
		$this->data = $data;
		$this->load->view('tracking/modalDirections', array('data' => $data));
	}

	public function asignarTicket()
	{
		$response = new stdClass;

		$response->code = 1;

		$idPerfil = $this->session->userdata('id_perfil');

		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));
		$idFunctions = $this->functions_model->validateFunction(
			strtoupper(__FUNCTION__), $idMenus
		);

		if(count($idFunctions) == 0){
			$this->session->set_flashdata('flashMessage', 7);
			$response->message = 'No posee los permisos para realizar esta acción';
			return print_r(json_encode($response));
		}

		if (!$this->functions_model->existFunctionInPerfil($idPerfil, $idFunctions)) {
			$this->session->set_flashdata('flashMessage', 7);
			$response->message = 'No posee los permisos para realizar esta acción';
			return print_r(json_encode($response));
		}

		$idTickets = $this->input->post("idTickets") ? $this->input->post("idTickets") : [];
		$id_tech  = $this->input->post("idTech")   ? (int)$this->input->post("idTech")   : 0;

		if (count($idTickets) > 0 && $id_tech > 0) {
			$sentToAssign = [];

			$this->tracking_model->deleteTrazerIncident($idTickets);

			foreach ($idTickets as $ticket) $sentToAssign[] = $this->tracking_model->assignOrderToTech($ticket, $id_tech);
			$response->code = 0;
			$response->data = $sentToAssign;
		} else {
			$response->code = 1;
			$response->message = 'Debe enviar la orden y técnico a asignar';
		}

		print_r(json_encode($response));
	}

	public function reAsignarTicket()
	{
		$result = "NOK";

		$idPerfil = $this->session->userdata('id_perfil');

		$idMenus = $this->menu_model->validateMenu(strtoupper(get_class($this)));
		$idFunctions = $this->functions_model->validateFunction(
			strtoupper(__FUNCTION__), $idMenus
		);

		if(count($idFunctions) == 0){
			$this->session->set_flashdata('flashMessage', 7);
			return print_r($result);
		}

		if (!$this->functions_model->existFunctionInPerfil($idPerfil, $idFunctions)) {
			$this->session->set_flashdata('flashMessage', 7);
			return print_r($result);
		}

		$idOrder = $_POST["idTicket"];
		$id_tech = $_POST["idTech"];

		$id_user = $this->session->userdata('user_id');


		$this->tracking_model->deleteTrazerIncident($idOrder);


		if ($this->tracking_model->checkifSentExist($idOrder, $id_tech) == 0) {
			$data['asignar'] = $this->tracking_model->createFreelanceSent($idOrder, $id_tech);
		}


		$data['asignar'] = $this->tracking_model->changeStatusOrderToAssign($idOrder);


		$sentToAssign = $this->tracking_model->assignOrderToTech($idOrder, $id_tech);

		if ($sentToAssign['code'] == 0)
			$result = "OK";

		return print_r($result);
	}

	public function tecnico()
	{
		$idTicket = $_POST["idTicket"];
		$idTech = $_POST["idTech"];
		$data['asignar'] = $this->tracking_model->getTecnico($idTicket, $idTech);
		return print_r(($data['asignar']));
	}

	public function cargarTecnicosAll()
	{
		$tecnicos = $this->tecnicos_model->findSelectAllTecnicos($this->input->get('term'), 10, $this->input->get('page'));
		$countTotal = $this->tecnicos_model->count($this->input->get('term'));
		$offset = ($this->input->get('page') - 1) * 10;

		$endCount = $offset + 10;
		$morePages =  $countTotal > $endCount;

		$result = array(
			'results' => $tecnicos,
			'pagination' => array(
				"more" => $morePages
			)
		);

		return print_r(json_encode($result, true));
	}
}
