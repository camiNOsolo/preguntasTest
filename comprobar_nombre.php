<?php

 require_once 'config.php';

 if(!empty($_POST['nombre'])){
     $nombre = $_POST['nombre'];
     $res = mysql_query("select count(nombre) as count from usuario where nombre = '$nombre'") or die(mysql_error()); 
     $count=mysql_fetch_array($res);
     if($count[0]==0){
         echo 'true';
     }else{
         echo 'false';
     }
 }
?>
