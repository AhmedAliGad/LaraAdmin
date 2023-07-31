<?php

namespace App\Models;

use App\Traits\HasTranslate;
use Illuminate\Database\Eloquent\Model;

class CloseReason extends Model
{
    use HasTranslate;

    protected $fillable = ['title_ar', 'title_en', 'active'];

    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
