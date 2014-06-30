<?php
require_once 'Mandrill.php'; //Not required with Composer
ini_set('max_execution_time', 0);

try {
    $mandrill = new Mandrill('guc0tRd_RLh6LkfNESYbPQ');
    $result = $mandrill->users->info();
    print_r($result);
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
    throw $e;
}
?>






