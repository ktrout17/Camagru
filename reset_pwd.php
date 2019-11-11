<?php
	require 'header.php';
	require 'config/database.php';

	$errormsg = "";
	if (isset($_POST['new_password_submit']))
	{
		$user_id = intval(base64_decode($_GET['user_id']));
		$new_password = $_POST['new_password'];
		$new_password_repeat = $_POST['new_password_repeat'];
		$hashedpwd = password_hash($new_password, PASSWORD_DEFAULT);
		
		if (!preg_match("/[A-Z]*$/", $new_password))
		{
			header("Location: reset_pwd.php?error=invalidpassword");
			exit();
		}
		else if (!preg_match("/[!@#$%^()+=\-\[\]\';,.\/{}|:<>?~]/", $new_password))
		{
			header("Location: reset_pwd.php?error=invalidpasswordscharreq");
			exit();
		}
		else if ($new_password !== $new_password_repeat)
		{
			header("Location: reset_pwd.php?error=passwordsnotmatch");
			exit();
		}

		try 
		{
			$sql = "UPDATE users SET `password` = :hashedpwd WHERE user_id = :user_id";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":hashedpwd", $hashedpwd);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$errormsg = 'Password changed successfully! You can now login <a href="index.php">here</a>';
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			$errormsg = "Something went wrong. Please try again";
		}
	}
	if (isset($_GET['error']))
	{	
		if ($_GET['error'] == "invalidpassword")
			$errormsg = "Password must have at least one uppercase letter";
		else if ($_GET['error'] == "invalidpasswordscharreq")
			$errormsg = "Password must have at least one special character";
		else if ($_GET['error'] == "passwordsnotmatch")
			$errormsg = "Passwords do not match.";
	}
?>

<!DOCTYPE>
<html>
	<head>
		<title>Reset Password</title>
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style.css">	
	</head>
	<body>
	<div align="center">
			<div class="resetpwd">
			<?php
				if (isset($errormsg))
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errormsg.'</div><br />';
			?>			
			<div style="font-size:30px;color:cadetblue">Reset Your Password</div>
			<br>
			<br>
			<form action="" method="post">
				<div style="color:burlywood">Enter your new password</div>
				<br>
				<input type="password" name="new_password" placeholder="New Password">
				<input type="password" name="new_password_repeat" placeholder="Re-enter New Password">
				<input type="submit" name="new_password_submit" value="Reset My Password">
			</form>
			</div>
		</div>
	</body>
</html>

<?php
	require 'footer.php';
?>