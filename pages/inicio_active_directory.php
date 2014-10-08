<?php

if (isset($_POST['txtUsuario'])){


    $datos_usuario = array();

    // inicio login active directory
    $adServer = "mexico.tem.mx";
    $ldap = ldap_connect($adServer);
   // $username ='MRT06294';
   // $password ='Rodrigo.09';
    $username = $_POST['txtUsuario'];
    $password = $_POST['txtContraseña'];
    $valor=explode('.',$adServer);
    $ldaprdn = $valor[0].'\\'.$username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALSa, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);


      $dc = explode(".", 'mexico.tem.mx');
      $base_dn = "";
      foreach($dc as $_dc) $base_dn .= "dc=".$_dc.",";
      $base_dn = substr($base_dn, 0, -1);

    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,$base_dn,$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
              /*
                0 0 nombre completo
                0 1 nombre
                0 2 apellido
                0 3 mail
                0 4 puesto
                0 5 area
              */
             $datos_usuario[0] =array($info[$i]["cn"][0],$info[$i]["name"][0],$info[$i]["sn"][0],$info[$i]["mail"][0],$info[$i]["title"][0],$info[$i]["department"][0]);

/*
            echo "<p>Nombre completo: ", $info[$i]["cn"][0], "</p>";
            echo "<p>Nombre: ", $info[$i]["name"][0], "</p>";
            echo "<p>Apellido: ", $info[$i]["sn"][0], "</p>";
            echo "<p>Mail: ", $info[$i]["mail"][0], "</p>";
            echo "<p>Puesto: ", $info[$i]["title"][0], "</p>";
            echo "<p>Area: ", $info[$i]["department"][0], "</p>";
*/

            //Si existe usuario entonces loguea

              
    include("config.php");
     
    $sql ="SELECT   id_usuario, username, nombre, n_paterno, n_materno,
                    users.area_idarea as id_area, area.tx_area as tx_area, area.oper_sol as oper_sol
             FROM   users
       INNER JOIN   area
               ON   users.area_idarea = area.id_area
            WHERE   username =  '$username'";

     $result=mysql_db_query($db, $sql, $link); 

    $uid = "";
     
    //Si existe al menos una fila
    if( $fila=mysql_fetch_array($result) )
       {       
          if($username==$fila['username'])
             {    
                                     
                                                                $uid = $fila['id_usuario'];
                                                                $id_area = $fila['id_area'];

                                                                                  session_start();  
                                                                $_SESSION['autenticado']    = 'SI';
                                                                $_SESSION['uid']            = $uid;
                                                                $_SESSION['username']       = $fila['username'];
                                                                $_SESSION['area']        = $fila['id_area'];
                                                                $_SESSION['tx_area']        = $fila['tx_area'];
                                                                $_SESSION['nombre']        = $fila['nombre'];
                                                                $_SESSION['paterno']        = $fila['n_paterno'];
                                                                $_SESSION['materno']        = $fila['n_materno'];
                                                                $_SESSION['oper_sol']        = $fila['oper_sol'];

                                                                    if($fila['oper_sol']==0){
                                                                            header('Location: index.php?id=operador');
                                                                      }
                                                                    else {
                                                                           header('Location: index.php?id=solicitante');
                                                                      }
                                     
            }
            else {
                header('Location: index.php?id=errorUsuario&Error=3');
          }  
    }

    else  {
    header('Location: index.php?id=errorUsuario&Error=1');
    }




        }
        @ldap_close($ldap);
    } else {
           header('Location: index.php?id=errorUsuario&Error=2');
    }
    //fin active directory  



}
    else{

?>
                     

<!-- inicio -->

        <div id="divNotificacion" />
            <form id="form1" action="#" method="post" >

        <div class="contenedor">

            <div class="header">
                <img alt="Movistar" class="logotipo" src="images/logo.png" />
                <h1>
                    
            </div>
            <div class="content">
                <div class="login">
                    <h2>Login
                    </h2>
                    <img src="images/candado.jpg" alt="Login" />
                    <p>
                        
                        Usuario:
                        <input type="text" id="txtUsuario" name="txtUsuario" MaxLength="20"/>
                    
                    </p>
                    
                      <p>
                        
                        Contraseña:
                        <input type = "password" id="txtContraseña" name="txtContraseña" MaxLength="20" required/>
                    
                    </p>
                    <p>
                        &nbsp;</p>
                    <p>
                        <input type="submit" ID="btnLogin"  value="Ingresar" >
                        
                    </p>
                </div>
            </div>

        </div>
           
         </form>
<?php } ?>