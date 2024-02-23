<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Entity\Reponse;
use App\Form\Rendezvous1Type;
use App\Form\Reponse1Type;
use App\Repository\RendezvousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendezvous/back')]
class RendezvousBackController extends AbstractController
{
    #[Route('/', name: 'app_rendezvous_back_index', methods: ['GET'])]
    public function index(RendezvousRepository $rendezvousRepository): Response
    {
        return $this->render('rendezvous_back/index.html.twig', [
            'rendezvouses' => $rendezvousRepository->findAll(),
        ]);
    }

    #[Route('/{id}/repondre', name: 'app_rendezvous_back_repondre', methods: ['GET', 'POST'])]
public function repondre(Request $request, Rendezvous $rendezvous, EntityManagerInterface $entityManager): Response
{
    $reponse = new Reponse();

    $form = $this->createForm(Reponse1Type::class, $reponse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Associer la réponse à la réclamation
        $rendezvous->setReponse($reponse);

        // Changer l'état de la réclamation à "traité"
        $rendezvous->setEtat(true);

        $entityManager->persist($reponse);
        $entityManager->flush();

        return $this->redirectToRoute('app_rendezvous_back_index', ['id' => $rendezvous->getId()]);
    }

    return $this->renderForm('reponse_back/new.html.twig', [
        'reponse' => $reponse,
        'form' => $form,
    ]);
}
#[Route('/{id}/show_response', name: 'app_rendezvous_back_show_response', methods: ['GET'])]
    public function showResponse(Rendezvous $rendezvous): Response
    {
        // Vous devez récupérer la réponse associée à cette réclamation
        $reponse = $rendezvous->getReponse();

        // Vous devez créer le template Twig pour afficher la réponse
        return $this->render('reponse_back/show.html.twig', [
            'rendezvous' => $rendezvous,
            'reponse' => $reponse,
        ]);
    }
    

    #[Route('/new', name: 'app_rendezvous_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(Rendezvous1Type::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rendezvou);
            $entityManager->flush();

            return $this->redirectToRoute('app_rendezvous_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous_back/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_back_show', methods: ['GET'])]
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous_back/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rendezvous_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rendezvous $rendezvou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Rendezvous1Type::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendezvous_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous_back/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_back_delete', methods: ['POST'])]
    public function delete(Request $request, Rendezvous $rendezvou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rendezvous_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
