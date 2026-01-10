<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'read_at',
        'sender_deleted',
        'receiver_deleted',
        'sender_archived',
        'receiver_archived',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'sender_deleted' => 'boolean',
        'receiver_deleted' => 'boolean',
        'sender_archived' => 'boolean',
        'receiver_archived' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeInbox($query, $userId)
    {
        return $query->where('receiver_id', $userId)
                     ->where('receiver_deleted', false)
                     ->where('receiver_archived', false); // Exclude archived
    }

    public function scopeSent($query, $userId)
    {
        return $query->where('sender_id', $userId)
                     ->where('sender_deleted', false)
                     ->where('sender_archived', false); // Exclude archived
    }

    public function scopeArchived($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('receiver_id', $userId)
              ->where('receiver_archived', true)
              ->where('receiver_deleted', false);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('sender_archived', true)
              ->where('sender_deleted', false);
        });
    }

    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class, 'internal_message_id');
    }
}
