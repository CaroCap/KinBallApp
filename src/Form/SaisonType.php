<?php

namespace App\Form;

use App\Entity\Saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextareaType::class,[                
                'label' => false,
            ])
            ->add('debut', DateType::class, ['format' => 'dd MM yyyy'],)
            ->add('fin', DateType::class, ['format' => 'dd MM yyyy'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Saison::class,
        ]);
    }
}
