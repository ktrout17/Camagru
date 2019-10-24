<!DOCTYPE> 
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<title>Camagru - kt editing</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<header>
			<div class="container">
				<img src="img/logo.png" alt="logo" class="logo">
				<nav>
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="#">Profile</a></li>
						<li><a href="#">Images</a></li>
						<li><a href="#">About</a></li>
					</ul>
				</nav>
				<div class="login">
					<form action="includes/login.inc.php" method="post">
						<input type="text" name="mailuid" placeholder="Username/email">
						<input type="password" name="pwd" placeholder="Password">
						<button type="submit" name="login-submit">Login</button>
					</form>
					<a href="signup.php">Signup</a>
					<form action="includes/logout.inc.php" method="post">
						<button type="submit" name="logout-submit">Logout</button>
					</form>
				</div>
			</div>
		</header>
	</body>
</html>