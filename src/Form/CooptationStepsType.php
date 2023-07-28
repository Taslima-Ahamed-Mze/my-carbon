<?php

namespace App\Form;

use App\Entity\CooptationSteps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CooptationStepsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //$cooptation = $options['cooptation'];
        $builder
            ->add('status')
            ->add('cooptation')
            ->add('stepCooptation')
            ->add('cooptation',TextType::class,[
                'label' => 'Montant',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CooptationSteps::class,
        ]);
    }
}
