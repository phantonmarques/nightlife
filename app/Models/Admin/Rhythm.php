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

    /**
     * Get statistics of establishment.
     */
    public function rhythm_statistics(){
        return $this->hasMany(RhythmStatistics::class, 'rhythm_id');
    }

}
