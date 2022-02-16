<html>
<?php

include("base.adj");
include("funciones.adj");
include("funciones_cobranza.adj");
include("mailer.adj");
/**
 * @abstract Archivo que genera pdf con todos los expedientes asociados al siniestro ingresado.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */

$conn_db = TraeCon("siniestro");
$conn = TraeCon("produccion");

$codsin=$_GET["codsin"];
$asegurado=$_GET["aseg"];
$liquidador=$_GET["liq"];
$fec_asig=$_GET["fec_asign"];
$fec_sin=$_GET["fec_sini"];
$fec_denu=$_GET["fec_denu"];
$expediente=$_GET["exp"];
$rut_tercero=$_GET["rut_terc"];
$nombre_tercero=$_GET["nom_terc"];

$sql="SELECT * FROM php_maeabo WHERE codsin=".$codsin." and folio_exp=".$expediente;
foreach($conn_db->query($sql) as $row){
	$ramo=$row['RAMO_ID'];
	$rut_abogado=$row['ABOG_NUMRUT'];
	$dv_abogado=$row['ABOG_DVRUT'];
}


?>
<head>
<!--<script type="text/javascript" src="js/scripts.js"></script>-->
<link rel="stylesheet" href="../js/jquery.css">
<link rel='stylesheet' type='text/css' href='<?=$URL_HOME?>/librerias/jquery.data-table/css/demo_table_jui.css'/>
<link rel="stylesheet" type="text/css" href="<?=$URL_HOME?>/librerias/jquery-ui-1.8.17/css/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" type="text/css" href="<?=$URL_HOME?>/librerias/jquery-ui-1.8.17/css/redmond/jquery-ui-1.9.2.custom.min.css">
<link rel='stylesheet' type='text/css' href='<?=$URL_HOME?>/librerias/nightly/jquery.qtip.min.css'/>
<link rel='stylesheet' type='text/css' href='<?=$URL_HOME?>/librerias/jquery.alerts/jquery.alerts.css'>
<link href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox-buttons.css" rel="stylesheet">
<link href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox-thumbs.css" rel="stylesheet">
<link href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox.css" rel="stylesheet">

<!-- <link rel="stylesheet" type="text/css" href="includes/estilo.css"> -->
<!-- <script type="text/javascript" src="includes/scripts.js"></script> -->
<script src='<?=$URL_HOME?>/librerias/jquery/jquery-1.7.1.js' type="text/javascript"></script>
<script src='<?=$URL_HOME?>/librerias/jquery.alerts/jquery.alerts.js' type='text/javascript'></script>
<script src='<?=$URL_HOME?>/librerias/nightly/jquery.qtip.min.js' type='text/javascript'></script>
<script src='<?=$URL_HOME?>/js/validaciones.js' type='text/javascript'></script>
<script src='<?=$URL_HOME?>/librerias/jquery-ui-1.8.17/development-bundle/ui/jquery-ui-1.8.17.custom.js' type='text/javascript'></script>
<script src='<?=$URL_HOME?>/librerias/jquery.data-table/jquery.dataTables.js' type='text/javascript'></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox.js"></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?=$URL_HOME?>/librerias/jsPDF/examples/libs/jspdf.umd.js"></script>
<script src="<?=$URL_HOME?>/librerias/jsPDF/dist/jspdf.plugin.autotable.js"></script>
<script type="text/javascript">
$(function(){
	$("#container").tabs();
	$("#d_Cargando").css('display', 'none');
});

$(document).ready(function(){
var filas=0;
    $("#tabla_recupero tbody tr").find('td:eq(0)').each(function () {
			filas+=1;	
    });
    if(filas>0){
        var nom_archi="Expedientes siniestro "+<?php echo $codsin; ?>; 
        var doc = new jspdf.jsPDF()
            // Simple html example
            doc.text("Numero siniestro: "+<?php echo $codsin; ?>, 15, 15)
            doc.autoTable({ html: '#tabla_recupero', startY: 20,cellPadding: 10})
            doc.save(nom_archi+'.pdf')
    }else{
        jAlert("No hay registros para exportar a PDF");
    }    
});

</script>
<style type="text/css">
	button {
	    -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	    -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	    box-shadow:inset 0px 1px 0px 0px #ffffff;
	    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f1f1f1), color-stop(1, #cccccc) );
	    background:-moz-linear-gradient( center top, #f1f1f1 5%, #cccccc 100% );
	    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f1f1f1', endColorstr='#cccccc');
	    background-color:#f1f1f1;
	    padding-left: 4px;
	    padding-right: 4px;
	    -moz-border-radius:3px;
	    -webkit-border-radius:3px;
	    border-radius:3px;
	    border:1px solid #999999;
	    display:inline-block;
	    color:#666666;
	    font-family:arial;
	    font-size:12px !important;
	    font-weight:bold;
	    height: 25px;
	    text-decoration:none;
	    cursor: pointer;
	}

	button:hover {
	    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #f1f1f1) );
	    background:-moz-linear-gradient( center top, #cccccc 5%, #f1f1f1 100% );
	    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#cccccc', endColorstr='#f1f1f1');
	    background-color:#cccccc;
	    cursor: pointer;
	}

	button:active {
	    position:relative;
	    top:1px;
	    cursor: pointer;
	}


	.ui-datepicker{
		width: auto;
		margin-top: 1px;
	}

	#facept .ui-datepicker .ui-widget{
	    display: block;
	    height: 272px;
	    left: 47px;
	    position: absolute;
	    top: 0;
	    width: 204px;
	    z-index: 1;
	}

	input, textarea, select{
	    background-image: url("<?=$URL_HOME?>images/form_bg.jpg");
	    background-repeat: repeat-x;
	    border: 1px solid #999;
	    border-radius: 2px;
	    color: #333;	    
	    font-size: 12px !important;
	    font-family: verdana !important;
	    height: 20px;
	    padding-left: 1px;
	}

	#container{
		margin-top: -5px;
		margin-left: -8px;
		margin-bottom: -8px;
		width: 850px;
		height: 650px;
	}

	#ui-datepicker-div{
		font-family: verdana !important;
		font-size: 12px !important;
	}

	.label {
		color: #555;
		font-weight: bold;
		font-size: 13px !important;
	}
	label{
		color: #555;
		font-weight: bold;
		font-size: 12px !important;	
	}
	td{
		font-weight: bold;
		font-size: 11px !important;		
	}
	
</style>
</head>

<body>
	<div id="container" height="">
			
			<ul><li><a href="#frame" style="font-size: 13px;">Recuperos</a></li></ul>
			<div id="d_Cargando" style="display: block; text-align: center; font-size: 12px; position:absolute; float: inherit; z-index:5; top: 170px; left: 250px;"><img src="<?=$URL_HOME?>/imagenes/spinner.gif"><br/>Cargando...</div>
			<div id="frame" style="width:100%">
			
				<table id="tabla_recupero" style="display: inline;border-collapse: collapse;">    
				<tbody>
	            <tr>
	            <td><b>Asegurado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo $asegurado; ?></span></td><td style="width: 300px;"><b>Fecha siniestro</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo $fec_sin; ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Liquidador</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo $liquidador; ?></span></td><td style="width: 300px;"><b>Fecha denuncio</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo $fec_denu; ?></span></td>
	            </tr>
				<tr>
	            <td><b>Fecha asignación</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo $fec_asig; ?></span></td>
	            </tr>
	            <?php
	            $sql="SELECT * FROM php_maeabo WHERE codsin=".$codsin." order by folio_exp";
				foreach($conn_db->query($sql) as $fila){
				$exp=$fila['FOLIO_EXP'];
				$gestion=trim($fila['TIPO_GESTION_ID']);
				if($gestion==1){
					$tipo_ges="(TIPO GESTIÓN RECUPERO)";
				}elseif($gestion==2){
					$tipo_ges="(TIPO GESTIÓN DEMANDA)";
				}elseif($gestion==3){
					$tipo_ges="(TIPO GESTIÓN PAGO INTERCOMPAÑÍA)";
				}
				$sql_ab = "SELECT nombre FROM abogados2 where numrut=".$fila['ABOG_NUMRUT']." and digrut='".trim($fila['ABOG_DVRUT'])."'";
					foreach($conn_db->query($sql_ab) as $row1){
						$nom_abog=trim($row1['NOMBRE']);	
					}
				$sql_ram = "SELECT ramo_descrip FROM ramosuper where cia_id=1 and ramo_id=".$fila['RAMO_ID'];
				foreach($conn->query($sql_ram) as $row2){
					$nombre_ramo=trim($row2['RAMO_DESCRIP']);	
				}	
	            ?>
	            <tr><td colspan="6"></td></tr>
	            <tr><td colspan="4">Expediente <?php echo $exp." ".$tipo_ges; ?> </td></tr>	
	            <?php 
	            if($gestion==1){
	            $sql_e="SELECT * FROM php_maeabo_rcpr WHERE codsin=".$codsin." and folio_exp=".$exp;
				foreach($conn_db->query($sql_e) as $row){	
	            ?>
	            <tr><td colspan="3">DATOS TERCERO</td></tr>
	            <tr>
	            <td><b>Abogado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nom_abog); ?></span></td>
	            <td style="width: 300px;"><b>Ramo</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nombre_ramo); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Nombre</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nombre_tercero); ?></span></td>
	            <td style="width: 300px;"><b>Fono</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($row['TERC_FONO']); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Mail</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($row['TERC_EMAIL']); ?></span></td>
	            <td style="width: 300px;"><b>Rut</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($rut_tercero); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Tribunal</b></td><td><b>:</b></td><td style="width:500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($row['RPCR_TRIBUNAL']); ?></span></td>
	            <td style="width: 300px;"><b>Causa/Rol</b></td><td><b>:</b></td><td style="width: 350px"><span style="margin-left:10px;font-size:12px"><?php echo trim($row['RCPR_CAUSA']); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Estado recupero</b></td><td><b>:</b></td><td style="width: 500px;">
	            	<span style="margin-left:10px"><?php
					$sql_est = "SELECT * FROM estados_php where tipo=48 and codigo=".trim($row['RCPR_ESTADO']);
					foreach($conn_db->query($sql_est) as $row_est){
						echo trim($row_est['DESCODIGO']);
					}
					?>
	            	</span>
	            </td>
	            <td style="width:300px;"><b>Tercero</b></td><td><b>:</b></td><td style="width:350px;">
	            	<span style="margin-left:10px"><?php
					$sql_est = "SELECT * FROM estados_php where tipo=49 and codigo=".trim($row['RCPR_TIPO_TERCERO']);
					foreach($conn_db->query($sql_est) as $row_tip){
						echo trim($row_tip['DESCODIGO']);
					}
					?>
	            	</span>
	            </td>
	            </tr>
	            <tr>
	            <td><b>Estado liquidación</b></td><td><b>:</b></td><td style="width: 500px;">
            		<span style="margin-left:10px"><?php
					$sql_est = "SELECT * FROM maeliq where fecproc=(SELECT max(fecproc) as max_fecha FROM maeliq where codsin=".$codsin.") and codsin=".$codsin;
					$con=0;
					foreach($conn_db->query($sql_est) as $row_el){
						echo trim($row_el['FORMA']);
						$con++;
					}
					if($con==0){
						echo "NL";
					}
					?>
	            	</span>
	            </td>
	            <td style="width: 300px;"><b>Monto indemnizado</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_MTO_INDEMI']); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Monto cobrado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_MONTO_COBRADO']); ?></span></td>
	            <td style="width:300px"><b>Monto recupero</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_MTO_RECUPERO']); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Honorarios</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_HONORARIOS']); ?></span></td>
	            </td>
	            <td style="width:300px"><b>Gastos</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_GASTOS']); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Tipo cobro</b></td><td><b>:</b></td><td style="width: 500px;">
            		<span style="margin-left:10px"><?php
            		$sql_est = "SELECT * FROM estados_php where tipo=50 and codigo=".trim($row['RCPR_TIPO_COBRO']);
					foreach($conn_db->query($sql_est) as $row_cob){
						echo trim($row_cob['DESCODIGO']);	
					}
					?>
	            	</span>
	            </td>
	            <td style="width:300px"><b>Compañía culpable</b></td><td><b>:</b></td><td style="width: 350px;">
            		<span style="margin-left:10px"><?php
            		$sql_est = "SELECT * FROM estados_php where tipo=41 and codigo=".trim($row['RCPR_COMPANIA_ID']);
					foreach($conn_db->query($sql_est) as $row_com){
						echo trim($row_com['DESCODIGO']);
					}
					?>
            		</span>
	            </td>
	            </tr>
	            <tr>
	            <td><b>Siniestro cía culpable</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo trim($row['RCPR_SINIE_ID_CIA']); ?></span></td>
	            <td style="width:300px"><b>Fecha cobro</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px"><?php echo date("d/m/Y",strtotime($row['RCPR_FECHA_COBRO'])); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Fecha recupero</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px"><?php echo date("d/m/Y", strtotime($row['RCPR_FECHA_RECUPE'])); ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Observaciones</b></td><td><b>:</b></td><td style="width: 500px;" colspan="4"><span style="margin-left:10px"><?php echo trim($row['RCPR_OBSERVA']); ?></span></td>
	            </tr>
	            <?php 
	        	} //cierre reparo
         		}elseif($gestion==2){ /* cierre if reparo*/ 
	         		$sql_e="SELECT * FROM php_maeabo_dmd WHERE codsin=".$codsin." and folio_exp=".$exp;
					foreach($conn_db->query($sql_e) as $row){	
					?>	
					<tr><td colspan="3">DATOS DEMANDANTE</td></tr>
					<tr>
		            <td><b>Abogado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nom_abog); ?></span></td>
		            <td style="width: 300px;"><b>Ramo</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nombre_ramo); ?></span></td>
		            </tr>
					<tr>
		            <td><b>Nombre</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $nombre_tercero; ?></span></td>
		            <td style="width: 300px;"><b>Fono</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $row['TERC_FONO']; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Mail</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['TERC_EMAIL']; ?></span></td>
		            <td style="width: 300px;"><b>Rut</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $rut_tercero; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Tribunal</b></td><td><b>:</b></td><td style="width: 500px"><span style="margin-left:10px;"><?php echo $row['DMD_TRIBUNAL']; ?></span></td>
		            <td style="width: 300px;"><b>Causa/Rol</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $row['DMD_CAUSA']; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Fecha demanda</b></td><td><b>:</b></td><td style="width: 500px"><span style="margin-left:10px;"><?php echo date("d/m/Y", strtotime($row['DMD_FECHA_DMD'])); ?></span></td>
		            <td style="width: 300px"><b>Tipo acuerdo</b></td><td><b>:</b></td><td style="width: 350px">
	            		<span style="margin-left:10px;"><?php
	            		if($row['DMD_TIPO_ACUERDO']==1){
	            			echo 'AVENIMIENTO';
	            		}elseif($row['DMD_TIPO_ACUERDO']==2){
	            			echo 'SENTENCIA';
	            		}else{
	            			echo '-';
	            		}
	            		?>
		            	</span>
		            </td>
		            </tr>
		            <tr>
		            <td><b>Fecha asignación</b></td><td><b>:</b></td><td style="width: 500px"><span style="margin-left:10px;"><?php echo date("d/m/Y", strtotime($row['DMD_FECHA_ASIGNA'])); ?></span></td>
		            <td style="width:300px;"><b>Monto demanda</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $row['DMD_MTO_DEMANDA']; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Monto pagado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['DMD_MTO_PAGADO']; ?></span></td>
		            <td style="width:300px"><b>Honorarios</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $row['DMD_HONORARIO']; ?></span></td>
		            </tr>
		            <td><b>Gastos</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['DMD_GASTOS']; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Observaciones</b></td><td><b>:</b></td><td colspan="4" style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['DMD_OBSERVA']; ?></span></td>
		            </tr>
		            <?php
		            }
         		}elseif($gestion==3){
         			$sql_e="SELECT * FROM php_maeabo_pec WHERE codsin=".$codsin." and folio_exp=".$exp;
					foreach($conn_db->query($sql_e) as $row){
         			?>
         			<tr><td colspan="3">COMPAÑÍA</td></tr>
         			<tr>
		            <td><b>Abogado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nom_abog); ?></span></td>
		            <td style="width: 300px;"><b>Ramo</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo trim($nombre_ramo); ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Nombre</b></td><td><b>:</b></td><td style="width: 500px;">
	            		<span style="margin-left:10px;"><?php
	            	    $sql_est = "SELECT * FROM estados_php where tipo=41 and codigo=".$row['PEC_COMPANIA_ID'];
						foreach($conn_db->query($sql_est) as $row_compa){
							echo trim($row_compa['DESCODIGO']);
						}
						?>
		            	</span>
		            </td>
		            <td style="width: 300px;"><b>Fecha cobro</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo date("d/m/Y", strtotime($row['PEC_FECHA_COBRO'])); ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Num sin 3ra compañía</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo trim($row['SINIE_ID_CIA']); ?></span></td>
		            <td style="width:300"><b>Fecha pago</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo date("d/m/Y", strtotime($row['PEC_FECHA_PAGO'])); ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Monto cobrado</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['PEC_MTO_COBRADO']; ?></span></td>
		            <td style="width: 300px;"><b>Monto pagado</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;"><?php echo $row['PEC_MTO_PAGADO']; ?></span></td>
		            </tr>
		            <tr>
		            <td><b>Honorarios</b></td><td><b>:</b></td><td style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['PEC_HONORARIO']; ?></span></td>
		            <td style="width:300px"><b>Gastos</b></td><td><b>:</b></td><td style="width:350px"><span style="margin-left:10px;"><?php echo $row['PEC_GASTOS']; ?></span></td>
		            <tr>
		            <td><b>Observaciones</b></td><td><b>:</b></td><td colspan="4" style="width: 500px;"><span style="margin-left:10px;"><?php echo $row['DMD_OBSERVA']; ?></span></td>
		            </tr>
         			<?php
         			}
         		}//cierre if 
	            } // cierre foreach principal

	            ?>
				</tbody>
				</table>
				
			</div>
		
	</div>
	
</body>
</html>
<?php is_logged(); 
$conn_db = null;

?>