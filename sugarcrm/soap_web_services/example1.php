<?php
    $script_start_time = microtime(true);
    ini_set("display_errors","1");
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', '0');
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
    $client = new nusoapclient('http://dev1sugargini.ossclients.com/crmprodev6/soap.php');

//      $username = "admin";
//     $password = "admin";
   
// $client = new nusoapclient('http://localhost/SugarCRM/soap.php');
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
    $crm_result = array();
    $count = 0;
    $crm_result['field_list'] =  array();
    $crm_result['entry_list'] = array();
    while ($get_entry_list_result['result_count'] != 0 && $count < 2) {
      if (isset($get_entry_list_result['next_offset'])) {
         $offset = $get_entry_list_result['next_offset'];
       } else {
        $offset = 999;
       }

       $params = fncReturnGetEntryListParametersArray($session_id,'Calls',999,$offset);
      $get_entry_list_result = $client->call('get_entry_list', $params);

// unset($get_entry_list_result['field_list']);
      $crm_result['field_list'] = 
        array_merge($crm_result['field_list'],$get_entry_list_result['field_list']);

      $crm_result['entry_list'] = 
             array_merge($crm_result['entry_list'],$get_entry_list_result['entry_list']);
      // $data = array_merge($params,$get_entry_list_result);
      // $fp = fopen('test.txt','a+');
      // fwrite($fp, json_encode($get_entry_list_result));
      // fclose($fp);
      ++$count;

    }echo "<pre>";

    $crm_result['result_count'] = $get_entry_list_result['next_offset'];
    $crm_result['next_offset'] = $get_entry_list_result['next_offset'];
print_r($crm_result);die;


//echo '<hr>Count------------------------>'.$count;
//die;
    // $get_entry_list_result = $client->call('get_entry_list', 
    //     fncReturnGetEntryListParametersArray($session_id,'Calls',999));
    
//print_r($get_entry_list_result); die(__FILE__);
    /*for displaying the result*/
    if ($get_entry_list_result === false) {
        var_dump($get_entry_list_result);   
    }else {
        // unset($get_entry_list_result['field_list']);
        
        
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
    function fncReturnGetEntryListParametersArray(
      $session_id,$moduleName,$maxResults,$offset) {
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
        return $get_entry_list_parameters;
    }
?>
