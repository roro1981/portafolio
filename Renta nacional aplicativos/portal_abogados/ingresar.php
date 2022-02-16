<html>
<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
include("base.adj");
include("funciones.adj");
include("funciones_cobranza.adj");
include("mailer.adj");
/**
 * @abstract Archivo que carga ventana para ingresar nuevo expediente asociada al siniestro ingresado.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */

$conn_db  = TraeCon("siniestro");
$conn_db2 = TraeCon("gestion");
$conn     = TraeCon("produccion");

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
<script type="text/javascript" src="js/index.js"></script>
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
var Fn = {
	// Valida el rut con su cadena completa "XXXXXXXX-X"
	validaRut : function (rutCompleto) {
		if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
			return false;
		var tmp 	= rutCompleto.split('-');
		var digv	= tmp[1]; 
		var rut 	= tmp[0];
		if ( digv == 'K' ) digv = 'k' ;
		return (Fn.dv(rut) == digv );
	},
	dv : function(T){
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
	}
}
$(function(){
	$("#container").tabs();
	$("#d_Cargando").css('display', 'none');
});
//graba datos de nuevo expediente asociado al siniestro ingresado
$(document).on('click','#grabar',function(e){      
var gestion=$("#gestion").val();
var abogado=$("#abogado").val();
var rut_terc=$("#rut_terc").val();
var nom_terc=$("#nom_terc").val();
var ramo=$("#ramo").val();

if(gestion==0){
    jAlert("Seleccione tipo de gestión");
    return false;
}
if(abogado==0){
    jAlert("Seleccione abogado");
    return false;
}
if(rut_terc==""){
    jAlert("Ingrese rut de tercero");
    return false;
}
if(!Fn.validaRut(rut_terc)){
    jAlert("Rut inválido");
    return false;
}
if(nom_terc==""){
    jAlert("Ingrese nombre de tercero");
    return false;
}
if(ramo==0){
    jAlert("Seleccione ramo");
    return false;
}

	$.ajax({
		type	: "POST",
		url		: "funciones/grabar_expediente.php",
		async	: true,
		data	: {
		gestion	: gestion,
		abogado : abogado,
		rut_terc: rut_terc,
		nom_terc: nom_terc,
		num_sin : '<?php echo $_GET["sini"]; ?>',
		ramo_id : ramo
		},

		success: function(r){
			var res=r.split("*");
			if(res[0]=="OK"){
				jAlert(res[1]);
				//$('#consultar').trigger('click');
				cierraFancy();
			}else if(res[0]=="existe"){
				jAlert(res[1]);
				return false;
			}else{
				jAlert(res[1]);
			}
		}
	});
				
});	
function cierraFancy(){
	window.parent.$.fancybox.close();
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
	    font-size:11px !important;
	    font-weight:bold;
	    height: 20px;
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
		width: 550px;
		height: 230px;
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
		color: blue;
		font-weight: bold;
		font-size: 12px !important;		
	}
	
</style>
</head>

<body>
	<div id="container" height="">
			<input type="hidden" id="rut_cl" />
			<input type="hidden" id="dv_cl" />
			<ul><li><a href="#frame" style="font-size: 13px;">Nuevo expediente</a></li></ul>
			<div id="d_Cargando" style="display: block; text-align: center; font-size: 12px; position:absolute; float: inherit; z-index:5; top: 170px; left: 250px;"><img src="<?=$URL_HOME?>/imagenes/spinner.gif"><br/>Cargando...</div>
			<div id="frame" style="width:100%">
			
				<table border="0" cellspacing="3" style="margin-left:50px;margin-top:-10px">
				<tr style="border:1px solid">
				<td class="label">Tipo gestion</td><td>
					<select id="gestion" style="width:200px" >
					<option value="0"></option>
					<?php
					$sql_est = "SELECT * FROM estados_php where tipo=51";
					foreach($conn_db->query($sql_est) as $row){
						echo "<option value='".$row['CODIGO']."'>".$row['DESCODIGO']."</option>";
					}
					?>
					</select>
				</td>
				</tr>
				<tr style="border:1px solid">
				<td class="label" >Abogado</td><td id="mod">
					<select id="abogado" style="width:200px">
					<option value="0"></option>
					<?php
					$sql_abs = "SELECT numrut,digrut,nombre FROM abogados2 group by numrut,digrut,nombre order by nombre";
					foreach($conn_db->query($sql_abs) as $row){
						$rut_ab=trim($row['NUMRUT']."-".$row['DIGRUT']);
						if($rut_ab != "-"){
							echo "<option value='".$rut_ab."'>".$row['NOMBRE']."</option>";
						}	
					}
					?>
					</select>
				</td>
				</tr>
				<tr>
				<td class="label">Rut Tercero</td><td ><input type="text" id="rut_terc" maxlenght="10" style="width:200px" /></td>
				</tr>
				<tr>
				<td class="label">Nombre Tercero</td><td><input type="text" id="nom_terc" style="width:200px" /></td>
				</tr>
				<tr>
	            <td class="label">Ramo</td><td>
	            	<select id="ramo" style="width: 200px;">
	            		<option value="0"></option>
	            		<?php
						$sql_ram = "SELECT * FROM ramosuper where cia_id=1 order by ramo_descrip";
						foreach($conn->query($sql_ram) as $row){
								echo "<option value='".$row['RAMO_ID']."'>".$row['RAMO_DESCRIP']."</option>";
						}
						?>
	            	</select>
	            </td>
	            </tr>
				<tr>
				<td colspan="2" style="text-align:center;">
					<button title="Guardar" id="grabar" style="margin-top:10px">Grabar expediente</button> 
				</td>
				</tr>
				</table>
				
			</div>
		
	</div>
</body>
</html>
<?php is_logged(); 
$conn_db = null;

?>