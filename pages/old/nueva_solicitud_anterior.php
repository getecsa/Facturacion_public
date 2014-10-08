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
include("config.php");  
//clientes

    function obterTiposClientes() {
    session_start();
     $id_usuario=$_SESSION['uid'];
     $id_area=$_SESSION['area'];
      include("config.php");  


    $clientes = array();  
    $sql="SELECT DISTINCT  tipo_cliente.tx_tipo_cliente as tipo_cliente, permisos.id_tipo_cliente as id_tipo_cliente
                     FROM   permisos
               INNER JOIN   tipo_cliente
                       ON   permisos.id_tipo_cliente = tipo_cliente.id_tipo_cliente
                    WHERE   id_area ='$id_area' and permiso=1";

         $result=mysql_db_query($db, $sql, $link);

        while($row = mysql_fetch_array($result)){
            $cliente = new cliente($row['id_tipo_cliente'], $row['tipo_cliente']);
            array_push($clientes, $cliente);
        }

        return $clientes;

    }


    class cliente {
        public $id;
        public $nombre;

        function __construct($id, $nombre) {
            $this->id = $id;
            $this->nombre = $nombre;
        }
    }



//documentos

 if(isset($_POST['idCliente'])) {
     $id_tipo_cliente=$_POST['idCliente'];
      $documentos = array();

             $sql="SELECT   permisos.id_tipo_documento as id_tipo_documento, tipo_documento.tipo_doc as tx_documento
                     FROM   permisos
               INNER JOIN   tipo_documento
                       ON   permisos.id_tipo_documento = tipo_documento.id_tipo_doc
                    WHERE   id_area ='$id_area' and id_tipo_cliente='$id_tipo_cliente' and permiso=1";

        $result=mysql_db_query($db, $sql, $link);

     while($row = mysql_fetch_array($result)){
            $documento = new documento($row['id_tipo_documento'], $row['tx_documento']);
            array_push($documentos, $documento);
        }

        echo json_encode($documentos);
    }

     class documento {
        public $id;
        public $nombre;

        function __construct($id, $nombre) {
            $this->id = $id;
            $this->nombre = $nombre;
        }
    }


//fin
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