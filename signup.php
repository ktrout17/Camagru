<?php 
	require "header.php";	
	require 'includes/dbh.inc.php';

if (isset($_POST['signup-submit']))
{
	$errormsg = '';

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordRepeat = $_POST['password-repeat'];
	$pin = $_POST['pin'];
	$hashedpwd = password_hash($password, PASSWORD_DEFAULT);

	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat))
	{
		header("Location: signup.php?error=emptyfields&username=".$username."&email=".$email);
		$errormsg = 'Empty fields';
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invalidemailusername");
		$errormsg = 'Please enter a valid email address and username.';
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: signup.php?error=invalidemail&username=".$email);
		$errormsg = 'Please enter a valid email address.';
		exit();
	}
	else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invalidusername&email=".$email);
		$errormsg = 'Please enter a valid username (no symbols).';
		exit();
	}
	else if ($password !== $passwordRepeat)
	{
		header("Location: signup.php?error=passwordcheckusername=".$username."&email=".$email);
		$errormsg = 'Passwords do not match.';
		exit();
	}
	
	if($errormsg == '')
	{
		try 
		{
			$stmt = $conn->prepare('INSERT INTO users (username, email, password, pin) VALUES (:username, :email, :hashedpwd, :pin)');
			$stmt->execute(array(
				':username' => $username,
				':email' => $email,
				':hashedpwd' => $hashedpwd,
				':pin' => $pin
				));
			header('Location: signup.php?action=joined');
			exit();
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
}
if (isset($_GET["action"]) && $_GET["action"] === "joined")
	$errormsg = 'Registration successful! You can now <a href="index.php">login</a>';
?>
<html>
<head>
	<title>Signup</title>
	<link rel="stylesheet" href="style.css">
</head>		
<body>
	<div align="center">
		<div class="signup">
			<?php
				if (isset($errormsg))
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>			
			<div style="font-size:30px;color:cadetblue">Signup</div>
			<br>
			<br>
			<form action="signup.php" method="post">
				<input type="text" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="text" name="email" placeholder="E-mail" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="password-repeat" placeholder="Re-enter Password" value="<?php if(isset($_POST['password-repeat'])) echo $_POST['password-repeat'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="pin" placeholder="Pin" value="<?php if(isset($_POST['pin'])) echo $_POST['pin'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="submit" name="signup-submit" value="Signup" class="submit"/><br />
			</form>
		</div>
	</div>
</body>	
</html>

<?php
	require "footer.php";
?>