<?php

return [
    'plugin' => [
        'name' => 'Portfolio',
        'description' => 'A robust blogging platform.',
    ],
    'portfolio' => [
        'menu_label' => 'Portfolio',
        'menu_description' => 'Manage Portfolio Items',
        'items' => 'Items',
        'create_item' => 'portfolio item',
        'categories' => 'Categories',
        'create_category' => 'portfolio category',
        'tags' => 'Tags',
        'create_tag' => 'portfolio tag',
        'delete_confirm' => 'Are you sure?',
    ],

    'permission' => [
        'access_items' => 'Manage the portfolio items',
        'access_categories' => 'Manage the blog categories',
    ],

    'categories' => [
        'list_title' => 'Manage the portfolio categories',
        'new_category' => 'New category',
        'uncategorized' => 'Uncategorized',
    ],
    'category' => [
        'name' => 'Name',
        'name_placeholder' => 'New category name',
        'slug' => 'Slug',
        'slug_placeholder' => 'new-category-slug',
        'items' => 'Items',
        'delete_confirm' => 'Do you really want to delete this category?',
        'return_to_categories' => 'Return to the portfolio category list',
    ],

    'tags' => [
        'list_title' => 'Manage the portfolio tags',
    ],

    'tag' => [
        'items' => 'Items',
        'name' => 'Name',
        'created' => 'Created at',
        'updated' => 'Updated at',
        'noItems' => 'No Items available',
        'delete_confirm' => 'Do you really want to delete this tag?',
        'return_to_tags' => 'Return to the portfolio tags list',
    ]
];
