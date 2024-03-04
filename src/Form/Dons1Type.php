<?php

namespace App\Form;

use App\Entity\Dons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Dons1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('DateDon', DateTimeType::class, [
            'widget' => 'single_text',
        ])
        ->add('datedernierdon', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('genre', ChoiceType::class, [
            'choices' => [
                'Homme' => 'Homme',
                'Femme' => 'Femme',
            ],
        ])
        ->add('GroupeSanguin', ChoiceType::class, [
            'choices' => [
                'O+' => 'O+',
                'O-' => 'O-',
                'A+' => 'A+',
                'A-' => 'A-',
                'B+' => 'B+',
                'B-' => 'B-',
                'AB+' => 'AB+',
                'AB-' => 'AB-',
            ],
        ])
        ->add('Etatmarital', ChoiceType::class, [
            'choices' => [
                'Célibataire' => 'Célibataire',
                'Marié' => 'Marié',
            ],
        ])
        ->add('typededon', ChoiceType::class, [
            'choices' => [
                'Don de sang' => 'S',
                'Don d’organes' => 'P',
                'Don de moelle osseuse' => 'PL',
            ],
        ])
            ->add('Cin')
            ->add('centreDon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dons::class,
        ]);
    }
}
