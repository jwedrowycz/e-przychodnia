<?php

namespace App\Form\Filter;

use App\Entity\Clinic;
use App\Entity\Doctor;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
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
                'class' => Clinic::class,
                'query_builder' => function (ClinicRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => function (?Clinic $entity) {
                    return $entity ? $entity->getName() : '';
                },
                'label' => 'Filtr poradni: ',
                'attr' => [
                    'onchange' => 'this.form.submit()'
                ],
                'placeholder' => 'Wszystkie',
            ])
            ->add('doctor', EntityType::class, [
                'class' => Doctor::class,
                'choice_label' => function(Doctor $doctor) {
                    return sprintf('%s %s', $doctor->getName(), $doctor->getLastName());
                },
                'label' => 'Filtr lekarza: ',
                'attr' => [
                    'onchange' => 'this.form.submit()'
                ],
                'placeholder' => 'Wszyscy',
                'choices' => $this->doctorRepo->findAllAlphabetical()
            ])
//            ->add('doctor', EntityType::class, [
//                'class' => Doctor::class,
//                'query_builder' => function (DoctorRepository $er) {
//                    return $er->createQueryBuilder('d')
//                        ->orderBy('d.last_name', 'ASC');
//                },
//                'choice_label' => 'last_name',
//                'choice_value' => function (?Doctor $entity) {
//                    return $entity ? $entity->getId() : '';
//                },
//                'label' => 'Filtr lekarza: ',
//                'attr' => [
//                    'onchange' => 'this.form.submit()'
//                ],
//                'placeholder' => 'Wszystkie',
//            ])
            ->setMethod('GET')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            // Configure your form options here
        ]);
    }
}
