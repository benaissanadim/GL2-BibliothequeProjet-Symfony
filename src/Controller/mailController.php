<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;



class mailController extends AbstractController
{

    /**
     *
     * @Route("/mail/{emailUser}", name= "mail")
     *
     * */


    public function index( $emailUser)
    {
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com' ,465 , 'ssl' ))
            ->setUsername("biblio.bouarada@gmail.com")
            ->setPassword("Mohamed123Mohamed") ;

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Welcome to our biblio'))
            ->setFrom("biblio.bouarada@gmail.com")
            ->addTo($emailUser)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'mail/EmailVerif.html.twig'

                ),
                'text/html'
            );


       $mailer->send($message)  ;

        return $this->redirect($this->generateUrl('app_login'));
    }


}