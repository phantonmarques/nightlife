<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RhythmStatistics extends Model
{
    /**
     * @var string table
     */
    protected $fillable = ['rhythm_id'];

    public function rhythm(){
        return $this->belongsTo(Rhythm::class, 'rhythm_id');
    }
}
