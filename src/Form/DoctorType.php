<?php

namespace App\Form;

use App\Entity\Doctor;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,

            ])
            ->add('lastName', TextType::class, [
                'required' => true,

            ])
            ->add('numPwz', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 7
                ]
            ])
            ->add('spec')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Aktywny' => '1',
                    'Nieaktywny' => '0',
                    ],
                'multiple'=>false,
                'expanded'=>true
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Doctor::class,
        ]);
    }
}
