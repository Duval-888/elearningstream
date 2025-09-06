<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'author_id',
        'reply_to_id',
        'content',
        'type',
        'attachments',
        'is_edited',
        'edited_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Get the chat that owns the message
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get the author that owns the message
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the message this is replying to
     */
    public function replyTo()
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to_id');
    }

    /**
     * Get replies to this message
     */
    public function replies()
    {
        return $this->hasMany(ChatMessage::class, 'reply_to_id');
    }

    /**
     * Boot method to update chat last_message_at
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($message) {
            $message->chat->update(['last_message_at' => $message->created_at]);
        });
    }

    /**
     * Mark message as edited
     */
    public function markAsEdited()
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now()
        ]);
    }

    /**
     * Scope for text messages
     */
    public function scopeText($query)
    {
        return $query->where('type', 'text');
    }

    /**
     * Scope for recent messages
     */
    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }
}