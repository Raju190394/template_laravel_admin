<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

use App\Http\Requests\NoticeStoreRequest;
use App\Services\NoticeService;

class NoticeController extends Controller
{
    protected $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    public function index()
    {
        $notices = $this->noticeService->getAllNotices();
        return view('master.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('master.notices.create');
    }

    public function store(NoticeStoreRequest $request)
    {
        $this->noticeService->createNotice($request->validated());
        return redirect()->route('master.notices.index')->with('success', 'Notice created successfully.');
    }

    public function edit(Notice $notice)
    {
        return view('master.notices.edit', compact('notice'));
    }

    public function update(NoticeStoreRequest $request, Notice $notice)
    {
        $this->noticeService->updateNotice($notice, $request->validated());
        return redirect()->route('master.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $this->noticeService->deleteNotice($notice);
        return redirect()->route('master.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
