<?php 
	require "header.php";	
	require 'includes/dbh.inc.php';

if (isset($_POST['signup-submit']))
{
	$errormsg = '';

	$username = $_POST['uid'];
	$email = $_POST['mail'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];
	$pin = $_POST['pin'];

	if ($username == '')
		$errormsg = 'Enter your username';
	if ($email == '')
		$errormsg = 'Enter your email';
	if ($password == '')
		$errormsg = 'Enter a password';
	if ($passwordRepeat == '')
		$errormsg = "Repeat your password";
	if ($pin == '')
		$errormsg = 'Enter a pin';

	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat))
	{
		header("Location: signup.php?error=emptyfields&uid=".$username."&email=".$email);
		$errormsg = 'Empty fields';
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invalidemailuid");
		$errormsg = 'Please enter a valid email address and username.';
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: signup.php?error=invalidemail&uid=".$email);
		$errormsg = 'Please enter a valid email address.';
		exit();
	}
	else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invaliduid&email=".$email);
		$errormsg = 'Please enter a valid username (no symbols).';
		exit();
	}
	else if ($password !== $passwordRepeat)
	{
		header("Location: signup.php?error=passwordcheckuid=".$username."&email=".$email);
		$errormsg = 'Passwords do not match.';
		exit();
	}
	
	if($errormsg == '')
	{
		try 
		{
			$stmt = $connect->prepare('INSERT INTO users (username, email, password, pin) VALUES (:uid, :mail, :pwd, :pin)');
			$stmt->execute(array(
				':uid' => $username,
				':mail' => $email,
				':pwd' => $password,
				':pin' => $pin
				));
			header('Location: signup.php?action=joined');
			exit;
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
	if (isset($_GET['action']) && $_GET['action'] == 'joined')
		$errormsg = 'Registration successful! You can now <a href="login.php">login</a>';
}
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
				<input type="text" name="uid" placeholder="Username" value="<?php if(isset($_POST['uid'])) echo $_POST['uid'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="text" name="mail" placeholder="E-mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="pwd" placeholder="Password" value="<?php if(isset($_POST['pwd'])) echo $_POST['pwd'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="pwd-repeat" placeholder="Re-enter Password" value="<?php if(isset($_POST['pwd-repeart'])) echo $_POST['pwd-repeat'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="pin" placeholder="Pin" value="<?php if(isset($_POST['pin'])) echo $_POST['pin'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="submit" name="signup-submit" value="Signup"/><br />
			</form>
		</div>
	</div>
</body>	
</html>

<?php
	require "footer.php";
?>