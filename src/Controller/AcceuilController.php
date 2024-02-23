<?php

namespace App\Controller;

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

    #[Route('/fr', name: 'fr')]
    public function front(): Response
    {
        return $this->render('dashboard/front.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}



