<?php 
	require 'style/header.php'; 
  

if (isset($_POST['submit-comment'])) 
{
	session_start();
	try 
	{
		include "../config/database.php";
		$msg = htmlspecialchars($_POST['comment']);
		$userid = $_SESSION['user_id'];
		$image_id = $_POST['img-id'];
		$loc = $_POST['loc'];
		$sql = "INSERT INTO `comments` (`comment`,`user_id`,`image_id`) VALUES (?, $userid, $image_id);";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $msg);
		$stmt->execute();
		header("Location: " . $loc);
		exit();
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		exit();
	}
} 
else if (isset($_POST['submit-like'])) 
{
	session_start();
	try 
	{
		include "../config/database.php";
		$loc = $_POST['loc'];
		$image_id = $_POST['img-id'];
		$likes = $_POST['submit-like'];
		$sql = "INSERT INTO `likes` (`like`,`image_id`) VALUES ($likes, $image_id);";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		header("Location: " . $loc);
		exit();
	} 
	catch (PDOException $e) 
	{
		echo $e->getMessage();
		exit();
	}
} 
else 
{
	header("Location: ../gallery.php?page=1");
	exit();
}
?>

<html>
<main>
	<?php
	include 'editing/functions.php';
	$image = $_GET['image'];
	$image_id = $_GET['id'];
	$loc = $_SERVER['REQUEST_URI'];
	$likes = get_likes($image_id);
	$com = get_user_comments($image_id, 1);
	$usernames = get_user_comments($image_id, 0); 
	$com_len = count($com);
	?>
	<div class="comment-wrapper">
		<div class="comment-grid">
			<section class="comment-image">
				<img src="<?php echo $image; ?>">
			</section>
			<section class="comment-section">
				<?php if (isset($_SESSION['userId']))
				{
				?>
				<form action="comments.php" method="post">
					<textarea name="comment" class="my-comm" placeholder="Comment on this pic"></textarea>
					<input type="hidden" name="img-id" value="<?php echo $image_id; ?>">
					<input type="hidden" name="loc" value="<?php echo $loc; ?>">
					<button type="submit" name="submit-comment">Post</button>
					<input type="image" src="img/like.jpeg" name="submit-like" value="<?php echo $likes; ?>" onclick="add_like()">Like: <?php echo $likes; ?></button>
				</form>
				<?php } ?>
				<fieldset class="messages">
						<?php
						$i = 0;
						while ($i < $com_len)
						{
							?>
							<span>
							<?php
							echo $usernames[$i];
							echo nl2br("\n");
							?>
							</span>
							<span>
							<?php
							echo $com[$i];
							echo nl2br("\n");
							?>
							</span>
							<?php
							$i++;
						}
						?>
				</fieldset>
			</section>
		</div>
	</div>
	<script>
		function add_like() {
			var like;
			like = parseInt(document.getElementById('like-btn').value) + 1;
			document.getElementById('like-btn').value = like.toString();
		}
	</script>
</main>
</html>

<?php 
	require 'style/footer.php';
?>