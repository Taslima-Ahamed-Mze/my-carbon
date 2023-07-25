<?php

namespace App\Form;

use App\Entity\Profile;
use App\Entity\Skills;
use App\Entity\User;
use App\Repository\SkillsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{


    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
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
                'choice_value' => 'name'
            ])
            ->add('skills', EntityType::class, [
                'label' => 'Compétences',
                'class' => Skills::class,
                'multiple' => true,
                'choice_label' => 'name',
                'mapped' => false
            ]);


        if ($options['back_edit']) {
            $builder->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
            ]);
        }
            $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' =>
                    'Les champs du mot de passe doivent correspondre.',
                'required' => false,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                ],
            ]);
    }

    private function getSkills($skills)
    {


        $choices = [];

        foreach ($skills as $skill) {
            $choices[$skill->getId()] = $skill->getId();
        }

        return $choices;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'back_edit' => false,
        ]);

        $resolver->setRequired('skills');
    }
}
