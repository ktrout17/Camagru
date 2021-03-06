<?php
	session_start();
	require '../config/database.php';

	$query = "SELECT user_id FROM users WHERE activation_code = ? AND email_status = 'not verified'";
	$stmt = $conn->prepare($query);
	$stmt->bindParam(1, $_GET['code']);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$user_id = $result['user_id'];
	$num = $stmt->rowCount();

	if ($num > 0)
	{
		$query = "UPDATE users SET email_status = 'verified' WHERE activation_code = :activation_code";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':activation_code', $_GET['code']);

		if ($stmt->execute())
		{
			header("Location: ../login.php");
			$errormsg = "Your email has been verified, thanks! You may now login.";
		}
		else
		{
			echo "Unable to update verification code.";
		}
	}
	else
	{
		echo "We can't find your verification code.";
	}
?>