<?php 
	require 'style/header.php'; 	
?>

<html !DOCTYPE>
	<html>
		<link rel="stylesheet" href="style/style.css">
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<main>
		<?php
		include 'editing/functions.php';

		$image = $_GET['image'];
		$image_id = $_GET['id'];
		$location = $_SERVER['REQUEST_URI'];
		$likes = get_likes($image_id);
		$comments = get_user_comments($image_id, 1);
		$usernames = get_user_comments($image_id, 0);
		$comment_len = count($comments);
		?>
		<div class="comment-wrapper">
			<div class="comment-grid">
				<section class="comment-image">	
					<img src="<?php echo $image;?>">
				</section>
				<section class="comment-section">
					<?php if (isset($_SESSION['user_id']) && $_SESSION['email_status'] == 'verified')
					{
					?>	
					<form method='post' action='includes/comments.inc.php'>
						<textarea name='comment' placeholder='Enter your comment here..'></textarea><br>
						<input type='hidden' name='img-id' value='<?php echo $image_id; ?>'>
						<input type="hidden" name="location" value="<?php echo $location; ?>">
						<button class='comment-btn' name="comment-submit" type='submit'>Comment</button>
						<button id="like-btn" style="background: url(img/likeicon.png)" name="submit-like" value="<?php echo $likes; ?>" onclick="add_like()"><?php echo $likes; ?></button>
					</form>
					<?php }
					if (!isset($_SESSION['user_id']) && !$_SESSION['email_status'] == 'verified')
					{ ?>
						<button id="like-btn" style="background: url(img/likeicon.png)" disabled ><?php echo $likes; ?></button>
					<?php } 
					?>
					<fieldset class="comments">
					<?php
						$i = 0;
						while ($i < $comment_len)
						{
							?>
							<span>
							<?php
							echo "<p class='comm-name'>$usernames[$i] :</p>";
							echo nl2br("\n");
							?>
							</span>
							<span>
							<?php
							echo "<p class='comm-text'>$comments[$i]</p>";
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
			function add_likes()
			{
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