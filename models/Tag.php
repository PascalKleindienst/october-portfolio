<?php namespace PKleindienst\Portfolio\Models;

use Model;

/**
 * Tag Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkleindienst_portfolio_tags';

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'items' => [
            'PKleindienst\Portfolio\Models\Item', 'table' => 'pkleindienst_portfolio_items_tags'
        ]
    ];

    /**
     * @var array Fillable fields
     */
    public $fillable = ['name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|unique:pkleindienst_portfolio_tags|regex:/^[a-zA-Z0-9-]+$/'
    ];

    /**
     * @return mixed
     */
    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }
}
