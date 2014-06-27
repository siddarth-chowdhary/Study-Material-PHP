<?php
	set_time_limit (0);
	$curl = curl_init ();
    curl_setopt ($curl, CURLOPT_URL, "http://test.com/" );
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1 );
    $siteName = curl_exec ($curl);
    curl_close ($curl);
    echo $siteName;
?>
