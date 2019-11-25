<?php
if (isset($_POST['del_img']))
{
	include '../config/database.php';
	$img_id = $_POST['del_img'];
	try 
	{
		$sql = "DELETE FROM `images` WHERE `image_id` = $img_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		header("Location: ../user/profile.php");
		exit();
	} catch (PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>