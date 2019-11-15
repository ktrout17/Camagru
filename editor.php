<?php
	require 'header.php';
?>

<!DOCTYPE>
<html>
	<main>
		<div class="editor">
			<div id="content">
				<form action="editor.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="size" value="1000000">
					<div class="upload">
						<input type="file" name="image">
					</div>
					<div class="upload">
						<input type="submit" name="upload" value="Upload Image">
					</div>
				</form>
				<form action="camera.php" method="post">
					<input type="submit" name="webcam" value="Use Webcam">
				</form> 
			</div>
		</div>
		<?php
			if ($_SESSION['email_status'] == 'verified')
			{
				echo '<div style="color:cadetblue">You account needs to be verified to use the editor</div>';
				echo '<div style="color:cadetblue">Please verify your account</div>';
			}
			else  
			{
				if (isset($_POST['webcam']))
					include "camera.php";
			}
		?>
	</main>
</html>

<?php
	require 'footer.php';
?>