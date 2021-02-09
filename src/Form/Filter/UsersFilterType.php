<?php

namespace App\Form\Filter;

use App\Entity\Clinic;
use App\Entity\Doctor;
use App\Entity\Unit;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\UnitRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class UsersFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Użytkownik' => 'ROLE_USER',
                    'Operator' => 'ROLE_OPERATOR',
                    'Administrator' => 'ROLE_ADMIN'
                ],
                'attr' => [
                    'onchange' => 'this.form.submit()'
                ],
                'placeholder' => 'Wszyscy'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Aktywni' => 1,
                    'Nieaktywni' => 0
                ],
                'attr' => [
                    'onchange' => 'this.form.submit()'
                ],
                'data' => 1
            ])
            ->setMethod('GET');
    }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'csrf_protection' => false,
                'validation' => false,
                // Configure your form options here
//            'data_class' =>
            ]);
        }
}

