<?php

namespace App\Controller;

use App\Entity\Dons;
use App\Form\DonsType;
use App\Repository\DonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dons')]
class DonsController extends AbstractController
{
    #[Route('/', name: 'app_dons_index', methods: ['GET'])]
    public function index(DonsRepository $donsRepository,EntityManagerInterface $entityManager): Response
    {
        $masc = $entityManager->getRepository(Dons::class)->count(['genre' => 'M']);
        $fem = $entityManager->getRepository(Dons::class)->count(['genre' => 'F']);
        $Sang = $entityManager->getRepository(Dons::class)->count(['typededon' => 'S']);
        $plasma = $entityManager->getRepository(Dons::class)->count(['typededon' => 'P']);
        $pl = $entityManager->getRepository(Dons::class)->count(['typededon' => 'PL']);
        $Apos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'A+']);
        $Aneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'A-']);
        $Bpos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'B+']);
        $Bneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'B-']);
        $ABpos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'AB+']);
        $ABneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'AB-']);
        $opos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'O+']);
        $oneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'O-']);

        return $this->render('dons/index.html.twig', [
            'dons' => $donsRepository->findAll(),
            'dons' => $donsRepository->findAll(),
            'masc'=> $masc,
            'fem'=>$fem,
            'sang'=>$Sang,
            'plasma'=>$plasma,
            'plaquette'=>$pl,
            'Apos'=>$Apos,
            'Aneg'=>$Aneg,
            'Bpos'=>$Bpos,
            'Bneg'=>$Bneg,
            'ABpos'=>$ABpos,
            'ABneg'=>$ABneg,
            'opos'=>$opos,
            'oneg'=>$oneg,

        ]);
    }
        #[Route('/charts', name: 'app_dons_charts', methods: ['GET'])]
        public function charts(DonsRepository $donsRepository,EntityManagerInterface $entityManager): Response
        {
            $masc = $entityManager->getRepository(Dons::class)->count(['genre' => 'M']);
            $fem = $entityManager->getRepository(Dons::class)->count(['genre' => 'F']);
            $Sang = $entityManager->getRepository(Dons::class)->count(['typededon' => 'S']);
            $plasma = $entityManager->getRepository(Dons::class)->count(['typededon' => 'P']);
            $pl = $entityManager->getRepository(Dons::class)->count(['typededon' => 'PL']);
            $Apos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'A+']);
            $Aneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'A-']);
            $Bpos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'B+']);
            $Bneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'B-']);
            $ABpos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'AB+']);
            $ABneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'AB-']);
            $opos = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'O+']);
            $oneg = $entityManager->getRepository(Dons::class)->count(['GroupeSanguin' => 'O-']);
    
            return $this->render('dons/charts.html.twig', [
                'dons' => $donsRepository->findAll(),
                'dons' => $donsRepository->findAll(),
                'masc'=> $masc,
                'fem'=>$fem,
                'sang'=>$Sang,
                'plasma'=>$plasma,
                'plaquette'=>$pl,
                'Apos'=>$Apos,
                'Aneg'=>$Aneg,
                'Bpos'=>$Bpos,
                'Bneg'=>$Bneg,
                'ABpos'=>$ABpos,
                'ABneg'=>$ABneg,
                'opos'=>$opos,
                'oneg'=>$oneg,
    
            ]);
        }
    #[Route('/new', name: 'app_dons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $don = new Dons();
        $form = $this->createForm(DonsType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($don);
            $entityManager->flush();

            return $this->redirectToRoute('app_dons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dons/new.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dons_show', methods: ['GET'])]
    public function show(Dons $don): Response
    {
        return $this->render('dons/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DonsType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dons/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dons_delete', methods: ['POST'])]
    public function delete(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
            $entityManager->remove($don);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dons_index', [], Response::HTTP_SEE_OTHER);
    }
}
