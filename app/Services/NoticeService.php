<?php

namespace App\Services;

use App\Models\Notice;

class NoticeService
{
    public function getAllNotices($paginate = 10)
    {
        return Notice::latest()->paginate($paginate);
    }

    public function createNotice(array $data)
    {
        return Notice::create($data);
    }

    public function updateNotice(Notice $notice, array $data)
    {
        $notice->update($data);
        return $notice;
    }

    public function deleteNotice(Notice $notice)
    {
        return $notice->delete();
    }
}
