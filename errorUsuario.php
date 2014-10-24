<?php
ob_start();
/*if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
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
    
                  echo "<center><h2>Este sitio no es compratible con la version de Internet Explorer que estas utilizando, para una mejor visualizacion puedes utilizar Chrome, Firefox, Safari</h2></center>";
        }
  /*      else {        
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
    <link rel="shortcut icon" href="images/movistar.ico" />
    <link href="styles/style.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <link href="styles/style1.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <link href="styles/app.css" rel="stylesheet" rev="stylesheet" type="text/css" />   
    <link rel="stylesheet" href="styles/thickbox.css" type="text/css" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="styles/jquery-ui.css">     
    <script src="scripts/modernizr-2.6.2.min.js"></script>
    <script src="scripts/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="scripts/default.js" type="text/javascript"></script>   
    <script src="scripts/funciones.js" type="text/javascript"></script>   
    <script type="text/javascript" src="scripts/thickbox.js"></script>
    <script type="text/javascript" src="scripts/jquery-ui.js"></script>
    <script src="scripts/jquery-ui-1.9.2.custom.min.js"></script>


</head>
<body>
     <div id="main">
                <div id="divNotificacion" />
                <div class="contenedor">
                            <div class="header">
                                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                                <h1></h1>
                            </div>
                            <div class="content">
                                <div class="login">
                 <?php
                if($_GET["Error"]==1)
                    echo "<h2>Error 01: Usuario ó Contraseña Invalido en Sistema</h2>";

                if($_GET["Error"]==2)
                    echo "<h2>Error 02: Usuario ó Contraseña Invalido en Active Directory</h2>";

                if($_GET["Error"]==3)
                    echo "<h2>Error 03: El usuario de Active Directory no existe en el directorio del sistema</h2>";

                if($_GET["Error"]==4)
                    echo "<h2>Error 04: El usuario no esta autentificado</h2>";

                ?>

                               </div>
                            </div>
                </div>
                </div>
            <div class="footer">
                <p>
                    Gestor de solicitudes de facturación. Todos los Derechos Reservados ©<br />
                    Resolución Mínima 1280 x 800px
                </p>
            </div>
    </div>  
</body>
</html>
<meta http-equiv="refresh" content="1.5;url=index.php">

<?php 
ob_end_flush();
?>

