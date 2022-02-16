<?php
/**
 * @abstract Archivo que genera reporte de abogado por rango de fecha.
 * 
 * @author Rodrigo Panes Fuentes <rpanes@rentanac.cl>
 * @version 1.0 - Creacion - 05/01/2021
 * 
 */
error_reporting(E_ALL & ~E_NOTICE);
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
include("base.adj");
include("funciones.adj");
include("funciones_cobranza.adj");
include("mailer.adj");

$conn_db = TraeCon("siniestro");
$conn_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn = TraeCon("produccion");
$conn_empresa = TraeCon("empresa");

$tipo=$_GET['tipo'];
if($tipo==1){
  $gestion="RECUPERO";
}elseif($tipo==2){
  $gestion="DEMANDA";
}elseif($tipo==3){
  $gestion="INTER-COMPANIA";
}
$abogado_id=$_GET['abog'];
$fec_desde=$_GET['fecha_desde'];
$fec_hasta=$_GET['fecha_hasta'];
$abogado=explode("-",$abogado_id);
$abog_rut=$abogado[0];
$abog_dv=$abogado[1];
//obtiene nombre abogado para nombre de archivo
$sql_abo = "SELECT nombre FROM abogados2 where numrut=".$abog_rut." and digrut='".$abog_dv."'";
foreach($conn_db->query($sql_abo) as $row_ab){
  $nombre_abog=trim($row_ab['NOMBRE']);  
}
mb_http_output('UTF-8');
$nombre_archivo=$gestion." ".$nombre_abog." ".$fec_desde." al ".$fec_hasta;
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename='.$nombre_archivo.'.xls');
?>
<html>
<head>
<meta charset="UTF-8">
</head>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
<tr>
<?php
if($tipo==1){
?>
<th>RAMO</th>
<th>NUMERO EXPEDIENTE</th>
<th>NUMERO DE SINIESTRO</th>
<th>ASEGURADO</th>
<th>LIQUIDADOR</th>
<th>FECHA SINIESTRO</th>
<th>FECHA DENUNCIA SINIESTRO</th>
<th>NOMBRE ABOGADO</th>
<th>FECHA ASIGNACION</th>
<th>ESTADO RECUPERO</th>
<th>TERCERO</th>
<th>ESTADO LIQUIDACION</th>
<th>TIPO DE COBRO</th>
<th>NOMBRE COMPAÑÍA CULPABLE</th>
<th>FECHA COBRO</th>
<th>FECHA RECUPERO</th>
<th>MONTO INDEMNIZADO</th>
<th>MONTO COBRADO</th>
<th>MONTO RECUPERO</th>
<th>HONORARIOS</th>
<th>GASTOS</th>
<th>OBSERVACIONES</th>
</tr>
<?php
try{
  $sql = "SELECT * FROM php_maeabo where abog_numrut=".$abog_rut." and abog_dvrut='".$abog_dv."' and tipo_gestion_id=1";
  foreach($conn_db->query($sql) as $row){
    //obtiene ramo
      $sql_ram = "SELECT ramo_descrip FROM ramosuper where cia_id=1 and ramo_id=".$row['RAMO_ID'];
      foreach($conn->query($sql_ram) as $row_r){
        $nombre_ramo=trim($row_r['RAMO_DESCRIP']); 
      }
      //obtiene nombre abogado
      $sql_ab = "SELECT nombre FROM abogados2 where numrut=".$abog_rut." and digrut='".$abog_dv."'";
      foreach($conn_db->query($sql_ab) as $row_a){
        $nom_abog=trim($row_a['NOMBRE']);  
      }
      //obtiene liquidador-asegurado-fecha denuncia-fecha den siniestro
      $sql_datos="SELECT * FROM maesin where codsin=".$row['CODSIN'];
      foreach($conn_db->query($sql_datos) as $row3){
        $fec_sinies = date("d/m/Y",strtotime($row3["FECHA_OCURR"]));
        $fec_den = date("d/m/Y",strtotime($row3["FECHA_DENUC"]));
        $asegurado_rut=$row3["NUMASE"];
        $asegurado_dv=$row3["DIGASE"];
        $liquidador_rut=$row3["NUMLIQ"];
        $liquidador_dv=$row3["DIGLIQ"];

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
    $contar=0;
    //datos recupero
    $sql2 = "SELECT * FROM php_maeabo_rcpr where rcpr_fecha_recupe between '".$fec_desde."' and '".$fec_hasta."' and codsin=".$row['CODSIN']." and folio_exp=".$row['FOLIO_EXP'];      
    foreach($conn_db->query($sql2) as $row1){
    $contar++;  
    //obtener estado recupero
    $sql_est = "SELECT * FROM estados_php where tipo=48 and codigo=".$row1['RCPR_ESTADO'];
    foreach($conn_db->query($sql_est) as $row_est){
      $est_recupero=trim($row_est['DESCODIGO']);  
    }
    //obtener tercero
    $sql_ter = "SELECT * FROM estados_php where tipo=49 and codigo=".$row1['RCPR_TIPO_TERCERO'];
    foreach($conn_db->query($sql_ter) as $row_ter){
      $tercero=trim($row_est['DESCODIGO']);  
    }
    //obtener estado liquidacion
    $sql_ter = "SELECT * FROM estados_php where tipo=49 and codigo=".$row1['RCPR_TIPO_TERCERO'];
    foreach($conn_db->query($sql_ter) as $row_ter){
      $tercero=trim($row_est['DESCODIGO']);  
    }
    //obtener estado liquidacion
    $sql_el = "SELECT * FROM maeliq where fecproc=(SELECT max(fecproc) as max_fecha FROM maeliq where codsin=".$row['CODSIN'].") and codsin=".$row['CODSIN'];
    $con=0;
    foreach($conn_db->query($sql_el) as $row_el){
      $est_liquid=trim($row_el['FORMA']);
      if($est_liquid=="T"){
        $est_liqui="TOTAL";
      }else{
        $est_liqui="PARCIAL";
      }
      $con++;
    }
    if($con==0){
      $est_liqui="NL";
    }
    //obtener tipo cobro
    $sql_tc = "SELECT * FROM estados_php where tipo=50 and codigo=".$row1['RCPR_TIPO_COBRO'];
    foreach($conn_db->query($sql_tc) as $row_tc){
      $tipo_cobro=trim($row_tc['DESCODIGO']);  
    }
     //obtener compañia culpable
    $sql_com = "SELECT * FROM estados_php where tipo=41 and codigo=".$row1['RCPR_COMPANIA_ID'];
    foreach($conn_db->query($sql_com) as $row_com){
      $compania=trim($row_com['DESCODIGO']);  
    }
      echo "<tr><td>".$nombre_ramo."</td><td>".$row1['FOLIO_EXP']."</td><td>".$row1['CODSIN']."</td>
      <td>".$nom_asegurado."</td><td>".$nom_liquidador."</td><td>".$fec_sinies."</td><td>".$fec_den."</td>
      <td>".$nom_abog."</td><td>".date("d/m/Y", strtotime($row['FECHA_ASIG']))."</td><td>".$est_recupero."</td>
      <td>".$tercero."</td><td>".$est_liqui."</td><td>".$tipo_cobro."</td><td>".$compania."</td>
      <td>".$row1['RCPR_FECHA_COBRO']."</td><td>".$row1['RCPR_FECHA_RECUPE']."</td><td>".$row1['RCPR_MTO_INDEMI']."</td>
      <td>".$row1['RCPR_MONTO_COBRADO']."</td><td>".$row1['RCPR_MTO_RECUPERO']."</td><td>".$row1['RCPR_HONORARIOS']."</td>
      <td>".$row1['RCPR_GASTOS']."</td><td>".$row1['RCPR_OBSERVA']."</td></tr>";  
    }
  } 
 }catch(Exception $e){
      $error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
      $conn_db = null;
      die("false*$error");
}
}elseif($tipo==2){  
?>
<th>RAMO</th>
<th>NUMERO EXPEDIENTE</th>
<th>NUMERO DE SINIESTRO</th>
<th>FECHA SINIESTRO</th>
<th>FECHA DENUNCIA SINIESTRO</th>
<th>ASEGURADO</th>
<th>LIQUIDADOR</th>
<th>FECHA ASIGNACION</th>
<th>NOMBRE ABOGADO</th>
<th>NOMBRE DEMANDANTE</th>
<th>FECHA DEMANDA</th>
<th>TIPO ACUERDO</th>
<th>MONTO DEMANDA</th>
<th>MONTO PAGADO</th>
<th>HONORARIOS</th>
<th>GASTOS</th>
<th>OBSERVACIONES</th>
<?php
try{
  $sql = "SELECT * FROM php_maeabo where abog_numrut=".$abog_rut." and abog_dvrut='".$abog_dv."' and tipo_gestion_id=2";
  foreach($conn_db->query($sql) as $row){
    //obtiene ramo
      $sql_ram = "SELECT ramo_descrip FROM ramosuper where cia_id=1 and ramo_id=".$row['RAMO_ID'];
      foreach($conn->query($sql_ram) as $row_r){
        $nombre_ramo=trim($row_r['RAMO_DESCRIP']); 
      }
      //obtiene nombre abogado
      $sql_ab = "SELECT nombre FROM abogados2 where numrut=".$abog_rut." and digrut='".$abog_dv."'";
      foreach($conn_db->query($sql_ab) as $row_a){
        $nom_abog=trim($row_a['NOMBRE']);  
      }
      //obtiene liquidador-asegurado-fecha denuncia-fecha den siniestro
      $sql_datos="SELECT * FROM maesin where codsin=".$row['CODSIN'];
      foreach($conn_db->query($sql_datos) as $row3){
        $fec_sinies = date("d/m/Y",strtotime($row3["FECHA_OCURR"]));
        $fec_den = date("d/m/Y",strtotime($row3["FECHA_DENUC"]));
        $asegurado_rut=$row3["NUMASE"];
        $asegurado_dv=$row3["DIGASE"];
        $liquidador_rut=$row3["NUMLIQ"];
        $liquidador_dv=$row3["DIGLIQ"];

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
    $contar=0;
    //datos demanda
    $sql2 = "SELECT * FROM php_maeabo_dmd where dmd_fecha_asigna between '".$fec_desde."' and '".$fec_hasta."' and codsin=".$row['CODSIN']." and folio_exp=".$row['FOLIO_EXP'];      
    foreach($conn_db->query($sql2) as $row1){
      $contar++;
      if($row1['DMD_TIPO_ACUERDO']==1){
        $tipo_acu="AVENIMIENTO";
      }
      if($row1['DMD_TIPO_ACUERDO']==2){
        $tipo_acu="SENTENCIA";
      }
      echo "<tr><td>".$nombre_ramo."</td><td>".$row1['FOLIO_EXP']."</td><td>".$row1['CODSIN']."</td>
      <td>".$fec_sinies."</td><td>".$fec_den."</td><td>".$nom_asegurado."</td><td>".$nom_liquidador."</td>
      <td>".date("d/m/Y", strtotime($row['FECHA_ASIG']))."</td><td>".$nom_abog."</td><td>".$row['TERC_NOMBRE']."</td>
      <td>".$row1['DMD_FECHA_DMD']."</td><td>".$tipo_acu."</td><td>".$row1['DMD_MTO_DEMANDA']."</td><td>".$row1['DMD_MTO_PAGADO']."</td>
      <td>".$row1['DMD_HONORARIO']."</td><td>".$row1['DMD_GASTOS']."</td><td>".$row1['DMD_OBSERVA']."</td></tr>";  
    }
  } 
 }catch(Exception $e){
      $error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
      $conn_db = null;
      die("false*$error");
}
}elseif($tipo==3){
?>
<th>RAMO</th>
<th>NUMERO EXPEDIENTE</th>
<th>NUMERO DE SINIESTRO</th>
<th>ASEGURADO</th>
<th>LIQUIDADOR</th>
<th>FECHA SINIESTRO</th>
<th>FECHA DENUNCIA SINIESTRO</th>
<th>NOMBRE ABOGADO</th>
<th>FECHA ASIGNACION</th>
<th>NOMBRE TERCERA COMPAÑIA</th>
<th>SINIESTRO TERCERA COMPAÑIA</th>
<th>FECHA COBRO</th>
<th>FECHA PAGO</th>
<th>MONTO COBRADO</th>
<th>MONTO PAGADO</th>
<th>HONORARIOS</th>
<th>GASTOS</th>
<th>OBSERVACIONES</th>
<?php
try{
  $sql = "SELECT * FROM php_maeabo where abog_numrut=".$abog_rut." and abog_dvrut='".$abog_dv."' and tipo_gestion_id=3";
  foreach($conn_db->query($sql) as $row){
    //obtiene ramo
      $sql_ram = "SELECT ramo_descrip FROM ramosuper where cia_id=1 and ramo_id=".$row['RAMO_ID'];
      foreach($conn->query($sql_ram) as $row_r){
        $nombre_ramo=trim($row_r['RAMO_DESCRIP']); 
      }
      //obtiene nombre abogado
      $sql_ab = "SELECT nombre FROM abogados2 where numrut=".$abog_rut." and digrut='".$abog_dv."'";
      foreach($conn_db->query($sql_ab) as $row_a){
        $nom_abog=trim($row_a['NOMBRE']);  
      }
      //obtiene liquidador-asegurado-fecha denuncia-fecha den siniestro
      $sql_datos="SELECT * FROM maesin where codsin=".$row['CODSIN'];
      foreach($conn_db->query($sql_datos) as $row3){
        $fec_sinies = date("d/m/Y",strtotime($row3["FECHA_OCURR"]));
        $fec_den = date("d/m/Y",strtotime($row3["FECHA_DENUC"]));
        $asegurado_rut=$row3["NUMASE"];
        $asegurado_dv=$row3["DIGASE"];
        $liquidador_rut=$row3["NUMLIQ"];
        $liquidador_dv=$row3["DIGLIQ"];

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
    $contar=0;
    //datos pago entre compañias
    $sql2 = "SELECT * FROM php_maeabo_pec where pec_fecha_cobro between '".$fec_desde."' and '".$fec_hasta."' and codsin=".$row['CODSIN']." and folio_exp=".$row['FOLIO_EXP'];      
    foreach($conn_db->query($sql2) as $row1){
      $contar++;
      if($row1['DMD_TIPO_ACUERDO']==1){
        $tipo_acu="AVENIMIENTO";
      }
      if($row1['DMD_TIPO_ACUERDO']==2){
        $tipo_acu="SENTENCIA";
      }
      //obtener nombre tercera compañia
      $sql_com = "SELECT * FROM estados_php where tipo=41 and codigo=".$row1['PEC_COMPANIA_ID'];
      foreach($conn_db->query($sql_com) as $row_com){
        $compania=trim($row_com['DESCODIGO']);  
      }
      echo "<tr><td>".$nombre_ramo."</td><td>".$row1['FOLIO_EXP']."</td><td>".$row1['CODSIN']."</td>
      <td>".$nom_asegurado."</td><td>".$nom_liquidador."</td><td>".$fec_sinies."</td><td>".$fec_den."</td>
      <td>".$nom_abog."</td><td>".date("d/m/Y", strtotime($row['FECHA_ASIG']))."</td></td><td>".$compania."</td>
      <td>".$row1['SINIE_ID_CIA']."</td><td>".$row1['PEC_FECHA_COBRO']."</td><td>".$row1['PEC_FECHA_PAGO']."</td>
      <td>".$row1['PEC_MTO_COBRADO']."</td><td>".$row1['PEC_MTO_PAGADO']."</td><td>".$row1['PEC_HONORARIO']."</td>
      <td>".$row1['PEC_GASTOS']."</td><td>".$row1['DMD_OBSERVA']."</td></tr>"; 
    }
  } 
 }catch(Exception $e){
      $error = "Error en la grabación código: ".$e->getCode().". Mensaje: ".$e->getMessage();
      $conn_db = null;
      die("false*$error");
}
}
if($contar==0){
  die("NO*NO HAY REGISTROS");
}
?>
</table>
<br>

    

   
        
    


