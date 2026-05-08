<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SystemRoleController;

class CheckMenuAccess
{
    /**
     * Mapping: route pattern => permission key
     * Digunakan untuk memvalidasi akses berdasarkan role user.
     */
    protected static $routePermissionMap = [
        // Dashboard
        'admin.dashboard' => 'dashboard',

        // Sirkulasi
        'admin.circulation.index' => 'sirkulasi.transaksi',
        'admin.circulation.search_member' => 'sirkulasi.transaksi',
        'admin.circulation.start' => 'sirkulasi.transaksi',
        'admin.circulation.transaction' => 'sirkulasi.transaksi',
        'admin.circulation.loan.store' => 'sirkulasi.transaksi',
        'admin.circulation.return' => 'sirkulasi.transaksi',
        'admin.circulation.extend' => 'sirkulasi.transaksi',
        'admin.circulation.lookup_loan' => 'sirkulasi.transaksi',
        'admin.circulation.lookup_item' => 'sirkulasi.transaksi',
        'admin.circulation.quick_return' => 'sirkulasi.pengembalian_kilat',
        'admin.circulation.search_loan' => 'sirkulasi.pengembalian_kilat',
        'admin.circulation.process_quick_return' => 'sirkulasi.pengembalian_kilat',
        'admin.circulation.rules' => 'sirkulasi.aturan_peminjaman',
        'admin.circulation.history' => 'sirkulasi.sejarah_peminjaman',
        'admin.circulation.history.export' => 'sirkulasi.sejarah_peminjaman',
        'admin.circulation.overdue' => 'sirkulasi.daftar_keterlambatan',
        'admin.circulation.overdue.notify' => 'sirkulasi.daftar_keterlambatan',
        'admin.circulation.reservations' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.approve' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.handover' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.reject' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.search_biblio' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.store' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.settings' => 'sirkulasi.reservasi',
        'admin.circulation.reservations.settings.update' => 'sirkulasi.reservasi',

        // Membership
        'admin.member.index' => 'membership.data_anggota',
        'admin.member.create' => 'membership.data_anggota',
        'admin.member.store' => 'membership.data_anggota',
        'admin.member.edit' => 'membership.data_anggota',
        'admin.member.update' => 'membership.data_anggota',
        'admin.member.destroy' => 'membership.data_anggota',
        'admin.member.show' => 'membership.data_anggota',
        'admin.member.import' => 'membership.data_anggota',
        'admin.member.process_import' => 'membership.data_anggota',
        'admin.member.export' => 'membership.data_anggota',
        'admin.member_type.index' => 'membership.tipe_keanggotaan',
        'admin.member_type.create' => 'membership.tipe_keanggotaan',
        'admin.member_type.store' => 'membership.tipe_keanggotaan',
        'admin.member_type.edit' => 'membership.tipe_keanggotaan',
        'admin.member_type.update' => 'membership.tipe_keanggotaan',
        'admin.member_type.destroy' => 'membership.tipe_keanggotaan',
        'admin.member_type.import' => 'membership.tipe_keanggotaan',
        'admin.member_type.process_import' => 'membership.tipe_keanggotaan',
        'admin.member_type.export' => 'membership.tipe_keanggotaan',
        'admin.member.barcode' => 'membership.cetak_kartu',
        'admin.member.print_barcodes' => 'membership.cetak_kartu',
        'admin.member.print_barcodes_filter' => 'membership.cetak_kartu',

        // Bibliografi
        'admin.biblio.index' => 'bibliografi.data_buku',
        'admin.biblio.create' => 'bibliografi.data_buku',
        'admin.biblio.store' => 'bibliografi.data_buku',
        'admin.biblio.edit' => 'bibliografi.data_buku',
        'admin.biblio.update' => 'bibliografi.data_buku',
        'admin.biblio.destroy' => 'bibliografi.data_buku',
        'admin.biblio.import' => 'bibliografi.data_buku',
        'admin.biblio.process_import' => 'bibliografi.data_buku',
        'admin.biblio.export' => 'bibliografi.data_buku',
        'admin.item.index' => 'bibliografi.eksemplar',
        'admin.item.edit' => 'bibliografi.eksemplar',
        'admin.item.update' => 'bibliografi.eksemplar',
        'admin.item.import' => 'bibliografi.eksemplar',
        'admin.item.process_import' => 'bibliografi.eksemplar',
        'admin.item.export' => 'bibliografi.eksemplar',
        'admin.item.out' => 'bibliografi.eksemplar_keluar',
        'admin.item.out.export' => 'bibliografi.eksemplar_keluar',
        'admin.item.barcode' => 'bibliografi.cetak_barcode',
        'admin.item.print_barcodes' => 'bibliografi.cetak_barcode',
        'admin.item.print_barcodes_filter' => 'bibliografi.cetak_barcode',
        'admin.marc.index' => 'bibliografi.marc',
        'admin.marc.import' => 'bibliografi.marc',
        'admin.marc.export' => 'bibliografi.marc',

        // Master files - Terkendali
        'admin.master.terkendali' => 'master.terkendali',
        'admin.gmd.index' => 'master.terkendali',
        'admin.content_type.index' => 'master.terkendali',
        'admin.media_type.index' => 'master.terkendali',
        'admin.carrier_type.index' => 'master.terkendali',
        'admin.publisher.index' => 'master.terkendali',
        'admin.supplier.index' => 'master.terkendali',
        'admin.author.index' => 'master.terkendali',
        'admin.topic.index' => 'master.terkendali',
        // Master files - Referensi
        'admin.master.referensi' => 'master.referensi',
        'admin.location.index' => 'master.referensi',
        'admin.place.index' => 'master.referensi',
        'admin.item_status.index' => 'master.referensi',
        'admin.coll_type.index' => 'master.referensi',
        'admin.language.index' => 'master.referensi',
        'admin.label.index' => 'master.referensi',
        'admin.frequency.index' => 'master.referensi',
        // Master files - Peralatan
        'admin.master.peralatan' => 'master.peralatan',
        'admin.visitor.index' => 'master.peralatan',
        'admin.comment.index' => 'master.peralatan',
        'admin.server.index' => 'master.peralatan',
        'admin.setting.item_pattern' => 'master.peralatan',
        'admin.orphan.index' => 'master.peralatan',

        // Inventarisasi
        'admin.inventarisasi.rekaman' => 'inventarisasi.rekaman',
        'admin.inventarisasi.inisialisasi' => 'inventarisasi.inisialisasi',
        'admin.inventarisasi.init' => 'inventarisasi.inisialisasi',
        'admin.inventarisasi.finish' => 'inventarisasi.inisialisasi',
        'admin.inventarisasi.scan' => 'inventarisasi.inisialisasi',
        'admin.inventarisasi.import' => 'inventarisasi.inisialisasi',
        'admin.inventarisasi.export' => 'inventarisasi.rekaman',

        // Acara
        'admin.acara.berita_acara.index' => 'acara.berita_acara',
        'admin.acara.berita_acara.create' => 'acara.berita_acara',
        'admin.acara.berita_acara.store' => 'acara.berita_acara',
        'admin.acara.berita_acara.edit' => 'acara.berita_acara',
        'admin.acara.berita_acara.update' => 'acara.berita_acara',
        'admin.acara.berita_acara.destroy' => 'acara.berita_acara',
        'admin.acara.pendaftaran.index' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.create' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.store' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.edit' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.update' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.destroy' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.builder' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.fields.store' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.fields.destroy' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.registrants' => 'acara.pendaftaran',
        'admin.acara.pendaftaran.registrants.confirm' => 'acara.pendaftaran',

        // Pelaporan
        'admin.pelaporan.statistik_koleksi' => 'pelaporan.statistik_koleksi',
        'admin.pelaporan.laporan_peminjaman' => 'pelaporan.laporan_peminjaman',
        'admin.pelaporan.laporan_anggota' => 'pelaporan.laporan_anggota',
        'admin.pelaporan.koleksi_perpustakaan' => 'pelaporan.koleksi_perpustakaan',
        'admin.pelaporan.data_klasifikasi' => 'pelaporan.data_klasifikasi',
        'admin.pelaporan.laporan_pengunjung' => 'pelaporan.laporan_pengunjung',
        'admin.pelaporan.laporan_denda' => 'pelaporan.laporan_denda',

        // Sistem
        'admin.sistem.konten.index' => 'sistem.konten',
        'admin.sistem.konten.create' => 'sistem.konten',
        'admin.sistem.konten.store' => 'sistem.konten',
        'admin.sistem.konten.edit' => 'sistem.konten',
        'admin.sistem.konten.update' => 'sistem.konten',
        'admin.sistem.konten.destroy' => 'sistem.konten',
        'admin.sistem.konten.bulk_delete' => 'sistem.konten',
        'admin.sistem.backup.index' => 'sistem.backup',
        'admin.sistem.backup.run' => 'sistem.backup',
        'admin.sistem.role.index' => 'sistem.role',
        'admin.sistem.role.create' => 'sistem.role',
        'admin.sistem.role.store' => 'sistem.role',
        'admin.sistem.role.edit' => 'sistem.role',
        'admin.sistem.role.update' => 'sistem.role',
        'admin.sistem.role.destroy' => 'sistem.role',
        'admin.sistem.role.permissions' => 'sistem.role',
        'admin.sistem.role.permissions.save' => 'sistem.role',
        'admin.sistem.role.import' => 'sistem.role',
        'admin.sistem.role.process_import' => 'sistem.role',
        'admin.sistem.role.export' => 'sistem.role',
        'admin.sistem.staff.index' => 'sistem.staff',
        'admin.sistem.staff.create' => 'sistem.staff',
        'admin.sistem.staff.store' => 'sistem.staff',
        'admin.sistem.staff.edit' => 'sistem.staff',
        'admin.sistem.staff.update' => 'sistem.staff',
        'admin.sistem.staff.destroy' => 'sistem.staff',
        'admin.sistem.staff.toggle' => 'sistem.staff',
        'admin.sistem.aktifitas.index' => 'sistem.aktifitas',
        'admin.sistem.aktifitas.toggle_user' => 'sistem.aktifitas',
        'admin.sistem.plugin.csp' => 'sistem.plugin',
        'admin.sistem.plugin.csp.store' => 'sistem.plugin',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->guard('admin')->user();
        
        // Not logged in - let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // group_id = 1 (Administrator Utama) always has full access
        $groupId = $user->groups ?? null;
        if ($groupId == 1) {
            return $next($request);
        }

        // Get current route name
        $routeName = $request->route()->getName();
        
        if (!$routeName) {
            return $next($request);
        }

        // Check if route has a mapped permission
        $permissionKey = self::$routePermissionMap[$routeName] ?? null;

        // If no mapping found, check by pattern for dynamically registered master module routes
        if (!$permissionKey) {
            $permissionKey = $this->resolveByPattern($routeName);
        }

        // If still no mapping, allow access (unmapped routes are open)
        if (!$permissionKey) {
            return $next($request);
        }

        // Check permission
        if (!SystemRoleController::userHasAccess($permissionKey)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda tidak memiliki akses ke halaman ini.'], 403);
            }
            
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }

    /**
     * Resolve permission by route name pattern for dynamically registered routes
     */
    protected function resolveByPattern($routeName)
    {
        // Master module routes (registered dynamically in web.php)
        $terkendaliModules = ['gmd', 'content_type', 'media_type', 'carrier_type', 'publisher', 'supplier', 'author', 'topic'];
        $referensiModules = ['location', 'place', 'item_status', 'coll_type', 'language', 'label', 'frequency'];

        foreach ($terkendaliModules as $module) {
            if (str_starts_with($routeName, "admin.{$module}.")) {
                return 'master.terkendali';
            }
        }

        foreach ($referensiModules as $module) {
            if (str_starts_with($routeName, "admin.{$module}.")) {
                return 'master.referensi';
            }
        }

        // Peralatan modules
        $peralatanModules = ['visitor', 'comment', 'server', 'setting', 'orphan'];
        foreach ($peralatanModules as $module) {
            if (str_starts_with($routeName, "admin.{$module}.")) {
                return 'master.peralatan';
            }
        }

        return null;
    }
}
