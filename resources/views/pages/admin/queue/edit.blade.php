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
    <span class="text-gray-600 font-medium">Antrian</span>
</nav>
    
<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">Antrian</h1>
    <a href="{{ route('antrians.index') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <!-- Form Edit Antrian -->
    @if(isset($antrian) && $antrian)
    <div class="mb-8 border-b border-gray-200 pb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Antrian</h2>
        
        <form action="{{ route('antrians.update', $antrian->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nomor Antrian -->
                <div>
                    <label for="nomor_antrian" class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Antrian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nomor_antrian" 
                           id="nomor_antrian" 
                           value="{{ old('nomor_antrian', $antrian->nomor_antrian) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('nomor_antrian') border-red-500 @enderror"
                           placeholder="Masukkan nomor antrian">
                    @error('nomor_antrian')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $antrian->nama) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('nama') border-red-500 @enderror"
                           placeholder="Masukkan nama">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Layanan ID -->
                <div>
                    <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Layanan <span class="text-red-500">*</span>
                    </label>
                    <select name="layanan_id" 
                            id="layanan_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('layanan_id') border-red-500 @enderror">
                        <option value="">Pilih Layanan</option>
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->id }}" {{ old('layanan_id', $antrian->layanan_id) == $layanan->id ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loket ID -->
                <div>
                    <label for="loket_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Loket <span class="text-red-500">*</span>
                    </label>
                    <select name="loket_id" 
                            id="loket_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('loket_id') border-red-500 @enderror">
                        <option value="">Pilih Loket</option>
                        @foreach($lokets as $loket)
                            <option value="{{ $loket->id }}" {{ old('loket_id', $antrian->loket_id) == $loket->id ? 'selected' : '' }}>
                                {{ $loket->nama_loket }}
                            </option>
                        @endforeach
                    </select>
                    @error('loket_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="menunggu" {{ old('status', $antrian->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="dipanggil" {{ old('status', $antrian->status) == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                        <option value="selesai" {{ old('status', $antrian->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <!-- Tombol Submit -->
            <div class="flex gap-2 pt-4">
                <button type="submit" 
                        class="px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-dark transition-colors focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2">
                    <i class="ti ti-device-floppy mr-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('antrians.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="ti ti-x mr-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
    @endif        
</div>

@endsection