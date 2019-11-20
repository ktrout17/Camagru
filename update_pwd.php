<?php
	require 'config/database.php';
	require 'header.php';

	if (isset($_POST['change_pwd']))
	{
		$errormsg = '';
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password'];
		$new_password_repeat = $_POST['new_password_repeat'];
		$hashedpwd = password_hash($new_password, PASSWORD_DEFAULT);
		$user_id = $_SESSION['user_id'];

		if (empty($current_password) ||empty($new_password) || empty($new_password_repeat))
		{
			header("Location: update_pwd.php?error=emptyfields&username=".$username."&email=".$email);
			exit();
		}	
		else if (!preg_match("/[A-Z]*$/", $new_password))
		{
			header("Location: update_pwd.php?error=invalidpassword");
			exit();
		}
		else if (!preg_match("/[!@#$%^()+=\-\[\]\';,.\/{}|:<>?~]/", $new_password))
		{
			header("Location: update_pwd.php?error=invalidpasswordscharreq");
			exit();
		}
		else if ($new_password !== $new_password_repeat)
		{
			header("Location: update_pwd.php?error=passwordsnotmatch=".$username."&email=".$email);
			exit();
		}
		
		try
		{
			$sql = "SELECT password FROM users WHERE user_id = :user_id";
			$stmt= $conn->prepare($sql);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$checkpwd = password_verify($current_password, $result['password']);
			if ($checkpwd == false)
			{
				header("Location: update_pwd.php?error=wrongpwd");
				exit();
			}
			else
			{
				$sql = "UPDATE users SET password = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(1, $hashedpwd);
				$stmt->execute();
				$errormsg = "Password Successfully Updated. Logout and relogin to see changes.";
			}
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}	
	}
	
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfields")
			$errormsg = "Fill in all fields.";
		else if ($_GET['error'] == "invalidpassword")
			$errormsg = "Password must have at least one uppercase letter";
		else if ($_GET['error'] == "invalidpasswordscharreq")
			$errormsg = "Password must have at least one special character";
		else if ($_GET['error'] == "passwordsnotmatch")
			$errormsg = "Passwords do not match.";
		else if ($_GET['error'] == "wrongpwd")
			$errormsg = "Incorrect password.";
	}
?>

<html>
	<link rel="stylesheet" href="style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<body>
	<div align="center">
		<div class="update">
			<?php
				if(isset($errormsg))
					echo '<div style="color:red;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>
			<br>
			<div style="font-size:30px;color:burlywood">Change Your Password</div>
			<br>
			<br>
			<form action="" method="post">
				<div style="color:cadetblue">Current Password</div><br>
				<input type="password" name="current_password" placeholder="Current Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">New Password</div><br>
				<input type="password" name="new_password" placeholder="New Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">Re-enter New Password</div><br>
				<input type="password" name="new_password_repeat" placeholder="Re-enter New Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/>
				<input type="submit" name="change_pwd" value="Change Password"/>
			</form>
		</div>
	</div>
	</body>	
</html>

<?php
	require 'footer.php';
?>