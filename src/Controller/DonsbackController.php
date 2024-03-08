<?php

namespace App\Controller;
use Psr\Log\LoggerInterface;

use App\Entity\Dons;
use App\Entity\User;
use App\Form\Dons1Type;
use App\Repository\DonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/donsback')]
class DonsbackController extends AbstractController
{
    #[Route('/', name: 'app_donsback_index', methods: ['GET'])]
    public function index(DonsRepository $donsRepository ,Request $request): Response
    {
        $offset = $request->query->get('offset', 0);
    $limit = 6;


        $dons = $donsRepository->findBy([], null, $limit, $offset);
        $totalDons = count($dons);
    $hasMore = $totalDons > ($offset + $limit);
        return $this->render('donsback/index.html.twig', [
            'dons' => $dons,
            'hasMore' => $hasMore,
        ]);
    }

    #[Route('/new', name: 'app_donsback_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {   
        $don = new Dons();
        $form = $this->createForm(Dons1Type::class, $don);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the current user
            $user = $this->getUser();
    
            // Ensure the user is logged in
            if ($user instanceof User) {
                $userID = $user->getId();
                
                // Set the user ID on the donation
                $don->setId($userID);
                $logger->info('User ID: ' . $userID);
                $entityManager->persist($don);
                $entityManager->flush();
        
                return $this->redirectToRoute('app_donsback_index', [], Response::HTTP_SEE_OTHER);
            } 
        }
    
        return $this->renderForm('donsback/new.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }
    #[Route('/jeux', name: 'app_donsback_jeux', methods: ['GET', 'POST'])]
    public function jeux(Request $request, EntityManagerInterface $entityManager): Response
    {
        $don = new Dons();
        $form = $this->createForm(Dons1Type::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($don);
            $entityManager->flush();

            return $this->redirectToRoute('app_donsback_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('donsback/jeux.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }
    #[Route('/about', name: 'app_donsback_about', methods: ['GET', 'POST'])]
    public function about(Request $request, EntityManagerInterface $entityManager): Response
    {
        $don = new Dons();
        $form = $this->createForm(Dons1Type::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($don);
            $entityManager->flush();

            return $this->redirectToRoute('app_donsback_about', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('donsback/about.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_donsback_show', methods: ['GET'])]
    public function show(Dons $don): Response
    {
        return $this->render('donsback/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_donsback_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Dons1Type::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_donsback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donsback/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donsback_delete', methods: ['POST'])]
    public function delete(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
            $entityManager->remove($don);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donsback_index', [], Response::HTTP_SEE_OTHER);
    }
}
