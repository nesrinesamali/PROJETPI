<?php

namespace App\Controller;

use App\Service\StripeService;
use StripeService as GlobalStripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function index(  StripeService $stripeService): Response
    {
        // Montant du paiement (en centimes)
        $amount = 2000; // Exemple de montant : 20 EUR

        // Créer une intention de paiement avec Stripe
        $paymentIntent = $stripeService->createPaymentIntent($amount);

        // Rendre le template avec l'intention de paiement
        return $this->render('payment/index.html.twig', [
            'paymentIntent' => $paymentIntent,
        ]);
    }
}
