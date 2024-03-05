<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]

    public function show(Request $request,  UserPasswordEncoderInterface $passwordEncoder,FlashyNotifier $flashy, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $filteredRoles = array_filter($user->getRoles(), function ($role) {
            return $role !== 'ROLE_USER';
        });
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $user->setBrochure($newFilename);
            }
            $flashy->success('Profile Modifer!', 'http://localhost:8000/profile');
            // Encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'filteredRoles' => $filteredRoles,
            'registrationForm' => $form->createView()
        ]);
    }
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
    
            // Encode the plain password
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
            // Generate and set the token
            $token = bin2hex(random_bytes(32)); // Generate a random token
            $user->setToken($token);
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            // Send verification email
            $email = (new TemplatedEmail())
                ->from(new Address('noreply@example.com', 'Example'))
                ->to($user->getEmail())
                ->subject('Vérification de votre email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context([
                    'token' => $user->getToken(),
                ]);
    
            $this->emailVerifier->sendEmailConfirmation('app_acceuil', $user, $email);
    
            $this->addFlash('success', 'Inscription réussie, veuillez vérifier votre email !');
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
}
