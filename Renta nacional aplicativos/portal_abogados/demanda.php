<html>
<?php
/**
 * @abstract Archivo que permite ingresar o modificar un nuevo expediente de tipo demanda.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */
include("base.adj");
include("funciones.adj");
include("funciones_cobranza.adj");
include("mailer.adj");
/**
 * @abstract Archivo que carga ventana con todos los datos del factor asociado a marca y modelo para posteriormente modificarlos en base de datos.
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
$rut_tercero=$_GET["rut_terc"];
$nombre_tercero=$_GET["nom_terc"];

$sql="SELECT * FROM php_maeabo WHERE codsin=".$codsin." and folio_exp=".$folio_exp;
foreach($conn_db->query($sql) as $row){
	$ramo=$row['RAMO_ID'];
	$rut_abogado=$row['ABOG_NUMRUT']."-".$row['ABOG_DVRUT'];
}
$sql2="SELECT * FROM php_maeabo_dmd WHERE codsin=".$codsin." and folio_exp=".$folio_exp;
foreach($conn_db->query($sql2) as $row2){
	$mail=trim($row2['TERC_EMAIL']);
	$fono=trim($row2['TERC_FONO']);
	$tribunal=trim($row2['DMD_TRIBUNAL']);
	$causa=trim($row2['DMD_CAUSA']);
	$fec_demanda=trim($row2['DMD_FECHA_DMD']);
	$fec_asignacion=trim($row2['DMD_FECHA_ASIGNA']);
	$tip_acuerdo=trim($row2['DMD_TIPO_ACUERDO']);
	$monto_dem=trim($row2['DMD_MTO_DEMANDA']);
	$monto_pag=trim($row2['DMD_MTO_PAGADO']);
	$honorarios=trim($row2['DMD_HONORARIO']);
	$gastos=trim($row2['DMD_GASTOS']);
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
var fono=$("#fono").val();
var correo=$("#mail").val();
var tribunal=$("#tribunal").val();
var causa=$("#causa").val();
var fec_dem=$("#fec_dem").val();
var tipo_acu=$("#tip_acu").val();
var fec_asign=$("#fec_asign").val();
var monto_dem=$("#monto_dem").val();
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
var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
if (!regex.test(correo.trim()) && correo!="") {
	jAlert("Ingrese correo en formato micorreo@micorreo.com");
	$('#mail').focus();
	return false;
}
if(fec_dem == ""){
	fec_dem="01/01/1970";
}else{
	if(validarFormatoFecha(fec_dem)){
	      if(existeFecha(fec_dem)){
	           
	      }else{
	            jAlert("La fecha de demanda introducida no existe.");
	            $("#fec_dem").val("");
	      		$("#fec_dem").focus();
	      		return false;
	      }
	}else{
	      jAlert("El formato de la fecha de demanda es incorrecto.");
	      $("#fec_dem").val("");
	      $("#fec_dem").focus();
	      return false;
	}
}
if(fec_asign == ""){
	fec_asign="01/01/1970";
}else{
	if(validarFormatoFecha(fec_asign)){
	      if(existeFecha(fec_asign)){
	           
	      }else{
	            jAlert("La fecha de asignación introducida no existe.");
	            $("#fec_asign").val("");
	      		$("#fec_asign").focus();
	      		return false;
	      }
	}else{
	      jAlert("El formato de la fecha de asignación es incorrecto.");
	      $("#fec_asign").val("");
	      $("#fec_asign").focus();
	      return false;
	}
}
if(monto_dem==""){
	monto_dem=0;
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
		url		: "funciones/grabar_demanda.php",
		async	: true,
		data	: {
		ramo 	: ramo,
		abogado : abogado,
		fono    : fono,
		correo  : correo,
		tribunal: tribunal,
		causa   : causa,
		fec_dem : fec_dem,
		tipo_acu: tipo_acu,
		fec_asign: fec_asign,
		m_dem   : monto_dem,
		m_pag   : monto_pag,
		hono    : honorarios,
		gastos  : gastos,
		obs     : obs,
		codsin  : sini,
		nexp    : exp
		},

		success: function(r){
			var res=r.split("*");
			console.log(res[1]);
			if(res[0]=="OK"){
				//$("#form")[0].reset();
				alert(res[1]);
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
			
			<ul><li><a href="#frame" style="font-size: 13px;">Demandas</a></li></ul>
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
				<tr><td colspan="3">DATOS DEMANDANTE</td></tr>
	            <tr><hr style="margin-right:50px"></tr>	
	            <tr>
	            <td><b>Nombre</b></td><td><b>:</b></td><td><span style="margin-left:10px;font-size:12px"><?php echo $nombre_tercero; ?></span></td><td><b>Fono</b></td><td><b>:</b></td><td style="width: 350px;"><input type="text" id="fono" style="margin-left:10px" value="<?php echo $fono; ?>" /></td>
	            </tr>
	            <tr>
	            <td><b>Mail</b></td><td><b>:</b></td><td><input type="text" id="mail" style="margin-left:10px" value="<?php echo $mail; ?>" /></td><td><b>Rut</b></td><td><b>:</b></td><td style="width: 350px;"><span style="margin-left:10px;font-size:12px"><?php echo $rut_tercero; ?></span></td>
	            </tr>
	            <tr>
	            <td style="padding-top:15px"><b>Tribunal</b></td><td style="padding-top:15px"><b>:</b></td><td style="padding-top:15px"><input type="text" id="tribunal" style="margin-left:10px" value="<?php echo $tribunal; ?>" /></td><td style="padding-top:15px"><b>Causa/Rol</b></td><td style="padding-top:15px"><b>:</b></td><td style="width: 350px; padding-top:15px"><input type="text" id="causa" style="margin-left:10px" value="<?php echo $causa; ?>" /></td>
	            </tr>
	            <tr>
	            <td style="padding-top:15px;width:200px"><b>Fecha demanda</b></td><td style="padding-top:15px"><b>:</b></td><td style="padding-top:15px"><input type="text" id="fec_dem" style="margin-left:10px" value="<?php echo date('d/m/Y',strtotime($fec_demanda)); ?>" /></td>
	            <td style="padding-top:15px"><b>Tipo acuerdo</b></td><td style="padding-top:15px"><b>:</b></td><td style="padding-top:15px">
	            	<select id="tip_acu" style="width: 160px;margin-left:10px">
            		<option value="0"></option>
            		<?php
            		if($tip_acuerdo==1){
            			echo '<option value="1" selected>AVENIMIENTO</option><option value="2">SENTENCIA</option>';
            		}elseif($tip_acuerdo==2){
            			echo '<option value="1">AVENIMIENTO</option><option value="2" selected>SENTENCIA</option>';
            		}else{
            			echo '<option value="1">AVENIMIENTO</option><option value="2">SENTENCIA</option>';
            		}
            		?>
	            	</select>
	            </td>
	            </tr>
	            <tr>
	            <td style="width:200px"><b>Fecha asignación</b></td><td><b>:</b></td><td><input type="text" id="fec_asign" style="margin-left:10px" value="<?php echo date('d/m/Y',strtotime($fec_asignacion)); ?>" /></td>
	            </tr>
	            <tr>
	            <td style="width:200px;padding-top:15px;"><b>Monto demanda</b></td><td><b>:</b></td><td style="padding-top:15px;width: 250px;"><input type="number" id="monto_dem" style="margin-left:10px" value="<?php echo $monto_dem; ?>" /></td>
	            </td>
	            <td style="padding-top:15px;width:200px"><b>Monto pagado</b></td><td><b>:</b></td><td style="padding-top:15px;width: 250px;"><input type="number" id="monto_pag" style="margin-left:10px" value="<?php echo $monto_pag; ?>" /></td>
	            </tr>
	            <tr>
	            <td style="width:200px"><b>Honorarios</b></td><td><b>:</b></td><td style="width: 250px;"><input type="number" id="hono" style="margin-left:10px" value="<?php echo $honorarios; ?>" /></td>
	            </td>
	            <td style="width:200px"><b>Gastos</b></td><td><b>:</b></td><td style="width: 250px;"><input type="number" id="gastos" style="margin-left:10px" value="<?php echo $gastos; ?>" /></td>
	            </tr>
	            <tr>
	            <td style="width:200px"><b>Observaciones</b></td><td><b>:</b></td><td style="width: 350px;">
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