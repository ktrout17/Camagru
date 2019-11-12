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
		<!-- <header>
		<img src="img/logo.png" alt="logo" class="logo">
			<nav>
				<ul>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</header> -->
		<?php
			if (isset($_SESSION['user_id']))
				echo '<header>
				<img src="img/logo.png" alt="logo" class="logo">
					<nav>
						<ul>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</nav>
				</header>';
			else
				echo '<header>
				<img src="img/logo.png" alt="logo" class="logo">
					<nav>
						<ul>
							<li><a href="index.php">HOME</a></li>
							<li><a href="login.php">LOGIN</a></li>
							<li><a href="signup.php">Signup</a></li>
						</ul>
					</nav>
				</header>'
		?>
	</body>
</html>