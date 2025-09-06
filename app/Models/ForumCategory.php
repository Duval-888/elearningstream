<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'color',
        'permissions',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get discussions in this category
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'category_id');
    }

    /**
     * Get discussion count
     */
    public function getDiscussionCountAttribute()
    {
        return $this->discussions()->count();
    }

    /**
     * Get message count
     */
    public function getMessageCountAttribute()
    {
        return $this->discussions()
                   ->withCount('replies')
                   ->get()
                   ->sum('replies_count') + $this->discussions()->count();
    }

    /**
     * Get last message
     */
    public function getLastMessageAttribute()
    {
        $lastDiscussion = $this->discussions()
                              ->latest('last_reply_at')
                              ->first();
        
        if (!$lastDiscussion) {
            return null;
        }

        $lastReply = $lastDiscussion->replies()->latest()->first();
        
        return $lastReply ?: $lastDiscussion;
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered categories
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}