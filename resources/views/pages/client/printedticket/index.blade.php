@extends('layouts.client.master')
@section('title', 'Front Screen | Antrians ')
@push('styles')
<style>
    .video-container {
        position: relative;
        background-color: #000;
        overflow: hidden;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .play-button:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background-color: #f1c40f;
    }

    .play-button::after {
        content: '';
        width: 0;
        height: 0;
        border-left: 25px solid #192a56;
        border-top: 15px solid transparent;
        border-bottom: 15px solid transparent;
        margin-left: 5px;
    }

    .counter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .counter-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

</style>
@endpush
@section('hero')
<!-- Main Content -->
<main class="bg-light p-6 h-full flex-1 flex">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 h-full w-full">
        @forelse($lokets as $loket)
        <a href="{{ route('printed.ticket.cetak', $loket->id) }}" class="counter-card bg-primary text-center cursor-pointer" target="_blank">
            <p class="text-xl text-light">Loket Antrian</p>
            <p class="text-3xl font-bold primary-text">{{ $loket->nama_loket }}</p>
            <p class="text-3xl font-bold primary-text">{{ $loket->layanan->nama_layanan }}</p>
            <p class="text-xl text-light">Cetak Antrian</p>
        </a>
        @empty
        <div class="counter-card bg-primary flex flex-col items-center justify-center text-center">                        
            <p class="text-3xl font-bold primary-text">Loket Belum Tersedia. Silahkan Ajukan Loket ke Layanan</p>            
        </div>
        @endforelse      
    </div>
</main>

@push('scripts')
<script>
    // Update jam real-time
    function updateClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const dateStr = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('currentTime').textContent = dateStr + ' ' + timeStr;
    }
    updateClock();
    setInterval(updateClock, 1000);

</script>
@endpush
@endsection
