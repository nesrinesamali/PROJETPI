<?php
namespace App\Controller;
use App\Repository\RendezvousRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\ProductRepository; // Assuming your ProductRepository namespace is App\Repository
use App\Entity\Product;
use App\Repository\DonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TCPDF;
class ExportPdfController extends AbstractController
{
#[Route('/exportProduct/pdf', name: 'export_product_to_pdf', methods: ['GET'])]
public function exportProductsToPdf(RendezvousRepository $rendezvousRepository): Response
{
$products = $rendezvousRepository->findAll();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("samali nesryne");
$pdf->SetAuthor('samali nesryne');
$pdf->SetTitle('Liste des rendez-vous ');
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setFont('dejavusans', '', 14, '', true);
$pdf->AddPage();
$html = $this->renderView('rendezvous/liste.html.twig', [
'rendezvous' => $rendezvousRepository->findAll(),
]);
$pdf->writeHTML($html);

$response = new Response($pdf->Output('rendez-vous.pdf', 'I'));
return $response;
}




}