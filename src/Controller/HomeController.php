<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Rating;
use App\Entity\Comments;
use App\Entity\Produit;
use App\Form\CommentsType;
use App\Form\ProduitType;
use App\Form\Rating1Type;
use App\Form\CantactMailType;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class HomeController extends AbstractController
{
    /**
     * @Route("" , name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/home", name="home")
     */
    public function welcome(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/shopgrid/{page<\d+>?1}/{number<\d+>?5}/{sort<\d+>?1}", name="shopgrid")
     */
    public function shopgrid($number , $page ,$sort ): Response
    {

        $repository = $this->getDoctrine()->getRepository('App:Produit');
        $repositoryCategory = $this->getDoctrine()->getRepository('App:Category');
        $Categories = $repositoryCategory->findBy([]);
        $nbProduits = $repository->count(array());
        $nbPage = ($nbProduits % $number) ? ($nbProduits / $number)+1 : ($nbProduits / $number);
        if($sort==1){
            $produits = $repository->findBy([], ['price'=> 'asc'],$number, ($page - 1) * $number);}
        if($sort==2){
            $produits = $repository->findBy([], ['price'=> 'desc'],$number, ($page - 1) * $number);}
        if($sort==3){
            $produits = $repository->findBy([], ['name'=> 'asc'],$number, ($page - 1) * $number);}
        return $this->render('home/shopgrid.html.twig',
            [
                'produits' => $produits,
                'nbPage' =>$nbPage,
                'page' =>$page,
                'sort' =>$sort,
                'Categories' =>$Categories
            ]);
    }


    #[Route('details/{id}', name: 'details', methods: ['GET', 'POST'])]
    public function details(Produit $produit, Request $request, SendMailService $mail): Response
    {
        $formmail = $this->createForm(CantactMailType::class);

        $contact = $formmail->handleRequest($request);

        if($formmail->isSubmitted() && $formmail->isValid()) {
            $context = [
                'produit' => $produit,
                'yourmail' => $contact->get('yours')->getData(),
                'destmail' => $contact->get('destination')->getData(),
                'message' => $contact->get('message')->getData()
            ];

            $mail->send($contact->get('yours')->getData(), $contact->get('destination')->getData(), "home/cantact.html.twig", $context);
        }
            // On confirme et on redirige
            $this->addFlash('message', 'Votre e-mail a bien été envoyé');

        $repositoryCategory = $this->getDoctrine()->getRepository('App:Category');
        $Categories = $repositoryCategory->findBy([]);
        // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments;
        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduit($produit);
            // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();
            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();
            if ($parentid != null) {
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }
            // On définit le parent
            $comment->setParent($parent ?? null);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('details', ['id' => $produit->getId()]);
        }


        return $this->render('home/details.html.twig', [
            'produit' => $produit,
            'commentForm' => $commentForm->createView(),
            'formmail' => $formmail->createView(),
            'Categories' =>$Categories,
        ]);
    }


        /**
 * @Route("/shopadd/{id?0}", name="edit")
 */
public function editProduit(Request $request, Produit $produit = null, EntityManagerInterface $manager) {
    if (!$produit) {
        $produit=  new Produit();
    }
    $form = $this->createForm(ProduitType::class, $produit);
    $form->remove('path');
    $form->remove('path2');

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        if($form['image'] && $form['image2']) {
            $image = $form['image']->getData();
            $imagePath = md5(uniqid()).$image->getClientOriginalName();
            $destination = __DIR__.'/../../public/assets/uploads';
            $image2 = $form['image2']->getData();
            $imagePath2 = md5(uniqid()).$image->getClientOriginalName();
            $destination2 = __DIR__.'/../../public/assets/uploads';

            try {
                $image->move($destination2,$imagePath);
                $image2->move($destination,$imagePath2);

                $produit->setPath('assets/uploads/'.$imagePath);
                $produit->setPath2('assets/uploads/'.$imagePath2);

            } catch (FileException $fe) {
                echo $fe;
            }
        }
        $manager->persist($produit);
        $manager->flush();
        return $this->redirectToRoute('shopgrid');

    }
    return $this->render('home/edit.html.twig', array(
        'form' => $form->createView()
    ));
}

}
