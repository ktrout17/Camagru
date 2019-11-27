<?php
session_start();
if (isset($_SESSION['user_id'])) {
	include '../config/database.php';
	$user_id = $_SESSION['user_id'];
	try {
		if (isset($_POST['mail-notify'])) {
			$sql = "UPDATE `users` SET `notifications` = 'yes' WHERE `user_id` = $user_id";
		}
		if (!isset($_POST['mail-notify'])) {
			$sql = "UPDATE `users` SET `notifications` = 'no' WHERE `user_id` = $user_id";
		}
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		header("Location: ../profile.php");
		exit();
	} catch (PDOException $e) {
		die("Connection failed: " . $e->getMessage());
	}
} else {
	header("Location: ../index.php");
	exit();
}