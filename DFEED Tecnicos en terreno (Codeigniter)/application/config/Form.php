<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends MY_Controller {

	function __construct() {
		parent::__construct();		
		$this->load->model('form_model');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
	}

	/*Función que verifica que no existan dependencia circular ni secciones que no han sido enlazadas al formulario principal*/
	public function verify($form){		
		//Se crea un grafo con las secciones para verificar circularidad y coherencia
		$tree = array();
		//Se crea un array con las secciones del formulario	
		$nodes = array_keys($form['section']);
		foreach ($nodes as $key => $node) {
			$tree[$node] = array();
			foreach ($form['section'][$node]['question'] as $keyQuestion => $question) {
				if(isset($question['option'])){
					foreach ($question['option'] as $keyOption => $option) {
						if(!in_array($option['section'], $tree[$node]) && $option['section'] != "") {
							array_push($tree[$node], (int)$option['section']);
						}
					}					
				}
				if(isset($question['restriction']['section'])){
					if(!in_array($question['restriction']['section'], $tree[$node]) && $question['restriction']['section'] !=""){
						array_push($tree[$node], (int)$question['restriction']['section']);
					}
				}				
				
			}
		}
		//Se utiliza el algoritmo de búsqueda en profundidad para recorrer el arbol
		$visitedNodes = array();
		$stack = array();
		$result = array();
		array_push($stack, $nodes[0]);
		array_push($visitedNodes, $nodes[0]);
		array_push($result, $nodes[0]);
		
		$alone = false;
		$nodeAlone = array();

		$cycle = false;
		$nodeCycle = array();

		for ($i = 0; $i < count($tree[end($stack)]) ; $i++) {						
		 	$actualNode = $tree[end($stack)][$i];		 			
		 	if(in_array($actualNode, $stack)){
		 		$cycle = true;
		 	}
	 		if(!in_array($actualNode, $visitedNodes)){								 		
			 	array_push($stack, $actualNode);					
				array_push($result, $actualNode);
				$i = -1;
	 		}
	 		array_push($visitedNodes, $actualNode);
			if($i == (count($tree[end($stack)]) - 1)){
				array_pop($stack);				
				if(count($stack) == 0){
					break;
				} 
			}
		}

		if($aux = array_diff($nodes, $result)){
			$alone = true;
			$nodeAlone = $aux;
		}	
		//Se genera un objeto con los resultados obtenidos para su retorno
		$finalResult = new stdClass();
		$finalResult->cycle = 	$cycle;
		$finalResult->resultCycle = $nodeCycle; 
		$finalResult->alone = 	$alone;
		$finalResult->resultAlone = $nodeAlone;
		return $finalResult;
	}

	/* Listado de formularios creados */
	public function index(){
		$data['search_value'] = "";
		$config['per_page'] = 7;
		$data['flashMessage'] = $this->session->flashdata('flashMessage');	
		$page = $this->input->get('page') != null ? $this->input->get('page') : 1;		
		if(!is_null($this->input->get('value'))){
			$config['base_url'] = site_url('form/index?value='.$this->input->get('value'));						
			$config['total_rows'] = $this->form_model->count($this->input->get('value'));			
			$data['forms'] = $this->form_model->find($this->input->get('value'), $config['per_page'], $page);
			$data['search_value'] = $this->input->get('value');
		}else{
			$config['base_url'] = site_url('form/index');
			$config['total_rows'] = $this->form_model->count();			
			$data['forms'] = $this->form_model->find(null, $config['per_page'], $page);			
		}
		$this->pagination->initialize($config);		
		$data['pagination'] = $this->pagination->create_links();
		$this->data = $data;
		$this->render('form/index');
	}

	/*Formulario de creación de formularios */
	public function create(){
		//Se verifican las credenciales
		if(!$this->ion_auth->in_group('1') && !$this->ion_auth->is_admin()){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('form/index');
		}
		$data['title'] = "Crear formulario";
		$data['flashMessage'] = $this->session->flashdata('flashMessage');	
		$data['inputTypes'] = $this->form_model->get_input_types_dropdown();		
		$data['categories'] = $this->form_model->get_categories_dropdown();
                //$data['countries'] = $this->form_model->get_countries_dropdown();
                //$data['companies'] = $this->form_model->get_companies_dropdown();
		
		$auxVerify = FALSE;
		$data['form_validation_graph_cycle'] = "";
		$data['form_validation_graph_alone'] = "";
		if($this->input->post('form')){
			$verify = $this->verify($this->input->post('form'));			
			if ($verify->cycle){
				$data['form_validation_graph_cycle'] = '<div class="form-alert-message"><svg class="icon"><use xlink:href="'.site_url('assets/images/icons.svg').'#icon-warning"></use></svg>El formulario posee una o más dependencias cíclicas.</div>';
				$auxVerify = TRUE;
			}
			if($verify->alone){
				$data['form_validation_graph_alone'] = '<div class="form-alert-message"><svg class="icon"><use xlink:href="'.site_url('assets/images/icons.svg').'#icon-warning"></use></svg>Exiten secciones que no se encuentran enlazadas al formulario principal.</div>';
				$auxVerify = TRUE;
			}
		}

		$this->form_validation->set_rules('form[title]', 'título', 'required');
		$this->form_validation->set_rules('form[description]', 'descripción', 'required');
                //$this->form_validation->set_rules('form[country_id]', 'país', 'required');
                //$this->form_validation->set_rules('form[company_id]', 'empresa', 'required');
		if($form = $this->input->post('form')){
			foreach ($form['section'] as $keySection => $section) {				
				$this->form_validation->set_rules('form[section]['.$keySection.'][section_index]', 'index de la sección', 'required|is_natural');				
				foreach ($section['question'] as $keyQuestion => $question) {					
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][text]', 'pregunta','required');
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][input_type_id]', 'tipo de input','required');
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][category_id]', 'categoría','required');
					//Se validan las opciones					
					if(isset($form['section'][$keySection]['question'][$keyQuestion]['option'])){
						foreach ($form['section'][$keySection]['question'][$keyQuestion]['option'] as $keyOption => $option) {
							$result = "";	
							foreach ($form['section'][$keySection]['question'][$keyQuestion]['option'] as $keyOptionB => $option) {
								if($keyOption != $keyOptionB){
									$result .= "|differs[form[section][".$keySection."][question][".$keyQuestion."][option][".$keyOptionB."][text]]";	
								}								
							}
							$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][option]['.$keyOption.'][text]', 'opción','required'.$result);
						}
					}
					//Valida las restricciones de la pregunta.
					if(isset($form['section'][$keySection]['question'][$keyQuestion]['restriction'])){
						foreach ($form['section'][$keySection]['question'][$keyQuestion]['restriction'] as $keyRestriction => $restriction) {	
							switch ($keyRestriction) {
								case '1':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad mínima','required|is_natural_no_zero');
									break;
								case '2':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad máxima','required|is_natural_no_zero|greater_than['.$form['section'][$keySection]['question'][$keyQuestion]['restriction']['1'].']');
									break;
								case '3':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad de imágenes','required|is_natural_no_zero');
									break;
								case '4':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'tamaño máximo total','required|is_natural_no_zero');
									break;
								case 'section':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'sección','required');
								default:
									break;
							}
							
						}
					}										
				}	
			}	
		}

                $tmpSD = $this->form_validation->run();
		
		if($tmpSD == FALSE || $auxVerify){
                        $tmpSD = $this->input->post('form');

			if(!empty($tmpSD)){
				$data['form'] = $form;					
				$data['sectionIndex'] = key(array_slice($form['section'],-1,1,TRUE));
				$data['questionIndex'] = key(array_slice($form['section'][$data['sectionIndex']]['question'],-1,1,TRUE));				
				//Se obtiene el el index de la última opción
				$auxQuestions = array_column($form['section'], 'question');				
				$auxOptions = array();				
				foreach ($auxQuestions as $keyAuxQuestion => $auxQuestion) {					
					foreach ($auxQuestion as $keyElement => $element) {						
						if(isset($element['option'])){
							$auxOptions = array_merge($auxOptions,$element['option']);
						}						
					}
				}
				$data['optionIndex'] = 0;
				if(count($auxOptions) > 0){
					$data['optionIndex'] = max(array_keys($auxOptions));				
				}				
			}
			$this->data = $data;
			$this->render('form/create');
		}else{
			if($this->form_model->create($this->input->post('form')) == FALSE){				
				$data['form'] = $form;					
				$data['sectionIndex'] = key(array_slice($form['section'],-1,1,TRUE));
				$data['questionIndex'] = key(array_slice($form['section'][$data['sectionIndex']]['question'],-1,1,TRUE));				
				//Se obtiene el el index de la última opción
				$auxQuestions = array_column($form['section'], 'question');				
				$auxOptions = array();				
				foreach ($auxQuestions as $keyAuxQuestion => $auxQuestion) {					
					foreach ($auxQuestion as $keyElement => $element) {						
						if(isset($element['option'])){
							$auxOptions = array_merge($auxOptions,$element['option']);
						}						
					}
				}
				$data['optionIndex'] = 0;
				if(count($auxOptions) > 0){
					$data['optionIndex'] = max(array_keys($auxOptions));				
				}
				$this->data = $data;
				$this->session->set_flashdata('flashMessage', -1);
				$this->render('form/create');
			}else{
				//Envía aviso de creación exitosa
				$this->session->set_flashdata('flashMessage', 1);
				redirect('form/index');
			}		
		}		
	}

	/* Formulario de edición de formularios */
	public function edit($id){
		//Se verifican las credenciales
		if(!$this->ion_auth->in_group('2') && !$this->ion_auth->is_admin()){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('form/index');
		}
		//Si está activo se redirecciona al listado de formularios
		if($this->form_model->isEditable($id) == FALSE){
			redirect('form/index');
		}

		$auxVerify = FALSE;
		$data['form_validation_graph_cycle'] = "";
		$data['form_validation_graph_alone'] = "";
		
		if($this->input->post('form')){
			$verify = $this->verify($this->input->post('form'));			
			if ($verify->cycle){
				$data['form_validation_graph_cycle'] = '<div class="form-alert-message"><svg class="icon"><use xlink:href="'.site_url('assets/images/icons.svg').'#icon-warning"></use></svg>El formulario posee una o más dependencias cíclicas.</div>';
				$auxVerify = TRUE;
			}
			if($verify->alone){
				$data['form_validation_graph_alone'] = '<div class="form-alert-message"><svg class="icon"><use xlink:href="'.site_url('assets/images/icons.svg').'#icon-warning"></use></svg>Exiten secciones que no se encuentran enlazadas al formulario principal.</div>';
				$auxVerify = TRUE;
			}
		}

                if(!$auxVerify) {
                    $delOpt = $this->input->post('delOpt');

                    if($delOpt != "") {
                        $delOpt = explode(",", $delOpt);
                        foreach($delOpt AS $optArr) {
                            $optArr = explode("#", $optArr);

                            $optId = $optArr[0];
                            if(isset($optArr[1]))
                                $queId = $optArr[1];
                            else
                                $queId = 0;
                            if((int)$optId && (int)$queId) {
                                $this->form_model->deleteOpt($optId, $queId);
                            }
                        }
                    }

                    $delQue = $this->input->post('delQue');

                    if($delQue != "") {
                        $delQue = explode(",", $delQue);
                        foreach($delQue AS $queArr) {
                            $queArr = explode("#", $queArr);

                            $queId = $queArr[0];
                            if(isset($queArr[1]))
                                $secId = $queArr[1];
                            else
                                $secId = 0;
                            if((int)$queId && (int)$secId) {
                                $this->form_model->deleteQue($queId, $secId);
                            }
                        }
                    }
                    
                    $delSec = $this->input->post('delSec');

                    if($delSec != "") {
                        $delSec = explode(",", $delSec);
                        foreach($delSec AS $secId) {
                            if((int)$secId) {
                                $this->form_model->deleteSec($secId);
                            }
                        }
                    }
                }

		$data['title'] = "Editar formulario";
		$data['edit'] = TRUE;
		$data['flashMessage'] = $this->session->flashdata('flashMessage');	
		$data['inputTypes'] = $this->form_model->get_input_types_dropdown();		
		$data['categories'] = $this->form_model->get_categories_dropdown();
                //$data['countries'] = $this->form_model->get_countries_dropdown();
                //$data['companies'] = $this->form_model->get_companies_dropdown();
		if($this->input->post()){
			$form = $this->input->post('form');
		}else{
			$form = $this->form_model->get($id);
                        $form = $form['form'];
		}
		$data['form'] = $form;
                
		//Se obtiene el índice de la última sección
		$data['sectionIndex'] = key(array_slice($form['section'],-1,1,TRUE));
		//Se obtiene el índice de la última pregunta
		$data['questionIndex'] = key(array_slice($form['section'][$data['sectionIndex']]['question'],-1,1,TRUE));				
		//Se obtiene el el index de la última opción
		$auxQuestions = array_column($form['section'], 'question');				
		$auxOptions = array();				
		foreach ($auxQuestions as $keyAuxQuestion => $auxQuestion) {					
			foreach ($auxQuestion as $keyElement => $element) {						
				if(isset($element['option'])){
					$auxOptions = array_merge($auxOptions,$element['option']);
				}						
			}
		}
		$data['optionIndex'] = 0;
		if(count($auxOptions) > 0){
			$data['optionIndex'] = max(array_keys($auxOptions));				
		}
		//Reglas de validación
		$this->form_validation->set_rules('form[title]', 'título', 'required');
		$this->form_validation->set_rules('form[form_id]', 'id del formulario', 'required|is_natural');
		$this->form_validation->set_rules('form[description]', 'descripción', 'required');
                //$this->form_validation->set_rules('form[country_id]', 'país', 'required');
                //$this->form_validation->set_rules('form[company_id]', 'empresa', 'required');
		if($form = $this->input->post('form')){
			foreach ($form['section'] as $keySection => $section) {			
				$this->form_validation->set_rules('form[section]['.$keySection.'][section_index]', 'index de la sección', 'required|is_natural');				
				foreach ($section['question'] as $keyQuestion => $question) {					
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][text]', 'pregunta','required');
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][input_type_id]', 'tipo de input','required');
					$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][category_id]', 'categoría','required');
					//Se validan las opciones					
					if(isset($form['section'][$keySection]['question'][$keyQuestion]['option'])){
						foreach ($form['section'][$keySection]['question'][$keyQuestion]['option'] as $keyOption => $option) {
							$result = "";	
							foreach ($form['section'][$keySection]['question'][$keyQuestion]['option'] as $keyOptionB => $option) {
								if($keyOption != $keyOptionB){
									$result .= "|differs[form[section][".$keySection."][question][".$keyQuestion."][option][".$keyOptionB."][text]]";	
								}								
							}							
							$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][option]['.$keyOption.'][text]', 'opción','required'.$result);
						}
					}
					//Valida las restricciones de la pregunta.
					if(isset($form['section'][$keySection]['question'][$keyQuestion]['restriction'])){
						foreach ($form['section'][$keySection]['question'][$keyQuestion]['restriction'] as $keyRestriction => $restriction) {	
							switch ($keyRestriction) {
								case '1': //min
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad mínima','required|is_natural');
									break;
								case '2': //max
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad máxima','required|is_natural');
									break;
								case '3': //qty
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'cantidad de imágenes','required|is_natural_no_zero');
									break;
								case '4': //size
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'tamaño máximo total','required|is_natural_no_zero');
									break;
								case 'section':
									$this->form_validation->set_rules('form[section]['.$keySection.'][question]['.$keyQuestion.'][restriction]['.$keyRestriction.']', 'sección','required');
								default:
									break;
							}
							
						}
					}										
				}	
			}	
		}		
		if($this->form_validation->run() == FALSE || $auxVerify){
			$this->data = $data;
			$this->render('form/create');
		}else{
			if($this->form_model->edit($id, $this->input->post('form')) == FALSE){								
				$this->data = $data;
				$this->session->set_flashdata('flashMessage', -1);
				$this->render('form/create');
			}else{
				//Envía aviso de modificación exitosa
				$this->session->set_flashdata('flashMessage', 2);
				redirect('form/index');
			}	
		}	
	}

	/*Cambio de estado de un formulario */
	public function change_state(){
		//Se verifican las credenciales
		if(!$this->ion_auth->in_group('3') && !$this->ion_auth->is_admin()){
			$this->session->set_flashdata('flashMessage', 7);
			redirect('form/index');
		}		
		if($form = $this->input->post('form')){
			$result = FALSE;
			$this->session->set_flashdata('flashMessage', -1);
			//Desactivar formulario
			if($form['action'] == 0){				
				$result = $this->form_model->deactivate($form['form_id']);					
				$this->session->set_flashdata('flashMessage', 4);
			}
			//Activar formulario
			else if($form['action'] == 1){
				$result = $this->form_model->activate($form['form_id']);	
				$this->session->set_flashdata('flashMessage', 3);
			}			
		}		
		redirect('form/index');
	}
}
