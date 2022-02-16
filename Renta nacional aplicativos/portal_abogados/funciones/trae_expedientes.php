<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
	include("base.adj");
	/**
 * @abstract Archivo que carga datatable con todos los expedientes del siniestro ingresado.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */
	try {
		$conn_db	= TraeCon('siniestro');
		$conn_empresa = TraeCon("empresa");
		$conn = TraeCon("produccion");
		$conn_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    print "<p>Error: No puede conectarse con la base de datos.</p>\n";
	    print "<p>Error: " . $e->getMessage() . "</p>\n";
	}	

	$usuario = $_SESSION['Usuario'];
	$sini    = $_POST['id_sini'];
	is_logged();
	

$sql_trae = "SELECT m.*,a.nombre FROM php_maeabo m INNER JOIN abogados2 a on m.abog_numrut=a.numrut where codsin=".$sini." ORDER by folio_exp desc";
Escribe_Log("$aux_seg: sql:$sql_trae ","query_trae_expedientes.log");

	echo "<span style='float:left'>Resumen</span><table id='Tabla_exp' style='width:100%'><thead>
			<tr>
			<th width='50' style='text-align:center'>Tipo gestion</th>
			<th width='50' style='text-align:center'>Abogado</th>
			<th width='50' style='text-align:center'>Nombre tercero/demandado</th>
			<th width='50' style='text-align:center'>Numero Folio</th>
		  </tr></thead><tbody>";
$cont=0;
try{
	foreach($conn_db->query($sql_trae) as $row_Trae){
		$cont++;
		$gestion    = $row_Trae['TIPO_GESTION_ID'];
		$abogado    = $row_Trae['NOMBRE'];
		$tercero    = $row_Trae['TERC_NOMBRE'];
		$rut_terc   = $row_Trae['TERC_NUMRUT']."-".$row_Trae['TERC_DVRUT'];
		$folio      = $row_Trae['FOLIO_EXP'];
		$ramo       = $row_Trae['RAMO_ID'];
		$abog_rut   = $row_Trae['ABOG_NUMRUT'];
		$abog_dv    = $row_Trae['ABOG_DVRUT'];
		$fec_asig   = date("d/m/Y",strtotime($row_Trae['FECHA_ASIG']));
		if($gestion==1){
			$gest="RECUPERO";
		}elseif($gestion==2){
			$gest="DEMANDA";
		}else{
			$gest="PAGO INTERCOMPANIA";
		}
		//datos siniestro
		$sql_datos="SELECT * FROM maesin where codsin=".$sini;
		foreach($conn_db->query($sql_datos) as $row){
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
		
		$datos=$sini."*".$nom_asegurado."*".$nom_liquidador."*".$ramo."*".$abog_rut."*".$abog_dv."*".$fec_asig."*".$fec_sinies."*".$fec_den."*".$folio."*".$gestion."*".$rut_terc."*".$tercero;
		echo "<tr>
					<td style='text-align:center'>$gest</td>
					<td style='text-align:center'>$abogado</td>
					<td style='text-align:center'>$tercero</td>
					<td style='text-align:center;cursor:pointer' id='".$datos."' class='caso2'>$folio</td>
				</tr>";
	}
}catch (PDOException $e) {
	$error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
	$conn_db = null;
	die("false*$error");
}	
	echo "</tbody></table>";
	$conn_db = null;
?>
