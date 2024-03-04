<?php

namespace App\Controller;

use App\Service\MailjetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MailjetService  $mailjet): Response
    {   $mailjet->sendMail(content:'Bonjour à toi',toEmail:'nesrine.samaali07@gmail.com',toName: "Nesrine Samaali");

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
