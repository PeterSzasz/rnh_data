<?php

namespace App\Controller;

use App\Entity\Hunter;
use App\Form\HunterType;
use App\Repository\HunterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/hunter')]
class HunterController extends AbstractController
{
    #[Route('/', name: 'hunter_index', methods: ['GET'])]
    public function index(HunterRepository $hunterRepository): Response
    {
        return $this->render('hunter/index.html.twig', [
            'hunters' => $hunterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'hunter_new', methods: ['GET','POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $hunter = new Hunter();
        $form = $this->createForm(HunterType::class, $hunter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($hunter);
            $entityManager->flush();

            return $this->redirectToRoute('hunter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hunter/new.html.twig', [
            'hunter' => $hunter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hunter_show', methods: ['GET'])]
    public function show(Hunter $hunter): Response
    {
        return $this->render('hunter/show.html.twig', [
            'hunter' => $hunter,
        ]);
    }

    #[Route('/{id}/edit', name: 'hunter_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Hunter $hunter, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(HunterType::class, $hunter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('hunter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hunter/edit.html.twig', [
            'hunter' => $hunter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hunter_delete', methods: ['POST'])]
    public function delete(Request $request, Hunter $hunter, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hunter->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($hunter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hunter_index', [], Response::HTTP_SEE_OTHER);
    }
}
