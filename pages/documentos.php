<?php
//tipo documento
 
     session_start();
     $id_usuario=$_SESSION['uid'];
     $id_area=$_SESSION['area'];


include("../configuracion.php");

 if(isset($_POST['idCliente'])) {
     $id_tipo_cliente=$_POST['idCliente'];
        $documentos = array();

             $sql="SELECT   permisos.id_tipo_documento as id_tipo_documento, tipo_documento.tipo_doc as tx_documento
                     FROM   permisos
               INNER JOIN   tipo_documento
                       ON   permisos.id_tipo_documento = tipo_documento.id_tipo_doc
                    WHERE   id_area ='$id_area' and id_tipo_cliente='$id_tipo_cliente' and permiso=1";

       // $result=mysql_db_query($db, $sql, $link);
        $result=$mysqli->query($sql);
     while($row = $result->fetch_array(MYSQLI_ASSOC)){
     //while($row = mysql_fetch_array($result)){
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

    
?>