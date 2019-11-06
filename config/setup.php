<?php
	
	try
	{
		$conn = new PDO("mysql:host=localhost", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$conn->exec("CREATE DATABASE IF NOT EXISTS camagru_users");
		$conn = null;

		require 'database.php';
		$sql = "CREATE TABLE IF NOT EXISTS `users` (
			user_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			username TINYTEXT NOT NULL,
			email TINYTEXT NOT NULL,
			`password` LONGTEXT NOT NULL,
			activation_code LONGTEXT NOT NULL,
			email_status enum('verified' , 'not verified') DEFAULT 'not verified'NOT NULL
			)";
		$conn->exec($sql);

		$sql = "CREATE TABLE IF NOT EXISTS images (
			image_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id int(11),
			img_src VARCHAR(255) UNIQUE NOT NULL,
			FOREIGN KEY(user_id) REFERENCES `users`(user_id)
			)";
		$conn->exec($sql);

		$sql = "CREATE TABLE IF NOT EXISTS comments (
			comment_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id int(11),
			comment_text VARCHAR(255) UNIQUE NOT NULL,
			FOREIGN KEY(user_id) REFERENCES `users`(user_id)
			)";
		$conn->exec($sql);

	}
	catch(PDOException $e)
	{
		die("Connection failed: " .$e->getMessage());
	}	

?>