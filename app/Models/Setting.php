<?php

namespace App\Models;

use App\Traits\HasTranslate;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'description_ar', 'description_en', 'phone', 'email', 'whatsapp',
        'facebook', 'youtube', 'twitter', 'address_en', 'address_ar', 'latitude', 'longitude', 'terms_ar', 'terms_en',
        'privacy_ar', 'privacy_en',];
}
