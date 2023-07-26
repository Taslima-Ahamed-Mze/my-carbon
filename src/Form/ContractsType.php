<?php

namespace App\Form;

use App\Entity\Contracts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Offers; 
use App\Entity\User; 


class ContractsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('offer', EntityType::class, [
            'class' => Offers::class,
            'choice_label' => 'name', // Remplacez 'nom' par la propriété de l'entité Offer à afficher dans la liste déroulante
            'placeholder' => 'Sélectionner une offre', // Message par défaut dans la liste déroulante
        ])
        ->add('collaborator', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'firstname', // Remplacez 'nom' par la propriété de l'entité Collaborator à afficher dans la liste déroulante
            'placeholder' => 'Sélectionner le client', // Message par défaut dans la liste déroulante
        ]);

         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contracts::class,
        ]);
    }
}
