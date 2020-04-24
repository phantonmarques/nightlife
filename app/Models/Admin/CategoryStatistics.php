<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CategoryStatistics extends Model
{
    /**
     * @var string table
     */
    protected $fillable = ['category_id'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
