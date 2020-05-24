<?php

namespace App\Form\Filter;

use App\Entity\Clinic;
use App\Entity\Doctor;
use App\Entity\Unit;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\UnitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    private $doctorRepo;
    public function __construct(DoctorRepository $doctorRepo)
    {
        $this->doctorRepo = $doctorRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('clinic', EntityType::class, [
                'class' => 'App\Entity\Clinic',
                'choice_label' => function ($clinic) {
                    return $clinic->getName();
                },
                'choice_value' => function (?Clinic $entity) {
                    return $entity ? $entity->getId() : '';
                },
                'attr' => [
                    'onchange' => 'this.form.submit()'
                ],
                'placeholder' => 'Wszystkie',
                'mapped' => false,
                'label' => 'Poradnie: '

            ])->setMethod('GET');

        $builder->get('clinic')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event)
            {
                $form = $event->getForm();

//                dump($form->getData()->getUnit());
                $form->getParent()->add('doctor', EntityType::class, [
                    'class' => 'App\Entity\Unit',
                    'placeholder' => 'Wszyscy',
                    'choices' => $form->getData() === null ? [] : $form->getData()->getUnit(),
                    'attr' => [
                        'onchange' => 'this.form.submit()'
                    ],
                    'label' => 'Lekarze: '
                ]);
            }
        );

//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function(FormEvent $event)
//            {
//                $form = $event->getForm();
//                $data = $event->getData();
//                $doctors = $data->getUnit();
//
//                $form->get('clinic')->setData($doctors->)
//            }
//        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            // Configure your form options here
//            'data_class' =>
        ]);
    }
}
