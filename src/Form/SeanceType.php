<?php

namespace App\Form;

use App\Entity\Saison;
use App\Entity\Seance;
use App\Entity\Categorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('title', ChoiceType::class, [
                'label' => false,
                'attr' => ['class' => 'form-select text-wrap'],
                'choices'  => [
                    'Entrainement VUB' => 'Entrainement VUB',
                    'Entrainement ULB' => 'Entrainement ULB',
                    'Entrainement EXTRA' => 'Entrainement EXTRA',
                    'Match Championnat' => 'Match Championnat',
                    'Tournoi' => 'Tournoi',
                    'Événement' => 'Événement',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            // ->add('start', DateTimeType::class, [
            //         'widget' => 'single_text',
            //         'format' => 'dd-MM-yyyy',
            //         'html5' => false,
            //         'attr' => ['class' => 'js-datepicker'],
            //     ]
            // )
            ->add('start', DateTimeType::class, [
                'date_format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ],
            ])
            ->add('end', DateTimeType::class, [
                'date_format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'seconde' => 'Seconde',
                ],
            ])
            ->add('numero', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('rue', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'CP',
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('saison', EntityType::class, [
                'attr' => ['class' => 'form-select'],
                'class'=>Saison::class,
                // Pour trier mes choix par ordre
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.titre', 'DESC');
                },
                'choice_label'=>'titre'
            ])
            ->add('categorie', EntityType::class, [
                'attr' => ['class' => 'form-select'],
                'class'=>Categorie::class,
                'choice_label'=>'typeCategorie'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
