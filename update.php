<?php
	session_start();
	require 'config/database.php';
	require 'header.php';

	if (empty($_SESSION['username']))
		header("Location: login.php");

	$curr_email = $_SESSION['email'];
	$curr_username = $_SESSION['username']; 

	if (isset($_POST['update']))
	{
		$errormsg = "";
		$username = $_POST['username'];
		$email = $_POST['email'];
		$current_password = $_POST['current_password'];
		$user_id = $_SESSION['user_id'];

		// if (empty($username) || empty($email) || empty($current_password))
		// {
		// 	header("Location: update.php?error=emptyfields&username=".$username."&email=".$email);
		// 	exit();
		// }	
		// else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
		// {
		// 	header("Location: update.php?error=invalidemailusername");
		// 	exit();
		// }
		// else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		// {
		// 	header("Location: update.php?error=invalidemail&username=".$email);
		// 	exit();
		// }
		// else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
		// {
		// 	header("Location: update.php?error=invalidusername&email=".$email);
		// 	exit();
		// }
		// else
		// {
			try
			{
				$sql = "SELECT password, email FROM users WHERE user_id = :user_id OR email = :email";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":user_id", $user_id);
				$stmt->bindParam(":email", $email);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$checkpwd = password_verify($current_password, $result['password']);
				$count = $stmt->rowCount();
				if ($checkpwd == false)
				{
					header("Location: update.php?error=wrongpwd");
					exit();
				}
				if ($count > 0)
				{
					header("Location: update.php?error=emailtaken");
					exit();
				}
				$sql = "UPDATE users SET username = ?, email = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(1, $username);
				$stmt->bindParam(2, $email);
				$stmt->execute();
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
// }
	// if (isset($_GET['error']))
	// {
	// 	if ($_GET['error'] == "emptyfields")
	// 		$errormsg = "Fill in all fields.";
	// 	else if ($_GET['error'] == "invalidemailusername")
	// 		$errormsg = "Invalid username and email.";
	// 	else if ($_GET['error'] == "invalidemail")
	// 		$errormsg = "Please enter a valid email";
	// 	else if ($_GET['error'] == "invalidusername")
	// 		$errormsg = "Username cannot contain any special characters";
	// 	else if ($_GET['error'] == "invalidpassword")
	// 		$errormsg = "Password must have at least one uppercase letter";
	// 	else if ($_GET['error'] == "invalidpasswordscharreq")
	// 		$errormsg = "Password must have at least one special character";
	// 	else if ($_GET['error'] == "passwordsnotmatch")
	// 		$errormsg = "Passwords do not match.";
	// 	else if ($_GET['error'] == "nopassword")
	// 		$errormsg = "Incorrect password.";
	// }
?>

<html>
	<link rel="stylesheet" href="style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<?php	
		if(isset($errormsg))	
			echo '<div style="color:#FF0000;text-align:center;font-size:18px;">'.$errormsg.'</div>';
	?>
	<body>
	<div align="center">
		<div class="update">
			<?php
				if(isset($errormsg))
					echo '<div style="color:#20b2aa;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>
			<div style="font-size:30px;color:burlywood">Update Your Info</div>
			<br>
			<br>
			<form action="" method="post">
				<!-- <div style="color:cadetblue">Username</div><br> -->
				<input type="text" name="username" placeholder="Username" value="<?php echo $curr_username; ?>" readonly autocomplete="off" />
				<input type="button" name="update_user" onclick="window.location.href = 'update_user.php" value="Change"/>
				<!-- <div style="color:cadetblue">Email</div><br> -->
				<input type="text" name="email" placeholder="Email" value="<?php echo $curr_email; ?>" readonly autocomplete="off"  />
				<input type="button" name="update_email" onclick="window.location.href = 'update_email.php" value="Change"/>
				<!-- <div style="color:cadetblue">Enter your password for verification</div><br>
				<input type="password" name="current_password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/> -->
				<!-- <input type="submit" name="update" value="UPDATE"/> -->
				<br>
				<div style="color:burlywood;font-size:20px">Would you like to change your password?</div>
				<input type="button" name="update_password" onclick="window.location.href = 'update_pwd.php'" value="Change Password"/>
			</form>	
		</div>
	</div>
	</body>	
</html>

<?php
	require 'footer.php';
?>