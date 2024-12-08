<?php

namespace App\Form;

use App\Entity\SubscriptionPlans;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionPlansType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currency', ChoiceType::class, [
                'choices' => array_flip(SubscriptionPlans::CURRENCY_SETTING),
                'choice_label' => function ($choice, $key, $value) {
                    return $value . '-' . $key;
                },
            ])
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('frequency', ChoiceType::class,[
                'choices' => array_flip(SubscriptionPlans::PLAN_TYPE),
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
            ])
            ->add('trial_days', IntegerType::class)
            ->add('sms_limit', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionPlans::class,
        ]);
    }
}
