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

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('title', ChoiceType::class, [
                'choices'  => [
                    'Entrainement VUB' => 'Entrainement VUB',
                    'Entrainement ULB' => 'Entrainement ULB',
                    'Match Championnat' => 'Match Championnat',
                    'Tournoi' => 'Tournoi',
                    'Événement' => 'Événement',
                ],
            ])
            ->add('description', TextType::class)
            // ->add('start', DateTimeType::class, [
            //         'widget' => 'single_text',
            //         'format' => 'dd-MM-yyyy',
            //         'html5' => false,
            //         'attr' => ['class' => 'js-datepicker'],
            //     ]
            // )
            ->add('start', DateTimeType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ],
                ])
            ->add('end', DateTimeType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'seconde' => 'Seconde',
                ],
                ])
            ->add('numero', TextType::class)
            ->add('rue', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('ville', TextType::class)
            ->add('saison', EntityType::class, [
                'class'=>Saison::class,
                // Pour trier mes choix par ordre
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.titre', 'DESC');
                },
                'choice_label'=>'titre'
            ])
            ->add('categorie', EntityType::class, [
                'class'=>Categorie::class,
                'choice_label'=>'typeCategorie'
            ])
            // ->add('categorie', EntityType::class, [
            //     'class'=>Categorie::class,
            //     'choice_label'=>'typeCategorie',
            //     'multiple'=>true
            // ])
            // ->add('start', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'input'  => 'string',
            //     'format' => 'dd MM yyyy HH:mm:ss',
            //     ])
            // ->add('title')
            // ->add('description')
            // ->add('start')
            // ->add('end')
            // ->add('numero')
            // ->add('rue')
            // ->add('codePostal')
            // ->add('ville')
            // ->add('saison')
            // ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
