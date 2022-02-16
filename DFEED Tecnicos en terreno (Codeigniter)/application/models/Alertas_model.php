<?php

class Alertas_model extends CI_Model
{
    private $bd_;

    function __construct()
    {
        parent::__construct();
    }

    public function buscarSolicitud($user_id)
    {
        try {

            $query = "SELECT s.id AS id_sol, s.id_remitente, u.name AS tecnico
                      FROM " . SMARTWAY_telrad . ".DATA_ALERTAS_STREAMING s 
                      LEFT OUTER JOIN  SMARTWAY_telrad.TRAZER_MAS_USER u ON s.id_remitente = u.id
                      WHERE s.estatus = 1 AND s.id_supervisor = $user_id";

            $query = $this->db->query($query);
            $resp = $query->result_array();

            return $resp;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }


    public function updateStatus($id_sol)
    {
        $query = "UPDATE " . SMARTWAY_telrad . ".DATA_ALERTAS_STREAMING s SET s.estatus = 0
                      where s.id = $id_sol";
        $this->db->query($query);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return true;
    }
}
