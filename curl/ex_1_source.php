<?php
/******************
Gary George
http://georgewebdesign.co.uk
@gary_george


below are the 3 cURL requests from the video.
Use as required.

Remember to change the urls to ones which is relevant to your server.

****************/


/*Example 1
cURL request for some xml data 
*/
/*
	//initiaize
		$ch = curl_init();
	//set the url
		$url = 'http://georgewebdesign.co.uk/tutorials/curl/data.php?type=xml';		
	//set options		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
	//execute	
		$data = curl_exec($ch);
	//close curl session / free resources	
		curl_close($ch);
	//set up your xml result	
		$xml = new SimpleXmlElement($data, LIBXML_NOCDATA);
	//loop through the results	
		$cnt = count($xml->Result);
    	for($i=0; $i<$cnt; $i++){
			echo 'XML : <b>First Name = </b>'.$xml->Result[$i]->FirstName.'  <b>Last Name = </b>'.$xml->Result[$i]->LastName.'<br>';
    	} 
*/




/*Example 2
cURL request for some json data 
*/
/*
	//initiaize
		$ch = curl_init();
	//set the url
		$url = 'http://georgewebdesign.co.uk/tutorials/curl/data.php?type=json';		
	//set options		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);		
	//execute 
		$json = curl_exec($ch); 
	//close curl session / free resources
		curl_close($ch);
	//decode the json string into an array
		$json = json_decode($json, true);			
	//loop through the results				
		for($i=0; $i<$json['Metadata']['TotalResults']; $i++) {
			 echo "JSON : <b>First Name =  </b>" . $json['Result'][$i]["FirstName"] . " ,  <b>Last Name = </b>" . $json['Result'][$i]["LastName"] . "<br>";
		}
*/





/*Example 3
post an array of data using cURL 
*/ 
/*
	//initiaize the array
		$members = array();
	//member 1
		$member1 = array( 'first_name_1' => 'Gary' , 'last_name_1' => 'George') ;          
		array_push($members , $member1);
		$numMembers = count($members);
	//member 2
		$member2 = array( 'first_name_1' => 'Tyler' , 'last_name_1' => 'George') ;  
		array_push($members , $member2);
		$numMembers = count($members);
	

	//initiaize
		$ch = curl_init();
	//set the url
		$url = "http://georgewebdesign.co.uk/tutorials/curl/data.php?type=post";
	//makes the array suitable for sending
		$items = http_build_query($members);
	//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($members));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $items);	
	//execute post
		$result = curl_exec($ch);	
	//close connection
		curl_close($ch);
		
*/		



	







?>