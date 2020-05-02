<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'city';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'name_visible',
        'ddd_city',
        'state_id'
    ];

    /**
     * Get citys of user.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
