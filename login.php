<?php
	require "includes/dbh.inc.php";
	require "header.php";

	if (isset($_POST['login-submit']))
	{
		$errormsg = '';

		$username = $_POST['uid'];
		$password = $_POST['pwd'];

		if($username == '')
			$errMsg = 'Enter username';
		if($password == '')
			$errMsg = 'Enter password';
		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT id, username, email, password, pin FROM users WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($data == false){
					$errMsg = "User $username not found.";
				}
				else {
					if($password == $data['password']) {
						$_SESSION['username'] = $data['username'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['pin'] = $data['pin'];
						header('Location: dashboard.php');
						exit;
					}
					else
						$errMsg = 'Password not match.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>