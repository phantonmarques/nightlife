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
    protected $fillable = [
        'name'
    ];

    /**
     * Get statistics of establishment.
     */
    public function rhythm_statistics()
    {
        return $this->hasMany(RhythmStatistics::class, 'rhythm_id');
    }

    /**
     * Get the rhythm record associated with the establishment.
     */
    public function rhythm_establishments()
    {
        return $this->belongsToMany(Establishment::class,'establishments_rhythm');
    }
}
