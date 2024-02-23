<?php

namespace App\Form;

use App\Entity\Calendrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CalendrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentWeek = date('W');
        $builder
            ->add('idMedecin')
            ->add('jourFeries', ChoiceType::class, [
                'label' => 'Jours Fériés',
                'choices' => array_combine(range(0, 7), range(0, 7)),
                'data' => $currentWeek, // Set the default value to the current week
                'placeholder' => 'cette semaine', // Add a placeholder
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
    
            ->add('infos')
            
            ->add('disponibilite', ChoiceType::class, [
                'label' => 'Disponibilité',
                'choices' => [
                    'Status' => '',
                    'Disponible' => 'Disponible',
                    'Occupé' => 'Occupé',
                ],
               
                'required' => true,
                'placeholder' => 'Status', // texte affiché avant la sélection
            ])

     
  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendrier::class,
        ]);
    }
}