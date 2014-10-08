<div id="divNotificacion" />
      <div class="contenedor">
                  <div class="header">
                      <img alt="Movistar" class="logotipo" src="images/logo.png" />
                      <h1>Confirmacion de refactura sin cambio</h1>
                  </div>
          <div class="content">
<?php
 include("config.php");

  if(isset($_POST["submit_pro"])) {    

if( (!isset($_POST["cod_cliente"])) || (!isset($_POST["razon_social"]))  ){

    header('Location: homepage.php?id=refactura_con_cambio_pro');
}

      $array_cont=$_POST["array_cont"];  
      $num_concepto=$_POST['num_concepto'];
      $cod_cliente=$_POST['cod_cliente'];
      $motivo_sol=$_POST['motivo_sol'];
      $leyenda_doc=$_POST['leyenda_doc'];
      $dias_ven=$_POST['dias_ven'];
      $codigo_cliente_afectar=$_POST['codigo_cliente_afectar'];
      $fecha_emision_nc=$_POST['fecha_emision_nc'];
      $moneda=$_POST['moneda'];
      $iva=$_POST["iva"];
      $folio_fac_origen=$_POST['folio_fac_origen'];
      $folio_nc=$_POST['folio_nc'];
      $fecha_emision_fac_or=$_POST['fecha_emision_fac_or'];
      $razon_social=$_POST['razon_social'];
      $entrada=$_POST['entrada'];
      $motivo_nc=$_POST['motivo_nc'];
      $mt_fac_orig=$_POST['mt_fac_orig'];
      $monto_afectar_nc=$_POST['monto_afectar_nc'];
      $importe_total=$_POST['importe_total']; 
      $tipo_cliente=$_POST['tipo_cliente'];
      $tipo_documento=$_POST['tipo_documento'];
      $id_area=$_SESSION['area'];
      $id_usuario=$_SESSION['uid'];


$query="SELECT *
          FROM flujo_trabajo
         WHERE prioridad=1 AND sub_prioridad=0 AND tipo_documento_id_tipo_doc='$tipo_documento'";
$result=$mysqli->query($query);
$row=$result->fetch_array(MYSQLI_ASSOC);
$area_inicial=$row['area_id_area'];

 $query="INSERT INTO solicitudes (fecha_solicitud,reservada,area_idarea,tipo_cliente_idtipo_cliente,users_id_usuario,estado_actual,area_flujo,area_flujo_anterior,prioridad_flujo,subprioridad_flujo) VALUES (now(),0,'".$id_area."','".$tipo_cliente."','".$id_usuario."',0,'".$area_inicial."','".$id_area."',1,0)";
 $result=$mysqli->query($query);
 $id_solicitud=$mysqli->insert_id;


$status = "";
	if ($_POST["action"] == "upload") {
	// obtenemos los datos del archivo 
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
	
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino =  "Archivos/".$id_solicitud.'-'.$archivo;
		if (copy($_FILES['archivo']['tmp_name'],$destino)) {
			$status = "Archivo subido: <b>".$archivo."</b>";
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
	echo $status;

}
		
		
		
if ($archivo != "") 	{
		$ext_archivo = $id_solicitud.'-'.$archivo;
		$query_adjuntos="INSERT INTO adjuntos (nombre, solicitudes_id_solicitudes) VALUE ('$ext_archivo', '$id_solicitud')";
		$result_adjunto = $mysqli->query($query_adjuntos);
}	


      if($result){
        
            $query="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,solicitudes_idSolicitudes,users_id_usuario,area_id_area) VALUES (now(),0,'".$id_solicitud."','".$id_usuario."','".$id_area."')";
            $result0=$mysqli->query($query);

            if($result0){        
                        $query="INSERT INTO documento (id_codigo_cliente,motivos,leyenda_doc,dias_vencimiento,codigo_cliente_afectar,fecha_emision_nc,Moneda_idMoneda,IVA_idIVA,folio_fac_origen,folio_nc,fecha_emision_fac_or,razon_social,entrada,motivo_nc,monto_total_fac_orig,monto_afectar_nc,importe_total,tipo_documento_idtipo_doc,solicitudes_idSolicitudes) VALUES ('".$cod_cliente."','".$motivo_sol."','".$leyenda_doc."','".$dias_ven."','".$codigo_cliente_afectar."','".$fecha_emision_nc."','".$moneda."','".$iva."','".$folio_fac_origen."','".$folio_nc."','".$fecha_emision_fac_or."','".$razon_social."','".$entrada."','".$motivo_nc."','".$mt_fac_orig."','".$monto_afectar_nc."','".$importe_total."','".$tipo_documento."','".$id_solicitud."')";
                        $result1=$mysqli->query($query);
                        $id_documento=$mysqli->insert_id;
                          if($result1){
                            for($i=1;$i<=$num_concepto;$i++){
                              $id_concepto=$array_cont[$i][0];
                              $tx_concepto=$array_cont[$i][1];
                              $fac_unidades=$array_cont[$i][2];
                              $fac_precio_uni=$array_cont[$i][3];
                              $fac_descuento=$array_cont[$i][5];

                                        $query="INSERT INTO conceptos_doc (id_codigo_concepto,tx_concepto,fac_unidades,fac_precio_uni,fac_descuento,documento_iddocumento) VALUES ('".$id_concepto."','".$tx_concepto."','".$fac_unidades."','".$fac_precio_uni."','".$fac_descuento."','".$id_documento."')";
                                        $result2=$mysqli->query($query);
                                             if($result2){
                                                if($num_concepto==$i){
                                                  header('Location: homepage.php?id=solicitante');
                                                }
                                             }
                                             else{
                                              echo "no guardado" . $mysqli->error;
                                             }
                              }



                          } else{
                           echo "Error: No guardado 2" . $mysqli->error;
                          }               
                      

                    } else {
                      echo "Error: No guardado 1" . $mysqli->error;
                    }
            } else{
              echo "Error: No guardado 0" . $mysqli->error;
            }

      }

	if(isset($_POST["submit"])) {
      	
      $array_cont=$_POST["add_cont"];  
      $num_concepto=$_POST['num_concepto'];

      if($_POST['return']==1){
      $num_return=$_POST['num_return'];
      $num_concepto=$num_concepto+$num_return-1;
       }
      
      $cod_cliente=$_POST['cod_cliente'];
      $motivo_sol=$_POST['motivo_sol'];
      $leyenda_doc=$_POST['leyenda_doc'];
      $dias_ven=$_POST['dias_ven'];
      $codigo_cliente_afectar=$_POST['codigo_cliente_afectar'];
      $fecha_emision_nc=$_POST['fecha_emision_nc'];
      $moneda=$_POST['moneda'];
      $iva=$_POST["iva"];
      $folio_fac_origen=$_POST['folio_fac_origen'];
      $folio_nc=$_POST['folio_nc'];
      $fecha_emision_fac_or=$_POST['fecha_emision_fac_or'];
      $razon_social=$_POST['razon_social'];
      $entrada=$_POST['entrada'];
      $motivo_nc=$_POST['motivo_nc'];
      $mt_fac_orig=$_POST['mt_fac_orig'];
      $monto_afectar_nc=$_POST['monto_afectar_nc'];
      $importe_total=$_POST['importe_total']; 
      $tipo_cliente=$_POST['tipo_cliente'];
      $tipo_documento=$_POST['tipo_documento'];

?>
  <form class="formulario_n" action="#" method="post" id="nueva_refactura_sc" enctype="multipart/form-data">
                    <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><p><?php echo $_POST['cod_cliente'];?></p>
                        <label for="motivo_sol">Motivo de solicitud:</label><p><?php echo $_POST['motivo_sol'];?></p>
                        <label for="leyenda_doc">Leyenda del documento:</label><p><?php echo $_POST['leyenda_doc'];?></p>
                        <label for="dias_ven">Dias de vencimiento:</label><p><?php echo $_POST['dias_ven'];?></p>
                        <label for="codigo_cliente_afectar">Codigo C.(Fac. Afectar):</label><p><?php echo $_POST['codigo_cliente_afectar'];?></p>
                        <label for="fecha_emision_nc">Fecha Emision NC:</label><p><?php echo $_POST['fecha_emision_nc'];?></p>
                      </div>  
                      <div class="column bottom_nc">
                      <label for="moneda">Moneda:</label>
                        <?php 
                            $sql_moneda="select * from moneda where id_moneda=$moneda";
                            $result_moneda=mysql_db_query($db, $sql_moneda,$link);
                            if($row=mysql_fetch_array($result_moneda)){
                            echo "<p>",$row['moneda'],"</p>";
                              }
                          ?>
                      <label for="iva">IVA:</label>
                        <?php 
                            $sql_iva="select * from iva where id_iva=$iva";
                            $result_iva=mysql_db_query($db, $sql_iva,$link);
                            if($row=mysql_fetch_array($result_iva)){
                            $id_iva=$row['id_iva'];
                            echo "<p>",$row['valor_tx'],"</p>";
                              }
                          ?>
                      <label for="folio_fac_origen">Folio factura origen:</label><p><?php echo $_POST['folio_fac_origen'];?></p>
                      <label for="folio_nc">Folio NC:</label><p><?php echo $_POST['folio_nc'];?></p>
                      <label for="fecha_emision_nc2">Fecha Emision Fac. Origen:</label><p><?php echo $_POST['fecha_emision_fac_or'];?></p>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><p><?php echo $_POST['razon_social'];?></p>
                        <label for="entrada">Entrada:</label><p><?php echo $_POST['entrada'];?></p>
                        <label for="motivo_nc">Motivo NC:</label><p><?php echo $_POST['motivo_nc'];?></p>
                        <label for="mt_fac_orig">Monto Total (Fac Origen):</label><p><?php echo $_POST['mt_fac_orig'];?></p>
                        <label for="monto_afectar_nc">Monto Afectar con NC:</label><p><?php echo $_POST['monto_afectar_nc'];?></p>
                        <label for="importe_total">Importe total:</label><p><?php echo $_POST['importe_total'];?></p>
                        
                      </div>
                    
  <div id="detalles_factura">
  <table class="gridview" id="agregar_detalle">
    <tr>
      <td>Codigo Concepto</td>
      <td>Descripcion Concepto</td>
      <td>Unidades</td>
      <td>Precio Unitario</td>
      <td>Cargo</td>
      <td>Descuento</td>
      <td>Subtotal</td>
    </tr>
    <?php
    $subtotal=0;
    for($i=1;$i<=$num_concepto;$i++){
    $subtotal=$subtotal+$array_cont[$i][6];
    ?>
    <tr class="add_factura">
      <td><?php echo $array_cont[$i][0]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>" /></td>
      <td><?php echo $array_cont[$i][1]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" />
      </td>
      <td><?php echo $array_cont[$i][2]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][2]" value="<?php echo $array_cont[$i][2]; ?>" />
      </td>
      <td><?php echo $array_cont[$i][3]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][3]" value="<?php echo $array_cont[$i][3]; ?>" />
      </td>
      <td><?php echo $array_cont[$i][4]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][4]" value="<?php echo $array_cont[$i][4]; ?>" />
      </td>
      <td><?php echo $array_cont[$i][5]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][5]" value="<?php echo $array_cont[$i][5]; ?>" />
      </td>
      <td><?php echo $array_cont[$i][6]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][6]" value="<?php echo $array_cont[$i][6]; ?>" />
      </td>
    </tr>
    <?php } ?>
    </table>
    <table class="gridview">
   <table class="gridview">
    <tr>
    <td colspan="3">
    
    
    <div class="custom-input-file botones">
    <input type="file" class="input-file" name="archivo" />
Adjuntar Archivos
    <div class="archivo">...</div>
    <input name="action" type="hidden" value="upload" /> 
</div>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr> 
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>SubTotal:</td>
    <td></td>
    <td></td>
    <td class="total_subtotal"><?php echo $subtotal; ?></td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IVA:</td>
    <td></td>
    <td></td>
    <td><?php
    $sql="select * from iva where id_iva=$iva";
    $result=mysql_db_query($db,$sql,$link);
    $row=mysql_fetch_array($result);
    $iva=$row['valor_int']*$subtotal;
    echo $iva; ?></td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IEPS:</td>
    <td></td>
    <td></td>
    <td>$0</td>
   </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>Total:</td>
    <td></td>
    <td></td>
    <td><?php echo $iva+$subtotal; ?></td>
   </tr>
  </table> 
        </fieldset>
                   <div class="boton_envio">    


    <input  type="hidden" id="num_concepto" name="num_concepto" value="<?php echo $num_concepto; ?>">                  
    <input  type="hidden" id="cod_cliente" name="cod_cliente" value="<?php echo $cod_cliente; ?>"> 
    <input  type="hidden" id="motivo_sol" name="motivo_sol" value="<?php echo $motivo_sol; ?>">    
    <input  type="hidden" id="leyenda_doc" name="leyenda_doc" value="<?php echo $leyenda_doc; ?>"> 
    <input  type="hidden" id="dias_ven" name="dias_ven" value="<?php echo $dias_ven; ?>">  
    <input  type="hidden" id="codigo_cliente_afectar" name="codigo_cliente_afectar" value="<?php echo $codigo_cliente_afectar; ?>">                  
    <input  type="hidden" id="fecha_emision_nc" name="fecha_emision_nc" value="<?php echo $fecha_emision_nc; ?>">                 
    <input  type="hidden" id="moneda" name="moneda" value="<?php echo $moneda; ?>">  
    <input  type="hidden" id="iva" name="iva" value="<?php echo $id_iva; ?>">   
    <input  type="hidden" id="folio_fac_origen" name="folio_fac_origen" value="<?php echo $folio_fac_origen; ?>"> 
    <input  type="hidden" id="folio_nc" name="folio_nc" value="<?php echo $folio_nc; ?>">  
    <input  type="hidden" id="fecha_emision_fac_or" name="fecha_emision_fac_or" value="<?php echo $fecha_emision_fac_or; ?>">  
    <input  type="hidden" id="razon_social" name="razon_social" value="<?php echo $razon_social; ?>">   
    <input  type="hidden" id="entrada" name="entrada" value="<?php echo $entrada; ?>">
    <input  type="hidden" id="motivo_nc" name="motivo_nc" value="<?php echo $motivo_nc; ?>">
    <input  type="hidden" id="mt_fac_orig" name="mt_fac_orig" value="<?php echo $mt_fac_orig; ?>">           
    <input  type="hidden" id="monto_afectar_nc" name="monto_afectar_nc" value="<?php echo $monto_afectar_nc; ?>">
    <input  type="hidden" id="importe_total" name="importe_total" value="<?php echo $importe_total; ?>">                
    <input  type="hidden" id="tipo_cliente" name="tipo_cliente" value="<?php echo $tipo_cliente; ?>">                  
    <input  type="hidden" id="tipo_documento" name="tipo_documento" value="<?php echo $tipo_documento; ?>">                 
                  
                 
                       <input type="submit" id="submit" name="submit_pro" value="Enviar" >
                       <input type="submit" value="Regresar" name="submit_return" id="submit_return_re_sc" >
                  </div>

        </form>
<?php } ?>
          </div>
        </div>
 </div>   