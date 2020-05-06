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

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                
            ])
            ->add('imie', TextType::class, [
                'required' => false,
               
            ])
            ->add('nazwisko', TextType::class, [
                'required' => false,
            ])
            ->add('PESEL', TextType::class, [
                'required' => false,
            ])
            ->add('telefon', TextType::class, [
                'required' => false,
            ])
            ->add('adres_zamieszkania', TextType::class, [
                'required' => false,
            ])
            ->add('miasto', TextType::class, [
                'required' => false,
            ])
            ->add('kod_pocztowy', TextType::class, [
                'required' => false,
            ])
            ->add('wojewodztwo', ChoiceType::class, [
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
            ->add('data_urodzenia', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                // 'format' => 'dd/mm/yyyy',
                // 'html5' => false
            ])
            ->add('plec', ChoiceType::class, [
                'choices' => [
                            'Wybierz płeć' => '',
                            'Mężczyzna' => 'Mężczyzna',
                            'Kobieta' => 'Kobieta',
                            ],
                'required'   => false,
                ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Zaakceptuj warunki przechowywania danych.',
                    ]),
                ],
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
                        'min' => 6,
                        'minMessage' => 'Twoje hasło powinno mieć przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options' => ['label' => 'Hasło' ],
                'second_options' => ['label' => 'Powtórz hasło'],
            ])
        ->add('submit', SubmitType::class, [
            'label' => 'Rejestruj'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
