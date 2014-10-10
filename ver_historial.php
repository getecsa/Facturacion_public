<?php
    include("configuracion.php");

$id_documento=$_GET['sol'];
	
$sql="SELECT fecha, estado_sol AS estado_solicitud, username AS usuario, tx_area AS area
FROM historial_estados hi
INNER JOIN estado_solicitud es ON hi.estado_solicitud_idestado_solicitud = es.id_estado_solicitud
INNER JOIN users us ON hi.users_id_usuario = us.id_usuario
INNER JOIN area ar ON hi.area_id_area = ar.id_area
WHERE  id_documento = '$id_documento' ORDER BY fecha";

$result=$mysqli->query($sql);
$result1=$mysqli->query($sql);
$result2=$mysqli->query($sql);
$result3=$mysqli->query($sql);

$sql_comentario="SELECT id_observaciones ,date(fecha_observacion) as fecha, observacion as observacion, username as usuario
        				FROM observaciones o
  						INNER JOIN users us ON o.users_id_usuario=us.id_usuario
       				WHERE id_documento='$id_documento'
       				and o.estado = '0'
       				";
$result_comentario=$mysqli->query($sql_comentario);
$result_comentario1=$mysqli->query($sql_comentario);
$result_comentario2=$mysqli->query($sql_comentario);

?>
<div id="ver_folio">
    <br>
      <h2>Historial de folio</h2>
    <br>

            <article class="detalle_historial">
                <ul>
                  <li class="title">Usuario</li>
                  <?php while($row = $result3->fetch_array(MYSQLI_ASSOC)) {
?>
                  <li class="uno"><?php echo $row['usuario']; ?></li>
<?php } ?>                  
                  
                </ul>
                <ul>
                  <li class="title">Area Asignada</li>
                  <?php while($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>
                  <li class="uno"><?php echo $row['area']; ?></li>
<?php } ?>                  
                  
                </ul>
                <ul>
                  <li class="title">Fecha de asignación</li>
                  <?php while($row = $result1->fetch_array(MYSQLI_ASSOC)) {
?>
                  <li class="uno"><?php echo $row['fecha']; ?></li>
<?php } ?>           
                </ul>
                <ul>
                
                  <li class="title">Estado</li>
                  <?php while($row = $result2->fetch_array(MYSQLI_ASSOC)) {
?>
                  <li class="uno"><?php echo $row['estado_solicitud']; ?></li>
                  <?php } ?> 
                </ul>
            </article>
<br><br><br><br>
          <table class="gridview">
				 <tr >
                        <td >Fecha Observaciòn</td>
                       <td >Observación</td>
                        <td ></td>
            </tr>
            <?php while($row = $result_comentario1->fetch_array(MYSQLI_ASSOC)) {
?>
			  <tr>
            
                        <td><?php echo $row["fecha"]; ?></td>
                        <td><?php echo utf8_encode($row["observacion"]); ?></td>
<td ><a href="responder_comentario.php?id_observacion=<?php echo $row['id_observaciones']; ?>" class="thickbox">Responder</a></td>                  
                    </tr>
                 
<?php } ?>
</table>    
      
</div>