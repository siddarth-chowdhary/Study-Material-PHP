<?php
//ini_set('display_errors','1');
require_once ('nusoap/nusoap.php');
echo '<pre>';
//Login into CRM
$endpoint_data = 'http://localhost/SugarCRM/service/v4_1/soap.php?wsdl';
$soapClient_data = new nusoapClient($endpoint_data,true);
//print_r($soapClient);

$userAuthParams = array(
					'user_auth' =>
					array('user_name'=>'admin','password'=>md5('admin')));
$userAuth_data = $soapClient_data->call('login',$userAuthParams);

//print_r($userAuth);
//Login Logic Ends Here

//$sessionId = $userAuth_data['id'];

$endpoint_nodata = 'http://localhost/sugar/service/v4_1/soap.php?wsdl';
$soapClient_nodata = new nusoapClient($endpoint_nodata,true);
//print_r($soapClient);

$userAuthParams = array(
					'user_auth' =>
					array('user_name'=>'admin','password'=>md5('admin')));
$userAuth_nodata = $soapClient_nodata->call('login',$userAuthParams);

//print_r($userAuth);
//Login Logic Ends Here

$sessionId_data = $userAuth_data['id'];
$sessionId_nodata = $userAuth_nodata['id'];

//~ print_r($sessionId_data.'<br/>');
//~ print_r($sessionId_nodata);

$get_entry_list_parameters = array(
     //session id
     'session' => $sessionId_data,

     //The name of the module from which to retrieve records
     'module_name' => 'Opportunities',
     
     'select_fields' => array(
          'name',
          'account_name','opportunity_type','lead_source',
    ),
);


$Opportunities = $soapClient_data->call('get_entry_list',$get_entry_list_parameters);
//p($Opportunities);//['entry_list'][0]['name_value_list']);
//die('here');

$size_data = count($Opportunities[entry_list]);
//p($size_data);
$set_entry_parameters = array();
$i=0;

for($i=0; $i<=$size_data; $i++)
{
	$set_entry_parameters = array(
		//session id
		"session" => $sessionId_nodata,
	
		//The name of the module from which to retrieve records.
		"module_name" => "Opportunities",
	
		//Record attributes
		"name_value_list" => $Opportunities['entry_list'][$i]['name_value_list'] 
		);
		//p($set_entry_parameters);
		$resultSet = $soapClient_nodata->call('set_entry',$set_entry_parameters);
		
}

//print_r($set_entry_parameters['name_value_list']);die;
//p($contact);

function p($t)
{
	echo '<pre>';
	print_r($t);
	die('in p()');
}
?>
