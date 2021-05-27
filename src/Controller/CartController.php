<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session)
    {
        $cart = $session->get("cart", []);

        $data = [];
        $total = 0;

        foreach($cart as $id => $quantity){
            $product = $id;
            if (isset($product)) {
                $data[] = [
                    "product" => $product,
                    "quantity" => $quantity
                ];
                $total += $product->getPrice() * $quantity;
            }
        }

        return $this->render('cart/index.html.twig', compact("data", "total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Products $product, SessionInterface $session)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(isset($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Products $product, SessionInterface $session)
    {
        // On récupère le cart actuel
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(isset($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Products $product, SessionInterface $session)
    {
        $cart = $session->get("cart", []);
        $id = $product->getId();

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("cart");

        return $this->redirectToRoute("cart_index");
    }

}