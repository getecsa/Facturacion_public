	<title>{tituloVentana}</title>
  </head>
  <body>
	<header><h1><span>Logos Institucionales</span></h1></header>
	<section>
		<div id='menutop'>
		    <label class='nomuser'>{nombreUsuario}</label>
		    <a href='{nombreArchivoCerrarSess}' title=''>{tituloCerrarSess}</a>
		</div> 
		<h1>{tituloPagina}</h1>
		<p>
			<h1 style='color:red;'>{mensajeError}</h1>
		</p>
		<form name='usuario' action='{nombreArchivoActionForm}' method='POST'>
		  	<table class='tabpgn'>
				<tr>
					<td>Usuario</td><td>{usuario}</td>
				</tr>
				<tr>
					<td>Centro Expedidor</td><td>{nombreCentroExp}</td>
				</tr>
				<tr>
					<td>Tipo de Usuario</td><td>{tipo}</td>
				</tr>
				<tr>
					<td>Estatus</td><td>{estatus}</td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td>
						<input type='text' name='nombre' placeholder='Escribir el Nombre Completo' 
						size='60' maxlength='50' value='{nombre}' autofocus>
			  		</td>
				</tr>
				<tr>
					<td>Contraseña Actual</td>
					<td>
						<input type='password' name='passActual' size='60' maxlength='10' 
						placeholder='Escribir la contraseña actual'>
			  		</td>
				</tr>
				<tr>
					<td>Nueva Contraseña</td>
					<td>
						<input type='password' name='pass' placeholder='Escribir nueva contraseña máximo 10 dígitos' 
						size='60' maxlength='10'>
			  		</td>
				</tr>
				<tr>
					<td>Confirmar Nueva Contraseña</td>
					<td>
						<input type='password' name='confirmPass' 
						placeholder='Confirmar nueva contraseña máximo 10 dígitos' size='60' maxlength='10'>
			  		</td>
				</tr>
			</table>
			<input type='hidden' name='mod' value='{mod}'>
			<input type='hidden' name='acc' value='{acc}'>
			<input type='hidden' name='pHash' value='{pHash}'>
		</form>
		<div class='botonesdecide'>
			<button type='button' name='botonAccion' onclick='return validarFormUsuarioInfo();'>{nombreBotonAccion}
			</button>
		  	<button type='button' name='botonMenu' onclick="location.href='{menuPrincipal}';">Menú Principal</button>
  		</div> 
  	</section>
  </body>
</html>