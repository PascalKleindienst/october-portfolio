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

    public $table = 'pkleindienst_portfolio_categories';

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:pkleindienst_portfolio_categories',
    ];

    protected $guarded = [];

    public $belongsToMany = [
        'items' => [
            'PKleindienst\Portfolio\Models\Item', 'table' => 'pkleindienst_portfolio_items_categories'
        ]
    ];

    public function beforeValidate()
    {
        // Generate a URL slug for this model
        if (!$this->exists && !$this->slug) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }
}