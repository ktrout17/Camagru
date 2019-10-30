<?php
session_start();

$dsn = "mysql:host=localhost;dbname=camagru_users";
$dBUsername = "root";
$dBPassword = "qwertqwert";

try
{
	$conn = new PDO($dsn, $dBUsername, $dBPassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	die("Connection failed: " .$e->getMessage());
}	


	