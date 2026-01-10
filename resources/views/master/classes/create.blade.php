@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary">
                        <i class="fa fa-{{ isset($class) ? 'edit' : 'plus' }} me-2"></i>
                        {{ isset($class) ? 'Edit' : 'Add New' }} Class
                    </h6>
                    <a href="{{ route('master.classes.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i>Please correct the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ isset($class) ? route('master.classes.update', $class) : route('master.classes.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($class))
                        @method('PUT')
                    @endif

                    <div class="row g-2">
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('class_name') is-invalid @enderror" 
                                       id="class_name" name="class_name" 
                                       value="{{ old('class_name', $class->class_name ?? '') }}" 
                                       placeholder="Class Name" required>
                                <label for="class_name">Class Name <span class="text-danger">*</span></label>
                                <div class="form-text">E.g., Class 1, Class 10, Nursery, LKG, UKG</div>
                                @error('class_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('section') is-invalid @enderror" 
                                       id="section" name="section" 
                                       value="{{ old('section', $class->section ?? '') }}" 
                                       placeholder="Section">
                                <label for="section">Section</label>
                                <div class="form-text">E.g., A, B, C</div>
                                @error('section')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" name="capacity" 
                               value="{{ old('capacity', $class->capacity ?? '') }}" 
                               placeholder="Capacity" min="1">
                        <label for="capacity">Maximum Capacity</label>
                        <div class="form-text">Maximum number of students</div>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $class->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Status (Classes marked as inactive will not be available for new admissions)
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" 
                                  placeholder="Description" style="height: 100px;">{{ old('description', $class->description ?? '') }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="reset" class="btn btn-light me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>{{ isset($class) ? 'Update' : 'Create' }} Class
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
