<?php

class Bird extends Animal{

	public function __construct(){
		echo "<br/>"."Call to parent constructor.";
		parent::__construct(40,50,60);
		echo "<br/>"."Bird Class , Child Of Animal Class"."<br/>";
	}

	public function fly() {
		echo "<br/> from fly function <br/>";
	}
}

?>