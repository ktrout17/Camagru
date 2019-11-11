<?php
	require 'config/database.php';
	require 'header.php';

	if (empty($_SESSION['username']))
		header("Location: login.php");

	if (isset($_POST['update']))
	{
		$errormsg = "";
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_repeat = $_POST['password_repeat'];
		$hashedpwd = password_hash($new_password, PASSWORD_DEFAULT);

		if (empty($username) || empty($email) || empty($password) || empty($password_repeat))
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
		else if (!preg_match("/[A-Z]*$/", $password))
		{
			header("Location: signup.php?error=invalidpassword");
			exit();
		}
		else if (!preg_match("/[!@#$%^()+=\-\[\]\';,.\/{}|:<>?~]/", $password))
		{
			header("Location: signup.php?error=invalidpasswordscharreq");
			exit();
		}
		else if ($password !== $password_repeat)
		{
			header("Location: signup.php?error=passwordsnotmatch=".$username."&email=".$email);
			exit();
		}
		// if ($errormsg == '')
		// {
		// 	try
		// 	{
		// 		$sql = "UPDATE users SET username = :username, password = :password, email = :email"
		// 	}
		// }
	}
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfields")
			$errormsg = "Fill in all fields.";
		else if ($_GET['error'] == "invalidemailusername")
			$errormsg = "Invalid username and email.";
		else if ($_GET['error'] == "invalidemail")
			$errormsg = "Please enter a valid email";
		else if ($_GET['error'] == "invalidusername")
			$errormsg = "Username cannot contain any special characters";
		else if ($_GET['error'] == "invalidpassword")
			$errormsg = "Password must have at least one uppercase letter";
		else if ($_GET['error'] == "invalidpasswordscharreq")
			$errormsg = "Password must have at least one special character";
		else if ($_GET['error'] == "passwordsnotmatch")
			$errormsg = "Passwords do not match.";
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
			<div style="font-size:30px;color:cadetblue">Update Your Info</div>
			<br>
			<br>
			<form action="" method="post">
				Username <br>
				<input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION['username']; ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box"/><br /><br />
				Email <br>
				<input type="text" name="email" placeholder="Email" value="<?php echo $_SESSION['email'];?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				Password <br>
				<input type="password" name="password" value=" <?php echo $_SESSION['password'];?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				Re-enter Password <br>
				<input type="password" name="password_repeat" value="<?php echo $_SESSION['password_repeat'];?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<input type="submit" name="update" value="UPDATE"/>
			</form>
		</div>
	</div>
	</body>	
	</html>

<?php
	require "footer.php";
?>