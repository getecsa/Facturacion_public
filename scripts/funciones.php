<?php
/*
 * Configuración
 */
include("../configuracion.php");

ob_start();
session_start();

//funcion para clonar un registro de mysql
      function mysql_clonar_registro ( $tabla, $clave ) {
       
         // limpieza parámetros
         $tabla = $mysqli->real_escape_string($tabla);
         $clave = $mysqli->real_escape_string($clave);

         // obtener lista de campos, no únicos
         $query="SHOW COLUMNS FROM $tabla";
         $rsCampos=$mysqli->query($query);
         $campos= array();
         $campoClave ="";
         while ( $campo = $rsCampos->fetch_array() ){

             if ( $campo["Key"] == "PRI" ){
                 $campoClave = $campo[0];
             }
             $campos[] =  $campo["Key"] == "PRI" || $campo["Key"] == "UNI" ? "NULL":    $campo[0];
         }
           $rsCampos->free_result();

         // clonar el registro mediante una SQL

          if ( $campoClave && count($campos)>0 ) {

             $SQL = sprintf( "INSERT INTO $tabla ( SELECT %s FROM $tabla WHERE %s='%s' )",
                 implode(",",$campos),
                 $campoClave,
                 $clave );
             $mysqli -> query($SQL);
             return $mysqli->insert_id;
         }
         return false;
      }


/*
 * Aqui mandamos la respuesta dependiendo de lo que solicite el 'request'
 */
header('Content-type: application/json; charset=utf-8');
if(isset($_POST['request'])) {
    switch ($_POST['request']) {

    case 'getConceptosdoc':
        if (isset($_SESSION['username'])) {
            $sql = "select * from users";
            $result = $mysqli->query($sql);
            $conceptos= array();
            $i=0;
            while($row=$result->fetch_array(MYSQLI_ASSOC)){
            $conceptos[$i]=$row;
            $i++;
            }
            echo json_encode($conceptos);

        } else {
            if (!isset($_SESSION['usuario'])) {
                header('Forbidden',true,403);
            } else {
                echo json_encode(array());
            }
            echo json_encode(array());
        }
        break;

    default:
        break;
    }
} else {

    /*
     * No podemos regresar nada.
     */
    header('Bad request',true,400);
    header('HTTP/1.0 400 Bad Request', true, 400);
    echo json_encode(array('status'=>'error'));
}





?>