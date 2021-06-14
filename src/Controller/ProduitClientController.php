<?php

namespace App\Controller;

use App\Entity\Newsletters\Newsletters;
use App\Entity\Newsletters\Users;
use App\Entity\Comments;
use App\Entity\Produit;
use App\Filter\FindByFilter;
use App\Form\CommentsType;
use App\Form\FilterFormType;
use App\Form\NewslettersUsersType;

use App\Form\CantactMailType;
use App\Form\SearchShopType;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProduitClientController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, SendMailService $mailer ): Response
    {
        //on veut  ajouter des subscribers aux newsletters
        $user = new Users();
        $usersRepository = $this->getDoctrine()->getRepository('App:Newsletters\Users');
        $NewsletterForm = $this->createForm(NewslettersUsersType::Class,$user);
        $NewsletterForm->handleRequest($request);
        if($NewsletterForm->isSubmitted() && $NewsletterForm->isValid() ){
            $email = $NewsletterForm->get("email")->getData();
            if($usersRepository->findOneBy(['email'=> $email]) == null)
            {
            $token =hash('sha256',uniqid());
            $user->setValidationToken($token);
            $em = $this ->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
                $context = [
                    'user' => $user,
                    'token' => $token,
                ];
                $mailer->send('Subscribe to newsletters', $user->getEmail(), 'nadim.ben.aissaa@gmail.com',
                'newsletters/validationsubscription.twig', 'text/html', $context);
                $this->addFlash('succes', "Success Verify your email to validate subscriptions");
            }}

        //on veut ajouter la liste des produits nouveaux
        $repository = $this->getDoctrine()->getRepository('App:Produit');
        $produitsforsale = $repository->findBy(['ForSale'=>1], ['createdAt'=> 'asc']);
        $produitsforBorrow = $repository->findBy(['forBorrow'=>1], ['createdAt'=> 'asc']);

        return $this->render('ProduitClient/index.html.twig',
            [
                'produitsforsale' => $produitsforsale,
                'produitsforBorrow' => $produitsforBorrow,
                'NewsletterFform' => $NewsletterForm->createView(),
            ]);
    }

    /**
     * @Route("/confirm/{id}/{token}", name="confirm")
     */

    //confirmation du user pour s'inscrire au newsletter
    public function confirm(Request $request, Users $user, $token):Response
    {
        if($user->getValidationToken() != $token) {
            throw $this->createNotFoundException('Page not found');
        }

        $user->setIsValid(true);
        $em = $this ->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $request->getSession()->getFlashBag()->add('succes', 'Success Subscription you will ereceive our news in mail');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/shopgrid/{typebook?all}/{page<\d+>?1}/{sort?price}/{filter?asc}/{actualcategory?all}", name="shopgrid")
     */
    public function shopgrid($typebook, $page ,$sort,$filter,  $actualcategory, Request $request ): Response
    {
        //on cherche les produits
        $repositoryProduits = $this->getDoctrine()->getRepository('App:Produit');
        if ($typebook != "all"){
        $nbProduits = $repositoryProduits->count([$typebook=>1]);
        $produits = $repositoryProduits->findBy([$typebook=>1], [$sort=> $filter],6, ($page-1)*6);
        }
        else{
            $nbProduits = $repositoryProduits->count([]);
            $produits = $repositoryProduits->findBy([], [$sort=> $filter], 6, ($page-1)*6);
        }

        //on cherche les categories
        $repositoryCategory = $this->getDoctrine()->getRepository('App:Category');
        $Categories = $repositoryCategory->findAll();

        //nb de pages
        $nbPage = ($nbProduits % 6) ? ($nbProduits / 6)+1 : ($nbProduits / 6);

        //recherche produits
        $SearchForm = $this->createForm(SearchShopType::class);
        $search = $SearchForm->handleRequest($request);
        if($SearchForm->isSubmitted() && $SearchForm->isValid()){
            // On recherche les annonces correspondant aux mots clés
            $produits = $repositoryProduits->search(
                $search->get('mots')->getData()
            );
        }
            return $this->render('ProduitClient/shopgrid.html.twig',
            [
                'produits' => $produits,
                'nbPage' =>$nbPage,
                'page' =>$page,
                'sort' =>$sort,
                'filter' =>$filter,
                'Categories' =>$Categories,
                'SearchForm' => $SearchForm->createView(),
                'actualcategory' => $actualcategory,
                'typebook' => $typebook
            ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */

    public function details(Produit $produit, Request $request, SendMailService $mailer): Response
    {

        //
        $repositoryCategory = $this->getDoctrine()->getRepository('App:Category');
        $Categories = $repositoryCategory->findBy([]);

        //Partie Commentaire
        $repositoryComments = $this->getDoctrine()->getRepository('App:Comments');
        $Comments = $repositoryComments->findAll();
        $nbComments = $repositoryComments->Count(['produit' => $produit]);

        $nbStars = array();
        for( $i=1 ; $i<6; $i++){
            $nbStars[$i]= $repositoryComments->count(
                ['produit' => $produit, 'nbStars' => $i ]
            );
        };
        $rating=0 ;
        for( $i=1 ; $i<6; $i++){
            $rating += $nbStars[$i]*$i ;
        };
        if(array_sum($nbStars) != 0)
            $rating /= array_sum($nbStars);
        else {$rating = 0;}


        // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments;
        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);
        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduit($produit);
            //on ajoute le nb stars
            $stars = $commentForm->get("stars")->getData();
            $comment-> setNbStars($stars);
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
            $this->addFlash('succes', 'You comment is added');
            return $this->redirectToRoute('details', ['id' => $produit->getId()]);
        }

        return $this->render('ProduitClient/details.html.twig', [
            'produit' => $produit,
            'commentForm' => $commentForm->createView(),
            'Categories' =>$Categories,
            'nbStars' => $nbStars ,
            'Comments' =>$Comments,
            'nbrating' =>array_sum($nbStars),
            'rating' => $rating ,
            'nbComments' => $nbComments

        ]);
    }

}
