@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-10">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary">
                        <i class="fa fa-{{ isset($schoolSetting) ? 'edit' : 'plus' }} me-2"></i>
                        {{ isset($schoolSetting) ? 'Edit' : 'Add' }} School Settings
                    </h6>
                    <a href="{{ route('master.school-settings.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i>Please correct the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ isset($schoolSetting) ? route('master.school-settings.update', $schoolSetting) : route('master.school-settings.store') }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($schoolSetting))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-secondary mb-3"><i class="fa fa-info-circle me-2"></i>Basic Information</h6>
                            
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" 
                                       value="{{ old('school_name', $schoolSetting->school_name ?? '') }}" 
                                       placeholder="School Name" required>
                                <label for="school_name">School Name <span class="text-danger">*</span></label>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" 
                                               value="{{ old('email', $schoolSetting->email ?? '') }}" 
                                               placeholder="Email">
                                        <label for="email">Email</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" 
                                               value="{{ old('phone', $schoolSetting->phone ?? '') }}" 
                                               placeholder="Phone">
                                        <label for="phone">Phone</label>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                       id="website" name="website" 
                                       value="{{ old('website', $schoolSetting->website ?? '') }}" 
                                       placeholder="Website URL">
                                <label for="website">Website URL</label>
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="text-secondary mb-3 mt-4"><i class="fa fa-map-marker-alt me-2"></i>Address Details</h6>
                            
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" 
                                          placeholder="Address" style="height: 100px;">{{ old('address', $schoolSetting->address ?? '') }}</textarea>
                                <label for="address">Address</label>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" 
                                               value="{{ old('city', $schoolSetting->city ?? '') }}" 
                                               placeholder="City">
                                        <label for="city">City</label>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                               id="state" name="state" 
                                               value="{{ old('state', $schoolSetting->state ?? '') }}" 
                                               placeholder="State">
                                        <label for="state">State</label>
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                                               id="pincode" name="pincode" 
                                               value="{{ old('pincode', $schoolSetting->pincode ?? '') }}" 
                                               placeholder="Pincode">
                                        <label for="pincode">Pincode</label>
                                        @error('pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-secondary mb-3 mt-4"><i class="fa fa-share-alt me-2"></i>Social Media Links</h6>
                            
                            <div class="form-floating mb-3">
                                <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" 
                                       id="youtube_link" name="youtube_link" 
                                       value="{{ old('youtube_link', $schoolSetting->youtube_link ?? '') }}" 
                                       placeholder="YouTube Link">
                                <label for="youtube_link"><i class="fab fa-youtube text-danger me-2"></i>YouTube Channel</label>
                                @error('youtube_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="url" class="form-control @error('facebook_link') is-invalid @enderror" 
                                       id="facebook_link" name="facebook_link" 
                                       value="{{ old('facebook_link', $schoolSetting->facebook_link ?? '') }}" 
                                       placeholder="Facebook Link">
                                <label for="facebook_link"><i class="fab fa-facebook text-primary me-2"></i>Facebook Page</label>
                                @error('facebook_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="url" class="form-control @error('instagram_link') is-invalid @enderror" 
                                       id="instagram_link" name="instagram_link" 
                                       value="{{ old('instagram_link', $schoolSetting->instagram_link ?? '') }}" 
                                       placeholder="Instagram Link">
                                <label for="instagram_link"><i class="fab fa-instagram text-danger me-2"></i>Instagram Profile</label>
                                @error('instagram_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" 
                                          placeholder="Description" style="height: 100px;">{{ old('description', $schoolSetting->description ?? '') }}</textarea>
                                <label for="description">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h6 class="text-secondary mb-3"><i class="fa fa-image me-2"></i>School Logo</h6>
                            
                            @if(isset($schoolSetting) && $schoolSetting->logo)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/' . $schoolSetting->logo) }}" 
                                         alt="Current Logo" class="img-fluid rounded border" 
                                         style="max-height: 200px;">
                                    <p class="text-muted small mt-2">Current Logo</p>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*">
                                <div class="form-text">Accepted formats: JPG, PNG, GIF, SVG. Max size: 2MB</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="fa fa-info-circle me-2"></i>
                                <small>
                                    <strong>Tips:</strong><br>
                                    - Use a square or rectangular logo<br>
                                    - Recommended size: 500x500 pixels<br>
                                    - Transparent background preferred
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="reset" class="btn btn-light me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>{{ isset($schoolSetting) ? 'Update' : 'Create' }} Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
