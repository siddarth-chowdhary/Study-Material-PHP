Ex of rest API
---------------
API File : server.php
Calling API : client.php

The API has two functions: 
get_app_by_id() and get_app_list(). 

get_app_by_id() expects an additional parameter called id to return the app info 
get_app_list() returns a array of apps. 

The API requires an action parameter to determine which function to call. 

Requests made to this API utilize the GET HTTP verb and all responses are returned using JSON. 
In the real world, your API would most likely return data from a database.
 
