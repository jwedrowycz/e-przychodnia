<?php

namespace App\Form;

use App\Entity\Lekarz;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLekarzFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie')
            ->add('nazwisko')
            ->add('numerPWZ')
            ->add('specjalizacja')
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
            'data_class' => Lekarz::class,
        ]);
    }
}
