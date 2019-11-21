<?php
	session_start();
?>
<!DOCTYPE> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<title>Camagru - kt editing</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
			if (isset($_SESSION['user_id']))
				echo '<header>
				<a href="index.php"><img src="../img/logo.png" alt="logo" class="logo"></a>
					<nav>
						<ul>
							<li><a href="../index.php">HOME</a></li>
							<li><a href="../user/profile.php">Profile</a></li>
							<li><a href="../editing/editor.php">Editor</a></li>
							<li><a href="../user/logout.php">Logout</a></li>
						</ul>
					</nav>
				</header>';
			else
				echo '<header>
				<a href="index.php"><img src="img/logo.png" alt="logo" class="logo"></a>
					<nav>
						<ul>
							<li><a href="login.php">LOGIN</a></li>
							<li><a href="signup.php">Signup</a></li>
						</ul>
					</nav>
				</header>'
		?>
	</body>
</html>