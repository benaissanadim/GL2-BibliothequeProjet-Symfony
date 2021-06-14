<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */

    public function login(Request $request, AuthenticationUtils $utils): \Symfony\Component\HttpFoundation\Response
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername ,

        ]);
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {

    }


}
