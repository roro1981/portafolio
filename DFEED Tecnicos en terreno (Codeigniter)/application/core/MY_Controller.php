<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . '/libraries/dBug.php';

class MY_Controller extends CI_Controller
{
	protected $data = array();
	protected $isFromTelefonica = FALSE;
	protected $isAdminSDC = FALSE;
	protected $isTelefonica = FALSE;
	protected $skillsProfile = [];
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model');
		$this->load->model('habilidades_model');
		
		$this->isAdminSDC       = (int)$this->session->userdata('user_id') === 1;
		/*$this->isFromTelefonica = ((int)$this->session->userdata('is_admin') === 1 || (int)$this->session->userdata('user_id') === 1)
			? TRUE
			: FALSE; // si es admin muestro el selector de empresas

		$this->selectCompany    = ((int)$this->session->userdata('is_admin') === 1 || (int)$this->session->userdata('user_id') === 1)
			? ''
			: $this->session->userdata('id_empresa'); // si no es admin, tomo la empresa por defecto*/
		$this->isFromTelefonica = $this->session->userdata('id_empresa')
			? (int)$this->session->userdata('id_empresa') === 1 || (int)$this->session->userdata('is_admin') === 1
			: FALSE; // si es admin telefonica
		//$this->selectCompany    = ( ($this->session->userdata('id_empresa'))
	    //&& (int)$this->session->userdata('id_perfil') !== 1)
		//	? $this->session->userdata('id_empresa')
		//	: ''; // empresa del usuario

		$this->selectCompany    = ($this->session->userdata('id_empresa') )
			? $this->session->userdata('id_empresa')
			: ''; // empresa del usuario
		$this->isTelefonica     = $this->session->userdata('id_empresa') == 2;
	}

	protected function render($view = NULL, $template = 'master', $breadcumb = '')
	{
		if ($template == 'json' || $this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			//echo json_encode($this->data);
		} else {
			$this->data['isFromTelefonica'] = $this->isFromTelefonica;
			$this->data['isAdminSDC'] = $this->isAdminSDC;
			$this->data['breadcumb'] = $breadcumb;
			if (!isset($this->data['selectCompany'])) {
			    $this->data['selectCompany'] = $this->selectCompany;
			}
			$this->data['content'] = (is_null($view)) ? '' : $this->load->view($view, $this->data, TRUE);

			$idPerfil = $this->session->userdata('id_perfil');
			$menuPerfil = $this->menu_model->getMenusPerfil($idPerfil);
			
			$this->data['menus'] = $this->renderMenu($menuPerfil);

			$this->data['menu'] = $this->load->view('templates/menu/admin_menu', $this->data, TRUE);
			$this->data['flashMessage'] = $this->load->view('templates/message/flash_message', $this->data, TRUE);
			$this->data['modalMessage'] = $this->load->view('templates/message/modal_message', $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}

	protected function renderMenu($menus){
		$result = '';

		foreach ($menus as $menu){
			if( is_array( $menu['submenu'] ) == true){
				$result .= "<li class='nav-item has-treeview'>";
				$result .= "<a href='#' class='nav-link morado'>";
				$result .= "<i class='nav-icon {$menu['iconMenu']}'></i>";
				$result .= "<p>{$menu['nombreMenu']} <i class='right fas fa-angle-left'></i></p>";
				$result .= "</a>";
				$result .= "<ul class='nav nav-treeview''>";
				$result .= $this->renderMenu($menu['submenu']);
				$result .= "</ul>";
				$result .= "</li>";
			} else {
				$result .= "
				<li class='nav-item has-treeview'>						
					<a class='nav-link' href='{$menu['linkMenu']}'>
						<i class='nav-icon {$menu['iconMenu']}'></i>
						<p>{$menu['nombreMenu']}</p>
					</a>
				</li>";
			}
		}

		$result .= '';

		return $result;
	}

	protected function not_authorized()
	{
		show_404();
	}

	protected function JSONFORMATTER($query){
		$query = stripslashes($query);
		$corcheteAbierto = (str_replace('"[', '[', $query));
		$corcheteCerrado = (str_replace(']"', ']', $corcheteAbierto));

		$corcheteAbiertoSkill = (str_replace('[\"', '[', $corcheteCerrado));
		$corcheteCerradoSkill = (str_replace('\"]', ']', $corcheteAbiertoSkill));

		return $corcheteCerradoSkill;
	}
}
