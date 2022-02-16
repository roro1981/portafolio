<?PHP
/*error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);*/

/**
 * @abstract Archivo que graba nuevo expediente en la tabla php_maeabo.
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

	
	$gestion=trim($_POST['gestion']);
	$abogado=explode("-",trim($_POST['abogado']));
	$abogado_rut=$abogado[0];
	$abogado_dv=$abogado[1];
	$terc=explode("-",trim($_POST['rut_terc']));
	$rut_terc=$terc[0];
	$dv_terc=$terc[1];
	$nom_terc=$_POST['nom_terc'];
	$siniestro=$_POST['num_sin'];
	$ramo=$_POST['ramo_id'];

	$fecha			= date("Y-m-d H:i:s");
	$usuario 		= $_SESSION['Usuario'];

	if (trim($usuario) === ''){
		die("false*Se perdió la conexión del sistema. Debe acceder nuevamente para continuar.");
	}
	$folio=0;
	$sql_exp="SELECT max(folio_exp) as ultima FROM php_maeabo WHERE codsin=".$siniestro;
	foreach($conn_db->query($sql_exp) as $row2){
		$folio=$row2['ULTIMA']+1;
	}
	$sql_graba_exp = "INSERT INTO php_maeabo(codsin,folio_exp,tipo_gestion_id,abog_numrut,abog_dvrut,terc_numrut,terc_dvrut,terc_nombre,fecha_asig,ramo_id) 
	VALUES (".$siniestro.",".$folio.",".$gestion.",".$abogado_rut.",'".$abogado_dv."',".$rut_terc.",'".$dv_terc."','".$nom_terc."','".$fecha."',".$ramo.")";	
	Escribe_Log("$aux_seg: sql_graba:$sql_graba_exp","query_insert_php_maeabo.log");
	try {

			$conn_db->beginTransaction();
			$conn_db->exec($sql_graba_exp);
			$conn_db->commit();
		}
		
		catch(Exception $e){
			$conn_db->rollBack();
			$error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
			$conn_db = null;
			die("false*$error");
		}
	
	$conn_db = null;
	echo "OK*Expediente grabado correctamente.";
	
?>