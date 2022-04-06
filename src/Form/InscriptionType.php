<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jourEntrainement', ChoiceType::class, [
                'choices'  => [
                    'Mercredi' => 'Mercredi',
                    'Dimanche' => 'Dimanche',
                    'Mercredi & Dimanche' => 'Mercredi & Dimanche'],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('categorie', EntityType::class, [
                'class'=>Categorie::class, 
                'choice_label'=>'typeCategorie',
                'attr' => ['class' => 'form-select'],
            ])    
            // ->add('dateInscription')
            // ->add('paiement')
            // ->add('datePaiement')
            ->add('ficheMedicale', FileType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('certifMedical', FileType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
