<!-- menuPrincipal.inc -->
        <title>{tituloVentana}</title>
    </head>
    <body>
        <form id='form1' name='form1'>
            <div class='contenedorPrincipal'>
                <div class='nombre-usuario'>Bienvenido: {nombreUsuarioSesion}
                    <a href='cerrar.php' class='texto_salir'>Cerrar Sesión</a>
                </div> <!-- nombre-usuario -->
                <img alt='Movistar' class='logotipo' src='images/logo.png' width='115' height='43'>
                <div class="easyui-layout" style="width:auto;height:500px;">
                    <!--<div data-options="region:'north'" style="height:50px"></div>-->
                    <div data-options="region:'west',split:true" title="Menú" style="width:150px;">
                        <div class='menuLateral'>
                            <li>
                                <a href='menu.php' class='{activoInicio}'>
                                    <img src='images/homeIcon.png' border='0' alt='Inicio' title='Inicio'>
                                    <span style='margin-left:5px;'>Inicio</span>
                                </a>
                            </li>
                            <li>
                                <a href='opciones.php'>Opciones</a>
                            </li>
                            <li>
                                <a href='reportes.php' class='{activoReportes}'>Reportes</a>
                            </li>
                        </div>
                    </div> <!-- west area -->
                    <div data-options="region:'center'">
                    </div> <!-- center area -->
                    <div data-options="region:'south',split:true,title:'Avisos'" style="height:100px;"></div>
                </div> <!-- easyui-layout -->
            </div> <!-- contenedorPrincipal -->
                    