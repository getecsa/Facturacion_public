<?php

$con = mysqli_connect("localhost", "root", "getecsa", "sis_fac");

/* verificar la conexion */
if (mysqli_connect_errno()) {
echo "Hay error de conexion: ". mysqli_connect_error();
exit();
}
   
?>