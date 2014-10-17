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
    $username = "saurabh";
    $password = "saurabh";
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

    $get_entry_list_result = array();
    $get_entry_list_result['result_count'] = 1;
    $get_entry_list_result['next_offset'] = 0;
    $totalCRMRecords = array();
    $flag = 0;
    while ($get_entry_list_result['result_count'] != 0) {
      $params = fncReturnGetEntryListParametersArray($session_id,'Calls',999,$get_entry_list_result['next_offset']);
        $get_entry_list_result = $client->call('get_entry_list', $params);
        if ($flag == 0) {
          $totalCRMRecords = $get_entry_list_result;
        } else {
          $totalCRMRecords['entry_list'] = array_merge($totalCRMRecords['entry_list'],$get_entry_list_result['entry_list']);
          
        }
        $flag = 1;
    }
    

    /*for displaying the result*/
    echo '<pre>';
    if ($totalCRMRecords === false) {
        var_dump($totalCRMRecords);   
    }else {
        // unset($get_entry_list_result['field_list']);
        print_r($totalCRMRecords);   
    }


    /*script execution related calculation*/
    $script_end_time = microtime(true);
    $time = number_format(($script_end_time - $script_start_time), 2);
    echo '<pre><hr>This script executed in ', $time, ' seconds<hr>';

    /*
    * @param $moduleName - Can be leads/contacts/calls etc
    * @param $maxResults _ Max no of results to be fetched
    * @desc This function returns the configuration array used in the get entry list method
    * @return The array configured for get entry list call
    */
    function fncReturnGetEntryListParametersArray($session_id,$moduleName,$maxResults,$offset) {
        $get_entry_list_parameters   = array(
           'session'       => $session_id,
           'module_name'   => $moduleName,
           'query'         => '',
           'order_by'      => 'date_modified desc',
           'offset'        => $offset,
           'select_fields' => array(
                  'id',
                  'first_name',
                  'title',
            ),
           'max_results' => $maxResults,
           'deleted' => '0',
           'Favorites' => false
        );
        // @for debug 
        // echo '<pre><hr>PARAMETRS<hr>';print_r($get_entry_list_parameters);echo '<hr>';
        // echo '<hr/> INI SETTINGS<hr>';
        // echo 'display_errors = ' . ini_get('display_errors') . "\n";
        // echo 'memory_limit = ' . ini_get('memory_limit') . "\n";
        // echo 'max_execution_time = ' . ini_get('max_execution_time') . "\n";
        // echo '<hr/> ';
        return $get_entry_list_parameters;
    }
?>
