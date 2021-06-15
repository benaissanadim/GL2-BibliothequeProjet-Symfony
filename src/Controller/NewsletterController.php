<?php
namespace App\Controller;
use App\Entity\Newsletters\Newsletters;
use App\Form\NewslettersType;
use App\Repository\NewslettersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter", name="newsletterlist")
     */
    public function index(): Response
    {
        $newslettersRepository = $this->getDoctrine()->getRepository('App:Newsletters\Newsletters');
        return $this->render('newsletters/index.html.twig', [

            'newsletters' => $newslettersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newsletteradd", name="newsletteradd")
     */
    public function welcome(Request $request, SendMailService $mailer): Response
    {
        $usersrepository = $this->getDoctrine()->getRepository('App:Newsletters\Users');
        $users = $usersrepository->findBy([]);
        $newsletter = new Newsletters();
        $form = $this->createForm(NewslettersType::Class, $newsletter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $nb = 0 ;
             $newsletter = $form->getData();

            // On crée le message
            foreach ($users as $user) {
                if($user->getIsValid())
                 $nb++;
                 $context = ['newsletter' => $newsletter];
                 
                $mailer->send($newsletter['name'] , $user->getEmail(),nadim.ben.aissaa@gmail.com,
                'newsletter/newslettersend.html.twig', 'text/html', $context);
            };
            $newsletter->setNbofsent($nb);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $this->addFlash('message', 'Send With Success');
            return $this->redirectToRoute("newsletteradd");
        }


        return $this->render('newsletters/add.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }
}
