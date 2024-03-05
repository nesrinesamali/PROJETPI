<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Persistence\ManagerRegistry;
use App\Security\EmailVerifier;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private ManagerRegistry $managerRegistry;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EmailVerifier $emailVerifier, ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->emailVerifier = $emailVerifier;
        $this->managerRegistry = $managerRegistry;
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
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
    

    #[Route('/confirm-email/{token}', name: 'app_confirm_email')]
    public function confirmEmail(string $token): Response
    {
        $user = $this->managerRegistry->getManager()->getRepository(User::class)->findOneBy(['token' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Token invalide');
        }

        // $user->setEmailConfirmed(true);

        // $entityManager = $this->managerRegistry->getManager();
        // $entityManager->persist($user);
        // $entityManager->flush();

        return new RedirectResponse($this->generateUrl('app_home'));
    }

    private function sendVerificationEmail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('shayma.gabsy@esprit.tn', 'vitawell'))
            ->to($user->getEmail())
            ->subject('Vérification de votre email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
            ->context([
                'token' => $user->getToken(),
            ]);

        $this->emailVerifier->sendEmailConfirmation('app_confirm_email', $user, $email);
    }
}
