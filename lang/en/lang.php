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
        'access_items' => 'Manage the portfolio items',
        'access_categories' => 'Manage the blog categories',
        'delete_confirm' => 'Are you sure?',
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
        'return_to_categories' => 'Return to the blog category list',
    ],
];
