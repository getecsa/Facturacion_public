<?php
if (!isset($_GET['id'])) {
    include("pages/inicio.php");
} else {
    include("pages/".$_GET['id'].".php");
}
?>