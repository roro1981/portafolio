<?php

class Tools
{
    public static function sanitize($text)
    {
        $text = trim($text);
        $text = preg_replace("/[;]/", "", $text);
        $text = str_replace("\n\r", "\n", $text);
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\n", "<br>", $text);
        return $text;
    }

    public function ClearCadena($text)
    {
        $sane = "";
        $forbidden_chars = array(
            "?", "[", "]", "\\", "<", ">", ":", ";", ",", "'", "\"", "&",
            "$", "*", "(", ")", "|", "~", "!", "{", "}", "%", chr(0));
        $source = addslashes(trim($text));
        for ($i = 0; $i < strlen($source); $i++) {
            $sane_char = $source_char = $source[$i];
            if (in_array($source_char, $forbidden_chars)) {
                $sane_char = "";
                $sane .= $sane_char;
                continue;
            }
            // Si ha pasado todos los controles, aceptamos el carácter
            $sane .= $sane_char;
        }
        return $sane;
    }

    public static function convertDate($fecha_americana)
    {
        $ano = substr($fecha_americana, 0, 4);
        $mes = substr($fecha_americana, 5, 2);
        $dia = substr($fecha_americana, 8, 2);
        $fecha_europea = "$dia/$mes/$ano";
        return $fecha_europea;
    }

    public static function deconvertDate($fecha_americana)
    {
        $ano = substr($fecha_americana, 6, 4);
        $mes = substr($fecha_americana, 3, 2);
        $dia = substr($fecha_americana, 0, 2);
        $fecha_europea = "$ano-$mes-$dia";
        return $fecha_europea;
    }

    public static function getFromDate($fecha, $formato, $campo)
    {
        $dia = "";
        $mes = "";
        $ano = "";
        if ($formato == 'A') {
            $ano = substr($fecha, 0, 4);
            $mes = substr($fecha, 5, 2);
            $dia = substr($fecha, 8, 2);
        }
        if ($formato == 'E') {
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $ano = substr($fecha, 6, 4);
        }
        switch ($campo) {
            case 'D':
                return $dia;
                break;
            case 'M':
                return $mes;
                break;
            case 'Y':
                return $ano;
                break;
        }
        return false;
    }

    public function randomColor()
    {
        $possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F");
        shuffle($possibilities);
        $color = "#";
        for ($i = 1; $i <= 6; $i++) {
            $color .= $possibilities[rand(0, 14)];
        }
        return $color;
    }

    public function dateLetras($fecha)
    {
/////////////////////////////////////////////////////////////////////////////////////
        $fechaInicio = date('d-m-Y', strtotime($fecha));
        $fechaActual = Date("d-m-Y");
        $diaActual = substr($fechaActual, 0, 2);
        $mesActual = substr($fechaActual, 3, 5);
        $anioActual = substr($fechaActual, 6, 10);
        $diaInicio = substr($fechaInicio, 0, 2);
        $mesInicio = substr($fechaInicio, 3, 5);
        $anioInicio = substr($fechaInicio, 6, 10);
        $b = 0;
        $mes = $mesInicio - 1;
        if ($mes == 2) {
            if (($anioActual % 4 == 0 && $anioActual % 100 != 0) || $anioActual % 400 == 0) {
                $b = 29;
            } else {
                $b = 28;
            }
        } else if ($mes <= 7) {
            if ($mes == 0) {
                $b = 31;
            } else if ($mes % 2 == 0) {
                $b = 30;
            } else {
                $b = 31;
            }
        } else if ($mes > 7) {
            if ($mes % 2 == 0) {
                $b = 31;
            } else {
                $b = 30;
            }
        }

        if (
            ($anioInicio > $anioActual) || ($anioInicio == $anioActual && $mesInicio > $mesActual) ||
            ($anioInicio == $anioActual && $mesInicio == $mesActual && $diaInicio > $diaActual)) {
            echo "La fecha de inicio ha de ser anterior a la fecha Actual";
        } else {
            if ($mesInicio <= $mesActual) {
                $anios = $anioActual - $anioInicio;
                if ($diaInicio <= $diaActual) {
                    $meses = $mesActual - $mesInicio;
                    $dies = $diaActual - $diaInicio;
                } else {
                    if ($mesActual == $mesInicio) {
                        $anios = $anios - 1;
                    }
                    $meses = ($mesActual - $mesInicio - 1 + 12) % 12;
                    $dies = $b - ($diaInicio - $diaActual);
                }
            } else {
                $anios = $anioActual - $anioInicio - 1;

                if ($diaInicio > $diaActual) {
                    $meses = $mesActual - $mesInicio - 1 + 12;
                    $dies = $b - ($diaInicio - $diaActual);
                } else {
                    $meses = $mesActual - $mesInicio + 12;
                    $dies = $diaActual - $diaInicio;
                }
            }
            $verDias = array("Anual" => $anios, "Meses" => $meses, "Dias" => $dies);
            return $verDias;
        }
        return false;
    }

    public function dateDias($start, $end)
    {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    public function url_exists($url = null)
    {
        if (empty($url)) {
            return false;
        }
        $options['http'] = array(
            'method' => "HEAD",
            'ignore_errors' => 1,
            'max_redirects' => 0,
        );
        @file_get_contents($url, null, stream_context_create($options));
        if (isset($http_response_header)) {
            sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode);
            //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
            $accepted_response = array(200, 301, 302);
            if (in_array($httpcode, $accepted_response)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function sendNotification($tx, $imei, $param, $tag)
    {
        $conectar = new conectionPdo();
        $routingKey = $imei . "-NOT";
        $datajson = json_encode(
            array(
                "properties" => array("headers" => array("tipo" => $tag)),
                "routing_key" => $routingKey,
                "payload" => $param,
                "payload_encoding" => "string"
            ));
        $conectar->Logs_sistema("[INFO]", __FUNCTION__, $datajson);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "15672",
            CURLOPT_URL => CURLOPT_URL_MQ_NOTIF,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $datajson,
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . AUTHORIZATION_MQ_NOTIF,
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $conectar->Logs_sistema("[ERROR] envio Notificacion", __FUNCTION__, $err);
            return false;
        } else {
            $resp = json_decode($response, true);
            if ($resp["routed"] === true) {
                $conectar->Logs_sistema("[OK] Notificacion enviada", __FUNCTION__, json_encode($resp));
                return true;
            } else {
                $conectar->Logs_sistema("[ERROR] Notificacion no enviada", __FUNCTION__, json_encode($response));
                return false;
            }
        }
    }
    public function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2]) && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string)$params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int)$params[2];
            } else {
                $paramsIndexKey = (string)$params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string)$row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}