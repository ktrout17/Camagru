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
		
		if (empty($email) || empty($password))
		{
			header("Location: index.php?error=emptyfields");
			$errormsg = "Empty fields";
			exit();
		}
		
		if($errormsg == '') 
		{
			try 
			{
				$stmt = $conn->prepare('SELECT id, username, email, password, pin FROM users WHERE username = :username OR email = :email');
				$stmt->execute(array(
					':username' => $username,
					':email' => $email
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($data == false){
					$errormsg = "User $username / $email not found.";
				}
				else 
				{
					$pwdcheck = password_verify($password, $data['password']);
					if ($pwdcheck == false)
					{
						header('Location: index.php?error=wrongpwd');
						$errormsg = 'Passwords do not match.';
						exit();

					}
					else if($pwdcheck == true) 
					{
						session_start();
						$_SESSION['id'] = $data['id'];
						$_SESSION['username'] = $data['username'];
	//					$_SESSION['email'] = $data['email'];
	//					$_SESSION['password'] = $data['password'];
	//					$_SESSION['pin'] = $data['pin'];
						header('Location: dashboard.php?login=success');
						$errormsg = 'You have successfully logged in';
						exit;
					}
					else
					{
						header('Location: index.php?error=wrongpwd');
						$errormsg = 'Passwords do not match.';
						exit();
					}
				}
			}
			catch(PDOException $e) {
				$errormsg = $e->getMessage();
			}
		}
	}
?>