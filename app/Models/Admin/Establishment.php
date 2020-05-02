<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\User;

class Establishment extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'establishment';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'user_id',
        'corporate_name',
        'state_registration',
        'type_license',
        'status'
    ];

    /**
     * Get the users record associated with the establishment.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the address record associated with the establishment.
     */
    public function establishment_address()
    {
        return $this->belongsTo(EstablishmentAddress::class, 'establishment_id', 'id');
    }

    /**
     * Get the category record associated with the establishment.
     */
    public function establishments_category()
    {
        return $this->belongsToMany(Category::class,'establishments_category');
    }

    /**
     * Get the rhythm musical record associated with the establishment.
     */
    public function establishments_rhythm()
    {
        return $this->belongsToMany(Rhythm::class,'establishments_rhythm');

    }

    /**
     * Get statistics of establishment.
     */
    public function establishment_statistics()
    {
        return $this->hasMany(EstablishmentStatistics::class, 'establishment_id');
    }
}
