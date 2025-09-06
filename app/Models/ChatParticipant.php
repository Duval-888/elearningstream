<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'joined_at',
        'last_read_at',
        'is_active'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'last_read_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the chat
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead()
    {
        $this->update(['last_read_at' => now()]);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCountAttribute()
    {
        $lastReadAt = $this->last_read_at ?? $this->joined_at;
        
        return $this->chat->messages()
                         ->where('created_at', '>', $lastReadAt)
                         ->where('author_id', '!=', $this->user_id)
                         ->count();
    }

    /**
     * Scope for active participants
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}