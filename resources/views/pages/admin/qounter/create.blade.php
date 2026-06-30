@extends('layouts.admin.master')
@section('title', 'Qounter Management | Admin Panel')
@push('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Loket</span>
</nav>
    
<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Buat Loket</h1>
    <a href="{{ route('lokets.index') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">    
    <!-- Form untuk membuat antrian baru -->
    <form action="{{ route('lokets.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">                        
            <div class="form-group">
                <label for="layanan_id" class="form-label">Layanan <span class="text-red-500">*</span></label>
                <select 
                    name="layanan_id"
                    id="layanan_id"
                    class="form-control @error('layanan_id') is-invalid @enderror"
                >
                    <option value="">Pilih Layanan</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }} ({{ $layanan->kode_layanan }})
                        </option>
                    @endforeach
                </select>
                @error('layanan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="jumlah_loket" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Loket <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah_loket" id="jumlah_loket" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200"
                       placeholder="Masukkan nomor loket">
            </div>            
        </div>

        <!-- Tombol Submit -->
        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-dark transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                <i class="ti ti-device-floppy mr-2"></i>
                Simpan Antrian
            </button>
            <button type="reset"
                    class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all duration-200 font-medium">
                <i class="ti ti-refresh mr-2"></i>
                Reset
            </button>
        </div>
    </form>
</div>

@endsection