<?php

namespace App\Controller;

use App\Entity\CentreDon;
use App\Form\CentreDonType;
use App\Repository\CentreDonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/centre/don')]
class CentreDonController extends AbstractController
{
    #[Route('/', name: 'app_centre_don_index', methods: ['GET'])]
    public function index(CentreDonRepository $centreDonRepository): Response
    {
        return $this->render('centre_don/index.html.twig', [
            'centre_dons' => $centreDonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_centre_don_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centreDon = new CentreDon();
        $form = $this->createForm(CentreDonType::class, $centreDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         
            $content = $centreDon->getNomCentre();
            $cleanedContenu = \ConsoleTVs\Profanity\Builder::blocker($content)->filter();
            $centreDon->setNomCentre($cleanedContenu);
            $entityManager->persist($centreDon);
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre_don/new.html.twig', [
            'centre_don' => $centreDon,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_centre_don_show', methods: ['GET'])]
    public function show(CentreDon $centreDon): Response
    {
        return $this->render('centre_don/show.html.twig', [
            'centre_don' => $centreDon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_centre_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CentreDon $centreDon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentreDonType::class, $centreDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre_don/edit.html.twig', [
            'centre_don' => $centreDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centre_don_delete', methods: ['POST'])]
    public function delete(Request $request, CentreDon $centreDon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centreDon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($centreDon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_centre_don_index', [], Response::HTTP_SEE_OTHER);
    }
}
