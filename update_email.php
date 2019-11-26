<?php
	// session_start();
	require 'config/database.php';
	require 'style/header.php';

	if (isset($_POST['change_email']))
	{
		$errormsg = '';
		$new_email = $_POST['new_email'];
		$current_password = $_POST['current_password'];
		$user_id = $_SESSION['user_id'];

		if (empty($new_email))
		{
			header("Location: update_email.php?error=emptyfields");
			exit();
		}	
		else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL))
		{
			header("Location: update_email.php?error=invalidemail");
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
				header("Location: update_email.php?error=wrongpwd");
				exit();
			}
			else
			{
				$sql = "UPDATE users SET email = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(1, $new_email);
				$stmt->execute();
				$errormsg = "Email Successfully Updated. Logout and relogin to see changes.";
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
		else if ($_GET['error'] == "invalidemail")
			$errormsg = "Please enter a valid email";
		else if ($_GET['error'] == "emailtaken")
			$errormsg = "Email is same as current address";
		else if ($_GET['error'] == "wrongpwd")
			$errormsg = "Incorrect Password";
	}
?>

<html>
	<link rel="stylesheet" href="style/style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<body>
	<div align="center">
		<div class="update">
			<?php
				if(isset($errormsg))
					echo '<div style="color:red;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>
			<br>
			<div style="font-size:30px;color:burlywood">Change Your Email</div>
			<br>
			<br>
			<form action="" method="post">
			<div style="color:cadetblue">New Email</div><br>
				<input type="text" name="new_email" placeholder="New Email" autocomplete="off" onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">Enter your password for verification</div><br>
				<input type="password" name="current_password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/>
				<input type="submit" name="change_email" value="Change Email"/>
			</form>
		</div>
	</div>
	</body>	
</html>

<?php
	require 'style/footer.php';
?>