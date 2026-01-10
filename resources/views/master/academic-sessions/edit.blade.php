@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <h6 class="mb-4">Edit Academic Session</h6>
        <form action="{{ route('master.academic-sessions.update', $academicSession->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Session Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $academicSession->name }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $academicSession->start_date->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $academicSession->end_date->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_current" name="is_current" value="1" {{ $academicSession->is_current ? 'checked' : '' }}>
                <label class="form-check-label" for="is_current">Set as Current Session</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Session</button>
            <a href="{{ route('master.academic-sessions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
