<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Alertas extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('alertas_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data = $this->alertas_model->buscarSolicitud($user_id);
        $data = json_encode($data);
        return print_r($data);
        // $this->render('notificaciones/selecUsuarios');
    }

    public function update()
    {
        $id_sol = $_GET["id"];
        $user_id = $this->session->userdata('user_id');
        $data = $this->alertas_model->updateStatus($id_sol);
        return print_r($data);
        // $this->render('notificaciones/selecUsuarios');
    }
}
