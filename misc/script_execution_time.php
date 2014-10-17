<?php
$start = microtime(true);

//Your Script Content here

$end = microtime(true);
$time = number_format(($end - $start), 2);

echo 'This page loaded in ', $time, ' seconds';
?>
