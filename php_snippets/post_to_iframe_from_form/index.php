<form action="iframe.php" target="my-iframe" method="post">
			
  <input type="hidden" name="fld_hidden" value="<?php echo "From post iframe";?>">
  <input type="hidden" name="text" value="<?php echo "text box value again";?>">
			
  <input type="submit" value="post">
			
</form>
		
<iframe name="my-iframe" src="iframe.php?text=text box value">
	
</iframe>