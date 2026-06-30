<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
// Admin Controllers
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\LoketController;
use App\Http\Controllers\Admin\AntrianController;
// Client Controllers
use App\Http\Controllers\Client\FrontScreenController;
use App\Http\Controllers\Client\ManageScreenController;
use App\Http\Controllers\Client\WelcomeController;
use App\Http\Controllers\Client\QounterController;
use App\Http\Controllers\Client\UserController as ClientUserController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/front-screen', [FrontScreenController::class, 'frontScreen1'])->name('front.screen1');
Route::get('/welcome', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/printed-ticket', [FrontScreenController::class, 'printedticket'])->name('printed.ticket');
Route::get('/printed-ticket/cetak/{loket_id}', [FrontScreenController::class, 'cetakTicket'])->name('printed.ticket.cetak');

Route::post('/client/qounter/panggil-antrian', [QounterController::class, 'panggilAntrian'])->name('client.qounter.panggil-antrian');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management Routes (Admin)
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/admin/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/admin/company', [CompanyController::class, 'store'])->name('company.store');
    Route::delete('/admin/company/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');

    // Services Management Routes (Admin)
    Route::get('/admin/layanans', [LayananController::class, 'index'])->name('layanans.index');
    Route::get('/admin/layanans/create', [LayananController::class, 'create'])->name('layanans.create');
    Route::post('/admin/layanans', [LayananController::class, 'store'])->name('layanans.store');
    Route::get('/admin/layanans/{id}/edit', [LayananController::class, 'edit'])->name('layanans.edit');
    Route::put('/admin/layanans/{id}', [LayananController::class, 'update'])->name('layanans.update');
    Route::delete('/admin/layanans/{id}', [LayananController::class, 'destroy'])->name('layanans.destroy');    

    // Loket Management Routes (Admin)
    Route::get('/admin/lokets', [LoketController::class, 'index'])->name('lokets.index');
    Route::get('/admin/lokets/create', [LoketController::class, 'create'])->name('lokets.create');
    Route::post('/admin/lokets', [LoketController::class, 'store'])->name('lokets.store');
    Route::get('/admin/lokets/{id}/edit', [LoketController::class, 'edit'])->name('lokets.edit');
    Route::put('/admin/lokets/{id}', [LoketController::class, 'update'])->name('lokets.update');
    Route::delete('/admin/lokets/{loket}', [LoketController::class, 'destroy'])->name('lokets.destroy');

    // Antrian Management Routes (Admin)
    Route::get('/admin/antrians', [AntrianController::class, 'index'])->name('antrians.index');    
    Route::get('/admin/antrians/create', [AntrianController::class, 'create'])->name('antrians.create');
    Route::post('/admin/antrians', [AntrianController::class, 'store'])->name('antrians.store');
    Route::get('/admin/antrians/{id}/edit', [AntrianController::class, 'edit'])->name('antrians.edit'); 
    Route::put('/admin/antrians/{id}', [AntrianController::class, 'update'])->name('antrians.update');
    Route::delete('/admin/antrians/{antrian}', [AntrianController::class, 'destroy'])->name('antrians.destroy');
    Route::post('/admin/antrians/destroy-multiple', [AntrianController::class, 'destroyMultiple'])->name('antrians.destroyMultiple');


    // Qounter Controller (User)
    Route::get('/client/qounter', [QounterController::class, 'index'])->name('client.qounter.index');
    Route::get('/client/qounter/pemanggilan/{id}', [QounterController::class, 'pemanggilan'])->name('client.qounter.pemanggilan');

    // FrontScreenManagement (User)
    Route::get('/client/managementfrontscreen', [ManageScreenController::class, 'index'])->name('client.frontscreen.managementfrontscreen');

    // Client User Profile (User)
    Route::get('/client/profile', [ClientUserController::class, 'index'])->name('client.profile.index');
    Route::get('/client/profile/edit', [ClientUserController::class, 'edit'])->name('client.profile.edit');
    Route::put('/client/profile', [ClientUserController::class, 'update'])->name('client.profile.update');    
});

require __DIR__.'/auth.php';
