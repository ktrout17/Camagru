<?php 
	require "header.php";	
	require 'config/database.php';

if (isset($_POST['signup-submit']))
{
	$errormsg = '';

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordRepeat = $_POST['password-repeat'];
	$hashedpwd = password_hash($password, PASSWORD_DEFAULT);

	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat))
	{
		header("Location: signup.php?error=emptyfields&username=".$username."&email=".$email);
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invalidemailusername");
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: signup.php?error=invalidemail&username=".$email);
		exit();
	}
	else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
	{
		header("Location: signup.php?error=invalidusername&email=".$email);
		exit();
	}
	else if ($password !== $passwordRepeat)
	{
		header("Location: signup.php?error=passwordcheckusername=".$username."&email=".$email);
		exit();
	}
	
	if($errormsg == '')
	{
		try 
		{
			$query = "SELECT id FROM users WHERE email = ? AND email_status = 'verified'";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(1, $email);
			$stmt->execute();
			$num = $stmt->rowCount();

			if ($num > 0)
			{
				$errormsg = "Your email has already been verified.";
			}
			else 
			{
				$query = "SELECT id FROM users WHERE email = ? AND email_status = 'not verified'";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(1, $email);
				$stmt->execute();
				$num = $stmt->rowCount();
				
				if ($num > 0)
				{
					$errormsg = "Your email has already been verified.";
				}
				else 
				{
					$activation_code = md5(uniqid("randomstring", true));
					$verification_link = "http://localhost/Camagru_github/activate.php?code=".$activation_code;
						
					$htmlStr = "";
					$htmlStr .= "Hi ".$username.",<br /><br />";
					$htmlStr .= "Please click the button below to verify your email and gain full access to kt editing.<br /><br /><br />";
					$htmlStr .= "<a href='{$verification_link}' target='_blank' style ='padding:1em; font-weight:bold; background-color:burlywood; color:cadetblue;'>VERIFY EMAIL</a><br /><br /><br />";
					$htmlStr .= "Kind Regards, <br />";
					$htmlStr .= "kt editing";
					$name = "kt editing";
					$email_sender = "no-reply@ktediting.com";
					$subject = "Email Verification Link | kt editing";
					$recipient_email = $email;
					
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$headers .= "From: {$name} <{$email_sender}> \n";
					$body = $htmlStr;
					
					if (mail($recipient_email, $subject, $body, $headers))
					{
						
						$stmt = $conn->prepare('INSERT INTO users (username, email, password, activation_code) VALUES (:username, :email, :hashedpwd, :activation_code)');				
						$array = array(				
							':username' => $username,					
							':email' => $email,					
							':hashedpwd' => $hashedpwd,					
							':activation_code' => $activation_code	
						);
						
						if ($stmt->execute($array))
						{
							$errormsg = "A verification email has been sent to <b>".$email."</b>, please check your email and click the link provided to verify your email";
						}
						else
						{
							$errormsg = "Unable to save your email to the database.";
						}
					}
					else
					{
						echo "hello";
						die("Sending failed.");
					}
				}
			}
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
}
if (isset($_GET["action"]) && $_GET["action"] === "joined")
	$errormsg = 'Registration successful! You can now <a href="index.php">login</a>';
if (isset($_GET['error']))
{
	if ($_GET['error'] == "emptyfields")
		$errormsg = "Fill in all fields.";
	else if ($_GET['error'] == "invalidemailusername")
		$errormsg = "Invalid username and email.";
	else if ($_GET['error'] == "invalidemail")
		$errormsg = "Invalid email";
	else if ($_GET['error'] == "invalidusername")
		$errormsg = "Invalid username";
	else if ($_GET['error'] == "passwordcheckusername")
		$errormsg = "Passwords do not match.";
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
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errormsg.'</div><br />';
			?>			
			<div style="font-size:30px;color:cadetblue">Signup</div>
			<br>
			<br>
			<form action="signup.php" method="post">
				<input type="text" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="text" name="email" placeholder="E-mail" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="password" name="password-repeat" placeholder="Re-enter Password" value="<?php if(isset($_POST['password-repeat'])) echo $_POST['password-repeat'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
				<input type="submit" name="signup-submit" value="Signup" class="submit"/><br />
				<div style="color:cadetblue;">Already have an account? Login <a href="index.php">here</a></div>
			</form>
		</div>
	</div>
</body>	
</html>

<?php
	require "footer.php";
?>