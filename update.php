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
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password'];
		$new_password_repeat = $_POST['new_password_repeat'];
		$hashedpwd = password_hash($new_password, PASSWORD_DEFAULT);

		try
		{
			$fetchqryid = "SELECT user_id FROM users WHERE password = :current_password";
			$fetch_id = $conn->prepare($fetchqry);
			$fetch_id->bindValue(":current_password", $current_password);
			$fetch_id->execute();
			
			while ($row_id = $fetch_id->fetch(PDO::FETCH_ASSOC))
				$user_id = $row_id['user_id'];
			
			$fetchqrypwd = "SELECT password FROM users WHERE user_id = :user_id";
			$fetch_pwd = $conn->prepare($fetchqrypwd);
			$fetch_pwd->bindValue(":user_id", $user_id);
			$fetch_pwd->execute();
			
			while ($row_pwd = $fetch_pwd->fetch(PDO::FETCH_ASSOC))
				$checkpwd = $row_pwd['password'];

			$fetchqryuser = "SELECT username FROM users WHERE user_id = :user_id";
			$fetch_user = $conn->prepare($fetchqryuser);
			$fetch_user->bindValue(":user_id", $user_id);
			$fetch_user->execute();

			while ($row_user = $fetch_user->fetch(PDO::FETCH_ASSOC))
				$check_user = $row_user['username'];
			
			$fetchqryemail = "SELECT email FROM users WHERE user_id = :user_id";
			$fetch_email = $conn->prepare($fetchqryemail);
			$fetch_email->bindValue(":user_id", $user_id);
			$fetch_email->execute();

			while ($row_email = $fetch_email->fetch(PDO::FETCH_ASSOC))
				$check_email = $row_email['email'];
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
		
		if (empty($username) || empty($email) || empty($current_password) ||empty($new_password) || empty($new_password_repeat))
		{
			header("Location: update.php?error=emptyfields&username=".$username."&email=".$email);
			exit();
		}	
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
		{
			header("Location: update.php?error=invalidemailusername");
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			header("Location: update.php?error=invalidemail&username=".$email);
			exit();
		}
		else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
		{
			header("Location: update.php?error=invalidusername&email=".$email);
			exit();
		}
		else if (!preg_match("/[A-Z]*$/", $new_password))
		{
			header("Location: update.php?error=invalidpassword");
			exit();
		}
		else if (!preg_match("/[!@#$%^()+=\-\[\]\';,.\/{}|:<>?~]/", $new_password))
		{
			header("Location: update.php?error=invalidpasswordscharreq");
			exit();
		}
		else if ($new_password !== $new_password_repeat)
		{
			header("Location: update.php?error=passwordsnotmatch=".$username."&email=".$email);
			exit();
		}
		else if ($current_password !== $checkpwd)
		{
			header("Location: update.php?error=nopassword=".$username."&email=".$email);
			exit();
		}
		if ($errormsg == '')
		{
			try
			{
				$sql = "UPDATE users SET username = :username, email = :email, password = :hashedpwd WHERE user_id = :user_id";
				$stmt = $conn->prepare($sql);
				$stmt->execute(array(
					":username" => $username,
					":email" => $email,
					":hashedpwd" =>$hashedpwd,
					":user_id" => $user_id
				));

				header("Location: update.php?action=updated");
				exit();
			}
			catch(PDOException $e) 
			{
				echo $e->getMessage();
			}
		}
	}
	if (isset($_GET['action']) && $_GET['action'] == "updated")
		$errormsg = "Profile successfully updated. Please log out and in again to see changes.";
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
		else if ($_GET['error'] == "nopassword")
			$errormsg = "Incorrect password.";
	}
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
				<div style="color:cadetblue">Username</div><br>
				<input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION['username']; ?>" autocomplete="off" /><br /><br />
				<div style="color:cadetblue">Email</div><br>
				<input type="text" name="email" placeholder="Email" value="<?php echo $_SESSION['email']?>" autocomplete="off"  /><br/><br />
				<div style="color:cadetblue">Current Password</div><br>
				<input type="password" name="current_password" placeholder="Current Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">New Password</div><br>
				<input type="password" name="new_password" placeholder="New Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">Re-enter New Password</div><br>
				<input type="password" name="new_password_repeat" placeholder="Re-enter New Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<input type="submit" name="update" value="UPDATE"/>
			</form>
		</div>
	</div>
	</body>	
</html>

<?php
	require 'footer.php';
?>