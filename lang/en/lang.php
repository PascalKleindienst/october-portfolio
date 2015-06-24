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
        'create_category' => 'portfolio category',
        'create_tag' => 'portfolio tag',
        'delete_confirm' => 'Are you sure?',

        // fields
        'title' => 'Title',
        'title_placeholder' => 'New Item Title',
        'slug' => 'Slug',
        'slug_placeholder' => 'new-item-title',
        'categories' => 'Categories',
        'visibility' => 'Visibility',
        'public' => 'Public',
        'private' => 'Private',
        'tags' => 'Tags',
        'tags_placeholder' => 'Enter Tags ...',
        'description' => 'Description',
        'description_comment' => 'A short description of the item',
        'tagline' => 'Tagline',
        'tagline_comment' => 'A short one line description of the item',
        'website' => 'Website',
        'website_comment' => 'Insert an URL for an external Website',
        'date' => 'Date',
        'date_comment' => 'Select the date the item was finished',
        'hero_image' => 'Hero Image',
        'hero_image_comment' => 'Main Image that represents the item',
        'featured_images' => 'Featured Image',
        'featured_images_comment' => 'Other images used in a slider to showcase the item',
        'created' => 'Created at',
        'updated' => 'Updated at',

        // tabs
        'tab_edit' => 'Edit',
        'tab_categories' => 'Categories',
        'tab_details' => 'Details',
        'tab_images' => 'Images'
    ],

    'permission' => [
        'access_items' => 'Manage the portfolio items',
        'access_categories' => 'Manage the blog categories',
    ],

    'items' => [
        'list_title' => 'Manage the portfolio items',
        'new_item' => 'New Item',
        'delete_confirm' => 'Do you really want to delete this item?',
        'delete_success' => 'Successfully deleted those items.',
        'return_to_items' => 'Return to the portfolio items list',
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
        'delete_success' => 'Successfully deleted those tags.',
        'return_to_tags' => 'Return to the portfolio tags list',
    ]
];
