<?php
if (isset($_POST['comment-submit'])) {
	session_start();
	try 
	{
		include "../config/database.php";
		$msg = htmlspecialchars($_POST['comment']);
		$email = ($_SESSION['email']);
		$user_id = $_SESSION['user_id'];
		$image_id = $_POST['img-id'];
		$username = $_SESSION['username'];
		$location = $_POST['location'];
		$sql = "INSERT INTO `comments` (`comment`, `user_id`,`image_id`) VALUES (?, $user_id, $image_id);";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $msg);
		if ($stmt->execute()) {
			$sql = "SELECT `username`, `email`, `img_src`, `notifications` FROM `users`
			JOIN `images` ON users.user_id = images.user_id
			WHERE `image_id` = $image_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($res[0]['notifications'] == 'yes') {
				$to = $res[0]['email'];
				$url = "http://localhost:" . $location;
				$htmlStr = "";
				$htmlStr .= "Hi ".$username.",<br /><br />";
				$htmlStr .= "" . $username . " just commented on your post!<br /><br />";
				$htmlStr .= "See what was said by clicking the button below.<br /><br /><br />";
				$htmlStr .= "<a href='{$url}' target='_blank' style ='padding:1em; font-weight:bold; background-color:burlywood; color:cadetblue;'>VIEW COMMENT</a><br /><br /><br />";
				$htmlStr .= "Kind Regards, <br />";
				$htmlStr .= "kt editing";
				$name = "kt editing";
				$email_sender = "no-reply@ktediting.com";
				$subject = "Someone commented on your post!";
				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= "From: {$name} <{$email_sender}> \n";
				$body = $htmlStr;
				
				if (!mail($to, $subject, $body, $headers)) {
					echo error_get_last()['message'];
					exit();
				}
			}
		}
		header("Location: " . $location);
		exit();
	} 
	catch (PDOException $e) 
	{
		die("Connection failed: " . $e->getMessage());
	}
} 
else if (isset($_POST['submit-like'])) 
{
	session_start();
	try 
	{
		include "../config/database.php";
		$location = $_POST['location'];
		$image_id = $_POST['img-id'];
		$likes = $_POST['submit-like'];
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT `user_id` FROM `likes` where `user_id` = $user_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) 
		{
			$sql = "DELETE FROM `likes` WHERE `user_id` = $user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		} else 
		{
			$sql = "INSERT INTO `likes` (`like`, `user_id`, `image_id`) VALUES ($likes, $user_id, $image_id);";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		header("Location: " . $location);
		exit();
	} 
	catch (PDOException $e) 
	{
		die("Connection failed: " . $e->getMessage());
	}
} 
else 
{
	header("Location: ../user_gallery.php");
	exit();
}