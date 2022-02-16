<?PHP
/*error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);*/

/**
 * @abstract Archivo que graba o actualiza nuevo expediente de tipo pago entre compañías en tabla php_maeabo_rec.
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

	$comp=$_POST['nom_com'];
	$fecha_cob=$_POST['fecha_cob'];
	$num_sin=$_POST['num_sin_tcom'];
	$fecha_pag=$_POST['fecha_pag'];
	$monto_cob=$_POST['monto_cob'];
	$monto_pag=$_POST['monto_pag'];
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
	$sql_exp="SELECT * FROM php_maeabo_pec WHERE codsin=".$codsin." and folio_exp=".$exp;
	foreach($conn_db->query($sql_exp) as $row2){
		$cont++;
	}

	if($cont==0){
		$sql = "INSERT INTO php_maeabo_pec(codsin,folio_exp,pec_compania_id,sinie_id_cia,pec_fecha_cobro,pec_fecha_pago,
		pec_mto_cobrado,pec_honorario,pec_mto_pagado,pec_gastos,dmd_observa) 
		VALUES (".$codsin.",".$exp.",'".$comp."','".$num_sin."','".$fecha_cob."','".$fecha_pag."',".$monto_cob.",
		".$honorarios.",".$monto_pag.",".$gastos.",'".$obs."')";	
		Escribe_Log("$aux_seg: sql_graba:$sql","query_insert_php_maeabo_pec.log");
		$sql2="UPDATE php_maeabo set abog_numrut=".$abogado_rut.",abog_dvrut='".$abogado_dv."',ramo_id=".$ramo." where 
		codsin=".$codsin." and folio_exp=".$exp;
		Escribe_Log("$aux_seg: sql_actualiza:$sql2","query_update_php_maeabo.log");
	}else{
		$sql = "UPDATE php_maeabo_pec set pec_compania_id='".$comp."',sinie_id_cia='".$num_sin."',pec_fecha_cobro='".$fecha_cob."',
		pec_fecha_pago='".$fecha_pag."',pec_mto_cobrado=".$monto_cob.",pec_honorario=".$honorarios.",pec_mto_pagado=".$monto_pag.",
		pec_gastos=".$gastos.",dmd_observa='".$obs."' WHERE codsin=".$codsin." and folio_exp=".$exp;	
		Escribe_Log("$aux_seg: sql_actualiza:$sql","query_update_php_maeabo_pec.log");
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
	echo "OK*Datos grabados correctamente.";
	
?>