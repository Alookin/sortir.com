<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateDebut')
            ->add('dateLimiteInscription')
            ->add('nbLimiteInscription')
            ->add('duree')
            ->add('infosSortie')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label'=>'nom'
            ])
            ->add('lieu', EntityType::class, [
                'class'=> Lieu::class,
                'choice_label'=>'nom'
            ])
            ->add('organisateur', EntityType::class,[
                'class'=>Utilisateur::class,
                'choice_label'=>'pseudo'
            ])
            ->add('etat', EntityType::class,[
                'class'=>Etat::class,
                'choice_label'=>'libelle'
            ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
