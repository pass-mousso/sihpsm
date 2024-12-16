<?php

namespace App\Form;

use App\Entity\AdminRole;
use App\Entity\Menu;
use App\Entity\Section;
use App\Service\RouteService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    private RouteService $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'title',
                'placeholder' => 'Choisissez une section',
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre du menu',
            ])
            ->add('url', ChoiceType::class, [
                'label' => 'URL',
                'choices' => $this->getRoutesForChoices(),
                'choice_label' => function ($choice, $key, $value) {
                    return $key; // Label affiché
                },
                'choice_value' => function ($choice) {
                    return $choice; // Valeur du champ
                },
                'placeholder' => 'Choisissez une URL',
                'required' => false, // Optionnel pour des menus à la racine
            ])
            ->add('order', IntegerType::class, [
                'label' => 'Ordre d\'affichage',
            ])
            ->add('parent', EntityType::class, [
                'class' => Menu::class,
                'choice_label' => 'title',
                'placeholder' => 'Choisissez un parent',
                'required' => false,
            ])
            ->add('roles', EntityType::class, [
                'class' => AdminRole::class,
                'choice_label' => 'description',
                'multiple' => true,
                'placeholder' => 'Choisissez les rôles'
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône',
                'required' => false,
            ])
        ;
    }

    private function getRoutesForChoices(): array
    {
        // Récupérer les routes avec descriptions du service
        $routes = $this->routeService->getRoutesWithDescriptions();

        // Format pour un `ChoiceType` Symfony : ['Description' => 'route_name']
        $choices = [];
        foreach ($routes as $routeName => $description) {
            $choices[$description] = $routeName;
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
