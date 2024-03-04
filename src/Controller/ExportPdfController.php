<?php
namespace App\Controller;
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

#[Route('/api/product')]
class ExportPdfController extends AbstractController
{
#[Route('/exportProduct/pdf', name: 'export_product_to_pdf', methods: ['GET'])]
public function exportProductsToPdf(DonsRepository $donsRepository): Response
{
$products = $donsRepository->findAll();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("amine toumi");
$pdf->SetAuthor('amine toumi');
$pdf->SetTitle('Liste des dons');
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
$html = $this->renderView('dons/liste.html.twig', [
'dons' => $donsRepository->findAll(),
]);
$pdf->writeHTML($html);

$response = new Response($pdf->Output('dons.pdf', 'I'));
return $response;
}

#[Route('/list', name: 'list_dons', methods: ['GET'])]
public function listProducts(DonsRepository $donsRepository): Response
{
$products = $donsRepository->findAll();

return $this->json($products, 200, [], ['groups' => 'api']);
}
}
