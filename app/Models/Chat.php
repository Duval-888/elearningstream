<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'course_id',
        'participants',
        'last_message_at',
        'is_active'
    ];

    protected $casts = [
        'participants' => 'array',
        'last_message_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the course that owns the chat
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get chat messages
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Get chat participants
     */
    public function chatParticipants()
    {
        return $this->hasMany(ChatParticipant::class);
    }

    /**
     * Get participant users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_participants')
                   ->withPivot('joined_at', 'last_read_at', 'is_active')
                   ->withTimestamps();
    }

    /**
     * Get latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    /**
     * Add participant to chat
     */
    public function addParticipant(User $user)
    {
        $this->chatParticipants()->create([
            'user_id' => $user->id,
            'joined_at' => now(),
        ]);

        // Update participants array
        $participants = $this->participants ?? [];
        if (!in_array($user->id, $participants)) {
            $participants[] = $user->id;
            $this->update(['participants' => $participants]);
        }
    }

    /**
     * Remove participant from chat
     */
    public function removeParticipant(User $user)
    {
        $this->chatParticipants()->where('user_id', $user->id)->delete();

        // Update participants array
        $participants = $this->participants ?? [];
        $participants = array_filter($participants, fn($id) => $id !== $user->id);
        $this->update(['participants' => array_values($participants)]);
    }

    /**
     * Check if user is participant
     */
    public function hasParticipant(User $user)
    {
        return in_array($user->id, $this->participants ?? []);
    }

    /**
     * Scope for active chats
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for user chats
     */
    public function scopeForUser($query, User $user)
    {
        return $query->whereJsonContains('participants', $user->id);
    }
}