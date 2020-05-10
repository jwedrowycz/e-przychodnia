<?php

namespace App\Form;

use App\Entity\CzasPracy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\CzasPracyFormType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CzasPracyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('dzien', ChoiceType::class, [
            'choices' => [ 'Wybierz dzień tygodnia' => '',
               'poniedziałek' => 'poniedziałek',
               'wtorek' => 'wtorek',
               'środa' => 'środa',
               'czwartek' => 'czwartek',
               'piątek' => 'piątek',
              
            ],
            'required'   => false,
            ])
            ->add('start')
            ->add('koniec')
          
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CzasPracy::class,
        ]);
    }
}
