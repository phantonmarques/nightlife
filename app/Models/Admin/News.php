<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    /**
     * @var string $table
     */
    protected $table = 'news';

    /**
     * @var string $fillable
     */
    protected $fillable = [
        'title',
        'description',
        'date_news',
        'important',
        'user_id'
    ];

    /**
     * @var array $hidden
     */
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

}
