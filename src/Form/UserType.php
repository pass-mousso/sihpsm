<?php

namespace App\Form;

use App\Constant\Roles;
use App\Entity\Hospital;
use App\Entity\Person;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [

            ])
            ->add('roles', ChoiceType::class, [
                'choices' => array_flip(Roles::ROLE_APPLICATION),
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
                'multiple' => true,
            ])
            ->add('password')
            ->add('username')
            ->add('status')
            ->add('isVerified')
            ->add('person', EntityType::class, [
                'class' => Person::class,
                'choice_label' => 'id',
            ])
            ->add('hospital', EntityType::class, [
                'mapped' => false,
                'class' => Hospital::class,
                'choice_label' => 'name',
                'placeholder' => 'Select hospital',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
