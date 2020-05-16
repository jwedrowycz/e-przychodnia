<?php

namespace App\Form;

use App\Entity\WorkTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('day', ChoiceType::class, [
            'choices' => [ 'Wybierz dzień tygodnia' => '',
               'poniedziałek' => 1,
               'wtorek' => 2,
               'środa' => 3,
               'czwartek' => 4,
               'piątek' => 5,
            ],
            'required'   => false,
            ])
            ->add('start')
            ->add('end')
          
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkTime::class,
        ]);
    }
}
