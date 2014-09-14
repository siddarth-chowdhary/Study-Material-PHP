<?php
/*methods implemented
 * login              --login to a sugarCRM instance
 * get_entry_list     --retrieve a list of records of a specified module
 * get_entry          --retrieve a single record of a specified module
 * get_entries        --retrieve an array of records of a specified module
 * set_entry          --create/update a single record in a specified module
 * set_entries        --create/update an array of records in a specified module
 * set_relationship   --create a relationship between records
*/


/*
 * setting up to use the system
 * */

    $url = "http://localhost/SugarCRM/service/v4_1/soap.php?wsdl";
    $username = "admin";
    $password = "admin";

    //require NuSOAP
    require_once("nusoap/nusoap.php");

    //retrieve WSDL
    $client = new nusoap_client($url, 'wsdl');

    //display errors
    $err = $client->getError();
    if ($err)
    {
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
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
         'application_name' => 'SoapTest',
         'name_value_list' => array(
         ),
    );

    $login_result = $client->call('login', $login_parameters);

    //p($login_result);
    
    //get session id
    $session_id =  $login_result['id'];
    //p($session_id);   //check session_id
    
    /*
     * get_entry_list() for retrieving a list of Leads
     * */
    $get_entry_list_parameters = array(
     //session id
     'session' => $session_id,

     //The name of the module from which to retrieve records
     'module_name' => 'Leads',

     //~ //The SQL WHERE clause without the word "where".
     //~ 'query' => "",
//~ 
     //~ //The SQL ORDER BY clause without the phrase "order by".
     //~ 'order_by' => "",
//~ 
     //~ //The record offset from which to start.
     //~ 'offset' => 0,
//~ 
     //~ //A list of fields to include in the results.
     //~ 'select_fields' => array(
          //~ 'id',
          //~ 'name',
          //~ 'title',
     //~ ),
//~ 
     //~ //A list of link names and the fields to be returned for each link name.
     //~ 'link_name_to_fields_array' => array(
         //~ array(
             //~ 'name' => 'email_addresses',
             //~ 'value' => array(
                 //~ 'email_address',
                 //~ 'opt_out',
                 //~ 'primary_address'
             //~ ),
         //~ ),
     //~ ),
//~ 
     //~ //The maximum number of results to return.
     //~ 'max_results' => 2,
//~ 
     //~ //If deleted records should be included in results.
     //~ 'deleted' => 0,
//~ 
     //~ //If only records marked as favorites should be returned.
     //~ 'favorites' => false,
);

$leads = $client->call('get_entry_list', $get_entry_list_parameters);
//p($leads);

	/*
     * get_entry() for retrieving a single contact sybil hanah
     * */
$get_entry_parameters = array(
     //session id
     'session' => $session_id,

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
$contact = $client->call('get_entry',$get_entry_parameters);
//p($contact);



	/*
     * get_entries() for retrieving an array of record specied by their id
     * */
$get_entries_parameters = array(
     //session id
     'session' => $session_id,

     //The name of the module from which to retrieve records
     'module_name' => "Contacts",

     //The ID of the record to retrieve.
     'ids' => array("32786d44-2d3e-7793-e3f6-51e6421ff2f6",  //albert adkinson
					"f35ab67d-d496-0ec5-3265-51e6413cb26d",  //erick akridge
     ),    

     //The list of fields to be returned in the results
     'select_fields' => array(
          'id',
          'first_name',
          'last_name',
     ),

    //Flag the record as a recently viewed item
    'track_view' => true,
);
$contacts = $client->call('get_entries',$get_entries_parameters);
//p($contacts);



/*
 * get_entry_list() to show accounts and their related contacts of 'link_name_to_fields_array'
 * shown in a table uncommnet the table to see the result
 * */
$get_relationships_parameters = array(

         'session'=>$session_id,
         'module_name' => 'Accounts',
		 'select_fields' => array(
          'id',
          'name',
          'account_type',
		  ),
         'link_name_to_fields_array' => array(
			 array(
				 'name' => 'contacts',
				 'value' => array(
					 'full_name',
					 'title',
					 'account_name'
				 ),
			),
         ),	
         //~ 'max_results' => 2,
    );

    $get_relationships_result = $client->call("get_entry_list", $get_relationships_parameters);
?>
<!--
<h1>ACCOUNTS</h1>
<table border="1">
	<tr><th>ID</th><th>NAME</th><th>CONTACTS Related to This Account</th><th>TITLE</th></tr>
	<?php
		//~ $cnt=count($get_relationships_result['entry_list']);
		//~ for($i=0;$i<$cnt;$i++){
			//~ $k=0;
			//~ echo '<tr>';
			//~ echo '<td>'.$get_relationships_result['entry_list'][$i]['name_value_list'][$k++]['value'].'</td>';
			//~ echo '<td>'.$get_relationships_result['entry_list'][$i]['name_value_list'][$k++]['value'].'</td>';
			//~ echo '<td>';
			//~ $innerCount=count($get_relationships_result['relationship_list'][$i]['link_list'][0]['records']);
			//~ for($j=0;$j<$innerCount;$j++){
				//~ echo $get_relationships_result['relationship_list'][$i]['link_list'][0]['records'][$j]['link_value'][0]['value'];
				//~ echo ' , ';
			//~ }
			//~ echo '</td>';
			//~ echo '<td>'.$get_relationships_result['entry_list'][$i]['name_value_list'][$k++]['value'].'</td>';
			//~ echo '</tr>';
		//~ }
	?>
</table>
-->
<?php


/*
 * set_entry() to create/update a single record - here accounts
 * */
$set_entry_parameters = array(
    //session id
    "session" => $session_id,
   
    //The name of the module from which to retrieve records.
    "module_name" => "Accounts",
   
    //Record attributes
    "name_value_list" => array(
        //to update a record
        /*
        array(
            "name" => "id",
            "value" => "1d1344da-09de-92e2-7bc5-51ee15221d76"
        ),
        */
        //to create a new record with a specific ID
        /*
        array(
            "name" => "new_with_id",
            "value" => true
        ),
        */
        array(
            "name" => "name",
            "value" => "Example Account - made by siddarth --and updated"
        ),
    ),
);
//p($set_entry_parameters);
$created_one_account = $client->call('set_entry',$set_entry_parameters);
p($created_one_account);


/*
 * set_entries() to create/update records accounts
 * */
$set_entries_parameters = array(
    //Session id
    "session" => $session_id,

    //The name of the module from which to retrieve records.
    "module_name" => "Accounts",

    //Record attributes
    "name_value_lists" => array(
        array(
            //to update a record
            
            array(
                "name" => "id",
                "value" => "3f695cdc-3c41-a4d9-ae8c-51ee187217dd"       //example 1
            ),
            
            //to create a new record with a specific ID
            /*
            array(
                "name" => "new_with_id",
                "value" => 1
            ),
            */
            array(
                "name" => "name",
                "value" => "Example Account 1 -- modified"
            ),
        ),
        array(
            //to update a record
            
            array(
                "name" => "id",
                "value" => "605983d9-8e63-9cc9-fbc1-51ee18ddf099"       //example 2
            ),
            
            //to create a new record with a specific ID
            /*
            array(
                "name" => "new_with_id",
                "value" => 1
            ),
            */
            array(
                "name" => "name",
                "value" => "Example Account 2 -- modified"
            ),
        ),
    ),
);
//~ $created_accounts = $client->call('set_entries',$set_entries_parameters);
//~ p($created_accounts);



$set_relationship_parameters = array(
    //session id
    'session' => $session_id,

    //The name of the module.
    'module_name' => 'Opportunities',

    //The ID of the specified module bean.
    'module_id' => 'c11eff6b-ce5b-de6e-f672-51e641462958',  //aim capital opp ki id

    //The relationship name of the linked field from which to relate records.
    'link_field_name' => 'contacts',

    //The list of record ids to relate
    'related_ids' => array(
        '114093c5-28e6-9559-d101-51e642032eb8',         //sybil hannah contact ki id
    ),

    //Sets the value for relationship based fields
    'name_value_list' => array(
        array(
            'name' => 'contact_role',
            'value' => 'Other'
        )
    ),

    //Whether or not to delete the relationship. 0:create, 1:delete
    'delete'=> 0,
);

//~ $created_relation_bw_opp_and_account = $client->call('set_relationship',$set_relationship_parameters);
//~ $p($created_relation_bw_opp_and_account);


/*
 * p() implementation
 * */
 function p($x) {
		echo '<pre>';
		print_r($x);
		die('-----------------------------------in p()-------------------------------------');
}
?>

