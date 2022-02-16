<?PHP
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
	include("base.adj");
	include("funciones.adj");
	include("funciones_cobranza.adj");
	/**
 * @abstract Archivo que trae los datos del siniestro ingresado en la pantalla de ingreso de siniestros
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */
	$id_sini=$_POST['id_sin'];	
	try {
		$conn_siniestro = TraeCon("siniestro");
		$conn_empresa = TraeCon("empresa");
		
	} catch (PDOException $e) {
	    print "<p>Error: No puede conectarse con la base de datos.</p>\n";
	    print "<p>Error: " . $e->getMessage() . "</p>\n";
	}
	
	$qry = "select * from maesin where codsin=".$id_sini;
	
	$cont=0;
	try{
		foreach($conn_siniestro->query($qry) as $row){
			$cont++;
			$sini=$row['CODSIN'];
			$fec_sinies = date("d/m/Y",strtotime($row["FECHA_OCURR"]));
			$fec_den = date("d/m/Y",strtotime($row["FECHA_DENUC"]));
			$asegurado_rut=$row["NUMASE"];
			$asegurado_dv=$row["DIGASE"];
			$liquidador_rut=$row["NUMLIQ"];
			$liquidador_dv=$row["DIGLIQ"];

			if ($asegurado_rut >= 50000000){
				$query_ase = "SELECT razon_social FROM empresas WHERE rut = '$asegurado_rut' AND digv = '$asegurado_dv'";
			}else{
				$query_ase = "SELECT pnombre, snombre, paterno, materno FROM personas WHERE rut = '$asegurado_rut' AND digv = '$asegurado_dv'";
			}
		
			foreach ($conn_empresa->query($query_ase) as $value_ase){
				if ($asegurado_rut >= 50000000){
					$nom_asegurado = trim($value_ase['RAZON_SOCIAL']);
				}
				else {
					$nom_asegurado = trim($value_ase['PNOMBRE'])." ".trim($value_ase['SNOMBRE'])." ".trim($value_ase['PATERNO'])." ".trim($value_ase['MATERNO']);
				}
			}
			if ($liquidador_rut >= 50000000){
				$query_liq = "SELECT razon_social FROM empresas WHERE rut = '$liquidador_rut' AND digv = '$liquidador_dv'";
			}else{
				$query_liq = "SELECT pnombre, snombre, paterno, materno FROM personas WHERE rut = '$liquidador_rut' AND digv = '$liquidador_dv'";
			}
		
			foreach ($conn_empresa->query($query_liq) as $value_liq){
				if ($liquidador_rut >= 50000000){
					$nom_liquidador = trim($value_liq['RAZON_SOCIAL']);
				}
				else {
					$nom_liquidador = trim($value_liq['PNOMBRE'])." ".trim($value_liq['SNOMBRE'])." ".trim($value_liq['PATERNO'])." ".trim($value_liq['MATERNO']);
				}
			}
		}
		$ramo_id=0;
		$sql_ramo="SELECT ramo_id from php_maeabo where codsin=".$sini;
		foreach ($conn_siniestro->query($sql_ramo) as $row){
			$ramo_id=$row["RAMO_ID"];
		}	
	}catch(Exception $e){
			$error = "Error en código: ".$e->getCode().". Mensaje: ".$e->getMessage();
			$conn_db = null;
			die("false*$error");
	}	
	if($cont>0){	
		echo "OK*".$sini."*".$fec_sinies."*".$fec_den."*".$nom_asegurado."*".$nom_liquidador."*".$ramo_id;
	}else{
		echo "NO*Siniestro no registrado";
	}	

?>