<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);

        return view('pages.admin.layanan.index', compact('layanans'));
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);

        return view('pages.admin.layanan.edit', compact('layanan'));
    }

    public function create()
    {
        return view('pages.admin.layanan.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255|unique:layanans,nama_layanan',
            'kode_layanan' => 'required|string|max:50|unique:layanans,kode_layanan',
            'prefix_antrian' => 'required|string|max:10',
            'suara_panggilan' => 'nullable|file|mimes:mp3,wav,ogg,aac,wma|max:10240',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'required|boolean',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi',
            'nama_layanan.unique' => 'Nama layanan sudah digunakan',
            'kode_layanan.required' => 'Kode layanan wajib diisi',
            'kode_layanan.unique' => 'Kode layanan sudah digunakan',
            'prefix_antrian.required' => 'Prefix antrian wajib diisi',
            'suara_panggilan.mimes' => 'Format audio harus: mp3, wav, ogg, aac, atau wma',
            'suara_panggilan.max' => 'File audio maksimal 10MB',
            'status_aktif.required' => 'Status aktif wajib dipilih',
            'status_aktif.boolean' => 'Status aktif harus berupa ya/tidak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload file audio jika ada
            $suaraPanggilan = null;
            if ($request->hasFile('suara_panggilan')) {
                $ext = $request->file('suara_panggilan')->getClientOriginalExtension();
                $filename = $request->kode_layanan . '.' . $ext;
                $suaraPanggilan = $request->file('suara_panggilan')
                    ->storeAs('suara_panggilan', $filename, 'public');
            }

            // Simpan data baru
            $layanan = Layanan::create([
                'nama_layanan' => $request->nama_layanan,
                'kode_layanan' => $request->kode_layanan,
                'prefix_antrian' => $request->prefix_antrian,
                'suara_panggilan' => $suaraPanggilan,
                'deskripsi' => $request->deskripsi,
                'status_aktif' => $request->status_aktif,
            ]);

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255|unique:layanans,nama_layanan,' . $id,
            'kode_layanan' => 'required|string|max:50|unique:layanans,kode_layanan,' . $id,
            'prefix_antrian' => 'required|string|max:10',
            'suara_panggilan' => 'nullable|file|mimes:mp3,wav,ogg,aac,wma|max:10240',
            'deskripsi' => 'nullable|string',
            'status_aktif' => 'required|boolean',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi',
            'nama_layanan.unique' => 'Nama layanan sudah digunakan',
            'kode_layanan.required' => 'Kode layanan wajib diisi',
            'kode_layanan.unique' => 'Kode layanan sudah digunakan',
            'prefix_antrian.required' => 'Prefix antrian wajib diisi',
            'suara_panggilan.mimes' => 'Format audio harus: mp3, wav, ogg, aac, atau wma',
            'suara_panggilan.max' => 'File audio maksimal 10MB',
            'status_aktif.required' => 'Status aktif wajib dipilih',
            'status_aktif.boolean' => 'Status aktif harus berupa ya/tidak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Cari data layanan
            $layanan = Layanan::findOrFail($id);

            $data = [
                'nama_layanan' => $request->nama_layanan,
                'kode_layanan' => $request->kode_layanan,
                'prefix_antrian' => $request->prefix_antrian,
                'deskripsi' => $request->deskripsi,
                'status_aktif' => $request->status_aktif,
            ];

            // Upload file audio baru jika ada
            if ($request->hasFile('suara_panggilan')) {
                // Hapus file lama jika ada
                if ($layanan->suara_panggilan) {
                    Storage::disk('public')->delete($layanan->suara_panggilan);
                }
                $ext = $request->file('suara_panggilan')->getClientOriginalExtension();
                $filename = $request->kode_layanan . '.' . $ext;
                $data['suara_panggilan'] = $request->file('suara_panggilan')
                    ->storeAs('suara_panggilan', $filename, 'public');
            }

            // Update data
            $layanan->update($data);

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            // Hapus file audio jika ada
            if ($layanan->suara_panggilan) {
                Storage::disk('public')->delete($layanan->suara_panggilan);
            }

            $layanan->delete();

            return redirect()->route('layanans.index')
                ->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('layanans.index')
                ->with('error', 'Terjadi kesalahan saat menghapus layanan: ' . $e->getMessage());
        }
    }
}
