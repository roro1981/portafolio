<?php

/**
 * @abstract archivo carga menu inicial de portal abogados
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */

	error_reporting(E_ALL);
	include("base.adj");
	include("funciones.adj");
	include("funciones_cobranza.adj");
	noCache();
	echo getHtmlInicio("Intranet Corporativa - Renta Nacional Compañia de Seguros");
	is_logged();
	try {
		$conn_sisgen = TraeCon("sisgen");
		$conn_db = TraeCon("siniestro");
		$conn=TraeCon("produccion");
		$sis_id = $_GET['sis_id'];
		$prog_id = $_GET['prog_id'];
		foreach($conn_sisgen->query("select sis_descr from sistema where sis_id='$sis_id'") as $row_sistema){
			$sis_descr = $row_sistema['SIS_DESCR'];
		}
	}

	catch(PDOException $e){ 
		print "<p>Error: No puede conectarse con la base de datos.</p>\n";
		print "<p>Error: ".$e->getMessage()."</p>\n";
	}
	$perfil = "";
	$user_log = $_SESSION['Usuario'];
	$perfil_aux = nombrePerfilBdCli($conn_sisgen, $user_log);
	if($perfil_aux != ""){
		$perfil = $perfil_aux;
	}
?>
<link rel="stylesheet" type='text/css' href="<?=$URL_HOME?>/librerias/nightly/jquery.qtip.min.css"/>
<link rel="stylesheet" type='text/css' href="<?=$URL_HOME?>/librerias/jquery.alerts/jquery.alerts.css">
<link rel="stylesheet" type='text/css' href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox-buttons.css">
<link rel="stylesheet" type='text/css' href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox-thumbs.css">
<link rel="stylesheet" type='text/css' href="<?=$URL_HOME?>/librerias/fancybox/css/jquery.fancybox.css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script src="<?=$URL_HOME?>/librerias/jquery.alerts/jquery.alerts.js" type='text/javascript'></script>
<script src="<?=$URL_HOME?>/librerias/nightly/jquery.qtip.min.js" type='text/javascript'></script>
<script src="<?=$URL_HOME?>/js/validaciones.js" type='text/javascript'></script>
<script src="<?=$URL_HOME?>/librerias/jquery-ui-1.8.17/development-bundle/ui/jquery-ui-1.8.17.custom.js" type='text/javascript'></script>
<script src="<?=$URL_HOME?>/librerias/jquery.data-table/jquery.dataTables.js" type='text/javascript'></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox.js"></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?=$URL_HOME?>/librerias/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?=$URL_HOME?>/lib_prop/upd_docs.js"></script>
<script type="text/javascript" src="<?=$URL_HOME?>/librerias/jquery-ui-1.8.17/development-bundle/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		//$("img[title]").qtip();
		$("#d_Cargando").css('display', 'none');
	});
	$(document).on('click','#btnIngresar',function(e){
		$("#menu").hide();
		$("#ingreso").show();
	});
	$(document).on('click','#btnInforme',function(e){
		$("#menu").hide();
		$("#informes").show();
	});
	function volver(num){
		if(num==1){
			$("#menu").show();
			$("#num_sini").val("");
			$("#ingreso").hide();
		}
		if(num==2){
			$("#ingreso").show();
			$("#modificar_1").hide();
		}
		if(num==3){
			$("#menu").show();
			$("#fec_desde").val("");
			$("#fec_hasta").val("");
			$("#abogado").val(0);
			$("#tipo").val(0);
			$("#informes").hide();
		}
	}
$(document).on('click','#consultar',function(e){
		var sin=$("#num_sini").val();
		if(sin=="" || sin==0){
			jAlert("Ingrese numero de siniestro");
			return false;
		}
		
	$.ajax({
			type	: "POST",
			url		: "funciones/trae_datos.php",
			async	: true,
			data	: {
			id_sin 	: sin
			},

			success: function(r){
				console.log(r);
				var res=r.split("*");
				if(res[0]=="OK"){
					$("#sini").text(res[1]);
					$("#fec_sini").text(res[2]);
					$("#fec_denu").text(res[3]);
					$("#aseg").text(res[4]);
					$("#liqui").text(res[5]);
					$("#ramo").val(res[6]);
					$("#menu").hide();
					$("#ingreso").hide();
					$("#modificar_1").show();
					Trae_tabla_resumen(res[1]);
				}else{
					jAlert(res[1]);
					return false;
				}
			}
	});
		
});
	$(document).on('click','.caso2',function(e){
		var separa=$(this).attr("id").split("*");
		var codsin=separa[0];
		var nom_aseg=separa[1];
		var nom_liq=separa[2];
		var ramo=separa[3];
		var abog_rut=separa[4];
		var abog_dv=separa[5];
		var fec_asign=separa[6];
		var fec_sini=separa[7];
		var fec_denu=separa[8];
		var folio=separa[9];
		var gestion=separa[10];
		var rut_ter=separa[11];
		var nom_ter=separa[12];

		if(gestion==1){
			var open = 'recupero.php?sini='+codsin+"&aseg="+nom_aseg+"&liq="+nom_liq+"&ramo="+ramo+"&rut_ab="+abog_rut+"&dv_ab="+abog_dv+"&fec_asign="+fec_asign+"&fec_sini="+fec_sini+"&fec_denu="+fec_denu+"&folio_exp="+folio+"&rut_terc="+rut_ter+"&nom_terc="+nom_ter;
			var ancho=850;
			var alto=650;
		}
		if(gestion==2){
			var open = 'demanda.php?sini='+codsin+"&aseg="+nom_aseg+"&liq="+nom_liq+"&ramo="+ramo+"&rut_ab="+abog_rut+"&dv_ab="+abog_dv+"&fec_asign="+fec_asign+"&fec_sini="+fec_sini+"&fec_denu="+fec_denu+"&folio_exp="+folio+"&rut_terc="+rut_ter+"&nom_terc="+nom_ter;
			var ancho=850;
			var alto=500;
		}
		if(gestion==3){
			var open = 'intercomp.php?sini='+codsin+"&aseg="+nom_aseg+"&liq="+nom_liq+"&ramo="+ramo+"&rut_ab="+abog_rut+"&dv_ab="+abog_dv+"&fec_asign="+fec_asign+"&fec_sini="+fec_sini+"&fec_denu="+fec_denu+"&folio_exp="+folio;
			var ancho=850;
			var alto=450;
		}	
		
	    $.fancybox({
	        href          : open,
	        transitionIn  : 'none',
	        transitionOut : 'none',
	        type          : 'iframe',
	        fitToView     : true,
	        width         : ancho,
	        height        : alto,
	        autoSize      : false,
	        closeClick    : false,
	        openEffect    : 'elastic',
	        closeEffect   : 'none',
	        padding		  : 0,
	        scrolling	  : 'no',
	        helpers     : { 
            overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
       		},
	        'beforeClose':function () {
               Trae_tabla_resumen(codsin);
           }
	    });    
	});
	function Fancybox_iframe(folio){
		if (folio == "nuevo"){
			var sin=$("#num_sini").val();
			
			var open = 'ingresar.php?sini='+sin;
			var ancho=550;
			var largo=230;
		}
		
	    $.fancybox({
	        href          : open,
	        transitionIn  : 'none',
	        transitionOut : 'none',
	        type          : 'iframe',
	        fitToView     : true,
	        width         : ancho,
	        height        : largo,
	        autoSize      : false,
	        closeClick    : false,
	        openEffect    : 'elastic',
	        closeEffect   : 'none',
	        padding		  : 0,
	        scrolling	  : 'no',
	        helpers     : { 
            overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
       		},
	        'beforeClose':function () {
	        	Trae_tabla_resumen(sin);
           }
	    });    
	}

$(document).on('click','#genera',function(e){
	var fec_desde=$("#fec_desde").val();
	var fec_hasta=$("#fec_hasta").val();
	var tipo_rep=$("#tipo").val();
	var abogado=$("#abogado").val();
	if(fec_desde == ""){
	}else{
		if(validarFormatoFecha(fec_desde)){
		      if(existeFecha(fec_desde)){
		           
		      }else{
		            jAlert("La fecha desde introducida no existe.");
		            $("#fec_desde").val("");
		      		$("#fec_desde").focus();
		      		return false;
		      }
		}else{
		      jAlert("El formato de la fecha desde es incorrecto.");
		      $("#fec_desde").val("");
		      $("#fec_desde").focus();
		      return false;
		}
	}
	if(fec_hasta == ""){
	}else{
		if(validarFormatoFecha(fec_hasta)){
		      if(existeFecha(fec_hasta)){
		           
		      }else{
		            jAlert("La fecha hasta introducida no existe.");
		            $("#fec_hasta").val("");
		      		$("#fec_hasta").focus();
		      		return false;
		      }
		}else{
		      jAlert("El formato de la fecha hasta es incorrecto.");
		      $("#fec_hasta").val("");
		      $("#fec_hasta").focus();
		      return false;
		}
	}
	var fec_d=fec_desde.split("/");
	var fec_h=fec_hasta.split("/");
	var f_desde=fec_d[2]+"/"+fec_d[1]+"/"+fec_d[0];
	var f_hasta=fec_h[2]+"/"+fec_h[1]+"/"+fec_h[0];
	if(Date.parse(f_desde) > Date.parse(f_hasta)){
	    jAlert("Fecha desde no puede ser mayor a fecha hasta");
	    return false;
	}
	$.ajax({
		type	: "GET",
		url		: "funciones/exportar_excel.php",
		async	: true,
		data	: {
		  fecha_desde: fec_desde,
		  fecha_hasta: fec_hasta,
		  abog       : abogado,
		  tipo       : tipo_rep
		},
		success: function(r){
			var ultima = r.substr(r.length - 9);
			if(ultima=="REGISTROS"){
				jAlert("NO HAY REGISTROS");
				return false;
			}
			window.open("funciones/exportar_excel.php?fecha_desde="+fec_desde+"&fecha_hasta="+fec_hasta+"&abog="+abogado+"&tipo="+tipo_rep);
		}
	});
    
       
});	
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
	.btnfiltros img {
		border: none;
	}

	.btnfiltros {
		text-align: right;
	}

	#dtodos {
		text-align: right;
		padding: 0;
		margin: 0;
		padding-top: 11px;
	}

	.dataTables_length {
		text-align: left;
	}

	.none {
		display: none;
	}

	.cargando {
		display: none;
		text-align: center !important;
	}

	.d_filtros {
		width: 80%;
		display: inline-block;
		float: left;
		text-align: left;
		margin: 0 0 0 5px;
	}

	.colx2 label:nth-child(3) {
		margin-left: 25px;
	}

	.colx2 label {
		width: 22% !important;
	}

	.ui-autocomplete-input .ui-widget .ui-widget-content .ui-corner-left {
		text-align: left !important;
		
	}

	.btn_info {
		width	: 56px;
		height	: 56px;
		cursor	: pointer; 
		background-color:transparent;
	}

	button {
		    -moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
		    -webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
		    box-shadow:inset 0px 1px 0px 0px #ffffff;
		    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #f1f1f1), color-stop(1, #cccccc) );
		    background:-moz-linear-gradient( center top, #f1f1f1 5%, #cccccc 100% );
		    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f1f1f1', endColorstr='#cccccc');
		    background-color:#f1f1f1;
		    padding-left: 0px;
		    padding-right: 0px;
		    -moz-border-radius:3px;
		    -webkit-border-radius:3px;
		    border-radius:3px;
		    border:1px solid #999999;
		    display:inline-block;
		    color:#666666;
		    font-family:arial;
		    font-size:11px !important;
		    font-weight:bold;
		    height: 30px;
		    text-decoration:none;
		}

	button:hover {
	    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #f1f1f1) );
	    background:-moz-linear-gradient( center top, #cccccc 5%, #f1f1f1 100% );
	    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#cccccc', endColorstr='#f1f1f1');
	    background-color:#cccccc;
	}

	button:active {
	    position:relative;
	    top:1px;
	}

	button:active disabled{
	    position:relative;
	}
	.dvMenu{
		border: 1px solid #a6c9e2;
		border-radius:10px;
	  	top:50%;
		left:50%;
		background: linear-gradient( #fcfdfd,#e8f3ff);
		margin: 0px auto;
		width:300px;
		text-align: center;
	}
	.btnMenu {
	    margin: 10px 0 10px 0;
	    width: 200px;
	    height: 40px;
	}
	.menulateral {
	    display: inline-block;
	    height: auto;
	    left: auto;
	    margin: 0;
	    padding: 0;
	    position: fixed;
	    right: 232px;
	    top: 122px;
	    width: 3em;
	    /* border: 1px solid; */
}
.eti{
	width:300px	;
}
</style> 
</head>
<body>
<div id="d_imgs_tabla" style="display:none;"></div>
<div id="d_Principal" class="container_12" style="font-size: 13px !important;">
	<div class="grid_12" id="d_Sistema"><?php echo GetHeader($sis_descr,$_SESSION['Usuario_Nombre'],$prog_id); ?></div>
		<div class="grid_12" id="d_Filtro_02" style="display: inline;">
			<br>
			<div id="dialog-form" title="" style="display: none;">
				<form>
					<div id="d_Confirma_insp" style="display: none;"></div>
				</form>
			</div> 
			<div id="d_Info" style='display: inline;'>
				<fieldset style='width:920px; margin: 0 -55;height:450px'>
				<legend id="le_Titulo_2" align="left" style="text-align:center; padding-bottom: 20px;">Portal Abogados</legend>
					<table cellpadding='0' cellspacing='0' style='display: inline;'>
						<tr id="menu" style="">
							<td style='width: 400px;'>
								<table style="display: inline;" cellpadding="0" cellspacing="0">
									<tr>
										<td style='width: 700px; text-align: center;'>
											<div id="d_Lista_Plns" align="center">
												<div class="dvMenu" id="dvMenu">
						                        	<button class="btnMenu" id="btnIngresar">Ingresar/Modificar caso</button>
						            				<button class="btnMenu" id="btnInforme">Informe</button>
						     					</div>
											</div>
											<div id="d_Cargando" style="display: inline;"><img src="<?=$URL_HOME?>/imagenes/spinner.gif"> CARGANDO...</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="ingreso" style="display:none">
							<td style="width: 400px;">
							<div class="menulateral">
	                        	<ul class="ulbtn">
			                        <li>
			                        <button id="b_Volver" onclick="volver(1);" oldtitle="Volver" aria-describedby="ui-tooltip-3"><img src="http://dti20.rentanac.cl/imagenes/f_volver_24x24.png" alt="P"></button>
			                        </li>
	                        </div>
                            <div id="d_Menu_opciones" style="display: inline;">
                                <table style="display: inline;">
                                	<tbody>
                                	<tr>
                                	<td style="width: 120px; height: 30px;"><label for="r_Menu_siniestro" class="labhand">Ingrese siniestro</label></td>
                                	<td style="font-size: 15px; width: 15px;height: 30px;"><b>:</b></td><td style="font-size: 15px;"><input type="text" style="width: 150px;" id="num_sini" maxlength="6"><button id="consultar" style="margin-left:10px"><img src="http://dti20.rentanac.cl/imagenes/buscar2_24x24.png" ></button>
                                	</td>
                                	</tr>
                                </tbody></table>
                              

                            </div>
                        </td>
						</tr>
						<tr id="informes" style="display:none">
							<td style="width: 400px;">
							<div class="menulateral">
	                        	<ul class="ulbtn">
			                        <li>
			                        <button id="b_Volver" onclick="volver(3);" oldtitle="Volver" aria-describedby="ui-tooltip-3"><img src="http://dti20.rentanac.cl/imagenes/f_volver_24x24.png" alt="P"></button>
			                        </li>
	                        </div>
                            <div id="d_Menu_opciones" style="display: inline;">
                                <table style="display: inline;">
                                	<tbody>
                                	<tr><td></td><td></td><td style="font-size:15pt;font-weight:bold;">Informes</td></tr>
                                	<tr><td>  </td></tr>
                                	<tr>
                                	<td style="width: 100px; height: 30px;">Fecha desde</td><td style="font-size: 15px; width: 15px;height: 30px;"><b>:</b></td>
                                	<td style="font-size: 15px;"><input type="text" style="width: 100px;" id="fec_desde"></td>
                                	</tr>
                                	<tr>
                                	<td style="width: 100px; height: 30px;">Fecha hasta</td><td style="font-size: 15px; width: 15px;height: 30px;"><b>:</b></td>
                                	<td style="font-size: 15px;"><input type="text" style="width: 100px;" id="fec_hasta"></td>
                                	</tr>
                                	<tr>
                                		<td style="width: 100px; height: 30px;">Tipo informe</td>
                                			<td style="font-size: 15px; width: 15px;height: 30px;"><b>:</b></td>
                                			<td style="font-size: 15px;">
											<select id="tipo" style="width:150px" >
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
                                	<tr>
                                		<td style="width: 100px; height: 30px;">Abogado</td>
                                			<td style="font-size: 15px; width: 15px;height: 30px;"><b>:</b></td>
                                			<td style="font-size: 15px;">
											<select id="abogado" style="width:200px" >
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
                                		<td colspan="3"><button id="genera" style="width:120px;margin-left:90px">Generar reporte</button></td></td>
                                	</tr>
                                </tbody></table>
                              

                            </div>
                        </td>
						</tr>
						<tr id="modificar_1" style="display:none">
							<td style="width: 100%;">
							<div class="menulateral">
	                        	<ul class="ulbtn">
			                        <li>
			                        <button id="b_Volver" onclick="volver(2);" oldtitle="Volver" aria-describedby="ui-tooltip-3"><img src="http://dti20.rentanac.cl/imagenes/f_volver_24x24.png" alt="P"></button>
			                        </li>
	                        </div>
                            <div id="d_Menu_opciones" style="display: inline;margin-left:50px">
                               <table style="display: inline;">    
            					<tbody>
					            <tr>
					            <td><b>Siniestro</b></td><td><b>:</b></td><td style="width: 750px;"><span id="sini" style="margin-left:10px"></span></td><td style="width: 150px;"><b>Fecha siniestro</b></td><td><b>:</b></td><td style="width: 350px;"><span id="fec_sini" style="margin-left:10px"></span></td>
					            </tr>
					            <tr>
					            <td><b>Asegurado</b></td><td><b>:</b></td><td style="width: 750px;"><span id="aseg" style="margin-left:10px"></span></td><td style="width: 150px;"><b>Fecha denuncio</b></td><td><b>:</b></td><td style="width: 350px;"><span id="fec_denu" style="margin-left:10px"></span></td>
					            </tr>
       							<tr>
					            <td><b>Liquidador</b></td><td><b>:</b></td><td style="width: 750px;"><span id="liqui" style="margin-left:10px"></span></td>
					            </tr>
					   
					            <tr>
					          	<div id="tbl_resumen" align="center" style="position:fixed;margin-left:130px;margin-top:100px">
					            </div>
					            </tr>
 								</tbody>
 								</table>
 								<br><br>
 								 <button onClick="Fancybox_iframe('nuevo')"; style="width:150px;margin-left:50px">Ingresar expediente</button></td>
                            </div>

                        </td>
						</tr>

					</table>
				</fieldset>
			</div>
		</div>
	</div>
<?php echo GetHtml2(); $conn_sisgen = null; $conn= null; ?>
</div>