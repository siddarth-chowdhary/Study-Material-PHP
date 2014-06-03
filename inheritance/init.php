<?php
ini_set("display_errors",1);

function __autoload($class_name) {
    include $class_name . '.class.php';
}



$animal_obj_1	=	new Animal(10,20,30);
$bird_obj_1		=	new Bird();
$mammal_obj_1	=	new Mammal();
$repltile_obj_1	=	new Reptile();


// $animal_obj_1->sleep();
// $bird_obj_1->sleep(); //sleep function of animal class called from bird class's object

// $bird_obj_1->fly();


// $animal_obj_1->getMembers();

// echo $animal_obj_1->_animalPrivate;   //gives error
// echo $animal_obj_1->animalProtected;
// echo $animal_obj_1->animalPublic;



?>