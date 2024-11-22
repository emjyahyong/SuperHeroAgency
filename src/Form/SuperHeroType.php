<?php

namespace App\Form;

use App\Entity\SuperHero;
use App\Entity\Power;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du super héros',
            ])
            ->add('alterEgo', TextType::class, [
                'required' => false,
                'label' => 'Alter Ego',
            ])
            ->add('available', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
            ])
            ->add('energyLevel', null, [
                'label' => 'Niveau d\'énergie',
            ])
            ->add('biography', null, [
                'label' => 'Biographie',
            ])
            ->add('imageName', TextType::class, [
                'required' => false,
                'label' => 'Nom de l\'image',
            ])
            // Ajout du champ pour les pouvoirs
            ->add('powers', EntityType::class, [
                'class' => Power::class,
                'choice_label' => 'name',
                'multiple' => true, // Permet de sélectionner plusieurs pouvoirs
                'expanded' => false, // Affiche comme une liste déroulante
                'label' => 'Pouvoirs',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHero::class,
        ]);
    }
}
