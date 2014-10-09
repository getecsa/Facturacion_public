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
                    $num_liberados=$result->num_rows;

                  ?>
                  <div class="datos_totales">
                <p>Total de solicitudes pendientes: <span><?php echo $num_pendientes; ?></span></p> 
                <p>Total de solicitudes liberadas: <span><?php echo $num_liberados; ?></span></p> 
                <p>Total de solicitudes rechazadas: <span><?php echo $num_rechazado; ?></span> </p> 
                <p>Total de solicitudes: <span><?php echo $num_pendientes+$num_liberados+$num_rechazado; ?></span></p> 
                  </div>

                  <div class="datos_totales right">
                <p>Solicitudes pendientes fuera dei tiempo: <span>0</span></p> 
                  </div>
                </div>
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
                        <td colspan="8" align="right" bgcolor="00517A"><font color="#fff">Filtro de solicitud:
<form action="#" method="post" id="id_estados_sol">
                        <select id='select_operador' name="id_estado_sol">
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
                        <td ><font color="#fff">ID Solicitud</font></td>
                        <td ><font color="#fff">ID Documento</font></td>
                        <td ><font color="#fff">Solicitante</font></td>
                        <td ><font color="#fff">Area</font></td>
                        <td ><font color="#fff">Tipo de solicitud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estado</font></td>
                        <td ><font color="#fff">&nbsp;</font></td>
                      
                    </tr>
<?php 

if ($id_estado_click==0){

$sql="SELECT so.id_solicitudes, do.id_documento, us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON do.estado_actual=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE area_flujo='$id_area_op' AND reservada=0 AND estado_actual='$id_estado_click' ORDER BY fecha DESC"  ;

}

if ($id_estado_click==1){
$sql="SELECT so.id_solicitudes, do.id_documento, us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON do.estado_actual=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE usuario_reserva='$id_user' AND area_flujo='$id_area_op' AND reservada=1 
         AND estado_actual='$id_estado_click' ORDER BY fecha DESC"  ;
}

if (($id_estado_click==2) || ($id_estado_click==5) || ($id_estado_click==6)){
$sql="SELECT so.id_solicitudes, do.id_documento, us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON do.estado_actual=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE area_flujo='$id_area_op' AND estado_actual='$id_estado_click' ORDER BY fecha DESC"  ;

}

if ($id_estado_click==3){

$sql="SELECT so.id_solicitudes, do.id_documento,us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM historial_estados hi
  INNER JOIN documento do ON hi.id_documento=do.id_documento
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes      
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON hi.estado_solicitud_idestado_solicitud=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE hi.estado_solicitud_idestado_solicitud=3 AND hi.users_id_usuario='$id_user' 
         AND hi.area_id_area='$id_area_op' ORDER BY fecha DESC";



}

if ($id_estado_click==4){
$sql="SELECT so.id_solicitudes, do.id_documento, us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON do.estado_actual=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE area_flujo='$id_area_op' AND estado_actual='$id_estado_click' ORDER BY fecha DESC"  ;

}

if ($id_estado_click==7){

$sql="SELECT DISTINCT so.id_solicitudes, do.id_documento, us.username,ar.tx_area,td.tipo_doc, date(so.fecha_solicitud) as fecha, es.estado_sol
        FROM documento do
  INNER JOIN solicitudes so ON do.solicitudes_idSolicitudes=so.id_solicitudes
  INNER JOIN historial_estados hi ON do.id_documento=hi.id_documento 
  INNER JOIN tipo_documento td ON do.tipo_documento_idtipo_doc=td.id_tipo_doc
  INNER JOIN area ar ON so.area_idarea=ar.id_area
  INNER JOIN estado_solicitud es ON do.estado_actual=es.id_estado_solicitud
  INNER JOIN users us ON so.users_id_usuario=us.id_usuario
       WHERE do.estado_actual=7 AND hi.users_id_usuario=5 
         AND hi.area_id_area=6 ORDER BY fecha DESC;";
}


    $result=$mysqli->query($sql);
    $bgcolor=0;
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
      if ($bgcolor%2==0){ $color="FFFFFF"; $bgcolor++; } else { $color="CEF6F5"; $bgcolor++;}
?>
                    <tr  bgcolor="<?php echo $color; ?>">
                        <td><?php echo $row['id_solicitudes']; ?></td>
                        <td><?php echo $row['id_documento']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['tx_area']; ?></td>
                        <td><?php echo $row['tipo_doc']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['estado_sol']; ?></td>
                        <td>
                          <?php 
                          if ($id_estado_click==0){
                          ?>
                          <a href="#" class="tomar_solicitud" id="<?php echo $row['id_documento']; ?>"><span class="icon-checkmark espacio"></span></a>
                          <?php 
                            } else {

                              if(($id_estado_click==1) || ($id_estado_click==2) || ($id_estado_click==5) || ($id_estado_click==6)){
                              
                          ?>
                          <a href="#" class="seguir_solicitud" id="<?php echo $row['id_solicitudes']; ?>" rel="<?php echo $row['id_documento']; ?>" title="<?php echo $row['tipo_doc']; ?>"><span class="icon-eye espacio"></span></a>
                           <?php
                                }
                            if ($id_estado_click==1){
                              ?>
                          <a href="#" class="liberar_solicitud" id="<?php echo $row['id_documento']; ?>"><span class="icon-close espacio"></span></a>
                            <?php } ?>
                          <a href="ver_historial.php?sol=<?php echo $row['id_documento']; ?>&height=450&width=650" title="Documento <?php echo $row['id_documento']; ?>" class="thickbox"><span class="icon-stack espacio"></span></a>
                           <?php } ?>
                        </td>
                    </tr>
<?php }  

?>
                            
            </table>

     </div>
        </div>
<form  action="#" method="post" id="tomar_solicitud">
  <input type="hidden" name="valor_solicitud" id="valor_solicitud" value="#">
  <input type="hidden" name="id_documento" id="id_documento" value="#">
  <input type="hidden" name="accion" id="accion" value="#">
</form>