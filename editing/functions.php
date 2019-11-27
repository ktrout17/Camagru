<?php 
function get_user_images($coll)
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT `img_src`, `image_id` FROM `images` WHERE `user_id` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $user_id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_COLUMN, $coll);
		return ($res);
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		
	}
}
function get_images($coll)
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `img_src`, `image_id` FROM `images` ORDER BY `image_id` DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_COLUMN, $coll);
		return ($res);
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
	}
}
function get_username_images()
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `username` FROM `images` JOIN `users` ON users.user_id = images.user_id ORDER BY `image_id` DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchALL(PDO::FETCH_COLUMN);
		return ($res);
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		exit();
	}
}
function get_comments($img_id)
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `comment` FROM `comments` WHERE `image_id` = $img_id ORDER BY `comment_id` DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return ($res);
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		exit();
	}
}
function get_user_comments($image_id, $coll)
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `username`, `comment` FROM ((`comments`
	JOIN `users` ON users.user_id = comments.user_id)
	JOIN `images` ON images.image_id = comments.image_id)
	WHERE comments.image_id = $image_id
	ORDER BY `comment_id` DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchALL(PDO::FETCH_COLUMN, $coll);
		return ($res);
	} catch (PDOException $e) {
		echo $e->getMessage();
		echo "1";
		exit();
	}
}
function get_likes($img_id)
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT `like` FROM `likes`
		JOIN `images` ON images.image_id = likes.image_id
		WHERE likes.image_id = $img_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$res = $stmt->rowCount();
		return ($res);
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		echo "2";
		exit();
	}
}