<?php
session_start();

 //Validar que el usuario este logueado y exista un UID
if ( ! ($_SESSION['autenticado'] == 'SI' && isset($_SESSION['uid'])) )
{
    header('location: index.php');
}

    $id_usuario=$_SESSION['uid'];
    $id_area=$_SESSION['area'];

// form anidado 


include("conectar_bd.php");  
conectar_bd();
     
include("cliente.php");

?>
   <div id="divNotificacion" />
    
        <?php include('menu.php'); ?>

        <div class="contenedor">
            <div class="header">
                 <h1 class="h1_header">
                   Nueva Solicitud
                </h1>
            
            </div>
                <div class="content">
                    <form action="#">
                        <table class="content">
<?php
/* 
include("conectar_bd.php");  
conectar_bd();
     
    $id_usuario=$_SESSION['uid'];
    $id_area=$_SESSION['area'];

    $sql="SELECT DISTINCT  tipo_cliente.tx_tipo_cliente as tipo_cliente, permisos.id_tipo_cliente as id_tipo_cliente
                     FROM   permisos
               INNER JOIN   tipo_cliente
                       ON   permisos.id_tipo_cliente = tipo_cliente.id_tipo_cliente
                    WHERE   id_area ='$id_area'";
    $result = mysql_query($sql,$conexion); 
  */      
?>
  <!--                                      <tr>
                                            <td>Tipo de cliente:</td>   
                                            <td>
   
                                           <select>
                                            <?php 
                                                    while( $row=mysql_fetch_array($result) )
                                                {  
                                                    echo "<option>",$row['tipo_cliente'],"</option>";
                                                }
                                             ?> 
                                            </select>
                                            </td>
                                        </tr>
  -->

<tr>
  <td>Tipo de cliente: </td>
  <td>

            <select id="cboClientes">
                <option value="0">Seleccione un Tipo de Cliente</option>
                <?php
                    $clientes = obterTiposClientes();
                    echo $clientes;
                    foreach ($clientes as $cliente) { 
                        echo '<option value="'.$cliente->id.'">'.$cliente->nombre.'</option>';        
                    }
                ?>
            </select>
        </div>
            

                                        <tr>
                                            <td>Tipo de documento:</td>    
                                            <td><select id="cboDocumentos">
                                                <option value="0">Seleccione un Documento</option>
                                               </select>
                                            </td>
                                        </tr>        
                                      
                                        <tr>
                                           <td>Código cliente:</td>  
                                           <td><input type="text" value="" name="cod_cte"></td>
                                        </tr>
                                        <tr>
                                           <td></td>  
                                           <td><input type="submit" ID="btnLogin"  value="Enviar" ></td>
                                        </tr>
                                </table>
                    </form>

               </div>
        </div>
</div>