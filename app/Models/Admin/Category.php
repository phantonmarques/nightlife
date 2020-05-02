<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string table
     */
    protected $table = 'category';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get statistics of category.
     */
    public function category_statistics()
    {
        return $this->hasMany(CategoryStatistics::class, 'category_id');
    }

    /**
     * Get the category record associated with the establishment.
     */
    public function category_establishments()
    {
        return $this->belongsToMany(Establishment::class,'establishments_category');
    }
}
