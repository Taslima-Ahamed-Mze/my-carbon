<?php

namespace App\Form;

use App\Entity\Levels;
use App\Entity\Skills;
use App\Entity\UserSkills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('skill',EntityType::class, [
                'class' => Skills::class,
                'multiple' => false,
                'choice_label' => 'name',
                'label' => 'Compétence',
                'placeholder' => 'Sélectionner une compétence',
                'required' => false,
                'attr' => [
                    'class' => 'block
                    w-full
                    mt-1
                    rounded-md
                    border-transparent
                    focus:border-gray-500 focus:bg-white focus:ring-0'
                ]
            ])

            ->add('level',EntityType::class, [
                'class' => Levels::class,
                'multiple' => false,
                'choice_label' => 'level',
                'label' => 'Niveau',
                'placeholder' => 'Sélectionner un niveau',
                'required' => false,
                'attr' => [
                    'class' => 'block
                    w-full
                    mt-1
                    rounded-md
                    border-transparent
                    focus:border-gray-500 focus:bg-white focus:ring-0'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSkills::class,
        ]);
    }
}
