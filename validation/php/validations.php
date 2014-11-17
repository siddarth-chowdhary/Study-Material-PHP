<?php
function isAlphaNumeric($val) {
	$pattern = '/^[a-z0-9]+([a-z0-9. ]*)?[a-z0-9]+$/i';
	if ( ! preg_match($pattern, $val))
		return false;
	return true;
}

function isValidEmail($email){ 
	$regex = "/([a-z0-9_]+|[a-z0-9_]+\.[a-z0-9_]+)@(([a-z0-9]|[a-z0-9]+\.[a-z0-9]+)+\.([a-z]{2,4}))/i"; 
	if ( ! preg_match($regex, $email))
		return false;
	return true;	
}

function isValidPhone( $val ) {
    if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $val ) )
        return true;
    return false;
}

function isNumeric($value)
{
    if (preg_match('/^([0-9]*)$/', $value))
    	return true;
    return false;
}


function isAlphabetic($value)
{
    if (preg_match('/^[a-zA-Z][a-zA-Z ]*$/', $value))
    	return true;
    return false;
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

var_dump(startsWith("hello world", "hello world1")); // true
//var_dump(endsWith("hello world", "world"));   // true
//var_dump(isAlphabetic('a'));