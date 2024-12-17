<?php

return [
    'sections' => [
        [
            'title' => 'GESTION DES UTILISATEURS',
            'icon'  => '',
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
            'title' => 'User Management',
            'icon'  => '',
            'menus' => [
                'user_menu' => [
                    'label' => 'User Management',
                    'icon' => 'abstract-28',
                    'route' => null,
                    'submenus' => [
                        ['label' => 'Gestion menu', 'route' => 'admin_menu_index'],
                        ['label' => 'Rôles', 'route' => 'admin_role_index'],
                        ['label' => 'Permissions', 'route' => 'admin_permission_index'],
                    ]
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
