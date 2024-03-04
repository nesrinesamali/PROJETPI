<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class QrcodeController extends AbstractController
{
    #[Route('/generate_qr_code/{nompatient}/{nommedecin}/{date}/{heure}', name: 'generate_qr_code')]
    public function generateQrCode($nompatient, $nommedecin, $date, $heure): Response
    {
        // Concatenate product information into a single string
        $productInfo = "NomPatient: $nompatient\Nommedecin: $nommedecin\ date: $date\heure: $heure";

        // Create the QR code using the concatenated product information
        $qrCode = new QrCode($productInfo);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode->setMargin(10);
        $qrCode->setEncoding(new Encoding('UTF-8'));
        $qrCode->setSize(300);

        // Generate the QR code image
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Return the QR code image as a response
        return new Response($result->getString(), 200, [
            'Content-Type' => 'image/png',
        ]);
    }
}