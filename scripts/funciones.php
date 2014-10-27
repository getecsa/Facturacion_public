<?php

//funcion para clonar un registro de mysql
      function mysql_clonar_registro ( $tabla, $clave ) {

        include("configuracion.php");

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
        if (isset($_SESSION['usuario']) && isset($_POST['id'])) {
            $sql = "SELECT
                    CONCAT_WS(\" \", a.tipo, a.nombre) as '1',
                    a.asignacion as '2',
                    a.metros_cuadrados_local as '3',
                    a.capacidad as '4',
                    DATE(a.apertura) as '5',
                    a.telefono as '6',
                    a.latitud as '7',
                    a.longitud as '8',
                    a.direccion as '9',
                    CONCAT_WS(\" \",f.tipo, b.colonia) as '10',
                    c.municipio as '11',
                    d.estado as '12',
                    a.cp as '13',
                    g.ciudad as '14'
                FROM inmuebles a
                    LEFT JOIN codigos_postales e on a.cp = e.id
                    LEFT JOIN colonias b on e.colonia = b.id
                    LEFT JOIN tipo_colonia f ON e.tipo_colonia = f.id
                    LEFT JOIN municipios c ON e.municipio = c.id
                    LEFT JOIN estados d on e.estado = d.id
                    LEFT JOIN ciudades g ON e.ciudad = g.id
                    WHERE a.id = ?";
            $res = $pdo->query_all($sql,array($_POST['id']));
            echo json_encode($res);
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