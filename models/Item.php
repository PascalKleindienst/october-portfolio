<?php namespace PKleindienst\Portfolio\Models;

use Model;

/**
 * Item Model
 * @package PKleindienst\Portfolio\Models
 */
class Item extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string
     */
    public $table = 'pkleindienst_portfolio_items';

    /**
     * @var array Relation
     */
    public $belongsToMany = [
        'categories' => [
            'PKleindienst\Portfolio\Models\Category',
            'table' => 'pkleindienst_portfolio_items_categories',
            'order' => 'name'
        ],
        'tags' => [
            'PKleindienst\Portfolio\Models\Tag', 'table' => 'pkleindienst_portfolio_items_tags', 'order' => 'name'
        ]
    ];

    /**
     * @var array Relation
     */
    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order']
    ];

    /**
     * @var array Relation
     */
    public $attachOne = [
        'hero_image' => ['System\Models\File']
    ];

    /**
     * @var array
     */
    protected $tagHolder = [];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'slug' => 'required|between:3,64|unique:pkleindienst_portfolio_items',
    ];

    /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('categories', function ($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

    /**
     * Allows filtering for specifc tags
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterTags($query, $tags)
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            $q->whereIn('id', $tags);
        });
    }

    /**
     * Get Tags for Tagbox
     * @return mixed
     */
    public function getTagboxAttribute()
    {
        return $this->tags()->lists('name');
    }

    /**
     * Set Tags for tagbox
     * @param $tags
     */
    public function setTagboxAttribute($tags)
    {
        $this->tagHolder = $tags;
    }

    /**
     * Save tags
     */
    public function afterSave()
    {
        if ($this->tagHolder) {
            $ids = [];
            foreach ($this->tagHolder as $name) {
                $create = Tag::firstOrCreate(['name' => $name]);
                $ids[] = $create->id;
            }

            $this->tags()->sync($ids);
        }
    }
}
