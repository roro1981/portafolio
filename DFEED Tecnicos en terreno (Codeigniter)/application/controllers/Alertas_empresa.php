<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alertas_empresa extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('alertas_empresa_model');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index()
    {

        $limit     = 7;
        $page      = $this->input->get('page') != null ? $this->input->get('page') : 1;
        $search    = $this->input->get('value')     ? $this->input->get('value') : '';
        $id_empresa = $this->input->get('id_empresa') ? $this->input->get('id_empresa') : '';

        $idCompanySelected = $this->selectCompany;
        if (!empty($id_empresa) && $this->isFromTelefonica) {
            $idCompanySelected = $id_empresa;
        }


        // Pagination
        $config['per_page']   = $limit;
        $config['base_url']   = site_url('alertas_empresa/index?value=' . $search);
        $config['total_rows'] = $this->alertas_empresa_model->count($search, $idCompanySelected);

        $data['selectCompany'] = $idCompanySelected;
        $data['flashMessage'] = $this->session->flashdata('flashMessage');
        $data['search_value'] = $search;
        $data['users']        = $this->alertas_empresa_model->find($search, $limit, $page, $idCompanySelected);

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $this->data         = $data;


        $breadcumb = '
            <div class="list">
                <ol class="breadcrumb">
                    <li title="Volver a la página anterior">
                        <a href="javascript:goBack()">
                            <strong><i class="fa fa-arrow-left"></i> Volver</strong>
                        </a>
                    </li>
                    <li><a href="/tecnicos"><strong>Mantenedores</strong></a></li>
                    <li><a href="/alertas_empresa"><strong>Alertas Empresas</strong></a></li>
                    <li class="active"><strong>Listado</strong></li>
                </ol>
            </div>';

        $this->render('alertas_empresa/index', 'master', $breadcumb);
    }

    public function list()
    {
        // Datatables Variables
        $bddColumnsName = [
            'id',
            'slot',
            'descripcion',
            'checked',
            'seleccionado',
            'empresa',
            'idRelacion',
            'correo',
            'sms',
            'whatsapp'
        ];
        $draw      = intval($this->input->get("draw"));
        $offset    = intval($this->input->get("start"));
        $limit     = intval($this->input->get("length"));
        //$columns    = $this->input->get("columns");
        $orderBy    = $this->input->get("order") ? $this->input->get("order") : [];
        $search     = $this->input->get("search") ? $this->input->get("search")['value'] : '';

        $status    = $this->input->get('status')    ? (int)$this->input->get('status') : '0';
        $id_empresa = $this->input->get('id_empresa') ? (int)$this->input->get('id_empresa') : '';

        $idCompanySelected = $this->selectCompany;
        if (!empty($id_empresa) && $this->isFromTelefonica) {
            $idCompanySelected = $id_empresa;
        }

        $orderFields = [['id', 'ASC']];
        if (!empty($bddColumnsName)) {
            $orderFields = [];
            foreach ($orderBy as $k => $col) {
                $colName = $bddColumnsName[$col['column']]; // nombre de la columna en bdd
                $colDir  = $col['dir'];    // direccion del orden
                $orderFields[] = [$colName, $colDir];
            }
        }

        $total    = $this->alertas_empresa_model->count("", $idCompanySelected);
        $filtered = $this->alertas_empresa_model->count($search, $idCompanySelected);
        $data = $this->alertas_empresa_model->find($search, $limit, $offset, $idCompanySelected);

        $output = array(
            "draw"              => $draw,
            "recordsTotal"      => $total,
            "recordsFiltered"   => $filtered,
            "data"              => $data
        );
        echo json_encode($output);

        exit();
    }


    /* Función para deshabilitar la alerta */
    public function deshabilitar($id = 0, $empresa = 0)
    {
       

        $id = preg_replace('/[^0-9]/s', '', $id);
        $empresa = preg_replace('/[^0-9]/s', '', $empresa);

        $code = 0;
        $message = 'OK';

        if (empty($id) || empty($empresa)) {
            $code    = 400;
            $message = 'Debe ingresar un id de empresa y alerta';
        } else {

            $create = $this->alertas_empresa_model->deshabilitar($id, $empresa);

            if (!$create) {

                $code    = 500;
                $message = 'No se pudo deshabilitar la alerta';
            } else {

                $code = 0;
                $message = 'Alerta deshabilitada correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }

    /* Función para habilitar la alerta */
    public function habilitar($id = 0, $empresa = 0)
    {        

        $id = preg_replace('/[^0-9]/s', '', $id);
        $empresa = preg_replace('/[^0-9]/s', '', $empresa);

        $code = 0;
        $message = 'OK';

        if (empty($id) || empty($empresa)) {
            $code    = 400;
            $message = 'Debe ingresar un id de empresa y alerta';
        } else {

            $create = $this->alertas_empresa_model->habilitar($id, $empresa);

            if (!$create) {

                $code    = 500;
                $message = 'No se pudo habilitar la alerta';
            } else {

                $code = 0;
                $message = 'Alerta habilitada correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }


    //OPCIONES DE ENVIO

    /* Función para deshabilitar opcion de envio */
    public function deshabilitarEnvio($id = 0, $empresa = 0, $opcion = 0)
    {        

        $id = preg_replace('/[^0-9]/s', '', $id);
        $opcion = preg_replace('/[^0-9]/s', '', $opcion);
        $empresa = preg_replace('/[^0-9]/s', '', $empresa);
        $code = 0;
        $message = 'OK';

        if (empty($id) || empty($opcion)) {
            $code    = 400;
            $message = 'Debe ingresar un id de empresa y opcion';
        } else {

            $create = $this->alertas_empresa_model->deshabilitarEnvio($id, $empresa, $opcion);

            if (!$create) {

                $code    = 500;
                $message = 'No se pudo deshabilitar la opcion';
            } else {

                $code = 0;
                $message = 'Opción deshabilitada correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }

    /* Función para habilitar opcion de envio */
    public function habilitarEnvio($id = 0, $empresa = 0, $opcion = 0)
    {
       

        $id = preg_replace('/[^0-9]/s', '', $id);
        $opcion = preg_replace('/[^0-9]/s', '', $opcion);
        $empresa = preg_replace('/[^0-9]/s', '', $empresa);
        $code = 0;
        $message = 'OK';

        if (empty($id) || empty($opcion)) {
            $code    = 400;
            $message = 'Debe ingresar un id de empresa y opcion';
        } else {

            $create = $this->alertas_empresa_model->habilitarEnvio($id, $empresa, $opcion);

            if (!$create) {

                $code    = 500;
                $message = 'No se pudo habilitar la opcion';
            } else {

                $code = 0;
                $message = 'Opción habilitada correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }


    //DESTINATARIOS

    public function listDest($id)
    {
        // Datatables Variables
        $bddColumnsName = [
            'id',
            'correo',
            'telefono'
        ];
        $draw      = intval($this->input->get("draw"));
        $offset    = intval($this->input->get("start"));
        $limit     = intval($this->input->get("length"));
        //$columns    = $this->input->get("columns");
        $orderBy    = $this->input->get("order") ? $this->input->get("order") : [];
        $search     = $this->input->get("search") ? $this->input->get("search")['value'] : '';

        $id_empresa = $this->input->get('id_empresa') ? (int)$this->input->get('id_empresa') : '';

        $idCompanySelected = $this->selectCompany;

        if (!empty($id_empresa) && $this->isFromTelefonica) {
            $idCompanySelected = $id_empresa;
        }


        $orderFields = [['id', 'ASC']];
        if (!empty($bddColumnsName)) {
            $orderFields = [];
            foreach ($orderBy as $k => $col) {
                $colName = $bddColumnsName[$col['column']]; // nombre de la columna en bdd
                $colDir  = $col['dir'];    // direccion del orden
                $orderFields[] = [$colName, $colDir];
            }
        }

        $total  = $this->alertas_empresa_model->countDest();
        $filtered = $this->alertas_empresa_model->countDest($search);
        $data = $this->alertas_empresa_model->findDest($search, $limit, $offset, $orderFields, $id);

        $output = array(
            "draw"              => $draw,
            "recordsTotal"      => $total,
            "recordsFiltered"   => $filtered,
            "data"              => $data
        );
        echo json_encode($output);

        exit();
    }

    /* Función para crear destinatario */
    public function createDest()
    {        

        $idAlertRelEmpresa = $this->input->post('idAlertRelEmpresa') ? trim($this->input->post('idAlertRelEmpresa')) : '';
        $correoDeEnvio = $this->input->post('correoDeEnvio') ? trim($this->input->post('correoDeEnvio')) : '';
        $phoneDeEnvio = $this->input->post('phoneDeEnvio') ? trim($this->input->post('phoneDeEnvio')) : '';

        $code = 0;
        $message = 'OK';

        if (empty($idAlertRelEmpresa) || empty($correoDeEnvio) || empty($phoneDeEnvio)) {
            $code    = 400;
            $message = 'Debe ingresar todos los campos requeridos';
        } else {
            $alert = array(
                'idAlertRelEmpresa' => $idAlertRelEmpresa,
                'correoDeEnvio' => $correoDeEnvio,
                'phoneDeEnvio' => $phoneDeEnvio
            );

            $create = $this->alertas_empresa_model->createDest($alert);

            if (!($create)) {
                $code    = 500;
                $message = 'No se pudo crear el Destinatario';
            } else {
                $code = 0;
                $message = 'Destinatario creado correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }

    /* Función para editar destinatario */
    public function editDest($id = 0)
    {


        $id = preg_replace('/[^0-9]/s', '', $id);
        $correoDeEnvio = $this->input->post('correoDeEnvio') ? trim($this->input->post('correoDeEnvio')) : '';
        $phoneDeEnvio = $this->input->post('phoneDeEnvio') ? trim($this->input->post('phoneDeEnvio')) : '';

        $code = 0;
        $message = 'OK';


        if (empty($id)) {
            $code    = 400;
            $message = 'Debe ingresar un id de Destinatario';
        } else if (empty($correoDeEnvio) || empty($phoneDeEnvio)) {
            $code    = 400;
            $message = 'Debe ingresar todos los campos requeridos';
        } else {
            $create = $this->alertas_empresa_model->editDest($id);

            if (!$create) {
                $code    = 500;
                $message = 'No se pudo modificar el Destinatario';
            } else {
                $code = 0;
                $message = 'Destinatario modificado correctamente.';
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }

    /* Función Eliminar destinatario */
    public function deleteDest($id = 0)
    {

        $id = preg_replace('/[^0-9]/s', '', $id);
        $code = 0;
        $message = 'OK';
        if (empty($id)) {
            $code    = 400;
            $message = 'Debe ingresar un id de Destinatario';
        } else {
            $dataSurvey = $this->alertas_empresa_model->getDest($id);
            if (empty($dataSurvey)) {
                $code    = 404;
                $message = 'Destinatario  no encontrado o ya eliminado.';
            } else {
                $result = $this->alertas_empresa_model->deleteDest($id);
                if (!$result) {
                    $code    = 500;
                    $message = 'No se pudo eliminar el Destinatario';
                } else {
                    $code = 0;
                    $message = "Destinatario eliminado correctamente.";
                }
            }
        }

        $response = new stdClass;
        $response->code = $code;
        $response->message = $message;
        echo json_encode($response);
    }

    /* Función buscar destinatario */
    public function getDest($id = 0)
    {
        $response = new stdClass;
        if (empty($id)) {
            $response->code = 400;
            $response->message = 'Debe enviar id de Destinatario';
        } else {
            $data = $this->alertas_empresa_model->getDest($id);
            if (empty($data)) {
                $response->code = 404;
                $response->message = 'Destinatario no existe';
            } else {
                $response->code = 200;
                $response->message = 'OK';
                $response->data = $data;
            }
        }

        echo json_encode($response);
    }

    public function listForSelectDest()
    {
        // Traigo el listado de destinatarios
        $data = $this->alertas_empresa_model->listForSelectDest($this->input->get('term'), 10, $this->input->get('page'));

        $result = array(
            'total' => count($data),
            'results' => $data,
            'pagination' => array(
                "more" => false
            )
        );

        return print_r(json_encode($result, true));
    }


    /* Función buscar relacion */
    public function getRel($id = 0)
    {
        $response = new stdClass;
        if (empty($id)) {
            $response->code = 400;
            $response->message = 'Debe enviar id de relacion';
        } else {
            $data = $this->alertas_empresa_model->getRel($id);
            if (empty($data)) {
                $response->code = 404;
                $response->message = 'relacion no existe';
            } else {
                $response->code = 200;
                $response->message = 'OK';
                $response->data = $data;
            }
        }

        echo json_encode($response);
    }
}
