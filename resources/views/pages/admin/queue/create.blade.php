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

<!-- Alert -->
@if(session('success'))
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-circle-check text-green-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">{{ session('success') }}</span>
        <button type="button" class="text-green-400 hover:text-green-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-alert-circle text-red-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">{{ session('error') }}</span>
        <button type="button" class="text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="flex items-center gap-3 p-4 mb-6 text-sm text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm" role="alert">
        <i class="ti ti-alert-triangle text-yellow-500 text-lg flex-shrink-0"></i>
        <span class="flex-1">Terdapat {{ $errors->count() }} kesalahan pada form. Silakan periksa kembali.</span>
        <button type="button" class="text-yellow-400 hover:text-yellow-600 transition-colors" onclick="this.parentElement.remove()">
            <i class="ti ti-x text-base"></i>
        </button>
    </div>
@endif

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">    
    <!-- Form untuk membuat antrian baru -->
    <form action="{{ route('antrians.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nama Antrian (Select Option A-Z) -->
            <div>
                <label for="nama_antrian" class="block text-sm font-semibold text-gray-700 mb-2">
                    Alfabet <span class="text-red-500">*</span>
                </label>
                <select name="nama_antrian" id="nama_antrian" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200">
                    <option value="">Pilih Alfabet</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                    <option value="H">H</option>
                    <option value="I">I</option>
                    <option value="J">J</option>
                    <option value="K">K</option>
                    <option value="L">L</option>
                    <option value="M">M</option>
                    <option value="N">N</option>
                    <option value="O">O</option>
                    <option value="P">P</option>
                    <option value="Q">Q</option>
                    <option value="R">R</option>
                    <option value="S">S</option>
                    <option value="T">T</option>
                    <option value="U">U</option>
                    <option value="V">V</option>
                    <option value="W">W</option>
                    <option value="X">X</option>
                    <option value="Y">Y</option>
                    <option value="Z">Z</option>
                </select>
            </div>

            <!-- Jumlah Banyak Antrian -->
            <div>
                <label for="jumlah_antrian" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jumlah Antrian <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah_antrian" id="jumlah_antrian" required
                       min="1" max="100" value="1"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200">
                <p class="text-xs text-gray-500 mt-1">Maksimal 100 antrian</p>
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Penjaga Loket <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" id="nama" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200"
                       placeholder="Masukkan nama penjaga loket">
            </div>

            <!-- Layanan (dari relasi) -->
            <div>
                <label for="layanan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Layanan <span class="text-red-500">*</span>
                </label>
                <select name="layanan_id" id="layanan_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200">
                    <option value="">Pilih Layanan</option>                  
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                        @endforeach                                                            
                </select>
                
            </div>

            <!-- Loket (dari relasi) -->
            <div>
                <label for="loket_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Loket <span class="text-red-500">*</span>
                </label>
                <select name="loket_id" id="loket_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200">
                    <option value="">Pilih Loket</option>                    
                        @foreach($lokets as $loket)
                            <option value="{{ $loket->id }}">{{ $loket->nama_loket }}</option>
                        @endforeach                                                            
                </select>                
            </div>

            <!-- Status (default: menunggu) -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status
                </label>
                <select name="status" id="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand transition-all duration-200">
                    <option value="menunggu" selected>Menunggu</option>
                    <option value="dipanggil">Dipanggil</option>
                    <option value="selesai">Selesai</option>
                </select>
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