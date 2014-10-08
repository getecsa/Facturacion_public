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
                {$param = 'Pendiente';}
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
<option value='Pendiente'>Pendiente</option> 
<option value='Rechazada'>Rechazada</option>
<option value='Aceptada'>Aceptada</option> 

</select> </font></td>
                        
                        
                        
                    </tr>
                    <tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        
                    </tr>
<?php 
//Si el estado esta en proceso para el solicitante

if ($param=='Pendiente'){
$sql="SELECT so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual=0 || do.estado_actual=1 || do.estado_actual=2 || do.estado_actual=3 ||
             do.estado_actual=5 || do.estado_actual=6 ORDER BY fecha DESC";

}

if ($param=='Rechazada'){
$sql="SELECT so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual=4";

}

if ($param=='Aceptada'){
$sql="SELECT distinct so.id_solicitudes, td.tipo_doc, so.fecha_solicitud as fecha, so.estado_actual as estado
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN historial_estados hi ON so.id_solicitudes=hi.solicitudes_idSolicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
       WHERE so.users_id_usuario='$id_user'
         AND do.estado_actual=7 ORDER BY fecha DESC";

}

if ($rs = mysqli_query($con, $sql)) {
    /* fetch array asociativo*/
while ($fila = mysqli_fetch_assoc($rs)) {
        
?>

                    <tr>
            
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>&estado=<?php echo $fila["estado"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"><?php echo $fila["id_solicitudes"]; ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>&estado=<?php echo $fila["estado"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"> <?php echo utf8_encode($fila["tipo_doc"]); ?></a></td>
                        <td><a href="ver_folio.php?id=<?php echo $fila["id_solicitudes"];?>&estado=<?php echo $fila["estado"];?>" title="Folio <?php echo $fila["id_solicitudes"];?>" class="thickbox"> <?php echo $fila["fecha"]; ?></a></td>
                       
                    </tr>
<?php }
}       
?>
                    
            </table>


               </div>
        </div>