<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProduitRepository $productsRepository) : Response
    {
        $panier = $session->get("panier", []);

        $data = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);
            $data[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }
        $borrow = $session->get("borrow", []);

        $data_borrow = [];
        $totalborrow = 0;

        foreach($borrow as $id => $quantite){
            $product = $productsRepository->find($id);
            $data_borrow[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $totalborrow += $product->getPrice() * $quantite;
        }
        return $this->render('cart/index.html.twig', compact("data","data_borrow", "total","totalborrow",));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Produit $product = null, SessionInterface $session) : Response
    {
        $panier = $session->get("panier", []);
        if($product){
            $id = $product->getId();
            if(!empty($panier[$id])){
                $panier[$id]++;
            }else{
                $panier[$id] = 1;
            }
            $session->set("panier", $panier);
        }
        else {
            $this->addFlash('danger',"The element you wish to add does not exist.");
        }
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Produit $product = null, SessionInterface $session) : Response
    {
        $panier = $session->get("panier", []);
        if($product) {
            $id = $product->getId();
            if(!empty($panier[$id])){
                if($panier[$id] > 1){
                    $panier[$id]--;
                }else{
                    unset($panier[$id]);
                }
                $session->set("panier", $panier);
            }
            else{
                $this->addFlash('error',"The element you wish to remove does not exist.");
            }
        }
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Produit $product, SessionInterface $session) : Response
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session) : Response
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

}