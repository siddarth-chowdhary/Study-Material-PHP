<?php 
function return_between($string, $start, $stop){ 
    $st = $string; 
    $list = array(); 
    for($i=0;$i<strlen($string);$i++){ 
        $temp = strpos($st, $start); 
        $str = substr($st, $temp+1); 
        $split_here = strpos($str, $stop); 
        $parsed_string = substr($str, 0, $split_here); 
        if($parsed_string == '') 
            break; 
        $st = substr($str, $split_here+1); 
        $list[] = $parsed_string; 
    } 
    return $list; 
} 

$text = 'This is a %string%, get text %some% text...'; 

print_r(return_between($text, '%', '%')); 
?>
