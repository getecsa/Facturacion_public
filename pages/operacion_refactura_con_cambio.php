<div id="divNotificacion" />
      <div class="contenedor">
                  <div class="header">
                      <img alt="Movistar" class="logotipo" src="images/logo.png" />
                      <h1>Validación refactura con cambio</h1>
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
    $observaciones=trim($observaciones);
    $id_usuario=$_SESSION['uid'];
    if(!isset($_POST['generacion_doc'])){$_POST['generacion_doc']="NO";}
    $generacion_doc=$_POST['generacion_doc'];

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
           $justificacion=trim($justificacion);
           $clasificacion=$_POST["clasificacion"];
           $oper1=$_POST["oper_plataforma"];
           $oper2=$_POST["oper_oficina"];
           $oper3=$_POST["oper_clase"];
           $oper4=$_POST["oper_canal"];
           $oper5=$_POST["oper_sector"];
           $oper6=$_POST["oper_tipo"];
           $oper7=$_POST["oper_numero"];


          if(!isset($_POST['oper_plataforma_nc'])){$_POST['oper_plataforma_nc']="";}
          if(!isset($_POST['oper_oficina_nc'])){$_POST['oper_oficina_nc']="";}
          if(!isset($_POST['oper_clase_nc'])){$_POST['oper_clase_nc']="";}
          if(!isset($_POST['oper_canal_nc'])){$_POST['oper_canal_nc']="";}
          if(!isset($_POST['oper_sector_nc'])){$_POST['oper_sector_nc']="";}
          if(!isset($_POST['oper_tipo_nc'])){$_POST['oper_tipo_nc']="";}
          if(!isset($_POST['oper_numero_nc'])){$_POST['oper_numero_nc']="";}

           $oper1_nc=$_POST["oper_plataforma_nc"];
           $oper2_nc=$_POST["oper_oficina_nc"];
           $oper3_nc=$_POST["oper_clase_nc"];
           $oper4_nc=$_POST["oper_canal_nc"];
           $oper5_nc=$_POST["oper_sector_nc"];
           $oper6_nc=$_POST["oper_tipo_nc"];
           $oper7_nc=$_POST["oper_numero_nc"];
           //datos que modifica el area asignacion de condiciones
           $motivo_sol=$_POST["motivo_sol"];
           $dias_ven=$_POST["dias_ven"];
           $entrada=$_POST["entrada"];
           $monto_afectar_nc=$_POST["monto_afectar_nc"];
           $array_cont=$_POST['array_cont'];

        }

        if ($area_flujo==5){
          
        if(!isset($_POST['clasificacion'])){$_POST['clasificacion']="";}
        if(!isset($_POST['proceso'])){$_POST['proceso']="";}
        if(!isset($_POST['numero_folio'])){$_POST['numero_folio']="";}

        
           $justificacion=$_POST["justificacion"];
           $justificacion=trim($justificacion);
           $clasificacion=$_POST["clasificacion"];
           $proceso=$_POST["proceso"];
           $numero_folio=$_POST["numero_folio"];

        }

       if ($area_flujo==6){
                

        }


// Liberado o finalizado

          if (($estado_actual=="3") || ($estado_actual=="7") ){
                //envia a generacion nota de credito
              if($generacion_doc==1){

                  $sql="SELECT prioridad_flujo, area_flujo, tipo_documento_idtipo_doc as tipo_documento
                          FROM documento 
                         WHERE id_documento='$id_documento'";
                  $result=$mysqli->query($sql);
                  $row=$result->fetch_array(MYSQLI_ASSOC);
                  $tipo_documento=$row['tipo_documento'];
                  $prioridad=$row['prioridad_flujo']+1;

                  $query1="SELECT area_id_area
                            FROM flujo_trabajo
                           WHERE tipo_documento_id_tipo_doc='$tipo_documento' AND prioridad='$prioridad' AND sub_prioridad=1 LIMIT 1";
                  $result1=$mysqli->query($query1);
                  $row1=$result1->fetch_array(MYSQLI_ASSOC);
                  $area_inicial=$row1['area_id_area'];
                  $cont = $result1->num_rows;

                $sql="UPDATE documento
                         SET subprioridad_flujo='1'
                       WHERE id_documento='$id_documento'";
                $mysqli->query($sql); 

              }

               //envia a generacion factura
              if($generacion_doc==2){

                  $sql="SELECT prioridad_flujo, area_flujo, tipo_documento_idtipo_doc as tipo_documento
                          FROM documento 
                         WHERE id_documento='$id_documento'";
                  $result=$mysqli->query($sql);
                  $row=$result->fetch_array(MYSQLI_ASSOC);
                  $tipo_documento=$row['tipo_documento'];
                  $prioridad=$row['prioridad_flujo']+1;

                  $query1="SELECT area_id_area
                            FROM flujo_trabajo
                           WHERE tipo_documento_id_tipo_doc='$tipo_documento' AND prioridad='$prioridad' AND sub_prioridad=2 LIMIT 1";
                  $result1=$mysqli->query($query1);
                  $row1=$result1->fetch_array(MYSQLI_ASSOC);
                  $area_inicial=$row1['area_id_area'];
                  $cont = $result1->num_rows;
                  
                $sql="UPDATE documento
                         SET subprioridad_flujo='2'
                       WHERE id_documento='$id_documento'";
                $mysqli->query($sql); 

              }

               //envia a generacion factura y nota de credito
              if($generacion_doc==3){
              //se genera primero la factura y ya despues se genera una copia de registros para generar la NC

                $sql="SELECT prioridad_flujo, area_flujo, tipo_documento_idtipo_doc as tipo_documento
                          FROM documento 
                         WHERE id_documento='$id_documento'";
                  $result=$mysqli->query($sql);
                  $row=$result->fetch_array(MYSQLI_ASSOC);
                  $tipo_documento=$row['tipo_documento'];
                  $prioridad=$row['prioridad_flujo']+1;

                  $query1="SELECT area_id_area
                            FROM flujo_trabajo
                           WHERE tipo_documento_id_tipo_doc='$tipo_documento' AND prioridad='$prioridad' AND sub_prioridad=2 LIMIT 1";
                  $result1=$mysqli->query($query1);
                  $row1=$result1->fetch_array(MYSQLI_ASSOC);
                  $area_inicial=$row1['area_id_area'];
                  $cont = $result1->num_rows;

                $sql="UPDATE documento
                         SET subprioridad_flujo='2'
                       WHERE id_documento='$id_documento'";
                $mysqli->query($sql); 

              }

              if($generacion_doc=="NO")
              {
               
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

              }

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
                                           SET oper_plataforma='$oper1',
                                               oper_oficina='$oper2',
                                               oper_clase='$oper3',
                                               oper_canal='$oper4',
                                               oper_sector='$oper5',
                                               oper_tipo='$oper6',
                                               oper_numero='$oper7',
                                               fac_clasificacion='$clasificacion',
                                               dias_vencimiento='$dias_ven',
                                               motivos='$motivo_sol',
                                               entrada='$entrada',
                                               monto_afectar_nc='$monto_afectar_nc'
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

                                 //si selecciono generar factura realizo la duplicidad NC
                                  if ($generacion_doc==3){
                                  //genero copia del documento para nota de credito
                                 include("scripts/funciones.php");
                                 $resultado=mysql_clonar_registro("documento",$id_documento);
                                 $id_documento_nc=$resultado;

/*
                                 $query1="SELECT area_id_area
                                           FROM flujo_trabajo
                                          WHERE tipo_documento_id_tipo_doc='$tipo_documento' AND prioridad='$prioridad' AND sub_prioridad=1  LIMIT 1";
                                 $result1=$mysqli->query($query1);
                                 $row1=$result1->fetch_array(MYSQLI_ASSOC);
                                 $area_inicial=$row1['area_id_area'];
                                 $cont = $result1->num_rows;
*/

                                 $sql="UPDATE documento
                                          SET  subprioridad_flujo=1,
                                               oper_plataforma='$oper1_nc',
                                               oper_oficina='$oper2_nc',
                                               oper_clase='$oper3_nc',
                                               oper_canal='$oper4_nc',
                                               oper_sector='$oper5_nc',
                                               oper_tipo='$oper6_nc',
                                               oper_numero='$oper7_nc',
                                               area_flujo='4'
                                        WHERE id_documento='$id_documento_nc'";
                                 $mysqli->query($sql);  
                                
                                $sql_con1="SELECT *
                                           FROM conceptos_doc
                                           WHERE documento_iddocumento='$id_documento'";
                                $result_con1=$mysqli->query($sql_con1);
                                    while($row=$result_con1->fetch_array(MYSQLI_ASSOC)){
                                      $campo1=$row['id_codigo_concepto'];
                                      $campo2=$row['tx_concepto'];
                                      $campo3=$row['fac_unidades'];
                                      $campo4=$row['fac_precio_uni'];
                                      $campo5=$row['fac_descuento'];
                                      $campo6=$row['not_importe_dispo'];
                                      $campo7=$row['not_monto_afec'];
                           
                                    $sql_ip="INSERT INTO conceptos_doc ( id_codigo_concepto,
                                                                         tx_concepto,
                                                                         fac_unidades,
                                                                         fac_precio_uni,
                                                                         fac_descuento,
                                                                         not_importe_dispo,
                                                                         not_monto_afec,
                                                                         documento_iddocumento)
                                                             VALUES ('$campo1',
                                                                     '$campo2',
                                                                     '$campo3',
                                                                     '$campo4',
                                                                     '$campo5',
                                                                     '$campo6',
                                                                     '$campo7',
                                                                     '$id_documento_nc') 
";
                                    $mysqli->query($sql_ip);

                                    }

                                  }

      }

                               if(!empty($justificacion)) {
                                  $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes,estado) VALUES ('$justificacion',now(),'$id_usuario','$id_documento','$id_solicitud',1)";
                                  $result=$mysqli->query($query);
                                  $id_observaciones_j=$mysqli->insert_id;

                                  if ($generacion_doc==3){
                                  //genero copia del documento para nota de credito
                                 $resultado=mysql_clonar_registro("observaciones",$id_observaciones_j);
                                 $id_observaciones_n=$resultado;

                                 $sql="UPDATE observaciones
                                          SET id_documento='$id_documento_nc'
                                        WHERE id_observaciones='$id_observaciones_n'";
                                 $mysqli->query($sql);  
      
                                  }

                                }

                               if(!empty($observaciones)) {
                                   $query="INSERT INTO observaciones (observacion,fecha_observacion,users_id_usuario,id_documento,solicitudes_id_solicitudes) VALUES ('$observaciones',now(),'$id_usuario','$id_documento','$id_solicitud')";
                                   $result=$mysqli->query($query);
                                   $id_observaciones=$mysqli->insert_id;

                                    if ($generacion_doc==3){
                                  //genero copia del documento para nota de credito
                                 $resultado=mysql_clonar_registro("observaciones",$id_observaciones);
                                 $id_observaciones_n=$resultado;

                                 $sql="UPDATE observaciones
                                          SET id_documento='$id_documento_nc'
                                        WHERE id_observaciones='$id_observaciones_n'";
                                 $mysqli->query($sql);  
                                  }

                                }

                                  if($result){
                                    
                                        $query="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,users_id_usuario,area_id_area,id_documento) VALUES (now(),'$estado_actual','$id_usuario','$area_flujo','$id_documento')";
                                        $result0=$mysqli->query($query);
                                        $id_historial=$mysqli->insert_id;
                                              if ($generacion_doc==3){
                                                    //genero copia del documento para nota de credito
                                                 
                                                   $resultado=mysql_clonar_registro("historial_estados",$id_historial);
                                                   $id_historial_n=$resultado;

                                                   $sql="UPDATE historial_estados
                                                            SET id_documento='$id_documento_nc'
                                                          WHERE id_historial='$id_historial_n'";
                                                   $mysqli->query($sql);  
                                                    }

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
                                           SET oper_plataforma='$oper1',
                                               oper_oficina='$oper2',
                                               oper_clase='$oper3',
                                               oper_canal='$oper4',
                                               oper_sector='$oper5',
                                               oper_tipo='$oper6',
                                               oper_numero='$oper7',
                                               fac_clasificacion='$clasificacion',
                                               dias_vencimiento='$dias_ven',
                                               motivos='$motivo_sol',
                                               entrada='$entrada',
                                               monto_afectar_nc='$monto_afectar_nc'
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
                              $sql="UPDATE documento
                              SET  estado_actual='$estado_actual'
                             	WHERE id_documento='$id_documento'";       

                      			$result=$mysqli->query($sql);
                            }

                          if ($area_flujo==2){
                              $sql="UPDATE documento
                                           SET oper_plataforma='$oper1',
                                               oper_oficina='$oper2',
                                               oper_clase='$oper3',
                                               oper_canal='$oper4',
                                               oper_sector='$oper5',
                                               oper_tipo='$oper6',
                                               oper_numero='$oper7',
                                               fac_clasificacion='$clasificacion',
                                               dias_vencimiento='$dias_ven',
                                               motivos='$motivo_sol',
                                               entrada='$entrada',
                                               monto_afectar_nc='$monto_afectar_nc'
                                         WHERE id_documento='$id_documento'";          
                              $result=$mysqli->query($sql); 
                              
                               //Query Daniel Irineo
                             	$sql="UPDATE documento
                              	SET  estado_actual='0', 
                              	area_flujo = '1', 
                              	area_flujo_anterior = '20', 
                              	prioridad_flujo = '1', 
                              	usuario_reserva = '1', 
                              	reservada = '0'
                             	WHERE id_documento='$id_documento'";       

                      			$result=$mysqli->query($sql);
                            }

                          if ($area_flujo==4 || $area_flujo==5){
                              $sql="UPDATE documento
                                       SET fac_proceso='$proceso', fac_numero_folio='$numero_folio'
                                     WHERE id_documento='$id_documento'";       
                              $result=$mysqli->query($sql); 
                              
 										$sql="UPDATE documento
                              	SET  estado_actual='0', 
                              	area_flujo = '2', 
                              	area_flujo_anterior = '1',
                              	prioridad_flujo = '2', 
                              	usuario_reserva = '0', 
                              	reservada = '0'
                             	WHERE id_documento='$id_documento'";       

                      			$result=$mysqli->query($sql);
                              
                            }          

                          if ($area_flujo==6){
                            echo "Entrega documentos";
                             //Query Daniel Irineo
                             	$sql="UPDATE documento
                              	SET  estado_actual='0', 
                              	area_flujo = '5', 
                              	area_flujo_anterior = '2', 
                              	prioridad_flujo = '3', 
                              	usuario_reserva = '0', 
                              	reservada = '0'
                             	WHERE id_documento='$id_documento'";       

                      			$result=$mysqli->query($sql);

                            }
/*
                      $sql="UPDATE documento
                               SET  estado_actual='$estado_actual'
                             WHERE id_documento='$id_documento'";       

                      $result=$mysqli->query($sql); */

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
      $leyenda_doc=$row['leyenda_doc'];
      $dias_ven=$row['dias_vencimiento'];
      $codigo_cliente_afectar=$row['codigo_cliente_afectar'];
      $fecha_emision_nc=$row['fecha_emision_nc'];
      $moneda=$row['Moneda_idMoneda'];
      $iva=$row["IVA_idIVA"];
      $folio_fac_origen=$row['folio_fac_origen'];
      $folio_nc=$row['folio_nc'];
      $fecha_emision_fac_or=$row['fecha_emision_fac_or'];
      $razon_social=$row['razon_social'];
      $entrada=$row['entrada'];
      $motivo_nc=$row['motivo_nc'];
      $mt_fac_orig=$row['monto_total_fac_orig'];
      $monto_afectar_nc=$row['monto_afectar_nc'];
      $importe_total=$row['importe_total']; 
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
                        <label for="motivo_sol">Motivo de solicitud:</label><p><?php if ($area_flujo==2){?><input type="text" name="motivo_sol" id="motivo_sol" value="<?php echo $motivo_sol; ?>" /> <?php } else { echo $motivo_sol; }?></p>
                        <label for="leyenda_doc">Leyenda del documento:</label><p><?php echo $leyenda_doc;?></p>
                        <label for="dias_ven">Dias de vencimiento:</label><p><?php if ($area_flujo==2){?><input type="text" name="dias_ven" id="dias_ven" value="<?php echo $dias_ven; ?>" /> <?php } else { echo $dias_ven; }?></p>
                        <label for="codigo_cliente_afectar">Codigo C.(Fac. Afectar):</label><p><?php echo $codigo_cliente_afectar; ?></p>
                        <label for="fecha_emision_nc">Fecha Emision NC:</label><p><?php echo $fecha_emision_nc;?></p>
                      </div>  
                      <div class="column bottom_nc">
                      <label for="moneda">Moneda:</label>
                        <?php 
                            $sql_moneda="select * from moneda where id_moneda=$moneda";
                            $result_moneda=$mysqli->query($sql_moneda);
                            if($row=$result_moneda->fetch_array(MYSQLI_ASSOC)){
                            echo "<p>",$row['moneda'],"</p>";
                              }
                          ?>
                      <label for="iva">IVA:</label>
                        <?php 
                            $sql_iva="select * from iva where id_iva=$iva";
                            $result_iva=$mysqli->query($sql_iva);
                            if($row=$result_iva->fetch_array(MYSQLI_ASSOC)){
                            $id_iva=$row['id_iva'];
                            echo "<p>",$row['valor_tx'],"</p>";
                              }
                          ?>
                      <label for="folio_fac_origen">Folio factura origen:</label><p><?php echo $folio_fac_origen; ?></p>
                      <label for="folio_nc">Folio NC:</label><p><?php echo $folio_nc;?></p>
                      <label for="fecha_emision_nc2">Fecha Emision Fac. Origen:</label><p><?php echo $fecha_emision_fac_or;?></p>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><p><?php echo $razon_social;?></p>
                        <label for="entrada">Entrada:</label><p><?php if ($area_flujo==2){?><input type="text" name="entrada" id="entrada" value="<?php echo $entrada; ?>" /> <?php } else { echo $entrada; }?></p>
                        <label for="motivo_nc">Motivo NC:</label><p><?php echo $motivo_nc;?></p>
                        <label for="mt_fac_orig">Monto Total (Fac Origen):</label><p><?php echo $mt_fac_orig; ?></p>
                        <label for="monto_afectar_nc">Monto Afectar con NC:</label><p><?php if ($area_flujo==2){?><input type="text" name="monto_afectar_nc" id="monto_afectar_nc" value="<?php echo $monto_afectar_nc; ?>" /> <?php } else { echo $monto_afectar_nc; }?></p>
                        <label for="importe_total">Importe total:</label><p><?php echo $importe_total;?></p>
                        
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
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>" /></td>
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
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][2]" value="<?php echo $array_cont[$i][2]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][2]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][2]" value="<?php echo $array_cont[$i][2]; ?>" /></td>
      <?php } ?>
      </td>
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][3]" value="<?php echo $array_cont[$i][3]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][3]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][3]" value="<?php echo $array_cont[$i][3]; ?>" /></td>
      <?php } ?>
      </td>
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][4]" value="<?php echo $array_cont[$i][4]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][4]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][4]" value="<?php echo $array_cont[$i][4]; ?>" /></td>
      <?php } ?>
      </td>
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][5]" value="<?php echo $array_cont[$i][5]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][5]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][5]" value="<?php echo $array_cont[$i][5]; ?>" /></td>
      <?php } ?>
      </td>
      <td><?php if ($area_operador==2){ ?>
      <input  type="text" size="10" name="array_cont[<?php echo $i; ?>][6]" value="<?php echo $array_cont[$i][6]; ?>" /></td>
           <?php }  else{ ?>
      <?php echo $array_cont[$i][6]; ?>
      <input  type="hidden" name="array_cont[<?php echo $i; ?>][6]" value="<?php echo $array_cont[$i][6]; ?>" /></td>
      <?php } ?>
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
    <table class="gridview" class="formulario_operador" id="operador_fac">
    <td colspan="7"><p><h2>Factura</h2></p></td>
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

    <table class="gridview" class="formulario_operador" id="operador_nc">
    <td colspan="7"><p><h2>Nota de credito</h2></p></td>
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
      <td><input type="text" size="10" name="oper_plataforma_nc"></td>
      <td><input type="text" size="25" name="oper_oficina_nc"></td>
      <td><input type="text" size="25" name="oper_clase_nc"></td>
      <td><input type="text" size="10" name="oper_canal_nc"></td>
      <td><input type="text" size="10" name="oper_sector_nc"></td>
      <td><input type="text" size="10" name="oper_tipo_nc"></td>
      <td><input type="text" size="10" name="oper_numero_nc"></td>
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
        <div>
        <p><input type="radio" name="generacion_doc" id="gen_fac" checked value="2">Generar Factura</p>
        <p><input type="radio" name="generacion_doc" id="gen_not" value="1">Generar Nota de Credito</p>
        <p><input type="radio" name="generacion_doc" id="gen_fac_not" value="3">Generar Factura y Nota de credito</p>
          Clasificacion: <input type="text" name="clasificacion"></div>
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

<?php }

ini_set('error_reporting', E_ALL); ?>
          </div>
        </div>
 </div>   	