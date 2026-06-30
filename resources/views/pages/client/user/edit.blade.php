@extends('layouts.admin.master')
@section('title', 'Edit Profil | Dashboard')
@push('styles')
<style>
    .profile-card {
        transition: all 0.3s ease;
    }
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <a href="{{ route('client.profile.index') }}" class="hover:text-brand transition-colors">Profil Saya</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Edit Profil</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Edit Profil</h1>
    <a href="{{ route('client.profile.index') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>

@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
        <ul class="list-disc pl-4 text-sm text-red-600 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    @if (session('success'))
    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif
    
<!-- Form Edit Profile -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <form action="{{ route('client.profile.update') }}" method="POST">
        @csrf
        @method('PUT')            

        <!-- Body form -->
        <div class="p-6 space-y-5">
            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                    placeholder="Masukkan nama lengkap" required>
            </div>

            <!-- Email (read-only) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" value="{{ $user->email }}"
                    class="block w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed"
                    disabled readonly>
                <p class="mt-1 text-xs text-gray-400">Email tidak dapat diubah.</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                    placeholder="Kosongkan jika tidak ingin mengubah password">
                <p class="mt-1 text-xs text-gray-400">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                    placeholder="Ulangi password baru">
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('client.profile.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                Batal
            </a>
            <button type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-all">
                <i class="ti ti-device-floppy"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>


@endsection
