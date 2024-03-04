<?php

namespace App\Controller;

use App\Entity\CentreDon;
use App\Form\CentreDon1Type;
use App\Repository\CentreDonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/centre/don/back')]
class CentreDonBackController extends AbstractController
{
    #[Route('/', name: 'app_centre_don_back_index', methods: ['GET'])]
    public function index(CentreDonRepository $centreDonRepository): Response
    {
        return $this->render('centre_don_back/index.html.twig', [
            'centre_dons' => $centreDonRepository->findAll(),
        ]);
    }
    #[Route('/centre-don/search', name: 'centre_don_search')]
    public function search(Request $request, CentreDonRepository $centreDonRepository): Response
    {
        $searchTerm = $request->query->get('q');

        if (empty($searchTerm)) {
            return $this->redirectToRoute('app_centre_don_back_index');
        }

        $centreDons = $centreDonRepository->findSearch($searchTerm);

        return $this->render('centre_don_back/index.html.twig', [
            'centre_dons' => $centreDons,
        ]);
    }

    #[Route('/new', name: 'app_centre_don_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centreDon = new CentreDon();
        $form = $this->createForm(CentreDon1Type::class, $centreDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($centreDon);
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_don_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre_don_back/new.html.twig', [
            'centre_don' => $centreDon,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_centre_don_back_show', methods: ['GET'])]
    public function show(CentreDon $centreDon): Response
    {
        return $this->render('centre_don_back/show.html.twig', [
            'centre_don' => $centreDon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_centre_don_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CentreDon $centreDon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentreDon1Type::class, $centreDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_don_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre_don_back/edit.html.twig', [
            'centre_don' => $centreDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centre_don_back_delete', methods: ['POST'])]
    public function delete(Request $request, CentreDon $centreDon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centreDon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($centreDon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_centre_don_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
