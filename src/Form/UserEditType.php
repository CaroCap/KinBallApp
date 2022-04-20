<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEditType extends AbstractType
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
            ->add('telephone', TelType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'format' => 'dd MM yyyy'])
        // Pour éviter prob fichier stocké sous format string ---> array('data_class' => null) 
        ->add('photo', FileType::class, [
            'label' => false,
            'required' => false, 
            'data_class' => null
        ])
        ->add('accordPhoto', CheckboxType::class, [
            'label' => 'J\'autorise le club à utiliser mes photos à des fins de communication',
            'required' => false,
            'attr' => ['class' => 'form-check-input']
        ])
        ->add('rue', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false
        ])
        ->add('numero', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false
        ])
        ->add('codePostal', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false
        ])
        ->add('ville', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false
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
