<?php

return [
    'locations' => [
        'home-sidebar' => 'Home Sidebar',
        'post-sidebar' => 'Post Sidebar',
        'home-bottombar' => 'Home Bottombar',
        'category-sidebar' => 'Category Sidebar',
        'tag-sidebar' => 'Tag Sidebar',
        'search-sidebar' => 'Search Sidebar'
    ],
    'editor' => [
        'routes' => [
            'location' => '/location',
            'sidebar' => [
            	'base' => '/sidebar',
                'get' => '/sidebar/editor/get',
                'put' => '/sidebar/editor/{id}',
                'store' => '/sidebar'
            ],
            'widget' => [
                'store' => '/widgets',
                'update'=> '/widgets/{id}',
                'delete'=> '/widgets/{id}'
            ]
        ]
    ],
    'sidebar' => [
        'markup' => [
            'posts' => [
                'container'=>[
                    'before'=>'<div class="widget widget-posts">',
                    'after' => '</div>'
                ],
                'title' => [
                    'before' => '<h1 class="widget widget-title">',
                    'after' => '</h1>'
                ],
                'content' => [
                    'before' => '<div class="widget widget-content">',
                    'after' => ''
                ]
            ],
            'html' => [
                'container'=>[
                    'before'=>'<div class="widget widget-posts">',
                    'after' => '</div>'
                ],
                'title' => [
                    'before' => '<h1 class="widget widget-title">',
                    'after' => '</h1>'
                ],
                'content' => [
                    'before' => '<div class="widget widget-content">',
                    'after' => ''
                ]
            ]
        ]
    ]
];