@extends('layouts.admin.master')
@section('title', 'Profile Saya | Dashboard')
@push('styles')
<style>
    .profile-card {
        transition: all 0.3s ease;
    }
    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Profile Saya</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Profil Saya</h1>
    <a href="{{ route('client.profile.edit') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all">
        <i class="ti ti-edit"></i>
        Edit Profil
    </a>
</div>

@if (session('success'))
<div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
    {{ session('success') }}
</div>
@endif

<!-- Card Profile -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <!-- Detail informasi -->
        <div class="p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Informasi Akun</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm text-gray-500">Nama Lengkap</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->name }}</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm text-gray-500">Email</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm text-gray-500">Role</span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600">
                        {{ $user->role }}
                    </span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm text-gray-500">Status Verifikasi</span>
                    @if ($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600">
                            <i class="ti ti-circle-check"></i>
                            Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-600">
                            <i class="ti ti-circle-x"></i>
                            Belum Verifikasi
                        </span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Bergabung Sejak</span>
                    <span class="text-sm font-medium text-gray-800">
                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>
</div>

@endsection
