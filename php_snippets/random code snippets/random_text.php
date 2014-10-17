<?php 
# This particular code will generate a random string 
# that is 25 charicters long 25 comes from the number 
# that is in the for loop 
$string = "abcdefghijklmnopqrstuvwxyz0123456789"; 
for($i=0;$i<25;$i++){ 
    $pos = rand(0,36); 
    $str .= $string{$pos}; 
} 
echo $str; 
# If you have a database you can save the string in  
# there, and send the user an email with the code in 
# it they then can click a link or copy the code 
# and you can then verify that that is the correct email 
# or verify what ever you want to verify 
?>
