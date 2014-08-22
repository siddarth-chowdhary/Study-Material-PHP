<?php

namespace Alpha\AlphaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends Controller
{
    public function profileAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        //if logged in then only see this page
        if ($session->has('login')) {
                //a user present in session
                $login = $session->get('login');
                $username = $login->getUsername();
                //$password = $login->getPassword();
                //$user = $repository->findOneBy(array('username' => $username, 'password' => $password));
                if ($username) {
                    //return $this->redirect($this->generateUrl('profile'));
                    return $this->render('AlphaAlphaBundle:Shop:profile.html.twig', array(
                        // ...
                    ));
                } else {
                    $this->get('session')->getFlashBag()->add('login-required', 'Login Required!'); // correctly
                    return $this->redirect($this->generateUrl('login'));
                }
                
        } else {
            //else login required
            $this->get('session')->getFlashBag()->add('login-required', 'Login Required!'); // correctly
            return $this->redirect($this->generateUrl('login'));
        }
    }

}
