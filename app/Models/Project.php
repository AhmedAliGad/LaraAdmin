<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'bio', 'company_id', 'active', 'start_date', 'end_date'];

    protected $dates = ['start_date', 'end_date'];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketsCount($status)
    {
        return $this->tickets()->where('status_id', $status)->count();
    }

    public function scopeSupport (Builder $builder)
    {
        $builder->where('end_date', '>', Carbon::today());
    }
}
