<?php
	$servername = "localhost";
	$dBUsername = "root";
	$dBPassword = "";
	$dBName = "camagru_users";

	try 
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dBName", "$dBUsername", "$dBPassword");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	catch(PDOException $e)
	{
		die("Connection failed: " .$e->getMessage());
	}