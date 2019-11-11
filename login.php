<?php
	require "config/database.php";
	require "header.php";

	if (isset($_POST['login-submit']))
	{
		$errormsg = '';

		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username == '')
			$errormsg = 'Enter username';
		if($password == '')
			$errormsg = 'Enter password';
		
		if (empty($username) || empty($password))
		{
			header("Location: index.php?error=emptyfields");
			exit();
		}
		
		if($errormsg == '') 
		{
			try 
			{
				$stmt = $conn->prepare('SELECT user_id, username, email, password FROM users WHERE username = :email OR email = :email');
				$stmt->execute(array(
					':email' => $username,
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($data == false){
					$errormsg = "User/email not found.";
				}
				else 
				{
					$pwdcheck = password_verify($password, $data['password']);
					if ($pwdcheck == false)
					{
						header('Location: index.php?error=pwdnomatch');
						exit();

					}
					else if($pwdcheck == true) 
					{
						session_start();
						$_SESSION['user_id'] = $data['user_id'];
						$_SESSION['username'] = $data['username'];
						header('Location: dashboard.php?login=success');
						exit;
					}
					else
					{
						header('Location: index.php?error=wrongpwd');
						exit();
					}
				}
			}
			catch(PDOException $e) {
				$errormsg = $e->getMessage();
			}
		}
	}
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfields")
			$errormsg = "Fill in all fields";
		else if ($_GET['error'] == "pwdnomatch")
			$errormsg = 'Passwords do not match.';
		else if ($_GET['error'] == "wrongpwd")
			$errormsg = 'Passwords do not match.';
	}
	if (isset($_GET['login']) && $_GET['login'] == "success")
		$errormsg = 'You have successfully logged in';
?>