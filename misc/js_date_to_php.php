<!DOCTYPE html>
<html>
<head>
	<title>DATE</title>
	<script type="text/javascript">
		var d = new Date();
		console.log("FULL DATE : " + d);
		var n = d.getTime();
		console.log("UNIX TIMESTAMP :  "+  n/1000);
	</script>
</head>
<body>
		<?php
			$timestamp = 1404545138.841;
			echo gmdate("Y-m-d H:i:s ", $timestamp);
		?>
</body>
</html>