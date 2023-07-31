<?php

namespace App\Models;

use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use HasPhoto, LogsActivity;

    protected $fillable = ['title', 'content', 'created_by', 'project_id', 'status_id', 'priority_id', 'device_os',
        'assigned_users', 'ticket_category_id', 'close_notes', 'close_reason_id', 'close_request_by'];

    protected $casts = ['assigned_users' => 'array'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()->logOnlyDirty();
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function priority(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function closeRequestBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'close_request_by');
    }

    public function assignedUsers()
    {
        return User::whereIn('id', $this->assigned_users)->get(['id', 'name']);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function closeReason()
    {
        return $this->belongsTo(CloseReason::class, 'close_reason_id');
    }

    public function scopeSearch($query, $value)
    {
        if (preg_match('/^[0-9]+$/', $value)) {
            $query->where('id', 'like', "%$value%");
        } else {
            $value = "%$value%";
            $query->where('title', 'like', $value)
                  ->orWhere('content', 'like', $value);
        }
    }

    public function scopeDateFilter($query, $value)
    {
        return isset($value) ? $query->whereDate('created_at', $value) : $query;
    }

    public function scopeProjectFilter($query, $value)
    {
        return isset($value) ? $query->where('project_id', $value) : $query;
    }

    public function scopeStatusFilter($query, $value)
    {
        return isset($value) ? $query->where('status_id', $value) : $query;
    }

    public function scopePriorityFilter($query, $value)
    {
        return isset($value) ? $query->where('priority_id', $value) : $query;
    }

    public function scopeCategoryFilter($query, $value)
    {
        return isset($value) ? $query->where('ticket_category_id', $value) : $query;
    }

    public function scopeOsFilter($query, $value)
    {
        return isset($value) ? $query->where('device_os', $value) : $query;
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['status_id'] ?? false,
            fn ($query, $value) => $query->where('status_id', $value)
        )->when(
            $filters['ticket_category_id'] ?? false,
            fn ($query, $value) => $query->where('ticket_category_id', $value)
        )->when(
            $filters['project_id'] ?? false,
            fn ($query, $value) => $query->where('project_id', $value)
        )->when(
            $filters['priority_id'] ?? false,
            fn ($query, $value) => $query->where('priority_id', $value)
        )->when(
            $filters['device_os'] ?? false,
            fn ($query, $value) => $query->where('device_os', $value)
        )->when(
            $filters['date_from'] ?? false,
            fn ($query, $value) => $query->whereDate('created_at', '>=', $value)
        )->when(
            $filters['date_to'] ?? false,
            fn ($query, $value) => $query->whereDate('created_at', '<=', $value)
        );
    }

    public function scopeOpen($query)
    {
        $query->where('status_id', 1);
    }
}
