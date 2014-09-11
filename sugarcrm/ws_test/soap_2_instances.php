<?php
/*
 * setting up to use the system
 * */

    $url_1 = "http://localhost/SugarCRM/service/v4_1/soap.php?wsdl";
    $url_2 = "http://localhost/sugar/service/v4_1/soap.php?wsdl";
    $username = "admin";
    $password = "admin";

    //require NuSOAP
    require_once("nusoap/nusoap.php");

    //retrieve WSDL
    $client_1 = new nusoap_client($url_1, 'wsdl');
    $client_2 = new nusoap_client($url_2, 'wsdl');
    

    //display errors
    $err_1 = $client_1->getError();
    $err_2 = $client_2->getError();
    if ($err_1 || $err_2)
    {
        echo '<h2>Constructor error</h2><pre>' . $err_1 . '</pre>';
        echo '<h2>Constructor error</h2><pre>' . $err_2 . '</pre>';
        echo '<h2>Debug</h2><pre>' . htmlspecialchars($client_1->getDebug(), ENT_QUOTES) . '</pre>';
        echo '<h2>Debug</h2><pre>' . htmlspecialchars($client_2->getDebug(), ENT_QUOTES) . '</pre>';
        exit();
    }

/*
 * login to the sugar CRM
 * */

    $login_parameters = array(
         'user_auth' => array(
              'user_name' => $username,
              'password' => md5($password),
              'version' => '1'
         ),
    );

    $login_result_client_1 = $client_1->call('login', $login_parameters);
    $login_result_client_2 = $client_2->call('login', $login_parameters);

    //~ p($login_result_client_2);
	$session_id_client_1 =  $login_result_client_1['id'];
	$session_id_client_2 =  $login_result_client_2['id'];

/*
 * get_entry() for retrieving a single contact sybil hanah from 1st instance
 * */
$get_entry_parameters = array(
     //session id
     'session' => $session_id_client_1,

     //The name of the module from which to retrieve records
     'module_name' => "Contacts",

     //The ID of the record to retrieve.
     'id' => "114093c5-28e6-9559-d101-51e642032eb8",     //id of sybil , president in contacts

     //The list of fields to be returned in the results
     'select_fields' => array(
          'id',
          'first_name',
          'last_name',
     ),

    //Flag the record as a recently viewed item
    'track_view' => true,
);
$contact = $client_1->call('get_entry',$get_entry_parameters);
//p($contact);

/*
 * set_entry() to create/update a single record - here accounts copied to 2nd instance
 * */
 $fieldsCount = count($contact['entry_list'][0]['name_value_list']);
 //p($fieldsCount);
$set_entry_parameters = array(
    //session id
    "session" => $session_id_client_2,
   
    //The name of the module from which to retrieve records.
    "module_name" => "Contacts",
   
    //Record attributes
    "name_value_list" => array(
        //to update a record
        /*
        array(
            "name" => "id",
            "value" => "1d1344da-09de-92e2-7bc5-51ee15221d76"
        ),
        */
        //~ array(
        //not required id coz automatically generated 
            //~ "name" => "$contact['entry_list'][0]['name_value_list'][0]['name']",  //coz id given automatically
            //~ "value" => $contact['entry_list'][0]['name_value_list'][0]['value']
            //~ foreach($contact['entry_list'][0]['name_value_list'] as $name =>$value) {
				//~ "name"=>$name,
				//~ "value"=>$value,
			//~ }
        //~ ),
        array(
            "name" => $contact['entry_list'][0]['name_value_list'][1]['name'],
            "value" => $contact['entry_list'][0]['name_value_list'][1]['value']
        ),
        array(
            "name" => $contact['entry_list'][0]['name_value_list'][2]['name'],
            "value" => $contact['entry_list'][0]['name_value_list'][2]['value']
        ),
    ),
);
//p($set_entry_parameters);
//~ $created_one_contact = $client_2->call('set_entry',$set_entry_parameters);
//~ p($created_one_contact);


//check if sugar is empty
$get_entry_list_parameters = array(
     'session' => $session_id_client_2,
     'module_name' => 'Leads',
);

$leads = $client_2->call('get_entry_list', $get_entry_list_parameters);
//~ p($leads);






?>

<?php
/*
 * p() implementation
 * */
 function p($x) {
		echo '<pre>';
		print_r($x);
		die('-----------------------------------in p()-------------------------------------');
}?>
