<?php
/*
This file holds the examples which determine the data that is returned to our cURL request. 
*/

$type = $_GET['type'];

 
/***********************
		 XML
***********************/
if($type == 'xml'){	
	
	//open xml	
		$xml = new DOMDocument( "1.0", "UTF-8" );
		$xml->preserveWhiteSpace = false;
		$xml->formatOutput   = true;				
	// Create "root" Elements
		$xml_root = $xml->createElement("XML-Example");
		$xml_root->setAttribute("Version", "1.0");	
	//metadata xml 
		$xml_item = $xml->createElement("Metadata");
		$xml_root->appendChild($xml_item);	
		$xml_item->appendChild($xml->createElement( "TotalResults", 1 ));	
	//result xml											
		$xml_item = $xml->createElement("Result");
		$xml_root->appendChild($xml_item);			
						
		$xml_item->appendChild($xml->createElement( 'FirstName', 	'Gary') );											
		$xml_item->appendChild($xml->createElement( 'LastName', 	'George') );			
																																													
	//close xml	
		$xml->appendChild($xml_root);		
	// Parse the XML.
		$_xml = $xml->saveXML();	
		echo $_xml;
	
}


/***********************
		JSON
***********************/
if($type == 'json'){

	//metadata which will contain how many results we have
		$meta_array['TotalResults'] = 1;
		$metadata= '{"Metadata" : ';
		$metadata.= json_encode($meta_array).',';	
	
	//the data																																																				
		$array["FirstName"] = 	'Gary' ;				
		$array["LastName"] = 	'George' ;																		
		$data[] = $array;																							
		
	//json encode the array		   
		$json_encoded = utf8_encode(json_encode($data));
		echo $metadata.' "Result" : '.$json_encoded.'}';
		
		exit();		
}


/***********************
		POST
***********************/
if($type == 'post'){
	
	//print out the posted vars
	print_r($_POST);
		
}


?>