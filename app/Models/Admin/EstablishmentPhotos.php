<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EstablishmentPhotos extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'establishments_photos';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'establishment_id',
        'img_path',
        'main',
    ];

    /**
     * Get establishment address of phones establishment available
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
}
