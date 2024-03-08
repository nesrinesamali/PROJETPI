<?php

namespace App\Controller;

use App\Entity\DossierMedical;
use App\Entity\Prescription;
use App\Form\DossierMedicalType;
use App\Repository\DossierMedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options as DompdfOptions;
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;

#[Route('/dossier/medical')]
class DossierMedicalController extends AbstractController
{

     
   
    #[Route('/dossier', name: 'app_dossier_medical_index', methods: ['GET'])]
    public function index(DossierMedicalRepository $dossierMedicalRepository, request  $request, PaginatorInterface $Paginator): Response
    {
        $dossier_medicals =$dossierMedicalRepository->findAll();
        $pagination = $Paginator->paginate(
            $dossierMedicalRepository->paginationQuery(),
            $request->query->getInt('page', 1) , 
            5/* page number */
        );
        return $this->render('dossier_medical/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    
    #[Route('/new', name: 'app_dossier_medical_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dossierMedical = new DossierMedical();
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossierMedical);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                ' Medical Record added successfully')
            ;
            
            return $this->redirectToRoute('app_dossier_medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dossier_medical/new.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dossier_medical_show', methods: ['GET'])]
    public function show(DossierMedical $dossierMedical): Response
    {
        return $this->render('dossier_medical/show.html.twig', [
            'dossier_medical' => $dossierMedical,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_dossier_medical_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierMedical $dossierMedical, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_dossier_medical_show', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('dossier_medical/edit.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);

    }

    #[Route('/{id}', name: 'app_dossier_medical_delete', methods: ['POST'])]
    public function delete(Request $request, DossierMedical $dossierMedical, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossierMedical->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dossierMedical);
            $entityManager->flush();
            $this->addFlash(
                'delete',
                'Medical Record Deleted')
            ;
        }

        return $this->redirectToRoute('app_dossier_medical_index', [], Response::HTTP_SEE_OTHER);
    }
   
    
    #[Route('/{id}/pdf', name: 'app_dossier_medical_pdf', methods: ['GET'])]
    public function generatePdf(DossierMedical $dossiermedical): Response
    {
        // Create a new instance of Dompdf
        $options = new DompdfOptions();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Render the PDF template with the prescription data
        $html = $this->renderView('dossier_medical/pdf.html.twig', [
            'dossier_medical' => $dossiermedical,
        ]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Stream the PDF to the browser
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        // Set the PDF file name
        $filename = sprintf('prescription_%s.pdf', $dossiermedical->getId());
        $response->headers->set('Content-Disposition', 'inline; filename="' . $filename . '"');

        return $response;
    }

    
    #[Route('/qrcode/{prescriptionId}', name: 'app_qr', methods: ['GET'])]
    public function generateQrCode(string $prescriptionId): Response
    {
        // Generate QR code with the prescription ID
        $qrCodeFactory = $this->get('endroid.qrcode.factory');
        $qrCode = $qrCodeFactory->create($prescriptionId);
    
        // Return the QR code as a response
        return new QrCodeResponse($qrCode);
    }
    
    
}
