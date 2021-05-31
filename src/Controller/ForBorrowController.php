<?php

namespace App\Controller;

use App\Entity\ForBorrow;
use App\Form\ForBorrowType;
use App\Repository\ForBorrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/for/borrow')]
class ForBorrowController extends AbstractController
{
    #[Route('/', name: 'for_borrow_index', methods: ['GET'])]
    public function index(ForBorrowRepository $forBorrowRepository): Response
    {
        return $this->render('for_borrow/index.html.twig', [
            'for_borrows' => $forBorrowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'for_borrow_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $forBorrow = new ForBorrow();
        $form = $this->createForm(ForBorrowType::class, $forBorrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forBorrow);
            $entityManager->flush();

            return $this->redirectToRoute('for_borrow_index');
        }

        return $this->render('for_borrow/new.html.twig', [
            'for_borrow' => $forBorrow,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'for_borrow_show', methods: ['GET'])]
    public function show(ForBorrow $forBorrow): Response
    {
        return $this->render('for_borrow/show.html.twig', [
            'for_borrow' => $forBorrow,
        ]);
    }

    #[Route('/{id}/edit', name: 'for_borrow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ForBorrow $forBorrow): Response
    {
        $form = $this->createForm(ForBorrowType::class, $forBorrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('for_borrow_index');
        }

        return $this->render('for_borrow/edit.html.twig', [
            'for_borrow' => $forBorrow,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'for_borrow_delete', methods: ['POST'])]
    public function delete(Request $request, ForBorrow $forBorrow): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forBorrow->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($forBorrow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('for_borrow_index');
    }
}
