<?php



$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];        


$dbhost 	= "localhost";
$dbname		= "test";
$dbuser		= "root";
$dbpass		= "root";

// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

// query
$sql = "INSERT INTO user (name,email,password) VALUES (:name,:email,:password)";
$q = $conn->prepare($sql);
$q->execute(array(':name'=>$name,
                  ':email'=>$email,
                  ':password'=>$password
    ));

$result = array("msg"=>"Form Data Saved successfully");
$json_encoded = utf8_encode(json_encode($result));
echo $json_encoded;
