<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CommentAttachment extends Model
{
    protected $fillable = ['file_name', 'comment_id', 'path', 'type'];

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

    public function comment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
