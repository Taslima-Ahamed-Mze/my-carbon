<?php

namespace App\Form;

use App\Entity\Offers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class OffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'offre',
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
            ->add('address', TextType::class, [
                'label' => 'Adresse postale',
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
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offers::class,
        ]);
    }
}
