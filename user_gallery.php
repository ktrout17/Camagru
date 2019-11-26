<?php 
	require "style/header.php";
	require "config/database.php";
	include 'editing/functions.php';
?>
<main>	
	<?php
	if (empty($_SESSION['username']))
	{
		header("Location: index.php");
		exit();
	}
	else
	{ ?>
		<?php
		$images = get_user_images(0);
		$image_id = get_user_images(1);
		$size = count($images);
		$i = 0;
		?>
		<link rel="stylesheet" href="style/style.css">
		<meta name="viewpoint" content="width=device-width, initial-scale=1">
		<body>
			<div id="gal_header">My Gallery</div>
			<div id="gal_container">
		
			<?php while ($i < $size) { ?>
				
					<?php $loc = "comments.php?image=" . $image_id[$i]; ?>
					<img onclick="window.location.href='<?php echo $images[$i]; ?>'" src="<?php echo $images[$i]; ?>" />
					<span onclick="delete_img('<?php echo $image_id[$i]; ?>')">&xotime;</span>
					<form id="<?php echo $image_id[$i] . "_form"; ?>" action="editing/delete_image.php" method="post">
							<input type="hidden" name="del_img" value="<?php echo $image_id[$i]; ?>">
					</form>
				
				<?php $i++;
				} ?>
				<p><?php echo $size ?> Images Displayed | <a href="#gal_header">Back to Top</a></p>
				<br>
				<hr />
			</div>
		</body>
	<?php
	}
	?>
</main>

<?php
	require "style/footer.php";
?>