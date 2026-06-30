@extends('layouts.admin.master')
@section('title', 'Queue Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Front Screen Management</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Screen Management</h1>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a href="{{ route('front.screen1') }}">
            <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">Halaman Layar</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Kunjungi Halaman -></h3>
            </div>
        </a>
        <a href="{{ route('printed.ticket') }}">
            <div class="bg-white dark:bg-primary rounded-2xl p-8 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">Halaman Print Tiket </span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Kunjungi Halaman -></h3>
            </div>
        </a>
    </div>
</div>

@push('scripts')
<script>

</script>
@endpush
@endsection
