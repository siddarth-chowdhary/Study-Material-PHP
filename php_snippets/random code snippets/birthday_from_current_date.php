<?php 
function birthday($birthday){ 
    $age = strtotime($birthday); 
    if($age === false){ 
        return false; 
    } 
    list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
    $now = strtotime("now"); 
    list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
    $age = $y2 - $y1; 
    if((int)($m2.$d2) < (int)($m1.$d1)) 
        $age -= 1; 
    return $age; 
} 

echo birthday('1989-12-05'); 
?>
