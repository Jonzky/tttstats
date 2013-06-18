<?php
$server_hostname = "127.0.0.1:3306";
$database_user = "";
$database_pass = "";
$database_db = "";

$connect = mysql_connect($server_hostname, $database_user, $database_pass);
$db_select = mysql_select_db('');
if (!connect) {die('ERROR, Failed to connect to database.' . mysql_error());}
?>