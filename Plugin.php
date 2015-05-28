<?php namespace PKleindienst\Portfolio;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'pkleindienst.portfolio::lang.plugin.name',
            'description' => 'pkleindienst.portfolio::lang.plugin.description',
            'author'      => 'Pascal Kleindienst',
            'icon'        => 'icon-picture-o',
            'homepage'    => 'https://github.com/pascalkleindienst/october-portfolio'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Owl\FormWidgets\Tagbox\Widget' => [
                'label' => 'Tagbox',
                'code'  => 'owl-tagbox'
            ],
        ];
    }

    public function registerComponents()
    {
        return [

        ];
    }

    public function registerPermissions()
    {
        return [
            'pkleindienst.portfolio.settings' => [
                'tab' => 'Portfolio', 'label' => 'pkleindienst.portfolio::lang.permission.settings'
            ],
            'pkleindienst.portfolio.access_items' => [
                'tab' => 'Portfolio', 'label' => 'pkleindienst.portfolio::lang.permission.access_items'
            ],
            'pkleindienst.portfolio.access_categories' => [
                'tab' => 'Portfolio', 'label' => 'pkleindienst.portfolio::lang.permission.access_categories'
            ],
            'pkleindienst.portfolio.access_tags' => [
                'tab' => 'Portfolio', 'label' => 'pkleindienst.portfolio::lang.permission.access_tags'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'portfolio' => [
                'label'       => 'pkleindienst.portfolio::lang.portfolio.menu_label',
                'url'         => Backend::url('pkleindienst/portfolio/items'),
                'icon'        => 'icon-picture-o',
                'permissions' => ['pkleindienst.portfolio.*'],
                'order'       => 500,

                'sideMenu' => [
                    'items' => [
                        'label'       => 'pkleindienst.portfolio::lang.portfolio.items',
                        'icon'        => 'icon-copy',
                        'url'         => Backend::url('pkleindienst/portfolio/items'),
                        'permissions' => ['pkleindienst.portfolio.access_posts']
                    ],
                    'categories' => [
                        'label'       => 'pkleindienst.portfolio::lang.portfolio.categories',
                        'icon'        => 'icon-list-ul',
                        'url'         => Backend::url('pkleindienst/portfolio/categories'),
                        'permissions' => ['pkleindienst.portfolio.access_categories']
                    ],
                    'tags' => [
                        'label'       => 'pkleindienst.portfolio::lang.portfolio.tags',
                        'icon'        => 'icon-tags',
                        'url'         => Backend::url('pkleindienst/portfolio/tags'),
                        'permissions' => ['pkleindienst.portfolio.access_tags']
                    ],
                ]
            ]
        ];
    }
}
