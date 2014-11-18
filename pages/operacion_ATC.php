<?php 
//error_reporting(E_ALL ^ E_NOTICE);  
    include("configuracion.php");
   // session_start();
    $id_user = $_SESSION['uid'];
    $id_area = $_SESSION['area'];
    $id_area_op= $_SESSION['area'];
    if(!isset($_POST['id_estado_sol'])){$_POST['id_estado_sol']=0;}
    $id_estado_click=$_POST['id_estado_sol'];
    if(!isset($_POST['id_documento'])){$_POST['id_documento']=0;}
    $id_documento=$_POST['id_documento'];
    if(!isset($_POST['accion'])){$_POST['accion']="-";}
    $accion=$_POST['accion'];


if(isset($_POST['bandera'])) {
	$detalle_solic = $_POST['detalle_solic'];
	$id = $_POST['id'];
	$estatus = $_POST['estatus'];

		if($estatus=='Cerrar') {

			if($id_area=='7') {

		  $sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = NULL, usuario_reserva = NULL, fecha_cierre = now(), 
		  estatus = '7',
		  area_flujo = '$estatus',
		  area_flujo_anterior = '$id_area' 
		  WHERE `aclaracion_queja`.`id` = '$id';";
		  $result=$mysqli->query($sql);
		   	
			}	
			
			else {
					
		$sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = NULL, usuario_reserva = NULL, fecha_cierre = now(), 
		  estatus = '0',
		  area_flujo = '7',
		  area_flujo_anterior = '$id_area' 
		  WHERE `aclaracion_queja`.`id` = '$id';";
		  $result=$mysqli->query($sql);
			
$query="INSERT INTO historial_estados (fecha, estado_solicitud_idestado_solicitud, users_id_usuario,
															  area_id_area, id_aclaracion) 
                VALUES (now(), '3', '$id_user', '$id_area', '$id')";
        $mysqli->query($query) or die($mysqli->error);			
			
			
			}
			
			

			$query = "INSERT INTO observaciones( observacion,fecha_observacion,users_id_usuario,
															 estado,solicitudes_id_solicitudes )
 						 VALUES ( '$detalle_solic', now(), '$id_user', '2', '$id')";
			$result = $mysqli->query($query);
	
		}

		


else {

	echo 'Viene AQ';

$sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = NULL, usuario_reserva = NULL, fecha_atenc = now(), 
		  estatus = '0',
		  area_flujo = '$estatus',
		  area_flujo_anterior = '$id_area' 
		  WHERE `aclaracion_queja`.`id` = '$id';";
		  $result=$mysqli->query($sql);
		  
 //guarda Historial
                               $query="INSERT INTO historial_estados (fecha,
                                                   estado_solicitud_idestado_solicitud,
                                                   users_id_usuario,
                                                   area_id_area,
                                                   id_aclaracion) 
                                            VALUES (now(),
                                                    7,
                                                    '$id_user',
                                                    '$id_area',
                                                    '$id')";
                                $mysqli->query($query) or die($mysqli->error);

$query = "INSERT INTO observaciones( observacion,fecha_observacion,users_id_usuario,
 estado,solicitudes_id_solicitudes )
 VALUES ( '$detalle_solic', now(), '$id_user', '2', '$id')";
$result = $mysqli->query($query);		  

//`observacion` = concat(observacion, '<br>' ,now(), '-', '$comentario')


}
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
	
*/
if($accion==1){

/*
    $sql="UPDATE documento
             SET reservada='1', estado_actual='1',area_flujo='$id_area',usuario_reserva='$id_user'
           WHERE id_documento='$id_documento'";
    $result=$mysqli->query($sql); 
      if($result){

          $sql1="INSERT INTO historial_estados (fecha,estado_solicitud_idestado_solicitud,id_documento,users_id_usuario,area_id_area) 
                     VALUES (now(),1,'".$id_documento."', '".$id_user."','".$id_area."' )";
          $result1=$mysqli->query($sql1);
      }
      */
      $sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = '1', usuario_reserva = '$id_user', estatus = '1' 
		  WHERE `aclaracion_queja`.`id` = '$id_documento';";
		  $result=$mysqli->query($sql);

      echo 'Accion 1-ID solicitud '.$id_documento;
}

if($accion==2){
/*
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
*/

$sql = "UPDATE `sis_fac`.`aclaracion_queja` 
		  SET `reservada` = NULL, usuario_reserva = NULL, estatus = 0 
		  WHERE `aclaracion_queja`.`id` = '$id_documento';";
		  $result=$mysqli->query($sql);

 echo 'Accion 2 LIBERAR -ID solicitud '.$id_documento;
}


if($accion==3){

/*
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
*/

echo 'Accion 3';
}


    
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

                    $num_pendientes=0;
                    $num_liberados=0;
                    $num_rechazado=0;

                    $sql="SELECT * 
									FROM  `aclaracion_queja` 
									WHERE  `area_flujo` =  '$id_area'	
									and reservada is null
									and estatus = '0'";
                    $result=$mysqli->query($sql);
                    $num_pendientes=$result->num_rows;

							$sql = "SELECT * 
									FROM  `aclaracion_queja` 
									WHERE  `area_flujo` =  '$id_area'	
									
									and estatus = '1'
									AND usuario_reserva = '$id_user'";                    
						  $result=$mysqli->query($sql);
                    $num_liberados=$result->num_rows;

                    $sql="SELECT DISTINCT  `id_aclaracion` 
FROM  `historial_estados` 
WHERE  `area_id_area` =  '$id_area'
AND  `users_id_usuario` =  '$id_user'";
                    $result=$mysqli->query($sql);
                    $num_rechazado=$result->num_rows;

                  ?>
                  <div class="datos_totales">
                <p>Total de solicitudes pendientes (Universo ATC): <span><?php echo $num_pendientes; ?></span></p> 
                <p>Total de solicitudes pendientes (Subconjunto ATC): <span><?php echo $num_liberados; ?></span></p> 
                <p>Total de solicitudes Atendidas: <span><?php echo $num_rechazado; ?></span> </p> 
                <p>Total de solicitudes: <span><?php echo $num_pendientes+$num_liberados+$num_rechazado; ?></span></p> 
                  </div>
<!--
                  <div class="datos_totales right">
                <p>Solicitudes pendientes fuera dei tiempo: <span>0</span></p> 
                  </div>
                </div>-->
                <?php 
                  $sql_estado="SELECT estado_sol
                          FROM estado_solicitud
                         WHERE id_estado_solicitud=0";
                  $result_estado=$mysqli->query($sql_estado);
                  $row=$result_estado->fetch_array(MYSQLI_ASSOC);

                ?>
                                                  <H2>Solicitudes <?php //echo $row['estado_sol'];?></H2>
                    <table class="gridview">
<tr >
                        <td colspan="11" align="right" bgcolor="00517A"><font color="#fff">Filtro de solicitud:
<form action="#" method="post" id="id_estados_sol">
                        <select id='select_ATC' name="id_estado_sol">
<option value='...'>---</option> 
<?php
  $sql_per="SELECT pe.id_estado_solicitud, es.estado_sol
          FROM permisos pe
    INNER JOIN estado_solicitud es ON pe.id_estado_solicitud=es.id_estado_solicitud 
         WHERE permiso=1 AND id_area='$id_area'";

    $result=$mysqli->query($sql_per);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>
  <option value='<?php echo $row['id_estado_solicitud']; ?>'><?php echo $row['estado_sol']; ?></option> 
                        
<?php } ?>
                    
</select></font></form></td>
                        
                        
                        
                    </tr>

                   <tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                        <td ><font color="#fff">Tipo Solicitud</font></td>
                       
                        <td ><font color="#fff">Línea de Negocio</font></td>
                        <td ><font color="#fff">Código de Cliente</font></td>
                        <td ><font color="#fff">Proceso</font></td>
                        <td ><font color="#fff">Fecha Cierre</font></td>
                        <td></td>
                  </tr>
<?php 

if ($id_estado_click==0){

$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null
and estatus = ('0' and '3') 
"  ;
echo '0';
}

if ($id_estado_click==1){

$sql = "SELECT * FROM `aclaracion_queja` 
		  WHERE `reservada` = '1' 
		  and `usuario_reserva` = '$id_user'
		  and estatus = '1' 		  
		  ";

/*
$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null"  ;
*/
echo '1';

}

if (($id_estado_click==2) || ($id_estado_click==5) || ($id_estado_click==6)){
/*
$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null"  ;
*/
echo '2';
}

if ($id_estado_click==3){

/*
$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null"  ;
*/
echo '3';
}

if ($id_estado_click==4){
/*
$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null"  ;
*/
echo '4';
}

if ($id_estado_click==7){

/*
$sql="SELECT * 
FROM  `aclaracion_queja` 
WHERE  `area_flujo` =  '$id_area'
and reservada is null"  ;
*/
echo '5';

}


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
                       
                        <td ><?php echo $row["linea_negoc"]; ?></td>
                        <td ><?php echo $row["cod_cte"]; ?></td>
                        <td ><?php echo $row["proceso"]; ?></td>
                        <td ><?php echo $row["fecha_cierre"]; ?></td>                 
               		
                        <td>
                          <?php 
                          if ($id_estado_click==0){
                          ?>
                              <a href="#" class="tomar_solicitudATC" id="<?php echo $row['id']; ?>"><span class="icon-checkmark espacio"></span></a>
                          <?php 
                            } 
                          if(($id_estado_click==1) || ($id_estado_click==2) || ($id_estado_click==5) || ($id_estado_click==6)){
                          ?>
                              <a href="#" class="seguir_solicitud" id="<?php echo $row['id']; ?>" rel="<?php echo $row['id']; ?>" title="ATC"><span class="icon-eye espacio"></span></a>
                          <?php
                            }
                          if (($id_estado_click==1) AND ($id_area_op==2)){
                          ?>
                          <!--  <a href="#" class="asignar_solicitudATC" id="<?php echo $row['id']; ?>" rel="<?php echo $row['id']; ?>" title="ASIGNACION TEMM"><span class="icon-delicious espacio"></span></a>-->
                          <?php
                            }
                          if ($id_estado_click==1){
                          ?>
                              <a href="#" class="liberar_solicitudATC" id="<?php echo $row['id']; ?>"><span class="icon-close espacio"></span></a>
                          <?php 
                             } ?>
                       

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