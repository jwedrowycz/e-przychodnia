<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'required' => false,
            
        ])
        ->add('name', TextType::class, [
            'required' => false,
           
        ])
        ->add('lastName', TextType::class, [
            'required' => false,
        ])
        ->add('PESEL', TextType::class, [
            'required' => false,
        ])
        ->add('numPhone', TextType::class, [
            'required' => false,
        ])
        ->add('address', TextType::class, [
            'required' => false,
        ])
        ->add('city', TextType::class, [
            'required' => false,
        ])
        ->add('postCode', TextType::class, [
            'required' => false,
        ])
            ->add('voivodeship', ChoiceType::class, [
                'choices' => [ 'Wybierz województwo' => '',
                   'dolnośląskie' => 'dolnośląskie',
                   'kujawsko' => 'kujawsko-omorskie',
                   'lubelskie' => 'lubelskie',
                   'lubuskie' => 'lubuskie',
                   'łódzkie' => 'łódzkie',
                   'małopolskie' => 'małopolskie',
                   'mazowieckie' => 'mazowieckie',
                   'opolskie' => 'opolskie',
                   'podkarpackie' => 'podkarpackie',
                   'podlaskie' => 'podlaskie',
                   'pomorskie' => 'pomorskie',
                   'śląskie' => 'śląskie',
                   'świętokrzyskie' => 'świętokrzyskie',
                   'warmińsko-mazurskie' => 'warmińsko-mazurskie',
                   'wielkopolskie' => 'wielkopolskie',
                   'zachodniopomorskie' => 'zachodniopomorskie',
                ],
                'required'   => false,
                ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                            'Wybierz płeć' => '',
                            'Mężczyzna' => 'M',
                            'Kobieta' => 'K',
                            'Dziecko' => 'D'
                            ],
                'required'   => false,
                ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Aktywny' => 1,
                    'Nieaktywny' => 0
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Operator' => 'ROLE_OPERATOR',
                    'Użytkownik' => 'ROLE_USER',
                    'Administrator' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => false,

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zatwierdź'
            ])
            
            ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
