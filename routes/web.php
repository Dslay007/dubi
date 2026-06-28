<?php

use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\OpacController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\PageController;

// ==========================================
// PUBLIC & LANDING PAGES
// ==========================================
Route::get('/', [PageController::class, 'landing'])->name('landing');
Route::get('/struktur', [PageController::class, 'struktur'])->name('page.struktur');
Route::get('/jurnal', [PageController::class, 'jurnal'])->name('page.jurnal');
Route::get('/jurnal/{id}', [PageController::class, 'jurnalDetail'])->name('page.jurnal.detail');

// ==========================================
// OPAC (Online Public Access Catalog)
// ==========================================
Route::get('/opac', [OpacController::class, 'index'])->name('opac.index');
Route::get('/opac/detail/{id}', [OpacController::class, 'show'])->name('opac.show');

// ==========================================
// EVENT & CLICK TRACKER
// ==========================================
Route::get('/kegiatan/daftar/{id}', function($id) {
    $event = \App\Models\Event::findOrFail($id);
    if($event->registration_link) {
        $event->increment('click_count');
        return redirect()->away($event->registration_link);
    }
    return redirect()->route('landing');
})->name('kegiatan.daftar');

// ==========================================
// DYNAMIC CONTENT PAGES
// ==========================================
Route::get('/page/{path}', [ContentController::class, 'show'])->name('content.show');

// ==========================================
// MEMBER AUTHENTICATION
// ==========================================
Route::get('/member/login', [MemberAuthController::class, 'showLoginForm'])->name('login');
Route::post('/member/login', [MemberAuthController::class, 'login'])->name('member.login');
Route::get('/register', [\App\Http\Controllers\MemberRegisterController::class, 'showRegistrationForm'])->name('member.register');
Route::post('/register', [\App\Http\Controllers\MemberRegisterController::class, 'register'])->name('member.register.post');
Route::post('/member/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

Route::middleware('auth:member')->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    Route::post('/member/update-image', [MemberController::class, 'updateImage'])->name('member.update_image');
    Route::post('/member/change-password', [MemberController::class, 'changePassword'])->name('member.change_password');
    Route::get('/digital/download/{id}', [OpacController::class, 'downloadDigital'])->name('digital.download');
    Route::post('/opac/reserve/{biblio_id}', [OpacController::class, 'reserve'])->name('opac.reserve');
});

// ==========================================
// ADMIN AUTHENTICATION
// ==========================================
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ==========================================
// ADMIN PANEL ROUTES (PROTECTED)
// ==========================================
Route::middleware(['auth:admin', 'menu_access'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // ==========================================
    // BIBLIOGRAFI
    // ==========================================
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

    // ==========================================
    // EKSEMPLAR (ITEMS)
    // ==========================================
    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ItemController::class, 'index'])->name('index');
        Route::get('/import', [\App\Http\Controllers\Admin\ItemController::class, 'import'])->name('import');
        Route::post('/import', [\App\Http\Controllers\Admin\ItemController::class, 'processImport'])->name('process_import');
        Route::get('/export', [\App\Http\Controllers\Admin\ItemController::class, 'export'])->name('export');
        Route::get('/out', [\App\Http\Controllers\Admin\ItemController::class, 'outList'])->name('out'); // Daftar Eksemplar Keluar
        Route::get('/out/export', [\App\Http\Controllers\Admin\ItemController::class, 'exportOutList'])->name('out.export');
        Route::get('/barcode', [\App\Http\Controllers\Admin\ItemController::class, 'barcodeIndex'])->name('barcode'); // Cetak Barcode page
        Route::post('/print-barcodes', [\App\Http\Controllers\Admin\ItemController::class, 'printBarcodes'])->name('print_barcodes');
        Route::post('/print-barcodes-filter', [\App\Http\Controllers\Admin\ItemController::class, 'printBarcodesByFilter'])->name('print_barcodes_filter');
        Route::post('/', [\App\Http\Controllers\Admin\ItemController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\ItemController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Admin\ItemController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\ItemController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // MARC IMPORT / EXPORT
    // ==========================================
    Route::prefix('marc')->name('marc.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MarcController::class, 'index'])->name('index');
        Route::post('/import', [\App\Http\Controllers\Admin\MarcController::class, 'import'])->name('import');
        Route::get('/export', [\App\Http\Controllers\Admin\MarcController::class, 'export'])->name('export');
    });

    // ==========================================
    // MEMBER MANAGEMENT (KEANGGOTAAN)
    // ==========================================
    Route::get('/member/import', [\App\Http\Controllers\Admin\MemberController::class, 'import'])->name('member.import');
    Route::post('/member/import', [\App\Http\Controllers\Admin\MemberController::class, 'processImport'])->name('member.process_import');
    Route::get('/member/export', [\App\Http\Controllers\Admin\MemberController::class, 'export'])->name('member.export');
    
    // --- Member Verification ---
    Route::get('/member/verifikasi', [\App\Http\Controllers\Admin\MemberController::class, 'verifikasiIndex'])->name('member.verifikasi');
    Route::post('/member/verifikasi/{id}/approve', [\App\Http\Controllers\Admin\MemberController::class, 'approve'])->name('member.verifikasi.approve');
    Route::post('/member/verifikasi/{id}/reject', [\App\Http\Controllers\Admin\MemberController::class, 'reject'])->name('member.verifikasi.reject');

    // --- Member Barcodes ---
    Route::get('/member/barcode', [\App\Http\Controllers\Admin\MemberController::class, 'barcodeIndex'])->name('member.barcode');
    Route::post('/member/print-barcodes', [\App\Http\Controllers\Admin\MemberController::class, 'printBarcodes'])->name('member.print_barcodes');
    Route::post('/member/print-barcodes-filter', [\App\Http\Controllers\Admin\MemberController::class, 'printBarcodesByFilter'])->name('member.print_barcodes_filter');
    
    // ==========================================
    // MEMBER ATTENDANCE (ABSENSI ANGGOTA)
    // ==========================================
    Route::get('/member/attendance', [\App\Http\Controllers\Admin\MemberController::class, 'attendance'])->name('member.attendance');
    Route::get('/member/attendance/check', [\App\Http\Controllers\Admin\MemberController::class, 'checkAttendance'])->name('member.attendance.check');
    Route::post('/member/attendance', [\App\Http\Controllers\Admin\MemberController::class, 'storeAttendance'])->name('member.attendance.store');
    
    // ==========================================
    // GUEST COUNTER (COUNTER TAMU)
    // ==========================================
    Route::get('/member/guest-counter', [\App\Http\Controllers\Admin\MemberController::class, 'guestCounter'])->name('member.guest_counter');
    Route::post('/member/guest-counter', [\App\Http\Controllers\Admin\MemberController::class, 'storeGuestVisit'])->name('member.guest_counter.store');
    
    Route::resource('member', \App\Http\Controllers\Admin\MemberController::class);
    
    // --- Member Types & Loan Rules ---
    Route::get('/member_type/import', [\App\Http\Controllers\Admin\MemberTypeController::class, 'import'])->name('member_type.import');
    Route::post('/member_type/import', [\App\Http\Controllers\Admin\MemberTypeController::class, 'processImport'])->name('member_type.process_import');
    Route::get('/member_type/export', [\App\Http\Controllers\Admin\MemberTypeController::class, 'export'])->name('member_type.export');
    Route::resource('member_type', \App\Http\Controllers\Admin\MemberTypeController::class); // Added for Loan Rules CRUD
    
    // ==========================================
    // CIRCULATION (SIRKULASI)
    // ==========================================
    Route::prefix('circulation')->name('circulation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CirculationController::class, 'index'])->name('index'); // Manual Transaction (Start)
        Route::get('/search-member', [\App\Http\Controllers\Admin\CirculationController::class, 'searchMember'])->name('search_member');
        Route::post('/start', [\App\Http\Controllers\Admin\CirculationController::class, 'start'])->name('start');
        Route::get('/transaction/{member_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'transaction'])->name('transaction');
        Route::post('/loan/{member_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'storeLoan'])->name('loan.store');
        Route::post('/return/{loan_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'returnLoan'])->name('return');
        Route::post('/extend/{loan_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'extendLoan'])->name('extend');
        Route::get('/lookup-loan', [\App\Http\Controllers\Admin\CirculationController::class, 'getLoanDetails'])->name('lookup_loan');
        Route::get('/lookup-item', [\App\Http\Controllers\Admin\CirculationController::class, 'getItemDetails'])->name('lookup_item');
        Route::get('/quick-return', [\App\Http\Controllers\Admin\CirculationController::class, 'quickReturn'])->name('quick_return');
        Route::get('/search-loan', [\App\Http\Controllers\Admin\CirculationController::class, 'searchLoan'])->name('search_loan');
        Route::get('/search-item', [\App\Http\Controllers\Admin\CirculationController::class, 'searchItem'])->name('search_item');
        Route::post('/process-quick-return', [\App\Http\Controllers\Admin\CirculationController::class, 'processQuickReturn'])->name('process_quick_return');
        Route::get('/history', [\App\Http\Controllers\Admin\CirculationController::class, 'history'])->name('history');
        Route::get('/history/export', [\App\Http\Controllers\Admin\CirculationController::class, 'exportHistory'])->name('history.export');
        Route::get('/overdue', [\App\Http\Controllers\Admin\CirculationController::class, 'overdue'])->name('overdue');
        Route::post('/overdue/notify/{loan_id}', [\App\Http\Controllers\Admin\CirculationController::class, 'notifyOverdue'])->name('overdue.notify');
        Route::get('/reservations', [\App\Http\Controllers\Admin\CirculationController::class, 'reservations'])->name('reservations');
        Route::post('/reservations/approve/{id}', [\App\Http\Controllers\Admin\CirculationController::class, 'approveReservation'])->name('reservations.approve');
        Route::post('/reservations/handover/{id}', [\App\Http\Controllers\Admin\CirculationController::class, 'handoverReservation'])->name('reservations.handover');
        Route::post('/reservations/reject/{id}', [\App\Http\Controllers\Admin\CirculationController::class, 'rejectReservation'])->name('reservations.reject');
        Route::post('/reservations/cancel/{id}', [\App\Http\Controllers\Admin\CirculationController::class, 'cancelReservation'])->name('reservations.cancel');
        
        Route::get('/reservations/search-biblio', [\App\Http\Controllers\Admin\CirculationController::class, 'searchBiblio'])->name('reservations.search_biblio');
        Route::post('/reservations/store', [\App\Http\Controllers\Admin\CirculationController::class, 'storeReservation'])->name('reservations.store');

        // Reservation Settings
        Route::get('/reservations/settings', [\App\Http\Controllers\Admin\ReservationSettingController::class, 'index'])->name('reservations.settings');
        Route::post('/reservations/settings', [\App\Http\Controllers\Admin\ReservationSettingController::class, 'update'])->name('reservations.settings.update');
        
        Route::get('/rules', [\App\Http\Controllers\Admin\CirculationController::class, 'rules'])->name('rules');
    });

    // ==========================================
    // MASTER FILES (DAFTAR TERKENDALI & REFERENSI)
    // ==========================================
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/terkendali', [\App\Http\Controllers\Admin\MasterFileController::class, 'terkendali'])->name('terkendali');
        Route::get('/referensi', [\App\Http\Controllers\Admin\MasterFileController::class, 'referensi'])->name('referensi');
        Route::get('/peralatan', [\App\Http\Controllers\Admin\MasterFileController::class, 'peralatan'])->name('peralatan');
        Route::get('/placeholder/{type}/{current}', [\App\Http\Controllers\Admin\MasterFileController::class, 'placeholder'])->name('placeholder');
    });

    // Daftar Terkendali & Referensi Modules
    $masterModules = [
        'gmd' => \App\Http\Controllers\Admin\GmdController::class,
        'content_type' => \App\Http\Controllers\Admin\ContentTypeController::class,
        'media_type' => \App\Http\Controllers\Admin\MediaTypeController::class,
        'carrier_type' => \App\Http\Controllers\Admin\CarrierTypeController::class,
        'publisher' => \App\Http\Controllers\Admin\PublisherController::class,
        'supplier' => \App\Http\Controllers\Admin\SupplierController::class,
        'author' => \App\Http\Controllers\Admin\AuthorController::class,
        'topic' => \App\Http\Controllers\Admin\TopicController::class,
        'location' => \App\Http\Controllers\Admin\LocationController::class,
        'place' => \App\Http\Controllers\Admin\PlaceController::class,
        'item_status' => \App\Http\Controllers\Admin\ItemStatusController::class,
        'coll_type' => \App\Http\Controllers\Admin\CollTypeController::class,
        'language' => \App\Http\Controllers\Admin\LanguageController::class,
        'label' => \App\Http\Controllers\Admin\LabelController::class,
        'frequency' => \App\Http\Controllers\Admin\FrequencyController::class,
    ];

    foreach ($masterModules as $prefix => $controller) {
        Route::get("{$prefix}/import", [$controller, 'import'])->name("{$prefix}.import");
        Route::post("{$prefix}/import", [$controller, 'processImport'])->name("{$prefix}.process_import");
        Route::get("{$prefix}/export", [$controller, 'export'])->name("{$prefix}.export");
        Route::resource($prefix, $controller);
    }

    // ==========================================
    // PERALATAN (TOOLS / SETTINGS)
    // ==========================================
    Route::get('visitor/export', [\App\Http\Controllers\Admin\VisitorCountController::class, 'export'])->name('visitor.export');
    Route::resource('visitor', \App\Http\Controllers\Admin\VisitorCountController::class)->only(['index', 'destroy']);
    
    Route::resource('comment', \App\Http\Controllers\Admin\CommentController::class)->only(['index', 'destroy']);
    
    Route::resource('server', \App\Http\Controllers\Admin\ServerController::class);
    
    Route::get('setting/item-pattern', [\App\Http\Controllers\Admin\SettingController::class, 'itemPattern'])->name('setting.item_pattern');
    Route::post('setting/item-pattern', [\App\Http\Controllers\Admin\SettingController::class, 'storeItemPattern'])->name('setting.item_pattern.store');
    Route::post('setting/item-pattern/destroy', [\App\Http\Controllers\Admin\SettingController::class, 'destroyItemPattern'])->name('setting.item_pattern.destroy');

    Route::get('orphan/{type}', [\App\Http\Controllers\Admin\OrphanDataController::class, 'index'])->name('orphan.index');
    Route::delete('orphan/{type}/destroy-all', [\App\Http\Controllers\Admin\OrphanDataController::class, 'destroyAll'])->name('orphan.destroyAll');

    // ==========================================
    // INVENTARISASI (STOCK TAKE)
    // ==========================================
    Route::prefix('inventarisasi')->name('inventarisasi.')->group(function () {
        Route::get('/rekaman', [\App\Http\Controllers\Admin\StockTakeController::class, 'rekaman'])->name('rekaman');
        Route::get('/inisialisasi', [\App\Http\Controllers\Admin\StockTakeController::class, 'inisialisasi'])->name('inisialisasi');
        Route::post('/init', [\App\Http\Controllers\Admin\StockTakeController::class, 'initAction'])->name('init');
        Route::post('/finish/{id}', [\App\Http\Controllers\Admin\StockTakeController::class, 'finishAction'])->name('finish');
        Route::post('/scan', [\App\Http\Controllers\Admin\StockTakeController::class, 'scanBarcode'])->name('scan');
        Route::post('/import', [\App\Http\Controllers\Admin\StockTakeController::class, 'importUpload'])->name('import');
        Route::get('/export/{id}/{type}', [\App\Http\Controllers\Admin\StockTakeController::class, 'exportCsv'])->name('export');
    });

    // ==========================================
    // SISTEM MODULES (SYSTEM CONFIGURATION)
    // ==========================================
    Route::prefix('sistem')->name('sistem.')->group(function () {
        // --- Konten (CMS) ---
        Route::delete('konten/bulk-delete', [\App\Http\Controllers\Admin\SystemContentController::class, 'bulkDelete'])->name('konten.bulk_delete');
        Route::resource('konten', \App\Http\Controllers\Admin\SystemContentController::class);
        
        // Backup
        Route::get('/backup', [\App\Http\Controllers\Admin\SystemBackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/run', [\App\Http\Controllers\Admin\SystemBackupController::class, 'runBackup'])->name('backup.run');
        
        // Role & Permission
        Route::get('/role/import', [\App\Http\Controllers\Admin\SystemRoleController::class, 'import'])->name('role.import');
        Route::post('/role/import', [\App\Http\Controllers\Admin\SystemRoleController::class, 'processImport'])->name('role.process_import');
        Route::get('/role/export', [\App\Http\Controllers\Admin\SystemRoleController::class, 'export'])->name('role.export');
        Route::get('/role/{id}/permissions', [\App\Http\Controllers\Admin\SystemRoleController::class, 'permissions'])->name('role.permissions');
        Route::post('/role/{id}/permissions', [\App\Http\Controllers\Admin\SystemRoleController::class, 'savePermissions'])->name('role.permissions.save');
        Route::resource('role', \App\Http\Controllers\Admin\SystemRoleController::class);
        
        // Aktifitas Staff
        Route::get('/aktifitas', [\App\Http\Controllers\Admin\SystemActivityController::class, 'index'])->name('aktifitas.index');
        Route::post('/aktifitas/toggle-user/{id}', [\App\Http\Controllers\Admin\SystemActivityController::class, 'toggleUserStatus'])->name('aktifitas.toggle_user');
        
        // Manajemen Staff (CRUD akun admin/staff)
        Route::get('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [\App\Http\Controllers\Admin\StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{id}/edit', [\App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('staff.destroy');
        Route::post('/staff/{id}/toggle', [\App\Http\Controllers\Admin\StaffController::class, 'toggleStatus'])->name('staff.toggle');

        // Plugin (CSP)
        Route::get('/plugin/csp', [\App\Http\Controllers\Admin\SystemPluginController::class, 'cspIndex'])->name('plugin.csp');
        Route::post('/plugin/csp', [\App\Http\Controllers\Admin\SystemPluginController::class, 'cspStore'])->name('plugin.csp.store');
    });

    // Pelaporan (Reports)
    Route::prefix('pelaporan')->name('pelaporan.')->group(function () {
        Route::get('/laporan-ketua', [\App\Http\Controllers\Admin\ReportController::class, 'laporanKetua'])->name('laporan_ketua');
        Route::get('/statistik-koleksi', [\App\Http\Controllers\Admin\ReportController::class, 'statistikKoleksi'])->name('statistik_koleksi');
        Route::get('/laporan-peminjaman', [\App\Http\Controllers\Admin\ReportController::class, 'laporanPeminjaman'])->name('laporan_peminjaman');
        Route::get('/laporan-anggota', [\App\Http\Controllers\Admin\ReportController::class, 'laporanAnggota'])->name('laporan_anggota');
        Route::get('/koleksi-perpustakaan', [\App\Http\Controllers\Admin\ReportController::class, 'koleksiPerpustakaan'])->name('koleksi_perpustakaan');
        Route::get('/data-klasifikasi', [\App\Http\Controllers\Admin\ReportController::class, 'dataKlasifikasi'])->name('data_klasifikasi');
        Route::get('/laporan-pengunjung', [\App\Http\Controllers\Admin\ReportController::class, 'laporanPengunjung'])->name('laporan_pengunjung');
        Route::get('/laporan-denda', [\App\Http\Controllers\Admin\ReportController::class, 'laporanDenda'])->name('laporan_denda');
    });

    // Kegiatan (Acara/Campaign, Agenda, Jurnal)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function() {
        Route::post('/acara/{id}/toggle', [\App\Http\Controllers\Admin\EventController::class, 'toggleActive'])->name('acara.toggle');
        Route::resource('acara', \App\Http\Controllers\Admin\EventController::class);
        Route::resource('agenda', \App\Http\Controllers\Admin\AgendaController::class);
        Route::resource('jurnal', \App\Http\Controllers\Admin\JurnalController::class);
        
        // Struktur Komunitas
        Route::get('/struktur', [\App\Http\Controllers\Admin\CommunityStructureController::class, 'index'])->name('struktur.index');
        Route::put('/struktur/{id}/static', [\App\Http\Controllers\Admin\CommunityStructureController::class, 'updateStatic'])->name('struktur.updateStatic');
        Route::post('/struktur/division', [\App\Http\Controllers\Admin\CommunityStructureController::class, 'storeDivision'])->name('struktur.storeDivision');
        Route::put('/struktur/division/{id}', [\App\Http\Controllers\Admin\CommunityStructureController::class, 'updateDivision'])->name('struktur.updateDivision');
        Route::delete('/struktur/division/{id}', [\App\Http\Controllers\Admin\CommunityStructureController::class, 'destroyDivision'])->name('struktur.destroyDivision');
    });
});
