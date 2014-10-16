<!--errorSesion.inc Plantilla para mostrar Error si la Sesión a Terminado o Caducó.-->
    <body>
        <form id='form1'>
            <div class='contenedor'>
                <img alt='Movistar' class='logotipo' src='images/logo.png' style='margin-left:840px;margin-top:40px;'>
                <br>
                <div class='contentBoxError' style='display:{displayError};'>{mensajesError}</div>
                <br>
                <h2 style='font-weight:bold;margin-left:290px;'>{mensaje}</h2>
                <br>
                <br>
                <input type='button' name='btnInicioSes' onclick="location.href='{urlInicioSesion}';" 
                value='Iniciar Sesión' style='margin-left:490px;'>
                <br>
                <br>
            </div> <!-- contenedor -->
            <div class='footer'>
                <p>
                    Gestor de solicitudes de facturación. Todos los Derechos Reservados &copy;<br>
                    Resoluci&oacute;n M&iacute;nima 1280 x 800px
                </p>
            </div> <!-- footer -->
        </form>
    </body>
</html>