<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('genre', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'choices'  => [
                    'X' => null,
                    'Femme' => true,
                    'Homme' => false,
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' =>'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('telephone', TelType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'format' => 'dd MM yyyy'])
            ->add('photo', FileType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('accordPhoto', CheckboxType::class, [
                'label' => 'J\'autorise le club à utiliser mes photos à des fins de communication',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
                // Pour mettre checkbox coché par défaut
                'data' => true,
                // OU 'attr' => ['class' => 'form-check-input', 'checked' => 'checked'],
            ])
            ->add('rue', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('numero', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('codePostal', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])

            ->add('persContactNom', TextType::class, [
                'label' => 'Personne de contact',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('persContactTel', TelType::class, [
                'label' => 'Téléphone de contact',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('persContactMail', EmailType::class, [
                'label' => 'E-mail de contact',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
