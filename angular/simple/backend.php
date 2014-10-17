<?php
ini_set('display_errors', '1');
include "f-pdo/FluentPDO/FluentPDO.php";
/*connect to the database*/
$pdo = new PDO("mysql:dbname=angular_test", "root", "root");
$fpdo = new FluentPDO($pdo);

$function = isset($_REQUEST['function']) ? $_REQUEST['function'] : '';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$countryId = '';
$countryName = '';
$countryPopulation = '';

if (isset($request) && is_object($request) && $function=="save" ) {
	$countryName = $request->data->name;
	$countryPopulation = $request->data->population;
}

if (isset($request) && is_object($request) && $function=="delete" ) {
	$countryId = $request->id;
}

if (isset($request) && is_object($request) && $function=="edit" ) {
	$countryId = $request->data->id;
	$countryName = $request->data->name;
	$countryPopulation = $request->data->population;
}

$result = array();


switch ($function) {
	case "select_all":
	    $query = $fpdo->from('countries');
		$result['response'] = $query->fetchAll();
	    break;
	
	case "save":
		$query = $fpdo->insertInto('countries',
			array(
				'name' => $countryName,
				'population' => $countryPopulation
			));
		$lastInsert = $query->execute();
		$result['response'] = $lastInsert;
	    break;

	case "edit":
		$query = $fpdo->update('countries')->set(array('name' => $countryName, 'population' => $countryPopulation))->where('id', $countryId);
		$response = $query->execute();
		$result['response'] = $response;
	    break;

	case "delete":
		$resultDelete = $fpdo->deleteFrom('countries')->where('id', $countryId)->execute();
		// $result['response'] = $resultDelete;
		if ($resultDelete) {
			$result['response'] = $resultDelete;
		} else {
			$result['response'] = "error";
		}
	    break;	    

  	default:
    	echo "Please provide a case! Error !!";
}


echo json_encode($result);
