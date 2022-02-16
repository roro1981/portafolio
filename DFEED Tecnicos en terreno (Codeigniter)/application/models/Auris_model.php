<?php

class Auris_model extends CI_Model
{

  public function __construct()
  {
    $this->load->database();
  }

  public function getZonas()
  {
    $zonas = [];
    $sql = 'SELECT z.name as nombre, z.id_zona as id FROM ' . SMARTWAY_telrad . '.TRAZER_MAS_ZONA z;';
    $result = $this->db->query($sql);

    if (!empty($result)) {
      $zonas = $result->result_array();
    }

    $this->db->close();

    return $zonas;
  }

  public function getGrupoResolutores($idUser)
  {
    $group = [];
    $sql = 'CALL ' . SMARTWAY_telrad . '.sp_sel_grupo_resolutor_by_user(' . $idUser . ')';
    $result = $this->db->query($sql);

    if (!empty($result)) {
      $grupos = $result->result_array();
      $result->free_result();
    }
    $this->db->close();

    return $grupos;
  }

  public function getClientes($idUser)
  {
    $clientes = [];
    $sql = "SELECT nombre_empresa as 'nombre', id_empresa as 'id' FROM " . SMARTWAY_telrad . ".TRAZER_DATA_EMPRESA;";
    $result = $this->db->query($sql);

    if (!empty($result)) {
      $clientes = $result->result_array();
    }
    $this->db->close();

    return $clientes;
  }

  public function getTotalTareas()
  {
    # id_status 1 = abierto y 11 asignado
    $sql = 'SELECT count(i.id) as total, z.name as nombrezona, sum(i.idstatus = 1) as noasignado, z.id_zona FROM ' . SMARTWAY_telrad . '.TRAZER_DATA_INCIDENT i
                inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_GRUOP g on i.id_group = g.id
                inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_ZONA z on g.id_zona = z.id_zona
                group by id_zona ;';
    $result = $this->db->query($sql);

    if ($result->num_rows() > 0) {
      return $result->result_array();
    }
    return [];
  }

  public function getTotalTicketsByCliente($idCliente)
  {
    $sql = 'SELECT count(i.id) as total, z.name as nombrezona, sum(i.idstatus = 1) as noasignado, z.id_zona
            FROM ' . SMARTWAY_telrad . '.TRAZER_DATA_INCIDENT i
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_GRUOP g on i.id_group = g.id
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_ZONA z on g.id_zona = z.id_zona
            WHERE i.id_customer = ' . $idCliente . '
            group by id_zona ;';
    return $this->db->query($sql)->result_array();
  }

  public function getTotalTareasRes()
  {
    //id_status 1 = abierto y 11 asignado
    $sql = 'SELECT count(i.id) as total, g.name as nombregrupo, z.id_zona as id_zona, z.name as nombrezona, sum(i.idstatus = 1) as noasignado, z.id_zona FROM ' . SMARTWAY_telrad . '.TRAZER_DATA_INCIDENT i
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_GRUOP g on i.id_group = g.id
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_ZONA z on g.id_zona = z.id_zona
             group by g.id order by z.id_zona;';
    return $this->db->query($sql)->result_array();
  }

  public function getTotalTareasAgente()
  {
    //id_status 1 = abierto y 11 asignado
    $sql = 'SELECT count(i.id) as total ,
            g.name as nombregrupo,
            u.name as  nombreagente,
            sum(i.idstatus = 1) as noasignado
            FROM ' . SMARTWAY_telrad . '.TRAZER_DATA_INCIDENT i
            left join ' . SMARTWAY_telrad . '.TRAZER_MAS_USER u on i.iduser = u.id
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_GRUOP g on i.id_group = g.id
            group by u.id order by g.id;';
    return $this->db->query($sql)->result_array();
  }

  public function getTotalTareasDetOT()
  {
    $sql = "SELECT
                i.incident as 'incident_numero',
                i.id as 'incident_id',
                i.iduser as 'user_id',
                u.name as 'user_name',
                s.id as 'status_id',
                s.name as 'status_name',
                g.id as 'group_id',
                g.name as 'group_name',
                z.id_zona as 'zona_id',
                z.name as 'zona_name',
                i.datecreation as 'incident_datecreation',
                i.updatetime as 'incident_updatetime',
                u.imei as 'user_imei',
                i.address as 'incident_address',
                i.dateclose as 'incident_dateclose',
                i.description as 'incident_description'
            FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT i
            INNER JOIN SMARTWAY_telrad.TRAZER_MAS_STATUS s ON i.idstatus = s.id
            INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP g on i.id_group = g.id
            INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA z on g.id_zona = z.id_zona
            INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER u on u.id = i.iduser
            ORDER BY i.id DESC;";
    return $this->db->query($sql)->result_array();
  }

  public function auristiempofinalizacion()
  {
    //id_status 1 = abierto y 11 asignado
    $sql = 'SELECT z.name as nombrezona, sum(i.idstatus = 5) as finalizadas, datecreation, updatetime
        , sum(MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) > 6 and i.idstatus = 5) as seis
        , sum(MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) > 4 and MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) < 6 and i.idstatus = 5) as cuatroseis
        , sum(MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) > 2 and MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) < 4 and i.idstatus = 5) as doscuatro
        , sum(MOD(MINUTE(TIMEDIFF(datecreation, updatetime)), 24) > 21 and MOD(HOUR(TIMEDIFF(datecreation, updatetime)), 24) < 120 and i.idstatus = 5) as veintiunodos
        , sum(MOD(MINUTE(TIMEDIFF(datecreation, updatetime)), 24) > 21 and i.idstatus = 5) as veintiuno
            FROM ' . SMARTWAY_telrad . '.TRAZER_DATA_INCIDENT i
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_GRUOP g on i.id_group = g.id
            inner join ' . SMARTWAY_telrad . '.TRAZER_MAS_ZONA z on g.id_zona = z.id_zona
            group by z.id_zona;';
    //new dBug($this->db->query($sql)->result_array());exit();
    return $this->db->query($sql)->result_array();
  }

  public function getLevelOneForCustomer($idcliente, $zona, $iniDate, $finDate)
  {

    $sql = "SELECT GROUP_CONCAT(T1.id) id,
                    T4.nombre_empresa as nombre, 
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer ";
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    $sql .= " ) as total,
                
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                    WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer ";
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    $sql .= " AND TOT_T1.idstatus IN ( 11, 4, 3, 2, 12, 13 )) as asignados,
                
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer ";
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    $sql .= " AND TOT_T1.idstatus IN ( 1, 7, 8, 9, 14 )) as no_asignados,
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer ";
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    $sql .= "  AND TOT_T1.idstatus IN ( 6, 5, 10 )) as cerrados,
                  '' as tickets
                FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP     T2 ON T1.id_group    = T2.id
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA      T3 ON T2.id_zona     = T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_DATA_EMPRESA  T4 ON T1.id_customer = T4.id_empresa
                WHERE 
                T1.datecreation BETWEEN '$iniDate' AND '$finDate' ";
    if ($idcliente) {
      $sql .= " AND T4.id_empresa = " . $idcliente;
    }
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    // $sql .= " AND T1.idstatus NOT IN ( 6, 5, 10 ) ";
    $sql .= " GROUP BY T4.id_empresa ";

    return $this->db->query($sql)->result_array();
  }

  public function getLevelTwoForZona($idcliente, $zona, $iniDate, $finDate)
  {
    $sql = "SELECT GROUP_CONCAT(T1.id) id,
                    T3.name as nombre, 
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT  TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer AND 
                     T2.id_zona = TOT_T2.id_zona ) as total,
                    
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer AND 
                     TOT_T1.idstatus IN ( 11, 4, 3, 2, 12, 13 ) AND T2.id_zona = TOT_T2.id_zona ) as asignados,
                    
                    (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer AND 
                     TOT_T1.idstatus IN ( 1, 7, 8, 9, 14 ) AND T2.id_zona = TOT_T2.id_zona ) as no_asignados,
                  (SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                      INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                     WHERE TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND TOT_T1.id_customer = T1.id_customer AND 
                     TOT_T1.idstatus IN ( 6, 5, 10 ) AND T2.id_zona = TOT_T2.id_zona ) as cerrados,
                    '' as tickets
                FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP     T2 ON T1.id_group    = T2.id
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA      T3 ON T2.id_zona     = T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_DATA_EMPRESA  T4 ON T1.id_customer = T4.id_empresa
                WHERE 
                T1.datecreation BETWEEN '$iniDate' AND '$finDate' ";
    if ($idcliente) {
      $sql .= " AND T1.id IN ( " . $idcliente . " ) ";
    }
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    // $sql .= " AND T1.idstatus NOT IN ( 6, 5, 10 ) ";
    $sql .= " GROUP BY T2.id_zona ";

    return $this->db->query($sql)->result_array();
  }

  public function getLevelThreeForGrupo($idcliente, $zona, $iniDate, $finDate)
  {

    $sql = "SELECT GROUP_CONCAT(T1.id) id, T2.name as nombre, 
                ( SELECT COUNT(*)  FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                  WHERE 
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.id_group = T1.id_group ) as total, 
                
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 11, 4, 3, 2, 12, 13 ) AND TOT_T1.id_group = T1.id_group ) as asignados, 
               
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 1, 7, 8, 9, 14 ) AND TOT_T1.id_group = T1.id_group ) as no_asignados, 
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 1, 7, 8, 9, 14 ) AND TOT_T1.id_group = T1.id_group ) as cerrados, 
                    
                  '' as tickets 
                  FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT T1 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    T2 ON T1.id_group    = T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     T3 ON T2.id_zona     = T3.id_zona 
                    INNER JOIN SMARTWAY_telrad.TRAZER_DATA_EMPRESA T4 ON T1.id_customer = T4.id_empresa 
                  WHERE 
                    T1.datecreation BETWEEN '$iniDate' AND '$finDate' ";
    if ($idcliente) {
      $sql .= " AND T1.id in ( " . $idcliente . " ) ";
    }
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    // $sql .= " AND T1.idstatus NOT IN ( 6, 5, 10 ) ";
    $sql .= " GROUP BY T1.id_group ";

    return $this->db->query($sql)->result_array();
  }

  public function getLevelFourForTecnico($idcliente, $zona, $iniDate, $finDate)
  {

    $sql = "SELECT  GROUP_CONCAT(T1.id) id, T5.name as nombre,
                ( SELECT COUNT(*)  FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     TOT_T4 ON TOT_T1.iduser   = TOT_T4.id
                  WHERE 
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.iduser = T1.iduser ) as total, 
                
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     TOT_T4 ON TOT_T1.iduser   = TOT_T4.id
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 11, 4, 3, 2, 12, 13 ) AND TOT_T1.iduser = T1.iduser ) as asignados, 
               
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     TOT_T4 ON TOT_T1.iduser   = TOT_T4.id
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 1, 7, 8, 9, 14 ) AND  TOT_T1.iduser = T1.iduser ) as no_asignados, 
                ( SELECT COUNT(*) FROM SMARTWAY_telrad.TRAZER_DATA_INCIDENT TOT_T1
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    TOT_T2 ON TOT_T1.id_group = TOT_T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     TOT_T3 ON TOT_T2.id_zona  = TOT_T3.id_zona
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     TOT_T4 ON TOT_T1.iduser   = TOT_T4.id
                  WHERE  
                    TOT_T1.datecreation BETWEEN '$iniDate' AND '$finDate' AND  TOT_T1.id IN ( " . $idcliente . " ) AND
                    TOT_T1.idstatus IN ( 6, 5, 10 ) AND  TOT_T1.iduser = T1.iduser ) as cerrados, 
                  '' as tickets 
                  FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT T1 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    T2 ON T1.id_group    = T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     T3 ON T2.id_zona     = T3.id_zona 
                    INNER JOIN SMARTWAY_telrad.TRAZER_DATA_EMPRESA T4 ON T1.id_customer = T4.id_empresa 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     T5 ON T1.iduser      = T5.id
                  WHERE 
                    T1.datecreation BETWEEN '$iniDate' AND '$finDate' ";
    if ($idcliente) {
      $sql .= " AND T1.id in ( " . $idcliente . " ) ";
    }
    if ($zona) {
      $sql .= " AND T2.id_zona = " . $zona;
    }
    // $sql .= " AND T1.idstatus NOT IN ( 6, 5, 10 ) ";
    $sql .= " GROUP BY T1.iduser ";

    return $this->db->query($sql)->result_array();
  }

  public function getLevelFiveForIncident($idcliente, $zona, $iniDate, $finDate)
  {

    $sql = "SELECT T1.incident Numero, 
                  IF ( T1.preventivo = 1, 'correctivo','preventivo' ) Tipo, 
                    T1.title Titulo, 
                    T6.name Estado,
                    '' as Bitacora, 
                    T2.name 'Grupo Resolutor',
                    T5.name 'Tecnico',
                    T1.address 'Ubicacion',
                    T1.datecreation 'Fecha Creación',
                    '' as 'Fecha Integracion',
                    
                    ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                         WHERE id_incident = T1.incident AND estado = 11 order by id desc limit 1 ) 'Fecha Asignado',
                    ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                      WHERE id_incident = T1.incident AND estado = 6  order by id desc limit 1 ) 'Fecha Cierre Ticket',
                    ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                      WHERE id_incident = T1.incident AND estado = 5  order by id desc limit 1 ) 'Fecha Resolucion',
                    '' as 'Tiempo Coordinación',
                    DATEDIFF( 
                        ( IF ( ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                 WHERE id_incident = T1.incident AND estado = 5  order by id desc limit 1 ) is null , '0000-00-00 00:00:00' , 
                               ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                 WHERE id_incident = T1.incident AND estado = 5  order by id desc limit 1 ) ) ),
                          -   
                         IF ( ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                WHERE id_incident = T1.incident AND estado = 11  order by id desc limit 1 ) is null , '0000-00-00 00:00:00' , 
                              ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                WHERE id_incident = T1.incident AND estado = 11  order by id desc limit 1 ) ) ) as 'Tiempo de Atención Terreno',
                    DATEDIFF( 
                        ( IF ( ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                 WHERE id_incident = T1.incident AND estado = 6  order by id desc limit 1 ) is null , '0000-00-00 00:00:00' , 
                               ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                 WHERE id_incident = T1.incident AND estado = 6  order by id desc limit 1 ) ) ),
                          -   
                         IF ( ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                WHERE id_incident = T1.incident AND estado = 11  order by id desc limit 1 ) is null , '0000-00-00 00:00:00' , 
                              ( SELECT updatetime FROM SMARTWAY_telrad.TRAZER_HIS_TICKET 
                                WHERE id_incident = T1.incident AND estado = 11  order by id desc limit 1 ) ) ) as 'Tiempo de Atención Terreno',
                    '' as 'Tiempo Integracion'
                         
               FROM SMARTWAY_telrad .TRAZER_DATA_INCIDENT T1 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_GRUOP    T2 ON T1.id_group    = T2.id 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_ZONA     T3 ON T2.id_zona     = T3.id_zona 
                    INNER JOIN SMARTWAY_telrad.TRAZER_DATA_EMPRESA T4 ON T1.id_customer = T4.id_empresa 
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_USER     T5 ON T1.iduser      = T5.id
                    INNER JOIN SMARTWAY_telrad.TRAZER_MAS_STATUS   T6 ON T1.idstatus    = T6.id 
               WHERE 
                    T1.datecreation BETWEEN '$iniDate' AND '$finDate' ";
    if ($idcliente)
      $sql .= " AND T1.id IN ( " . $idcliente . " ) ";

    return $this->db->query($sql)->result_array();
  }
}
