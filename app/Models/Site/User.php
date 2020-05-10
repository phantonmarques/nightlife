<?php

namespace App\Models\Site;

use App\Models\Admin\Establishment;
use App\Models\Admin\UserAccess;
use App\Models\Admin\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;

    /**
     * @var string $table
     */
    protected $table = 'user';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'cpf_cnpj',
        'city_id',
        'type_user'
    ];

    /**
     * @var array $hidden
     */
    protected $hidden = [
        'password',
        'establishment_connect',
        'type_user',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array $casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get users type establishment.
     */
    public function establishments(){
        return $this->hasOne(Establishment::class, 'id', 'user_id');
    }

    /**
     * Get citys of user.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    /**
     * Get users_settings of users (USER COMMON)
     */
    public function user_settings()
    {
        return $this->hasOne(UserSettings::class, 'user_id');
    }

    /**
     * Get statistics of establishment.
     */
    public function user_access()
    {
        return $this->hasMany(UserAccess::class, 'user_id');
    }

    /**
     * Get rating of establishment.
     */
    public function user_rating()
    {
        return $this->hasMany(UserRating::class, 'user_id');
    }

    /**
     * Get rating of establishment.
     */
    public function user_comment()
    {
        return $this->hasMany(UserComment::class, 'user_id');
    }
}
