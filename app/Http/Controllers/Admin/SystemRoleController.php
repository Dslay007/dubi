<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemRoleController extends Controller
{
    /**
     * Struktur menu & sub-menu untuk permission.
     * Setiap key = permission key, setiap sub-menu = 1 checkbox.
     * Struktur ini 1:1 mengikuti sidebar di admin.blade.php.
     */
    public static function getMenuStructure()
    {
        return [
            'dashboard' => [
                'label' => 'Dashboard',
                'icon' => 'layout-dashboard',
                'submenus' => [
                    'dashboard' => 'Dashboard',
                ]
            ],
            'sirkulasi' => [
                'label' => 'Sirkulasi',
                'icon' => 'repeat',
                'submenus' => [
                    'sirkulasi.transaksi' => 'Transaksi',
                    'sirkulasi.pengembalian_kilat' => 'Pengembalian Kilat',
                    'sirkulasi.aturan_peminjaman' => 'Aturan Peminjaman',
                    'sirkulasi.sejarah_peminjaman' => 'Sejarah Peminjaman',
                    'sirkulasi.daftar_keterlambatan' => 'Daftar Keterlambatan',
                    'sirkulasi.reservasi' => 'Reservasi',
                ]
            ],
            'membership' => [
                'label' => 'Membership',
                'icon' => 'users',
                'submenus' => [
                    'membership.data_anggota' => 'Data Anggota',
                    'membership.tipe_keanggotaan' => 'Tipe Keanggotaan',
                    'membership.cetak_kartu' => 'Cetak Kartu Anggota',
                ]
            ],
            'bibliografi' => [
                'label' => 'Bibliografi',
                'icon' => 'book-open',
                'submenus' => [
                    'bibliografi.data_buku' => 'Bibliografi (Data Buku)',
                    'bibliografi.eksemplar' => 'Eksemplar',
                    'bibliografi.eksemplar_keluar' => 'Daftar Eksemplar Keluar',
                    'bibliografi.cetak_barcode' => 'Cetak Barcode',
                    'bibliografi.marc' => 'MARC Import/Export',
                ]
            ],
            'master' => [
                'label' => 'Daftar Terkendali',
                'icon' => 'database',
                'submenus' => [
                    'master.terkendali' => 'Daftar Terkendali',
                    'master.referensi' => 'Daftar Referensi',
                    'master.peralatan' => 'Peralatan',
                ]
            ],
            'inventarisasi' => [
                'label' => 'Inventarisasi',
                'icon' => 'clipboard-list',
                'submenus' => [
                    'inventarisasi.rekaman' => 'Rekaman Inventaris',
                    'inventarisasi.inisialisasi' => 'Inisialisasi',
                ]
            ],
            'acara' => [
                'label' => 'Acara',
                'icon' => 'calendar-days',
                'submenus' => [
                    'acara.berita_acara' => 'Berita Acara',
                    'acara.pendaftaran' => 'Form Pendaftaran Kegiatan',
                ]
            ],
            'pelaporan' => [
                'label' => 'Pelaporan',
                'icon' => 'bar-chart-3',
                'submenus' => [
                    'pelaporan.statistik_koleksi' => 'Statistik Koleksi',
                    'pelaporan.laporan_peminjaman' => 'Laporan Peminjaman',
                    'pelaporan.laporan_anggota' => 'Laporan Anggota',
                    'pelaporan.koleksi_perpustakaan' => 'Koleksi Perpustakaan',
                    'pelaporan.data_klasifikasi' => 'Data Klasifikasi',
                    'pelaporan.laporan_pengunjung' => 'Laporan Pengunjung',
                    'pelaporan.laporan_denda' => 'Laporan Denda',
                ]
            ],
            'sistem' => [
                'label' => 'Sistem',
                'icon' => 'settings',
                'submenus' => [
                    'sistem.konten' => 'Konten',
                    'sistem.backup' => 'Salinan Pangkalan',
                    'sistem.role' => 'Role and Permission',
                    'sistem.staff' => 'Manajemen Staff',
                    'sistem.aktifitas' => 'Aktifitas Staff',
                    'sistem.plugin' => 'Plugin (CSP)',
                ]
            ],
        ];
    }

    /**
     * Load permission yang sudah disimpan untuk role tertentu.
     * Returns array of permission keys yang aktif.
     */
    public static function loadPermissions($groupId)
    {
        // group_id = 1 (Admin Utama) selalu full access
        if ($groupId == 1) {
            $allKeys = [];
            foreach (self::getMenuStructure() as $menu) {
                foreach ($menu['submenus'] as $key => $label) {
                    $allKeys[] = $key;
                }
            }
            return $allKeys;
        }

        $row = DB::table('group_access')
            ->where('group_id', $groupId)
            ->first();

        if (!$row || empty($row->menus)) {
            return [];
        }

        $perms = json_decode($row->menus, true);
        return is_array($perms) ? $perms : [];
    }

    /**
     * Check apakah user yang sedang login punya akses ke permission key tertentu.
     */
    public static function userHasAccess($permissionKey)
    {
        $user = auth()->guard('admin')->user();
        if (!$user) return false;

        // group_id = 1 selalu full access
        $groupId = $user->groups ?? null;
        if ($groupId == 1) return true;

        // Cache permissions in session for performance
        $cacheKey = 'user_permissions_' . $user->user_id;
        $perms = session($cacheKey);

        if ($perms === null) {
            $perms = self::loadPermissions($groupId);
            session([$cacheKey => $perms]);
        }

        return in_array($permissionKey, $perms);
    }

    /**
     * Clear cached permissions (call after saving permissions or changing user role)
     */
    public static function clearPermissionCache()
    {
        $user = auth()->guard('admin')->user();
        if ($user) {
            session()->forget('user_permissions_' . $user->user_id);
        }
    }

    public function index()
    {
        $roles = DB::table('user_group')->orderBy('group_id')->get();
        
        // Count staff per role
        foreach ($roles as $role) {
            $role->staff_count = DB::table('user')->where('groups', $role->group_id)->count();
        }
        
        return view('admin.sistem.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.sistem.role.form', ['role' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:50|unique:user_group,group_name'
        ]);

        DB::table('user_group')->insertGetId([
            'group_name' => $request->group_name,
            'input_date' => Carbon::now(),
            'last_update' => Carbon::now()
        ]);

        return redirect()->route('admin.sistem.role.index')->with('success', 'Role baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $role = DB::table('user_group')->where('group_id', $id)->first();
        if (!$role) abort(404);
        return view('admin.sistem.role.form', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name' => 'required|string|max:50|unique:user_group,group_name,' . $id . ',group_id'
        ]);

        DB::table('user_group')->where('group_id', $id)->update([
            'group_name' => $request->group_name,
            'last_update' => Carbon::now()
        ]);

        return redirect()->route('admin.sistem.role.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if ($id == 1) {
            return back()->with('error', 'Role Administrator Utama tidak dapat dihapus.');
        }

        DB::table('user_group')->where('group_id', $id)->delete();
        DB::table('group_access')->where('group_id', $id)->delete();

        return back()->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Halaman "Atur Hak Akses" — checkbox per sub-menu
     */
    public function permissions($id)
    {
        $role = DB::table('user_group')->where('group_id', $id)->first();
        if (!$role) abort(404);

        $menuStructure = self::getMenuStructure();
        $savedPerms = self::loadPermissions($id);

        return view('admin.sistem.role.permissions', compact('role', 'menuStructure', 'savedPerms'));
    }

    /**
     * Simpan hak akses — simpan sebagai array JSON flat dari permission keys
     */
    public function savePermissions(Request $request, $id)
    {
        $role = DB::table('user_group')->where('group_id', $id)->first();
        if (!$role) abort(404);

        // Collect checked permission keys
        $checkedPerms = array_keys($request->input('perms', []));

        // Delete existing & insert new
        DB::table('group_access')->where('group_id', $id)->delete();

        if (!empty($checkedPerms)) {
            DB::table('group_access')->insert([
                'group_id' => $id,
                'module_id' => 1,
                'menus' => json_encode($checkedPerms),
                'r' => 1,
                'w' => 1,
            ]);
        }

        // Clear permission cache for all sessions
        self::clearPermissionCache();

        return redirect()->route('admin.sistem.role.index')->with('success', "Hak akses untuk role \"{$role->group_name}\" berhasil disimpan.");
    }

    /**
     * Export roles as CSV
     */
    public function export()
    {
        $roles = DB::table('user_group')->orderBy('group_id')->get();
        
        $fileName = 'role_export_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($roles) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['group_id', 'group_name']);
            foreach ($roles as $role) {
                fputcsv($handle, [$role->group_id, $role->group_name]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import view
     */
    public function import()
    {
        return view('admin.sistem.role.import');
    }

    /**
     * Process import
     */
    public function processImport(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt|max:2048']);

        $data = file_get_contents($request->file('file'));
        $lines = array_filter(array_map('trim', explode("\n", $data)));

        $imported = 0;
        $header = true;

        foreach ($lines as $line) {
            if ($header) { $header = false; continue; }

            $separator = (substr_count($line, ';') > substr_count($line, ',')) ? ';' : ',';
            $cols = str_getcsv($line, $separator);
            
            if (count($cols) < 2) continue;

            $groupName = trim($cols[1]);
            if (empty($groupName)) continue;

            $existing = DB::table('user_group')->where('group_name', $groupName)->first();
            if (!$existing) {
                DB::table('user_group')->insert([
                    'group_name' => $groupName,
                    'input_date' => Carbon::now(),
                    'last_update' => Carbon::now()
                ]);
                $imported++;
            }
        }

        return redirect()->route('admin.sistem.role.index')->with('success', "{$imported} role baru berhasil diimpor.");
    }
}
