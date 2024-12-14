<?php

return [
    'menus' => [
        'customer_menu' => [
            'label' => 'Customers',
            'icon' => 'abstract-38',
            'route' => 'admin_user_index',
            'submenus' => [
                ['label' => 'Customer Listing', 'route' => 'admin_user_index'],
                ['label' => 'Customer Details', 'route' => 'admin_user_details'],
            ]
        ],
        'account_menu' => [
            'label' => 'My Account',
            'icon' => 'user-account',
            'route' => 'user_account',
            'submenus' => [
                ['label' => 'Profile', 'route' => 'user_profile'],
                ['label' => 'Settings', 'route' => 'user_settings'],
            ]
        ],
    ],

    'role_permissions' => [
        'ROLE_ADMIN' => ['customer_menu', 'account_menu'],
        'ROLE_USER' => ['account_menu'],
        // Ajoutez d'autres rôles ici avec les menus qu'ils peuvent voir
    ],
];
