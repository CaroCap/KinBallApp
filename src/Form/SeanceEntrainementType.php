<?php

namespace App\Form;

use App\Entity\SeanceEntrainement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceEntrainementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEntrainement')
            ->add('description')
            ->add('heureDebut')
            ->add('heureFin')
            ->add('adresse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeanceEntrainement::class,
        ]);
    }
}
