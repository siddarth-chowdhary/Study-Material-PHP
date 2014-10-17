<?php

namespace Alpha\AlphaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Alpha\AlphaBundle\Entity\User;
use Alpha\AlphaBundle\Form\UserType;

use Symfony\Component\HttpFoundation\Request;

use Alpha\AlphaBundle\Modals\Login;

class UserController extends Controller
{
    public function loginAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AlphaAlphaBundle:User');
        
//        echo '<pre>';
//        print_r($session);
//        die(__FILE__);
        
        
        if ($request->getMethod() == 'POST') {
            $session->clear();
            $username = $request->get('username');
            //$password = sha1($request->get('password'));
            $password = $request->get('password');
            //$remember = $request->get('remember');
            $user = $repository->findOneBy(array('username' => $username, 'password' => $password));
            if ($user) {
                $login = new Login();
                $login->setUsername($username);
                $login->setPassword($password);
                $session->set('login', $login);
                return $this->redirect($this->generateUrl('profile'));
            } else {
                //login failed
                $this->get('session')->getFlashBag()->add('login-failed', 'Invalid Username/Password!'); // correctly
                return $this->redirect($this->generateUrl('login'));
            }
        } else {
            //request is not post , might be the first or second request
            if ($session->has('login')) {
                //a user present in session
                $login = $session->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();
                $user = $repository->findOneBy(array('username' => $username, 'password' => $password));
                if ($user) {
                    return $this->redirect($this->generateUrl('profile'));
                }
            }
            //first time rendering
            return $this->render('AlphaAlphaBundle:User:login.html.twig');
        }

        return $this->render('AlphaAlphaBundle:User:login.html.twig', array(
                        // ...
        ));
    }

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

                $this->get('session')->getFlashBag()->add('user-saved', 'Your user was created successfully. Thank you!');

                return $this->redirect($this->generateUrl('signup'));
            }
        }

        return $this->render('AlphaAlphaBundle:User:signup.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
        ));
    }

    public function logoutAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        $session->clear();
        $this->get('session')->getFlashBag()->add('user-loggged-out', 'Logged Out Successfully!');
        return $this->redirect($this->generateUrl('login'));    
        
    }

}
