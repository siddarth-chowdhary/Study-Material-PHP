<?php
/*
 * Data which is to submitted to the remote URL
 */
$data = array();
$data['first_name'] = 'Jatinder';
$data['last_name'] = 'Thind';
$data['password'] = 'password';
$data['email'] = 'me@abc.com';

/*
 * Prepare data for posting. That is, urlencode data 
 */
$post_str = '';
foreach($data as $key=>$val) {
	$post_str .= $key.'='.urlencode($val).'&';
}
$post_str = substr($post_str, 0, -1);

/*
 * Initialize cURL and connect to the remote URL
 * You will need to replace the URL with your own server's URL
 * or wherever you uploaded this script to. 
 */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/dump/curl/curl-forms/form-handler.php' );

/*
 * Instruct cURL to do a regular HTTP POST
 */
curl_setopt($ch, CURLOPT_POST, TRUE);

/*
 * Specify the data which is to be posted
 */
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);

/*
 * Tell curl_exec to return the response output as a string
 */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

/**
 * Execute the cURL session
 */
$response = curl_exec($ch );

/**
 * Close cURL session and file
 */
curl_close($ch );

echo $response;
?>
