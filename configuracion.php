<?php

$server="localhost"; 
$db="sis_fac"; 
$dbuser="root"; 
$dbpass="getecsa"; 
 
$mysqli = new mysqli($server, $dbuser, $dbpass, $db);
$acentos = $mysqli->query("SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}

?>