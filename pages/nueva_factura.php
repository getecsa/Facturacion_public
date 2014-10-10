<div id="divNotificacion" />
  <div class="contenedor">
              <div class="header">
                  <img alt="Movistar" class="logotipo" src="images/logo.png" />
                  <h1>Nueva Factura</h1>
              </div>
  <div class="content">

<?php
include("config.php");

$sql_iva="select * from iva";
$result_iva=mysql_db_query($db, $sql_iva,$link);

$sql_moneda="select * from moneda";
$result_moneda=mysql_db_query($db, $sql_moneda,$link);

if( (!isset($_POST["tipo_cliente"])) || (!isset($_POST["tipo_documento"]))  ){

    header('Location: homepage.php?id=nueva_solicitud');
}

$tipo_cliente=$_POST["tipo_cliente"];
$tipo_documento=$_POST["tipo_documento"];
$return=0;
$num_return=0;
//return

if(isset($_POST["submit_return"])) {    
$return=1;

$array_cont=$_POST["array_cont"];  
$num_concepto=$_POST['num_concepto'];
$num_return=$num_concepto;
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

}
//termina return

?>
                  <form class="formulario_n" action="homepage.php?id=nueva_factura_pro" method="post" name="form1" id="form1">

                   
                    <fieldset>
                    
                      <div class="column">
                        <label for="cod_cliente">Código de cliente:</label><input type="text" name="cod_cliente" id="cod_cliente" <?php if($return==1){ echo 'value="'.$cod_cliente.'"';} else{ ?> value="<?php echo $_POST['codigo_cliente']; }?>" />
                        <label for="motivo_sol">Motivo de solicitud:</label><input type="text" name="motivo_sol" id="motivo_sol" <?php if($return==1){ echo 'value="'.$motivo_sol.'"';} ?> />
                        <label for="dias_ven">Días de vencimiento:</label><input type="text" name="dias_ven" id="dias_ven" <?php if($return==1){ echo 'value="'.$dias_ven.'"';} ?> />
                        <label for="leyenda_doc">Leyenda del documento:</label><input type="text" name="leyenda_doc" id="leyenda_doc" <?php if($return==1){ echo 'value="'.$leyenda_doc.'"';} ?> />
                      </div>  
                      <div class="column bottom">   
                      <label for="iva">IVA:</label>
                      <select id="iva" name="iva">
                      		<option value="0">Seleccione IVA</option>
                      <?php 
                            while($row=mysql_fetch_array($result_iva)){
                            echo "<option value='",$row['id_iva'],"'";
                              if($return==1){ 
                                if($row['id_iva']==$iva)
                                  {
                                    echo"selected";
                                  }
                                } 
                            echo ">",$row['valor_tx'],"</option>";
                              }
                          ?>
                      </select>
                      <label for="leyenda_mat">Leyenda Material:</label><input type="text" name="leyenda_mat" id="leyenda_mat" <?php if($return==1){ echo 'value="'.$leyenda_mat.'"';} ?> />
                      </div>

                      <div class="column">      
                        <label for="razon_social">Razón Social:</label><input type="text" name="razon_social" id="razon_social" <?php if($return==1){ echo 'value="'.$razon_social.'"';} ?> />
                        <label for="compa_fac">Compañía facturadora:</label><input type="text" name="compa_fac" id="compa_fac" <?php if($return==1){ echo 'value="'.$compa_fac.'"';} ?>  />
                        <label for="moneda">Moneda:</label>
                        <select name="moneda">
                        	<option value="0">Seleccione Moneda</option>
                          <?php 
                            while($row=mysql_fetch_array($result_moneda)){
                            echo "<option value='",$row['id_moneda'],"'";
                              if($return==1){ 
                                if($row['id_moneda']==$moneda)
                                  {
                                    echo"selected";
                                  }
                                } 
                            echo ">",$row['moneda'],"</option>";
                              }
                          ?>
                        </select>


                        <label for="salida">Salida:</label><input type="text" name="salida" id="salida" <?php if($return==1){ echo 'value="'.$salida.'"';} ?> />
                      </div>
                    
  <div id="detalles_factura">
  <table class="gridview" id="agregar_detalle">
    <tr>
      <td>Código Concepto</td>
      <td>Descripción Concepto</td>
      <td>Unidades</td>
      <td>Precio Unitario</td>
      <td>Cargo</td>
      <td>Descuento</td>
      <td>Subtotal</td>
    </tr>

      <?php
    if($return==1){
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
    
     <?php }  } else {?>

    <tr class="add_factura">
      <td><input type="text" size="10" name="add_cont[1][0]" /> </td>
      <td><input type="text" name="add_cont[1][1]" /></td>
      <td><input type="text" size="10" name="add_cont[1][2]" class="calcular_subtotal total_unidades" /></td>
      <td><input type="text" size="10" name="add_cont[1][3]" class="calcular_subtotal" /></td>
      <td><input type="text" size="10" name="add_cont[1][4]" readonly class="suma_cargo"/></td>
      <td><input type="text" size="10" name="add_cont[1][5]" class="calcular_subtotal" value="0"/></td>
      <td><input type="text" size="10" name="add_cont[1][6]" readonly class="suma_subtotal" /></td>
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
<!--   <tr>
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
   </tr> -->
  </table>
   <div id="errorForm"></div> 
        </fieldset>
                   <div class="boton_envio">
                    <input  type="hidden" value="<?php echo $return; ?>" name="return" id="return">
                    <input  type="hidden" value="<?php echo $num_return; ?>" name="num_return" id="num_return">
                    <input  type="hidden" id="num_concepto" value="1" name="num_concepto">
                    <input  type="hidden"  value="<?php echo $tipo_cliente; ?>" name="tipo_cliente">
                    <input  type="hidden"  value="<?php echo $tipo_documento; ?>" name="tipo_documento">
                    <input type="submit" id="submit" name="submit" value="Enviar" onclick="return validarUsuarioForm();" >
                    <input type="reset" value="Borrar" >
                  </div>

        </form> 
      
      </div>
    </div>
 </div>   
 
 