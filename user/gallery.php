<?php
	require '../style/header.php';
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="../style/style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<body>
		<div id="gal_header">User's Gallery</div>
		<div id="gal_container">
			<a href="../img/background.jpg"><img src="../img/background.jpg"/></a>
			<a href="../img/background2.png"><img src="../img/background2.png"/></a>
			<a href="../img/background3.jpg"><img src="../img/background3.jpg"/></a>
			<a href="../img/wallpaper4.png"><img src="../img/wallpaper4.png"/></a>
			<a href="../img/wallpaper2.jpg"><img src="../img/wallpaper2.jpg"/></a>
			<a href="../img/wallpaper3.jpg"><img src="../img/wallpaper3.jpg"/></a>
			<a href="../img/wallpaper5.png"><img src="../img/wallpaper5.png"/></a>
			<a href="../img/headerfoot.jpg"><img src="../img/headerfoot.jpg"/></a>
			<a href="../img/header:footer.jpg"><img src="../img/header:footer.jpg"/></a>
			<p>9 Images Displayed | <a href="#gal_header">Back to Top</a></p>
			<br>
			<hr />
		</div>
	</body>
</html>
<script>
var contentHeight = 800;
var pageHeight = document.documentElement.clientHeight;
var scrollPosition;
var n = 10;
var xmlhttp;
 
function putImages()
{
     
    if (xmlhttp.readyState==4)
    {
        if(xmlhttp.responseText)
		{
        	var resp = xmlhttp.responseText.replace("\r\n", ""); 
            var files = resp.split(";");
            var j = 0;
            for(i=0; i<files.length; i++)
			{
                if(files[i] != "")
				{
                	document.getElementById("gal_container").innerHTML += '<a href="../img/'+files[i]+'"><img src="../img/'+files[i]+'" /></a>';
                    j++;
                   	if(j == 3 || j == 6)
                          document.getElementById("gal_container").innerHTML += '';
                    else if(j == 9)
					{
                        document.getElementById("gal_container").innerHTML += '<p>'+(n-1)+" Images Displayed | <a href='#gal_header'>top</a></p><hr />";
                        j = 0;
                    }
                }
            }
        }
    }
}
         
         
function scroll(){
     
    if(navigator.appName == "Microsoft Internet Explorer")
        scrollPosition = document.documentElement.scrollTop;
    else
        scrollPosition = window.pageYOffset;        
     
    if((contentHeight - pageHeight - scrollPosition) < 500){
                 
        if(window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            if(window.ActiveXObject)
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            else
                alert ("Bummer! Your browser does not support XMLHTTP!");         
           
        var url="get_images_gall.php?n="+n;
         
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
         
        n += 9;
        xmlhttp.onreadystatechange=putImages;       
        contentHeight += 800;       
    }
}
 
</script>

<?php
	require '../style/footer.php';
?>