<!-- menuSupervArea.inc -->        
        <title>{tituloVentana}</title>
    </head>
    <body>
        <div id="main">
           <div id="divNotificacion">
                <div class='menu'>
                    <ul>
                        <li>
                            <a href='menu.php'>
                                <img src='images/homeIcon.png' border='0' alt='Inicio' title='Inicio'>
                            </a>
                        </li>
                        <li>
                            <a href='reportes.php?mod=reportes&acc=form' class='{activoReportes}' alt='Reportes de SLA' 
                            title='Reportes de SLA'>Reportes</a>
                        </li>
                    </ul>
                </div> <!-- menu -->
                <div class='bienvenida'><p>Nombre: {nombreUsuarioSesion} <a href='cerrar.php'>Logout</a></p>
                    <p>{nombreArea}</p>
                </div>
                <div class='contenedor'>
                    <div class='header' style='margin-top:20px;'>
                        <img alt='Movistar' class='logotipo' src='images/logo.png'>
