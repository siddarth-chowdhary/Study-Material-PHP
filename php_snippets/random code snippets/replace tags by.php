<?php 
/* 
$content = text you want to parse 
$replacement = what you want to replace the tags with (Defaults to a space). 
*/ 
function tagStripReplace($content, $replacement = " "){ 
    return preg_replace("~<(w*[^>])*>~", $replacement, $content); 
} 
echo tagStripReplace("<p>I like pizza</p>",";"); 
echo tagStripReplace("<p>I like pizza</p><p>Do you?</p>"); 
?>
