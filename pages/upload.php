<?php
require_once '../configuracion.php';
$target_dir="../Archivos/";
$target_dir=$target_dir.  basename($_FILES["uploadfile"]["name"]);
$uploadOk=1;
if(move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$target_dir))
{    
    $row=1;
    $fp=  fopen($target_dir, "r");
    while ($data = fgetcsv ($fp,1000, ";")) 
    {
     if(($data[8]==1)||($data[8]==2)||($data[8])==3||($data[8]==4))
     {
     $insertar="INSERT INTO documento(`id_codigo_cliente`,`tipo_nc`,`dias_vencimiento`,`leyenda_doc`,`compa_fac`,`refac_folio`,`IVA_idIVA`,`Moneda_idMoneda`,`tipo_documento_idtipo_doc`,`solicitudes_idSolicitudes`"
             . ",`razon_social`,`leyenda_mat`,`salida`,`entrada`,`motivos`,`folio_fac_origen`,`monto_total_fac_orig`,`monto_afectar_nc`"
             . ",`fecha_emision_nc`,`folio_nc`,`fecha_emision_fac_or`,`importe_total`,`codigo_cliente_afectar`,`motivo_nc`,`oper_plataforma`,`oper_oficina`"
             . ",`oper_clase`,`oper_canal`,`oper_sector`,`oper_tipo`,`oper_numero`,`fac_clasificacion`,`fac_proceso`,`fac_numero_folio`,`estado_actual`"
             . ",`area_flujo`,`area_flujo_anterior`,`prioridad_flujo`,`subprioridad_flujo`,`usuario_reserva`,`reservada`)"
             . "VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]',"
             . "'$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]',"
             . "'$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]',"
             . "'$data[31]','$data[32]','$data[33]','$data[34]','$data[35]','$data[36]','$data[37]','$data[38]','$data[39]','$data[40]')";
      $mysqli->query($insertar);
     echo "\n Los datos se insertaron correctamente";
     }     
     else 
     {
         echo "El tipo de documento no es el correcto";
     }    
   // header("Location:../homepage.php?id=carga_masiva");
      }      
     fclose($fp);
}
 else 
{
    echo "Error al subir el archvio";
}
?>
