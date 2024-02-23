<?php

namespace App\Form;

use DateTime;
use App\Entity\Rendezvous;
use Doctrine\DBAL\Types\TimeType as TypesTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

use Symfony\Component\Form\FormEvents;
// use Webmozart\Assert\Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType as TypeTimeType;
use Symfony\Component\Form\FormError;
use Webmozart\Assert\Assert\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RendezvousType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        ->add('nompatient')
        ->add('nommedecin')
        ->add('heure')
        
        ->add('date', DateType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'constraints' => [
                new Callback([$this, 'validateDateAndTime']),
            ],
        ]);
}
        
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
    public function validateDateAndTime($value, ExecutionContextInterface $context)
    {
        // Récupérer la date et l'heure sélectionnées
        $selectedDate = $value;
        $selectedTime = $context->getRoot()->get('heure')->getData();

        // Vérifier si un rendez-vous existe déjà pour la même date et la même heure
        $reservationRepository = $this->entityManager->getRepository(Rendezvous::class);
        $existingReservation = $reservationRepository->findOneBy([
            'date' => $selectedDate,
            'heure' => $selectedTime,
        ]);

        // Si un rendez-vous existe, ajouter une violation
        if ($existingReservation) {
            $context->buildViolation('Un rendez-vous existe déjà pour cette date et cette heure.')
                ->atPath('date')
                ->addViolation();
        }
    }
}
