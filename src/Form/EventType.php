<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
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
            ->add('description', TextType::class, [
                'label' => 'Description',
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
                'widget' => 'single_text',
                'required' =>true,
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
                'widget' => 'single_text',
                'required' =>true,
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
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de l\'événement',
            ])
//            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
