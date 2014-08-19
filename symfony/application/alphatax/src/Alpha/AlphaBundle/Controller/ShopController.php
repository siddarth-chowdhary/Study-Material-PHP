<?php

namespace Alpha\AlphaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
    public function profileAction()
    {
        return $this->render('AlphaAlphaBundle:Shop:profile.html.twig', array(
                // ...
            ));    }

}
