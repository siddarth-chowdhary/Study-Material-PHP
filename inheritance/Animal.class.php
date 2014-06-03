<?php

class Animal {

	private $_animalPrivate;
	protected $animalProtected;
	public $animalPublic;

	public function __construct($one,$two,$three){
		echo "<br/>"."Animal Class."."<br/>";
		$this->_animalPrivate 	= $one;
		$this->_animalProtected = $two;
		$this->_animalPublic 	= $three;
	}

	/*
	* @  desc This can also be used but has lower priority
	*/
	public function Animal() {
		echo "<br/>animal function.";
	}

	public function sleep() {
		echo "<br/>From Animal sleep function.<br/>";
	}

	public function getMembers() {
		// echo "<br/>private 		: ".self::_animalPrivate; //fatal error
		echo "<br/>private 		: ".$this->_animalPrivate;
		echo "<br/>protected 	: ".$this->_animalProtected;
		echo "<br/>public 		: ".$this->_animalPublic;
	}

	function __destruct(){
	   echo "<br/>from desctructor animal class.".get_class($this)."<br/>"; 
	}
}

?>