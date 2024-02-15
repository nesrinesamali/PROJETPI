<?php
namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/consultation")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    #[Route('/consultation', name: 'consultation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $consultations = $entityManager
        ->getRepository(Consultation::class)
        ->findAll();

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
        ]);
    }

    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     */
    #[Route('/new', name: 'consultation_new', methods: ['GET', 'POST'])]

    public function new(Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    #[Route('/update/{id}', name: 'consultation_edit')]
    public function update(
        Request $request,
        ManagerRegistry $doctrine,
        $id
    ): Response {
        $consultation = $doctrine
            ->getRepository(Consultation::class)
            ->find($id);
        $form = $this->createForm(ConsultationType::class, $consultation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->renderForm('consultation/edit.html.twig', [
            'form' => $form,
            'consultation' => $consultation,
        ]);
    }
    /**
     * @Route("/{id}", name="consultation_delete")
     */
    #[Route('/{id}/delete', name: 'consultation_delete')]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $consultation = $entityManager
            ->getRepository(Consultation::class)
            ->find($id);
        
            $entityManager->remove($consultation);
            $entityManager->flush();
        
    
        return $this->redirectToRoute('consultation_index', [], Response::HTTP_SEE_OTHER);
    }
}