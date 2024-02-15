<?php

namespace App\Controller;

use App\Entity\Calendrier;
use App\Form\CalendrierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
class CalendrierController extends AbstractController
{
    #[Route('/calendrier',  name: 'calendrier_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $calendriers = $entityManager
        ->getRepository(Calendrier::class)
        ->findAll();

        return $this->render('calendrier/index.html.twig', [
            'calendriers' => $calendriers,
        ]);
    }
     /**
     * @Route("/new", name="Calendrier_new", methods={"GET","POST"})
     */
    #[Route('/calendrier/new', name: 'calendrier_new', methods: ['GET', 'POST'])]

    public function new(Request $request): Response
    {
        $calendrier = new Calendrier();
        $form = $this->createForm(CalendrierType::class, $calendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendrier);
            $entityManager->flush();

            return $this->redirectToRoute('calendrier_index');
        }

        return $this->render('calendrier/new.html.twig', [
            'calendrier' => $calendrier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="Calendrier_edit", methods={"GET","POST"})
     */
    #[Route('/update/{id}', name: 'calendrier_edit')]
    public function update(
        Request $request,
        ManagerRegistry $doctrine,
        $id
    ): Response {
        $calendrier = $doctrine
            ->getRepository(Calendrier::class)
            ->find($id);
        $form = $this->createForm(CalendrierType::class, $calendrier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('calendrier_index');
        }

        return $this->renderForm('calendrier/edit.html.twig', [
            'form' => $form,
            'calendrier' => $calendrier,
        ]);
    }
    /**
     * @Route("/{id}", name="Calendrier_delete", methods={"DELETE"})
     */
    #[Route('/{id}/delete', name: 'calendrier_delete')]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $calendrier = $entityManager
            ->getRepository(Calendrier::class)
            ->find($id);
        
            $entityManager->remove($calendrier);
            $entityManager->flush();
        
    
        return $this->redirectToRoute('calendrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
