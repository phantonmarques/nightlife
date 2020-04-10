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
    protected $fillable = ['name'];


}
