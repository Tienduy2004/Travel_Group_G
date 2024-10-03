@extends('layouts.app')

@section('content')
<div class="container py-12 profile-page">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Cập nhật thông tin người dùng -->
            <div class="profile-card mb-4">
                <div class="profile-header">
                    <h2>Profile Information</h2>
                </div>
                <div class="profile-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Cập nhật mật khẩu -->
            <div class="profile-card mb-4">
                <div class="profile-header" style="background-color: #eeda6f;">
                    <h2>Update Password</h2>
                </div>
                <div class="profile-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Xóa tài khoản -->
            <div class="profile-card mb-4">
                <div class="profile-header" style="background-color: #ee3e3e;">
                    <h2>Delete Account</h2>
                </div>
                <div class="profile-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
