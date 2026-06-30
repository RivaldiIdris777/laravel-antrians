@extends('layouts.admin.master')
@section('title', 'Client Management | Admin Panel')
@push('styles')
<style></style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Client</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Client Management</span>
</nav>

<!-- Card konten utama -->
<div class="grid grid-cols-1 md:grid-cols-4">
    @foreach($lokets as $loket)
    <a href="{{ route('client.qounter.pemanggilan', $loket->id) }}" class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl cursor-pointer">
        <i class="ti ti-user text-4xl text-primary"></i>
        <div class="flex flex-col">
            <span class="text-2xl font-semibold text-primary leading-tight">{{ $loket->nama_loket }}</span>
            <span class="text-xl text-gray-500 font-medium">{{ $loket->kode_loket }}</span>
        </div>
    </a>
    @endforeach
    @if(count($lokets) === 0)
    <div class="col-span-4 bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4">
        <p class="text-xl text-gray-500 font-medium">No lokets available</p>
    </div>
    @endif
    
</div>

@push('scripts')

@endpush
@endsection