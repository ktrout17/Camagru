<?php
	require 'config/database.php';
	require 'header.php';

	if (isset($_POST['change_user']))
	{
		$errormsg = '';
		$new_user = $_POST['new_user'];
		$user_id = $_SESSION['user_id'];
		$current_password = $_POST['current_password'];

		if (empty($new_user))
		{
			header("Location: update_user.php?error=emptyfields");
			exit();
		}
		else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
		{	
			header("Location: update_user.php?error=invalidusername");
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
				header("Location: update_user.php?error=wrongpwd");
				exit();
			}
			else
			{
				$sql = "UPDATE users SET username = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(1, $new_user);
				$stmt->execute();
				header("Location: profile.php");
				$errormsg = "Username Successfully Updated. Logout and relogin to see changes.";
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
		else if ($_GET['error'] == "invalidusername")
			$errormsg = "Username cannot contain any special characters";
		else if ($_GET['error'] == "wrongpwd")
			$errormsg = "Incorrect Password";
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
			<div style="font-size:30px;color:burlywood">Change Your Username</div>
			<br>
			<br>
			<form action="" method="post">
				<div style="color:cadetblue">New Username</div><br>
				<input type="text" name="new_user" placeholder="New Username" autocomplete="off" onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<div style="color:cadetblue">Enter your password for verification</div><br>
				<input type="password" name="current_password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/>
				<input type="submit" name="change_user" value="Change Username"/>
			</form>
		</div>
	</div>
	</body>	                                                                            
</html>

<?php
	require 'footer.php';
?>