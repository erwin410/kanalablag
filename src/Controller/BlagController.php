<?php

namespace App\Controller;

use App\Entity\Blag;
use App\Form\BlagType;
use App\Repository\BlagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blag')]
class BlagController extends AbstractController
{
    #[Route('/blag', name: 'app_blag_index', methods: ['GET'])]
    public function index(BlagRepository $blagRepository): Response
    {
        return $this->render('blag/index.html.twig', [
            'blags' => $blagRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_blag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blag = new Blag();
        $form = $this->createForm(BlagType::class, $blag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blag);
            $entityManager->flush();

            return $this->redirectToRoute('app_blag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blag/new.html.twig', [
            'blag' => $blag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blag_show', methods: ['GET'])]
    public function show(Blag $blag): Response
    {
        return $this->render('blag/show.html.twig', [
            'blag' => $blag,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blag $blag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlagType::class, $blag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blag/edit.html.twig', [
            'blag' => $blag,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blag_delete', methods: ['POST'])]
    public function delete(Request $request, Blag $blag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blag->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blag_index', [], Response::HTTP_SEE_OTHER);
    }
}
