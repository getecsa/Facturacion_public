<?php  

$conn = oci_connect('ops$xpfactur', 'ops$xpfactur', '10.225.240.35/SCELPROY'); 
if (!$conn) {    
$m = oci_error();    
echo $m['message'], "\n";    
exit; 
} 
else 
{    echo "Conexión con éxito a Oracle!"; } 
oci_close($conn); 
?>
