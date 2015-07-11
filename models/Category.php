<?php namespace PKleindienst\Portfolio\Models;

use Str;
use Model;
use URL;
use PKleindienst\Portfolio\Models\Item;
use October\Rain\Router\Helper as RouterHelper;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string
     */
    public $table = 'pkleindienst_portfolio_categories';

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:pkleindienst_portfolio_categories',
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'items' => [
            'PKleindienst\Portfolio\Models\Item', 'table' => 'pkleindienst_portfolio_items_categories'
        ]
    ];

    /**
     * Generate Slug
     */
    public function beforeValidate()
    {
        // Generate a URL slug for this model
        if (!$this->exists && !$this->slug) {
            $this->slug = Str::slug($this->name);
        }
    }

    /**
     * @return mixed
     */
    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}
