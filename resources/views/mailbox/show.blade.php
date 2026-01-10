@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">View Message</h6>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-arrow-left me-2"></i>Back</a>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="{{ route('mailbox.index') }}" class="list-group-item list-group-item-action {{ $message->receiver_id == Auth::id() && !$message->receiver_archived ? 'active' : '' }}">
                                <i class="fa fa-inbox me-2"></i>Inbox
                            </a>
                            <a href="{{ route('mailbox.sent') }}" class="list-group-item list-group-item-action {{ $message->sender_id == Auth::id() && !$message->sender_archived ? 'active' : '' }}">
                                <i class="fa fa-share me-2"></i>Sent
                            </a>
                            <a href="{{ route('mailbox.archived') }}" class="list-group-item list-group-item-action {{ ($message->sender_id == Auth::id() && $message->sender_archived) || ($message->receiver_id == Auth::id() && $message->receiver_archived) ? 'active' : '' }}">
                                <i class="fa fa-archive me-2"></i>Archive
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $message->subject }}</h5>
                                <span class="badge bg-secondary">{{ $message->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">From: {{ $message->sender->name }} ({{ $message->sender->email }})</div>
                                            <div class="text-muted">To: {{ $message->receiver->name }} ({{ $message->receiver->email }})</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="my-4 white-space-pre-wrap">
                                    {!! nl2br(e($message->body)) !!}
                                </div>
                                
                                @if($message->attachments->count() > 0)
                                    <h6 class="mt-4 mb-3"><i class="fa fa-paperclip me-2"></i>Attachments ({{ $message->attachments->count() }})</h6>
                                    <div class="row g-3">
                                        @foreach($message->attachments as $attachment)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="border rounded p-3 d-flex align-items-center bg-light">
                                                    <div class="me-3">
                                                        <i class="fa fa-{{ Str::contains($attachment->file_type, 'image') ? 'image' : (Str::contains($attachment->file_type, 'pdf') ? 'file-pdf' : 'file-alt') }} fa-2x text-primary"></i>
                                                    </div>
                                                    <div class="overflow-hidden">
                                                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-decoration-none text-dark fw-bold d-block text-truncate" title="{{ $attachment->file_name }}">
                                                            {{ $attachment->file_name }}
                                                        </a>
                                                        <small class="text-muted">{{ round($attachment->file_size / 1024, 1) }} KB</small>
                                                    </div>
                                                    <a href="{{ Storage::url($attachment->file_path) }}" download="{{ $attachment->file_name }}" class="ms-auto text-secondary">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('mailbox.destroy', $message->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Permanently delete this message?')">
                                                <i class="fa fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                        @if(($message->sender_id == Auth::id() && !$message->sender_archived) || ($message->receiver_id == Auth::id() && !$message->receiver_archived))
                                            <form action="{{ route('mailbox.archive', $message->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Archive this message?')">
                                                    <i class="fa fa-archive me-2"></i>Archive
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if($message->receiver_id == Auth::id())
                                        <a href="{{ route('mailbox.compose', ['reply_to' => $message->sender_id, 'subject' => 'Re: ' . $message->subject]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-reply me-2"></i>Reply
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .white-space-pre-wrap {
        white-space: pre-wrap;
        line-height: 1.6;
    }
</style>
@endsection
