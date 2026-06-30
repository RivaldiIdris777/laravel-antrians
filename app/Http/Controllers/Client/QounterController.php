<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loket;
use App\Models\Antrian;
use App\Events\AntrianDipanggil;

class QounterController extends Controller
{
    public function index()
    {
        $lokets = Loket::all();
        return view('pages.client.qounter.index', compact('lokets'));
    }

    /**
     * Menampilkan data antrian berdasarkan loket_id.
     * (Mengambil semua antrian dengan loket_id yang sama)
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function pemanggilan($id)
    {
        $antrians = Antrian::with(['loket', 'layanan'])
            ->where('loket_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        // Antrian sekarang: antrian dengan status 'dipanggil', atau jika tidak ada, ambil antrian 'menunggu' pertama
        $antrianSekarang = $antrians->where('status', 'dipanggil')->first()
                        ?? $antrians->where('status', 'menunggu')->first();

        // Antrian selanjutnya: antrian 'menunggu' setelah antrian sekarang
        $indexSekarang = $antrians->search(function ($item) use ($antrianSekarang) {
            return $antrianSekarang && $item->id === $antrianSekarang->id;
        });
        $antrianSelanjutnya = ($indexSekarang !== false && isset($antrians[$indexSekarang + 1]))
            ? $antrians[$indexSekarang + 1]
            : null;

        // Sisa antrian yang masih 'menunggu'
        $sisaAntrian = $antrians->where('status', 'menunggu')->count();

        return view('pages.client.qounter.pemanggilan', compact('antrians', 'antrianSekarang', 'antrianSelanjutnya', 'sisaAntrian'));
    }

    public function panggilAntrian(Request $request)
    {
        $request->validate([
            'antrian_id' => 'required|exists:antrians,id',
        ]);

        $antrian = Antrian::with(['layanan', 'loket'])->findOrFail($request->antrian_id);

        // Update status semua antrian di loket ini jadi 'selesai' (kecuali yang sudah selesai)
        Antrian::where('loket_id', $antrian->loket_id)
            ->where('status', 'dipanggil')
            ->update(['status' => 'selesai']);

        // Update antrian yang dipanggil jadi 'dipanggil'
        $antrian->update(['status' => 'dipanggil']);

        // Broadcast event via Reverb
        broadcast(new AntrianDipanggil($antrian));

        // Ambil data antrian selanjutnya & sisa untuk response
        $antriansLoket = Antrian::with(['layanan', 'loket'])
            ->where('loket_id', $antrian->loket_id)
            ->orderBy('id', 'asc')
            ->get();
        
        $indexSekarang = $antriansLoket->search(fn($item) => $item->id === $antrian->id);
        $antrianSelanjutnya = ($indexSekarang !== false && isset($antriansLoket[$indexSekarang + 1]))
            ? $antriansLoket[$indexSekarang + 1]
            : null;

        $sisaAntrian = $antriansLoket->where('status', 'menunggu')->count();

        return response()->json([
            'success' => true,
            'antrian' => $antrian,
            'antrian_selanjutnya' => $antrianSelanjutnya,
            'sisa_antrian' => $sisaAntrian,
        ]);
    }
}
