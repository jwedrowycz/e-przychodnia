<?php

namespace App\Form;

use App\Entity\CzasPracy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\CzasPracyFormType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CzasPracyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dzien')
            ->add('start')
            ->add('koniec')
            ->add('submit', SubmitType::class, [
                'label' => 'Dodaj'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CzasPracy::class,
        ]);
    }
}
