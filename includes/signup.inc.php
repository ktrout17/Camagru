<?php
	if (isset($_POST['signup-submit']))
	{
		require 'dbh.inc.php';

		$username = $_POST['uid'];
		$email = $_POST['mail'];
		$password = $_POST['pwd'];
		$passwordRepeat = $_POST['pwd-repeat'];

		if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat))
		{
			header("Location: ../signup.php?error=emptyfields&uid=".$username."&email=".$email);
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
		{
			header("Location: ../signup.php?error=invalidemailuid");
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			header("Location: ../signup.php?error=invalidemail&uid=".$email);
			exit();
		}
		else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
		{
			header("Location: ../signup.php?error=invaliduid&email=".$email);
			exit();
		}
		else if ($password !== $passwordRepeat)
		{
			header("Location: ../signup.php?error=passwordcheckuid=".$username."&email=".$email);
			exit();
		}
		
	}