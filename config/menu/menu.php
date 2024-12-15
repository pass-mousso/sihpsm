<?php

return [
    'sections' => [
        [
            'title' => 'GESTION DES UTILISATEURS',
            'icon'  => 'users',
            'menus' => [
                'customer_menu' => [
                    'label' => 'Customers',
                    'icon' => 'abstract-38',
                    'route' => 'admin_user_index',
                    'submenus' => [
                        ['label' => 'Customer Listing', 'route' => 'admin_user_index'],
                        ['label' => 'Customer Details', 'route' => 'admin_user_new'],
                    ]
                ],
                'account_menu' => [
                    'label' => 'My Account',
                    'icon' => 'user-account',
                    'route' => 'user_account',
                    'submenus' => [
                        ['label' => 'Profile', 'route' => 'admin_user_index'],
                        ['label' => 'Settings', 'route' => 'admin_user_index'],
                    ]
                ],
            ],
        ],
        [
            'title' => 'RAPPORTS',
            'icon'  => 'chart-bar',
            'menus' => [
                [
                    'icon' => 'chart-pie',
                    'label' => 'Statistiques',
                    'route' => 'stats_overview',
                ],
                [
                    'icon' => 'file-text',
                    'label' => 'Rapports mensuels',
                    'route' => 'monthly_reports',
                ],
            ],
        ],
    ],


    'role_permissions' => [
        'ROLE_IT_ADMIN' => ['customer_menu', 'account_menu'],
        'ROLE_OWNER' => ['account_menu'],
        // Ajoutez d'autres rôles ici avec les menus qu'ils peuvent voir
    ],
];
