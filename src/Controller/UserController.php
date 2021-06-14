<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     *
     * @Route("/user", name="user")
     */
    public function index(UserPasswordEncoderInterface $passwordEncoder , Request $request): Response
    {
       $user = new User();
       $form = $this->createForm(UserType::class, $user);
       $form->handleRequest($request) ;
       if($form->isSubmitted() && $form->isValid()) {
           $password = $passwordEncoder->encodePassword($user , $user->getPlainPassword());
           $user->setPassword($password) ;

           $em = $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
           return
               $this->redirectToRoute('mail' , array(
                   'emailUser' => $user->getEmail(),
               ));






       }


       return $this->render("loginInscription/inscription.html.twig",[
           "form" => $form->createView(),

       ]);

    }

    /**
     * @Route("signUpSuccess/{name}" , name = "signUpSuccess")
     */


    public function goToLogin($name) {
        return
        $this->redirectToRoute("app_login") ;
    }
}
