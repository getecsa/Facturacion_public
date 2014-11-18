<?php 
 error_reporting (0);
?>
        <div class="contenedor">
            <div class="header">
            	<img alt="Movistar" class="logotipo" src="images/logo.png">
                <h1 class="h1_header">
                   Facturación
                </h1>
            
            </div>
                <div class="content">


<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
Selecciona el archivo:
<form name="importa" method="post" action="#" enctype="multipart/form-data" >
<input type="file" name="excel" />
<input type='button' name='enviar'  value="Importar"  onclick="$('body').addClass('loading');document.importa.submit();"/>
<input type="hidden" value="upload" name="action" />
</form>
<div class='modal'></div>
<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

<?php 
extract($_POST);
if ($action == "upload"){
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo	 bak_ 
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "Archivos/bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo '<center><h1 class="h1_header">Archivo Cargado Con Éxito</h1></center>';
	else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
if (file_exists ("Archivos/bak_".$archivo)){ 
/** Clases necesarias */
require_once('pages/PHPExcel.php');
require_once('pages/PHPExcel/Reader/Excel2007.php');

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("Archivos/bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


include("configuracion.php");
$id_area=$_SESSION['area'];
$id_usuario=$_SESSION['uid'];


$query="SELECT *
         FROM flujo_trabajo
         WHERE prioridad=1 AND sub_prioridad=0 AND tipo_documento_id_tipo_doc='1'";
$result=$mysqli->query($query) or die($mysql->error);
$row=$result->fetch_array(MYSQLI_ASSOC);
$area_inicial=$row['area_id_area'];



        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=2;$i<=300;$i++){
	$_DATOS_EXCEL[$i]['num_solicitud'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['tipo_cte'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['comp_fact']= $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['moneda']= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['iva'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['motivo_sol'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['cod_cte'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['razon_soc'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['ley_doc'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['dias_venc'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['salida_extra'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['cod_concepto'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['desc_conc'] = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['cantidad'] = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['prec_unit'] = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['sub_sin_imp'] = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['descuento'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['total_concep'] = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['total_solic'] = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['ley_mat'] = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
	
	if($_DATOS_EXCEL[$i]['num_solicitud'] == '' ){
		//Marca para saber cuando ya no existen registros	
	}
	else {
			if($_DATOS_EXCEL[$i]['num_solicitud']<>$_DATOS_EXCEL[$i-1]['num_solicitud']){
					
					$query="INSERT INTO solicitudes (fecha_solicitud,
                                  area_idarea,
                                  users_id_usuario) 
                          VALUES (now(),
                                  '$id_area',
                                  '$id_usuario')";
					 $result=$mysqli->query($query) or die($mysql->error);
 					 $id_solicitud=$mysqli->insert_id;	
 					 $query1="INSERT INTO `sis_fac`.`documento`(
 					 				id_codigo_cliente,
 					 				dias_vencimiento,
 					 				leyenda_doc,
 					 				compa_fac,
 					 				IVA_idIVA, 
 					 				Moneda_idMoneda,
      							tipo_documento_idtipo_doc, 
      							solicitudes_idSolicitudes, 
      							razon_social, 
      							leyenda_mat, 
      							salida,
									motivos, 
									estado_actual, 
									area_flujo, 
									area_flujo_anterior, 
									prioridad_flujo, 
									subprioridad_flujo, 
									usuario_reserva, 
									reservada, 
									tipo_cliente) 
 					 				VALUES (
 					 				'".$_DATOS_EXCEL[$i]['cod_cte']."', 
 					 				'".$_DATOS_EXCEL[$i]['dias_venc']."',
									'".$_DATOS_EXCEL[$i]['ley_doc']."',
									'".$_DATOS_EXCEL[$i]['comp_fact']."',
									'1', 
									'1',
									'1', 
									'$id_solicitud', 
									'".$_DATOS_EXCEL[$i]['razon_soc']."', 
									'".$_DATOS_EXCEL[$i]['ley_mat']."', 
									'".$_DATOS_EXCEL[$i]['salida_extra']."',
									'".$_DATOS_EXCEL[$i]['motivo_sol']."', 
									'0', 
									'$area_inicial', 
									'$id_area',
                           1,
                           0,
									'$id_usuario',
                           0, 
                           '1'
                           )";

                        $result1=$mysqli->query($query1) or die($mysql->error);
                        $id_documento=$mysqli->insert_id;
                        
                                     $query="INSERT INTO historial_estados (fecha,
                                                   estado_solicitud_idestado_solicitud,
                                                   users_id_usuario,
                                                   area_id_area,
                                                   id_documento) 
                                            VALUES (now(),
                                                    0,
                                                    '$id_usuario',
                                                    '$id_area',
                                                    '$id_documento')";
                                $mysqli->query($query) or die($mysql->error);

							$query="INSERT INTO conceptos_doc (id_codigo_concepto,tx_concepto,fac_unidades,
								fac_precio_uni,fac_descuento,documento_iddocumento) 
								VALUES ('".$_DATOS_EXCEL[$i]['cod_concepto']."','".$_DATOS_EXCEL[$i]['desc_conc']."',
								'".$_DATOS_EXCEL[$i]['cantidad']."',
										'".$_DATOS_EXCEL[$i]['prec_unit']."',
										'".$_DATOS_EXCEL[$i]['descuento']."',
										'".$id_documento."')";
                                        $result2=$mysqli->query($query);
                      
                      $query = "INSERT INTO observaciones( 
                      								observacion,fecha_observacion,users_id_usuario,
 															id_documento,solicitudes_id_solicitudes )
 							VALUES ( '".$_DATOS_EXCEL[$i]['observaciones']."', now(), '$id_usuario', 
 							'$id_documento', '$id_solicitud')";
 							
 							$result3=$mysqli->query($query);
			
			}
			else {
					
					$query="INSERT INTO conceptos_doc (id_codigo_concepto,tx_concepto,fac_unidades,
								fac_precio_uni,fac_descuento,documento_iddocumento) 
								VALUES ('".$_DATOS_EXCEL[$i]['cod_concepto']."','".$_DATOS_EXCEL[$i]['desc_conc']."',
								'".$_DATOS_EXCEL[$i]['cantidad']."',
										'".$_DATOS_EXCEL[$i]['prec_unit']."',
										'".$_DATOS_EXCEL[$i]['descuento']."',
										'".$id_documento."')";
                                        $result2=$mysqli->query($query);
			            
			            $query = "INSERT INTO observaciones( 
                      								observacion,fecha_observacion,users_id_usuario,
 															id_documento,solicitudes_id_solicitudes )
 							VALUES ( '".$_DATOS_EXCEL[$i]['observaciones']."', now(), '$id_usuario', 
 							'$id_documento', '$id_solicitud')";
 							
 							$result3=$mysqli->query($query);
          
          
					
			}
			
			 
}		}
}
//si por algo no cargo el archivo bak_ 
else{echo "Necesitas primero importar el archivo";}
$errores=0;
;


//recorremos el arreglo multidimensional 
//para ir recuperando los datos obtenidos
//del excel e ir insertandolos en la BD


/*	

foreach($_DATOS_EXCEL as $campo => $valor){





	$sql = "INSERT INTO alumnos VALUES ('";
	foreach ($valor as $campo2 => $valor2){
		$campo2 == "sexo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
	}
	$result = mysql_query($sql);
	if (!$result){ echo "Error al insertar registro ".$campo;$errores+=1;}
	
	
}	*/
/////////////////////////////////////////////////////////////////////////

echo "
<script>$('body').removeClass('loading');</script>
";
//una vez terminado el proceso borramos el 
//archivo que esta en el servidor el bak_
unlink($destino);
}

?>
</div>
 
</div>
