<?php
	require "includes/dbh.inc.php";
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
		if($errormsg == '') 
		{
			try 
			{
				$stmt = $connect->prepare('SELECT id, username, email, password, pin FROM users WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($data == false){
					$errormsg = "User $username not found.";
				}
				else 
				{
					if($password == $data['password']) 
					{
						$_SESSION['username'] = $data['username'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['pin'] = $data['pin'];
						header('Location: dashboard.php');
						exit;
					}
					else
						$errormsg = 'Passwords do not match.';
				}
			}
			catch(PDOException $e) {
				$errormsg = $e->getMessage();
			}
		}
	}
?>