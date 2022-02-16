<?php

/**
 * Class1 short summary.
 *
 * Class1 description.
 *
 * @version 1.0
 * @author GNB
 */
if(!defined('WEB_HOME')) define('WEB_HOME', '/var/www/html/telrad');

require_once APPPATH . '/libraries/DayLog.php';
require_once APPPATH . 'helpers/Forms_WS_Helper.php';

$rowGeneric['empresa']   = "NOMBR EMPRESA";
$rowGeneric['rut']       = "7665430-8";
$rowGeneric['direccion'] = "DIRECCION DE EMPRESA";
$rowGeneric['name']      = "NOMBRE DE USUARIO";

class FormPdfHelper {
	
    public function CreateFormCard($questions, $answers){

	    $html = "<table class=\"card\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">DATOS GENERALES NODO</td></tr>";

        for ($i=0;$i<=4;$i++){
            $html.="<tr><td class=\"question\">";
            $html.=$questions[$i];
            $html.="</td><td class=\"answer\" colspan=\"3\">";
            $html.=$answers[$i];
            $html.="</td></tr>";
        }

        // Fifth row of the card
        $html.="<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\">";
        $html.= $answers[$i];

        $i =$i +1;


        $html.= "</td><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr>";

        $i=$i+1;

        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\" colspan=\"3\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table><br /><br />";

        $flow[0]=$i+1;
        $flow[1]=$html;

	     return $flow;

    }

    public function CreateFormCard37($questions, $answers){

	    $html= "<table class=\"card\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">DATOS GENERALES NODO</td></tr>";


        for ($i=1;$i<=5;$i++){
            $html.="<tr><td class=\"question\">";
            $html.=$questions[$i];
            $html.="</td><td class=\"answer\" colspan=\"3\">";
            $html.=$answers[$i];
            $html.="</td></tr>";
        }

        // Fifth row of the card
        $html.="<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\">";
        $html.= $answers[$i];

        $i =$i +1;


        $html.= "</td><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr>";

        $i=$i+1;

        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\" colspan=\"3\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table><br /><br />";

        $flow[0]=$i+1;
        $flow[1]=$html;

        return $flow;

    }

    public function CreateFormCard36($questions, $answers){

	    $html= "<table class=\"card\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">DATOS GENERALES NODO</td></tr>";


        for ($i=1;$i<=7;$i++){
            $html.="<tr><td class=\"question\">";
            $html.=$questions[$i];
            $html.="</td><td class=\"answer\" colspan=\"3\">";
            $html.=$answers[$i];
            $html.="</td></tr>";
        }

        // Fifth row of the card
        $html.="<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\">";
        $html.= $answers[$i];

        $i =$i +1;


        $html.= "</td><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr>";

        $i=$i+1;

        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\" colspan=\"3\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table><br /><br />";

        $flow[0]=$i+1;
        $flow[1]=$html;

        return $flow;

    }

    public function CreateFormCard45($questions, $answers){

        $questions[0]=" NODO/HUB/SW";
        $questions[1]="EMPRESA INTEGRADORA";
        $questions[2]="TAREA";
        $questions[3]="ID ACCESO";
        $questions[4]="FECHA DE MANTENIMIENTO";

	    
	    $html= "<table class=\"card\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">DATOS GENERALES NODO</td></tr>";


        for ($i=0;$i<=4;$i++){
            $html.="<tr><td class=\"question\">";
            $html.=$questions[$i];
            $html.="</td><td class=\"answer\" colspan=\"3\">";
            $html.=$answers[$i];
            $html.="</td></tr>";
        }

        $html.="</table><br><br>";

        // Fifth row of the card
       /* $html.="<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\">";
        $html.= $answers[$i];

        $i =$i +1;


        $html.= "</td><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr>";

        $i=$i+1;

        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.= "</td><td class=\"answer\" colspan=\"3\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table><br /><br />";*/

        $flow[0]=$i+1;
        $flow[1]=$html;

        return $flow;

    }




    public function FillHtmlForm33($questions,$answers){

        $a=count($answers);
        $flow=$this->CreateFormCard($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\"  colspan=\"4\">";
        $html.= "LECTURAS ELECTRICAS DE BATERIAS UPS</td></tr>"	;
        $html.= "<tr><td class=\"question\"  >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];


        $i=$i+1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i+1;

        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.= $answers[$i];

        $i=$i +1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr><tr><td colspan=\"4\"  class=\"subtitle\" >";

        $i=$i +1;

        $html.= utf8_encode("DATOS DE LAS BATERIAS SEGÚN FABRICANTE</td></tr>"	);
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];

        $i=$i +1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i+1;


        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];

        $i=$i +1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr></table><br /><br />";

        $html.= "<table class=\"content\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\"  colspan=\"7\">";
        $html.= "MEDICIONES DE IMPEDANCIA DE BATERIAS</td></tr>"	;

        $html.=utf8_encode("<tr><td class=\"gridheader\">N°</td><td class=\"gridheader\">R-Range</td><td class=\"gridheader\">RESISTENCIA [mohm]</td><td class=\"gridheader\">VOLTAJE [volt]</td><td class=\"gridheader\">% MEDICIÓN</td><td class=\"gridheader\">FECHA</td><td class=\"gridheader\">ESTADO</td></tr>");

        $k=1;

        for($i=16;$i <$a-1;$i=$i+6){

            $html.="<tr><td class=\"rowheader\">" . $k . "</td>";
            $html.="<td>".  $answers[$i] . "</td>";
            $html.="<td>".  $answers[$i+1] . "</td>";
            $html.="<td>".  $answers[$i+2] . "</td>";
            $html.="<td>".  $answers[$i+3] . "</td>";
            $html.="<td>".  $answers[$i+4] . "</td>";
            $html.="<td>".  $answers[$i+5] . "</td></tr>";
            $k=$k+1;
        }

        //$html.="</table>";

        $html.="</table><br /><br /><table  class=\"content\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\">OBSERVACIONES</td></tr><tr><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table>";


        return $html;
    }

    public function FillHtmlForm28($questions,$answers){

        $a=count($answers);
        $flow=$this->CreateFormCard($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"10\">";
        $html.= "EMPALME  ELECTRICOS AC</td></tr>"	;

        //row1
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td class=\"answer\">";
        $html.= $answers[$i] ."</td>";

        $i=$i+1;

        $html.= "<td class=\"question\" >";
        $html.=$questions[$i] . "</td>";
        $html.="<td  colspan=\"7\" class=\"answer\">";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i+1;

        //row2
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i] . "</td>";
        $html.="<td class=\"answer\" >";
        $html.= $answers[$i] . "</td>";

        $i=$i +1;

        $html.= "<td class=\"question\" >";
        $html.=$questions[$i] . "</td>";
        $html.="<td  colspan=\"7\"class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i +1;

        //row3
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.= $answers[$i];

        $i=$i +1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td   colspan=\"7\"class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i +1;

        //row 4

        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];

        $i=$i +1;

        $html.= "</td><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td>";

        $i=$i+1;


        $html.= "<td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];
        $html.="</td>";

        $i=$i + 1;

        $html.= "<td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i];
        $html.="</td>";


        $i=$i + 1;

        $html.= "<td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.= $answers[$i] . "</td>";

        //close table
        $html.="</tr></table><br><br>";

        $i=$i + 1;

        //New content table

        $html.= "<table class=\"content\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\"  colspan=\"9\">";
        $html.= "TABLEROS ELECTRICOS AC</td></tr>"	;

        $html.= "<tr>
					    <td class=\"question\"  rowspan=\"2\">CTO N°</td>
					    <td class=\"question\"  colspan=\"2\">PROTECCION</td>
					    <td class=\"question\"  colspan=\"3\">CONSUMOS</td>
					    <td class=\"question\"  colspan=\"2\" rowspan=\"2\">DESCRIPCION</td>
					    <td class=\"question\"  rowspan=\"2\">ESTADO</td>
					  </tr>
					  <tr>
					    <td class=\"answer\">Marca</td>
					    <td class=\"answer\">Capacidad</td>
					    <td class=\"answer\">R (amp)</td>
					    <td class=\"answer\">S (amp)</td>
					    <td class=\"answer\">T (amp)</td>
					  </tr>";


        $k=1;

        for($i=19;$i < $a -1;$i=$i+9){

            $html.="<tr>";
            $html.="<td>".  $answers[$i+0] . "</td>";
            $html.="<td>".  $answers[$i+1] . "</td>";
            $html.="<td>".  $answers[$i+2] . "</td>";
            $html.="<td>".  $answers[$i+3] . "</td>";
            $html.="<td>".  $answers[$i+4] . "</td>";
            $html.="<td>".  $answers[$i+5] . "</td>";
            $html.="<td>".  $answers[$i+6] . "</td>";
            $html.="<td>".  $answers[$i+7] . "</td>";
            $html.="<td>".  $answers[$i+8] . "</td>";
            $html.="</tr>";

            $k=$k+1;
        }

        $html.="</table>";
        /*$html.="</table><br /><br /><table  class=\"content\" width=\"90%\" align=\"center\"><tr><td class=\"subtitle\">OBSERVACIONES</td></tr><tr><td  class=\"answer\">";
        $html.= $answers[$i];
        $html.= "</td></tr></table>";*/
	    
        return $html;
    }

    public function FillHtmlForm37($questions,$answers) {
        $a=count($answers);
        $flow=$this->CreateFormCard37($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">";
        $html.= "DATOS GENERALES PANEL DE DETECCION</td></tr>";

        //Row 1
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td  colspan=\"3\" class=\"answer\">";
        $html.= $answers[$i] ."</td></tr>";

        $i=$i+1;

        //Row 2
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\">";
        $html.= $answers[$i] . "</td>";

        $i=$i +1;

        $html.= "<td class=\"question\">";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\">";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i +1;

        //Row 3
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.= $answers[$i] . "</td>";

        $i=$i +1;

        $html.= "<td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i+1;

        //Row 4
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td  colspan=\"3\" class=\"answer\">";
        $html.= $answers[$i] ."</td>";

        $html.="</tr></table>";

        $i=$i+1;

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">";
        $html.= "DATOS GENERALES PANEL DE ASPIRACION</td></tr>"	;


        //Row 1
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td  colspan=\"3\" class=\"answer\">";
        $html.= $answers[$i] ."</td></tr>";

        $i=$i+1;

        //Row 2
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\">";
        $html.= $answers[$i] . "</td>";

        $i=$i +1;

        $html.= "<td class=\"question\">";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\">";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i +1;

        //Row 3
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.= $answers[$i] . "</td>";

        $i=$i +1;

        $html.= "<td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i+1;

        //Row 4
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td  colspan=\"3\" class=\"answer\">";
        $html.= $answers[$i] ."</td>";

        $html.="</tr></table><br><br>";

        $i=$i+1;

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"2\">";
        $html.= "DATOS GENERALES DEL AGENTE EXTINTOR</td></tr>"	;



        //Row 1
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i] ."</td>";
        $html.="<td  class=\"answer\">";
        $html.= $answers[$i] ."</td></tr>";

        $i=$i+1;

        //Row 2
        $html.= "<tr><td class=\"question\">";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\">";
        $html.= $answers[$i] . "</td></tr>";

        $i=$i +1;

        //Row 3
        $html.= "<tr><td class=\"question\">";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\">";
        $html.=$answers[$i];
        $html.="</td></tr>";

        $i=$i +1;

        //Row 4
        $html.= "<tr><td class=\"question\" >";
        $html.= $questions[$i];
        $html.="</td><td  class=\"answer\" >";
        $html.= $answers[$i] . "</td></tr>";

        $i=$i +1;

        //Row 5
        $html.= "<tr><td class=\"question\" >";
        $html.=$questions[$i];
        $html.="</td><td class=\"answer\" >";
        $html.=$answers[$i];
        $html.="</td>";

        $html.="</tr></table><br><br>";

        $i=$i+1;

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"3\">";
        $html.= "VERIFICACIONES Y LIMPIEZAS  GENERALES BATERIAS  VDC</td></tr>";
        $html.="<tr><td class=\"gridheader\">&nbsp</td><td class=\"gridheader\">ESTADO</td><td class=\"gridheader\">OBSERVACIONES</td></tr>";



        for ($i=25;$i < $a -1;$i=$i+2){
            $html.="<tr>";
            $html.="<td  class=\"question\">" . $questions[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i+1] . "</td>";
            $html.="</tr>";
        }

        $html.="</table>";

        return $html;
    }

    public function FillHtmlForm30($questions,$answers){
        $a=count($answers);
        $flow=$this->CreateFormCard($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"3\">";
        $html.= "DATOS GENERALES DE RECTIFICADOR</td></tr>";

        $html.="<tr><td class=\"question\">DATOS GENERALES</td><td class=\"question\">PLANO A</td><td class=\"question\">PLANO B</td></tr>";

        /*$html.="<tr>";
        $html.="<td class=\"question\">";
        $html.= $questions[$i];
        $html.="</td>";
        $html.="<td class=\"answer\">"*/

        for ($i=8;$i <= 15;$i=$i+2){
            $html.="<tr>";
            $html.="<td  class=\"question\">" . $questions[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i+1] . "</td>";
            $html.="</tr>";
        }

        $html.="</table><br><br>";

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"3\">";
        $html.= "LECTURAS DE RECTIFICADOR (DC)</td></tr>";

        $html.="<tr><td class=\"question\">LECTURA</td><td class=\"question\">PLANO A</td><td class=\"question\">PLANO B</td></tr>";

        for ($i=16;$i <= 29;$i=$i+2){
            $html.="<tr>";
            $html.="<td  class=\"question\">" . $questions[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td  class=\"answer\">" . $answers[$i+1] . "</td>";
            $html.="</tr>";
        }

        $html.="</table><br><br>";

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"7\">";
        $html.= "BREAKER DEL RECTIFICADOR (AC)</td></tr>";

        $html.="<tr><td class=\"question\">BREAKER</td><td class=\"question\"  colspan=\"3\">PLANO A</td><td class=\"question\" colspan=\"3\">PLANO B</td></tr>";

        for ($i=30;$i <= 33;$i=$i+2){
            $html.="<tr>";
            $html.="<td  class=\"question\">" . $questions[$i] . "</td>";
            $html.="<td  class=\"answer\" colspan=\"3\">" . $answers[$i] . "</td>";
            $html.="<td  class=\"answer\" colspan=\"3\">" . $answers[$i+1] . "</td>";
            $html.="</tr>";
        }


            $html.="<tr>";
            $html.="<td class=\"question\">" . $questions[$i] . "</td>";
            $html.="<td class=\"answer\">(R)" . $answers[$i] . "</td>";
            $html.="<td class=\"answer\">(S)" . $answers[$i+1] . "</td>";
            $html.="<td class=\"answer\">(T)" . $answers[$i+2] . "</td>";
            $html.="<td class=\"answer\">(R)" . $answers[$i+3] . "</td>";
            $html.="<td class=\"answer\">(S)" . $answers[$i+4] . "</td>";
            $html.="<td class=\"answer\">(T)" . $answers[$i+5] . "</td>";
            $html.="</tr>";

            $html.="<tr>";
            $html.="<td class=\"question\">VOLTAJES (AC)</td>";
            $html.="<td class=\"answer\">(R-S)</td>";
            $html.="<td class=\"answer\">(R-T)</td>";
            $html.="<td class=\"answer\">(T-S)</td>";
            $html.="<td class=\"answer\">(R-S)</td>";
            $html.="<td class=\"answer\">(T-S)</td>";
            $html.="<td class=\"answer\">(T)</td>";
            $html.="</tr>";

            $html.="<tr>";
            $html.="<td class=\"question\">VOLTAJE (NEUTRO - TIERRA)</td>";
            $html.="<td class=\"answer\" colspan=\"3\"></td>";
            $html.="<td class=\"answer\" colspan=\"3\"></td>";
            $html.="</tr>";

            $html.="</table><br><br>";


            $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"7\">";
            $html.= "DISTRIBUIDOR DEL RECTIFICADOR (MASTER)</td></tr>";

            $html.="<tr><td class=\"question\">N° CIRCUITO</td><td class=\"question\">MARCA</td><td class=\"question\">TIPO</td><td class=\"question\">CAP. (AMP)</td>";
            $html.="<td class=\"question\">CONSUMO (A)</td><td class=\"question\">DESCRIPCION</td><td class=\"question\">ESTADO</td></tr>";

            $i=40;

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"answer\"></td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="</table><br><br>";

            $i=$i+1;



            $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"7\">";
            $html.= "DISTRIBUIDOR DEL RECTIFICADOR (ESCLAVO)</td></tr>";

            $html.="<tr><td class=\"question\">N° CIRCUITO</td><td class=\"question\">MARCA</td><td class=\"question\">TIPO</td><td class=\"question\">CAP. (AMP)</td>";
            $html.="<td class=\"question\">CONSUMO (A)</td><td class=\"question\">DESCRIPCIÓN</td><td class=\"question\">ESTADO</td></tr>";

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"answer\"></td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="</table><br><br>";

            $i=$i+1;

            $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"6\">";
            $html.= "FUSIBLE DE BATERIAS (MASTER)</td></tr>";

            $html.="<tr><td class=\"question\">N° CIRCUITO</td><td class=\"question\">MARCA</td><td class=\"question\">TIPO</td><td class=\"question\">CAP. (AMP)</td>";
            $html.="<td class=\"question\">CONSUMO (A)</td><td class=\"question\">DESCRIPCIÓN</td></tr>";


            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="</table><br><br><br><br><br><br>";

            $i=$i+1;


            $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"6\">";
            $html.= "FUSIBLE DE BATERIAS (ESCLAVO)</td></tr>";

            $html.="<tr><td class=\"question\">N° CIRCUITO</td><td class=\"question\">MARCA</td><td class=\"question\">TIPO</td><td class=\"question\">CAP. (AMP)</td>";
            $html.="<td class=\"question\">CONSUMO (A)</td><td class=\"question\">DESCRIPCIÓN</td></tr>";

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="</table><br><br>";

            $i=$i+1;

            $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"3\">";
            $html.= "ALARMAS</td><td class=\"subtitle\" colspan=\"3\">";
            $html.= "REVISIÓN GENERAL</td></tr>";

            $html.="<tr><td class=\"question\">GLOSA</td><td class=\"question\">LOCAL</td><td class=\"question\">REMOTA</td><td class=\"question\">ACTIVIDAD</td>";
            $html.="<td class=\"question\">OK/NO OK</td><td class=\"question\">OBSERVACIÓN</td></tr>";

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°1</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Reaprete terminales Conexión</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°2</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Verif. Estado Conductores</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°3</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Revisión Fusible Baterías</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°4</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Verif. Parámetros Controlador</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°5</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Limpieza General</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $i=$i+1;

            $html.="<tr>";
            $html.="<td class=\"question\">RELE N°6</td>";
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="<td class=\"question\">Ubicación sensor Temperatura</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $i=$i+1;
            $html.="<td class=\"answer\">" . $answers[$i] . "</td>";
            $html.="</tr>";

            $html.="</table><br><br>";


            return $html;
    }

    public function FillHtmlForm36($questions,$answers) {
        $a=count($answers);
        $flow=$this->CreateFormCard36($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.= "<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\" colspan=\"4\">";
        $html.= "DATOS GENERALES GRUPO GENERADOR</td></tr>";

        $html.="<tr><td class=\"question\"></td><td class=\"question\">MARCA</td><td class=\"question\">MODELO</td><td class=\"question\">N° DE SERIE</td></tr>";
	    
        $html.="</table><br><br>";

        return $html;
	    
    }

    public function FillHtmlForm45($questions,$answers){
        $a=count($answers);
        $flow=$this->CreateFormCard45($questions,$answers);

        $i=$flow[0];
        $html=$flow[1];

        $html.="<table class=\"content\"  width=\"90%\" align=\"center\"><tr><td class=\"subtitle\"  colspan=\"2\">";
        $html.="OBSERVACIONES</td></tr>";
        $html.="<tr><td class=\"answer\"  colspan=\"2\">" . $answers[$i-1] . "</td></tr>";

        $html.="<tr><td class=\"subtitle\">FOTO</td><td class=\"subtitle\">FIRMA</td></tr>";
       
        //Begin fake fotos
        //$answers[$i]="batteriesBank.jpg";
        //$answers[$i+1]="Signature.png";
        //End fake fotos

        
	     if($answers[$i]){
		     $html.="<tr><td class=\"subtitle\"><img src=\"/images/" . $answers[$i] ."\" alt=\"Foto\"></td>";
		
	     }
	     
        if($answers[$i+1]){
	        $html.="<td class=\"subtitle\"><img src=\"/images/" . $answers[$i+1] ."\" alt=\"Foto\"></td></tr>";
        }
        

        $html.="</table>";



        return $html;
    }



    public function GetQuestionAnswerArrays($headId){
        $fws = new Forms_WS_Helper();
        $header = $fws->getFormHead_model($headId);

        $fid = $header["Data"]["Property"]["ListValue"]["Property"]["ListValue"]["Property"][0]["Value"];
        $imei = $header["Data"]["Property"]["ListValue"]["Property"]["ListValue"]["Property"][1]["Value"];
        $numpet = $header["Data"]["Property"]["ListValue"]["Property"]["ListValue"]["Property"][2]["Value"];
        $fecha = $header["Data"]["Property"]["ListValue"]["Property"]["ListValue"]["Property"][3]["Value"];

        // RECIBIR CONFIGURACION DEL FORMULARIO
        $formConfig = $fws->getFormConfig_model($fid, $imei, $numpet, $empty);
        $check = (int) $formConfig["Return"]["Code"];
        $formConfig = $formConfig["Data"]["Property"]["Value"];

        if ($check != 101) {

            // RECIBIR DATOS INGRESADOS O PRELLENADOS DEL FORMULARIO
            $dataFormEntry = $fws->getFormData_model($fid, $imei, $fecha, $numpet, $headId);

            if (isset($dataFormEntry["Data"]["Property"]["ListValue"]["Property"][0])) {
                $dataFormEntry = $dataFormEntry["Data"]["Property"]["ListValue"]["Property"];
            }

            if (isset($dataFormEntry["Data"]["Property"]["ListValue"]["Property"]["ListValue"])) {
                $tmpArr = $dataFormEntry["Data"]["Property"]["ListValue"]["Property"]["ListValue"];
                unset($dataFormEntry);
                $dataFormEntry[0]["ListValue"] = $tmpArr;
            }

            $formArr = json_decode($formConfig, true);

            // RELACIONAR LOS ANSWERS CON LOS QUESTIONS
            foreach ($dataFormEntry AS $answer) {
                $rowData = $answer["ListValue"]["Property"];
                $value = $rowData[0]["Value"];
                $questId = $rowData[1]["Value"];
                $inputType = $rowData[2]["Value"];

                foreach ($formArr["section"] AS $sectionKey => $section) {
                    foreach ($section["question"] AS $questionKey => $question) {
                        if ($question["question_id"] == $questId) {
                            $formArr["section"][$sectionKey]["question"][$questionKey]["value"][] = $value;
                            $formArr["section"][$sectionKey]["question"][$questionKey]["inputType"] = $inputType;
                        }
                    }
                }
            }

            $formArr["numpet"] = $numpet;
            $formArr["user"] = $imei;
            $formArr["fecha"] = $fecha;

            // CONTAR LOS PREGUNTAS
            $cc = 0;
            foreach ($formArr["section"] AS $sectionKey => $section) {
                foreach ($section["question"] AS $questionKey => $question) {
                    $cc++;
                }
            }
            $formArr["cc"] = $cc;

            $data["formConfig"] = $formArr;
        }

        $questArr = array();
        foreach (array_keys($data["formConfig"]["section"]) AS $secKey) {
            foreach ($data["formConfig"]["section"][$secKey]["question"] AS $quest) {
                if ($quest["typeName"] == "") {
                    $quest["typeName"] = "DATOS";
                }

                $questArr[$quest["typeName"]][] = $quest;
            }
        }


        $i=0;
        $j=0;

        $questions=[];
        $answers=[];

        foreach($questArr AS $quest1) {
            foreach($quest1 AS $quest2){
                $question = $quest2['text'];
                $answer = $quest2['value'];
                $questions[$i]=$question;

                if (isset($answer)){
                    $answers[$i]=$answer[0];
                    $j=$j+1;
                }
                else {
                    $answers[$i]="";
                    $j=$j+1;
                }
                $i=$i+1;
            }
        }

        $qa_array=[];
        $qa_array[0]=$questions;
        $qa_array[1]=$answers;

        return $qa_array;
    }

    public function SetPdf($title,$logo){
	
	     $log = new DayLog(INTERFACE_HOME_PATH, 'SetPdf');
    	
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
        $logo= APPPATH . "/../assets/images/Logo-claro.jpg";
        
        $pdf->SetCreator(PDF_CREATOR);
	     $pdf->SetAuthor('GNB');
	     $pdf->SetTitle('$title');
	     $pdf->SetSubject('$title');
	     $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // $pdf->SetHeaderData($logo, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);
        $pdf->SetHeaderData($logo, 10, strtoupper($title), 'TELRAD');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('helvetica', '', 10);
	    $log->writelog("[INFO] INICIO AFTER  \n");
        $pdf->AddPage();
	    $log->writelog("[INFO] INICIO BEFORE  \n");
	     return $pdf;
    }

    public function  TestQA($questions,$answers){
        $htmlTest ='<html>';

        $q=count($questions);
        $a=count($answers);

        if ($q<>$a)
        {
            $htmlTest.="<p>El número de preguntas es distinto al número de respuestas: N° Preguntas:=" .$s . " N° de Respuestas:=" . $a ."</p></html>" ;
            return $htmlTest;
        }

        for($i=0;$i < $q;$i++){
            $htmlTest.="<p>I:=" . $i . " --" . $questions[$i] . "=>" . $answers[$i];
        }
        return $htmlTest;

    }

    public function GetFormQuestions($fid){
        $pdo = new PDO('mysql:host=localhost;dbname=someDatabase', $username, $password);
    }

    public function InitializeHTML(){
        $html = <<<EOF
<html>
<head>
<style>
        table.card {
            color: black;
            font-family: helvetica;
            font-size: 10pt;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        table.content {
            color: black;
            font-family:helvetica;
            font-size: 8pt;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        td {
            border: 1px solid black;
        }

            td.question {
                background-color: lightgray;
                border: 1px solid black;
            }
            td.answer {
                background-color: ghostwhite;
                border: 1px solid green;
                vertical-align: middle;
            }
            td.subtitle {
                background-color: aliceblue;
                border: 1px solid black;
                font-family:helvetica;
                font-weight:bold;
                text-align:center;
            }

            td.gridheader {
                background-color: lightgray;
                border: 1px solid black;
                font-family:helvetica;
                font-weight:bold;
                text-align:center;
            }

            td.rowheader {
                background-color:cornflowerblue;
                border: 1px solid black;
                font-family:helvetica;
                font-weight:bold;
                text-align:center;
            }


        div.test {
            color: #CC0000;
            background-color: #FFFF66;
            font-family: helvetica;
            font-size: 10pt;
            border-style: solid solid solid solid;
            border-width: 2px 2px 2px 2px;
            border-color: green #FF00FF blue red;
            text-align: center;
        }

        .lowercase {
            text-transform: lowercase;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .capitalize {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
EOF;
        return $html;
    }

}





