@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <h6 class="mb-4">Post New Notice</h6>
        <form action="{{ route('master.notices.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Notice Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Target Audience</label>
                <select name="target" class="form-select">
                    <option value="All">All</option>
                    <option value="Students">Students</option>
                    <option value="Staff">Staff</option>
                    <option value="Parents">Parents</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Notice Content</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label class="form-check-label" for="is_active">Publish immediately</label>
            </div>
            <button type="submit" class="btn btn-primary">Publish Notice</button>
            <a href="{{ route('master.notices.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
