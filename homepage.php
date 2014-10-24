<?php
ob_start();
session_start();
 //Validar que el usuario este logueado y exista un UID
if (($_SESSION['autenticado'] == 'SI' &&  isset($_SESSION['oper_sol'])) )
{


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
        <meta HTTP-EQUIV=Refresh CONTENT="1800; URL=logout.php">
        <link rel="stylesheet" href="styles/normalize.css">
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

	    <script src="scripts/validaciones.js"></script>

</head>
<body>
    <div id="main">
           <div id="divNotificacion" />
                    <?php include('menu.php'); ?>
                    <?php
                        if (!isset($_GET['id'])) {
                            include("pages/panel.php");
                        } else {
                            include("pages/".$_GET['id'].".php");
                        }
                        
                    ?>

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
<?php
} else {
      header('Location: errorUsuario.php?Error=4');
} 
ob_end_flush();
?>