@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary">Edit Staff Member</h6>
                    <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
                
                <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $staff->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $staff->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Link Login Account (Optional)</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">None</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $staff->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <div class="form-text text-info">Only users with 'staff' role appear here.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $staff->designation) }}" required>
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $staff->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Update Photo</label>
                            <div class="mb-2">
                                @if($staff->photo)
                                    <img src="{{ asset('storage/' . $staff->photo) }}" class="rounded border" width="100" height="100" style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->name) }}&background=random" class="rounded border" width="100" height="100">
                                @endif
                            </div>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                            @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $staff->address) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $staff->joining_date ? $staff->joining_date->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" step="0.01" name="salary" class="form-control" value="{{ old('salary', $staff->salary) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ $staff->is_active ? 'checked' : '' }}>
                                <label class="form-check-input-label" for="is_active">Active Staff Member</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 w-100">Update Staff Member</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
