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
?>