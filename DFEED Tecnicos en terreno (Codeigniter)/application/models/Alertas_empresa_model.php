<?php

class Alertas_empresa_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    /**
     * Obtiene un registro de una Alerta
     * @param int $id Id de Alerta
     */
    public function get($id)
    {
        $this->db->where('idAlertRelEmpresa', $id);
        $this->db->where_in('statusAlert', '1'); // activo
        $query = $this->db->get(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA');
        return $query->row_array();
    }

    /**
     * Obtiene un registro de una Alerta
     * @param int $id Id de Alerta
     */
    public function getRel($id)
    {
        $this->db->where('idAlertRelEmpresa', $id);
        $this->db->where_in('statusAlert', '1'); // activo
        $query = $this->db->get(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA');
        return $query->row_array();
    }


    /**
     * Listado de Alertas, filtro por nombre
     * @param string $value nameSurvey, filtro
     * @param int $limit Cantidad de registros
     * @param int $offset Desde cantidad de registros
     * @param array $order Por qué campos ordenar
     */
    public function find($value = "", $limit = 10, $offset = 0, $id_empresa = 0)
    {

        try {
            $result = [];

            $query = "SELECT * FROM 
        (SELECT idAlert AS id, slotAlert AS slot, descriptionAlert AS descripcion FROM " . SMARTWAY_telrad . ".ALERTS_DFEED) a
        LEFT JOIN (SELECT idAlert AS seleccionado,  idEmpresa AS empresa, idAlertRelEmpresa AS idRelacion, envioPorWhatsapp AS whatsapp,
        envioPorEmail AS correo, envioPorSms AS sms,
        (CASE 
                WHEN idAlert IS NOT NULL THEN 'check'  
                ELSE '' END ) AS checked FROM " . SMARTWAY_telrad . ".ALERTS_REL_EMPRESA 
        WHERE idEmpresa = {$id_empresa} AND statusAlert =1 ) b
        ON a.id = b.seleccionado ORDER BY id ASC";

            if (!empty($value)) {
                $this->db->like('descriptionAlert', $value);
            }

            if ($offset > 0) {
                $this->db->limit($limit, $offset);
            }

            if ($id_empresa != 0) {
                $this->db->where("idEmpresa = {$id_empresa} ");
            }

            $query = $this->db->query($query);
            $result = $query->result_array();
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $result;
    }

    /**
     * Trae el valor del total de Alerta registrados, activos e inactivos
     * @param string $value nameAlert, nombre de Alerta, filtro
     */
    public function count($value = "",  $id_empresa = 0)
    {
        if (!empty($value)) {
            $this->db->like('slot', $value);
        }

        $this->db->where_in('statusAlert', '1'); // activo
        return $this->db->count_all_results(SMARTWAY_telrad . '.ALERTS_DFEED');
    }

    /**
     * Funcon para deshabilitar una alerta 
     */
    public function deshabilitar($id, $empresa)
    {

        $this->db->trans_begin();

        $valor = $this->getRelAlertaEmpresaId($id, $empresa);

        $relacion_data = array(
            'statusAlert'  => '0'
        );

        $this->db->where('idAlertRelEmpresa', $valor->idAlertRelEmpresa);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA', $relacion_data);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }

    /**
     * Funcion para habilitar una alerta 
     */
    public function habilitar($id, $empresa)
    {

        $this->db->trans_begin();

        $valor = $this->getRelAlertaEmpresaId($id, $empresa);

        if (empty($valor)) {
            $this->habilitarNuevo($id, $empresa);
        } else {
            $this->HabilitarUpdate($valor);
        }

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }

    /**
     * Obtiene ID de relacion entre alerta y empresa
     */
    public function getRelAlertaEmpresaId($idAlert, $idEmpresa)
    {
        $this->db->select('idAlertRelEmpresa');
        $this->db->where('idAlert', $idAlert);
        $this->db->where('idEmpresa', $idEmpresa);
        $this->db->where('statusAlert', '1');
        $this->db->or_where('statusAlert', '0');
        $query = $this->db->get(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA');
        return $query->row();
    }

    /** Guarda alertas */
    private function habilitarNuevo($idAlert, $idEmpresa)
    {

        $relacion_data = array(
            'idEmpresa'  => $idEmpresa,
            'idAlert'  => $idAlert,
            'statusAlert'  => '1'
        );
        $this->db->insert(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA', $relacion_data);
    }

    /** Actualiza los alera */
    private function HabilitarUpdate($valor)
    {

        $relacion_data = array(
            'statusAlert'  => '1'
        );
        $this->db->where('idAlertRelEmpresa', $valor->idAlertRelEmpresa);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA', $relacion_data);
    }

    //OPCIONES

    /**
     * Funcon para deshabilitar una opcion 
     */
    public function deshabilitarEnvio($id, $empresa, $opcion)
    {

        $this->db->trans_begin();
        $valor = $this->getRelAlertaEmpresaId($id, $empresa);
        if ($opcion == 1) {
            $relacion_data = array(
                'envioPorEmail'  => '0'
            );
        }
        if ($opcion == 2) {
            $relacion_data = array(
                'envioPorWhatsapp'  => '0'
            );
        }
        if ($opcion == 3) {
            $relacion_data = array(
                'envioPorSms'  => '0'
            );
        }


        $this->db->where('idAlertRelEmpresa', $valor->idAlertRelEmpresa);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA', $relacion_data);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }

    /**
     * Funcion para habilitar una opcion 
     */
    public function habilitarEnvio($id, $empresa, $opcion)
    {

        $this->db->trans_begin();
        $valor = $this->getRelAlertaEmpresaId($id, $empresa);
        if ($opcion == 1) {
            $relacion_data = array(
                'envioPorEmail'  => '1'
            );
        }
        if ($opcion == 2) {
            $relacion_data = array(
                'envioPorWhatsapp'  => '1'
            );
        }
        if ($opcion == 3) {
            $relacion_data = array(
                'envioPorSms'  => '1'
            );
        }


        $this->db->where('idAlertRelEmpresa', $valor->idAlertRelEmpresa);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA', $relacion_data);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }

    //DESTINATARIOS

    /**
     * Listado de encuestas, filtro por nombre
     * @param string $value nameSurvey, filtro
     * @param int $limit Cantidad de registros
     * @param int $offset Desde cantidad de registros
     * @param array $order Por qué campos ordenar
     */
    public function findDest($value = "", $limit = 10, $offset = 0, $order = [], $id)
    {
        $colums = [
            'e.idAlertDestinatario as id',
            'e.idAlertRelEmpresa as idRel',
            'e.correoDeEnvio as correo',
            'e.phoneDeEnvio as telefono',
            'e.statusAlert as status'

        ];
        $this->db->select(implode(',', $colums));
        $this->db->from(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS  e');
        $this->db->join(SMARTWAY_telrad . '.ALERTS_REL_EMPRESA c', 'e.idAlertRelEmpresa = c.idAlertRelEmpresa', 'left');
        $this->db->where('e.idAlertRelEmpresa', $id);
        $this->db->where_in('e.statusAlert', '1'); // activos
        $this->db->group_by('id');
        $this->db->order_by('id', 'desc');
        if (!empty($value)) {
            $this->db->like('correo', $value);
        }
        if ($limit >= 0 && $offset >= 0) {
            $this->db->limit($limit, $offset);
        }
        if (!empty($order)) {
            foreach ($order as $k => $campo) {
                $this->db->order_by($campo[0], $campo[1]);
            }
        }
        $query  = $this->db->get(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS');
        $result =  $query->result_array();

        return $result;
    }

    /**
     * Trae el valor del total de destinatarios activos
     * @param string $value correo, nombre , filtro
     */
    public function countDest($value = "")
    {
        if (!empty($value)) {
            $this->db->like('correoDeEnvio', $value);
        }
        $this->db->where_in('statusAlert', '1'); // activo 
        return $this->db->count_all_results(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS');
    }


    /**
     * Crea una Alerta
     * @param array $empresa Data de la alerta a guardar
     */
    public function createDest($alert)
    {
        $this->db->trans_begin();
        $alert_data = array(
            'idAlertRelEmpresa' => $alert['idAlertRelEmpresa'],
            'phoneDeEnvio'    => $alert['phoneDeEnvio'],
            'correoDeEnvio'    => $alert['correoDeEnvio'],
            'statusAlert'    => '1'

        );
        $this->db->insert(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS', $alert_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }

    /**
     * Obtiene un registro de una Alerta
     * @param int $id Id de Alerta
     */
    public function getDest($id)
    {
        $this->db->where('idAlertDestinatario', $id);
        $this->db->where_in('statusAlert', '1'); // activo
        $query = $this->db->get(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS');
        return $query->row_array();
    }

    /**
     * Elimina una Alerta
     * (Se cambia de estatus a 2)
     * @param int $id Id de Alerta a eliminar
     */
    public function deleteDest($id)
    {
        $this->db->trans_begin();
        $survey_data = [
            'statusAlert' => '2'
        ];
        $this->db->set($survey_data);
        $this->db->where('idAlertDestinatario', $id);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }


    /**
     * Actualiza la Alerta
     */
    public function editDest($id)
    {

        $correoDeEnvio = $this->input->post('correoDeEnvio') ? trim($this->input->post('correoDeEnvio')) : '';
        $phoneDeEnvio = $this->input->post('phoneDeEnvio') ? trim($this->input->post('phoneDeEnvio')) : '';

        $this->db->trans_begin();

        $alert_data = array(
            'correoDeEnvio' => $correoDeEnvio,
            'phoneDeEnvio' => $phoneDeEnvio
        );

        //$this->db->set($survey_data);
        $this->db->where('idAlertDestinatario', $id);
        $this->db->update(SMARTWAY_telrad . '.ALERTS_EMPRESA_DESTINATARIOS', $alert_data);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return TRUE;
    }
}
