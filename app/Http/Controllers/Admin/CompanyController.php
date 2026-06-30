<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);

        return view('pages.admin.company.index', compact('companies'));
    }

    public function create()
    {
        // Cek apakah sudah ada data company
        if (Company::exists()) {
            return redirect()->route('company.index')
                ->with('error', 'Data company sudah ada, tidak dapat menambahkan data baru. Anda hanya dapat mengedit data yang sudah ada.');
        }

        return view('pages.admin.company.create');
    }

    public function store(Request $request)
    {
        // Cek apakah sudah ada data company
        if (Company::exists()) {
            return redirect()->route('company.index')
                ->with('error', 'Data company sudah ada, tidak dapat menambahkan data baru. Anda hanya dapat mengedit data yang sudah ada.');
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'branch_company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'desc' => 'nullable|string|max:1000',
            'img' => 'nullable|image|mimes:jpeg,jpg,png|max:200',
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_name.max' => 'Nama perusahaan maksimal 255 karakter',
            'branch_company.max' => 'Cabang perusahaan maksimal 255 karakter',
            'address.max' => 'Alamat maksimal 500 karakter',
            'desc.max' => 'Deskripsi maksimal 1000 karakter',
            'img.image' => 'File harus berupa gambar',
            'img.mimes' => 'Format gambar harus: JPEG, JPG, atau PNG',
            'img.max' => 'Ukuran gambar maksimal 200KB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload gambar jika ada
            $imgPath = null;
            if ($request->hasFile('img')) {
                $ext = $request->file('img')->getClientOriginalExtension();
                $filename = 'company_' . time() . '_' . uniqid() . '.' . $ext;
                $imgPath = $request->file('img')->storeAs('companyImage', $filename, 'public');
            }

            // Simpan data
            Company::create([
                'company_name' => $request->company_name,
                'branch_company' => $request->branch_company,
                'address' => $request->address,
                'desc' => $request->desc,
                'img' => $imgPath,
            ]);

            return redirect()->route('company.index')
                ->with('success', 'Company berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);

            // Hapus file gambar dari storage jika ada
            if ($company->img) {
                Storage::disk('public')->delete($company->img);
            }

            $company->delete();

            return redirect()->route('company.index')
                ->with('success', 'Company berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('company.index')
                ->with('error', 'Terjadi kesalahan saat menghapus company: ' . $e->getMessage());
        }
    }
}
