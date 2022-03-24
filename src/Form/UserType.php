<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('dateNaissance')
            ->add('rue')
            ->add('numero')
            ->add('codePostal')
            ->add('ville')
            ->add('roles')
            ->add('password')
            ->add('photo')
            ->add('accordPhoto')
            ->add('persContactNom')
            ->add('persContactTel')
            ->add('persContactMail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
