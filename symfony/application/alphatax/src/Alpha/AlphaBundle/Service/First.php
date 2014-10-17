<?php

namespace Alpha\AlphaBundle\Service;
/**
 * Description of First
 *
 * @author siddarth
 * This is a service created for testing purpose
 */

class First {
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    //put your code here
    public function add($param1,$param2) {
//        echo '<pre>';var_dump($this->session);die("in class : ".__CLASS__." , line no : ".__LINE__);
        return $param1+$param2;
    }
}
