<?php
 include("configuracion.php");

 $area_operador=$_SESSION['tx_area'];
 if(isset($_POST["valor_solicitud"])) {

  
  $id_solicitud=$_POST["valor_solicitud"];
  $id_documento=$_POST["id_documento"];
  
echo $id_solicitud;

echo $id_documento;

$sql = "SELECT *  FROM `aclaracion_queja` WHERE `id` = '$id_solicitud'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);



}  
  
?>
<div id="divNotificacion" />

        <div class="contenedor">
            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                <h1><?php echo $area_operador;?>
                </h1>    
            </div>
            <div class="content">
<form method="POST" action="homepage.php?id=operacion_ATC">                
               <table class="gridview"  id="tabla" >
                    
 <tr bgcolor="00517A">
                        <td ><font color="#fff">Código de Cliente</font></td>
								<td ><font color="#fff">Línea de Negocio</font></td>                                               
                        <td ><font color="#fff">Tipo Solicitud</font></td>                        
                        
                       	<td ><font color="#fff">Fecha Recepción</font></td>
                        <td ><font color="#fff">Fecha Atención</font></td>
                       
                       
                       
                  </tr>	
 						 <tr >
                        <td ><?php echo $row["cod_cte"]; ?></td>
    							<td ><?php echo $row["linea_negoc"]; ?></td>                    
								<td ><?php echo $row["tipo_solic"]; ?></td>                        
                        <td ><?php echo $row["fecha_recep"]; ?></td>
                        <td ><?php echo $row["fecha_atenc"]; ?></td>
								
                                                                                       
                    </tr>	                                      
                    
						  <tr bgcolor="00517A">
								<td ><font color="#fff">Detalle Solicitud</font></td>
                    </tr>

                    <tr >
								 <td ><?php echo $row["detalle_solic"]; ?></td>
                    </tr>
                      <tr bgcolor="00517A">
								<td ><font color="#fff">Agregar observación</font></td>
								<td ><font color="#fff">Estatus</font></td>
								<td></td>
                    </tr>
                    <tr >
								 <td ><textarea COLS="25" ROWS="2" name="detalle_solic">
                             </textarea></td>
                         <td><select>
                         <option value='0'>SELECCIONE ESTATUS</option>
<?php
  $sql_per="SELECT *
          FROM area 
         WHERE oper_sol = '0'";

    $result=$mysqli->query($sql_per);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    	if($row['tx_area']<>'DIRECCIONAMIENTO' && $row['tx_area']<>'ASIGNACION TEMM' && $row['tx_area']<>'ENTREGA DE DOCUMENTOS' && $row['tx_area']<> $area_operador) {
?>                         
 <option value='<?php echo $row['id_area']; ?>'><?php echo $row['tx_area']; ?></option> 
                        
<?php 
}
} ?>
<option value='Aceptada'>CERRAR</option>
                         </select></td>
                         <td  align="center"><input type="submit" ID="btnLogin"  value="Enviar" ></td>
                    </tr>             
                   
                    <tr>
                     
                       
                    </tr>
            </table>
</form>
                
            </div>
            
        </div>
    


 </div>   	