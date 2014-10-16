<?php
//Versión 1.0 Oct-14
  session_start();
  session_unset();
  session_destroy();
  header("Location:../"); //envío al usuario a la pag. de autenticación
?>