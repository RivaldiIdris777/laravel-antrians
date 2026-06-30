<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Layanan;
use App\Models\Loket;
use Illuminate\Support\Facades\Validator;

class AntrianController extends Controller
{
    public function index()
    {
        $antrians = Antrian::with(['layanan', 'loket'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.queue.index', compact('antrians'));
    }

    public function create()
    {        
        $layanans = Layanan::all(); // model layanan
        $lokets = Loket::all(); // model loket
        
        return view('pages.admin.queue.create', compact('layanans', 'lokets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_antrian' => 'required|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
            'jumlah_antrian' => 'required|integer|min:1|max:100',
            'nama' => 'required',
            'layanan_id' => 'required|exists:layanans,id',
            'loket_id' => 'required|exists:lokets,id',
            'status' => 'in:menunggu,dipanggil,selesai'
        ]);
        
        $namaAntrian = $validated['nama_antrian'];
        $jumlahAntrian = $validated['jumlah_antrian'];
        
        // Ambil semua nomor antrian yang sudah ada untuk huruf yang dipilih
        $existingQueues = Antrian::where('nomor_antrian', 'like', $namaAntrian . '-%')
            ->orderBy('nomor_antrian', 'asc')
            ->get();
        
        // Ekstrak nomor urut dari nomor_antrian yang sudah ada (format: A-001)
        $existingNumbers = [];
        foreach ($existingQueues as $queue) {
            preg_match('/' . $namaAntrian . '-(\d+)/', $queue->nomor_antrian, $matches);
            if (isset($matches[1])) {
                $existingNumbers[] = (int)$matches[1];
            }
        }
        
        // Jika ada nomor yang sudah terdaftar, tampilkan peringatan
        if (!empty($existingNumbers)) {
            $existingNumbersList = implode(', ', array_map(function($num) use ($namaAntrian) {
                return $namaAntrian . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            }, $existingNumbers));
            
            return redirect()->back()
                ->withInput()
                ->with('error', "Nomor antrian untuk {$namaAntrian} yang sudah terdaftar: {$existingNumbersList}. Silakan pilih huruf antrian lain!");
        }
        
        // Cari nomor terakhir yang ada untuk huruf tersebut
        $lastQueue = Antrian::where('nomor_antrian', 'like', $namaAntrian . '-%')
            ->orderBy('nomor_antrian', 'desc')
            ->first();
        
        // Tentukan nomor awal
        $startNumber = 1;
        if ($lastQueue) {
            preg_match('/' . $namaAntrian . '-(\d+)/', $lastQueue->nomor_antrian, $matches);
            if (isset($matches[1])) {
                $startNumber = (int)$matches[1] + 1;
            }
        }
        
        // Cek apakah nomor yang akan dibuat sudah melebihi batas
        $maxNumber = 999;
        if (($startNumber + $jumlahAntrian - 1) > $maxNumber) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Jumlah antrian terlalu banyak. Maksimal nomor antrian adalah {$maxNumber}. Saat ini sudah mencapai nomor " . ($startNumber - 1));
        }
        
        // Siapkan array untuk menyimpan data
        $createdQueues = [];
        $duplicateNumbers = [];
        $currentTime = now(); // Waktu ambil otomatis sekarang
        
        // Proses penyimpanan data
        for ($i = 0; $i < $jumlahAntrian; $i++) {
            $currentNumber = $startNumber + $i;
            $nomorAntrian = $namaAntrian . '-' . str_pad($currentNumber, 3, '0', STR_PAD_LEFT);
            
            // Cek apakah nomor_antrian sudah ada (double check)
            $exists = Antrian::where('nomor_antrian', $nomorAntrian)->exists();
            
            if ($exists) {
                $duplicateNumbers[] = $nomorAntrian;
                continue;
            }
            
            // Buat antrian baru sesuai struktur tabel
            $queue = Antrian::create([
                'nomor_antrian' => $nomorAntrian,
                'nama' => $validated['nama'], // asumsi field 'nama' di tabel menyimpan customer_id atau nama?
                'layanan_id' => $validated['layanan_id'],
                'loket_id' => $validated['loket_id'],
                'status' => $validated['status'],
                'waktu_ambil' => $currentTime, // otomatis diisi waktu sekarang
                'created_at' => $currentTime,
                'updated_at' => $currentTime
            ]);
            
            $createdQueues[] = $nomorAntrian;
        }
        
        // Handle duplikasi
        if (!empty($duplicateNumbers)) {
            $duplicateList = implode(', ', $duplicateNumbers);
            if (!empty($createdQueues)) {
                $createdList = implode(', ', $createdQueues);
                return redirect()->route('antrians.index')
                    ->with('warning', "Beberapa nomor antrian gagal dibuat karena sudah ada: {$duplicateList}. Berhasil membuat: {$createdList}");
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Gagal membuat antrian. Nomor yang sudah ada: {$duplicateList}");
            }
        }
        
        // Jika berhasil semua
        $createdList = implode(', ', $createdQueues);
        return redirect()->route('antrians.index')
            ->with('success', "Berhasil membuat {$jumlahAntrian} antrian baru: {$createdList}");
    }

    public function edit($id)
    {
        $antrian = Antrian::findOrFail($id);
        $layanans = Layanan::orderBy('nama_layanan')->get();
        $lokets = Loket::orderBy('nama_loket')->get();

        return view('pages.admin.queue.edit', compact('antrian', 'layanans', 'lokets'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_antrian' => 'required|string|max:20|unique:antrians,nomor_antrian,' . $id,
            'nama' => 'required|string|max:100',
            'layanan_id' => 'required|exists:layanans,id',
            'loket_id' => 'required|exists:lokets,id',
            'status' => 'required|in:menunggu,dipanggil,selesai',
        ], [
            'nomor_antrian.required' => 'Nomor antrian wajib diisi',
            'nomor_antrian.unique' => 'Nomor antrian sudah digunakan',
            'nama.required' => 'Nama wajib diisi',
            'layanan_id.required' => 'Layanan wajib dipilih',
            'layanan_id.exists' => 'Layanan tidak valid',
            'loket_id.required' => 'Loket wajib dipilih',
            'loket_id.exists' => 'Loket tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // Update data using current schedule time for waktu_ambil
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'nomor_antrian' => $request->input('nomor_antrian'),
            'nama' => $request->input('nama'),
            'layanan_id' => $request->input('layanan_id'),
            'loket_id' => $request->input('loket_id'),
            'status' => $request->input('status'),
            'waktu_ambil' => now(),
        ]);

        return redirect()->route('antrians.index')
                        ->with('success', 'Antrian berhasil diperbarui');
    }    

    public function destroy(Antrian $antrian)
    {
        try {
            $antrian->delete();
            return redirect()->route('antrians.index')
                ->with('success', 'Antrian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('antrians.index')
                ->with('error', 'Gagal menghapus antrian: ' . $e->getMessage());
        }
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:antrians,id',
        ]);

        try {
            $count = Antrian::whereIn('id', $request->ids)->count();
            Antrian::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$count} antrian"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus antrian: ' . $e->getMessage()
            ], 500);
        }
    }

}
