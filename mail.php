<?php
$destino="gerardo1.ramirez11@gmail.com";
$asunto="correo de prueba";
$mensaje="Este es un correo de prueba HOLA MUNDO";
$encabezados="From: Artemisa IX<micorreo@ovi.com>";
 
if(mail($destino, $asunto, $mensaje, $encabezados)){
    echo "Mail enviado correctamente";
}else {
    echo "Error al enviar el mail";
    }
?>
