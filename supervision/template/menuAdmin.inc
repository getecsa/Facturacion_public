<!-- menuAdmin.inc -->        
        <title>{tituloVentana}</title>
    </head>
    <body>
        <form id='form1' name='form1'>
            <div class='contenedor'>
                <div class='menu'>
                    <ul>
                        <li>
                            <a href='admin.php'>
                                <img src='images/homeIcon.png' border='0' alt='Inicio' title='Inicio'>
                            </a>
                        </li>
                        <li>
                            <a href='#' class='{activoAdmin}' alt='Administración del Gestor' 
                            title='Administración del Gestor'>Administración</a>
                            <ul>
                                <li>
                                    <a href='admin.php?mod=users&acc=con' alt='Administración de Usuarios' 
                                    title='Administración de Usuarios'>Usuarios</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href='#' class='{activoCatalogo}' alt='Administrar Catálogos' 
                            title='Administrar Catálogos'>Catálogos</a>
                            <ul>
                                <li>
                                    <a href='admin.php?mod=areas&acc=con' alt='Catálogo de Áreas' 
                                    title='Cátalogo de Áreas'>Áreas</a>
                                </li>
                                <li>
                                    <a href='admin.php?mod=iva&acc=con' alt='Modificar valores de IVA' 
                                    title='Modificar valores de IVA'>I.V.A.</a>
                                </li>
                                <li>
                                    <a href='admin.php?mod=monedas&acc=con' alt='Catálogo de tipos de Monedas' 
                                    title='Catálogo de tipos de Monedas'>Monedas</a>
                                </li>
                                <li>
                                    <a href='admin.php?mod=cfdi&acc=con' alt='Catálogo de CFDI' 
                                    title='Catálogo de CFDI'>CFDI</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href='#' class='{activoDocs}' alt='Administrar de Documentación' 
                            title='Administrar de Documentación'>Documentación</a>
                            <ul>
                                <li>
                                    <a href='admin.php?mod=docs&acc=alta' alt='Alta de Documentos' 
                                    title='Alta de Documentos'>Alta de Documentos</a>
                                </li>
                                <li>
                                    <a href='admin.php?mod=docs&acc=permisos&opc=sel' alt='Permisos de Documentos' 
                                    title='Permisos de Documentos'>Permisos de Documentos</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div> <!-- menu -->
                <div class='nombre-usuario'>Nombre: {nombreUsuarioSesion}<a href='cerrar.php' class='texto_salir'>
                Cerrar Sesión</a></div>
                <div class='header' style='margin-top:20px;'>
                    <img alt='Movistar' class='logotipo' src='images/logo.png'>
