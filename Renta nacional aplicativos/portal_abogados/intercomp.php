<html>
<?php

include("base.adj");
include("funciones.adj");
include("funciones_cobranza.adj");
include("mailer.adj");
/**
 * @abstract Archivo que permite ingresar o modificar un nuevo expediente de tipo pago entre compañías.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 19/11/2020
 * 
 */

$conn_db = TraeCon("siniestro");
$conn = TraeCon("produccion");

$codsin=$_GET["sini"];
$folio_exp=$_GET["folio_exp"];
$asegurado=$_GET["aseg"];
$liquidador=$_GET["liq"];
$fec_asig=$_GET["fec_asign"];
$fec_sin=$_GET["fec_sini"];
$fec_denu=$_GET["fec_denu"];

$sql="SELECT * FROM php_maeabo WHERE codsin=".$codsin." and folio_exp=".$folio_exp;
foreach($conn_db->query($sql) as $row){
	$ramo=$row['RAMO_ID'];
	$rut_abogado=$row['ABOG_NUMRUT']."-".$row['ABOG_DVRUT'];
}
$sql2="SELECT * FROM php_maeabo_pec WHERE codsin=".$codsin." and folio_exp=".$folio_exp;
foreach($conn_db->query($sql2) as $row2){
	$compania=trim($row2['PEC_COMPANIA_ID']);
	$num_sin_comp=trim($row2['SINIE_ID_CIA']);
	$fec_cobro=trim($row2['PEC_FECHA_COBRO']);
	$fec_pago=trim($row2['PEC_FECHA_PAGO']);
	$monto_cob=trim($row2['PEC_MTO_COBRADO']);
	$honorarios=trim($row2['PEC_HONORARIO']);
	$monto_pag=trim($row2['PEC_MTO_PAGADO']);
	$gastos=trim($row2['PEC_GASTOS']);
	$obs=trim($row2['DMD_OBSERVA']);
}
?>
<head>
<!--<script type="text/javascript" src="js/scripts.js"></script>-->
<link rel="stylesheet" href="js/jquery.css">
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
<script type="text/javascript">
$(function(){
	$("#container").tabs();
	$("#d_Cargando").css('display', 'none');
});
//actualiza datos de factor asociado a marca y modelo en la base de datos
$(document).on('click','#grabar',function(e){      
var ramo=$("#ramo").val();	
var abogado=$("#abogado").val();
var sini=$("#sini").text();
var exp=$("#nexp").text();
var nom_com=$("#nomb_comp").val();
var fecha_cob=$("#fec_cob").val();
var num_sin_tcom=$("#num_sin_tcomp").val();
var fecha_pag=$("#fec_pag").val();
var monto_cob=$("#monto_cob").val();
var monto_pag=$("#monto_pag").val();
var honorarios=$("#hono").val();
var gastos=$("#gastos").val();
var obs=$("#obs").val();

if(ramo==0){
    jAlert("Debe seleccionar ramo");
    return false;
}
if(abogado==0){
    jAlert("Debe seleccionar abogado");
    return false;
}
if(fecha_pag == ""){
	fecha_pag="01/01/1970";
}else{
	if(validarFormatoFecha(fecha_pag)){
	      if(existeFecha(fecha_pag)){
	           
	      }else{
	            jAlert("La fecha de pago introducida no existe.");
	            $("#fec_pag").val("");
	      		$("#fec_pag").focus();
	      		return false;
	      }
	}else{
	      jAlert("El formato de la fecha de pago es incorrecto.");
	      $("#fec_pag").val("");
	      $("#fec_pag").focus();
	      return false;
	}
}
if(fecha_cob == ""){
	fecha_cob="01/01/1970";
}else{
	if(validarFormatoFecha(fecha_cob)){
	      if(existeFecha(fecha_cob)){
	           
	      }else{
	            jAlert("La fecha de cobro introducida no existe.");
	            $("#fec_cob").val("");
	      		$("#fec_cob").focus();
	      		return false;
	      }
	}else{
	      jAlert("El formato de la fecha de cobro es incorrecto.");
	      $("#fec_cob").val("");
	      $("#fec_cob").focus();
	      return false;
	}
}
if(monto_cob==""){
	monto_cob=0;
}
if(monto_pag==""){
	monto_pag=0;
}
if(honorarios==""){
	honorarios=0;
}
if(gastos==""){
	gastos=0;
}
	$.ajax({
		type	: "POST",
		url		: "funciones/grabar_intercomp.php",
		async	: true,
		data	: {
		ramo 	: ramo,
		abogado : abogado,
		nom_com     : nom_com,
		fecha_cob   : fecha_cob,
		num_sin_tcom: num_sin_tcom,
		fecha_pag   : fecha_pag,
		monto_cob   : monto_cob,
		monto_pag   : monto_pag,
		hono        : honorarios,
		gastos      : gastos,
		obs         : obs,
		codsin      : sini,
		nexp        : exp
		},

		success: function(r){
			console.log(r);
			var res=r.split("*");
			if(res[0]=="OK"){
				//$("#form")[0].reset();
				jAlert(res[1]);
				cierraFancy();
			}else{
				jAlert(res[1]);
			}
		}
	});
				
});	
$(document).on('click','#imprime',function(e){
	var sini=$("#sini").text();
	var aseg='<?php echo $asegurado; ?>';
	var liq='<?php echo $liquidador; ?>';
	var fec_asign='<?php echo $fec_asig; ?>';
	var fec_sin='<?php echo $fec_sin; ?>';
	var fec_denu='<?php echo $fec_denu; ?>';
	var exp='<?php echo $folio_exp; ?>';
	var rut_ter='<?php echo $rut_tercero; ?>';
	var nom_ter='<?php echo $nombre_tercero; ?>';
	$("#obj_pdf").attr("src","funciones/pdf.php?codsin="+sini+"&aseg="+aseg+"&liq="+liq+"&fec_asign="+fec_asign+"&fec_sini="+fec_sin+"&fec_denu="+fec_denu+"&exp="+exp+"&rut_terc="+rut_ter+"&nom_terc="+nom_ter);
});	
function cierraFancy(){
	window.parent.$.fancybox.close();
}
function validarFormatoFecha(campo) {
      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
}
function existeFecha(fecha){
  var fechaf = fecha.split("/");
  var d = fechaf[0];
  var m = fechaf[1];
  var a = fechaf[2];
  var ok = true;
    if( (a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31) )
       ok = false;
    else
    {
       if((a%4 != 0) && (m == 2) && (d > 28))
          ok = false;
       else
       {
          if( (((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)) )
             ok = false;
       }
    }
    return ok;
}
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
		height: 500px;
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
			
			<ul><li><a href="#frame" style="font-size: 13px;">Pagos entre compañías</a></li></ul>
			<div id="d_Cargando" style="display: block; text-align: center; font-size: 12px; position:absolute; float: inherit; z-index:5; top: 170px; left: 250px;"><img src="<?=$URL_HOME?>/imagenes/spinner.gif"><br/>Cargando...</div>
			<div id="frame" style="width:100%">
			
				<table style="display: inline;">    
				<tbody>
	            <tr>
	            <td><b>Siniestro</b></td><td><b>:</b></td><td style="width: 750px;"><span id="sini" style="margin-left:10px"><?php echo $codsin; ?></span></td><td style="width: 150px;"><b>Fecha siniestro</b></td><td><b>:</b></td><td style="width: 350px;"><span id="fec_sini" style="margin-left:10px"><?php echo $fec_sin; ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Asegurado</b></td><td><b>:</b></td><td style="width: 750px;"><span id="aseg" style="margin-left:10px"><?php echo $asegurado; ?></span></td><td style="width: 150px;"><b>Fecha denuncio</b></td><td><b>:</b></td><td style="width: 350px;"><span id="fec_denu" style="margin-left:10px"><?php echo $fec_denu; ?></span></td>
	            </tr>
				<tr>
	            <td><b>Liquidador</b></td><td><b>:</b></td><td style="width: 750px;"><span id="liqui" style="margin-left:10px"><?php echo $liquidador; ?></span></td><td style="width: 150px;"><b>Num. expediente</b></td><td><b>:</b></td><td style="width: 350px;"><span id="nexp" style="margin-left:10px"><?php echo $folio_exp; ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Ramo</b></td><td><b>:</b></td><td style="width: 750px;">
	            	<select id="ramo" style="width: 200px;margin-left:10px">
            		<option value="0"></option>
            		<?php
					$sql_ram = "SELECT * FROM ramosuper where cia_id=1 order by ramo_descrip";
					foreach($conn->query($sql_ram) as $row){
						if($ramo==$row['RAMO_ID']){
							echo "<option value='".$row['RAMO_ID']."' selected>".$row['RAMO_DESCRIP']."</option>";	
						}else{
							echo "<option value='".$row['RAMO_ID']."'>".$row['RAMO_DESCRIP']."</option>";
						}
					}
					?>
	            	</select>
	            </td><td style="width: 240px;"><b>Fecha asignación</b></td><td><b>:</b></td><td style="width: 350px;"><span id="nexp" style="margin-left:10px"><?php echo $fec_asig; ?></span></td>
	            </tr>
	            <tr>
	            <td><b>Abogado</b></td><td><b>:</b></td><td style="width: 750px;">
	            	<select id="abogado" style="width:200px;margin-left:10px">
					<option value="0"></option>
					<?php
					$sql_abs = "SELECT numrut,digrut,nombre FROM abogados2 group by numrut,digrut,nombre order by nombre";
					foreach($conn_db->query($sql_abs) as $row){
						$rut_ab=trim($row['NUMRUT']."-".$row['DIGRUT']);
						if($rut_ab != "-"){
							if($rut_abogado==$rut_ab){
								echo "<option value='".$rut_ab."' selected>".$row['NOMBRE']."</option>";
							}else{
								echo "<option value='".$rut_ab."'>".$row['NOMBRE']."</option>";
							}	
						}	
					}
					?>
					</select>
	            </td>
	            <td colspan="3">
	            	<button id="grabar" style="margin-right:5px">Grabar datos</button><button id="imprime">Imprimir</button>
	            </td>
	            </tr>

	            <tr>
	            <table style="display: inline;margin-top:25px;">    
				<tbody>
				<tr><td colspan="3">COMPAÑÍA</td></tr>
	            <tr><hr style="margin-right:50px"></tr>	
	            <tr>
	            <td><b>Nombre</b></td><td><b>:</b></td><td>
	            	<select id="nomb_comp" style="width: 160px;margin-left:10px">
            		<option value="0"></option>
            		<?php
            		$sql_est = "SELECT * FROM estados_php where tipo=41 order by descodigo";
					foreach($conn_db->query($sql_est) as $row){
						if($compania==$row['CODIGO']){
							echo "<option value='".$row['CODIGO']."' selected>".$row['DESCODIGO']."</option>";	
						}else{
							echo "<option value='".$row['CODIGO']."'>".$row['DESCODIGO']."</option>";
						}
					}
					?>
	            	</select>
	            </td>
	            <td><b>Fecha cobro</b></td><td><b>:</b></td><td style="width: 150px;"><input type="text" id="fec_cob" style="margin-left:10px" value="<?php echo date('d/m/Y',strtotime($fec_cobro)); ?>" /></td>
	            </tr>
	            <tr>
	            <td><b>Num sin 3ra compañía</b></td><td><b>:</b></td><td><input type="text" id="num_sin_tcomp" style="margin-left:10px" value="<?php echo $num_sin_comp; ?>" /></td><td><b>Fecha pago</b></td><td><b>:</b></td><td style="width: 150px;"><input type="text" id="fec_pag" style="margin-left:10px" value="<?php echo date('d/m/Y',strtotime($fec_pago)); ?>"/></td>
	            </tr>
	            <tr>
	            <td style="padding-top:15px"><b>Monto cobrado</b></td><td style="padding-top:15px"><b>:</b></td><td style="padding-top:15px"><input type="text" id="monto_cob" style="margin-left:10px" value="<?php echo $monto_cob; ?>" /></td><td style="padding-top:15px"><b>Monto pagado</b></td><td style="padding-top:15px"><b>:</b></td><td style="width: 150px; padding-top:15px"><input type="text" id="monto_pag" style="margin-left:10px" value="<?php echo $monto_pag; ?>" /></td>
	            </tr>
	            <tr>
	            <td ><b>Honorarios</b></td><td><b>:</b></td><td><input type="text" id="hono" style="margin-left:10px" value="<?php echo $honorarios; ?>" /></td>
	            <td style="width:150px"><b>Gastos</b></td><td><b>:</b></td><td><input type="text" id="gastos" style="margin-left:10px" value="<?php echo $gastos; ?>" /></td>
	            </tr>
	            <tr>
	            <td style="width:200px"><b>Observaciones</b></td><td><b>:</b></td><td style="width: 250px;">
	            	<textarea style="margin-left:10px;width:202px;height:64px;" id="obs"><?php echo $obs; ?></textarea>
	            </td>
	            </tr>
	            </tbody>
	            </table>

	            </tr>
				</tbody>
				</table>
				
			</div>
		
	</div>
	<div id="modal1" class="modalmask">
	    <div class="modalbox movedown">
	        <a href="#close" title="Close" class="close">X</a>
	        <h2>Documento</h2>
	        <iframe id="obj_pdf" src="" width="750px" height="500px"></iframe>  
	    </div>
	</div>
</body>
</html>
<?php is_logged(); 
$conn_db = null;

?>