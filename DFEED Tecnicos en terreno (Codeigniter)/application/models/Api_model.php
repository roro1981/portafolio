F<?php

class Api_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}	
	
	/*Obtiene toda la información de un formulario*/
	public function get_form($id){
		//Array auxiliar para descargar una vez la información de la categoría
		$auxCategories = array();
		//Se obtiene la información básica del formulario
		$this->db->select('form_id , title');
		$this->db->where('form_id',$id);
		$this->db->where('active', 1);
		$queryForm = $this->db->get('form');
		$form = $queryForm->row_array();

						//Se obtiene el arbol de categoría y las categorías padre de la pregunta
						if (!in_array($question['category_id'], $auxCategories)) {
							array_push($auxCategories, $question['category_id']);
							//Se obtienen los datos de la categoría						
							$this->db->where('category_id', $question['category_id']);
							$categoryResult = $this->db->get('category')->row_array();
							$form['category'][] = $categoryResult;

							$aux = $categoryResult['cat_category_id'];
							while ($aux != null) {
								$this->db->where('category_id', $aux);
								$categoryResult = $this->db->get('category')->row_array();
								$aux = $categoryResult['cat_category_id'];
								if (!in_array($categoryResult['category_id'], $auxCategories)) {
									$form['category'][] = $categoryResult;
									array_push($auxCategories, $categoryResult['category_id']);
								}
							}
						}


						//Se incluyen las opciones
						$this->db->select('option.option_id, text, section_option.section_id as section');
						$this->db->where('question_id', $question['question_id']);
						$this->db->where('status', 1);
						$this->db->join('section_option', 'option.option_id = section_option.option_id', 'LEFT');
						$queryOption = $this->db->get('option');
						$queryOptionResult = $queryOption->result_array();
						if ($queryOptionResult) {
							$form['section'][$keySection]['question'][$keyQuestion]['option'] = $queryOptionResult;
						}
						//Se incluyen las restricciones
						$this->db->select('restriction_id, value');
						$this->db->where('question_id', $question['question_id']);
						$queryRestriction = $this->db->get('restriction_question');
						$queryRestrictionResult = $queryRestriction->result_array();
						if ($queryRestrictionResult) {
							foreach ($queryRestrictionResult as $keyRestriction => $restriction) {
								$form['section'][$keySection]['question'][$keyQuestion]['restriction'][$keyRestriction] = $restriction;
							}
							$this->db->select('section_id');
							$this->db->where('question_id', $question['question_id']);
							$querySectionRestriction = $this->db->get('section_question');
							$querySectionRestrictionResult = $querySectionRestriction->row_array();
							if ($querySectionRestrictionResult) {
								$form['section'][$keySection]['question'][$keyQuestion]['section'] = $querySectionRestrictionResult['section_id'];
							}
						}
					}
				}
			}
			return $form;
		}
		return $form;
		
	}
	
        
        /*Obtiene toda la información de un formulario*/
	public function get_active_forms(){
		//Array auxiliar para descargar una vez la información de la categoría
		$auxCategories = array();
		//Se obtiene la información básica del formulario
		$this->db->select('form_id, title');
		$this->db->where('active', 1);
		$queryForm = $this->db->get('form');
		$form = $queryForm->result_array();
		return $queryForm;
		
	}
}
