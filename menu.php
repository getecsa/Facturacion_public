 <?php
 //Validar que el usuario este logueado y exista un UID
if (($_SESSION['autenticado'] == 'SI' &&  isset($_SESSION['oper_sol'])) )
{

	if($_SESSION['oper_sol'] == 1){
?>
<ul class="menu"> 
	 	<li> <a href="homepage.php?id=solicitante">Inicio</a></li>
        <li> <a href="homepage.php?id=nueva_solicitud">Nueva Solicitud</a></li>
        <li> <a href="homepage.php?id=aclaracion_queja">Aclaración o Queja</a></li>
        <li> <a href="homepage.php?id=buscar" >Buscar Solicitud</a></li>
        <li> <a href="homepage.php?id=carga_masiva">Carga Masiva</a>
</ul>
<?php }
	if($_SESSION['oper_sol'] == 0){
?>
<ul class="menu"> 
	 	<li> <a href="homepage.php?id=operador">Inicio</a></li>
      <!--  <li> <a href="buscar.php" >Busqueda</a></li> -->
</ul>
<?php } ?>
<div class="bienvenida">
<p>Bienvenido: <?php echo $_SESSION['username'];?> <a href="logout.php">Logout</a></p>
<p><?php echo $_SESSION['tx_area'];?></p>
</div>
<?php    
}
?>
