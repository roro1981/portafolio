<?php


/* * ***************************************************************** 

 * Copyright (c) VPT S.A. 2001-2008. All Rights Reserved.           

 *  --------------------------------------------------------------  *
 *  Derechos Reservados VPT S.A.                                    *
 *  Prohibida su Reproduccion Total o Parcial por cualquier metodo. *

 *                  INFORMACION CONFIDENCIAL                        *
 *
 * *******************************************************************

 * =====================================================================================
 * -------------------------------------------------------------------------------------
 *  Descripcion:

 *  Utilidad para conexi&oacute;n y ejecucion de consultas a BD.

 * -------------------------------------------------------------------------------------
 *  Log de cambios:

 *  Fecha       Resp.   Detalle
 * -------------------------------------------------------------------------------------
 *  2016-04-26  HH      Creacion del archivo.
 * 
  -------------------------------------------------------------------------------------
  =====================================================================================
 */

/**
 * Clase para conexi&oacute;n y ejecucion de consultas a BD.
 *
 * @category  UtilsVPT
 * @package   Utils/php
 * @example <br />
  * <pre>$db = new DBConnector('USER', 'PASS', '172.16.19.112');
 * $db->openConnection();
 * if ($db->getError() == 0) {
 *     $data = $db->executeStmtResult('SHOW PROCESSLIST;');
 *     print_r($db->getError() . "\n");
 *     print_r($db->getErrorDescription() . "\n");
 *     print_r($db->getNumRows() . "\n");
 *     print_r($data);
 * 
 *     for ($i = 0; $i < $db->getNumRows(); $i++) {
 *         echo $data[$i]['User'] . ' - ' . $data[$i]['Host'] . "\n";
 *     }
 * 
 *     $db->executeStmt('UPDATE ARTEMISA_EVENTS.ART_DATA_REQUEST SET CreationTimestamp = NOW() WHERE Id = 4;');
 *     print_r($db->getError() . "\n");
 *     print_r($db->getErrorDescription() . "\n");
 *     print_r($db->getAffectedRows() . "\n");
 * }
 * $db->closeConnection();
 * 
 * **** OUTPUT:
 * 
 * 0
 * OK
 * 1
 * Array
 * (
 *     [0] => Array
 *         (
 *             [0] => 2363
 *             [Id] => 2363
 *             [1] => vpt
 *             [User] => vpt
 *             [2] => 172.16.19.112:26851
 *             [Host] => 172.16.19.112:26851
 *             [3] => 
 *             [db] => 
 *             [4] => Query
 *             [Command] => Query
 *             [5] => 0
 *             [Time] => 0
 *             [6] => 
 *             [State] => 
 *             [7] => SHOW PROCESSLIST
 *             [Info] => SHOW PROCESSLIST
 *         )
 * 
 * )
 * vpt - 172.16.19.112:26851
 * 0
 * OK
 * 1</pre>
 * @version   0.01
 * @since     2016-04-25
 * @author hherrera
 */
class DBConnector {

    /**
     * Constantes propias de la clase
     */
    const ERROR_CODE_OK = '0';
    const ERROR_DESC_OK = 'OK';
    const ERROR_CODE_CONSTRUCTOR_PARAMETERS = 100;
    const ERROR_DESC_CONSTRUCTOR_PARAMETERS = 'Invalid parameters in constructor, it will not connect to database.';
    const ERROR_DESC_OK_DISCONNECTED = 'Diconnect success.';
    const FLAG_DISCONNECTED = true;
    const MYSQL_DEFAULT_PORT = 3306;

    private $szUser;
    private $szPass;
    private $szIpAddress;
    private $szSchema;
    private $nPort;
    private $nError;
    private $szErrorDescription;
    private $pLink;
    private $bFlagDisconnected;
    private $nAffectedRows;
    private $nNumRows;

    /**
     * Constructor de la clase.
     * 
     * @param string $szUser Parametro obligatorio, setea usuario del motor de BD.
     * @param string $szPass Parametro obligatorio, setea password del motor de BD.
     * @param string $szIpAddress Parametro obligatorio, setea ipaddress del motor de BD.
     * @param int $nPort Parametro opcional. Setea puerto de conexi&oacute;n, por defecto 3306.
     * @param string $szSchema Parametro opcional. Indica schema a seleccionar en la conexi&oacute;.
     */
    public function __construct($szUser = NULL, $szPass = NULL, $szIpAddress = NULL, $nPort = self::MYSQL_DEFAULT_PORT, $szSchema = NULL) {

        if (!isset($szUser) || !isset($szPass) || !isset($szIpAddress) || $szUser == '' || $szPass == '' || $szIpAddress == '') {
            $this->setError(self::ERROR_CODE_CONSTRUCTOR_PARAMETERS);
            $this->setErrorDescription(self::ERROR_CONSTRUCTOR_PARAMETERS);
        } else {
            $this->setSzUser($szUser);
            $this->setSzPass($szPass);
            $this->setSzIpAddress($szIpAddress);
            $this->setNPort($nPort);
            $this->setSzSchema($szSchema);
        }
    }

    public function __destruct() {
        if (!$this->getBFlagDisconnected()) {
            mysql_close($this->getPLink());
            $this->setError(self::ERROR_CODE_OK);
            $this->setErrorDescription(self::ERROR_DESC_OK_DISCONNECTED);
        }
    }

    /**
     * Establece conexi&oacute;n a la base de datos en base los par&aacute;metros establecidos en el constructor.
     */
    public function openConnection() {

        $this->setPLink(mysql_connect($this->getSzIpAddress() . ':' . $this->getNPort(), $this->getSzUser(), $this->getSzPass()));
        if (!$this->getPLink()) {
            $this->setError(mysql_errno());
            $this->setErrorDescription(mysql_error());
            $this->setBFlagDisconnected(self::FLAG_DISCONNECTED);
        } else {
            if (!is_null($this->getSzSchema())) {
                if (!mysql_select_db($this->getSzSchema(), $this->getPLink())) {
                    $this->setError(mysql_errno($this->getPLink()));
                    $this->setErrorDescription(mysql_error($this->getPLink()));
                    $this->setBFlagDisconnected(self::FLAG_DISCONNECTED);
                }
            }
            $this->setError(self::ERROR_CODE_OK);
            $this->setErrorDescription(self::ERROR_DESC_OK);
        }
    }

    /**
     * Cierra la conexi&oacute;n con la base de datos siempre y cuando se haya establecido correctamente.
     */
    public function closeConnection() {
        if (!$this->getBFlagDisconnected()) {
            mysql_close($this->getPLink());
            $this->setError(self::ERROR_CODE_OK);
            $this->setErrorDescription(self::ERROR_DESC_OK_DISCONNECTED);
            $this->setBFlagDisconnected(self::FLAG_DISCONNECTED);
        }
    }

    /**
     * Metodo para consultas del tipo UPDATE y DELETE.
     * 
     * @param string $szQuery Consulta a realizar en BD.
     */
    public function executeStmt($szQuery) {

        if (!$this->getBFlagDisconnected()) {
            $this->openConnection();
        }

        if (!mysql_query($szQuery, $this->getPLink())) {
            $this->setError(mysql_errno($this->getPLink()));
            $this->setErrorDescription(mysql_error($this->getPLink()));
        } else {
            $this->setAffectedRows(mysql_affected_rows($this->getPLink()));

            $this->setError(self::ERROR_CODE_OK);
            $this->setErrorDescription(self::ERROR_DESC_OK);
        }
    }

    /**
     * Metodo para consultas solo de tipo SELECT
     * 
     * @param string $szQuery Consulta a realizar en BD.
     * @return array
     */
    public function executeStmtResult($szQuery) {

        $arrayData = array();

        if (!$this->getBFlagDisconnected()) {
            $this->openConnection();
        }

        $result = mysql_query($szQuery, $this->getPLink());
        if (!$result) {
            $this->setError(mysql_errno($this->getPLink()));
            $this->setErrorDescription(mysql_error($this->getPLink()));
        } else {
            $this->setNumRows(mysql_num_rows($result));

            if ($this->getNumRows() > 0) {
                while ($row = mysql_fetch_array($result)) {
                    array_push($arrayData, $row);
                }
            }

            mysql_free_result($result);
            $this->setError(self::ERROR_CODE_OK);
            $this->setErrorDescription(self::ERROR_DESC_OK);
        }

        return $arrayData;
    }

    /**
     * Funcion que entrega la cantidad de registros afectados por la consulta tipo DELETE/UPDATE ejecutada.
     * 
     * @return int Numero de registros afectados.
     */
    public function getAffectedRows() {
        return $this->nAffectedRows;
    }
    
    /**
     * Funcion que entrega la cantidad de registros de la consulta tipo SELECT ejecutada.
     * 
     * @return int Numero de registros rescatados.
     */
    public function getNumRows() {
        return $this->nNumRows;
    }
    
    public function getLastInsertId(){
        return mysql_insert_id($this->getPLink());
    }
    
    public function getError() {
        return $this->nError;
    }

    public function getErrorDescription() {
        return $this->szErrorDescription;
    }

    private function setError($nError) {
        $this->nError = $nError;
    }

    private function setErrorDescription($szErrorDescription) {
        $this->szErrorDescription = $szErrorDescription;
    }

    private function getSzUser() {
        return $this->szUser;
    }

    private function getSzPass() {
        return $this->szPass;
    }

    private function getSzIpAddress() {
        return $this->szIpAddress;
    }

    private function getNPort() {
        return $this->nPort;
    }

    private function setSzUser($szUser) {
        $this->szUser = $szUser;
    }

    private function setSzPass($szPass) {
        $this->szPass = $szPass;
    }

    private function setSzIpAddress($szIpAddress) {
        $this->szIpAddress = $szIpAddress;
    }

    private function setNPort($nPort) {
        $this->nPort = $nPort;
    }

    private function getSzSchema() {
        return $this->szSchema;
    }

    private function setSzSchema($szSchema) {
        $this->szSchema = $szSchema;
    }

    private function getPLink() {
        return $this->pLink;
    }

    private function setPLink($pLink) {
        $this->pLink = $pLink;
    }

    private function getBFlagDisconnected() {
        return $this->bFlagDisconnected;
    }

    private function setBFlagDisconnected($bFlagDisconnected) {
        $this->bFlagDisconnected = $bFlagDisconnected;
    }    

    private function setAffectedRows($nAffectedRows) {
        $this->nAffectedRows = $nAffectedRows;
    }

    private function setNumRows($nNumRows) {
        $this->nNumRows = $nNumRows;
    }

}

/*$db = new DBConnector('vpt', '4150_rhn', '172.16.19.112');
$db->openConnection();
if ($db->getError() == 0) {
    $data = $db->executeStmtResult('SHOW PROCESSLIST;');
    print_r($db->getError() . "\n");
    print_r($db->getErrorDescription() . "\n");
    print_r($db->getNumRows() . "\n");
    print_r($data);

    for ($i = 0; $i < $db->getNumRows(); $i++) {
        echo $data[$i]['User'] . ' - ' . $data[$i]['Host'] . "\n";
    }

    $db->executeStmt('UPDATE ARTEMISA_EVENTS.ART_DATA_REQUEST SET CreationTimestamp = NOW() WHERE Id = 4;');
    print_r($db->getError() . "\n");
    print_r($db->getErrorDescription() . "\n");
    print_r($db->getAffectedRows() . "\n");
}
$db->closeConnection();

OUTPUT:

0
OK
1
Array
(
    [0] => Array
        (
            [0] => 2363
            [Id] => 2363
            [1] => vpt
            [User] => vpt
            [2] => 172.16.19.112:26851
            [Host] => 172.16.19.112:26851
            [3] => 
            [db] => 
            [4] => Query
            [Command] => Query
            [5] => 0
            [Time] => 0
            [6] => 
            [State] => 
            [7] => SHOW PROCESSLIST
            [Info] => SHOW PROCESSLIST
        )

)
vpt - 172.16.19.112:26851
0
OK
1

*/
