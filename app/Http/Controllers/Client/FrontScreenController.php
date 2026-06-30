<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Loket;
use App\Models\Antrian;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;

class FrontScreenController extends Controller
{
    public function frontScreen1()
    {
        $lokets = Loket::with('layanan')->orderBy('id', 'asc')->get();
        
        $antrianPerLoket = [];
        foreach ($lokets as $loket) {
            $antrianSekarang = Antrian::with(['layanan', 'loket'])
                ->where('loket_id', $loket->id)
                ->where('status', 'dipanggil')
                ->first();
            
            $antrianPerLoket[] = [
                'loket' => $loket,
                'antrian_sekarang' => $antrianSekarang,
            ];
        }

        return view('pages.client.frontscreen.index', compact('antrianPerLoket'));
    }    

    public function printedticket() 
    {
        $lokets = Loket::with(['layanan'])->orderBy('id', 'asc')->get();
        $company = Company::first();
        return view('pages.client.printedticket.index', compact('lokets', 'company'));
    }

    /**
     * Cetak tiket antrian untuk loket tertentu.
     * Ukuran kertas: 80mm (lebar 226.77 pt).
     * Untuk 58mm, ubah array paper menjadi [0, 0, 164.41, 600].
     */
    public function cetakTicket($loket_id)
    {
        $loket = Loket::with('layanan')->findOrFail($loket_id);
        $layanan = $loket->layanan;
        $company = Company::first();

        // === Tentukan prefix alfabet berdasarkan urutan ID loket ===
        // Ambil semua loket (diurutkan ID), lalu cari posisi loket saat ini
        $allLokets = Loket::orderBy('id', 'asc')->pluck('id')->toArray();
        $position = array_search($loket_id, $allLokets); // 0-based: 0=A, 1=B, 2=C, ...
        $prefix = chr(65 + $position); // 65 = 'A' dalam ASCII

        // === Cek duplikasi: jika sudah ada antrian dibuat dalam 5 detik terakhir ===
        // untuk loket yang sama, langsung tampilkan tiket yang sudah ada (tanpa buat baru)
        $recentAntrian = Antrian::where('loket_id', $loket_id)
            ->where('waktu_ambil', '>=', now()->subSeconds(5))
            ->orderBy('waktu_ambil', 'desc')
            ->first();

        if ($recentAntrian) {
            $antrian = $recentAntrian;
            $currentLevel = error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
            $pdf = Pdf::loadView('pages.client.printedticket.print', compact('antrian', 'loket', 'layanan', 'company'));
            $pdf->setPaper([0, 0, 226.77, 600], 'portrait');
            $result = $pdf->stream('tiket-' . $antrian->nomor_antrian . '.pdf');
            error_reporting($currentLevel);
            return $result;
        }

        // Generate nomor antrian berikutnya
        $lastQueue = Antrian::where('nomor_antrian', 'like', $prefix . '-%')
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        $startNumber = 1;
        if ($lastQueue) {
            preg_match('/' . $prefix . '-(\d+)/', $lastQueue->nomor_antrian, $matches);
            if (isset($matches[1])) {
                $startNumber = (int)$matches[1] + 1;
            }
        }

        // Pastikan nomor belum dipakai
        $nomorAntrian = $prefix . '-' . str_pad($startNumber, 3, '0', STR_PAD_LEFT);
        while (Antrian::where('nomor_antrian', $nomorAntrian)->exists()) {
            $startNumber++;
            $nomorAntrian = $prefix . '-' . str_pad($startNumber, 3, '0', STR_PAD_LEFT);
        }

        // Buat record antrian baru
        $antrian = Antrian::create([
            'nomor_antrian' => $nomorAntrian,
            'layanan_id' => $layanan->id,
            'loket_id' => $loket->id,
            'status' => 'menunggu',
            'nama' => 'Opt Loket',
            'waktu_ambil' => now(),
        ]);

        // Load view untuk PDF
        $currentLevel = error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
        $pdf = Pdf::loadView('pages.client.printedticket.print', compact('antrian', 'loket', 'layanan', 'company'));

        // Set ukuran kertas: 80mm lebar (226.77 pt), tinggi menyesuaikan
        // Untuk 58mm: [0, 0, 164.41, 600]
        $pdf->setPaper([0, 0, 226.77, 600], 'portrait');

        $result = $pdf->stream('tiket-' . $nomorAntrian . '.pdf');
        error_reporting($currentLevel);
        return $result;
    }
}
