<?php

namespace Beta\BetaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BetaBetaBundle:Default:index.html.twig', array('name' => $name));
    }
}
