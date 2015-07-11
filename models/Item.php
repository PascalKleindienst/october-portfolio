<?php namespace PKleindienst\Portfolio\Models;

use Model;

/**
 * Item Model
 * @package PKleindienst\Portfolio\Models
 */
class Item extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public static $sortingOptions = [
        'created_at desc' => 'Created At (Descending)',
        'created_at asc' => 'Created At (Ascending)',
        'title desc' => 'Title (Descending)',
        'title asc' => 'Title (Ascending)',
        'date desc' => 'Finished (Descending)',
        'date asc' => 'Finished (Ascending)'
    ];

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
     * @param  Illuminate\Query\Builder $query QueryBuilder
     * @param  array $tags List of tag ids
     * @return Illuminate\Query\Builder QueryBuilder
     */
    public function scopeFilterTags($query, $tags)
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            $q->whereIn('id', $tags);
        });
    }

    /**
     * Only Public Items
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeIsPublic($query)
    {
        return $query->where('visibility', 'public');
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

    /**
     * Lists posts for the front end
     * @param  array $options Display options
     * @return self
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'sort'       => 'created_at',
            'categories' => null,
            'visibility'  => 'public'
        ], $options));

        /*
         * Sorting
         */
        if (!is_array($sort)) $sort = [$sort];
        foreach ($sort as $sorting) {

            if (in_array($sorting, array_keys(self::$sortingOptions))) {
                $parts = explode(' ', $sorting);
                if (count($parts) < 2) array_push($parts, 'desc');
                list($sortField, $sortDirection) = $parts;

                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Categories
         */
        if ($categories !== null) {
            if (!is_array($categories)) $categories = [$categories];
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('id', $categories);
            });
        }

        return $query->get();
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

        if (array_key_exists('categories', $this->getRelations())) {
            $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}
