@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-school me-2"></i>School Settings</h6>
                    @if(!$settings)
                        <a href="{{ route('master.school-settings.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus me-1"></i>Add School Details
                        </a>
                    @else
                        <a href="{{ route('master.school-settings.edit', $settings->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-edit me-1"></i>Edit Settings
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($settings)
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    @if($settings->logo)
                                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="School Logo" class="img-fluid mb-3" style="max-height: 150px;">
                                    @else
                                        <div class="bg-light rounded p-5 mb-3">
                                            <i class="fa fa-school fa-4x text-muted"></i>
                                        </div>
                                    @endif
                                    <h5 class="text-primary">{{ $settings->school_name }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="fa fa-info-circle me-2"></i>Basic Information
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>School Name:</strong></div>
                                        <div class="col-md-8">{{ $settings->school_name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Email:</strong></div>
                                        <div class="col-md-8">{{ $settings->email ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Phone:</strong></div>
                                        <div class="col-md-8">{{ $settings->phone ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Website:</strong></div>
                                        <div class="col-md-8">
                                            @if($settings->website)
                                                <a href="{{ $settings->website }}" target="_blank">{{ $settings->website }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-info text-white">
                                    <i class="fa fa-map-marker-alt me-2"></i>Address Details
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Address:</strong></div>
                                        <div class="col-md-8">{{ $settings->address ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>City:</strong></div>
                                        <div class="col-md-8">{{ $settings->city ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>State:</strong></div>
                                        <div class="col-md-8">{{ $settings->state ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Pincode:</strong></div>
                                        <div class="col-md-8">{{ $settings->pincode ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <i class="fa fa-share-alt me-2"></i>Social Media Links
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>YouTube:</strong></div>
                                        <div class="col-md-8">
                                            @if($settings->youtube_link)
                                                <a href="{{ $settings->youtube_link }}" target="_blank" class="text-danger">
                                                    <i class="fab fa-youtube me-1"></i>View Channel
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Facebook:</strong></div>
                                        <div class="col-md-8">
                                            @if($settings->facebook_link)
                                                <a href="{{ $settings->facebook_link }}" target="_blank" class="text-primary">
                                                    <i class="fab fa-facebook me-1"></i>View Page
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Instagram:</strong></div>
                                        <div class="col-md-8">
                                            @if($settings->instagram_link)
                                                <a href="{{ $settings->instagram_link }}" target="_blank" class="text-danger">
                                                    <i class="fab fa-instagram me-1"></i>View Profile
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($settings->description)
                                <div class="card border-0 shadow-sm mt-3">
                                    <div class="card-header bg-secondary text-white">
                                        <i class="fa fa-align-left me-2"></i>Description
                                    </div>
                                    <div class="card-body">
                                        {{ $settings->description }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-school fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No school settings configured yet</h5>
                        <p class="text-muted">Please add school details to get started</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
