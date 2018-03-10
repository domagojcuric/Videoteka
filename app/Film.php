<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'films';
    protected $primaryKey= 'id';

    public $fillable = [
        'naslov',
        'zanr_id',
        'godina',
        'trajanje',
        'cover_image',
    ];
}
