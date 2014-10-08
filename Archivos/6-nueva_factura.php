<div id="divNotificacion" />
  <div class="contenedor">
              <div class="header">
                  <img alt="Movistar" class="logotipo" src="images/logo.png" />
                  <h1>Nueva Factura</h1>
              </div>
  <div class="content">

<?php
include("config.php");

 if(isset($_POST["submit_return"])) {    

$sql_iva="select * from iva";
$result_iva1=mysql_db_query($db, $sql_iva,$link); 

$sql_moneda="select * from moneda";
$result_moneda1=mysql_db_query($db, $sql_moneda,$link);



$array_cont=unserialize($_POST["array_cont"]);
$num_concepto=$_POST['num_concepto'];
$num_concepto2=$num_concepto;
$cod_cliente=$_POST['cod_cliente'];
$motivo_sol=$_POST['motivo_sol'];
$dias_ven=$_POST['dias_ven'];
$leyenda_doc=$_POST['leyenda_doc'];
$iva=$_POST["iva"];
$leyenda_mat=$_POST['leyenda_mat'];
$razon_social=$_POST['razon_social'];
$compa_fac=$_POST['compa_fac'];
$moneda=$_POST['moneda'];
$salida=$_POST['salida'];
$tipo_cliente=$_POST['tipo_cliente'];
$tipo_documento=$_POST['tipo_documento'];
$id_area=$_SESSION['area'];
$id_usuario=$_SESSION['uid'];
var_dump($array_cont);
?>


                  <form class="formulario_n" action="homepage.php?id=nueva_factura_pro" method="post">
                    <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><input type="text" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>" />
                        <label for="motivo_sol">Motivo de solicitud:</label><input type="text" name="motivo_sol" id="motivo_sol" value="<?php echo $motivo_sol;?>"/>
                        <label for="dias_ven">Días de vencimiento:</label><input type="text" name="dias_ven" id="dias_ven" value="<?php echo $dias_ven?>"/>
                        <label for="leyenda_doc">Leyenda del documento:</label><input type="text" name="leyenda_doc" id="leyenda_doc" value="<?php echo $leyenda_doc;?>"/>
                      </div>  
                      <div class="column bottom">   
                      <label for="iva">IVA:</label>
                      
                      <select id="iva" name="iva">
                      <?php 
									$sql_iva="select * from iva where id_iva=$iva";
                            $result_iva=mysql_db_query($db, $sql_iva,$link);
                            if($row=mysql_fetch_array($result_iva)){
                            $id_iva=$row['id_iva'];
                           echo  '<option value="'.$iva.'">'.$row['valor_tx'].'</option>';
                           
                              }					                      
                     			 
                            while($row=mysql_fetch_array($result_iva1)){
                            echo "<option value='",$row['id_iva'],"'>",$row['valor_tx'],"</option>";
                              }
                          ?>
                      </select>
                      <label for="leyenda_mat">Leyenda Material:</label><input type="text" name="leyenda_mat" id="leyenda_mat" value="<?php echo $leyenda_mat;?>"/>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><input type="text" name="razon_social" id="razon_social" value="<?php echo $razon_social;?>"/>
                        <label for="compa_fac">Compañia facturadora:</label><input type="text" name="compa_fac" id="compa_fac" value="<?php echo $compa_fac;?>"/>
                        <label for="moneda">Moneda:</label>
                        <select name="moneda">
                        <?php 
									 $sql_moneda="select * from moneda where id_moneda=$moneda";
                            $result_moneda=mysql_db_query($db, $sql_moneda,$link);
                            if($row=mysql_fetch_array($result_moneda)){
                            echo  '<option value="'.$moneda.'">'.$row['moneda'].'</option>';
                              
                              }					                      
                     			 
                            while($row=mysql_fetch_array($result_moneda1)){
                            echo "<option value='",$row['id_moneda'],"'>",$row['moneda'],"</option>";
                              }
                          ?>
                          
                        </select>


                        <label for="salida">Salida:</label><input type="text" name="salida" id="salida" value="<?php echo $salida;?>"/>
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
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>"/> </td>
      <td><input type="text" name="add_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][2]" class="calcular_subtotal total_unidades" value="<?php echo $array_cont[$i][2]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][3]" class="calcular_subtotal" value="<?php echo $array_cont[$i][3]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][4]" readonly class="suma_cargo" value="<?php echo $array_cont[$i][4]; ?>"/></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][5]" class="calcular_subtotal" value="<?php echo $array_cont[$i][5]; ?>" /></td>
      <td><input type="text" size="10" name="add_cont[<?php echo $i; ?>][6]" readonly class="suma_subtotal" value="<?php echo $array_cont[$i][6]; ?>" /></td>
    </tr>
    
     <?php } ?>
     
    </table>
    <table class="gridview">
    <tr>
    <td colspan="3"><a href="#" id="agregar_campo_fac"><div class="agregar_observacion botones">Agregar Concepto</div></a></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr> 
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>SubTotal:</td>
    <td></td>
    <td></td>
    <td class="total_subtotal">$0</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IVA:</td>
    <td></td>
    <td></td>
    <td>$32</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IEPS:</td>
    <td></td>
    <td></td>
    <td>$0</td>
   </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>Total:</td>
    <td></td>
    <td></td>
    <td>$200</td>
   </tr>
  </table> 
        </fieldset>
                   <div class="boton_envio">
                    <input  type="hidden" id="num_concepto2" value="<?php  echo $num_concepto2; ?>" name="num_concepto2">
                    <input  type="hidden" id="num_concepto" value="1" name="num_concepto">
                    <input  type="hidden"  value="<?php echo $tipo_cliente; ?>" name="tipo_cliente">
                    <input  type="hidden"  value="<?php echo $tipo_documento; ?>" name="tipo_documento">
                    <input type="submit" id="submit" name="submit" value="Enviar" >
                    <input type="reset" value="Borrar" >
                  </div>

        </form>

<?php
 
}

else { 

$sql_iva="select * from iva";
$result_iva=mysql_db_query($db, $sql_iva,$link);

$sql_moneda="select * from moneda";
$result_moneda=mysql_db_query($db, $sql_moneda,$link);

if( (!isset($_POST["tipo_cliente"])) || (!isset($_POST["tipo_documento"]))  ){

    header('Location: homepage.php?id=nueva_solicitud');
}

$tipo_cliente=$_POST["tipo_cliente"];
$tipo_documento=$_POST["tipo_documento"];

?>
                  <form class="formulario_n" action="homepage.php?id=nueva_factura_pro" method="post">
                    <fieldset>
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><input type="text" name="cod_cliente" id="cod_cliente" value="<?php echo $_POST['codigo_cliente'];?>" />
                        <label for="motivo_sol">Motivo de solicitud:</label><input type="text" name="motivo_sol" id="motivo_sol"/>
                        <label for="dias_ven">Días de vencimiento:</label><input type="text" name="dias_ven" id="dias_ven" />
                        <label for="leyenda_doc">Leyenda del documento:</label><input type="text" name="leyenda_doc" id="leyenda_doc"/>
                      </div>  
                      <div class="column bottom">   
                      <label for="iva">IVA:</label>
                      <select id="iva" name="iva">
                          <?php 
                            while($row=mysql_fetch_array($result_iva)){
                            echo "<option value='",$row['id_iva'],"'>",$row['valor_tx'],"</option>";
                              }
                          ?>
                      </select>
                      <label for="leyenda_mat">Leyenda Material:</label><input type="text" name="leyenda_mat" id="leyenda_mat"/>
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><input type="text" name="razon_social" id="razon_social"/>
                        <label for="compa_fac">Compañia facturadora:</label><input type="text" name="compa_fac" id="compa_fac" />
                        <label for="moneda">Moneda:</label>
                        <select name="moneda">
                          <?php 
                            while($row=mysql_fetch_array($result_moneda)){
                            echo "<option value='",$row['id_moneda'],"'>",$row['moneda'],"</option>";
                              }
                          ?>
                        </select>


                        <label for="salida">Salida:</label><input type="text" name="salida" id="salida"/>
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
    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[1][0]" /> </td>
      <td><input type="text" name="add_cont[1][1]" /></td>
      <td><input type="text" size="10" name="add_cont[1][2]" class="calcular_subtotal total_unidades" /></td>
      <td><input type="text" size="10" name="add_cont[1][3]" class="calcular_subtotal" /></td>
      <td><input type="text" size="10" name="add_cont[1][4]" readonly class="suma_cargo"/></td>
      <td><input type="text" size="10" name="add_cont[1][5]" class="calcular_subtotal" /></td>
      <td><input type="text" size="10" name="add_cont[1][6]" readonly class="suma_subtotal" /></td>
    </tr>
    </table>
    <table class="gridview">
    <tr>
    <td colspan="3"><a href="#" id="agregar_campo_fac"><div class="agregar_observacion botones">Agregar Concepto</div></a></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr> 
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>SubTotal:</td>
    <td></td>
    <td></td>
    <td class="total_subtotal">$0</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IVA:</td>
    <td></td>
    <td></td>
    <td>$32</td>
   </tr>   
    <tr>
    <td colspan="3">&nbsp;</td>
    <td>IEPS:</td>
    <td></td>
    <td></td>
    <td>$0</td>
   </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
    <td>Total:</td>
    <td></td>
    <td></td>
    <td>$200</td>
   </tr>
  </table> 
        </fieldset>
                   <div class="boton_envio">
                    <input  type="hidden" id="num_concepto" value="1" name="num_concepto">
                    <input  type="hidden"  value="<?php echo $tipo_cliente; ?>" name="tipo_cliente">
                    <input  type="hidden"  value="<?php echo $tipo_documento; ?>" name="tipo_documento">
                    <input type="submit" id="submit" name="submit" value="Enviar" >
                    <input type="reset" value="Borrar" >
                  </div>

        </form>
 
<?php 
}
?> 



       </div>
    </div>
 </div>   
 
 