<?php

namespace App\Form;

use App\Entity\FormationRegister;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FormationRegisterType extends AbstractType
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('certificateFile', VichFileType::class, [
                'label' => 'Certificat de fin de formation',
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Finir la formation",
                'attr' => [
                    'class' => 'px-4 py-3 bg-[#5B98D2] rounded text-white'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationRegister::class,
        ]);
    }
}