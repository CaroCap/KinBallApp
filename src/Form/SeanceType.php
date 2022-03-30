<?php

namespace App\Form;

use App\Entity\Saison;
use App\Entity\Seance;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        ->add('description')
        ->add('start')
        ->add('end')
        ->add('rue', TextType::class)
        ->add('numero', TextType::class)
        ->add('codePostal', TextType::class)
        ->add('ville', TextType::class)
        ->add('saison', EntityType::class, [
            'class'=>Saison::class, 
            'choice_label'=>'titre'
        ])    
        ->add('categorie', EntityType::class, [
            'class'=>Categorie::class, 
            'choice_label'=>'typeCategorie',
            'multiple'=>true
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
