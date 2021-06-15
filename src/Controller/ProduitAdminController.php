<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\Produit1Type;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("produit")
 */
class ProduitAdminController extends AbstractController
{
    /**
     * @Route("/new/{id?0}", name="produitnew")
     */
    public function new(Request $request, Produit $produit = null, EntityManagerInterface $manager): Response
    {
        if (!$produit) {
            $produit=  new Produit();}

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
            $this->addFlash('succes', "Added successfully");

            return $this->redirectToRoute("shopgrid");

        }
        return $this->render('ProduitAdmin/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id?0}", name="produitdelete")
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        return $this->redirectToRoute("shopgrid");
    }
}