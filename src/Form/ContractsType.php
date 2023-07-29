<?php

namespace App\Form;

use App\Entity\Contracts;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Offers; 
use App\Entity\User; 
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class ContractsType extends AbstractType
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('offer', CollectionType::class, [
            'class' => Offers::class,
            'choice_label' => 'name',
            'placeholder' => 'Sélectionner une offre',
            'attr' => [
                'class' => ' mt-1
                block
                w-full
                rounded-md
                border-transparent
                focus:border-gray-500 focus:bg-white focus:ring-0
                bg-gray-100
                '
            ]
        ])
       
        ->add('collaborator', EntityType::class, [
            'class' => User::class,
            'choices' => $this->userRepository->findCollaboratorsWithoutContract(),
            'choice_label' => 'firstname',
            'placeholder' => 'Sélectionner le client',
            'attr' => [
                'class' => ' mt-1
                block
                w-full
                rounded-md
                border-transparent
                focus:border-gray-500 focus:bg-white focus:ring-0
                bg-gray-100
                '
            ]
        ])
        ->add('start_date', DateTimeType::class, [
            'label' => 'Date de début',
            'widget' => 'single_text',
            'html5' => true,
            
            'attr' => [
                'class' => ' datetimepicker1
                block
                w-full
                rounded-md
                border-transparent
                focus:border-gray-500 focus:bg-white focus:ring-0
                bg-gray-100
                '
            ]
        ])
        ->add('end_date', DateTimeType::class, [
            'label' => 'Date de fin',
            'widget' => 'single_text',
            'html5' => true,
            'attr' => [
                'class' => ' datetimepicker1
                block
                w-full
                rounded-md
                border-transparent
                focus:border-gray-500 focus:bg-white focus:ring-0
                bg-gray-100
                '
            ]
        ])

        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contracts::class,
        ]);
    }
}
