<?php 
echo "code: to show the date in format >>>>  2001-03-10 17:16:18 >>>>> MYSQL";
echo '<br>'.'date("Y-m-d H:i:s");'.'<br>';
echo date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)

echo '<br>'."code: to get the timestamp from any given date";
echo '<br>'.'strtotime(date("Y-m-d H:i:s"));'.'<br>';
echo strtotime(date("Y-m-d H:i:s")), "\n";


$val1 = 1389348078;
$val2 = 1389348483;

var_dump($val1 - $val2);




?>
