<div id="divNotificacion" />
      <div class="contenedor">
                  <div class="header">
                      <img alt="Movistar" class="logotipo" src="images/logo.png" />
                      <h1>Validación Factura</h1>
                  </div>
          <div class="content">
<?php
 include("configuracion.php");
    $area_operador=$_SESSION['area'];

  if(isset($_POST["submit"])) {    

    $estado_actual=$_POST["estado_actual"];
    $area_flujo=$_POST["area_flujo"];
    $id_documento=$_POST["id_documento"];
    $id_solicitud=$_POST["id_solicitud"];    
    $observaciones=$_POST["observaciones"];
    $id_usuario=$_SESSION['uid'];

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

            }            
                
            if ($archivo != "")   {
                $ext_archivo = $id_solicitud.'-'.$archivo;
                $query_adjuntos="INSERT INTO adjuntos (nombre, id_documento,id_usuario,area) VALUE ('$ext_archivo', '$id_documento','$id_usuario','$area_flujo')";
                //$query_adjuntos="INSERT INTO adjuntos (nombre, solicitudes_id_solicitudes,id_usuario,area) VALUE ('$ext_archivo', '$id_solicitud','$id_usuario','$area_flujo')";
                $result_adjunto = $mysqli->query($query_adjuntos);
            }   





    // Acciones por tipo de area
        if ($area_flujo==2){
          
        if(!isset($_POST['oper_plataforma'])){$_POST['oper_plataforma']="";}
        if(!isset($_POST['oper_oficina'])){$_POST['oper_oficina']="";}
        if(!isset($_POST['oper_clase'])){$_POST['oper_clase']="";}
        if(!isset($_POST['oper_canal'])){$_POST['oper_canal']="";}
        if(!isset($_POST['oper_sector'])){$_POST['oper_sector']="";}
        if(!isset($_POST['oper_tipo'])){$_POST['oper_tipo']="";}
        if(!isset($_POST['oper_numero'])){$_POST['oper_numero']="";}
        if(!isset($_POST['clasificacion'])){$_POST['clasificacion']="";}
        
           $justificacion=$_POST["justificacion"];
           $clasificacion=$_POST["clasificacion"];
           $oper1=$_POST["oper_plataforma"];
           $oper2=$_POST["oper_oficina"];
           $oper3=$_POST["oper_clase"];
           $oper4=$_POST["oper_canal"];
           $oper5=$_POST["oper_sector"];
           $oper6=$_POST["oper_tipo"];
           $oper7=$_POST["oper_numero"];
           $dias_ven=$_POST["dias_ven"];
           $iva=$_POST["iva"];
           $leyenda_mat=$_POST["leyenda_mat"];
           $compa_fac=$_POST["compa_fac"];
           $moneda=$_POST["moneda"];
           $salida=$_POST["salida"];
           $generar_nota=$_POST["generar_nota"];


        }

        if ($area_flujo==5){
          
        if(!isset($_POST['clasificacion'])){$_POST['clasificacion']="";}
        if(!isset($_POST['proceso'])){$_POST['proceso']="";}
        if(!isset($_POST['numero_folio'])){$_POST['numero_folio']="";}

        
           $justificacion=$_POST["justificacion"];
           $clasificacion=$_POST["clasificacion"];
           $proceso=$_POST["proceso"];
           $numero_folio=$_POST["numero_folio"];

        }

       if ($area_flujo==6){
              
              
        }


// Liberado o finalizado

          if (($estado_actual=="3") || ($estado_actual=="7") ){




            $sql="SELECT prioridad_flujo, area_flujo, tipo_documento_idtipo_doc as tipo_documento
                    FROM documento 
                   WHERE id_documento='$id_documento'";
            $result=$mysqli->query($sql);
            $row=$result->fetch_array(MYSQLI_ASSOC);
            $tipo_documento=$row['tipo_documento'];
            $prioridad=$row['prioridad_flujo']+1;

            $query1="SELECT area_id_area
                      FROM flujo_trabajo
                     WHERE tipo_documento_id_tipo_doc='$tipo_documento' AND prioridad='$prioridad' LIMIT 1";
            $result1=$mysqli->query($query1);
            $row1=$result1->fetch_array(MYSQLI_ASSOC);
            $area_inicial=$row1['area_id_area'];
            $cont = $result1->num_rows;
              
              if($cont==0){

                    $sql="UPDATE documento
                         SET reservada='1', estado_actual='7',area_flujo='$area_flujo',area_flujo_anterior='$area_flujo',prioridad_flujo='$prioridad',usuario_reserva='$id_usuario'
                       WHERE id_documento='$id_documento'";
                    $result=$mysqli->query($sql); 
                      if($result){
                         header('Location: homepage.php?id=operador');
                                } else {
                        echo "Error: No guardado 0" . $mysqli->error;
                                            }
                    $estado_actual=7;
                } else {

              //if especial gestion flujo
                              if ($area_flujo==2){
                                  $sql="UPDATE documento
                                           SET oper_plataforma='$oper1',oper_oficina='$oper2',oper_clase='$oper3',oper_canal='$oper4',oper_sector='$oper5',oper_tipo='$oper6',oper_numero='$oper7', fac_clasificacion='$clasificacion', dias_vencimiento='$dias_ven', IVA_idIVA='$iva',leyenda_mat='$leyenda_mat', compa_fac='$compa_fac',Moneda_idMoneda='$moneda', salida='$salida'
                                         WHERE id_documento='$id_documento'";       
                                  $result=$mysqli->query($sql); 

                                 /*
                                      //generacion de nota de credito

                                      if($generar_nota==1)
                                      {
                                        include("scripts/funciones.php");
                                        $resultado=mysql_clonar_registro("documento",$id_documento);
                                        $sql="UPDATE documento
                                                 SET tipo_documento_idtipo_doc='2'
                                               WHERE id_documento='$resultado'";
                                        $result=$mysqli->query($sql);       
                                        echo $resultado;
                                      }
                                  */


                                }

                              if ($area_flujo==5){
                                  $sql="UPDATE documento
                                           SET fac_proceso='$proceso', fac_numero_folio='$numero_folio'
                                         WHERE id_documento='$id_documento'";       
                                  $result=$mysqli->query($sql); 
                                }          


                              $sql="UPDATE documento
                                       SET reservada='0', estado_actual='0',area_flujo='$area_inicial',area_flujo_anterior='$area_flujo',prioridad_flujo='$prioridad',usuario_reserva=''
                                     WHERE id_documento='$id_documento'";       

                              $result=$mysqli->query($sql); 

      }
              $justificacion=trim($justificacion);
              $observaciones=trim($observaciones);
                               if(!empty($justificacion)) {
                                  $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                                  $result=$mysqli->query($query);
                                }

                               if(!empty($observaciones)) {
                                   $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes) VALUES ('$observaciones',now(),'$id_usuario','$id_documento','$id_solicitud')";
                                   $result=$mysqli->query($query);
                                }

                                  if($result){
                                    
                                        $query="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,users_id_usuario,area_id_area,id_documento) VALUES (now(),'$estado_actual','$id_usuario','$area_flujo','$id_documento')";
                                        $result0=$mysqli->query($query);

                                                 if($result0){
                                                 header('Location: homepage.php?id=operador');
                                                  echo "entro a if de liberado";
                                                      } else {
                                                        echo "Error: No guardado 0" . $mysqli->error;
                                                      }
                                                

                                        } else{
                                          echo "Error: No guardado" . $mysqli->error;
                                        }
                                   }

      

// Analisis, insidencia en sistema, gestion terceros
          if (($estado_actual=="2") || ($estado_actual=="5") || ($estado_actual=="6")){

                          if ($area_flujo==1){
                            echo "direccionamiento";
                            }

                          if ($area_flujo==2){
                              $sql="UPDATE documento
                                       SET oper_plataforma='$oper1',oper_oficina='$oper2',oper_clase='$oper3',oper_canal='$oper4',oper_sector='$oper5',oper_tipo='$oper6',oper_numero='$oper7', fac_clasificacion='$clasificacion', dias_vencimiento='$dias_ven', IVA_idIVA='$iva',leyenda_mat='$leyenda_mat', compa_fac='$compa_fac',Moneda_idMoneda='$moneda', salida='$salida'
                                     WHERE id_documento='$id_documento'";       
                              $result=$mysqli->query($sql); 
                            }

                          if ($area_flujo==5){
                              $sql="UPDATE documento
                                       SET fac_proceso='$proceso', fac_numero_folio='$numero_folio'
                                     WHERE id_documento='$id_documento'";       
                              $result=$mysqli->query($sql); 
                            }          

                          if ($area_flujo==6){
                            echo "Entrega documentos";
                            }

                      $sql="UPDATE documento
                               SET  estado_actual='$estado_actual'
                             WHERE id_documento='$id_documento'";       

                      $result=$mysqli->query($sql);
              $justificacion=trim($justificacion);
              $observaciones=trim($observaciones);
                     if(!empty($justificacion)) {
                        $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                        $result=$mysqli->query($query);
                      }

                     if(!empty($observaciones)) {
                         $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes) VALUES ('$observaciones',now(),'$id_usuario','$id_documento','$id_solicitud')";
                         $result=$mysqli->query($query);
                      }

                              if($result){
                                
                                    $query="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,users_id_usuario,area_id_area,id_documento) VALUES (now(),'$estado_actual','$id_usuario','$area_flujo','$id_documento')";
                                    $result0=$mysqli->query($query);

                                             if($result0){
                                              header('Location: homepage.php?id=operador');
                                              echo "entro a if de analisis";
                                                  } else {
                                                    echo "Error: No guardado 0" . $mysqli->error;
                                                  }
                                            

                                    } else{
                                      echo "Error: No guardado" . $mysqli->error;
                                    }

          }        

// rechazado
            if ($estado_actual=="4"){

                          if ($area_flujo==1){
                            echo "direccionamiento";
									//Query Daniel Irineo Rechazo, se quedá igual a como se venia trabajando	                              
                           	$sql="UPDATE documento
                              			SET  estado_actual='$estado_actual'
                             			 WHERE id_documento='$id_documento'";       
					
                     		 $result=$mysqli->query($sql); 
                            
                            }

                          if ($area_flujo==2){
                              $sql="UPDATE documento
                                       SET oper_plataforma='$oper1',oper_oficina='$oper2',oper_clase='$oper3',oper_canal='$oper4',oper_sector='$oper5',oper_tipo='$oper6',oper_numero='$oper7', fac_clasificacion='$clasificacion', dias_vencimiento='$dias_ven', IVA_idIVA='$iva',leyenda_mat='$leyenda_mat', compa_fac='$compa_fac',Moneda_idMoneda='$moneda', salida='$salida'
                                     WHERE id_documento='$id_documento'";       
                              $result=$mysqli->query($sql); 
									//Query Daniel Irineo Rechazo		                              
                           	$sql="UPDATE documento
                              			SET  estado_actual='0', area_flujo = '1', area_flujo_anterior = '20', prioridad_flujo = '1', usuario_reserva = '1', reservada = '0'
                             			WHERE id_documento='$id_documento'";       
					
                     		 $result=$mysqli->query($sql); 
                            }

                          if ($area_flujo==5){
                              $sql="UPDATE documento
                                       SET fac_proceso='$proceso', fac_numero_folio='$numero_folio'
                                     WHERE id_documento='$id_documento'";       
                              $result=$mysqli->query($sql); 
									//Query Daniel Irineo Rechazo		                              
                           	$sql="UPDATE documento
                              			SET  estado_actual='0', area_flujo = '2', area_flujo_anterior = '1', prioridad_flujo = '2', usuario_reserva = '0', reservada = '0'
                             			WHERE id_documento='$id_documento'";       
					
                     		 $result=$mysqli->query($sql);                              
                              
                              
                              
                            }          

                          if ($area_flujo==6){
                            echo "Entrega documentos";
                            
												//Query Daniel Irineo Rechazo		                              
                           	$sql="UPDATE documento
                              			SET  estado_actual='0', area_flujo = '5', area_flujo_anterior = '2', prioridad_flujo = '3', usuario_reserva = '0', reservada = '0'
                             			WHERE id_documento='$id_documento'";       
					
                     		 $result=$mysqli->query($sql);                              
                                               
                            
                            
                            }

					/* Query Daniel 				
                      $sql="UPDATE documento
                               SET  estado_actual='$estado_actual'
                             WHERE id_documento='$id_documento'";       
					
                      $result=$mysqli->query($sql); 
             */

                $justificacion=trim($justificacion);
                $observaciones=trim($observaciones);
                     if(!empty($justificacion)) {
                        $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                        $result=$mysqli->query($query);
                      }

                     if(!empty($observaciones)) {
                         $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes) VALUES ('$observaciones',now(),'$id_usuario','$id_documento','$id_solicitud')";
                         $result=$mysqli->query($query);
                      }

                              if($result){
                                
                                    $query="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,id_documento,users_id_usuario,area_id_area) VALUES (now(),'$estado_actual','$id_documento','$id_usuario','$area_flujo')";
                                    $result0=$mysqli->query($query);

                                             if($result0){
                                              header('Location: homepage.php?id=operador');
                                              echo "entro a if de analisis";
                                                  } else {
                                                    echo "Error: No guardado 0" . $mysqli->error;
                                                  }
                                            

                                    } else{
                                      echo "Error: No guardado" . $mysqli->error;
                                    }

          }        








}


  if(isset($_POST["valor_solicitud"])) {
  
  $id_solicitud=$_POST["valor_solicitud"];
  $id_documento=$_POST["id_documento"];

  $sql="SELECT *
          FROM documento do
    INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes 
         WHERE solicitudes_idSolicitudes='$id_solicitud' AND id_documento='$id_documento'";
  $result=$mysqli->query($sql);
  $row=$result->fetch_array(MYSQLI_ASSOC);

  $area_flujo=$row['area_flujo'];
  $cod_cliente=$row['id_codigo_cliente'];
  $motivo_sol=$row['motivos'];
  $dias_ven=$row['dias_vencimiento'];
  $leyenda_doc=$row['leyenda_doc'];
  $iva=$row["IVA_idIVA"];
  $leyenda_mat=$row['leyenda_mat'];
  $razon_social=$row['razon_social'];
  $compa_fac=$row['compa_fac'];
  $moneda=$row['Moneda_idMoneda'];
  $salida=$row['salida'];
  $tipo_cliente=$row['tipo_cliente'];
  $tipo_documento=$row['tipo_documento_idtipo_doc'];

  $sql="SELECT *
          FROM conceptos_doc
         WHERE documento_iddocumento='$id_documento'";
         $result=$mysqli->query($sql);
         $num_concepto = $result->num_rows;
         $b=1;
         while ($row=$result->fetch_array(MYSQLI_ASSOC)){
          $array_cont[$b][0]=$row['id_codigo_concepto'];
          $array_cont[$b][1]=$row['tx_concepto'];
          $array_cont[$b][2]=$row['fac_unidades'];
          $array_cont[$b][3]=$row['fac_precio_uni'];
          $array_cont[$b][4]=$row['fac_unidades']*$row['fac_precio_uni'];
          $array_cont[$b][5]=$row['fac_descuento'];
          $array_cont[$b][6]=($row['fac_unidades']*$row['fac_precio_uni'])-$row['fac_descuento'];
          $b++;
         }

?>
<?php
$sql_iva="select * from iva";
$result_iva=$mysqli->query($sql_iva);

$sql_moneda="select * from moneda";
$result_moneda=$mysqli->query($sql_moneda);

?>
  <form class="formulario_n" action="#" method="post" enctype="multipart/form-data">
                    <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><p><?php echo $cod_cliente;?></p>
                        <label for="motivo_sol">Motivo de solicitud:</label><p><?php echo $motivo_sol;?></p>
                        <label for="dias_ven">Días de vencimiento:</label><p><?php if ($area_flujo==2){?><input type="text" name="dias_ven" id="dias_ven" value="<?php echo $dias_ven; ?>" /> <?php } else { echo $dias_ven; }?></p>
                        <label for="leyenda_doc">Leyenda del documento:</label><p><?php echo $leyenda_doc;?></p>
                      </div>  
                      <div class="column bottom">   
                      <label for="iva">IVA:</label>
                          <?php
                               if ($area_operador==2){
                             ?>
                      <select id="iva" name="iva">
                          <option value="0">Seleccione IVA</option>
                      <?php 
                            while($row=$result_iva->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='",$row['id_iva'],"'";
                                if($row['id_iva']==$iva)
                                  {
                                    echo"selected";
                                  }
                            echo ">",$row['valor_tx'],"</option>";
                              }
                          ?>
                      </select>

                        <?php 
                      } else {
                            $sql_iva="select * from iva where id_iva=$iva";
                            $result_iva=$mysqli->query($sql_iva);
                            if($row=$result_iva->fetch_array(MYSQLI_ASSOC)){
                            $id_iva=$row['id_iva'];
                            echo "<p>",$row['valor_tx'],"</p>";
                              }
                          }
                          ?>
                         
                    <label for="leyenda_mat">Leyenda Material:</label><p><?php if ($area_flujo==2){?><input type="text" name="leyenda_mat" id="leyenda_mat" value="<?php echo $leyenda_mat; ?>" /> <?php } else { echo $leyenda_mat; }?></p>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><p><?php echo $razon_social;?></p>
                        <label for="compa_fac">Compañia facturadora:</label><p><?php if ($area_flujo==2){?><input type="text" name="compa_fac" id="compa_fac" value="<?php echo $compa_fac; ?>" /> <?php } else { echo $compa_fac; }?></p>
                        <label for="moneda">Moneda:</label>
                            <?php
                               if ($area_operador==2){
                             ?>
                          <select name="moneda">
                          <option value="0">Seleccione Moneda</option>
                          <?php 
                            while($row=$result_moneda->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='",$row['id_moneda'],"'";
                                if($row['id_moneda']==$moneda)
                                  {
                                    echo"selected";
                                } 
                            echo ">",$row['moneda'],"</option>";
                              }
                          ?>
                        </select>
                        <?php 
                         } else {
                                $sql_moneda="select * from moneda where id_moneda=$moneda";
                                $result_moneda=$mysqli->query($sql_moneda);
                                if($row=$result_moneda->fetch_array(MYSQLI_ASSOC)){
                                echo "<p>",$row['moneda'],"</p>";
                                  }
                             }     
                          ?>
                        

                        <label for="salida">Salida:</label><p><?php if ($area_flujo==2){?><input type="text" name="salida" id="salida" value="<?php echo $salida; ?>" /> <?php } else { echo $salida; }?></p>
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
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" name="array_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][0]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>" /></td>
      <?php } ?>
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" name="array_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" /> 
      <?php }  else{ ?>
      <?php echo $array_cont[$i][1]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" />
      <?php } ?>
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
    <tr>
    <td colspan="7" ><br></td>           
    </tr>
    <tr>
    <td></td>
    <td colspan="4" rowspan="6">
    </td>   
    <td>SubTotal:</td>
    <td class="total_subtotal"><?php echo $subtotal; ?></td>
   </tr>   
<tr>
    <td colspan="5" >&nbsp;</td>
    <td>IVA:</td>
    <td><?php
    $sql="select * from iva where id_iva=$iva";
    $result=$mysqli->query($sql);
    $row=$result->fetch_array(MYSQLI_ASSOC);
    $iva=$row['valor_int']*$subtotal;
    echo $iva; ?></td>
   </tr>   
    <tr>
    <td colspan="5">&nbsp;</td>
    <td>IEPS:</td>
    <td>$0</td>
   </tr>
   <tr>
    <td colspan="5">&nbsp;</td>
    <td>Total:</td>
    <td><?php echo $iva+$subtotal; ?></td>
   </tr>
    </table>        
    <?php
       if ($area_operador==2){
     ?>
      <br>
    <table class="gridview" class="formulario_operador">
    <tr bgcolor="#00517A">
    <td><font color="#ffffff">PLATAFORMA</font></td>
    <td><font color="#ffffff">OFICINA,SOCIEDAD,REFERENCIA SAP,SUCURSAL,PROGRAMACION</font></td>
    <td><font color="#ffffff">CLASE DE PEDIDO, FOLIO FISCAL NC, UNIDAD DE MEDIDA</font></td>
    <td><font color="#ffffff">CANAL, PEFIJO-SERIE</font></td>
    <td><font color="#ffffff">SECTOR, METODO DE PAGO</font></td>
    <td><font color="#ffffff">TIPO DE CAMBIO</font></td>
    <td><font color="#ffffff">NUMERO DE CUENTA DE PAGO</font></td>
    </tr>
    <tr>
      <td><input type="text" size="10" name="oper_plataforma"></td>
      <td><input type="text" size="25" name="oper_oficina"></td>
      <td><input type="text" size="25" name="oper_clase"></td>
      <td><input type="text" size="10" name="oper_canal"></td>
      <td><input type="text" size="10" name="oper_sector"></td>
      <td><input type="text" size="10" name="oper_tipo"></td>
      <td><input type="text" size="10" name="oper_numero"></td>
    </tr>
    </table>
    <?php } ?>
    
     <?php
       if (($area_operador==5) || ($area_operador==6)) {
     ?>
      <br>
    <table class="gridview" class="formulario_operador">
    <tr bgcolor="#00517A">
    <td><font color="#ffffff">PLATAFORMA</font></td>
    <td><font color="#ffffff">OFICINA,SOCIEDAD,REFERENCIA SAP,SUCURSAL,PROGRAMACION</font></td>
    <td><font color="#ffffff">CLASE DE PEDIDO, FOLIO FISCAL NC, UNIDAD DE MEDIDA</font></td>
    <td><font color="#ffffff">CANAL, PEFIJO-SERIE</font></td>
    <td><font color="#ffffff">SECTOR, METODO DE PAGO</font></td>
    <td><font color="#ffffff">TIPO DE CAMBIO</font></td>
    <td><font color="#ffffff">NUMERO DE CUENTA DE PAGO</font></td>
    </tr>
    <tr>
      <?php 
        $sql="SELECT *
                FROM documento
               WHERE id_documento='$id_documento'";
        $result=$mysqli->query($sql);
        $row=$result->fetch_array(MYSQLI_ASSOC);       
        $clasificacion=$row['fac_clasificacion'];
      ?>
      <td><?php echo $row['oper_plataforma'];?></td>
      <td><?php echo $row['oper_oficina'];?></td>
      <td><?php echo $row['oper_clase'];?></td>
      <td><?php echo $row['oper_canal'];?></td>
      <td><?php echo $row['oper_sector'];?></td>
      <td><?php echo $row['oper_tipo'];?></td>
      <td><?php echo $row['oper_numero'];?></td>
    </tr>
    </table>
    <?php } ?>


      <div class="funciones_operador">
        <div class="observaciones">
          <p>Observaciones:</p><textarea name="observaciones" COLS=40 ROWS=3></textarea>
        </div>

        <div class="estado">


       <?php
          if ($area_operador==2){
        ?>
      <div class="funciones_operador">
     <!-- <div>Generar Nota de credito: <input type="checkbox" name="generar_nota" value="1" /></div> -->
      <div>Clasificacion: <input type="text" name="clasificacion"></div>
      </div>

      <?php } ?>

      <span>Estado:</span>
               <select name="estado_actual">
              <option value='...'>---</option> 
              <?php
               $id_area=$_SESSION['area'];
                $sql_per="SELECT pe.id_estado_solicitud, es.estado_sol
                        FROM permisos pe
                  INNER JOIN estado_solicitud es ON pe.id_estado_solicitud=es.id_estado_solicitud 
                       WHERE permiso=1 AND id_area='$id_area' AND es.id_estado_solicitud!='0' AND es.id_estado_solicitud!='1'";

                  $result=$mysqli->query($sql_per);
                  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
              ?>
                <option value='<?php echo $row['id_estado_solicitud']; ?>'><?php echo $row['estado_sol']; ?></option> 
                                      
              <?php } ?>
                                  
              </select>

        </div>
      
        <?php
          if (($area_operador!=1) AND ($area_operador!=6) ){
        ?>
        <div class="justificacion">
          <p>Justificacion:</p><textarea name="justificacion" COLS=40 ROWS=3></textarea>
        </div>
        <?php 
          }
         if ($area_operador==6){
        ?>
            
          <?php } ?>
      </div>
        <?php
          if ($area_operador==5){
        ?>
      <div class="funciones_operador">
      <div>Clasificacion: <?php echo $clasificacion; ?></div>
      <div>Proceso: <input type="text" name="proceso"></div>
      <div>Numero de Folio: <input type="text" name="numero_folio"></div>
      </div>
      <?php } ?>
        
       <?php
          if ($area_operador==6){
                $sql="SELECT *
                FROM documento
               WHERE solicitudes_idSolicitudes='$id_solicitud'";
              $result=$mysqli->query($sql);
              $row=$result->fetch_array(MYSQLI_ASSOC);  
        ?>
      <div class="funciones_operador">
      <div>Clasificacion: <?php echo $row['fac_clasificacion'];?></div>
      <div>Proceso: <?php echo $row['fac_proceso'];?></div>
      <div>Numero de Folio: <?php echo $row['fac_numero_folio'];?></div>
      </div>
      <?php } ?>     

 <div class="custom-input-file botones">
            <input type="file" class="input-file" name="archivo" />
            Adjuntar Archivos
            <div class="archivo">...</div>
            <input name="action" type="hidden" value="upload" /> 
            </div>
        </fieldset>
<?php
               echo 'Descargar Archivos:<br>';
                $sql_archivos="SELECT nombre, area, tx_area
						FROM adjuntos
						LEFT JOIN area ON adjuntos.area = area.id_area
						WHERE adjuntos.id_documento  = '$id_documento'";

                  $result=$mysqli->query($sql_archivos);
                  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
							if($row['tx_area'] == NULL) {
								echo 'SOLICITANTE: <a href="Archivos/'.$row['nombre'].'">'.$row['nombre'].'</a><br>';
							}	                 
							else { 	
                  	 echo $row['tx_area'].': <a href="Archivos/'.$row['nombre'].'">'.$row['nombre'].'</a><br>';
                  } 
                 }
?>
               
                                      
                   
                   <div class="boton_envio">                           
                    <input type="hidden" name="area_flujo" id="area_flujo" value="<?php echo $area_flujo; ?>">
                    <input type="hidden" name="id_documento" value="<?php echo $id_documento; ?>">
                    <input type="hidden" name="id_solicitud" value="<?php echo $id_solicitud; ?>">
                    <input type="submit" id="submit" name="submit" value="Enviar" >
     </form>

<?php } ?>
          </div>
        </div>
 </div>   	