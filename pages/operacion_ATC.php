<?php 
//error_reporting(E_ALL ^ E_NOTICE);  
    include("configuracion.php");
	   // session_start();
    $id_user = $_SESSION['uid'];
    $id_area = $_SESSION['area'];
    $id_area_op= $_SESSION['area'];

    if(isset($_GET['marca'])) {
    
 echo  "Entró-usuario";
 
 echo $id_user.'- area'.$id_area;
 
 $id = $_GET['i'];
 
$sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = '1', usuario_reserva = '$id_user' 
		  WHERE `aclaracion_queja`.`id` = '$id';";
$result=$mysqli->query($sql);
 
 
}
/*
if(isset($_POST['bandera'])) {
	
	echo 'form'.$_POST['comentario'].$_POST['id_observacion'];
	$comentario = $_POST['comentario'];
	$id_observacion = $_POST['id_observacion'];
$sql="UPDATE `sis_fac`.`observaciones` 
SET `observacion` = concat(observacion, '<br>' ,now(), '-', '$comentario') 
WHERE `observaciones`.`id_observaciones` = '$id_observacion'";
$result=$mysqli->query($sql);

}
	

if($accion==1){
    $sql="UPDATE documento
             SET reservada='1', estado_actual='1',area_flujo='$id_area',usuario_reserva='$id_user'
           WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql); 
      if($result){

          $sql1="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,id_documento,users_id_usuario,area_id_area) 
                     VALUES (now(),1,'".$id_documento."', '".$id_user."','".$id_area."' )";
          $result1=$mysqli->query($sql1);
      }
}

if($accion==2){

    $sql="SELECT *
           FROM documento
          WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql);
    $row=$result->fetch_array(MYSQLI_ASSOC);

    $sql="UPDATE documento
             SET reservada='0', estado_actual='0',area_flujo='$id_area',usuario_reserva=''
           WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql); 
      if($result){
        $sql1="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,id_documento,users_id_usuario,area_id_area) 
                   VALUES (now(),0,'".$id_documento."', '".$id_user."','".$id_area."' )";
        $result1=$mysqli->query($sql1);
      }
}


if($accion==3){
  $id_area=3;

    $sql="SELECT *
           FROM documento
          WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql);
    $row=$result->fetch_array(MYSQLI_ASSOC);

    $sql="UPDATE documento
             SET reservada='0', estado_actual='0',area_flujo='$id_area',area_flujo_anterior='$id_area_op',usuario_reserva=''
           WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql); 
      if($result){
        $sql1="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,id_documento,users_id_usuario,area_id_area) 
                   VALUES (now(),0,'".$id_documento."', '".$id_user."','".$id_area."' )";
        $result1=$mysqli->query($sql1);
      }
}

*/
    
?>
<div class="contenedor">
            <div class="header">
                 <h1 class="h1_header">
                    <?php echo utf8_encode($_SESSION['username']);?> 
                </h1>
            
            </div>
                <div class="content">
                 <div class="datos_informacion">
                  <?php
/*
                    $num_pendientes=0;
                    $num_liberados=0;
                    $num_rechazado=0;

                    $sql="SELECT *
                            FROM documento
                           WHERE estado_actual!=4 || estado_actual!=7 AND area_flujo=$id_area_op";
                    $result=$mysqli->query($sql);
                    $num_pendientes=$result->num_rows;

                    $sql="SELECT *
                            FROM historial_estados
                           WHERE estado_solicitud_idestado_solicitud=3 AND users_id_usuario=$id_user";
                    $result=$mysqli->query($sql);
                    $num_liberados=$result->num_rows;

                    $sql="SELECT *
                            FROM historial_estados
                           WHERE estado_solicitud_idestado_solicitud=4 AND users_id_usuario=$id_user";
                    $result=$mysqli->query($sql);
                    $num_rechazado=$result->num_rows;
*/
                  ?>
                  <div class="datos_totales">
                <p>Total de solicitudes pendientes: <span><?php //echo $num_pendientes; ?></span></p> 
                <p>Total de solicitudes liberadas: <span><?php //echo $num_liberados; ?></span></p> 
                <p>Total de solicitudes rechazadas: <span><?php //echo $num_rechazado; ?></span> </p> 
                <p>Total de solicitudes: <span><?php //echo $num_pendientes+$num_liberados+$num_rechazado; ?></span></p> 
                  </div>

                  <div class="datos_totales right">
                <p>Solicitudes pendientes fuera dei tiempo: <span>0</span></p> 
                  </div>
                </div>
                <?php 
                  /*$sql_estado="SELECT estado_sol
                          FROM estado_solicitud
                         WHERE id_estado_solicitud=0";
                  $result_estado=$mysqli->query($sql_estado);
                  $row=$result_estado->fetch_array(MYSQLI_ASSOC);
*/
                ?>
                                                  <H2>Solicitudes <?php //echo $row['estado_sol'];?></H2>
                    <table class="gridview">
<tr >
                        <td colspan="10" align="right" bgcolor="00517A"><font color="#fff">Filtro de solicitud:
<form action="operar_ATC.php" method="post" id="id_estados_sol">
                         <select id='' name="" onchange="this.form.submit()">
<option value='...'>---</option> 

  	<option value='PENDIENTES'>PENDIENTES</option>
  	<option value='RECIBIDO'>RECIBIDO</option>  
  	<option value='LIBERADO'>LIBERADO</option>
	<option value='GESTION TERCEROS'>GESTION TERCEROS</option>
  	<option value='FINALIZADO'>FINALIZADO</option> 
                        

                    
</select></form></td>
                        
                        
                        
                    </tr>

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
                        <td></td>
                  </tr>
<?php 


$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '7'
and reservada is null
";



    $result=$mysqli->query($sql);
    $bgcolor=0;
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
      if ($bgcolor%2==0){ $color="FFFFFF"; $bgcolor++; } else { $color="CEF6F5"; $bgcolor++;}
?>
                    <tr  bgcolor="<?php echo $color; ?>">

                        <td ><?php echo $row["id"]; ?></td>
                        <td ><?php echo $row["fecha_recep"]; ?></td>
                        <td ><?php echo $row["fecha_atenc"]; ?></td>
								<td ><?php echo $row["tipo_solic"]; ?></td>
                        <td ><?php echo $row["detalle_solic"]; ?></td>
                        <td ><?php echo $row["linea_negoc"]; ?></td>
                        <td ><?php echo $row["cod_cte"]; ?></td>
                        <td ><?php echo $row["proceso"]; ?></td>
                        <td ><?php echo $row["fecha_cierre"]; ?></td>                 
               			<td><a href="homepage.php?id=operacion_ATC&marca=1&i=<?php echo $row['id']; ?>" class="tomar_solicitud" id="<?php echo $row['id']; ?>"><span class="icon-checkmark espacio"></span></a>
									<a href="ver_historial.php?sol=<?php echo $row['id_documento']; ?>&height=450&width=650" title="Documento <?php echo $row['id_documento']; ?>" class="thickbox"><span class="icon-stack espacio"></span></a>               			
               			
               			</td>
                       
                    </tr>
<?php }  ?>
                            
            </table>

     </div>
        </div>
<form  action="#" method="post" id="tomar_solicitud">
  <input type="hidden" name="valor_solicitud" id="valor_solicitud" value="#">
  <input type="hidden" name="id_documento" id="id_documento" value="#">
  <input type="hidden" name="accion" id="accion" value="#">
</form>