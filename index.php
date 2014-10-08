<?php
/*
if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
{
    /*
          if(preg_match('/(?i)msie [1-7]/',$_SERVER['HTTP_USER_AGENT']))
            {
               // if IE<=7
                  echo "<center><h2>Este sitio no es compratible con la version de Internet Explorer que estas utilizando, para una mejor visualizacion puedes utilizar Chrome, Firefox, Safari</h2></center>";
            }
               else
            {
                // if IE>7
    */
  /*                echo "<center><h2>Este sitio no es compratible con la version de Internet Explorer que estas utilizando, para una mejor visualizacion puedes utilizar Chrome, Firefox, Safari</h2></center>";
        }
        else {        
*/
?>
 <!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head >

    <title>Gestor de solicitudes de facturación</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/normalize.min.css">
        <link rel="stylesheet" href="styles/main.css">
        <script src="scripts/modernizr-2.6.2.min.js"></script>
    <link rel="shortcut icon" href="images/movistar.ico" />
    <link href="styles/style.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <link href="styles/app.css" rel="stylesheet" rev="stylesheet" type="text/css" />   
    <script src="scripts/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="scripts/default.js" type="text/javascript"></script>	
    <script src="scripts/funciones.js" type="text/javascript"></script>   
</head>
<body>
	<div id="main">
           <div id="divNotificacion" />
		      <?php  include("pages/inicio.php"); ?>
            </div>
            <div class="footer">
                <p>
                    Gestor de solicitudes de facturación. Todos los Derechos Reservados ©<br />
                    Resolución Mínima 1280 x 800px
                </p>
            </div>
    </div>  
<script src="scripts/plugins.js"></script>
<script src="scripts/main.js"></script>
</body>
</html>
<?php  ?>