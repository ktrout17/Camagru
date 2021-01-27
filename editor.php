<?php
	require 'config/database.php';
	require 'style/header.php';
	include 'editing/functions.php';
	
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="style/style.css">
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
						<img class="sticker" src="stickers/1.png" onclick="merge('stickers/1.png')"><br />
						<img class="sticker" src="stickers/2.png" onclick="merge('stickers/2.png')"><br />
						<img class="sticker" src="stickers/3.png" onclick="merge('stickers/3.png')"><br />
						<img class="sticker" src="stickers/4.png" onclick="merge('stickers/4.png')"><br />
						<img class="sticker" src="stickers/5.png" onclick="merge('stickers/5.png')"><br />
						<img class="sticker" src="stickers/6.png" onclick="merge('stickers/6.png')"><br />
						<img class="sticker" src="stickers/22.png" onclick="merge('stickers/22.png')"><br />
						<img class="sticker" src="stickers/23.png" onclick="merge('stickers/23.png')"><br />
						<img class="sticker" src="stickers/24.png" onclick="merge('stickers/24.png')"><br />
						<img class="sticker" src="stickers/25.png" onclick="merge('stickers/25.png')"><br />
						<img class="sticker" src="stickers/26.png" onclick="merge('stickers/26.png')"><br />
						<img class="sticker" src="stickers/27.png" onclick="merge('stickers/27.png')"><br />
						<img class="sticker" src="stickers/28.png" onclick="merge('stickers/28.png')"><br />
						<img class="sticker" src="stickers/29.png" onclick="merge('stickers/29.png')"><br />
						<img class="sticker" src="stickers/30.png" onclick="merge('stickers/30.png')"><br />
						<img class="sticker" src="stickers/31.png" onclick="merge('stickers/31.png')"><br />
						<img class="sticker" src="stickers/32.png" onclick="merge('stickers/32.png')"><br />
						<p> | <a href="#stick_header">Back to Top</a></p>
						<br>
						<hr />
					</div>
					<div class="webcam">
						<video id="vid" autoplay></video><br />
						<button class="button" id="capture">Capture</button>
					</div>
					<div class="current">
					<?php while ($i < $size)
					{ ?>
						<a href="<?php echo $images[$i]; ?>"><img src="<?php echo $images[$i]; ?>"/></a>
						<?php $i++;
					}?>	
					</div>
					<div class="captured">
						<form action="editing/save_img.php" method="post">
							<canvas style="background-color:#FEF9E5" id="canvas" width="420" height="340"></canvas><br />
							<button class="button" id="upload" type="submit" name="upload" onclick="save_image()">Upload</button>
						</form>
						<button class="button" id="remove" onclick="remove()">Remove Stickers</button>
					</div>
					<div class="upload">
						<form enctype="multipart/form-data">
							<input id="file" name="image" accept="image" type="file" onclick="load_image()">
							<!-- <input value="Upload" type="button"> -->
						</form>
					</div>
				</div>
			<?php
			}
			?>
		<script type="text/javascript" async src="editing/camera.js"></script>
	</main>
	</html>
	
	<?php
	require 'style/footer.php';
	?>
	