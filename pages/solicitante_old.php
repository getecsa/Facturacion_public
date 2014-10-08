 <?php
session_start();

 //Validar que el usuario este logueado y exista un UID
if ( ! ($_SESSION['autenticado'] == 'SI' && isset($_SESSION['uid'])) )
{
    header('location: index.php');
}

?>

    <form id="form1" action="validarUsuario.php" method="post" >
        <div id="divNotificacion" />
        <ul class="menu">
    
    <li> <a href="nueva_solic.php">Nueva Solicitud</a>
       
    </li>
    <li> <a href="buscar.php" >Buscar Solicitud</a>
        
    </li>
</ul>
        <div class="contenedor">
            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                <h1>
                    <?php echo utf8_encode($_SESSION['username']);?> 
                </h1>
                <h2>Area: <?php echo utf8_encode($_SESSION['tx_area']);?> </h2>
                 
            </div>
            <div class="content">
                               <H2>Solicitudes Pendientes</H2>
                    <table class="gridview"   >
<tr >
                        <td colspan="7" align="right" bgcolor="00517A"><font color="#fff">Filtro de solicitud: <input type="text" name="" size="25" value="xxxx"></font></td>
                        
                        
                        
                    </tr>
<p></p>
                    <tr bgcolor="00517A">
                        <td ><font color="#fff">ID</font></td>
                        <td ><font color="#fff">Solicitante</font></td>
                        <td ><font color="#fff">Área</font></td>
                        <td ><font color="#fff">Tipo de solictud</font></td>
                        <td ><font color="#fff">Importe de solictud</font></td>
                        <td ><font color="#fff">Fecha Ingreso</font></td>
                        <td ><font color="#fff">Estado</font></td>
                        
                    </tr>
                    <tr>
            
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> 5324</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> $XXX,XXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XX-XX-XXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXX</a></td>
                    </tr>
                    <tr>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> 5324</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXXXXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> $XXX,XXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XX-XX-XXXX</a></td>
                        <td><a href="ver_folio.php?height=450&width=600" title="Folio 5324" class="thickbox"> XXXXX</a></td>
                    </tr>
                    
            </table>

            </div>
        </div>
    </form>
