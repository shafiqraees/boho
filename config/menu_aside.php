<?php

// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/',
            'new-tab' => false,
        ],
        [
            'title' => 'Players',
            'root' => false,
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/players',
            'new-tab' => false,
        ],

        [
            'title' => 'Statistics',
            'root' => false,
            'icon' => 'media/svg/icons/Design/Bucket.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/stats',
            'new-tab' => false,
        ],
        [
            'title' => 'users',
            'icon' => 'media/svg/icons/Layout/Layout-left-panel-2.svg',
            'bullet' => 'dot',
            'page' => '/users',
            'root' => false,
            'new-tab' => false,
        ],
        // Custom

    ]

];
