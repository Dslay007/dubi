<?php

use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\OpacController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/struktur', function () {
    return view('pages.struktur');
})->name('page.struktur');

Route::get('/jurnal', function () {
    return view('pages.jurnal');
})->name('page.jurnal');

Route::get('/opac', [OpacController::class, 'index'])->name('opac.index');
Route::get('/opac/detail/{id}', [OpacController::class, 'show'])->name('opac.show');

// Content Routes
Route::get('/page/{path}', [ContentController::class, 'show'])->name('content.show');

// Member Routes
Route::get('/member/login', [MemberAuthController::class, 'showLoginForm'])->name('login');
Route::post('/member/login', [MemberAuthController::class, 'login'])->name('member.login');
Route::get('/register', [\App\Http\Controllers\MemberRegisterController::class, 'showRegistrationForm'])->name('member.register');
Route::post('/register', [\App\Http\Controllers\MemberRegisterController::class, 'register'])->name('member.register.post');
Route::post('/member/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

Route::middleware('auth:member')->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
});

// Admin Routes
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Bibliografi Group
    Route::prefix('biblio')->name('biblio.')->group(function () {
        // Main Bibliography
        Route::get('/', [\App\Http\Controllers\Admin\BiblioController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\BiblioController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\BiblioController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\BiblioController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\BiblioController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\BiblioController::class, 'destroy'])->name('destroy');
        Route::get('/import', [\App\Http\Controllers\Admin\BiblioController::class, 'import'])->name('import');
        Route::post('/import', [\App\Http\Controllers\Admin\BiblioController::class, 'processImport'])->name('process_import');
        Route::get('/export', [\App\Http\Controllers\Admin\BiblioController::class, 'export'])->name('export');
    });

    // Items (Eksemplar)
    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ItemController::class, 'index'])->name('index');
        Route::get('/import', [\App\Http\Controllers\Admin\ItemController::class, 'import'])->name('import');
        Route::get('/export', [\App\Http\Controllers\Admin\ItemController::class, 'export'])->name('export');
        Route::get('/out', [\App\Http\Controllers\Admin\ItemController::class, 'outList'])->name('out'); // Daftar Eksemplar Keluar
        Route::get('/barcode', [\App\Http\Controllers\Admin\ItemController::class, 'barcodeIndex'])->name('barcode'); // Cetak Barcode page
        Route::post('/print-barcodes', [\App\Http\Controllers\Admin\ItemController::class, 'printBarcodes'])->name('print_barcodes');
        Route::post('/print-barcodes-filter', [\App\Http\Controllers\Admin\ItemController::class, 'printBarcodesByFilter'])->name('print_barcodes_filter');
    });

    // MARC
    Route::prefix('marc')->name('marc.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MarcController::class, 'index'])->name('index');
        Route::post('/import', [\App\Http\Controllers\Admin\MarcController::class, 'import'])->name('import');
        Route::get('/export', [\App\Http\Controllers\Admin\MarcController::class, 'export'])->name('export');
    });

    // Other Modules (Keeping existing ones)
    Route::resource('member', \App\Http\Controllers\Admin\MemberController::class);
    Route::resource('member_type', \App\Http\Controllers\Admin\MemberTypeController::class); // Added for Loan Rules CRUD
    
    Route::prefix('circulation')->name('circulation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CirculationController::class, 'index'])->name('index'); // Manual Transaction (Start)
        Route::post('/start', [\App\Http\Controllers\Admin\CirculationController::class, 'start'])->name('start');
        Route::get('/transaction/{member_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'transaction'])->name('transaction');
        Route::post('/loan/{member_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'storeLoan'])->name('loan.store');
        Route::post('/return/{loan_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'returnLoan'])->name('return');
        Route::get('/lookup-loan', [\App\Http\Controllers\Admin\CirculationController::class, 'getLoanDetails'])->name('lookup_loan');
        Route::get('/quick-return', [\App\Http\Controllers\Admin\CirculationController::class, 'quickReturn'])->name('quick_return');
        Route::get('/history', [\App\Http\Controllers\Admin\CirculationController::class, 'history'])->name('history');
        Route::get('/overdue', [\App\Http\Controllers\Admin\CirculationController::class, 'overdue'])->name('overdue');
        Route::post('/overdue/notify/{loan_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'notifyOverdue'])->name('overdue.notify');
        Route::get('/reservations', [\App\Http\Controllers\Admin\CirculationController::class, 'reservations'])->name('reservations');
        Route::get('/rules', [\App\Http\Controllers\Admin\CirculationController::class, 'rules'])->name('rules');
    });

    Route::resource('author', \App\Http\Controllers\Admin\AuthorController::class);
    Route::resource('publisher', \App\Http\Controllers\Admin\PublisherController::class);
    Route::resource('gmd', \App\Http\Controllers\Admin\GmdController::class);
    Route::resource('topic', \App\Http\Controllers\Admin\TopicController::class);
    Route::resource('place', \App\Http\Controllers\Admin\PlaceController::class);
    Route::resource('item_status', \App\Http\Controllers\Admin\ItemStatusController::class);
});

