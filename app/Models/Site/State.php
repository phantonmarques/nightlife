<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

    /**
     * Get state of user.
     */
    public function city()
    {
        return $this->hasOne (City::class);
    }
}
