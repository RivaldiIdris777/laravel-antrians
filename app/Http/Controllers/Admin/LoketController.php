<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loket;
use App\Models\Layanan;
use App\Models\Antrian;
use RealRashid\SweetAlert\Facades\Alert;

class LoketController extends Controller
{
    public function index()
    {
        $lokets = Loket::with('layanan')->latest()->paginate(10);

        return view('pages.admin.qounter.index', compact('lokets'));
    }

    public function edit($id)
    {
        $loket = Loket::findOrFail($id);
        $layanans = Layanan::orderBy('nama_layanan')->get();

        return view('pages.admin.qounter.edit', compact('loket', 'layanans'));
    }

    public function create()
    {
        $layanans = Layanan::orderBy('nama_layanan')->get();

        return view('pages.admin.qounter.create', compact('layanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|integer|exists:layanans,id',
            'jumlah_loket' => 'required|integer|min:1'
        ], [
            'layanan_id.required' => 'Layanan wajib dipilih',
            'layanan_id.exists' => 'Layanan tidak valid',
            'jumlah_loket.required' => 'Nomor loket wajib diisi',
            'jumlah_loket.integer' => 'Nomor loket harus berupa angka',
            'jumlah_loket.min' => 'Nomor loket minimal 1'
        ]);

        // Ambil data layanan
        $layanan = Layanan::findOrFail($validated['layanan_id']);
        
        // Ambil huruf awal dari setiap kata pada nama layanan
        $kataKata = explode(' ', $layanan->nama_layanan);
        $inisial = '';
        foreach ($kataKata as $kata) {
            if (!empty(trim($kata))) {
                $inisial .= strtoupper(substr(trim($kata), 0, 1));
            }
        }
        
        $nomor = $validated['jumlah_loket'];
        
        // Format kode_loket: "Loket-CS-01"
        $kode_loket = 'L-' . $inisial . '-' . str_pad($nomor, 2, '0', STR_PAD_LEFT);
        
        // Format nama_loket: "Loket CS 1"
        $nama_loket = 'Loket ' . $inisial . ' ' . $nomor;
        
        // Cek apakah kode_loket sudah terdaftar
        $cekLoket = Loket::where('kode_loket', $kode_loket)->exists();
        if ($cekLoket) {
            Alert::error('Gagal!', 'Kode loket ' . $kode_loket . ' sudah terdaftar. Silakan gunakan nomor loket yang berbeda.');
            return redirect()->back()->withInput();
        }
        
        // Simpan data
        Loket::create([
            'nama_loket' => $nama_loket,
            'kode_loket' => $kode_loket,
            'layanan_id' => $validated['layanan_id'],
            'status' => 'buka'
        ]);
        
        return redirect()->route('lokets.index')
                        ->with('success', 'Data loket berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_loket' => 'required|string|max:100|unique:loket,nama_loket,' . $id,
            'kode_loket' => 'required|string|max:20',
            'layanan_id' => 'required|integer|exists:layanans,id',
            'status' => 'required|in:buka,tutup,istirahat'
        ], [
            'nama_loket.required' => 'Nama loket wajib diisi',
            'nama_loket.unique' => 'Nama loket sudah digunakan',
            'kode_loket.required' => 'Kode loket wajib diisi',
            'layanan_id.required' => 'Layanan ID wajib diisi',
            'layanan_id.exists' => 'Layanan ID tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus salah satu dari: buka, tutup, istirahat'
        ]);

        // Cek apakah kode_loket sudah digunakan oleh loket lain (selain data yang sedang diedit)
        $cekKodeLoket = Loket::where('kode_loket', $validated['kode_loket'])
                            ->where('id', '!=', $id)
                            ->exists();

        if ($cekKodeLoket) {
            Alert::error('Gagal!', 'Kode loket ' . $validated['kode_loket'] . ' sudah terdaftar. Silakan gunakan kode loket yang berbeda.');
            return redirect()->back()->withInput();
        }

        // Proses update data
        $loket = Loket::findOrFail($id);
        $loket->update($validated);

        return redirect()->route('lokets.index')
                        ->with('success', 'Data loket berhasil diupdate');
    }

    public function destroy(Loket $loket)
    {
        try {
            // Cek apakah masih ada antrian yang menggunakan loket ini
            $antrianTerdaftar = Antrian::where('loket_id', $loket->id)->exists();

            if ($antrianTerdaftar) {
                return redirect()->route('lokets.index')
                    ->with('error', 'Loket tidak dapat dihapus karena masih terdapat data antrian yang terdaftar pada loket ini.');
            }

            $loket->delete();

            return redirect()->route('lokets.index')
                ->with('success', 'Loket berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('lokets.index')
                ->with('error', 'Terjadi kesalahan saat menghapus loket: ' . $e->getMessage());
        }
    }
}
