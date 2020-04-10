<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

use App\Models\Site\State;


class City extends Model
{
    protected $table = 'city';

    /**
     * Get citys of user.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
