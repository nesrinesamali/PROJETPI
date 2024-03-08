<?php

namespace App\Form;

use App\Entity\CentreDon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentreDon1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('NomCentre')
        ->add('DateOuverture', null, [
            'widget' => 'single_text',
        ])
        
        ->add('datefermeture', null, [
            'widget' => 'single_text',
        ])
        ->add('gouvernorat', ChoiceType::class, [
            'choices' => [
                'Ariana' => 'Ariana',
                'Béja' => 'Béja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabès' => 'Gabès',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kébili' => 'Kébili',
                'Le Kef' => 'Le Kef',
                'Mahdia' => 'Mahdia',
                'Manouba' => 'Manouba',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozeur' => 'Tozeur',
                'Tunis' => 'Tunis',
                'Zaghouan' => 'Zaghouan',
            ],
            'choice_label' => function ($value, $key) {
                return strtoupper($key);
            },
        ])
        
        ->add('adresse')
        ->add('email')
        ->add('Numero')
    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CentreDon::class,
        ]);
    }
}
