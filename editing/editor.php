<?php
	require '../config/database.php';
	require '../style/header.php';
	include 'functions.php';
	
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="../style/style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<main>
			<?php
			if ($_SESSION['email_status'] == 'not verified')
			{
				echo '<div style="color:cadetblue">You account needs to be verified to use the editor</div>';
				echo '<div style="color:cadetblue">Please verify your account</div>';
				exit();
			}
			else  
			{
				$images = get_user_images(0);
				$size = count($images);
				$i = 0;		
			?>
				<div id="stick_header">Stickers</div>
				<br>
				<br>
				<div class="editor">
					<div class="stickers">
						<img class="sticker" src="../stickers/1.png" onclick="merge('../stickers/1.png')"><br />
						<img class="sticker" src="../stickers/2.png" onclick="merge('../stickers/2.png')"><br />
						<img class="sticker" src="../stickers/3.png" onclick="merge('../stickers/3.png')"><br />
						<img class="sticker" src="../stickers/4.png" onclick="merge('../stickers/4.png')"><br />
						<img class="sticker" src="../stickers/5.png" onclick="merge('../stickers/5.png')"><br />
						<img class="sticker" src="../stickers/6.png" onclick="merge('../stickers/6.png')"><br />
						<img class="sticker" src="../stickers/7.png" onclick="merge('../stickers/7.png')"><br />
						<img class="sticker" src="../stickers/8.png" onclick="merge('../stickers/8.png')"><br />
						<img class="sticker" src="../stickers/9.png" onclick="merge('../stickers/9.png')"><br />
						<img class="sticker" src="../stickers/10.png" onclick="merge('../stickers/10.png')"><br />
						<img class="sticker" src="../stickers/11.png" onclick="merge('../stickers/11.png')"><br />
						<img class="sticker" src="../stickers/12.png" onclick="merge('../stickers/12.png')"><br />
						<img class="sticker" src="../stickers/13.png" onclick="merge('../stickers/13.png')"><br />
						<img class="sticker" src="../stickers/14.png" onclick="merge('../stickers/14.png')"><br />
						<img class="sticker" src="../stickers/15.png" onclick="merge('../stickers/15.png')"><br />
						<img class="sticker" src="../stickers/16.png" onclick="merge('../stickers/16.png')"><br />
						<img class="sticker" src="../stickers/17.png" onclick="merge('../stickers/17.png')"><br />
						<img class="sticker" src="../stickers/18.png" onclick="merge('../stickers/18.png')"><br />
						<img class="sticker" src="../stickers/19.png" onclick="merge('../stickers/19.png')"><br />
						<img class="sticker" src="../stickers/20.png" onclick="merge('../stickers/20.png')"><br />
						<img class="sticker" src="../stickers/21.png" onclick="merge('../stickers/21.png')"><br />
						<p> | <a href="#stick_header">Back to Top</a></p>
						<br>
						<hr />
					</div>
					<div class="webcam">
						<video id="vid" autoplay></video><br />
						<button id="capture">Capture</button>
					</div>
					<div class="current">
					<?php while ($i < $size)
					{ ?>
						<a href="<?php echo $images[$i]; ?>"<img src="<?php echo $images[$i]; ?>"/></a>
						<?php $i++;
					}?>	
					</div>
					<div class="captured">
						<form action="save_img.php" method="post">
							<canvas style="background-color:#FEF9E5" id="canvas" width="320" height="240"></canvas><br />
							<button id="upload" type="submit" name="upload" onclick="save_image()">Upload</button>
						</form>
						<button id="remove" onclick="remove()">Remove</button>
					</div>
					<div class="upload">
						<form enctype="multipart/form-data">
						<input id="file" name="image" accept="image" type="file" onclick="load_image()">
						<input value="submit" type="button">
					</form>
				</div>
			</div>
			<?php
			}
			?>
		<script type="text/javascript" async src="camera.js"></script>
	</main>
	</html>
	
	<?php
	require '../style/footer.php';
	?>
	