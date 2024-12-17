<?php

namespace App\Form;

use App\Entity\Posology;
use App\Enum\FrequencyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('frequencyType', EnumType::class, [
                'class' => FrequencyType::class,
                'label' => 'Fréquence (Par jour, semaine, ...)'
            ])
            ->add('dose', NumberType::class, [
                'label' => 'Dose par prise (quantité)',
                'required' => true,
            ])
            ->add('unitType', EnumType::class, [
                'class' => UnitType::class,
                'label' => 'Unité (mg, ml, comprimés, ...)',
            ])
            ->add('periodType', EnumType::class, [
                'class' => PeriodType::class,
                'label' => 'Moment de la journée (matin, soir, ...)',
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée (en jours)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posology::class,
        ]);
    }
}
