<?PHP
/*error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);*/

/**
 * @abstract Archivo que graba o actualiza nuevo expediente de tipo demanda en tabla php_maeabo_dmd.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */
	include("base.adj");
	
	try {
		$conn_db	= TraeCon('siniestro');
		$conn_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    print "<p>Error: No puede conectarse con la base de datos.</p>\n";
	    print "<p>Error: " . $e->getMessage() . "</p>\n";
	}

	$ramo=trim($_POST['ramo']);
	$abogado=explode("-",trim($_POST['abogado']));
	$abogado_rut=$abogado[0];
	$abogado_dv=$abogado[1];

	$fono=$_POST['fono'];
	$correo=$_POST['correo'];
	$trib=$_POST['tribunal'];
	$causa=$_POST['causa'];
	$fecha_dem=$_POST['fec_dem'];
	$tipo_acu=$_POST['tipo_acu'];
	$fecha_asign=$_POST['fec_asign'];
	$monto_dem=$_POST['m_dem'];
	$monto_pag=$_POST['m_pag'];
	$honorarios=$_POST['hono'];
	$gastos=$_POST['gastos'];
	$obs=$_POST['obs'];

	$codsin=$_POST['codsin'];
	$exp=$_POST['nexp'];	

	$fecha			= date("Y-m-d H:i:s");
	$usuario 		= $_SESSION['Usuario'];

	if (trim($usuario) === ''){
		die("false*Se perdió la conexión del sistema. Debe acceder nuevamente para continuar.");
	}

	$cont=0;
	$sql_exp="SELECT * FROM php_maeabo_dmd WHERE codsin=".$codsin." and folio_exp=".$exp;
	foreach($conn_db->query($sql_exp) as $row2){
		$cont++;
	}

	if($cont==0){
		$sql = "INSERT INTO php_maeabo_dmd(codsin,folio_exp,terc_email,terc_fono,dmd_tribunal,dmd_causa,dmd_fecha_dmd,
		dmd_fecha_asigna,dmd_tipo_acuerdo,dmd_mto_demanda,dmd_mto_pagado,dmd_honorario,dmd_gastos,dmd_observa) 
		VALUES (".$codsin.",".$exp.",'".$correo."','".$fono."','".$trib."','".$causa."','".$fecha_dem."','".$fecha_asign."',
		".$tipo_acu.",".$monto_dem.",".$monto_pag.",".$honorarios.",".$gastos.",'".$obs."')";	
		Escribe_Log("$aux_seg: sql_graba:$sql","query_insert_php_maeabo_dmd.log");
		$sql2="UPDATE php_maeabo set abog_numrut=".$abogado_rut.",abog_dvrut='".$abogado_dv."',ramo_id=".$ramo." where 
		codsin=".$codsin." and folio_exp=".$exp;
		Escribe_Log("$aux_seg: sql_actualiza:$sql2","query_update_php_maeabo.log");
	}else{
		$sql = "UPDATE php_maeabo_dmd set terc_email='".$correo."',terc_fono='".$fono."',dmd_tribunal='".$trib."',
		dmd_causa='".$causa."',dmd_fecha_dmd='".$fecha_dem."',dmd_fecha_asigna='".$fecha_asign."',dmd_tipo_acuerdo=".$tipo_acu.",
		dmd_mto_demanda=".$monto_dem.",dmd_mto_pagado=".$monto_pag.",dmd_honorario=".$honorarios.",dmd_gastos=".$gastos.",
		dmd_observa='".$obs."' WHERE codsin=".$codsin." and folio_exp=".$exp;	
		Escribe_Log("$aux_seg: sql_actualiza:$sql","query_update_php_maeabo_dmd.log");
		$sql2="UPDATE php_maeabo set abog_numrut=".$abogado_rut.",abog_dvrut='".$abogado_dv."',ramo_id=".$ramo." where 
		codsin=".$codsin." and folio_exp=".$exp;
		Escribe_Log("$aux_seg: sql_actualiza:$sql2","query_update_php_maeabo.log");
	}
	//echo $sql;	
	try {

			$conn_db->beginTransaction();
			$conn_db->exec($sql);
			$conn_db->exec($sql2);
			$conn_db->commit();
		}
		
		catch(Exception $e){
			$conn_db->rollBack();
			$error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
			$conn_db = null;
			die("false*$error");
		}
	
	$conn_db = null;
	echo "OK*Datos grabados correctamentee.";
	
?>