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
if(isset($_GET['request'])) {
    switch ($_GET['request']) {

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
                            FROM GE_CLIENTES
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

        case 'getdocnota':
            $oracle=ConexionSCL();
            if (isset($_SESSION['username'])) {
                $factura_a=$_GET['factura_a'];
                $factura_b=$_GET['factura_b'];
/*

                $query = "SELECT COD_CLIENTE, TOT_CARGOSME, FEC_EMISION,IND_ORDENTOTAL, (
                                      SELECT mens.desc_menslin
                                        FROM
                                             FA_MENSAJES mens,
                                             FA_MENSPROCESO procmen,
                                             FA_HISTDOCU histdocu
                                       where mens.corr_mensaje=procmen.corr_mensaje
                                         and mens.cod_idioma=1
                                         and mens.num_linea=1
                                         and procmen.num_proceso=histdocu.num_proceso
                                         and histdocu.num_proceso  =his.NUM_PROCESO) as LEYENDA_DOC,
                (SELECT NOM_CLIENTE ||' ' ||
                NOM_APECLIEN1||' '||
                NOM_APECLIEN2
                                        FROM GE_CLIENTES
                                       WHERE COD_CLIENTE=his.COD_CLIENTE
                AND ROWNUM <= 1) as RAZON_SOCIAL,
                                  (SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
                                              ELSE 0 END
                                     FROM FA_HISTDOCU
                                    WHERE NUM_SECUREL=his.NUM_SECUENCI and COD_TIPDOCUM='25' and cod_cliente =his.COD_CLIENTE) as TOTAL_NC
                             FROM FA_HISTDOCU his where PREF_PLAZA='$factura_a' AND NUM_FOLIO='$factura_b' ";

 */

                $query = "SELECT COD_CLIENTE, TOT_CARGOSME, FEC_EMISION,IND_ORDENTOTAL,IND_ORDENTOTAL,
                                     (SELECT NOM_CLIENTE ||' ' ||
                                             NOM_APECLIEN1||' '||
                                             NOM_APECLIEN2
                                        FROM GE_CLIENTES
                                       WHERE COD_CLIENTE=his.COD_CLIENTE
                                  AND ROWNUM <= 1) as RAZON_SOCIAL,
                                  (SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
                                              ELSE 0 END
                                     FROM FA_HISTDOCU
                                    WHERE NUM_SECUREL=his.NUM_SECUENCI and COD_TIPDOCUM='25' and cod_cliente =his.COD_CLIENTE) as TOTAL_NC
                             FROM FA_HISTDOCU his where PREF_PLAZA='$factura_a' AND NUM_FOLIO='$factura_b' ";


                $result = oci_parse($oracle, $query);
                $ok=oci_execute($result);
                if ($ok != false) {
                    $row = oci_fetch_array($result, OCI_ASSOC);
                    if(!empty($row)){
                        $int_ordentotal=$row['IND_ORDENTOTAL'];
                        $c_cliente=$row['COD_CLIENTE'];
                        $t_factura=$row['TOT_CARGOSME'];
                        $f_emision=$row['FEC_EMISION'];
                        $leyenda_doc="NADA"; /*$row['LEYENDA_DOC'];*/
                        $razon_social=$row['RAZON_SOCIAL'];
                        $total_nc=$row['TOTAL_NC'];
                        $conceptos_fac=$row['IND_ORDENTOTAL'];
                        $result=compact("c_cliente","t_factura","f_emision","leyenda_doc","razon_social","total_nc","conceptos_fac","int_ordentotal");
                        echo json_encode($result);

                                //numeros de conceptos que tiene cada factura
                                $query_concepto="select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL
                                           from fa_histconc_19010102 his
                                          where ind_ordentotal = $int_ordentotal and COD_CONCEREL < '0'";
                                $result_concepto = oci_parse($oracle, $query_concepto);
                                $ok=oci_execute($result_concepto);
                                if ($ok != false) {
                                    $i=0;
                                    while($row_concepto = oci_fetch_array($result_concepto, OCI_ASSOC)){
                                        $cod_con[$i]['codigo']=$row_concepto['COD_CONCEPTO'];
                                        $cod_con[$i]['concepto']=$row_concepto['DES_CONCEPTO'];
                                        $cod_con[$i]['importe']=$row_concepto['IMPORTE_TOTAL'];
                                        $i++;
                                    }
                                    echo json_encode($cod_con);

                                    //query para saber todas las notas de creditos existentes

                                    $query_nc="select ind_ordentotal
                                                         from fa_histdocu
                                                        where num_securel =
                                                                     (SELECT num_secuenci
                                                                        from FA_HISTDOCU
                                                                       where  PREF_PLAZA='$factura_a' AND NUM_FOLIO='$factura_b')
                                                                   and cod_tipdocum = 25
                                                                   and cod_cliente =
                                                                     (SELECT cod_cliente
                                                                        from FA_HISTDOCU
                                                                       where  PREF_PLAZA='$factura_a' AND NUM_FOLIO='$factura_b')";

                                            $result_nc = oci_parse($oracle, $query_nc);
                                            $ok=oci_execute($result_nc);
                                            if ($ok != false) {
                                                while($row_nc = oci_fetch_array($result_nc, OCI_ASSOC)){
                                                  $nota=$row_nc['IND_ORDENTOTAL'];
                                                  echo json_encode($nota);



                                                }
                                            }else{
                                                echo json_encode('no result0');
                                            }




                                }else{
                                    echo json_encode('no result1');
                                }





                    }else{
                        echo json_encode('no result2');
                    }
                }else{
                    echo json_encode('no result3');
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