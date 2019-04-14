<?php
// db connection variables
$MYSQL_HOST = 'localhost';//HOST
$MYSQL_USER = 'root';//Username
$MYSQL_PASSWORD = '';//Password
$MYSQL_DB_NAME = 'declan';//My sql database name

// Establish DB connection. The @ means hide any error output
$db = @mysqli_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DB_NAME) or die("Could not
connect to database");
 ?>
