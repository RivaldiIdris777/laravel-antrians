<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Loket;
use App\Models\Antrian;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahLayanan = Layanan::count();
        $jumlahLoket = Loket::count();
        $jumlahAntrian = Antrian::count();

        return view('pages.admin.dashboard', compact(
            'jumlahLayanan',
            'jumlahLoket',
            'jumlahAntrian'
        ));
    }
}
