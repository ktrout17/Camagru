<?php
	require "config/database.php";
	require "style/header.php";

	if (isset($_POST['login-submit']))
	{
		$errormsg = '';

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		
		if($username == '')
		$errormsg = 'Enter username';
		if($password == '')
		$errormsg = 'Enter password';
		
		if (empty($username) || empty($password))
		{
			header("Location: login.php?error=emptyfields");
			exit();
		}
		
		try 
		{
			$stmt = $conn->prepare('SELECT * FROM users WHERE username = :email OR email = :email');
			$stmt->execute(array(
				':email' => $username,
			));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$verified = $data['email_status'];
			
			if($data == false){
					$errormsg = "User/email not found.";
				}
				else 
				{
					$pwdcheck = password_verify($password, $data['password']);
					if ($pwdcheck == false)
					{
						header('Location: login.php?error=pwdnomatch');
						exit();
					}
					if ($verified !== 'verified')
					{
						header("Location: login.php?error=notverified");
						exit();
					}
					else if(($pwdcheck == true) && ($verified == 'verified')) 
					{
						session_start();
						$_SESSION['user_id'] = $data['user_id'];
						$_SESSION['username'] = $data['username'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['email_status'] = $data['email_status'];
						header('Location: profile.php?login=success');
						exit;
					}
					else
					{
						header('Location: login.php?error=wrongpwd');
						exit();
					}
				}
			}
			catch(PDOException $e) {
				$errormsg = $e->getMessage();
			}
		
	}
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfields")
			$errormsg = "Fill in all fields";
		else if ($_GET['error'] == "pwdnomatch")
			$errormsg = 'Incorrect Password';
		else if ($_GET['error'] == "wrongpwd")
			$errormsg = 'Incorrect Password';
		else if ($_GET['error'] == "notverified")
			$errormsg = "Your account needs to be verified to login. Please verify your account.";
	}
	if (isset($_GET['login']) && $_GET['login'] == "success")
		$errormsg = 'You have successfully logged in';
?>

	<html>
	<link rel="stylesheet" href="style/style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<body>
	<div align="center">
		<div class="login">
			<?php
				if(isset($errormsg))
					echo '<div style="color:red;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>
			<br>
			<div style="font-size:30px;color:cadetblue">Welcome Back!</div>
			<br>
			<br>
			<form action="login.php" method="post">
				<input type="text" name="username" placeholder="Username/E-mail" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box"/><br /><br />
				<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<input type="submit" name="login-submit" value="Login" class="submit"/><br />
				<div style="color:cadetblue;">Don't have an account? Create one <a href="signup.php">here</a></div>
				<div style="color:cadetblue;"><a href="email verification/forgot_pwd.php">I forgot my password</a></div>
			</form>
		</div>
	</div>
	</body>	
	</html>

<?php
	require "style/footer.php";
?>