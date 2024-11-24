<?php
// src/Form/TeamType.php

namespace App\Form;

use App\Entity\SuperHero;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'équipe'
            ])
            ->add('active', null, [
                'label' => 'Équipe active'
            ])
            ->add('leader', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'name',
                'label' => 'Sélectionner le leader',
                'placeholder' => 'Choisir un leader'
            ])
            ->add('members', EntityType::class, [
                'class' => SuperHero::class,
                'choice_label' => 'name',
                'label' => 'Sélectionner les membres',
                'multiple' => true,  // Permet la sélection multiple
                'expanded' => false, // Si true, affiche des cases à cocher
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
