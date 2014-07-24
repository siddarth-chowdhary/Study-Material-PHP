<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$("#upload_iframe", parent.document.body).find("div#container").html("from iframe"); 
});
</script>
<?php
echo "---------------------- IFRAME ---------------------- ";
echo "<pre>";print_r($_FILES);
     
/*
	if ($_FILES["file"]["error"] > 0)
     {
         echo "Error: " . $_FILES["file"]["error"] . "<br>";
     }
     else
     {
         echo "Upload: " . $_FILES["file"]["name"] . "<br>";
         echo "Type: " . $_FILES["file"]["type"] . "<br>";
         echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
         echo "Stored in: " . $_FILES["file"]["tmp_name"]. " <br>";
         $content = file_get_contents($_FILES["file"]["tmp_name"]);
         echo "Content: ".$content; 
     }
*/   
?>
