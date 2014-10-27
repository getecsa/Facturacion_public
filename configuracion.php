<?php

$server="localhost"; 
$db="sis_fac"; 
$dbuser="root"; 
$dbpass="getecsa"; 
 /*
$server="localhost"; 
$db="sis_fac"; 
$dbuser="sisgesofa"; 
$dbpass="g3s0fa"; 
*/

$mysqli = new mysqli($server, $dbuser, $dbpass, $db);
$acentos = $mysqli->query("SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}
/*
PutEnv("ORACLE_HOME=instantclient,/opt/oracle/instantclient/10");

function ConectaGuio()
{
           echo "conectandome...";
           $conn = OCILogon("APP_SOLFACT", "Mg2$8Xqw",
           '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)
           (HOST=10.225.173.100) (PORT=1521)))
                           (CONNECT_DATA=(SERVICE_NAME = REPOSCEL)))') or die
           ('No es posible conectar a GUIO: <!pre>' . print_r(oci_error(),1) .
           '<!/pre><!/body><!/html>');
           return $conn;
}
*/
function ConexionSCL(){
    $conn = oci_connect("APP_SOLFACT", "Mg2$8Xqw", "10.225.173.100/REPOSCEL");
    if (!$conn) {
        $m = oci_error();
       // trigger_error(htmlentities($m['message']), E_USER_ERROR);
        echo $m;
    }
    return $conn;
}

?>