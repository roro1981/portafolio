<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
// $seguro=1 genera poliza vehiculo
// $seguro=2 genera poliza incendio
ob_start();

function poliza_pdf($arrDatos,$seguro){
	
?>
<style type="text/css">
        
        h3{
            /*float:left;*/
           margin-right: 90px;
           text-align: center;
           font-weight: normal;
        }
        #cabecera img{
        	margin-top: 20px;
            width: 200px;
            height:55px;
            float:right;
        }
        .etiqueta_der{
        	font-weight: bold;
        	margin-left:20px;
        	font-size: 12px;
        }
        .etiqueta_izq{
        	font-weight: bold;
        	font-size: 12px;
        }
        .div_izq{
				border:1px solid #C6C6C6;
				height:12px;
				width:405px;
				background-color:#EEEEEE;
				font-size: 12px;
			}
		.div_der{
				border:1px solid #C6C6C6;
				margin-left:20px;
				height:12px;
				width:300px;
				background-color:#EEEEEE;
				font-size: 12px;
		}
		b{
			font-size:13px;
		}
		p{
			font-size:13px;
			margin-left:3px;
		
			font-family: Times; 
		}
        </style>

<page style="font-size: 12pt;">
  <?php if($seguro==1){ ?>
    <div id="cabecera" >
        <img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/imagenes/logo_renta_229x49.png'; ?>" />
        <h3 style="margin-bottom:0px">CARÁTULA UNIFORME PARA PÓLIZA DE <br>SEGURO DE <strong>VEHÍCULO</strong>/<br>CERTIFICADO DE COBERTURA</h3>
    </div>
    <div id="contenido" style="margin-top:15px;">
    	<table>
					
			<tr>
			<td >
					<div class='etiqueta_izq' ><strong>CÓDIGO CMF DE LA POLIZA</strong></div>
					<div class='div_izq' id="cod_poliza"><span><?php echo $arrDatos['cod_poliza']; ?></span></div>
				</td>
				<td>
				<div class='etiqueta_der'>PÓLIZA N°</div>
					<div class='div_der' id="num_poliza"><span><?php echo $arrDatos['num_poliza']; ?></span></div>
				</td>
			</tr>
			
			<tr>
			<td>
					<div style="margin-top:-48px" class='etiqueta_izq'><strong>CONTRATANTE (SI ES DISTINTO DEL ASEGURADO)</strong></div>
					<div class='div_izq' id="cont"><span><?php echo $arrDatos['contratante']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-48px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_cont"><span><?php echo $arrDatos['rut_contratante']; ?></span></div>
				</td>
			</tr>

			<tr><td>
			<div style="margin-top:-60px" class='etiqueta_izq'><strong>ASEGURADO</strong></div>
					<div class='div_izq' id="aseg"><span><?php echo $arrDatos['asegurado']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-60px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_aseg"><span><?php echo $arrDatos['rut_asegurado']; ?></span></div>
				</td>
			</tr>
			
			<tr><td>
			<div style="margin-top:-25px" class='etiqueta_izq'><strong>TIPO DE VEHÍCULO</strong></div>
					<div class='div_izq' id="tip_veh"><span><?php echo $arrDatos['tipo_vehiculo']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-25px" class='etiqueta_der'>Marca / Modelo</div>
					<div class='div_der' id="marca_modelo_veh"><span><?php echo $arrDatos['marca_modelo']; ?></span></div>
				</td>
			</tr>

			<tr><td>
			<div style="margin-top:-22px;margin-left:40px" class='etiqueta_der'><strong>Patente</strong></div>
					<div style="margin-left:40px;width:170px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="pat"><span style="font-size:12px"><?php echo $arrDatos['patente']; ?></span></div>
					<div style="margin-top:-35px;margin-left:235px" class='etiqueta_der'><strong>Año</strong></div>
					<div style="margin-left:235px;width:170px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="anio"><span style="font-size:12px"><?php echo $arrDatos['anio']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-22px" class='etiqueta_der'>VIN</div>
					<div class='div_der' id="vin"><span><?php echo $arrDatos['vin']; ?></span></div>
				</td>
			</tr>		
		</table>
		<label class="etiqueta_izq" style="margin-top:2px">TIPO DE RIESGO ASEGURADO</label><br>
  		<!--<input type="checkbox" style="margin-top:-4px" name="pl_seg_dp" value="">-->
  		<img src="img/<?php if($arrDatos['pl_seg_dp']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Póliza de seguro de daños propios</label><br>
  		<!--<input type="checkbox" style="margin-top:-4px" name="pl_seg_dt" value="">--> 
  		<img src="img/<?php if($arrDatos['pl_seg_dt']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-3px">Póliza de seguro de daños a terceros</label><br>
  		<!--<input type="checkbox" style="margin-bottom:0px;margin-top:-4px" name="pl_seg_dpt" value="">--> 
  		<img src="img/<?php if($arrDatos['pl_seg_dpt']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-3px">Póliza de seguro de daños propios y de terceros</label><br>
  		
  		<div style="margin-top:1px;border-top:1px"></div>

  		<table style="margin-top:-19px;">
  		<tr>
  			<td style="padding-right:80px;">
  				<label class="etiqueta_izq">PÓLIZA</label>
  			</td>
  			<td style="padding-right:80px">
  				<label class="etiqueta_izq">VIGENCIA</label>
  			</td>
  			<td>
  				<label class="etiqueta_izq">RENOVACIÓN AUTOMÁTICA</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['pl_ind']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Individual</label><br>
  				<!--<input type="checkbox" style="margin-top:-5px" name="pl_ind" value=""> <label style="font-size:12px">Individual</label>-->
  			</td>
  			<td style="padding-right:80px">
  				<div style="font-size:12px;margin-top:-5px;width:80px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="vig_ini"><?php echo $arrDatos['vig_inicio']; ?></div><div style="font-size:12px;margin-left:85px;margin-top:-15px">Inicio</div>
  			</td>
  			<td style="padding-top:-3px">
  			<img src="img/<?php if($arrDatos['ra_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label><br>
  				<!--<input type="checkbox" style="margin-top:-5px" name="ra_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-6px">
  			<img src="img/<?php if($arrDatos['pl_col']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Colectiva</label><br>
  				<!--<input type="checkbox" style="margin-top:-7px" name="pl_col" value=""> <label style="font-size:12px">Colectiva</label>-->
  			</td>
  			<td style="padding-right:80px">
  				<div style="font-size:12px;margin-top:-7px;width:80px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="vig_term"><?php echo $arrDatos['vig_termino']; ?></div><div style="font-size:12px;margin-left:85px;margin-top:-15px">Término</div>
  			</td>
  			<td style="padding-top:-6px">
  				<img src="img/<?php if($arrDatos['ra_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label><br>
  				<!--<input type="checkbox" style="margin-top:-7px" name="ra_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  		</tr>
  		</table>
  		
  		<div style="margin-top:-2px;border-top:1px"></div>

  			<div style="font-size:12px;margin-top:-15px"><strong>PRIMA</strong> Monto</div>
			<div style="font-size:12px;margin-top:-5px;width:180px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="monto_prima"><span><?php echo $arrDatos['monto_prima']; ?><</span></div>

		<table style="margin-top:-4px;">
  		<tr >
  			<td style="padding-right:80px;">
  				<label class="etiqueta_izq">MONEDA</label>
  			</td>
  			<td style="padding-right:80px">
  				<label class="etiqueta_izq">PERÍODO DE PAGO</label>
  			</td>
  			<td style="padding-right:50px">
  				<label class="etiqueta_izq">CONDICIONES</label>
  			</td>
  			<td>
  				<label class="etiqueta_izq">COMISIÓN TOTAL CORREDOR</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['moneda_uf']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">UF</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="moneda_uf" value=""> <label style="font-size:12px">UF</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['pp_anual']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Anual</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="pp_anual" value=""> <label style="font-size:12px">Anual</label>-->
  			</td>
  			<td style="padding-right:50px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['cond_fija']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Fija</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="cond_fija" value=""> <label style="font-size:12px">Fija</label>-->
  			</td>
  			<td>
  				<font style="font-size:12px;margin-top:-5px">Monto</font><div style="font-size:12px;margin-top:-5px;margin-left:5px;width:150px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="monto_com"><?php echo $arrDatos['monto_com']; ?></div>
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['moneda_peso']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Peso</label><br>
  				<!--<input type="checkbox" name="moneda_peso" style="margin-top:-9px" value=""> <label style="font-size:12px">Peso</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['pp_mensual']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Mensual</label><br>
  				<!--<input type="checkbox" name="pp_mensual" style="margin-top:-9px" value=""> <label style="font-size:12px">Mensual</label>-->
  			</td>
  			<td style="padding-right:50px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['cond_ajust_sc']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Ajustable Según Contrato</label><br>
  				<!--<input type="checkbox" name="cond_ajust_sc" style="margin-top:-9px" value=""> <label style="font-size:12px">Ajustable Según Contrato</label>-->
  			</td>
  			<td style="padding-top:-4px">
  			<label style="font-size:12px;margin-top:-1px">No hay comisión</label><img style="margin-left:88px;" src="img/<?php if($arrDatos['monto_com']==0 || $arrDatos['monto_com']==NULL){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> 
  				<!--<label style="font-size:12px;margin-top:-9px">No hay comisión</label> <input type="checkbox" style="margin-left:85px;margin-top:-9px" name="no_com" value=""> -->
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['moneda_otra']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otra</label><br>
  				<!--<input type="checkbox" name="moneda_otra" style="margin-top:-18px" value=""> <label style="font-size:12px">Otra</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['pp_otro']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otro</label>
  				<!--<input type="checkbox" name="pp_otro" style="margin-top:-18px" value=""> <label style="font-size:12px">Otro</label>-->
  			</td>
  			
  		</tr>
  		</table>	
  		<div style="margin-top:-4px;border-top:1px"></div>
  		<table style="margin-top:-17px">
  		<tr >
  			<td style="padding-right:15px">
  				<label class="etiqueta_izq" >TIPOS DE DAÑOS, COBERTURA Y DEDUCIBLES</label>
  			</td>
  			<td style="padding-right:20px;">
  				<label style="font-size:12px;margin-left:-1px">MONTO/VALOR COMERCIAL</label>
  			</td>
  			<td style="padding-right:30px;">
  				<label style="font-size:12px;margin-left:17px">DEDUCIBLE</label>
  			</td>
  			<td style="padding-right:20px;">
  				<label class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center">
  				<label class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-3px">
  			<img src="img/<?php if($arrDatos['dpropio']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Daños Propios</label>
  				<!--<input type="checkbox" style="margin-top:-5px" name="tdcd_dpropio" value=""> <label style="font-size:12px">Daños Propios</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_monto_com"><?php echo $arrDatos['dpropio_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_ded"><?php echo $arrDatos['dpropio_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_cg"><?php echo $arrDatos['dpropio_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_cp"><?php echo $arrDatos['dpropio_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['robo']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Robo, Hurto O Uso No Autorizado</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_robo" value=""> <label style="font-size:12px">Robo, Hurto O Uso No Autorizado</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_monto_com"><?php echo $arrDatos['robo_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_ded"><?php echo $arrDatos['robo_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_cg"><?php echo $arrDatos['robo_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_cp"><?php echo $arrDatos['robo_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['dat']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Daños A Terceros</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_dat" value=""> <label style="font-size:12px">Daños A Terceros</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_monto_com"><?php echo $arrDatos['dat_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_ded"><?php echo $arrDatos['dat_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_cg"><?php echo $arrDatos['dat_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_cp"><?php echo $arrDatos['dat_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['de']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Daño Emergente</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_de" value=""> <label style="font-size:12px">Daño Emergente</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_monto_com"><?php echo $arrDatos['de_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_ded"><?php echo $arrDatos['de_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_cg"><?php echo $arrDatos['de_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_cp"><?php echo $arrDatos['de_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['dam']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Daño Moral</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_dam" value=""> <label style="font-size:12px">Daño Moral</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_monto_com"><?php echo $arrDatos['dam_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_ded"><?php echo $arrDatos['dam_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_cg"><?php echo $arrDatos['dam_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_cp"><?php echo $arrDatos['dam_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['lc']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Lucro Cesante</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_lc" value=""> <label style="font-size:12px">Lucro Cesante</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_monto_com"><?php echo $arrDatos['lc_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_ded"><?php echo $arrDatos['lc_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_cg"><?php echo $arrDatos['lc_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_cp"><?php echo $arrDatos['lc_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['pt']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Pérdida Total</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_pt" value=""> <label style="font-size:12px">Pérdida Total</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="pt_monto_com"><?php echo $arrDatos['pt_monto_com']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="pt_ded"><?php echo $arrDatos['pt_ded']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="pt_cg"><?php echo $arrDatos['pt_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="pt_cp"><?php echo $arrDatos['pt_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px" colspan="5">
  			<img src="img/<?php if($arrDatos['cob_adic']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Esta poliza contiene otras coberturas adicionales, cuyo detalle debe ser consultado en las condiciones particulares.</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="cob_adic" value=""> <label style="font-size:12px">Esta poliza contiene otras coberturas adicionales, cuyo detalle debe ser consultado en las condiciones particulares.</label>-->
  			</td>
  		</tr>	
  		<tr>
  			<td style="padding-top:-4px" colspan="3">
  				<div style="font-size:12px;"><strong>CONDICIONES ESPECIALES DE ASEGURABILIDAD</strong></div>
  			</td>
  			<td style="padding-right:20px;padding-top:-4px">
  				<label class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center;padding-top:-4px">
  				<label class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-43px" colspan="3">
  			<img src="img/<?php if($arrDatos['ceda_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label>
  				<!--<input type="checkbox" style="margin-top:-45px" name="ceda_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-43px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="si_cg"><?php echo $arrDatos['ceda_si_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-43px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="si_cp"><?php echo $arrDatos['ceda_si_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-32px" colspan="3">
  			<img src="img/<?php if($arrDatos['ceda_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label>
  				<!--<input type="checkbox" style="margin-top:-35px" name="ceda_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-32px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="ceda_no_cg"><?php echo $arrDatos['ceda_no_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-32px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="ceda_no_cp"><?php echo $arrDatos['ceda_no_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px" colspan="3">
  				<div style="margin-top:-15px;font-size:12px;"><strong>PERÍODO DE CARENCIA</strong></div>
  			</td>
  			<td style="padding-top:-5px;padding-right:20px;">
  				<label style="margin-top:-15px;" class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="padding-top:-5px;text-align:center">
  				<label style="margin-top:-15px;" class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td colspan="3">
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:180px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="per_car"><span><?php echo $arrDatos['per_car']; ?></span></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="per_car_cg"><?php echo $arrDatos['per_car_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="per_car_cp"><?php echo $arrDatos['per_car_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px" colspan="3">
  				<div style="margin-top:-10px;font-size:12px;"><strong>DEDUCIBLE PROVISORIO</strong></div>
  			</td>
  			<td style="padding-right:20px;padding-top:-5px">
  				<label style="margin-top:-10px;" class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center;padding-top:-5px">
  				<label style="margin-top:-10px;" class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-15px" colspan="3">
  			<img src="img/<?php if($arrDatos['deprov_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label>
  				<!--<input type="checkbox" style="margin-top:-15px" name="deprov_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-15px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="desprov_cg_si"><?php echo $arrDatos['deprov_si_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-15px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="desprov_cp_si"><?php echo $arrDatos['deprov_si_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-4px" colspan="3">
  			<img src="img/<?php if($arrDatos['deprov_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="desprov_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="desprov_no_cg"><?php echo $arrDatos['deprov_no_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="desprov_no_cp"><?php echo $arrDatos['deprov_no_cp']; ?></div>
  			</td>
  		</tr>

  		<tr>
  			<td style="padding-top:-5px" colspan="3">
  				<div style="margin-top:1px;font-size:12px;"><strong>EXCLUSIONES</strong></div>
  			</td>
  			<td style="padding-right:20px;padding-top:-5px">
  				<label style="margin-top:1px;" class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center;padding-top:-5px">
  				<label style="margin-top:1px;" class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-3px" colspan="3">
  			<img src="img/<?php if($arrDatos['exclu_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label>
  				<!--<input type="checkbox" style="margin-top:2px" name="exclu_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  			<td style="padding-top:-3px">
  				<div style="font-size:12px;text-align:center;margin-top:2px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_si_cg"><?php echo $arrDatos['exclu_si_cg']; ?></div>
  			</td>
  			<td style="padding-top:-3px">
  				<div style="font-size:12px;text-align:center;margin-top:2px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_si_cp"><?php echo $arrDatos['exclu_si_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-6px" colspan="3">
  			<img src="img/<?php if($arrDatos['exclu_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="exclu_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_no_cg"><?php echo $arrDatos['exclu_no_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_no_cp"><?php echo $arrDatos['exclu_no_cp']; ?></div>
  			</td>
  		</tr>
  		</table>
  		<div style="margin-top:-1px;border-top:1px"></div>	
  		<table>
  			<tr>
  				<td colspan="5">
  					<div style="margin-top:-14px;font-size:12px;"><strong>SISTEMA DE NOTIFICACIÓN</strong></div>
  				</td>
  			</tr>
  			<tr>
  				<td>
  					<div style="width:100%;margin-top:-26px;font-size:12px;">El asegurado ha autorizado a la compañía para efectuar las notificaciones asociadas a esta póliza por el siguiente medio:</div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-7px" colspan="5">
  				<img src="img/<?php if($arrDatos['not_mail']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">e-mail al correo electrónico</label>
  					<!--<input type="checkbox" style="margin-top:-233px" name="exclu_no" value=""> <label style="font-size:12px;width;120px">e-mail al correo electrónico</label>-->
  					<div style="font-size:12px;margin-top:3px;margin-left:26px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_mail_texto"><?php echo $arrDatos['not_mail_texto']; ?></div>
  				</td>
  			
  			</tr>
  			<tr>
  				<td style="padding-top:0px">
  					<img src="img/<?php if($arrDatos['not_direcc']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Carta a la siguiente dirección</label>
  					<div style="font-size:12px;margin-left:16px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_direccion_texto"><?php echo $arrDatos['not_direccion_texto']; ?></div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-2px">
  					<img style="margin-top:0;" src="img/<?php if($arrDatos['not_otro']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otro</label>
  					<div style="font-size:12px;margin-left:148px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_otro_texto"><?php echo $arrDatos['not_otro_texto']; ?></div><br>
  					
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-8px">
  					<div style="width:100%;font-size:10px;">La presente carátula es un resumen de la información más relevante de la póliza y los conceptos fundamentales se encuentran definidos al reverso.</div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-2px">
  					<div style="width:110%;font-size:10px;">Para una comprensión integral, se debe consultar las condiciones generales y particulares de la póliza.  En cada punto se señala el artículo del condicionado general (CG) o condicionado particular (CP) donde puede revisarse el detalle respectivo.</div>
					
  				</td>
  			</tr>
  		
  		</table>
    </div>
    <?php } 
    if($seguro==2){
	?>
    <div id="cabecera" >
        <img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/imagenes/logo_renta_229x49.png'; ?>" />
        <h3 style="margin-bottom:0px">CARÁTULA UNIFORME PARA PÓLIZA DE <br>SEGURO DE <strong>INCENDIO</strong>/<br>CERTIFICADO DE COBERTURA</h3>
    </div>
    <div id="contenido" style="margin-top:15px;">
    	<table>
					
			<tr>
			<td >
					<div class='etiqueta_izq' ><strong>CÓDIGO CMF DE LA POLIZA</strong></div>
					<div class='div_izq' id="cod_poliza"><span><?php echo $arrDatos['cod_poliza']; ?></span></div>
				</td>
				<td>
				<div class='etiqueta_der'>PÓLIZA N°</div>
					<div class='div_der' id="num_poliza"><span><?php echo $arrDatos['num_poliza']; ?></span></div>
				</td>
			</tr>
			
			<tr>
			<td>
					<div style="margin-top:-48px" class='etiqueta_izq'><strong>CONTRATANTE (SI ES DISTINTO DEL ASEGURADO)</strong></div>
					<div class='div_izq' id="cont"><span><?php echo $arrDatos['contratante']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-48px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_cont"><span><?php echo $arrDatos['rut_contratante']; ?></span></div>
				</td>
			</tr>

			<tr><td>
			<div style="margin-top:-60px" class='etiqueta_izq'><strong>ASEGURADO</strong></div>
					<div class='div_izq' id="aseg"><span><?php echo $arrDatos['asegurado']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-60px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_aseg"><span><?php echo $arrDatos['rut_asegurado']; ?></span></div>
				</td>
			</tr>
			
			<tr><td>
			<div style="margin-top:-25px" class='etiqueta_izq'><strong>ACREEDOR</strong></div>
					<div class='div_izq' id="acreedor"><span><?php echo $arrDatos['acreedor']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:-25px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_acreedor"><span><?php echo $arrDatos['rut_acreedor']; ?></span></div>
				</td>
			</tr>

			<tr><td>
			<div style="margin-top:1px" class='etiqueta_izq'><strong>BENEFICIARIO</strong></div>
					<div class='div_izq' id="benef"><span><?php echo $arrDatos['benef']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:1px" class='etiqueta_der'>Rut</div>
					<div class='div_der' id="rut_benef"><span><?php echo $arrDatos['rut_benef']; ?></span></div>
				</td>
			</tr>
			<tr><td>
			<label class="etiqueta_izq" style="margin-top:2px">PROPIEDAD ASEGURADA</label>
			</td></tr>
			<tr><td>
			<div style="margin-top:0px" class='etiqueta_izq'><strong>DIRECCIÓN</strong></div>
					<div class='div_izq' id="dir_prop"><span><?php echo $arrDatos['dir_prop']; ?></span></div>
				</td>
				<td>
				<div style="margin-top:0px" class='etiqueta_der'>COMUNA</div>
					<div class='div_der' id="com_prop"><span><?php echo $arrDatos['com_prop']; ?></span></div>
				</td>
			</tr>
				
		</table>
		<label class="etiqueta_izq" style="margin-top:2px">TIPO DE RIESGO ASEGURADO</label><br>
  		<!--<input type="checkbox" style="margin-top:-4px" name="pl_seg_dp" value="">-->
  		<img src="img/<?php if($arrDatos['pl_seg_is']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Póliza de seguro de incendio simple</label><br>
  		<!--<input type="checkbox" style="margin-top:-4px" name="pl_seg_dt" value="">--> 
  		<img src="img/<?php if($arrDatos['pl_seg_ich']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-3px">Póliza de seguro de incendio asociada a créditos hipotecarios y sus adicionales</label><br>
  		
  		<div style="margin-top:1px;border-top:1px"></div>

  		<table style="margin-top:-19px;">
  		<tr>
  			<td style="padding-right:80px;">
  				<label class="etiqueta_izq">PÓLIZA</label>
  			</td>
  			<td style="padding-right:80px">
  				<label class="etiqueta_izq">VIGENCIA</label>
  			</td>
  			<td>
  				<label class="etiqueta_izq">RENOVACIÓN AUTOMÁTICA</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['pl_ind']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Individual</label><br>
  				<!--<input type="checkbox" style="margin-top:-5px" name="pl_ind" value=""> <label style="font-size:12px">Individual</label>-->
  			</td>
  			<td style="padding-right:80px">
  				<div style="font-size:12px;margin-top:-5px;width:80px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="vig_ini"><?php echo $arrDatos['vig_inicio']; ?></div><div style="font-size:12px;margin-left:85px;margin-top:-15px">Inicio</div>
  			</td>
  			<td style="padding-top:-3px">
  			<img src="img/<?php if($arrDatos['ra_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label><br>
  				<!--<input type="checkbox" style="margin-top:-5px" name="ra_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-6px">
  			<img src="img/<?php if($arrDatos['pl_col']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Colectiva</label><br>
  				<!--<input type="checkbox" style="margin-top:-7px" name="pl_col" value=""> <label style="font-size:12px">Colectiva</label>-->
  			</td>
  			<td style="padding-right:80px">
  				<div style="font-size:12px;margin-top:-7px;width:80px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="vig_term"><?php echo $arrDatos['vig_termino']; ?></div><div style="font-size:12px;margin-left:85px;margin-top:-15px">Término</div>
  			</td>
  			<td style="padding-top:-6px">
  				<img src="img/<?php if($arrDatos['ra_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label><br>
  				<!--<input type="checkbox" style="margin-top:-7px" name="ra_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  		</tr>
  		</table>
  		
  		<div style="margin-top:-2px;border-top:1px"></div>

  			<div style="font-size:12px;margin-top:-15px"><strong>PRIMA</strong> Monto</div>
			<div style="font-size:12px;margin-top:-5px;width:180px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="monto_prima"><span><?php echo $arrDatos['monto_prima']; ?><</span></div>

		<table style="margin-top:-4px;">
  		<tr >
  			<td style="padding-right:80px;">
  				<label class="etiqueta_izq">MONEDA</label>
  			</td>
  			<td style="padding-right:80px">
  				<label class="etiqueta_izq">PERÍODO DE PAGO</label>
  			</td>
  			<td style="padding-right:50px">
  				<label class="etiqueta_izq">CONDICIONES</label>
  			</td>
  			<td>
  				<label class="etiqueta_izq">COMISIÓN TOTAL CORREDOR</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['moneda_uf']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">UF</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="moneda_uf" value=""> <label style="font-size:12px">UF</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['pp_anual']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Anual</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="pp_anual" value=""> <label style="font-size:12px">Anual</label>-->
  			</td>
  			<td style="padding-right:50px;padding-top:-3px">
  			<img src="img/<?php if($arrDatos['cond_fija']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Fija</label><br>
  				<!--<input type="checkbox" style="margin-top:-6px" name="cond_fija" value=""> <label style="font-size:12px">Fija</label>-->
  			</td>
  			<td>
  				<font style="font-size:12px;margin-top:-5px">Monto</font><div style="font-size:12px;margin-top:-5px;margin-left:5px;width:150px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="monto_com"><?php echo $arrDatos['monto_com']; ?></div>
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['moneda_peso']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Peso</label><br>
  				<!--<input type="checkbox" name="moneda_peso" style="margin-top:-9px" value=""> <label style="font-size:12px">Peso</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['pp_mensual']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Mensual</label><br>
  				<!--<input type="checkbox" name="pp_mensual" style="margin-top:-9px" value=""> <label style="font-size:12px">Mensual</label>-->
  			</td>
  			<td style="padding-right:50px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['cond_ajust_sc']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Ajustable Según Contrato</label><br>
  				<!--<input type="checkbox" name="cond_ajust_sc" style="margin-top:-9px" value=""> <label style="font-size:12px">Ajustable Según Contrato</label>-->
  			</td>
  			<td style="padding-top:-4px">
  			<label style="font-size:12px;margin-top:-1px">No hay comisión</label><img style="margin-left:88px;" src="img/<?php if($arrDatos['monto_com']==0 || $arrDatos['monto_com']==NULL){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> 
  				<!--<label style="font-size:12px;margin-top:-9px">No hay comisión</label> <input type="checkbox" style="margin-left:85px;margin-top:-9px" name="no_com" value=""> -->
  			</td>
  		</tr>
  		<tr >
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['moneda_otra']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otra</label><br>
  				<!--<input type="checkbox" name="moneda_otra" style="margin-top:-18px" value=""> <label style="font-size:12px">Otra</label>-->
  			</td>
  			<td style="padding-right:80px;padding-top:-5px">
  			<img src="img/<?php if($arrDatos['pp_otro']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otro</label>
  				<!--<input type="checkbox" name="pp_otro" style="margin-top:-18px" value=""> <label style="font-size:12px">Otro</label>-->
  			</td>
  			
  		</tr>
  		</table>	
  		<div style="margin-top:-4px;border-top:1px"></div>
  		<table style="margin-top:-17px">
  		<tr >
  			<td style="padding-right:150px">
  				<label class="etiqueta_izq" >COBERTURAS</label>
  			</td>
  			<td style="padding-right:20px;">
  				<label style="font-size:12px;margin-left:-1px">MONTO</label>
  			</td>
  			<td style="padding-right:130px;">
  				<label style="font-size:12px;margin-left:17px">DEDUCIBLE</label>
  			</td>
  			<td style="padding-right:20px;">
  				<label class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center">
  				<label class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-3px">
  			<img src="img/<?php if($arrDatos['incendio']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Incendio</label>
  				<!--<input type="checkbox" style="margin-top:-5px" name="tdcd_dpropio" value=""> <label style="font-size:12px">Daños Propios</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_monto_com"><?php echo $arrDatos['incendio_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_ded"><?php echo $arrDatos['incendio_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_cg"><?php echo $arrDatos['incendio_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-5px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dpropio_cp"><?php echo $arrDatos['incendio_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['sismo']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Sismo</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_robo" value=""> <label style="font-size:12px">Robo, Hurto O Uso No Autorizado</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_monto_com"><?php echo $arrDatos['sismo_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_ded"><?php echo $arrDatos['sismo_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_cg"><?php echo $arrDatos['sismo_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="robo_cp"><?php echo $arrDatos['sismo_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['inunda']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Inundación</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_dat" value=""> <label style="font-size:12px">Daños A Terceros</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_monto_com"><?php echo $arrDatos['inunda_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_ded"><?php echo $arrDatos['inunda_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_cg"><?php echo $arrDatos['inunda_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dat_cp"><?php echo $arrDatos['inunda_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['riesgo_nat']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Riesgo de la naturaleza</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_de" value=""> <label style="font-size:12px">Daño Emergente</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_monto_com"><?php echo $arrDatos['riesgo_nat_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_ded"><?php echo $arrDatos['riesgo_nat_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_cg"><?php echo $arrDatos['riesgo_nat_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="de_cp"><?php echo $arrDatos['riesgo_nat_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['rot']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Rotura de cañerías</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_dam" value=""> <label style="font-size:12px">Daño Moral</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_monto_com"><?php echo $arrDatos['rot_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_ded"><?php echo $arrDatos['rot_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_cg"><?php echo $arrDatos['rot_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="dam_cp"><?php echo $arrDatos['rot_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px">
  			<img src="img/<?php if($arrDatos['ms']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Maremoto o tsunami</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="tdcd_lc" value=""> <label style="font-size:12px">Lucro Cesante</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:160px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_monto_com"><?php echo $arrDatos['ms_monto']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:100px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_ded"><?php echo $arrDatos['ms_ded']; ?></div>
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_cg"><?php echo $arrDatos['ms_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-7px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="lc_cp"><?php echo $arrDatos['ms_cp']; ?></div>
  			</td>
  		</tr>
  
  		<tr>
  			<td style="padding-top:-5px" colspan="5">
  			<img src="img/<?php if($arrDatos['cob_adic']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Esta poliza contiene otras coberturas adicionales, cuyo detalle debe ser consultado en las condiciones particulares.</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="cob_adic" value=""> <label style="font-size:12px">Esta poliza contiene otras coberturas adicionales, cuyo detalle debe ser consultado en las condiciones particulares.</label>-->
  			</td>
  		</tr>	
  		<tr>
  			<td style="padding-top:-4px" colspan="3">
  				<div style="font-size:12px;"><strong>CONDICIONES ESPECIALES DE ASEGURABILIDAD</strong></div>
  			</td>
  			<td style="padding-right:20px;padding-top:-4px">
  				<label class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center;padding-top:-4px">
  				<label class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-43px" colspan="3">
  			<img src="img/<?php if($arrDatos['ceda_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label>
  				<!--<input type="checkbox" style="margin-top:-45px" name="ceda_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-43px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="si_cg"><?php echo $arrDatos['ceda_si_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-43px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="si_cp"><?php echo $arrDatos['ceda_si_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-32px" colspan="3">
  			<img src="img/<?php if($arrDatos['ceda_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label>
  				<!--<input type="checkbox" style="margin-top:-35px" name="ceda_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-32px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="ceda_no_cg"><?php echo $arrDatos['ceda_no_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-32px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="ceda_no_cp"><?php echo $arrDatos['ceda_no_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-5px" colspan="3">
  				<div style="margin-top:-15px;font-size:12px;"><strong>PERÍODO DE CARENCIA</strong></div>
  			</td>
  			<td style="padding-top:-5px;padding-right:20px;">
  				<label style="margin-top:-15px;" class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="padding-top:-5px;text-align:center">
  				<label style="margin-top:-15px;" class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td colspan="3">
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:180px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;float:left" id="per_car"><span><?php echo $arrDatos['per_car']; ?></span></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="per_car_cg"><?php echo $arrDatos['per_car_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-30px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="per_car_cp"><?php echo $arrDatos['per_car_cp']; ?></div>
  			</td>
  		</tr>

  		<tr>
  			<td style="padding-top:-14px" colspan="3">
  				<div style="margin-top:1px;font-size:12px;"><strong>EXCLUSIONES</strong></div>
  			</td>
  			<td style="padding-right:20px;padding-top:-14px">
  				<label style="margin-top:1px;" class="etiqueta_izq">&nbsp;ART.CG</label>
  			</td>
  			<td style="text-align:center;padding-top:-14px">
  				<label style="margin-top:1px;" class="etiqueta_izq">ART.CP</label>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-3px" colspan="3">
  			<img src="img/<?php if($arrDatos['exclu_si']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Si</label>
  				<!--<input type="checkbox" style="margin-top:2px" name="exclu_si" value=""> <label style="font-size:12px">Si</label>-->
  			</td>
  			<td style="padding-top:-3px">
  				<div style="font-size:12px;text-align:center;margin-top:2px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_si_cg"><?php echo $arrDatos['exclu_si_cg']; ?></div>
  			</td>
  			<td style="padding-top:-3px">
  				<div style="font-size:12px;text-align:center;margin-top:2px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_si_cp"><?php echo $arrDatos['exclu_si_cp']; ?></div>
  			</td>
  		</tr>
  		<tr>
  			<td style="padding-top:-4px" colspan="3">
  			<img src="img/<?php if($arrDatos['exclu_no']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">No</label>
  				<!--<input type="checkbox" style="margin-top:-7px" name="exclu_no" value=""> <label style="font-size:12px">No</label>-->
  			</td>
  			<td >
  				<div style="font-size:12px;text-align:center;margin-top:-4px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_no_cg"><?php echo $arrDatos['exclu_no_cg']; ?></div>
  			</td>
  			<td>
  				<div style="font-size:12px;text-align:center;margin-top:-4px;width:50px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="exclu_no_cp"><?php echo $arrDatos['exclu_no_cp']; ?></div>
  			</td>
  		</tr>
  		</table>
  		<div style="margin-top:-1px;border-top:1px"></div>	
  		<table>
  			<tr>
  				<td colspan="5">
  					<div style="margin-top:-14px;font-size:12px;"><strong>SISTEMA DE NOTIFICACIÓN</strong></div>
  				</td>
  			</tr>
  			<tr>
  				<td>
  					<div style="width:100%;margin-top:-26px;font-size:12px;">El asegurado ha autorizado a la compañía para efectuar las notificaciones asociadas a esta póliza por el siguiente medio:</div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-7px" colspan="5">
  				<img src="img/<?php if($arrDatos['not_mail']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">e-mail al correo electrónico</label>
  					<!--<input type="checkbox" style="margin-top:-233px" name="exclu_no" value=""> <label style="font-size:12px;width;120px">e-mail al correo electrónico</label>-->
  					<div style="font-size:12px;margin-top:3px;margin-left:26px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_mail_texto"><?php echo $arrDatos['not_mail_texto']; ?></div>
  				</td>
  			
  			</tr>
  			<tr>
  				<td style="padding-top:0px">
  					<img src="img/<?php if($arrDatos['not_direcc']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Carta a la siguiente dirección</label>
  					<div style="font-size:12px;margin-left:16px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_direccion_texto"><?php echo $arrDatos['not_direccion_texto']; ?></div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-2px">
  					<img style="margin-top:0;" src="img/<?php if($arrDatos['not_otro']==1){ echo 'check'; }else{ echo 'uncheck'; }?>.png" width="13" height="13"/> <label style="font-size:12px;margin-top:-2px">Otro</label>
  					<div style="font-size:12px;margin-left:148px;width:250px;border:1px solid #C6C6C6;height:12px;background-color:#EEEEEE;" id="not_otro_texto"><?php echo $arrDatos['not_otro_texto']; ?></div><br>
  					
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-8px">
  					<div style="width:100%;font-size:10px;">La presente carátula es un resumen de la información más relevante de la póliza y los conceptos fundamentales se encuentran definidos al reverso.</div>
  				</td>
  			</tr>
  			<tr>
  				<td style="padding-top:-2px">
  					<div style="width:110%;font-size:10px;">Para una comprensión integral, se debe consultar las condiciones generales y particulares de la póliza.  En cada punto se señala el artículo del condicionado general (CG) o condicionado particular (CP) donde puede revisarse el detalle respectivo.</div>
					
  				</td>
  			</tr>
  		
  		</table>
    </div>
    <?php } ?>
</page>

<?php if($seguro==1){ ?>
<page>
	<p><b>Nota 1:</b> En caso de accidente, el conductor del vehículo asegurado debe concurrir a dar cuenta de inmediato a la autoridad policial más próxima. Se presume culpabilidad del 
	o de los que no lo hacen y abandonan el lugar del accidente. Adicionalmente, tan pronto le sea posible, una vez tomado conocimiento de la ocurrencia
	de un hecho que pueda constituir o constituya un siniestro, el asegurado debe efectuar el denuncio ante la compañía.
	<br><b>Nota 2:</b> El asegurado tiene la obligación de entregar la información que la compañía requiera acerca de su estado de riesgo, en los casos y en la forma que determina
	la normativa vigente. La infracción a esta obligación puede acarrear la terminación del contrato o que no sea pagado el siniestro.
	<br><b>Nota 3:</b> (Para Seguros Colectivos) Importante. "Usted está solicitando su incorporación como asegurado a una póliza o contrato de seguro colectivo cuyas condiciones
	han sido convenidas por... (indicar contratante) directamente con la compañía de seguros."
	</p><br>

	<p><b style="font-size:14px">DEFINCIONES</b>
	<br><b>CÓDIGO SVS DE LA PÓLIZA</b>: Es el Código con que la póliza fue depositada en la Superintendencia de Valores y Seguros, conocido también como "código Pol". Si la póliza
	incluye más de uno, se incluye sólo el  la cobertura principal.
	<br><b>PÓLIZA</b>: Documento justificativo del seguro.
	<br><b>CERTIFICADO DE COBERTURA</b>: Documento que da cuenta de un seguro emitido con sujeción a los términos de una póliza de seguro colectivo.
	<br><b>CONTRATANTE</b>: La persona que contrata el seguro con la compañía aseguradora y sobre quien recaen, en general, las obligaciones y cargas del contrato. Puede ser una
	persona diferente al asegurado.
	<br><b>ASEGURADO</b>: La persona a quien afecta el riesgo que se transfiere a la compañía aseguradora.
	<br><b>BENEFICIARIO</b>: La persona que, aun sin ser asegurado, tiene derecho a la indemnización en caso de siniestro.
	<br><b>TIPO DE RIESGO ASEGURADO</b>: Según el tipo de riesgo, las pólizas pueden ser de los siguientes tipos:<br>
	Es <i>seguro de daños propios</i>, aquel que cubre los daños del vehículo asegurado (total o parcial).<br>
	Es <i>seguro de daños a terceros</i>, aquel que cubre los daños ocasionados a terceros pero no al vehículo que se ha asegurado (total o parcial).<br>
	Es de <i>seguro de daños propios y a terceros</i>, aquel que cubre los daños ocasionados a terceros y al vehículo que se ha asegurado (total o parcial).
	Normalmente la póliza contempla dos coberturas adicionales que pueden contratarse conjuntamente o en forma separada, éstas son responsabilidad civil y robo,
	hurto o uso no autorizado del vehículo.
	<br><b>VIGENCIA</b>: Tiempo durante el cual se extiende la cobertura de riesgo de la póliza contratada.
	<br><b>RENOVACIÓN</b>: Se refiere a si la póliza se extingue al vencimiento de su plazo o si se renueva.<br>
	Es <i>automática</i> cuando se entiende renovada si el cliente o la compañía no deciden terminarla, conforme a la póliza.<br>
	Es <i>sin renovación</i>, cuando la póliza se extingue al vencimiento de su vigencia.
	<br><b>PRIMA</b>: El precio que se cobra por el seguro. Éste incluye los adicionales, en su caso.
	<br><b>CONDICIONES DE PRIMA</b>: La prima puede ser <i>fija</i>, si el monto es el mismo durante toda la vigencia de la póliza, o puede ser <i>ajustable</i>, si ese precio puede ser
	modificado conforme a las normas incluidas en la póliza.
	<br><b>COMISIÓN CORREDOR</b>: Es la parte de la prima que recibe un corredor de seguros, que ha vendido el seguro por cuenta de la compañía.  Puede expresarse como un monto fijo o un porcentaje de la prima.
	<br><b>COBERTURA</b>: El tipo de riesgo cubierto por la póliza.
	<br><b>DEDUCIBLE</b>: Cantidad o porcentaje establecido en la póliza de seguro que corre siempre por cuenta del asegurado, por lo que el asegurador siempre indemnizará en
	exceso de la cifra o porcentaje acordado.
	<br><b>DEDUCIBLE PROVISORIO</b>: Aquel mayor deducible diferente que se aplica cuando, habiéndose celebrado el contrato de seguro, aún se encuentra pendiente la
	obligación de efectuar la inspección.
	<br><b>CARENCIA</b>: Período establecido en la póliza durante el cual no rige la cobertura del seguro.
	<br><b>EXCLUSIONES</b>: Aquellos riesgos especificados en la póliza que no son cubiertos por el seguro.
	<br><b>CONDICIONES ESPECIALES DE ASEGURABILIDAD</b>: Son los requisitos específicos que debe cumplir el asegurado para que la compañía cubra el riesgo y pague el
	seguro, en caso de siniestro.
	<br><b>SISTEMA DE NOTIFICACIÓN</b>: Sistema de comunicación que el cliente autoriza para que la compañía le efectúe todas las notificaciones requeridas conforme a la póliza
	o que la compañía requiera realizar. Es responsabilidad del cliente actualizar los datos cuando exista un cambio en ellos.

	</p>
</page>
<?php } 
if($seguro==2){
?>
<page>
	<p><b>Nota 1:</b> El asegurado tiene la obligación de entregar la información que la compañía requiera acerca de su estado de riesgo, en los casos y en la forma que determina
	la normativa vigente. La infracción a esta obligación puede acarrear la terminación del contrato o que no sea pagado el siniestro.
	<br><b>Nota 2:</b> (Para Seguros Colectivos) Importante."Usted está solicitando su incorporación como asegurado a una póliza o contrato de seguro colectivo cuyas condiciones
	han sido convenidas por... (indicar contratante) directamente con la compañía de seguros."
	</p><br>

	<p><b style="font-size:14px">DEFINCIONES</b>
	<br><b>CÓDIGO SVS DE LA PÓLIZA</b>: Es el Código con que la póliza fue depositada en la Superintendencia de Valores y Seguros, conocido también como "código Pol". Si la póliza
	incluye más de uno, se incluye sólo el  la cobertura principal.
	<br><b>PÓLIZA</b>: Documento justificativo del seguro.
	<br><b>CERTIFICADO DE COBERTURA</b>: Documento que da cuenta de un seguro emitido con sujeción a los términos de una póliza de seguro colectivo.
	<br><b>CONTRATANTE</b>: La persona que contrata el seguro con la compañía aseguradora y sobre quien recaen, en general, las obligaciones y cargas del contrato. Puede ser una
	persona diferente al asegurado.
	<br><b>ASEGURADO</b>: La persona a quien afecta el riesgo que se transfiere a la compañía aseguradora.
	<br><b>BENEFICIARIO</b>: La persona que, aun sin ser asegurado, tiene derecho a la indemnización en caso de siniestro.
	<br><b>TIPO DE RIESGO ASEGURADO</b>: Según el tipo de riesgo, las pólizas pueden ser de los siguientes tipos:<br>
	Es <i>seguro de incendio simple</i> cuando se paga una indemnización, en caso de incendio con pérdida total del inmueble asegurado en la póliza. En caso de pérdida parcial,
	paga la reparación de dicho bien.<br>
	Es <i>seguro de incendio asociado a créditos hipotecarios y sus adicionales</i>, aquel exigido por las entidades crediticias que cubre los daños al inmueble dado en garantía
	hipotecaria en caso de incendio. Se pueden contratar coberturas adicionales tales como daños a causa de sismos, salida de mar, riesgos de la naturaleza, etc.
	<br><b>VIGENCIA</b>: Tiempo durante el cual se extiende la cobertura de riesgo de la póliza contratada.
	<br><b>RENOVACIÓN</b>: Se refiere a si la póliza se extingue al vencimiento de su plazo o si se renueva.<br>
	Es <i>automática</i> cuando se entiende renovada si el cliente o la compañía no deciden terminarla, conforme a la póliza.<br>
	Es <i>sin renovación</i>, cuando la póliza se extingue al vencimiento de su vigencia.
	<br><b>PRIMA</b>: El precio que se cobra por el seguro. Éste incluye los adicionales, en su caso.
	<br><b>CONDICIONES DE PRIMA</b>: La prima puede ser <i>fija</i>, si el monto es el mismo durante toda la vigencia de la póliza, o puede ser <i>ajustable</i>, si ese precio puede ser
	modificado conforme a las normas incluidas en la póliza.
	<br><b>COMISIÓN CORREDOR</b>: Es la parte de la prima que recibe un corredor de seguros, que ha vendido el seguro por cuenta de la compañía.  Puede expresarse como un monto fijo o un porcentaje de la prima.
	<br><b>COBERTURA</b>: El tipo de riesgo cubierto por la póliza.
	<br><b>CARENCIA</b>: Período establecido en la póliza durante el cual no rige la cobertura del seguro.
	<br><b>EXCLUSIONES</b>: Aquellos riesgos especificados en la póliza que no son cubiertos por el seguro.
	<br><b>CONDICIONES ESPECIALES DE ASEGURABILIDAD</b>: Son los requisitos específicos que debe cumplir el asegurado para que la compañía cubra el riesgo y pague el
	seguro, en caso de siniestro.
	<br><b>SISTEMA DE NOTIFICACIÓN</b>: Sistema de comunicación que el cliente autoriza para que la compañía le efectúe todas las notificaciones requeridas conforme a la póliza
	o que la compañía requiera realizar. Es responsabilidad del cliente actualizar los datos cuando exista un cambio en ellos.

	</p>
</page>
<?php
}
    $content = ob_get_clean();

    require_once($_SERVER['DOCUMENT_ROOT'].'/librerias/html2pdf_v4.03/html2pdf.class.php');
    try
    {
       //$html2pdf = new HTML2PDF('P', 'letter', 'fr', true, 'UTF-8', 0);
        $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8',array(7, 7, 20, 2));
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Poliza.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

}
if($_GET['tipo']==1){
$dato=array("cod_poliza" => "965221-5", "num_poliza" => "88551555", "pl_seg_dp" => 1, 
			"pl_seg_dt" => 1, "pl_seg_dpt" => 0, "contratante" => "CECILIA SANHUEZA JARA",
			"rut_contratante" => "8904063-9", "asegurado" => "CECILIA SANHUEZA JARA",
			"rut_asegurado" => "8904063-9","tipo_vehiculo" => "AUTOMOVIL", "marca_modelo" => "MERCEDES BENZ / E200",
			"patente" => "BFYR66", "anio" => "2008", "vin" => "271956309250406", "pl_ind" => 1, "pl_col" => 0,
			"vig_inicio" => "27-08-2019", "vig_termino" => "01-09-2019", "ra_si" => 0, "ra_no" => 1, "monto_prima" => 300,
			"moneda_uf" => 1, "moneda_peso" => 0, "moneda_otra" => 0, "pp_anual" => 0, "pp_mensual" => 1, "pp_otro" => 0,
			"cond_fija" => 0, "cond_ajust_sc" => 1, "monto_com" => 0, "dpropio" => 1, "robo" => 0, "dat" => 1, "de" => 0,
			"dam" => 1, "lc" => 0, "pt" => 1, "cob_adic" => 0, "dpropio_monto_com" => 150, "dpropio_ded" => 10,
			"dpropio_cg" => 2, "dpropio_cp" => 3, "robo_monto_com" => 150, "robo_ded" => 10, "robo_cg" => 2, 
			"robo_cp" => 3, "dat_monto_com" => 150, "dat_ded" => 10, "dat_cg" => 2, "dat_cp" => 3,
			"de_monto_com" => 150, "de_ded" => 10, "de_cg" => 2, "de_cp" => 3, "dam_monto_com" => 150, "dam_ded" => 10, "dam_cg" => 2, 
			"dam_cp" => 3, "lc_monto_com" => 150, "lc_ded" => 10, "lc_cg" => 2, "lc_cp" => 3, "pt_monto_com" => 150,
			"pt_ded" => 10, "pt_cg" => 2, "pt_cp" => 3, "ceda_si" => 1, "ceda_no" => 1, "ceda_si_cg" => 3, "ceda_si_cp" => 3,
			"ceda_no_cg" => 1, "ceda_no_cp" => 1, "per_car" => "NO", "per_car_cg" => 1,"per_car_cp" => 2, "deprov_si" => 0,
			"deprov_no" => 1, "deprov_si_cg" => 6, "deprov_si_cp" => 6, "deprov_no_cg" => 5, "deprov_no_cp" => 5,
			"exclu_si" => 1, "exclu_no" => 0, "exclu_si_cg" => 11, "exclu_si_cp" => 11, "exclu_no_cg" => 10, "exclu_no_cp" => 10,
			"not_mail" => 1, "not_direcc" => 0,  "not_otro" => 1, "not_mail_texto" => "rodrigopanes@gmail.com", 
			"not_direccion_texto" => "Pasaje uno sur 3811 block 15 dep-47", "not_otro_texto" => "-");
poliza_pdf($dato,1);
}
if($_GET['tipo']==2){
$dato=array("cod_poliza" => "965221-5", "num_poliza" => "88551555", "pl_seg_dp" => 1, 
			"pl_seg_dt" => 1, "pl_seg_dpt" => 0, "contratante" => "CECILIA SANHUEZA JARA",
			"rut_contratante" => "8904063-9", "asegurado" => "CECILIA SANHUEZA JARA",
			"rut_asegurado" => "8904063-9","acreedor" => "JUAN PEREZ", "rut_acreedor" => "14363032-3",
			"benef" => "CARLOS RODRIGUEZ", "rut_benef" => "17123915-K", "dir_prop" => "AMUNATEGUI 200", 
			"com_prop" => "SANTIAGO", "pl_seg_is" => 1, "pl_seg_ich" => 0, "pl_ind" => 1, "pl_col" => 0,
			"vig_inicio" => "27-08-2019", "vig_termino" => "01-09-2019", "ra_si" => 0, "ra_no" => 1, "monto_prima" => 300,
			"moneda_uf" => 1, "moneda_peso" => 0, "moneda_otra" => 0, "pp_anual" => 0, "pp_mensual" => 1, "pp_otro" => 0,
			"cond_fija" => 0, "cond_ajust_sc" => 1, "monto_com" => 0, "incendio" => 1, "sismo" => 0, "inunda" => 1, "riesgo_nat" => 0,
			"rot" => 1, "ms" => 0, "cob_adic" => 0, "incendio_monto" => 150, "incendio_ded" => 10,
			"incendio_cg" => 2, "incendio_cp" => 3, "sismo_monto" => 150, "sismo_ded" => 10, "sismo_cg" => 2, 
			"sismo_cp" => 3, "inunda_monto" => 150, "inunda_ded" => 10, "inunda_cg" => 2, "inunda_cp" => 3,
			"riesgo_nat_monto" => 150, "riesgo_nat_ded" => 10, "riesgo_nat_cg" => 2, "riesgo_nat_cp" => 3, "rot_monto" => 150, "rot_ded" => 10, "rot_cg" => 2, 
			"rot_cp" => 3, "ms_monto" => 150, "ms_ded" => 10, "ms_cg" => 2, "ms_cp" => 3, "ceda_si" => 1, "ceda_no" => 1, "ceda_si_cg" => 3, "ceda_si_cp" => 3,
			"ceda_no_cg" => 1, "ceda_no_cp" => 1, "per_car" => "NO", "per_car_cg" => 1,"per_car_cp" => 2, 
			"exclu_si" => 1, "exclu_no" => 0, "exclu_si_cg" => 11, "exclu_si_cp" => 11, "exclu_no_cg" => 10, "exclu_no_cp" => 10,
			"not_mail" => 1, "not_direcc" => 0,  "not_otro" => 1, "not_mail_texto" => "rodrigopanes@gmail.com", 
			"not_direccion_texto" => "Pasaje uno sur 3811 block 15 dep-47", "not_otro_texto" => "-");
poliza_pdf($dato,2);
}
