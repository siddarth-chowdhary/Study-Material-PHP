<?php
//step 2. save images to user's images folder (try)
//step2.1 if error throw error
$file = file_get_contents('http://zendguru.files.wordpress.com/2009/04/ajax-form1.jpg');
file_put_contents('public/image.jpg', $file);