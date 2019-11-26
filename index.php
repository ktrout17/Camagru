<?php 
	require "style/header.php";
	include "editing/functions.php";
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
					$size = count($images);
					$i = 0;
				?>
				<?php while ($i < $size) 
				{ ?>
					<?php $loc = "comments.php?image=" . $image_id[$i]; ?>
					<img onclick="window.location.href='<?php echo $images[$i]; ?>'" src="<?php echo $images[$i]; ?>" />
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