<?php
    $script_start_time = microtime(true);
    ini_set("display_errors","1");
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0);
    /*to solve the problem -Not a Valid Entry Point
    * Reason it's using the copy of nuSOAP found in Sugar 
    * (which has protections built in for entry points).
    */
    define('sugarEntry', TRUE);  
    //require NuSOAP
    require_once("nusoap.php");

    // soap client setup
    $username = "siddarth";
    $password = "siddarth";
    $client = new nusoapclient('http://dev1sugargini.ossclients.com/crmprodev6/soap.php?wsdl');

    //login to sugar crm
    $login_parameters = array(
         'user_auth' => array(
              'user_name' => $username,
              'password' => md5($password),
              'version' => '1'
         ),
         'application_name' => 'SoapTest',
         'name_value_list' => array(
         ),
    );

    $login_result = $client->call('login', $login_parameters);
    
    //set session id
    $session_id =  $login_result['id'];

	$set_entry_params = array(
	'session' => $session_id,
	'module_name' => 'Contacts',
	'name_value_list'=> array(
	array('name'=>'email1','value'=> 'email@email.com'),	
	));
	$result2 = $client->call('set_entry', $set_entry_params); 
	print_r($result2);
