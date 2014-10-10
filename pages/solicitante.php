<?php 
error_reporting(E_ALL ^ E_NOTICE);  
    include("conectar_bd.php");
    session_start();
    $id_user = $_SESSION['uid'];
    
        
        if(isset($_POST['form_1']))
                {
                        $id = $_POST['id'];
                        $comentario = $_POST['comentario'];


                        $insert = "INSERT INTO observaciones(  `observacion` ,  `fecha_observacion` ,  `users_id_usuario` ,  `solicitudes_id_solicitudes` )
                                VALUES ( '$comentario', now(), '$id_user', '$id')";

                        mysqli_query($con, $insert);
                }   

        if($_GET['param'] == '')
                {$param = 'Pendientes';}
        else {
            $param = $_GET['param'];
        }
?>
<script>
function enviar_parametro(valor){ 
location = location.pathname + '?id=solicitante&param=' + valor; 
// suponiendo que 'param' es el nombre como se reflejara en PHP; 
// location.pathname hace referencia a la ruta actual, de ser necesario puedes cambiarlo a la direccion que procesara los datos en PHP; 
}  
</script>


<div class="contenedor">
            <div class="header">
                 <h1 class="h1_header">
                    <?php echo utf8_encode($_SESSION['username']);?> 
                </h1>
            
            </div>
                <div class="content">
 
                                                  <H2>Solicitudes <?php echo $param;?></H2>
                    <table class="gridview" width=30%>
<tr >
                        <td colspan="7" align="right" bgcolor="00517A"><font color="#fff">Filtro de solicitud:
                        <select id='mySelect' onchange='enviar_parametro(this.value);'>
<option value='...'>---</option> 
<option value='Pendientes'>Pendientes</option> 
<option value='Rechazadas'>Rechazadas</option>
<option value='Aceptadas'>Aceptadas</option> 

</select> </font></td>
                        
                        
                        
                    </tr>
                    <tr bgcolor="00517A">
                        <td ><font color="#fff">ID Solicitud</font></td>
                        <td ><font color="#fff">ID Documento</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        
                    </tr>
<?php 
//Si el estado esta en proceso para el solicitante

if ($param=='Pendientes'){
$sql="SELECT so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha, do.estado_actual as estado, do.id_documento, do.subprioridad_flujo  as doc
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual=0 || do.estado_actual=1 || do.estado_actual=2 || do.estado_actual=3 ||
             do.estado_actual=5 || do.estado_actual=6 ORDER BY fecha DESC";

}

if ($param=='Rechazadas'){
$sql="SELECT so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha, do.estado_actual as estado, do.id_documento, do.subprioridad_flujo  as doc
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual= 4 ORDER BY fecha DESC";

}

if ($param=='Aceptadas'){
$sql="SELECT so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha, do.estado_actual as estado, do.id_documento, do.subprioridad_flujo  as doc
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual= 7 ORDER BY fecha DESC";

}

if ($rs = mysqli_query($con, $sql)) {
    /* fetch array asociativo*/
while ($fila = mysqli_fetch_assoc($rs)) {
        
?>

                    <tr>
            
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_documento"];?>&estado=<?php echo $fila["estado"];?>" title="ID <?php echo $fila["id_documento"];?>" class="thickbox"><?php echo $fila["id_solicitudes"]; ?></a></td>
								        <td><a href="ver_folio.php?id=<?php echo $fila["id_documento"];?>&estado=<?php echo $fila["estado"];?>" title="ID <?php echo $fila["id_documento"];?>" class="thickbox"><?php echo $fila["id_documento"]; ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_documento"];?>&estado=<?php echo $fila["estado"];?>" title="ID <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); if ($fila['doc']==1){ echo "- NOTA DE CREDITO";} if ($fila['doc']==2){ echo "- FACTURA";} ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_documento"];?>&estado=<?php echo $fila["estado"];?>" title="ID <?php echo $fila["id_documento"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                       
                    </tr>
<?php }
}       
?>
                    
            </table>
            <br>
                                                <H2>Aclaraciones ó Quejas <?php echo $param;?></H2>
                    <table class="gridview" width=30%>
                   <tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                        <td ><font color="#fff">Tipo Solicitud</font></td>
                        <td ><font color="#fff">Detalle Solicitud</font></td>
                        <td ><font color="#fff">Línea de Negocio</font></td>
                        <td ><font color="#fff">Código de Cliente</font></td>
                        <td ><font color="#fff">Proceso</font></td>
                        <td ><font color="#fff">Fecha Cierre</font></td>
                  </tr>
<?php 
//Si el estado esta en proceso para el solicitante


					$sql_aclaraciones="SELECT * 
					FROM  `aclaracion_queja` 
					WHERE estatus = '$param'";


if ($rs_aclaraciones = mysqli_query($con, $sql_aclaraciones)) {
    /* fetch array asociativo*/
while ($fila = mysqli_fetch_assoc($rs_aclaraciones)) {
        


               echo    	'<tr>           				
                        <td >'.$fila["id"].'</td>
                        <td >'.$fila["fecha_recep"].'</td>
                        <td >'.$fila["fecha_atenc"].'</td>
								<td >'.utf8_encode($fila["tipo_solic"]).'</td>
                        <td >'.utf8_encode($fila["detalle_solic"]).'</td>
                        <td >'.utf8_encode($fila["linea_negoc"]).'</td>
                        <td >'.$fila["cod_cte"].'</td>
                        <td >'.$fila["proceso"].'</td>
                        <td >'.$fila["fecha_cierre"].'</td>                 
               			</tr>';
 }
}       
?>
                    
            </table>


               </div>
        </div>