<?php
function get_imgs()
{
	try 
	{
		$conn = new PDO("mysql:host=localhost;dbname=camagru_users;", "root", "qwertqwert");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$user_id = $_SESSION['userId'];
		$sql = "SELECT `img_src` FROM `images` WHERE `user_id` = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $user_id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return ($res);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}