<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'author_id',
        'parent_id',
        'content',
        'like_count',
        'status',
        'is_solution'
    ];

    protected $casts = [
        'is_solution' => 'boolean',
    ];

    /**
     * Get the discussion that owns the reply
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get the author that owns the reply
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get parent reply
     */
    public function parent()
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }

    /**
     * Get child replies
     */
    public function children()
    {
        return $this->hasMany(DiscussionReply::class, 'parent_id');
    }

    /**
     * Boot method to update discussion reply count
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->discussion->updateReplyCount();
        });

        static::deleted(function ($reply) {
            $reply->discussion->updateReplyCount();
        });
    }

    /**
     * Scope for published replies
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}