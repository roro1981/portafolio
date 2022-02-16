<?PHP
/*error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);*/

/**
 * @abstract Archivo que graba o actualiza nuevo expediente de tipo recupero en tabla php_maeabo_rcpr.
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
	$est_recupero=$_POST['est_rec'];
	$tipo_terc=$_POST['tip_terc'];
	$monto_ind=$_POST['m_ind'];
	$monto_cob=$_POST['m_cob'];
	$monto_rec=$_POST['m_rec'];
	$honorarios=$_POST['hono'];
	$gastos=$_POST['gastos'];
	$tipo_cob=$_POST['tip_cob'];
	$comp_id=$_POST['comp_id'];
	$sin_comp_cul=$_POST['scc'];
	$f_cobro=$_POST['fec_cob'];
	$f_rec=$_POST['fec_rec'];
	$obs=$_POST['obs'];

	$codsin=$_POST['codsin'];
	$exp=$_POST['nexp'];	

	$fecha			= date("Y-m-d H:i:s");
	$usuario 		= $_SESSION['Usuario'];

	if (trim($usuario) === ''){
		die("false*Se perdió la conexión del sistema. Debe acceder nuevamente para continuar.");
	}

	$cont=0;
	$sql_exp="SELECT * FROM php_maeabo_rcpr WHERE codsin=".$codsin." and folio_exp=".$exp;
	//echo $sql_exp;
	foreach($conn_db->query($sql_exp) as $row2){
		$cont++;
	}

	if($cont==0){
		$sql = "INSERT INTO php_maeabo_rcpr(codsin,folio_exp,terc_email,terc_fono,rpcr_tribunal,rcpr_causa,rcpr_estado,rcpr_tipo_tercero,
		rcpr_monto_cobrado,rcpr_honorarios,rcpr_mto_indemi,rcpr_mto_recupero,rcpr_gastos,rcpr_tipo_cobro,rcpr_compania_id,
		rcpr_sinie_id_cia,rcpr_fecha_cobro,rcpr_fecha_recupe,rcpr_observa,rcpr_estado) 
		VALUES (".$codsin.",".$exp.",'".$correo."','".$fono."','".$trib."','".$causa."',".$est_recupero.",".$tipo_terc.",".$monto_cob.",
		".$honorarios.",".$monto_ind.",".$monto_rec.",".$gastos.",".$tipo_cob.",".$comp_id.",'".$sin_comp_cul."',
		'".$f_cobro."','".$f_rec."','".$obs."',1)";	
		Escribe_Log("$aux_seg: sql_graba:$sql","query_insert_php_maeabo_rcpr.log");
		$sql2="UPDATE php_maeabo set abog_numrut=".$abogado_rut.",abog_dvrut='".$abogado_dv."',ramo_id=".$ramo." where 
		codsin=".$codsin." and folio_exp=".$exp;
		Escribe_Log("$aux_seg: sql_actualiza:$sql2","query_update_php_maeabo.log");
	}else{
		$sql = "UPDATE php_maeabo_rcpr set terc_email='".$correo."',terc_fono='".$fono."',rpcr_tribunal='".$trib."',
		rcpr_causa='".$causa."',rcpr_estado=".$est_recupero.",rcpr_tipo_tercero=".$tipo_terc.",rcpr_monto_cobrado=".$monto_cob.",rcpr_honorarios=".$honorarios.",
		rcpr_mto_indemi=".$monto_ind.",rcpr_mto_recupero=".$monto_rec.",rcpr_gastos=".$gastos.",rcpr_tipo_cobro=".$tipo_cob.",
		rcpr_compania_id=".$comp_id.",rcpr_sinie_id_cia='".$sin_comp_cul."',rcpr_fecha_cobro='".$f_cobro."',
		rcpr_fecha_recupe='".$f_rec."',rcpr_observa='".$obs."' WHERE codsin=".$codsin." and folio_exp=".$exp;	
		Escribe_Log("$aux_seg: sql_actualiza:$sql","query_update_php_maeabo_rcpr.log");
		$sql2="UPDATE php_maeabo set abog_numrut=".$abogado_rut.",abog_dvrut='".$abogado_dv."',ramo_id=".$ramo." where 
		codsin=".$codsin." and folio_exp=".$exp;
		Escribe_Log("$aux_seg: sql_actualiza:$sql2","query_update_php_maeabo.log");
	}

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