<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MusicalRhythm extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'musical_rhythm';

    /**
     * @var array $fillable
     */
    protected $fillable = ['name'];

}
