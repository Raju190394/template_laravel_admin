<?php

namespace App\Services;

use App\Models\AcademicSession;

class AcademicSessionService
{
    public function getAllSessions($paginate = 10)
    {
        return AcademicSession::latest()->paginate($paginate);
    }

    public function createSession(array $data, $isCurrent = false)
    {
        $session = AcademicSession::create($data);
        if ($isCurrent) {
            $this->setAsCurrent($session);
        }
        return $session;
    }

    public function updateSession(AcademicSession $session, array $data, $isCurrent = false)
    {
        $session->update($data);
        if ($isCurrent) {
            $this->setAsCurrent($session);
        }
        return $session;
    }

    public function deleteSession(AcademicSession $session)
    {
        if ($session->is_current) {
            throw new \Exception('Cannot delete the current active session.');
        }
        return $session->delete();
    }

    public function setAsCurrent(AcademicSession $session)
    {
        AcademicSession::where('id', '!=', $session->id)->update(['is_current' => false]);
        $session->update(['is_current' => true]);
    }
}
