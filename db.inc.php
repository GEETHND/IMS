<?php
define("USER","root");
define("PWD","");
define("HOST","localhost");
define("DB","imsdb");

//connect to DataBase
$conn=mysql_connect(HOST,USER,PWD) or die (header('location:error.php?err='.mysql_error()));

//select DB
mysql_select_db(DB) or (header('location:error.php?err='.mysql_error()));
?>
