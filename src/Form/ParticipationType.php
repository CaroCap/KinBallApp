<?php

namespace App\Form;

use App\Entity\Participation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typePresence', ChoiceType::class, [
                'choices'  => [
                    'Présent' => 'Présent',
                    'Absent' => 'Absent',
                    'Indécis' => 'Indécis',
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false])
            // ->add('inscription')
            // ->add('seance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}
