<?php
// session_start();

define('dbhost', 'localhost');
define('dbuser', 'root');
define('dbpass', 'qwertqwert');
define('dbname', 'camagru_users');

try
{
	$conn = new PDO("mysql:host=".dbhost."; dbname=".dbname, dbuser, dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	die("Connection failed: " .$e->getMessage());
}	


	