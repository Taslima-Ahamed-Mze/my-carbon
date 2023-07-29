<?php

namespace App\Form;

use App\Entity\Cooptation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CooptationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
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
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
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
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => ' mt-1
                    block
                    w-full
                    rounded-md
                    border-transparent
                    bg-gray-100
                    focus:border-gray-500 focus:bg-white focus:ring-0',
                    'placeholder' => 'john@example.com'
                ]
            ])
            ->add('cvFile', VichFileType::class, [
                'label' => 'CV',
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cooptation::class,
        ]);
    }
}
