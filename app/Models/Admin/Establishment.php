<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site\User;
use App\Models\Admin\EstablishmentAddress;

class Establishment extends Model
{
    protected $table = 'establishment';

    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function establishment_address(){
        return $this->belongsTo(EstablishmentAddress::class, 'establishment_id', 'id');
    }
}
