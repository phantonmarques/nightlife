<?php

namespace App\Models\Site;

use App\Models\Admin\Establishment;
use App\Models\Admin\UserAccess;
use App\Models\Admin\UserSettings;
use App\Models\Site\City;
use App\Models\Admin\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'cpf_cnpj','city_id', 'type_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
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
    public function user_access(){
        return $this->hasMany(UserAccess::class, 'user_id');
    }



}
