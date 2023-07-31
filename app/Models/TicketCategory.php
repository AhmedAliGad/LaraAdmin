<?php

namespace App\Models;

use App\Traits\HasTranslate;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'color'];
}
