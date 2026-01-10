@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Inbox</h6>
                    <a href="{{ route('mailbox.compose') }}" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane me-2"></i>Compose</a>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="{{ route('mailbox.index') }}" class="list-group-item list-group-item-action active">
                                <i class="fa fa-inbox me-2"></i>Inbox
                            </a>
                            <a href="{{ route('mailbox.sent') }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-share me-2"></i>Sent
                            </a>
                            <a href="{{ route('mailbox.archived') }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-archive me-2"></i>Archive
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- Search & Bulk Actions -->
                        <div class="d-flex justify-content-between mb-3">
                            <form action="{{ route('mailbox.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search mail..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fa fa-search"></i></button>
                            </form>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary me-2" onclick="submitBulkArchive()">
                                    <i class="fa fa-archive me-2"></i>Archive
                                </button>
                                <button form="bulk-delete-form" type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete selected messages?')">
                                    <i class="fa fa-trash me-2"></i>Delete
                                </button>
                            </div>
                        </div>

                        <form id="bulk-archive-form" action="{{ route('mailbox.mass-archive') }}" method="POST" class="d-none">@csrf</form>

                        <form id="bulk-delete-form" action="{{ route('mailbox.mass-destroy') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40"><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th>Sender</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($messages as $message)
                                        <tr class="{{ $message->read_at ? '' : 'fw-bold border-start border-primary border-4' }}">
                                            <td><input type="checkbox" name="ids[]" value="{{ $message->id }}" class="form-check-input message-checkbox"></td>
                                            <td>{{ $message->sender->name }}</td>
                                            <td>
                                                <a href="{{ route('mailbox.show', $message->id) }}" class="text-dark">
                                                    {{ $message->subject }}
                                                    @if($message->attachments->count() > 0)
                                                        <i class="fa fa-paperclip ms-1 text-secondary"></i>
                                                    @endif
                                                    <small class="text-muted d-block">{{ Str::limit($message->body, 50) }}</small>
                                                </a>
                                            </td>
                                            <td>{{ $message->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('mailbox.show', $message->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No messages found in inbox.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <script>
                            document.getElementById('select-all').addEventListener('change', function() {
                                document.querySelectorAll('.message-checkbox').forEach(cb => cb.checked = this.checked);
                            });

                            function submitBulkArchive() {
                                const checkboxes = document.querySelectorAll('.message-checkbox:checked');
                                if (checkboxes.length === 0) {
                                    alert('Please select at least one message to archive.');
                                    return;
                                }

                                if (!confirm('Archive selected messages?')) return;

                                const form = document.getElementById('bulk-archive-form');
                                checkboxes.forEach(cb => {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'ids[]';
                                    input.value = cb.value;
                                    form.appendChild(input);
                                });
                                form.submit();
                            }
                        </script>
                        <div class="mt-4">
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
