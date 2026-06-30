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
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4">
        <i class="ti ti-users text-4xl text-yellow-500"></i>
        <div class="flex flex-col">
            <span class="text-3xl font-semibold text-yellow-500 leading-tight">{{ $antrians->count() }}</span>
            <span class="text-sm text-gray-500 font-medium">Jumlah Antrian</span>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4 cursor-pointer hover:bg-green-50 transition-colors btn-panggil-sekarang"
        data-nomor="{{ $antrianSekarang->nomor_antrian ?? '' }}"
        data-layanan="{{ $antrianSekarang->layanan->suara_panggilan ?? '' }}"
        data-layanan-loket="{{ $antrianSekarang->loket->layanan->suara_panggilan ?? '' }}"
        data-loket="{{ $antrianSekarang->loket->nama_loket ?? '' }}">
        <i class="ti ti-user-check text-4xl text-green-600"></i>
        <div class="flex flex-col">
            <span class="text-3xl font-semibold text-green-600 leading-tight">{{ $antrianSekarang->nomor_antrian ?? '-' }}</span>
            <span class="text-sm text-gray-500 font-medium">Antrian Sekarang</span>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4 card-selanjutnya">
        <i class="ti ti-user-plus text-4xl text-blue-600"></i>
        <div class="flex flex-col">
            <span class="text-3xl font-semibold text-blue-600 leading-tight">{{ $antrianSelanjutnya->nomor_antrian ?? '-' }}</span>
            <span class="text-sm text-gray-500 font-medium">Antrian Selanjutnya</span>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm m-1 flex items-center justify-center gap-4 card-sisa">
        <i class="ti ti-user text-4xl text-orange-700"></i>
        <div class="flex flex-col">
            <span class="text-3xl font-semibold text-orange-700 leading-tight">{{ $sisaAntrian }}</span>
            <span class="text-sm text-gray-500 font-medium">Sisa Antrian</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 p-2 shadow-sm mt-2">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50 text-xs uppercase font-medium text-gray-700 tracking-wider border-b border-gray-200">
                <tr>                    
                    <th scope="col" class="px-6 py-4 text-center">No. Antrian</th>
                    <th scope="col" class="px-6 py-4 text-center">Loket</th>
                    <th scope="col" class="px-6 py-4 text-center">Panggil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($antrians as $antrian)
                <tr>                    
                    <td class="px-6 py-4 text-center">{{ $antrian->nomor_antrian }}</td>
                    <td class="px-6 py-4 text-center">{{ $antrian->loket?->nama_loket ?? 'Belum Ditentukan' }}</td>
                    <td class="px-6 py-4 text-center">
                        <button type="button"
                            data-antrian-id="{{ $antrian->id }}"
                            data-nomor="{{ $antrian->nomor_antrian }}"
                            data-layanan="{{ $antrian->layanan->suara_panggilan ?? '' }}"
                            data-layanan-loket="{{ $antrian->loket->layanan->suara_panggilan ?? '' }}"
                            data-loket="{{ $antrian->loket->nama_loket }}"
                            class="btn-panggil inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                            <i class="ti ti-microphone text-lg"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <!-- Kondisi Jika Tidak Ada Data -->
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                            Tidak ada data dari antrian loket tersebut.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>    
</div>


@push('scripts')
<script>
    // 1. Parse nomor antrian "A-001" → array file audio
    function parseNomorAntrian(nomor) {
        const dasar = {
            0: 'nol', 1: 'satu', 2: 'dua', 3: 'tiga', 4: 'empat',
            5: 'lima', 6: 'enam', 7: 'tujuh', 8: 'delapan', 9: 'sembilan'
        };

        const files = [];

        for (let i = 0; i < nomor.length; i++) {
            const char = nomor[i];

            if (char === '-') {
                // Strip (-) : skip, tidak perlu audio
                continue;
            }

            if (/[A-Za-z]/.test(char)) {
                // Huruf → audio alfabet
                files.push('/audio/alfabet/' + char.toUpperCase() + '.mp3');
            } else if (/\d/.test(char)) {
                // Angka per digit → audio nomor
                const kata = dasar[parseInt(char)];
                if (kata) {
                    files.push('/audio/nomor/' + kata + '.mp3');
                }
            }
        }

        return files;
    }

    // 2. Ekstrak digit angka dari nama loket ("Loket CS 1" → ["satu"])
    function parseDigits(str) {
        const dasar = {
            0: 'nol', 1: 'satu', 2: 'dua', 3: 'tiga', 4: 'empat',
            5: 'lima', 6: 'enam', 7: 'tujuh', 8: 'delapan', 9: 'sembilan'
        };

        const files = [];
        for (let i = 0; i < str.length; i++) {
            const char = str[i];
            if (/\d/.test(char)) {
                const kata = dasar[parseInt(char)];
                if (kata) {
                    files.push('/audio/nomor/' + kata + '.mp3');
                }
            }
        }
        return files;
    }

    // 2. Fungsi memutar audio berantai (sequential)
    function playAudioSequence(files, index = 0) {
        if (index >= files.length) return;
        console.log('Memutar:', files[index]);
        const audio = new Audio(files[index]);
        audio.onended = () => playAudioSequence(files, index + 1);
        audio.onerror = () => {
            console.warn('Gagal memuat:', files[index]);
            playAudioSequence(files, index + 1);
        };
        audio.play().catch(e => console.error('Audio error:', e));
    }

    // 3. Fungsi untuk memicu pemanggilan audio
    function triggerPanggilan(nomor, layanan, layananLoket, loket) {
        const nomorAudioFiles = parseNomorAntrian(nomor);
        const loketDigits = parseDigits(loket);

        const audioFiles = [
            '/audio/kalimat/nomor%20antrian.mp3',
            ...nomorAudioFiles,
            '/audio/kalimat/silahkan%20menuju.mp3',
            '/audio/kalimat/loket.mp3',
            '/storage/' + layananLoket,
            ...loketDigits,
        ];

        console.log('Memanggil:', nomor, '→', nomorAudioFiles);
        playAudioSequence(audioFiles);
    }

    // --- Fungsi untuk update UI card setelah panggilan ---
    function updateCards(nomor, layanan, layananLoket, loket) {
        const cardSekarang = document.querySelector('.btn-panggil-sekarang');
        const cardSelanjutnya = document.querySelector('.card-selanjutnya');

        if (cardSekarang) {
            // Update data attributes
            cardSekarang.dataset.nomor = nomor;
            cardSekarang.dataset.layanan = layanan;
            cardSekarang.dataset.layananLoket = layananLoket;
            cardSekarang.dataset.loket = loket;
            // Update teks nomor
            const spanNomor = cardSekarang.querySelector('span.text-3xl');
            if (spanNomor) spanNomor.textContent = nomor;
        }

        // Cari baris selanjutnya setelah baris yang tombolnya diklik
        // untuk meng-update Antrian Selanjutnya dan Sisa Antrian
        const rows = document.querySelectorAll('.btn-panggil');
        let found = false;
        let nextNomor = '-';
        let sisa = 0;

        rows.forEach((btn, index) => {
            if (btn.dataset.nomor === nomor && !found) {
                found = true;
                // Ambil next row jika ada
                if (rows[index + 1]) {
                    nextNomor = rows[index + 1].dataset.nomor;
                }
            } else if (found) {
                // Hitung sisa antrian (yang belum dipanggil)
                sisa++;
            }
        });

        // Update card Antrian Selanjutnya
        if (cardSelanjutnya) {
            const spanNext = cardSelanjutnya.querySelector('span.text-3xl');
            if (spanNext) spanNext.textContent = nextNomor;
        }

        // Update card Sisa Antrian
        const cardSisa = document.querySelector('.card-sisa');
        if (cardSisa) {
            const spanSisa = cardSisa.querySelector('span.text-3xl');
            if (spanSisa) spanSisa.textContent = sisa;
        }
    }

    // 4. Event listener untuk semua tombol panggil di tabel
    document.querySelectorAll('.btn-panggil').forEach(btn => {
        btn.addEventListener('click', function() {
            const nomor = this.dataset.nomor;
            const layanan = this.dataset.layanan;
            const layananLoket = this.dataset.layananLoket;
            const loket = this.dataset.loket;
            const antrianId = this.dataset.antrianId;

            // Kirim AJAX ke backend
            fetch('/client/qounter/panggil-antrian', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                body: JSON.stringify({ antrian_id: antrianId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update card lokal
                    updateCards(nomor, layanan, layananLoket, loket);
                    // Putar audio panggilan
                    triggerPanggilan(nomor, layanan, layananLoket, loket);
                }
            })
            .catch(err => console.error('Gagal memanggil:', err));
        });
    });

    // 5. Event listener untuk card Antrian Sekarang
    const btnSekarang = document.querySelector('.btn-panggil-sekarang');
    if (btnSekarang) {
        btnSekarang.addEventListener('click', function() {
            const nomor = this.dataset.nomor;
            const layanan = this.dataset.layanan;
            const layananLoket = this.dataset.layananLoket;
            const loket = this.dataset.loket;
            if (nomor) {
                triggerPanggilan(nomor, layanan, layananLoket, loket);
            }
        });
    }
</script>
@endpush
@endsection