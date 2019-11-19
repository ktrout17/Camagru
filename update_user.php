<?php
	session_start();
	require 'config/database.php';
	require 'header.php';

	if (isset($_POST['new_user']))
	{
		$new_user = $_POST['new_user'];
		$user_id = $_SESSION['user_id'];

		if (empty($new_user))
		{
			header("Location: update.php?error=emptyfields&username=".$username."&email=".$email);
			exit();
		}
		else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
		{	
			header("Location: signup.php?error=invalidusername");
			exit();
		}	
		
		else
		{
			$sql = "SELECT password, username FROM users WHERE user_id = :user_id";
			$stmt= $conn->prepare($sql);
			$stmt->bindParam(":user_id", $user_id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$checkpwd = password_verify($current_password, $result['password']);
			$count = $stmt->rowCount();
			if ($checkpwd == false)
			{
				header("Location: update_pwd.php?error=wrongpwd");
				exit();
			}
			else
			{
				$sql = "UPDATE users SET password = ?";
				$stmt->bindParam(1, $hashedpwd);
				$stmt->execute();
			}
		}
	}
	// else
	// {
	// 	header("Location: profile.php");
	// 	exit();
	// }

	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfields")
			$errormsg = "Fill in all fields.";
		else if ($_GET['error'] == "invalidusername")
			$errormsg = "Username cannot contain any special characters";
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
			<div style="font-size:30px;color:burlywood">Change Your Password</div>
			<br>
			<br>
			<form action="" method="post">
				<div style="color:cadetblue">New Username</div><br>
				<input type="text" name="new_user" placeholder="New Username" autocomplete="off" onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">Enter your password for verification</div><br>
				<input type="password" name="current_password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/>
				<input type="submit" name="new_user" value="Change Username"/>
			</form>
		</div>
	</div>
	</body>	                                                                            
</html>

<?php
	require 'footer.php';
?>