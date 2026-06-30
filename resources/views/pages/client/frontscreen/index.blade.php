@extends('layouts.client.master')
@section('title', 'Front Screen | Antrians ')
@push('styles')
<style>
    .video-container {
        position: relative;
        background-color: #000;
        overflow: hidden;
        min-height: 400px;
        aspect-ratio: 16 / 9;
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

    .marquee-text {
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
    }

    .marquee-text span {
        display: inline-block;
        font-size: 1.5rem;
        font-weight: bold;
        color: #fff;
        animation: scrollText 15s linear infinite;
    }

    @keyframes scrollText {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

</style>
@endpush
@section('hero')
<!-- Main Content -->
<main class="bg-light flex-1 p-6">
    <div class="grid grid-cols-12 gap-6 h-full">

        <!-- Left Section: 8 Grid -->
        <div class="col-span-8 flex flex-col gap-6">
            <!-- Video / Banner -->
            <div class="counter-card overflow-hidden p-0">
                <div class="video-container rounded-lg h-full flex items-center justify-center relative">
                    <iframe
                        width="100%"
                        height="100%"
                        src="https://www.youtube.com/embed/fQIuP2WgJO8?autoplay=1&loop=1&playlist=fQIuP2WgJO8&controls=0&mute=1&rel=0"
                        title="Video Antrian"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="absolute inset-0 w-full h-full rounded-lg"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    </iframe>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="grid grid-cols-1 gap-4">                
                <div class="counter-card bg-primary text-center overflow-hidden">
                    <div class="marquee-text">
                        <span>Antrians — Aplikasi antrian berbasis web menggunakan Laravel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section: 4 Grid (4 Rows) -->
        <div class="col-span-4 flex flex-col gap-4">
            @foreach($antrianPerLoket as $item)
            <div class="counter-card loket-card" data-loket-id="{{ $item['loket']->id }}">
                <div>
                    <h4 class="font-bold text-gray-800">{{ $item['loket']->layanan->nama_layanan ?? 'Layanan' }}</h4>
                    <p class="text-xl text-primary font-bold nomor-antrian">
                        {{ $item['antrian_sekarang']->nomor_antrian ?? '-' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-secondary">{{ $item['loket']->nama_loket }}</p>
                    <span class="status-badge text-xs">
                        {{ $item['antrian_sekarang'] ? 'Melayani' : 'Menunggu' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</main>

@push('scripts')
<script>
    // Tunggu Echo siap (karena app.js adalah ES module, dimuat async)
    function initEchoListener(retries = 0) {
        if (window.Echo) {
            window.Echo.channel('antrian-channel')
                .listen('.antrian.dipanggil', (data) => {
                    console.log('Antrian dipanggil:', data);

                    const card = document.querySelector(`.loket-card[data-loket-id="${data.loket_id}"]`);
                    if (card) {
                        const nomorEl = card.querySelector('.nomor-antrian');
                        if (nomorEl) nomorEl.textContent = data.nomor_antrian;

                        const statusEl = card.querySelector('.status-badge');
                        if (statusEl) statusEl.textContent = 'Melayani';
                    }
                });
        } else if (retries < 25) {
            // Retry setiap 200ms, maks 5 detik
            setTimeout(() => initEchoListener(retries + 1), 200);
        } else {
            console.error('Echo tidak tersedia setelah 5 detik.');
        }
    }

    initEchoListener();
</script>
@endpush
@endsection
