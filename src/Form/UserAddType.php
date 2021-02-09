<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserAddType extends AbstractType
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'mapped' => false,
                'invalid_message' => 'Podane hasła muszą się ze sobą zgadzać.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz hasło',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Twoje hasło powinno mieć przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern'   => '/^(?=.*[a-z])(?=.*\d).{8,}$/i',
                        'match'     => true,
                        'message'   => 'Hasło musi zawierać przynajmniej jedną wielką litere, cyfre oraz znak specjalny'])

                ],
                'first_options' => ['label' => 'Hasło' ],
                'second_options' => ['label' => 'Powtórz hasło'],
            ])
        ->add('submit', SubmitType::class, [
            'label' => 'Dodaj'
        ])
        // ->add('data_dolaczenia')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
