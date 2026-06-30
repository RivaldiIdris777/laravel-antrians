@extends('layouts.admin.master')
@section('title', 'Loket Management | Admin Panel')
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
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        ring: 2px solid #3b82f6;
    }
    .btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
    }
    .btn-primary:hover {
        background-color: #2563eb;
    }
    .btn-secondary {
        background-color: #9ca3af;
        color: white;
        border: none;
    }
    .btn-secondary:hover {
        background-color: #6b7280;
    }
    .alert-danger {
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .invalid-feedback {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
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
    <h1 class="text-[22px] font-bold text-gray-800">Edit Loket</h1>
    <a href="{{ route('lokets.index') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        
        <!-- Form Edit Loket -->
        <form action="{{ route('lokets.update', $loket->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Menampilkan error validasi -->
            @if ($errors->any())
                <div class="alert-danger">
                    <ul class="mb-0 pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="form-row">
                <!-- Nama Loket -->
                <div class="form-group">
                    <label for="nama_loket" class="form-label">Nama Loket <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama_loket" 
                        id="nama_loket" 
                        class="form-control @error('nama_loket') is-invalid @enderror"
                        value="{{ old('nama_loket', $loket->nama_loket) }}"
                        placeholder="Masukkan nama loket"
                    >
                    @error('nama_loket')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kode Loket -->
                <div class="form-group">
                    <label for="kode_loket" class="form-label">Kode Loket <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="kode_loket" 
                        id="kode_loket" 
                        class="form-control @error('kode_loket') is-invalid @enderror"
                        value="{{ old('kode_loket', $loket->kode_loket) }}"
                        placeholder="Masukkan kode loket"
                    >
                    @error('kode_loket')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Layanan -->
            <div class="form-group">
                <label for="layanan_id" class="form-label">Layanan <span class="text-red-500">*</span></label>
                <select 
                    name="layanan_id"
                    id="layanan_id"
                    class="form-control @error('layanan_id') is-invalid @enderror"
                >
                    <option value="">Pilih Layanan</option>
                    @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('layanan_id', $loket->layanan_id) == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }} ({{ $layanan->kode_layanan }})
                        </option>
                    @endforeach
                </select>
                @error('layanan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Status dengan Select Option -->
            <div class="form-group">
                <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                <select 
                    name="status" 
                    id="status" 
                    class="form-control @error('status') is-invalid @enderror"
                >
                    <option value="">Pilih Status</option>
                    <option value="buka" {{ old('status', $loket->status) == 'buka' ? 'selected' : '' }}>Buka</option>
                    <option value="tutup" {{ old('status', $loket->status) == 'tutup' ? 'selected' : '' }}>Tutup</option>
                    <option value="istirahat" {{ old('status', $loket->status) == 'istirahat' ? 'selected' : '' }}>Istirahat</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Tombol aksi -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Loket</button>
                <a href="{{ route('lokets.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
        
    </div>
</div>

@push('scripts')
<script>
    // Optional: Tambahkan JavaScript untuk konfirmasi sebelum update
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('Apakah Anda yakin ingin mengupdate data loket ini?')) {
            e.preventDefault();
        }
    });
</script>
@endpush
@endsection