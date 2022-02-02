<?php

namespace App\Controller;

use App\Entity\Rabbit;
use App\Form\RabbitType;
use App\Repository\RabbitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/rabbit')]
class RabbitController extends AbstractController
{
    #[Route('/', name: 'rabbit_index', methods: ['GET'])]
    public function index(RabbitRepository $rabbitRepository): Response
    {
        return $this->render('rabbit/index.html.twig', [
            'rabbits' => $rabbitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'rabbit_new', methods: ['GET','POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $rabbit = new Rabbit();
        $form = $this->createForm(RabbitType::class, $rabbit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($rabbit);
            $entityManager->flush();

            return $this->redirectToRoute('rabbit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rabbit/new.html.twig', [
            'rabbit' => $rabbit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rabbit_show', methods: ['GET'])]
    public function show(Rabbit $rabbit): Response
    {
        return $this->render('rabbit/show.html.twig', [
            'rabbit' => $rabbit,
        ]);
    }

    #[Route('/{id}/edit', name: 'rabbit_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Rabbit $rabbit): Response
    {
        $form = $this->createForm(RabbitType::class, $rabbit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rabbit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rabbit/edit.html.twig', [
            'rabbit' => $rabbit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rabbit_delete', methods: ['POST'])]
    public function delete(Request $request, Rabbit $rabbit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rabbit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rabbit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rabbit_index', [], Response::HTTP_SEE_OTHER);
    }
}
