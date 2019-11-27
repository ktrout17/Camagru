<?php 
	require "style/header.php";
	include "editing/functions.php";
	include_once "config/setup.php";
?>
	<html>
		<link rel="stylesheet" href="style/style.css">
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<body>
			<div id="gal_header">Users' Gallery</div>
			<div id="gal_container">
				<?php
					$usernames = get_username_images(0);
					$images = get_images(0);
					$image_id = get_images(1);
					$size = count($images);
					$i = 0;
				?>
				<?php while ($i < $size) 
				{ ?>
					<?php $location = "comments.php?image=" . $images[$i] . "&id=" . $image_id[$i]; ?>
					<img onclick="window.location.href='<?php echo $location; ?>'" src="<?php echo $images[$i]; ?>" />
					<form id="<?php echo $image_id[$i] . "_form"; ?>" action="editing/delete_image.php" method="post">
							<input type="hidden" name="del_img" value="<?php echo $image_id[$i]; ?>">
					</form>
					<p><div style="text-align:center;">Uploaded by: <?php echo $usernames[$i]; ?></div></p>
					<?php $i++;
				} 	?>
		
				<p><?php echo $size ?> Images Displayed | <a href="#gal_header">Back to Top</a></p>
				<br>
				<hr />
			</div>
		</body>
	</html>

<?php
	require "style/footer.php";
?>