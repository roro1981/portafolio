<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
    }

    //        public function test() {
    //            $result = $this->api_model->get_Data();
    //        }

    public function get_form()
    {
        if ($this->input->post()) {
            if ($this->input->post('key') == 'aFHVA71KHmVW76oj') {
                $numpet = $this->input->post('numpet');
                $id = $this->input->post('id');
                $result = $this->api_model->get_form($id);
                //echo json_encode($result);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function get_active_forms()
    {
        if ($this->input->post()) {
            if ($this->input->post('key') == 'aFHVA71KHmVW76oj') {
                $result = $this->api_model->get_active_forms();
                $actStr = "";
                if (isset($result)) {
                    foreach (json_decode(json_encode($result->{"result_array"})) as $res) {
                        $actStr .= $res->{"form_id"} . "#" . $res->{"title"} . ",";
                    }
                }
                $actStr = substr($actStr, 0, strlen($actStr) - 1);
                echo $actStr;
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
}
