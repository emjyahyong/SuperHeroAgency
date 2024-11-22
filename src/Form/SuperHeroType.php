<?php

namespace App\Form;

use App\Entity\SuperHero;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuperHeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du Super Héros',
            ])
            ->add('alterEgo', TextType::class, [
                'label' => 'Alter Ego',
                'required' => false,
            ])
            ->add('available', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
            ])
            ->add('energyLevel', IntegerType::class, [
                'label' => 'Niveau d\'énergie',
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Biographie',
            ])
            ->add('imageName', TextType::class, [
                'label' => 'Nom de l\'image',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuperHero::class,
        ]);
    }
}
