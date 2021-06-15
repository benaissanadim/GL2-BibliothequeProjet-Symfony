<?php

namespace App\Controller;

use App\Form\CantactMailType;
use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CantactController extends AbstractController
{
    /**
     * @Route("/cantactmail", name="cantactmail")
     */

    public function cantact(Request $request , SendMailService $mailer ): Response
    {
        $MailForm = $this->createForm(CantactMailType::class);
        $MailForm->handleRequest($request);
        $contact = $MailForm->getData();
        if ($MailForm->isSubmitted() && $MailForm->isValid()) {

            $contact = $MailForm->getData();
            $context = ['contact' => $contact];

            $mailer->send($contact['Subject'] , 'nadim.ben.aissaa@gmail.com',$contact['email'],
                'Cantact/cantact.twig', 'text/html', $context);
            $this->addFlash('succes', 'Your mail is deliverd thanks');
        }
        return $this->render('Cantact/index.html.twig', [
            'formmail' => $MailForm->createView(),
        ]);
    }


    }