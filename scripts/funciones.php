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

// request de solicitud
header('Content-type: application/json; charset=utf-8');
if(isset($_POST['request'])) {
    switch ($_POST['request']) {

        case 'getConceptosdoc':
            $oracle=ConexionSCL();
            if (isset($_SESSION['username'])) {
                $query = "SELECT COD_CONCEPTO as codigo,
                           DES_CONCEPTO as descripcion
                      FROM FA_CONCEPTOS
                  ORDER BY DES_CONCEPTO";
                $result = oci_parse($oracle, $query);
                oci_execute($result);
                $conceptos= array();
                $i=0;
                while (($row = oci_fetch_array($result, OCI_ASSOC)) != false) {
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

        case 'getdocfactura':
            $oracle=ConexionSCL();
            if (isset($_SESSION['username'])) {
                $id_cliente=$_POST['id'];
                $query = "SELECT NOM_CLIENTE ||' ' ||
                                 NOM_APECLIEN1||' '||
                                 NOM_APECLIEN2 as razon_social
                            FROM FA_HISTCLIE_19010102
                           WHERE COD_CLIENTE= '$id_cliente'
                             AND ROWNUM <= 1";
                $result = oci_parse($oracle, $query);
                $ok=oci_execute($result);
                if ($ok != false) {
                    $row = oci_fetch_array($result, OCI_ASSOC);
                    if(!empty($row)){
                        $razon_social=$row['RAZON_SOCIAL'];
                        echo json_encode($razon_social);
                    }else{
                        echo json_encode('no result');
                    }
                }else{
                    echo json_encode('no result');
                }

            } else {
              /*  if (!isset($_SESSION['usuario'])) {
                    header('Forbidden',true,403);
                } else {
                    echo json_encode(array());
                } */
                echo json_encode(false);
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