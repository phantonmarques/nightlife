<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

    public function city(){
        return $this->hasMany(City::class, 'state_id', 'id');
    }
}
