<?php

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Login\LoginBundle\Entity\Users;
use Login\LoginBundle\Modals\Login;

class DefaultController extends Controller {

//    public function indexAction(Request $request) {
//        //for sessions
//        $session = $this->getRequest()->getSession();
//        $em = $this->getDoctrine()->getEntityManager();
//        $repository = $em->getRepository('LoginLoginBundle:Users');
//        if ($request->getMethod() == 'POST') {
//            //after user has clicked login button
//            $session->clear();
//            $username = $request->get('username');
//            $password = sha1($request->get('password'));
//            $remember = $request->get('remember');
//            $user = $repository->findOneBy(array('userName' => $username, 'password' => $password));
//            if ($user) {
//                //if user exists in db
//                //2 cases here 1.remeber me 2. without remember me
//                if ($remember == 'remember-me') {
//                    //user is logged in , create a model and store the values in that model
//                    $login = new Login();
//                    $login->setUsername($username);
//                    $login->setPassword($password);
//                    $session->set('login', $login);
//                }
//                //show the user welcome page as user is authentic
//                return $this->render('LoginLoginBundle:Default:welcome.html.twig', array('name' => $user->getFirstName()));
//            } else {
//                //login failed
//                return $this->render('LoginLoginBundle:Default:login.html.twig', array('name' => 'Login Error'));
//            }
//        } else {
//            //request is not post , might be the first or second request
//            if ($session->has('login')) {
//                //a user present in session
//                $login = $session->get('login');
//                $username = $login->getUsername();
//                $password = $login->getPassword();
//                $user = $repository->findOneBy(array('userName' => $username, 'password' => $password));
//                if ($user) {
//                    //if user is authentic
//                    return $this->render('LoginLoginBundle:Default:welcome.html.twig', array('name' => $user->getFirstName()));
//                }
//            }
//            //first time rendering
//            return $this->render('LoginLoginBundle:Default:login.html.twig');
//        }
//    }
    
    public function indexAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('LoginLoginBundle:Users');
        if ($request->getMethod() == 'POST') {
            $session->clear();
            $username = $request->get('username');
            $password = sha1($request->get('password'));
            $remember = $request->get('remember');
            $user = $repository->findOneBy(array('userName' => $username, 'password' => $password));
            if ($user) {
                if ($remember == 'remember-me') {
                    $login = new Login();
                    $login->setUsername($username);
                    $login->setPassword($password);
                    $session->set('login', $login);
                }
                return $this->render('LoginLoginBundle:Default:welcome.html.twig', array('name' => $user->getFirstName()));
            } else {
                return $this->render('LoginLoginBundle:Default:login.html.twig', array('name' => 'Login Error'));
            }
        } else {
            if ($session->has('login')) {
                $login = $session->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();
                $user = $repository->findOneBy(array('userName' => $username, 'password' => $password));
                if ($user) {
                    $page = $request->get('page');
                    $count_per_page = 50;
                    $total_count = $this->getTotalCountries();
                    $total_pages=ceil($total_count/$count_per_page);

                    if(!is_numeric($page)){
                        $page=1;
                    }
                    else{
                        $page=floor($page);
                    }
                    if($total_count<=$count_per_page){
                        $page=1;
                    }
                    if(($page*$count_per_page)>$total_count){
                        $page=$total_pages;
                    }
                    $offset=0;
                    if($page>1){
                        $offset = $count_per_page * ($page-1);
                    }
                     $em = $this->getDoctrine()->getEntityManager();
                    $ctryQuery = $em->createQueryBuilder()
                            ->select('c')
                            ->from('LoginLoginBundle:Country', 'c')
                            ->setFirstResult($offset)
                            ->setMaxResults($count_per_page);
                    $ctryFinalQuery = $ctryQuery->getQuery();

                    $countries = $ctryFinalQuery->getArrayResult();
                    return $this->render('LoginLoginBundle:Default:welcome.html.twig', array('name' => $user->getFirstName(),'countries'=>$countries,'total_pages'=>$total_pages,'current_page'=> $page));
                }
            }
            return $this->render('LoginLoginBundle:Default:login.html.twig');
        }
    }

    public function getTotalCountries() {
        $em = $this->getDoctrine()->getEntityManager();
        $countQuery = $em->createQueryBuilder()
                ->select('Count(c)')
                ->from('LoginLoginBundle:Country', 'c');
        $finalQuery = $countQuery->getQuery();
        $total = $finalQuery->getSingleScalarResult();
        return $total;
    }

    public function signupAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $username = $request->get('username');
            $firstname = $request->get('firstname');
            $password = $request->get('password');

            $user = new Users();
            $user->setFirstName($firstname);
            $user->setPassword(sha1($password));
            $user->setUserName($username);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('LoginLoginBundle:Default:signup.html.twig');
    }

    public function logoutAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->render('LoginLoginBundle:Default:login.html.twig');
    }

}
