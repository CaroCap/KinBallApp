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
            'required' => true
        ])
        ->add('prenom', TextType::class)
        ->add('genre', ChoiceType::class, [
            'choices'  => [
                'X' => null,
                'Femme' => true,
                'Homme' => false,
            ],
        ])
        ->add('telephone', TelType::class)
        ->add('dateNaissance', BirthdayType::class, ['format' => 'dd MM yyyy'])
        ->add('photo', FileType::class, [
            'required' => false
        ])
        ->add('accordPhoto', CheckboxType::class, [
            'required' => false
        ])
        ->add('rue', TextType::class)
        ->add('numero', TextType::class)
        ->add('codePostal', TextType::class)
        ->add('ville', TextType::class)

        ->add('persContactNom', TextType::class, [
            'required' => false
        ])
        ->add('persContactTel', TelType::class, [
            'required' => false
        ])
        ->add('persContactMail', EmailType::class, [
            'required' => false
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
