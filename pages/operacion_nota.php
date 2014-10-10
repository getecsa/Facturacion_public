<div id="divNotificacion" />
      <div class="contenedor">
                  <div class="header">
                      <img alt="Movistar" class="logotipo" src="images/logo.png" />
                      <h1>Validación</h1>
                  </div>
          <div class="content">
<?php
 include("config.php");
    $area_operador=$_SESSION['area'];

  if(isset($_POST["submit"])) {    

    $estado_actual=$_POST["estado_actual"];
    $area_flujo=$_POST["area_flujo"];
    $id_documento=$_POST["id_documento"];
    $id_solicitud=$_POST["id_solicitud"];    
    $observaciones=$_POST["observaciones"];
    $id_usuario=$_SESSION['uid'];

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
                //$query_adjuntos="INSERT INTO adjuntos (nombre, id_documento, id_usuario) VALUE ('$ext_archivo', '$id_documento','$id_usuario')";
                $query_adjuntos="INSERT INTO adjuntos (nombre, id_documento,id_usuario,area) VALUE ('$ext_archivo', '$id_documento','$id_usuario','$area_flujo')";
                $result_adjunto = $mysqli->query($query_adjuntos);
            }   

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

                               if(!empty(trim($justificacion))) {  
                                  $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                                  $result=$mysqli->query($query);
                                }

                               if(!empty(trim($observaciones))) {  
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

                     if(!empty(trim($justificacion))) {  
                        $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                        $result=$mysqli->query($query);
                      }

                     if(!empty(trim($observaciones))) {  
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

                     if(!empty(trim($justificacion))) {  
                        $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                        $result=$mysqli->query($query);
                      }

                     if(!empty(trim($observaciones))) {  
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
  $folio_fac_origen=$row['folio_fac_origen'];
  $leyenda_doc=$row['leyenda_doc'];
  $tipo_nc=$row['tipo_nc'];
  $iva=$row["IVA_idIVA"];
  $mt_fac_orig=$row['monto_total_fac_orig'];
  $fecha_emision_nc=$row['fecha_emision_nc'];
  $razon_social=$row['razon_social'];
  $monto_afectar_nc=$row['monto_afectar_nc'];
  $moneda=$row['Moneda_idMoneda'];
  $tipo_cliente=$row['tipo_cliente_idtipo_cliente'];
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
$result_iva=mysql_db_query($db, $sql_iva,$link);

$sql_moneda="select * from moneda";
$result_moneda=mysql_db_query($db, $sql_moneda,$link);

?>
  <form class="formulario_n" action="#" method="post" enctype="multipart/form-data">
                     <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><p><?php echo $cod_cliente;?></p>
                        <label for="motivo_sol">Motivo de solicitud:</label><p><?php echo $motivo_sol;?></p>
                        <label for="leyenda_doc">Leyenda del documento:</label><p><?php echo $leyenda_doc;?></p>
                        <label for="folio_fac_origen">Folio factura origen:</label><p><?php echo $folio_fac_origen;?></p>
                      </div>  
                      <div class="column bottom_nc">
                      <label for="tipo_nc">Tipo Nota Crédito:</label><p><?php echo $tipo_nc;?></p>
                      <label for="iva">IVA:</label>
                        <?php 
                            $sql_iva="select * from iva where id_iva=$iva";
                            $result_iva=mysql_db_query($db, $sql_iva,$link);
                            if($row=mysql_fetch_array($result_iva)){
                            $id_iva=$row['id_iva'];
                            echo "<p>",$row['valor_tx'],"</p>";
                              }
                          ?>
                    <label for="mt_fac_orig">Monto Total (Fac Origen):</label><p><?php echo $mt_fac_orig;?></p>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><p><?php echo $razon_social;?></p>
                        <label for="moneda">Moneda:</label>
                        <?php 
                            $sql_moneda="select * from moneda where id_moneda=$moneda";
                            $result_moneda=mysql_db_query($db, $sql_moneda,$link);
                            if($row=mysql_fetch_array($result_moneda)){
                            echo "<p>",$row['moneda'],"</p>";
                              }
                          ?>

                        <label for="fecha_emision_nc">Fecha Emisión:</label><p><?php echo $fecha_emision_nc;?></p>
                        <label for="monto_afectar_nc">Monto Afectar con NC:</label><p><?php echo $monto_afectar_nc;?></p>
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
    $result=mysql_db_query($db,$sql,$link);
    $row=mysql_fetch_array($result);
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
          <p>Observaciones:</p><textarea name="observaciones" COLS=30 ROWS=6></textarea>
        </div>
        <div class="estado">

       <?php
          if ($area_operador==2){
        ?>
      <div class="funciones_operador">
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
          <p>Justificacion:</p><textarea name="justificacion" COLS=30 ROWS=6></textarea>
        </div>
        <?php 
          }
         if ($area_operador==6){
        ?>
            <div class="custom-input-file botones">
            <input type="file" class="input-file" name="archivo" />
            Adjuntar Archivos
            <div class="archivo">...</div>
            <input name="action" type="hidden" value="upload" /> 
            </div>
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


        </fieldset>
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