<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('brochure', FileType::class, [
            'label' => 'Brochure (Image file)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '10240k', 
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file (jpeg, png, jpg)',
                ])
            ],
        ])
        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\Email([
                    'message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.'
                ]),
            ],
        ])
            ->add('nom', null, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres.'
                    ]),
                ],
            ])
            ->add('prenom', null, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres.'
                    ]),
                ],
            ])
           
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'mapped' => true, // Mapping this field to a property of the entity
                'choices' => [
                    'Patient' => 'PATIENT',
                    'Donneur' => 'DONNEUR',
                    'Medecin' => 'MEDECIN',
                ],
                'multiple' => true, // Can be unchecked to select only one role
                'expanded' => true, // If you want roles to be presented as checkboxes
                'constraints' => [
                    new Callback([$this, 'validateRoles']),
                ],
            ])
            
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'mapped' => false,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.'
                    ])
                ],
            ]);

    
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validate' => false, // Disable validation for the form
        ]);
    }

    // Méthode de validation pour vérifier qu'un seul rôle est sélectionné
    public function validateRoles($value, ExecutionContextInterface $context): void
    {
        // Si aucun rôle n'est sélectionné, la validation échoue
        if (empty($value)) {
            $context->buildViolation('Veuillez sélectionner au moins un rôle.')
                ->addViolation();
        }
        // Si plus d'un rôle est sélectionné, la validation échoue
        elseif (count($value) > 1) {
            $context->buildViolation('Vous ne pouvez sélectionner qu\'un seul rôle.')
                ->addViolation();
        }
    }
}