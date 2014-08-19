<?php

namespace Alpha\AlphaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Alpha\AlphaBundle\Entity\User;
use Alpha\AlphaBundle\Form\UserType;
class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render('AlphaAlphaBundle:User:login.html.twig', array(
                // ...
            ));    }

    public function signupAction() {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('user-saved', 'Your user was created successfully. Thank you!'); // correctly

                return $this->redirect($this->generateUrl('signup'));
            }
        }

        return $this->render('AlphaAlphaBundle:User:signup.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
        ));
    }

    public function logoutAction()
    {
        return $this->render('AlphaAlphaBundle:User:logout.html.twig', array(
                // ...
            ));    }

}
