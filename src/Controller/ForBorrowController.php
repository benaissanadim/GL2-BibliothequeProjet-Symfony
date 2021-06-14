<?php

namespace App\Controller;

use App\Entity\ForBorrow;
use App\Entity\Produit;
use App\Form\ForBorrowType;
use App\Repository\ForBorrowRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/for/borrow",name="for/borrow_")
 */
class ForBorrowController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProduitRepository $productsRepository) : Response
    {

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Produit $product = null, SessionInterface $session) : Response
    {
        $borrow = $session->get("borrow", []);
        if($product){
            $id = $product->getId();
            if(!empty($borrow[$id])){
                $borrow[$id]++;
            }else{
                $borrow[$id] = 1;
            }
            $session->set("borrow", $borrow);
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
        $borrow = $session->get("borrow", []);
        if($product) {
            $id = $product->getId();
            if(!empty($borrow[$id])){
                if($borrow[$id] > 1){
                    $borrow[$id]--;
                }else{
                    unset($borrow[$id]);
                }
                $session->set("borrow", $borrow);
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
        $borrow = $session->get("borrow", []);
        $id = $product->getId();

        if(!empty($borrow[$id])){
            unset($borrow[$id]);
        }

        $session->set("borrow", $borrow);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session) : Response
    {
        $session->remove("borrow");

        return $this->redirectToRoute("cart_index");
    }

}
