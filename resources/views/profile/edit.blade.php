@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Profile Information</h6>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Update Password</h6>
                @include('profile.partials.update-password-form')
            </div>
        </div>
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4 border border-danger">
                <h6 class="mb-4 text-danger">Delete Account</h6>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
