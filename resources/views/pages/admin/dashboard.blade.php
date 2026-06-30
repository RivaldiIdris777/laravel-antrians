@extends('layouts.admin.master')
@section('title', 'Dashboard | Admin Panel')
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Dashboard</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Dashboard</h1>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card Data -->
        <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
            <div class="flex items-center justify-between mb-4">
                <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $jumlahLayanan }}</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Layanan</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Total layanan yang tersedia</p>
        </div>
        <div class="bg-white dark:bg-secondary rounded-2xl p-8 card-hover">
            <div class="flex items-center justify-between mb-4">
                <span class="text-3xl font-bold text-gray-900 dark:text-primary">{{ $jumlahLoket }}</span>
            </div>
            <h3 class="text-lg font-semibold text-primary dark:text-primary">Konter</h3>
            <p class="text-sm text-primary dark:text-primary mt-2">Total konter/loket pelayanan</p>
        </div>
        <div class="bg-white dark:bg-gray-200 rounded-2xl p-8 card-hover">
            <div class="flex items-center justify-between mb-4">
                <span class="text-3xl font-bold text-primary dark:text-primary">{{ $jumlahAntrian }}</span>
            </div>
            <h3 class="text-lg font-semibold text-primary dark:text-primary">Antrian</h3>
            <p class="text-sm text-primary dark:text-primary mt-2">Total antrian hari ini</p>
        </div>
    </div>
</div>

@endsection
