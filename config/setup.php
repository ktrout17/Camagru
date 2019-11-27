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
			email_status enum('verified' , 'not verified') DEFAULT 'not verified' NOT NULL,
			notifications enum('yes', 'no') DEFAULT 'yes' NOT NULL
			)";
		$conn->exec($sql);

		$sql = "CREATE TABLE IF NOT EXISTS images (
			image_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id int(11),
			img_src TEXT NOT NULL,
			FOREIGN KEY(user_id) REFERENCES `users`(user_id) ON DELETE CASCADE ON UPDATE CASCADE
			)";
		$conn->exec($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `comments`(
			`comment_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			`comment` TEXT NOT NULL,
			`user_id` INT(11),
			`image_id` INT(11),
			FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
			FOREIGN KEY (`image_id`) REFERENCES `images`(`image_id`) ON DELETE CASCADE ON UPDATE CASCADE
			);";
		$conn->exec($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `likes`(
			`like_id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			`like` int(11) DEFAULT 0 NOT NULL,
			`user_id` int(11),
			`image_id` INT(11),
			FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
			FOREIGN KEY (`image_id`) REFERENCES `images`(`image_id`) ON DELETE CASCADE ON UPDATE CASCADE
			);";
		$conn->exec($sql);
		$conn = null;

	}
	catch(PDOException $e)
	{
		die("Connection failed: " .$e->getMessage());
	}	
	$conn = null;
?>