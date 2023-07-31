<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CloseReason extends Model
{
    protected $fillable = ['title_ar', 'title_en', 'active'];

    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
