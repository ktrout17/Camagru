<?php
	
	require 'header.php';
	require 'config/database.php';
	
	$errormsg = '';
	if (isset($_POST['reset_email']))
	{
		$email = $_POST['email'];
		$sql = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
		if (empty($email))
		{
			header("Location: forgot_pwd.php?error=emptyfield");
			exit();
		}

		try 
		{
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(":email", $email);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			if ($result[0]["count"] > 0)
			{
				$fetchqry = "SELECT user_id FROM users WHERE email = :email";
				$fetchid = $conn->prepare($fetchqry);
				$fetchid->bindValue(":email", $email);
				$fetchid->execute();
				
				while ($row = $fetchid->fetch(PDO::FETCH_ASSOC))
					$id = $row['user_id'];
				
				$reset_code = md5(uniqid("randomstring", true));
				$reset_link = "http://localhost/Camagru_github/reset_pwd.php?code=".$reset_code;
				
				$htmlStr = "";
				$htmlStr .= "Hi ".$email.",<br /><br />";
				$htmlStr .= "Please click the button below reset your password.<br /><br /><br />";
				$htmlStr .= "<a href='{$reset_link}' target='_blank' style ='padding:1em; font-weight:bold; background-color:burlywood; color:cadetblue;'>RESET PASSWORD</a><br /><br /><br />";
				$htmlStr .= "Kind Regards, <br />";
				$htmlStr .= "kt editing";
				$name = "kt editing";
				$email_sender = "no-reply@ktediting.com";
				$subject = "Password Reset Link | kt editing";
				$recipient_email = $email;
				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= "From: {$name} <{$email_sender}> \n";
				$body = $htmlStr;
				
				try
				{
					mail($recipient_email, $subject, $body, $headers);
					$errormsg = "A password reset email has been sent to <b>".$email."</b>, please check your email and click the link provided to reset your password";
				}
				catch (PDOException $e)
				{
					echo $e->getMessage();
					$errormsg = "Mail could not be sent. Please check your internet connection";
				}
			}
			else
				$errormsg = "Your email is not registered with us.";
		}
		catch(PDOException $e) 
		{
			echo $e->getMessage();
		}
	}
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == "emptyfield")
			$errormsg = "Please enter your email address";
	}
?>
<!DOCTYPE>
<html>
	<head>
	<title>Forgotten Password</title>
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div align="center">
			<div class="forgotpwd">
			<?php
				if (isset($errormsg))
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errormsg.'</div><br />';
			?>			
			<div style="font-size:30px;color:cadetblue">Forgotten Password</div>
			<br>
			<br>
			<form action="" method="post">
				<div style="color:burlywood">Enter your email below and a password reset link will be sent to you.</div>
				<br>
				<input type="text" name="email" placeholder="Email address">
				<input type="submit" name="reset_email" value="SEND RESET LINK">
			</form>
			</div>
		</div>
	</body>
</html>

<?php
	require 'footer.php';
?>