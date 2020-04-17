<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Rhythm extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'rhythm';

    /**
     * @var array $fillable
     */
    protected $fillable = ['name'];

}
