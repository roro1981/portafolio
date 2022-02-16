<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auris extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('auris_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index($idempresa = null)
    {

        $this->render('monitoring/auris');
    }

    public function filtros()
    {
        $id_perfil = $this->session->userdata('id_perfil');
        $response = ['data' => [], 'error' => []];

        // Grupos resolutores que tiene asignado
        $user = $this->session->userdata();
        $grupos = $this->auris_model->getGrupoResolutores($user['user_id']);
        $clientes = $this->auris_model->getClientes($user['user_id']);
        $zonas = $this->auris_model->getZonas();

        $response['data'] = array(
            'user' => $user,
            'grupos' => $grupos,
            'zonas' => $zonas,
            'clientes' => $clientes,
        );

        echo json_encode($response);
    }

    public function totalesByCliente()
    {

        $idcliente = $this->input->get_post('cliente');
        $periodo = $this->input->get_post('periodo');
        $zona = $this->input->get_post('zona');

        $response = ['data' => [], 'error' => []];

        switch ($periodo) {
            case 1:
                $iniDate = date('Y-m-01 00:00:00');
                $finDate = date('Y-m-t 23:59:59');
                $interval = $periodo;
                break;

            default:
                $finDate = date('Y-m-d 00:00:00');
                $interval = '-' . $periodo . ' day';
                $timestamp = strtotime($interval, strtotime($finDate));
                $iniDate = date('Y-m-d 23:59:59', $timestamp);
                break;
        }

        # First Level For Customer
        $LevelOne =  $this->auris_model->getLevelOneForCustomer($idcliente, $zona, $iniDate, $finDate);

        $data = array(
            'clientes'   => $LevelOne,
            'titulo'     => 'Productividad por Cliente',
            'head_title' => 'Productividad por Cliente',
            'tickets'    => array(),
            'periodo'    => array(
                'inicio' => $iniDate,
                'fin' => $finDate,
                'interval' => $interval,
            )
        );

        $response['data'] = $data;

        echo json_encode($response);
    }

    public function totalesByZona()
    {

        $idcliente = $this->input->get_post('cliente');
        $periodo = $this->input->get_post('periodo');
        $zona = $this->input->get_post('zona');

        $response = ['data' => [], 'error' => []];

        switch ($periodo) {
            case 1:
                $iniDate = date('Y-m-01 00:00:00');
                $finDate = date('Y-m-t 23:59:59');
                $interval = $periodo;
                break;

            default:
                $finDate = date('Y-m-d 00:00:00');
                $interval = '-' . $periodo . ' day';
                $timestamp = strtotime($interval, strtotime($finDate));
                $iniDate = date('Y-m-d 23:59:59', $timestamp);
                break;
        }

        $LevelTwo =  $this->auris_model->getLevelTwoForZona($idcliente, $zona, $iniDate, $finDate);

        $data = array(
            'clientes'   => $LevelTwo,
            'titulo'     => 'Productividad por Zona',
            'head_title' => 'Productividad por Zona',
            'tickets'    => array(),
            'periodo'    => array(
                'inicio' => $iniDate,
                'fin' => $finDate,
                'interval' => $interval,
            )
        );

        $response['data'] = $data;

        echo json_encode($response);
    }

    public function totalesByGrupo()
    {

        $idcliente = $this->input->get_post('cliente');
        $periodo = $this->input->get_post('periodo');
        $zona = $this->input->get_post('zona');

        $response = ['data' => [], 'error' => []];

        switch ($periodo) {
            case 1:
                $iniDate = date('Y-m-01 00:00:00');
                $finDate = date('Y-m-t 23:59:59');
                $interval = $periodo;
                break;

            default:
                $finDate = date('Y-m-d 00:00:00');
                $interval = '-' . $periodo . ' day';
                $timestamp = strtotime($interval, strtotime($finDate));
                $iniDate = date('Y-m-d 23:59:59', $timestamp);
                break;
        }

        # Tree Level For Customer
        $LevelThree =  $this->auris_model->getLevelThreeForGrupo($idcliente, $zona, $iniDate, $finDate);

        $data = array(
            'clientes'   => $LevelThree,
            'titulo'     => 'Productividad por Grupo',
            'head_title' => 'Productividad por Grupo',
            'tickets'    => array(),
            'periodo'    => array(
                'inicio' => $iniDate,
                'fin' => $finDate,
                'interval' => $interval,
            )
        );

        $response['data'] = $data;

        echo json_encode($response);
    }

    public function totalesByTecnico()
    {

        $idcliente = $this->input->get_post('cliente');
        $periodo = $this->input->get_post('periodo');
        $zona = $this->input->get_post('zona');

        $response = ['data' => [], 'error' => []];

        switch ($periodo) {
            case 1:
                $iniDate = date('Y-m-01 00:00:00');
                $finDate = date('Y-m-t 23:59:59');
                $interval = $periodo;
                break;

            default:
                $finDate = date('Y-m-d 00:00:00');
                $interval = '-' . $periodo . ' day';
                $timestamp = strtotime($interval, strtotime($finDate));
                $iniDate = date('Y-m-d 23:59:59', $timestamp);
                break;
        }

        # Second Level For Customer
        $LevelFour =  $this->auris_model->getLevelFourForTecnico($idcliente, $zona, $iniDate, $finDate);

        $data = array(
            'clientes'   => $LevelFour,
            'titulo'     => 'Productividad por Tecnico',
            'head_title' => 'Productividad por Tecnico',
            'tickets'    => array(),
            'periodo'    => array(
                'inicio' => $iniDate,
                'fin' => $finDate,
                'interval' => $interval,
            )
        );

        $response['data'] = $data;

        echo json_encode($response);
    }

    public function totalesByIncident()
    {

        $idcliente = $this->input->get_post('cliente');
        $periodo = $this->input->get_post('periodo');

        $response = ['data' => [], 'error' => []];

        switch ($periodo) {
            case 1:
                $iniDate = date('Y-m-01 00:00:00');
                $finDate = date('Y-m-t 23:59:59');
                $interval = $periodo;
                break;

            default:
                $finDate = date('Y-m-d 00:00:00');
                $interval = '-' . $periodo . ' day';
                $timestamp = strtotime($interval, strtotime($finDate));
                $iniDate = date('Y-m-d 23:59:59', $timestamp);
                break;
        }

        $LevelFive =  $this->auris_model->getLevelFiveForIncident($idcliente, $zona, $iniDate, $finDate);

        $response['data'] = $LevelFive;

        echo json_encode($response);
    }
}
