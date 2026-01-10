<?php

namespace App\Services;

use App\Models\InternalMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailboxService
{
    public function getInboxMessages($search = null)
    {
        return InternalMessage::inbox(Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%")
                      ->orWhereHas('sender', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->with('sender')
            ->latest()
            ->paginate(15);
    }

    public function getSentMessages($search = null)
    {
        return InternalMessage::sent(Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%")
                      ->orWhereHas('receiver', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->with('receiver')
            ->latest()
            ->paginate(15);
    }

    public function bulkDelete(array $ids)
    {
        $messages = InternalMessage::whereIn('id', $ids)->get();
        
        foreach ($messages as $message) {
            $this->deleteMessage($message->id);
        }
        
        return true;
    }

    public function getUnreadCount()
    {
        return InternalMessage::inbox(Auth::id())
            ->whereNull('read_at')
            ->count();
    }

    public function getLatestUnread($limit = 5)
    {
        return InternalMessage::inbox(Auth::id())
            ->whereNull('read_at')
            ->with('sender')
            ->latest()
            ->limit($limit)
            ->get();
    }



    public function sendMessage(array $data)
    {
        $message = InternalMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $data['receiver_id'],
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                // Store file in public/attachments directory
                $path = $file->store('attachments', 'public');
                
                $message->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return $message;
    }

    public function getMessage($id)
    {
        $message = InternalMessage::where(function($q) {
            $q->where('receiver_id', Auth::id())
              ->orWhere('sender_id', Auth::id());
        })->findOrFail($id);

        if ($message->receiver_id == Auth::id() && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return $message;
    }

    public function deleteMessage($id)
    {
        $message = InternalMessage::findOrFail($id);

        if ($message->sender_id == Auth::id()) {
            $message->update(['sender_deleted' => true]);
        }

        if ($message->receiver_id == Auth::id()) {
            $message->update(['receiver_deleted' => true]);
        }

        if ($message->sender_deleted && $message->receiver_deleted) {
            $message->delete();
        }

        return true;
    }

    public function getArchivedMessages($search = null)
    {
        return InternalMessage::archived(Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%")
                      ->orWhereHas('sender', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('receiver', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(15);
    }

    public function archiveMessage($id)
    {
        $message = InternalMessage::findOrFail($id);

        if ($message->sender_id == Auth::id()) {
            $message->update(['sender_archived' => true]);
        }

        if ($message->receiver_id == Auth::id()) {
            $message->update(['receiver_archived' => true]);
        }

        return true;
    }

    public function bulkArchive(array $ids)
    {
        $messages = InternalMessage::whereIn('id', $ids)->get();
        
        foreach ($messages as $message) {
            $this->archiveMessage($message->id);
        }
        
        return true;
    }

    public function getRecipients()
    {
        // For staff/admin system, they can message each other
        // Admin, Staff roles
        return User::whereIn('role', ['admin', 'staff'])
            ->where('id', '!=', Auth::id())
            ->get();
    }
}
