<?php namespace PKleindienst\Portfolio\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PKleindienst\Portfolio\Models\Item as ItemModel;
use PKleindienst\Portfolio\Models\Category;
use PKleindienst\Portfolio\Models\Settings;

/**
 * Item Component
 * @package PKleindienst\Portfolio\Components
 */
class Item extends ComponentBase
{
    /**
     * @var PKleindienst\Portfolio\Models\Item The item model used for display.
     */
    public $item;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    /**
     * @var string Reference to the page name.
     */
    public $itemsPage;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'pkleindienst.portfolio::lang.settings.item_title',
            'description' => 'pkleindienst.portfolio::lang.settings.item_description'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.item_slug',
                'description' => 'pkleindienst.portfolio::lang.settings.item_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.item_category',
                'description' => 'pkleindienst.portfolio::lang.settings.item_category_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/category',
            ],
            'itemsPage' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_items',
                'description' => 'pkleindienst.portfolio::lang.settings.items_items_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @return mixed
     */
    public function getItemsPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Load CSS and JS files and item
     */
    public function onRun()
    {
        $this->addCss('/plugins/pkleindienst/portfolio/assets/vendor/owl.carousel/dist/assets/owl.carousel.min.css');
        $this->addCss('/plugins/pkleindienst/portfolio/assets/vendor/owl.carousel/dist/assets/owl.theme.default.min.css');
        $this->addJs('/plugins/pkleindienst/portfolio/assets/vendor/owl.carousel/dist/owl.carousel.min.js');
        $this->addJs('/plugins/pkleindienst/portfolio/assets/js/slider.js');

        $this->sliderOptions = Settings::get('slider_options', '{}');
        $this->categoryPage  = $this->page[ 'categoryPage' ] = $this->property('categoryPage');
        $this->itemsPage     = $this->page[ 'itemsPage' ]    = $this->property('itemsPage');
        $this->item          = $this->page[ 'item' ]         = $this->loadItem();

        // show 404 when no item is found
        if (is_null($this->item)) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
    }

    /**
     * Load item
     * @return mixed
     */
    protected function loadItem()
    {
        $slug = $this->property('slug');
        $item = ItemModel::isPublic()->where('slug', $slug)->first();

        // Add a "url" helper attribute for linking to each category
        if ($item && $item->categories->count()) {
            $item->categories->each(function ($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        return $item;
    }
}
