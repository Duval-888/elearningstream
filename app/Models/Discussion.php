<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'status',
        'is_pinned',
        'category_id',
        'author_id',
        'view_count',
        'reply_count',
        'like_count',
        'tags',
        'last_reply_at'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'tags' => 'array',
        'last_reply_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($discussion) {
            if (empty($discussion->slug)) {
                $discussion->slug = Str::slug($discussion->title);
            }
        });
    }

    /**
     * Get the category that owns the discussion
     */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    /**
     * Get the author that owns the discussion
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get discussion replies
     */
    public function replies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    /**
     * Get latest reply
     */
    public function latestReply()
    {
        return $this->hasOne(DiscussionReply::class)->latest();
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Update reply count
     */
    public function updateReplyCount()
    {
        $this->update([
            'reply_count' => $this->replies()->count(),
            'last_reply_at' => $this->replies()->latest()->first()?->created_at ?? $this->created_at
        ]);
    }

    /**
     * Scope for open discussions
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for pinned discussions
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%");
        });
    }
}