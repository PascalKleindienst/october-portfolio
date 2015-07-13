<?php namespace PKleindienst\Portfolio\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PKleindienst\Portfolio\Models\Item;
use PKleindienst\Portfolio\Models\Category;
use PKleindienst\Portfolio\Models\Tag;
use PKleindienst\Portfolio\Models\Settings;

/**
 * Items Component
 * @package PKleindienst\Portfolio\Components
 */
class Items extends ComponentBase
{
    /**
     * A collection of items to display
     * @var Collection
     */
    public $items;

    /**
     * A collection of tags
     * @var Collection
     */
    public $tags;

    /**
     * If the item list should be filtered by a category, the model to use.
     * @var Model
     */
    public $category;

    /**
     * Message to display when there are no messages.
     * @var string
     */
    public $noItemsMessage;

    /**
     * Show Tag filters
     * @var boolean
     */
    public $showFilters;

    /**
     * Reference to the page name for linking to items.
     * @var string
     */
    public $itemPage;

    /**
     * Reference to the page name for linking to categories.
     * @var string
     */
    public $categoryPage;

    /**
     * If the item list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'pkleindienst.portfolio::lang.settings.items_title',
            'description' => 'pkleindienst.portfolio::lang.settings.items_description'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'categoryFilter' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_filter',
                'description' => 'pkleindienst.portfolio::lang.settings.items_filter_description',
                'type'        => 'string',
                'default'     => ''
            ],
            'showFilters' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_showfilter',
                'description' => 'pkleindienst.portfolio::lang.settings.items_showfilter_description',
                'type'        => 'checkbox',
                'default'     => ''
            ],
            'noItemsMessage' => [
                'title'        => 'pkleindienst.portfolio::lang.settings.items_no_items',
                'description'  => 'pkleindienst.portfolio::lang.settings.items_no_items_description',
                'type'         => 'string',
                'default'      => 'No items found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_order',
                'description' => 'pkleindienst.portfolio::lang.settings.items_order_description',
                'type'        => 'dropdown',
                'default'     => 'created_at desc'
            ],
            'categoryPage' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_category',
                'description' => 'pkleindienst.portfolio::lang.settings.items_category_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/category',
                'group'       => 'Links',
            ],
            'itemPage' => [
                'title'       => 'pkleindienst.portfolio::lang.settings.items_item',
                'description' => 'pkleindienst.portfolio::lang.settings.items_item_description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/item',
                'group'       => 'Links',
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
    public function getItemPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @return array
     */
    public function getSortOrderOptions()
    {
        return Item::$sortingOptions;
    }

    /**
     * Load JS,CSS and items, category and tags for the component view
     */
    public function onRun()
    {
        $this->addJs('/plugins/pkleindienst/portfolio/assets/vendor/shufflejs/dist/jquery.shuffle.modernizr.min.js');
        $this->addJs('/plugins/pkleindienst/portfolio/assets/js/list.js');
        $this->addCss('/plugins/pkleindienst/portfolio/assets/css/list.css');

        $this->prepareVars();

        $this->category = $this->page['category'] = $this->loadCategory();
        $this->items = $this->page['items'] = $this->listItems();
        $this->tags = $this->page['tags'] = Tag::lists('name');
        $this->imageOptions = [
            'width' => Settings::get('img_width') ?: 370,
            'height' => Settings::get('img_height') ?: 270,
            'mode' => Settings::get('img_mode') ?: 'auto'
        ];
    }

    /**
     * Prepare vars
     */
    protected function prepareVars()
    {
        $this->noItemsMessage = $this->page['noItemsMessage'] = $this->property('noItemsMessage');
        $this->showFilters = $this->page['showFilters'] = $this->property('showFilters');

        // Page links
        $this->itemPage = $this->page['itemPage'] = $this->property('itemPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    /**
     * Load items
     * @return mixed
     */
    protected function listItems()
    {
        $categories = $this->category ? $this->category->id : null;

        /*
         * List all the items, eager load their categories
         */
        $items = Item::with('categories')->listFrontEnd([
            'sort'       => $this->property('sortOrder'),
            'categories' => $categories
        ]);

        // Add a "url" helper attribute for linking to each item and category
        $items->each(function ($item) {
            $item->setUrl($this->itemPage, $this->controller);

            $item->categories->each(function ($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        });

        return $items;
    }

    /**
     * Load Categoriy
     * @return null
     */
    protected function loadCategory()
    {
        if (!$categoryId = $this->property('categoryFilter')) {
            return null;
        }

        if (!$category = Category::whereSlug($categoryId)->first()) {
            return null;
        }

        return $category;
    }
}
