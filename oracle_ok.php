<?php
PutEnv("ORACLE_HOME=instantclient,/opt/oracle/instantclient/10");

function ConectaGuio()
{
           echo "conectandome...";
           $conn = OCILogon("APP_SOLFACT", "Mg2$8Xqw",
           '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)
           (HOST=10.225.173.100) (PORT=1521)))
                           (CONNECT_DATA=(SERVICE_NAME = REPOSCEL)))') or die
           ('No es posible conectar a GUIO: <!pre>' . print_r(oci_error(),1) .
           '<!/pre><!/body><!/html>');
           return $conn;
}
$conn=ConectaGuio();
echo "ejecutando query";
$q="SELECT * FROM FA_HISTCONC_19010102";
$qp=OCIParse($conn,$q);
OCIExecute($qp,OCI_DEFAULT);
OCIFetchInto ($qp, $rtmp, OCI_ASSOC);
//echo "valor=".$rtmp["NUM_AUTORIZACION"];
var_dump($rtmp);

?>