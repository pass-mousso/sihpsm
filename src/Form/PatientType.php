<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Doctor;
use App\Entity\Hospital;
use App\Entity\Patient;
use App\Entity\Region;
use App\Entity\User;
use App\Enum\BloodGroup;
use App\Enum\MaritalStatusEnum;
use App\Enum\ResultatDepranocite;
use App\Enum\StatutTestDepranocite;
use App\Form\DataTransformer\StatutTestDepranociteDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Positive;

class PatientType extends AbstractType
{
    public function __construct(
        private StatutTestDepranociteDataTransformer $statutTestDepranociteDataTransformer
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'mapped' => false
            ])
//            ->add('username', TextType::class, [
//                'mapped' => false
//            ])
            ->add('firstName', TextType::class, [
                'label' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
            ])
            ->add('birthDate', BirthdayType::class, [
                'label'=> false,
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ],
            ])
            ->add('gender', ChoiceType::class,[
                'label' => false,
                'choices' => [
                    "Masculin" => "M",
                    "Féminin" => "F"
                ],
                'placeholder' => ""
            ])
            ->add('maritalStatus', ChoiceType::class, [
                'label' => false,
                'choices' => MaritalStatusEnum::readableChoices(),
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Sélectionnez un statut marital',
            ])
            ->add('weight', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'inputmode' => 'numeric', // Clavier numérique sur mobile
                    'pattern' => '\d+',       // Numéros uniquement, sans virgules
                ],
                'constraints' => [
//                    new \Symfony\Component\Validator\Constraints\NotBlank([
//                        'message' => 'Le poids ne peut pas être vide.',
//                    ]),
                    new Positive([
                        'message' => 'Le poids doit être un entier positif.'
                    ]),
                ],
            ])
            ->add('height', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('numberOfChildren', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('occupation', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('company', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('nationalCarteNumber', TextType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false
            ])
            ->add('SocialSecurityCarteNumber', TextType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false
            ])
            ->add('bloodGroup', ChoiceType::class, [
                'label' => false,
                'choices' => BloodGroup::GROUPS,
                'choice_label' => function ($choice) {
                    return ucfirst($choice);
                },
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Sélectionnez votre groupe sanguin'
            ])
            ->add('resultatDepranocite', ChoiceType::class, [
                'label' => false,
                'choices' => ResultatDepranocite::VALUES,
                'choice_label' => function ($choice) {
                    return ucfirst($choice);
                },
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Select Résultat Dépranocite'
            ])
            ->add($builder->create('statutTestDepranocite', ChoiceType::class, [
                'label' => 'Statut du test de drépanocytose',
                'choices' => StatutTestDepranocite::choices(),
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Sélectionnez le statut',
            ])->addModelTransformer($this->statutTestDepranociteDataTransformer))
            ->add('hospitals', EntityType::class, [
                'class' => Hospital::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'placeholder' => 'Sélectionnez un hôpital'
            ])
            ->add('imageProfile', null, [
                'mapped' => false,
                'label' => false,
                'required' => false,
            ])
            ->add('contact', TextType::class, [
                'mapped' => false
            ])
            ->add('regime', ChoiceType::class, [
                'mapped' => false,
                'required' => false,
                'choices' => [
                    "Aucun" => "RAS",
                    "Le régime hyperprotéiné" => "hyperprotéiné",
                    "Le régime protéiné" => "protéiné",
                    "Le régime hypocalorique" => "hypocalorique",
                    "Le régime dissocié" => "dissocié",
                    "Le régime végétarien." => "végétarien",
                    "Le régime anticellulite." => "anticellulite",
                    "Le régime sans sel." => "sans sel",
                    "Le régime hypoglucidique." => "hypoglucidique",
                ],
                'placeholder' => "",
                'empty_data' => 'RAS',
            ])
            ->add('address', TextType::class, [
                'mapped' => false
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un pays'
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une région'
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une ville'
            ])
            ->add('nationality', EntityType::class, [
               'required' => false,
               'mapped' => false,
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une nationalité'
            ])
            ->add('placeResidence', TextType::class, [
               'required' => false,
               'mapped' => false,
            ])
            ->add('doctor', EntityType::class, [
               'required' => false,
               'mapped' => false,
                'class' => Doctor::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez un médecin'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
