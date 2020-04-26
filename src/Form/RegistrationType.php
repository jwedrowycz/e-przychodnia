<?php

namespace App\Form;

use App\Entity\Pacjent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('imie')
            ->add('nazwisko')
            ->add('PESEL')
            ->add('telefon')
            ->add('adres_zamieszkania')
            ->add('miasto')
            ->add('kod_pocztowy')
            ->add('data_dolaczenia')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pacjent::class,
        ]);
    }
}
