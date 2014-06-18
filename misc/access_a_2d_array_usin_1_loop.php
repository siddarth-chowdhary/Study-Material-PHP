<?php

$arr = array(array(1,2,3,4,5),array(1,2,3,4,5),array(1,2,3,4,5),array(1,2,3,4,5),array(1,2,3,4,5));

echo "<pre>";print_r($arr);

/*

for($i=0;$i<25;$i++) {
	if (($i>=0) && ($i<5)) {
		echo "<br/>".$arr[0][$i]."<br/>";
	}
	if (($i>=5) && ($i<10)) {
		echo "<br/>".$arr[1][$i%5]."<br/>";
	}
	if (($i>=10) && ($i<15)) {
		echo "<br/>".$arr[2][$i%10]."<br/>";
	}
	if (($i>=15) && ($i<20)) {
		echo "<br/>".$arr[3][$i%15]."<br/>";
	}
	if (($i>=20) && ($i<25)) {
		echo "<br/>".$arr[4][$i%20]."<br/>";
	}
}
*/

for($i=0;$i<5;$i++) {
	if ($i==0) {
		echo $arr[$i][0];
		echo $arr[$i][1];
		echo $arr[$i][2];
		echo $arr[$i][3];
		echo $arr[$i][4];
	}
	if ($i==1) {
		echo $arr[$i][0];
		echo $arr[$i][1];
		echo $arr[$i][2];
		echo $arr[$i][3];
		echo $arr[$i][4];
	}
	if ($i==2) {
		echo $arr[$i][0];
		echo $arr[$i][1];
		echo $arr[$i][2];
		echo $arr[$i][3];
		echo $arr[$i][4];
	}
	if ($i==3) {
		echo $arr[$i][0];
		echo $arr[$i][1];
		echo $arr[$i][2];
		echo $arr[$i][3];
		echo $arr[$i][4];
	}
	if ($i==4) {
		echo $arr[$i][0];
		echo $arr[$i][1];
		echo $arr[$i][2];
		echo $arr[$i][3];
		echo $arr[$i][4];
	}
}
