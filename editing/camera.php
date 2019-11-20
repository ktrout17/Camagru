<?php
	require "../style/header.php";
?>

<!DOCTYPE>
<html>
<head>
    <title>Webcam</title>
</head>
<body>
    
    <!-- Stream video via Webcam -->
    <div class = "video-wrap"></div>
        <video id="video" playsinline autoplay></video>
    </div>

    <!-- Trigger canvas web API -->
    <div class="controller">
        <button id="snap">Capture</button>
    </div>

    <!-- Webcam Video Snapshot -->
    <canvas id="canvas" width="640" height="480"></canvas>
	<script>
    	'use strict';
    	const video = document.getElementById('video');
    	const canvas = document.getElementById('canvas');
   	 	const snap = document.getElementById('snap');
    	const errorMsgElement = document.getElementById('span#ErrorMsg');
    	const constraints = 
    	{
        	audio: false,                       //true for on, false for off
       	 	video:
        	{
            	width: 640, height: 480
        	}
    	};
// Access webcam
    	async function init ()
    	{
        	try
			{
            	const stream = await navigator.mediaDevices.getUserMedia(constraints);
            	handleSuccess(stream);
        	}
        	catch(e)
        	{
            	errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
        	}
   		}
//Success
    	function handleSuccess(stream)
    	{
        	window.stream = stream
        	video.srcObject = stream;
    	}
// Load init
    	init();
// Draw image
    	var context = canvas.getContext('2d');
    	snap.addEventListener("click", function()
    	{
        	context.drawImage(video, 0, 0, 640, 480);
    	});
	</script>
</body>
</html>

<?php
	require '../style/footer.php';
?>