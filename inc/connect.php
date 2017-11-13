<?php
$user="user";
$password="password";
$database="db";
mysql_connect("localhost",$user,$password);
mysql_select_db($database) or die("Unable to select database");
?>