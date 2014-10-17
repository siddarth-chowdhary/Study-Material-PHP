<?php

/*
difference between usage--
soap -- we need library , client creation to call a function

*/

    $url = "http://localhost/SugarCRM/service/v2_1/rest.php";
    $username = "admin";
    $password = "admin";

    //function to make cURL request
    function call($method, $parameters, $url='http://localhost/SugarCRM/service/v2_1/rest.php')
    {
        ob_start();
        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);

        $jsonEncodedData = json_encode($parameters);

        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );

        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }

    //login ---------------------------------

    $login_parameters = array(
         "user_auth"=>array(
              "user_name"=>$username,
              "password"=>md5($password),
              "version"=>"1"
         ),
         "application_name"=>"RestTest",
         "name_value_list"=>array(),
    );

    $login_result = call("login", $login_parameters);         //here 3 parameters , in soap 2 were given
     /*uncomment to see login info
      * */
    //echo "<pre>";
    //print_r($login_result);
    //echo "</pre>";

    //get session id
    $session_id = $login_result->id;
    
    //retrieve fields -----------------------------------

    $get_module_fields_parameters = array(

         //session id
         'session' => $session_id,

         //The name of the module from which to retrieve records
         'module_name' => 'Accounts',

         //Optional. Returns vardefs for the specified fields. An empty array will return all fields.
         'fields' => array(
             'id',
             'name',
         ),
    );

    $get_module_fields_result = call("get_module_fields", $get_module_fields_parameters);

    /*uncomment to see retrieved fields
      * */
    //~ echo "<pre>";
    //~ print_r($get_module_fields_result);
    //~ echo "</pre>";



	//get list of records --------------------------------
   
    $get_entry_list_parameters = array(

         //session id
         'session' => $session_id,

         //The name of the module from which to retrieve records
         'module_name' => 'Leads',

         //The SQL WHERE clause without the word "where".
         'query' => "",

         //The SQL ORDER BY clause without the phrase "order by".
         'order_by' => "",

         //The record offset from which to start.
         'offset' => '0',

         //Optional. A list of fields to include in the results.
         //~ 'select_fields' => array(
              //~ 'id',
              //~ 'name',
              //~ 'title',
         //~ ),

         /*
         A list of link names and the fields to be returned for each link name.
         Example: 'link_name_to_fields_array' => array(array('name' => 'email_addresses', 'value' => array('id', 'email_address', 'opt_out', 'primary_address')))
         */
         'link_name_to_fields_array' => array(
         ),

         //The maximum number of results to return.
         //~ 'max_results' => '2',

         //To exclude deleted records
         'deleted' => '0',

         //If only records marked as favorites should be returned.
         'Favorites' => false,
    );

    $get_entry_list_result = call('get_entry_list', $get_entry_list_parameters);

    /*uncomment to see leads
      * */
    //~ echo '<pre>';
    //~ print_r($get_entry_list_result);
    //~ echo '</pre>';
    
    
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
            "value" => "Example Account - made by siddarth"
        ),
    ),
);
/*uncomment to see record creation
 * */
//$created_one_account = call('set_entry',$set_entry_parameters);
//p($created_one_account);
    

//create note --------------------------------------------------

    $set_entry_parameters = array(
         //session id
         "session" => $session_id,

         //The name of the module
         "module_name" => "Notes",

         //Record attributes
         "name_value_list" => array(
              //to update a record, you will nee to pass in a record id as commented below
              //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
              array("name" => "name", "value" => "Example Note"),
         ),
    );

    $set_entry_result = call("set_entry", $set_entry_parameters);

    echo "<pre>";
    print_r($set_entry_result);
    echo "</pre>";

    $note_id = $set_entry_result->id;

//create note attachment -----------------------------------------

    $contents = file_get_contents ("example_file.php");

    $set_note_attachment_parameters = array(
        //session id
        "session" => $session_id,

        //The attachment details
        "note" => array(
            //The ID of the note containing the attachment.
            'id' => $note_id,

            //The file name of the attachment.
            'filename' => 'example_file.php',

            //The binary contents of the file.
            'file' => base64_encode($contents),
        ),
    );

    $set_note_attachment_result = call("set_note_attachment", $set_note_attachment_parameters);

    echo "<pre>";
    print_r($set_note_attachment_result);
    echo "</pre>";


/*
 * p() implementation
 * */
 function p($x) {
		echo '<pre>';
		print_r($x);
		die('-----------------------------------in p()-------------------------------------');
}   
?>
