<?php

namespace App\Form;

use App\Entity\Wizyta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WizytaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data_wizyty')
            ->add('godzina_przyjecia')
            ->add('jednostka')
            ->add('pacjent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wizyta::class,
        ]);
    }
}
