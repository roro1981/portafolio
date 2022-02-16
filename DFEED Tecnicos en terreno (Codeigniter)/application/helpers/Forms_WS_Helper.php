<?php

/**
 * Forms_WS_Helper short summary.
 *
 * Forms_WS_Helper description.
 *
 * @version 1.0
 * @author GNB
 */
	
class Forms_WS_Helper
{

    public function getActForms_model($USER_ID = 0, $ORIGIN) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getActDynamicForms';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';
            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'IDENT';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $USER_ID;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'ORIGIN';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $ORIGIN;
            $i++;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // LISTA DE FORMULARIOS INGRESADOS CON DATOS
	public function getFormEntries_model($page = 0, $searchTxt = "", $formId, $stat) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsEntries';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'PAGE';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $page;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'SEARCH_TXT';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $searchTxt;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FORM_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $formId;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'STATUS';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $stat;
            $i++;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // LISTA DE DATOS INGRESADOS DE UN FORMULARIO
    // function getFormData_model($FORM_ID, $IMEI, $FECHA = "", $NUMPET = "", $headId = 0) {
	public function getFormData_model($FORM_ID, $IMEI, $FECHA, $NUMPET, $headId) {

        try {

            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormData';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FORM_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $FORM_ID;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'IMEI';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $IMEI;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FECHA';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $FECHA;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'NUMPET';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $NUMPET;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'HEAD_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $headId;
            
            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // LISTA DE DATOS INGRESADOS DE UN FORMULARIO
	public function getFormConfig_model($FORM_ID, $IMEI, $NUMPET, $EMPTY = 0) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormConfig';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FORM_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $FORM_ID;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'IMEI';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $IMEI;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'NUMPET';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $NUMPET;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'STOP';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $EMPTY;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // LISTA TECNICOS
	public function getFormTecnicos_model($SEARCH_VAL) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsTecnicos';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'SEARCH_VAL';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $SEARCH_VAL;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // LISTA NUMPET POR TECNICO
	public function getFormNumpet_model($IMEI, $FONO) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsNumpet';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'IMEI';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $IMEI;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FONO';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $FONO;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // INGRESO ANSWER HEADER CON FOLIO
	public function generateAnswerHeader_model($fid, $numpet, $imei) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsInsertHeader';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'FORM_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $fid;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'IMEI';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $imei;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'NUMPET';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $numpet;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // ACCEPTA/RECHAZA UN FORMULARIO INGRESADO POR UN TECNICO
	public function setDynamicFormStatus_model($stat, $headId, $obs) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'setDynamicFormStatus';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'STATUS';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $stat;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'HEADER_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $headId;
            $i++;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'OBS';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $obs;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // GUARDA LOS DATOS DEL MDF PRELLENADO PARA EL TECNICO
	public function saveHeaderPreAnswers_model($folio, $questArr) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'saveHeaderPreAnswers';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'HEAD_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $folio;
            $i++;
            foreach (array_keys($questArr) AS $questId) {
                $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = $questId;
                $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $questArr[$questId];
                $i++;
            }

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    // BUSCA LOS DATOS INGRESADOS EN EL HEADER
	public function getFormHead_model($headId) {
    	
        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsHeadData';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'HEADID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $headId;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

    }

    // TICKET HIST
	public function getFormTicketHist_model($headId) {

        try {
            $requestFinal['OperationRequest']['Header']['DateTime'] = date("Y-m-d");
            $requestFinal['OperationRequest']['Header']['Operation'] = 'getDynamicFormsTicketHist';
            $requestFinal['OperationRequest']['Header']['Destination'] = '';

            $i = 0;
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Name'] = 'HEAD_ID';
            $requestFinal['OperationRequest']['Data']['Property'][$i]['Value'] = $headId;

            $client = new nusoap_client(URL_IP_FORM_ENPOINT, true);

            $result = $client->call('OutputRequest', $requestFinal);
            //print_r($result);

            if ($client->fault) {
                $code = 2;
                $description = 'Error al consultar el servicio';
            } else {
                $err = $client->getError();
                if ($err) {
                    $code = 3;
                    $description = $err;
                } else {
                    $code = 0;
                    $description = 'Consulta exitosa';
                }
            }

            if ($code == 2 || $code == 3) {
                $var = "NOK";
                return $var;
            } else if ($code == 0) {
                return $result;
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

    }

}