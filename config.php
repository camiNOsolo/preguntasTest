<?php

define('BASE_PATH','http://localhost/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'cuestionario');
define('DB_USER','root');
define('DB_PASSWORD','lalala11A');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Error al conectar a la Base de Datos: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Error al conectar a la Base de Datos:  " . mysql_error());
mysql_set_charset('utf8',$con);
?>
