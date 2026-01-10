@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Compose Message</h6>
                    <a href="{{ route('mailbox.index') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-arrow-left me-2"></i>Back to Inbox</a>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="{{ route('mailbox.index') }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-inbox me-2"></i>Inbox
                            </a>
                            <a href="{{ route('mailbox.sent') }}" class="list-group-item list-group-item-action">
                                <i class="fa fa-share me-2"></i>Sent
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form action="{{ route('mailbox.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="receiver_id" class="form-label">To:</label>
                                <select name="receiver_id" id="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                                    <option value="">Select Recipient</option>
                                    @foreach($recipients as $recipient)
                                        <option value="{{ $recipient->id }}" {{ Request::get('reply_to') == $recipient->id || old('receiver_id') == $recipient->id ? 'selected' : '' }}>
                                            {{ $recipient->name }} ({{ ucfirst($recipient->role) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('receiver_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject:</label>
                                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ Request::get('subject') ?? old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="body" class="form-label">Message:</label>
                                <textarea name="body" id="body" rows="10" class="form-control @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attachments:</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments') is-invalid @enderror" multiple>
                                @error('attachments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Allowed files: PDF, Images, Word, Excel, ZIP. Max 10MB each.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4"><i class="fa fa-paper-plane me-2"></i>Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
