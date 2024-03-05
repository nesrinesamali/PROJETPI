<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('acceuil/home.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    #[Route('/medecin', name: 'app_medecin')]
    public function medecin(): Response
    {
        return $this->render('acceuil/medecin.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/fr', name: 'fr')]
    public function front(): Response
    {
        return $this->render('dashboard/front.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
