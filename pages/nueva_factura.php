<?php
include("configuracion.php");
if( (!isset($_POST["tipo_cliente"])) || (!isset($_POST["tipo_documento"]))  ){
    header('Location: homepage.php?id=nueva_solicitud');
}
$tipo_cliente=$_POST["tipo_cliente"];

$sql="select * from tipo_cliente where id_tipo_cliente='$tipo_cliente'";
$result=$mysqli->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);


?>
<div id="divNotificacion" />
  <div class="contenedor">
              <div class="header">
                  <img alt="Movistar" class="logotipo" src="images/logo.png" />
                  <h1 class="h1_header">Nueva Factura</h1> <h2 class="subtitulo"><?=$row['tx_tipo_cliente']?></h2>
              </div>
  <div class="content">

<?php
$cod_cliente=$_POST['cod_cliente'];
$razon_social=$_POST['razon_social'];


$sql_iva="SELECT i.valor_tx, i.valor_int, i.id_iva
            FROM iva i
      INNER JOIN permisos pe ON i.id_iva = pe.id_iva
           WHERE pe.permiso =1 AND pe.id_tipo_documento =1
             AND pe.id_tipo_cliente ='$tipo_cliente'";
$result_iva=$mysqli->query($sql_iva);

$sql_moneda="SELECT m.id_moneda, m.moneda
            FROM moneda m
      INNER JOIN permisos pe ON m.id_moneda = pe.id_moneda
           WHERE pe.permiso =1 AND pe.id_tipo_documento =1
             AND pe.id_tipo_cliente ='$tipo_cliente'";
$result_moneda=$mysqli->query($sql_moneda);

$sql_compania="SELECT li.sociedad
                 FROM linea_negocio li
           INNER JOIN permisos pe ON li.id=pe.id_linea_negocio
                WHERE pe.permiso=1 AND pe.id_tipo_documento=1
                  AND pe.id_tipo_cliente='$tipo_cliente'";
$result_compania=$mysqli->query($sql_compania);



  $sql_t="select conexion, caracteres from tipo_cliente where id_tipo_cliente='$tipo_cliente'";
     $result_t=$mysqli->query($sql_t);
     $row_t=$result_t->fetch_array(MYSQLI_ASSOC);
     $conexion=$row_t['conexion'];
     $caracteres=$row_t['caracteres'];

 // RFC="SELECT COD_CLIENTE, NOM_CLIENTE ||' ' || NOM_APECLIEN1||' '|| NOM_APECLIEN2 FROM FA_HISTCLIE_19010102"

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

                      <div class="column">
                          <label for="cod_cliente"><p>Código de cliente:</p></label>
                          <input type="text" name="cod_cliente" id="cod_cliente" readonly <?php if($return==1){ echo 'value="'.$cod_cliente.'"';} else{ ?> value="<?php echo $_POST['cod_cliente']; }?>" />
                          <label for="motivo_sol"><p>Motivo de solicitud:</p></label>
                          <input type="text" name="motivo_sol" id="motivo_sol" <?php if($return==1){ echo 'value="'.$motivo_sol.'"';} ?> />
                          <label for="dias_ven"><p>Días de vencimiento:</p></label>
                          <input type="text" name="dias_ven" id="dias_ven" <?php if($return==1){ echo 'value="'.$dias_ven.'"';} ?> />
                          <label for="leyenda_doc"><p>Leyenda del doc.:</p></label>
                          <input type="text" maxlength="<?=$caracteres ?>" name="leyenda_doc" id="leyenda_doc"  <?php if($return==1){ echo 'value="'.$leyenda_doc.'"';} ?> />
                      </div>
                      <div class="column_rz">
                          <label for="razon_social"><p>Razón Social:</p></label><input type="text" size="73" name="razon_social" id="razon_social" readonly <?php echo 'value="'.$razon_social.'"'; ?> />
                      </div>
                        <div class="column_enmedio espacio">
                          <label for="moneda"><p>Moneda:</p></label>
                          <select name="moneda" id="moneda">
                              <option value="0">Seleccione Moneda</option>
                              <?php
                              while($row=$result_moneda->fetch_array(MYSQLI_ASSOC)){
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
                          <label for="iva"><p>IVA:</p></label>
                      <select id="iva" name="iva">
                          <option value="0">Seleccione IVA</option>
                      <?php
                            while($row=$result_iva->fetch_array(MYSQLI_ASSOC)){
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
                          <label for="salida"><p>Salida:</p></label><input type="text" name="salida" id="salida" <?php if($return==1){ echo 'value="'.$salida.'"';} ?> />

                      </div>

                      <div class="column">
                        <label for="compa_fac"><p>CIA facturadora:</p></label>
                          <select name="compa_fac" id="compa_fac">
                              <option value="0">Seleccione Compañia</option>
                              <?php
                              while($row=$result_compania->fetch_array(MYSQLI_ASSOC)){
                                  echo "<option value='",$row['sociedad'],"'";
                                  if($return==1){
                                      if($row['sociedad']==$compa_fac)
                                      {
                                          echo"selected";
                                      }
                                  }
                                  echo ">",$row['sociedad'],"</option>";
                              }
                              ?>
                          </select>
                      </div>

  <div id="detalles_factura">
  <table class="gridview" id="agregar_detalle">
    <tr>
      <td>Código Concepto</td>
      <td>Descripción Concepto</td>
      <td>Leyenda Material</td>
      <td>Unidades</td>
      <td>Precio Unitario</td>
      <td>Cargo</td>
      <td>Descuento</td>
      <td>Subtotal</td>
      <td></td>
    </tr>

      <?php
    if($return==1){
    $subtotal=0;
    for($i=1;$i<=$num_concepto;$i++){
    $subtotal=$subtotal+$array_cont[$i][6];
    ?>
  
    <tr class="add_factura">
      <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][0]" value="<?php echo $array_cont[$i][0]; ?>"/> </td>
      <td><input type="text" name="add_cont[<?php echo $i; ?>][1]" value="<?php echo $array_cont[$i][1]; ?>" /></td>
      <td><input type="text" size="9" maxlength="<?=$caracteres ?>" name="add_cont[<?php echo $i; ?>][7]" value="<?php echo $array_cont[$i][7]; ?>" /> </td>
    <!--  <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][3]" class="calcular_subtotal"  /></td> -->
      <td><input type="text" size="5" name="add_cont[<?php echo $i; ?>][2]" class="calcular_subtotal total_unidades" value="<?php echo $array_cont[$i][2]; ?>" /></td>
      <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][3]" class="calcular_subtotal" value="<?php echo $array_cont[$i][3]; ?>" /></td>
      <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][4]" readonly class="suma_cargo" value="<?php echo $array_cont[$i][4]; ?>"/></td>
      <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][5]" class="calcular_subtotal" value="<?php echo $array_cont[$i][5]; ?>" /></td>
      <td><input type="text" size="9" name="add_cont[<?php echo $i; ?>][6]" readonly class="suma_subtotal" value="<?php echo $array_cont[$i][6]; ?>" /></td>
      <td></td>
    </tr>
    
     <?php }  } else {      ?>
    <tr class="add_factura">
      <?php 
        //validar conexiones para 0 ninguna 1 SCL 2 SAP 
          if($conexion == 1){
      ?>

              <td><select id="num_principal" name="add_cont[1][0]" class="descripcion_concepto"></select></td>
              <td><select id="txt_principal" name="add_cont[1][1]" class="descripcion_concepto"></select></td>
        <?php  } else {?>
      <td><input type="text" size="9" name="add_cont[1][0]" /> </td>
      <td><input type="text" name="add_cont[1][1]" /></td>
        <?php } ?>
      <td><input type="text" size="9" maxlength="<?=$caracteres ?>" name="add_cont[1][7]" /> </td>
      <td><input type="text" size="5" name="add_cont[1][2]" class="calcular_subtotal total_unidades" /></td>
      <td><input type="text" size="9" name="add_cont[1][3]" class="calcular_subtotal" /></td>
      <td><input type="text" size="9" name="add_cont[1][4]" readonly class="suma_cargo"/></td>
      <td><input type="text" size="9" name="add_cont[1][5]" class="calcular_subtotal" value="0"/></td>
      <td><input type="text" size="9" name="add_cont[1][6]" readonly class="suma_subtotal" /></td>
    </tr>
    <?php } ?>
    </table>
      <a href="#" id="agregar_campo_fac"> <div class="agregar_observacion botones">Agregar Concepto</div></a>
   <div id="errorForm"></div> 

                   <div class="boton_envio">
                    <input  type="hidden" value="0" name="lista_concepto_cod" id="lista_concepto_cod">
                    <input  type="hidden" value="0" name="lista_concepto_tex" id="lista_concepto_tex">
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
<script type='text/javascript'>
    $(document).ready(function(){
        //$('#main').docFactura($cod_cliente);
        $('#main').listaConceptos();
        $('#main').numConceptos('#num_principal');
        $('#main').txtConceptos('#txt_principal');
        //window.location.replace('homepage.php?id=nueva_solicitud');
    });
</script>
 
 