<?php

namespace App\Controller;
use DateTime;
use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\RendezvousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\StripeService as StripeServiceAlias;

use App\Service\StripeService;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Service\RendezVousManager;
use StripeService as GlobalStripeService;

#[Route('/rendezvous')]
class RendezvousController extends AbstractController


{
  

    #[Route('/', name: 'app_rendezvous_index', methods: ['GET'])]
    public function index(RendezvousRepository $rendezvousRepository): Response
    {
        $rdv=$rendezvousRepository->findAll();

        return $this->render('rendezvous/index.html.twig', [
            'rendezvouses' => $rdv,
        ]);
    }
#[Route('/calendar/{id}', name: 'app_rendezvous_calendar', methods: ['GET'])]
public function calendar(RendezvousRepository $rendezvousRepository): Response
{
    return $this->render('rendezvous/calendar.html.twig', [
        'rendezvou' => $rendezvousRepository->findAll(),
    ]);
}
    #[Route('/new', name: 'app_rendezvous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rendezvou->setUser($this->getUser());

            $content = $rendezvou->getNompatient();
            $cleanedContenu = \ConsoleTVs\Profanity\Builder::blocker($content)->filter();
            $rendezvou->setnompatient($cleanedContenu);

       
        

            $entityManager->persist($rendezvou);
            $entityManager->flush();
            $this->addFlash('success', 'Rendezvous added successfully.');

           

            return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_show', methods: ['GET'])]
    public function show($id ,RendezvousRepository $rendezvou): Response
    {
        $rdv=$rendezvou->find($id);
       
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rdv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rendezvous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, RendezvousRepository $rendezvou, EntityManagerInterface $entityManager): Response
    {
        $rdv=$rendezvou->find($id);
        $form = $this->createForm(RendezvousType::class, $rdv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist( $rdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/edit.html.twig', [
          
            'form' => $form,
            'rendezvou'=>$rdv,
        ]);
    }

    #[Route('/{id}', name: 'app_rendezvous_delete', methods: ['POST'])]
    public function delete( RendezvousRepository $rendezvou,$id, EntityManagerInterface $entityManager): Response
    {
            $rdv=$rendezvou->find($id);
            $entityManager->remove($rdv);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_rendezvous_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
   
    }

