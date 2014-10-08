<?php
    
    function obterTiposClientes() {
    session_start();
     $id_usuario=$_SESSION['uid'];
     $id_area=$_SESSION['area'];
/*

    $elUsr = "root";
    $elPw  = "getecsa"; 
    $elServer ="localhost";
    $laBd = "sis_fac";
     
    //Conectar
    $conexion = mysql_connect($elServer, $elUsr , $elPw) or die (mysql_error());
     
*/
include("config.php");

    $clientes = array();  
    $sql="SELECT DISTINCT  tipo_cliente.tx_tipo_cliente as tipo_cliente, permisos.id_tipo_cliente as id_tipo_cliente
                     FROM   permisos
               INNER JOIN   tipo_cliente
                       ON   permisos.id_tipo_cliente = tipo_cliente.id_tipo_cliente
                    WHERE   id_area ='$id_area' and permiso=1";
  //  $result = mysql_query($sql,$conexion); 
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

?>