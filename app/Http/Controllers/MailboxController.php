<?php

namespace App\Http\Controllers;

use App\Http\Requests\Mailbox\MessageStoreRequest;
use App\Services\MailboxService;
use Illuminate\Http\Request;

class MailboxController extends Controller
{
    protected $mailboxService;

    public function __construct(MailboxService $mailboxService)
    {
        $this->mailboxService = $mailboxService;
    }

    public function getUnreadData()
    {
        return response()->json([
            'count' => $this->mailboxService->getUnreadCount(),
            'messages' => $this->mailboxService->getLatestUnread(),
        ]);
    }

    public function index(Request $request)
    {
        $messages = $this->mailboxService->getInboxMessages($request->search);
        return view('mailbox.index', compact('messages'));
    }

    public function sent(Request $request)
    {
        $messages = $this->mailboxService->getSentMessages($request->search);
        return view('mailbox.sent', compact('messages'));
    }

    public function create()
    {
        $recipients = $this->mailboxService->getRecipients();
        return view('mailbox.compose', compact('recipients'));
    }

    public function store(MessageStoreRequest $request)
    {
        $this->mailboxService->sendMessage($request->validated());
        return redirect()->route('mailbox.sent')->with('success', 'Message sent successfully.');
    }

    public function show($id)
    {
        $message = $this->mailboxService->getMessage($id);
        return view('mailbox.show', compact('message'));
    }

    public function destroy($id)
    {
        $this->mailboxService->deleteMessage($id);
        return redirect()->back()->with('success', 'Message deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:internal_messages,id'
        ]);

        $this->mailboxService->bulkDelete($request->ids);
        return redirect()->back()->with('success', 'Selected messages deleted successfully.');
    }

    public function archived(Request $request)
    {
        $messages = $this->mailboxService->getArchivedMessages($request->search);
        return view('mailbox.archived', compact('messages'));
    }

    public function archive($id)
    {
        $this->mailboxService->archiveMessage($id);
        return redirect()->back()->with('success', 'Message archived successfully.');
    }

    public function massArchive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:internal_messages,id'
        ]);

        $this->mailboxService->bulkArchive($request->ids);
        return redirect()->back()->with('success', 'Selected messages archived successfully.');
    }
}
