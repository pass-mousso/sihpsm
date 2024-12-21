<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Hospital;
use App\Entity\HospitalFacility;
use App\Entity\Region;
use App\EventSubscriber\HospitalFormSubscriber;
use App\Service\Utils;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospitalType extends AbstractType
{
    public function __construct(
        private Security $security,
        private Utils $utils
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
//            ->add('description', TextareaType::class)
            ->add('address', TextType::class, [
                'required' => true,
            ])
//            ->add('website')
//            ->add('latitude')
//            ->add('longitude')
//            ->add('postalCode')
//            ->add('foundedDate', null, [
//                'widget' => 'single_text',
//            ])
            ->add('registrationNumber', TextType::class, [
                'required' => true,
            ])
            ->add('ownership', ChoiceType::class, [
                'required' => true,
                'choices' => Hospital::OWNERSHIP,
                'choice_label' => function ($choice) {
                    return ucfirst($choice);
                },
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('type', EntityType::class, [
                'required' => true,
                'class' => HospitalFacility::class,
                'choice_label' => 'label',
                'placeholder' => ""
            ])
            ->add('city', EntityType::class, [
                'required' => true,
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => ""
            ])
            ->add('region', EntityType::class, [
                'required' => true,
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => ""
            ])
            ->add('country', EntityType::class, [
                'required' => true,
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => ""
            ])
            ->add('business_contact', TextType::class, [
                'required' => true,
                'mapped' => false, // Non lié à une entité ou un modèle de données
                'attr' => ['class' => 'form-control form-control-lg form-control-solid'],
            ])
            ->add('business_email', EmailType::class, [
                'required' => true,
                'mapped' => false, // Non lié à une entité ou un modèle de données
                'attr' => ['class' => 'form-control form-control-lg form-control-solid'],
            ])
        ;

        $builder->addEventSubscriber(new HospitalFormSubscriber($this->security, $this->utils));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hospital::class,
        ]);
    }
}
