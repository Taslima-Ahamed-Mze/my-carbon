<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{


    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        if (!$options['back_edit']) {
            $builder
                ->add('lastname', TextType::class, [
                    'label' => 'Nom',
                ])
                ->add('firstname', TextType::class, [
                    'label' => 'Prénom',
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Email',
                ])
                ->add('profile', EntityType::class, [
                    'label' => 'Profile',
                    'class' => Profile::class,
                    'multiple' => false,
                    'choice_label' => 'name',
                    'choice_value' => 'name',
                ])
                ->add('userSkills', CollectionType::class, [
                    'label' => 'Compétences',
                    'entry_type' => UserSkillsType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'attr' => [
                        'class' => 'skills-field',
                        'style' => 'display: none;',
                    ]
                ]);
        }
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo de profil',
                'required' => false
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ]);

    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'back_edit' => false,
        ]);
    }
}