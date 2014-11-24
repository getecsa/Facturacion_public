<?php
//Versión 1.0 Oct-14
$C = array();
// Datos del Proyecto. *
date_default_timezone_set('America/Mexico_City');
$C['PROJECT_NAME']   = 'Gestor de Solicitud de Facturación';
$C['YEAR_DEVELOP']   = date('Y');
$C['MIN_RESOLUTION'] = '1280 x 800';
//
// Datos de Conexión a la Base de Datos Propia de MySQL. (LOCALHOST) - ALF*
/*$C['DB_HOST'] = 'localhost';
$C['DB_USER'] = 'usuario';
$C['DB_PASS'] = 'l0c4lU53r';
$C['DB_NAME'] = 'ger';*/
//
// Datos de Conexión a la Base de Datos Propia de MySQL. (LOCALHOST) - LUIS DANIEL*
$C['DB_HOST'] = 'localhost';
$C['DB_USER'] = 'root';
$C['DB_PASS'] = 'getecsa';
$C['DB_NAME'] = 'sis_fac';
//
// Datos de Conexión a la Base de Datos Propia de MySQL. (appsmap.tecnologiatmm.com.mx) *
/*$C['DB_HOST'] = 'localhost';
$C['DB_USER'] = 'ger';
$C['DB_PASS'] = 'ger!';
$C['DB_NAME'] = 'proy';*/
//
// Datos de Conexión a la Base de Datos de "SCL" de Oracle. *
$C['USERNAME_SCL']    = '';
$C['PASSWORD_SCL']    = '';
$C['DB_SCELPROYIXTL'] = '';
//
// Datos de Conexión al Correo Electrónico. *
$C['HOST_MAIL'] = 'smtp.gmail.com';
$C['PORT_MAIL'] = '587';
$C['USER_MAIL'] = '';
$C['PASS_MAIL'] = '';
//
// Datos de Conexión al Active Directory. *
$C['AD_TEM_SERVER'] = 'mexico.tem.mx';
//