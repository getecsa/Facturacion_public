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

require_once 'scripts/mysql_db.php';

$mysqli = new mysqli($server, $dbuser, $dbpass, $db);
$acentos = $mysqli->query("SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}

//usuario scl
/*
function ConexionSCL(){
    $conn = oci_connect("APP_SOLFACT", "Mg2$8Xqw", "10.225.173.100/REPOSCEL");
    if (!$conn) {
        $m = oci_error();
       // trigger_error(htmlentities($m['message']), E_USER_ERROR);
        echo $m;
    }
    return $conn;
}
*/

//usuario scl test

function ConexionSCL(){
    $conn = oci_connect("siscel", "kariso2b", "10.225.207.77/scelproy");
    if (!$conn) {
        $m = oci_error();
        // trigger_error(htmlentities($m['message']), E_USER_ERROR);
        echo $m;
    }
    return $conn;
}

?>