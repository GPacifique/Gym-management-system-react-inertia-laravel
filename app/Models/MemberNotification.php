<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberNotification extends Model
{
    use HasFactory;

    protected $table = 'member_notifications';

    protected $fillable = [
        'member_id',
        'title',
        'message',
        'type',
        'is_read',
        'sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
    ];

    /**
     * Member receiving notification
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
        ]);
    }
}