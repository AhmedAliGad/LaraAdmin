<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    protected $fillable = ['file_name', 'ticket_id', 'path', 'type', 'uploaded_by'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($photo) {
            if (static::where('path', $photo->path)->exists()) {
                Storage::disk('s3')->delete($photo->path);
            }
        });
    }

    public function getFilePathAttribute()
    {
        return env('AWS_TICKETS_URL').$this->path;
    }

    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
