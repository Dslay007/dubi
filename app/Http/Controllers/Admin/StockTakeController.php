<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gmd;
use App\Models\CollType;
use App\Models\Location;
use Carbon\Carbon;

class StockTakeController extends Controller
{
    /**
     * Tampilan Menu Inisialisasi
     */
    public function inisialisasi()
    {
        $gmds = Gmd::orderBy('gmd_name')->get();
        $collTypes = CollType::orderBy('coll_type_name')->get();
        $locations = Location::orderBy('location_name')->get();
        
        // Cek apakah ada stock take yang aktif (is_active = 1)
        $activeStockTake = DB::table('stock_take')->where('is_active', 1)->first();

        return view('admin.inventarisasi.inisialisasi', compact('gmds', 'collTypes', 'locations', 'activeStockTake'));
    }

    /**
     * Tampilan Menu Rekaman Inventaris
     */
    public function rekaman()
    {
        $activeStockTake = DB::table('stock_take')->where('is_active', 1)->first();
        
        $stockTakeItems = [];
        $archives = DB::table('stock_take')->orderBy('start_date', 'desc')->get();

        if ($activeStockTake) {
            $stockTakeItems = DB::table('stock_take_item')
                                ->where('stock_take_id', $activeStockTake->stock_take_id)
                                ->orderBy('last_update', 'desc')
                                ->paginate(50);
        }

        return view('admin.inventarisasi.rekaman', compact('activeStockTake', 'stockTakeItems', 'archives'));
    }

    /**
     * Proses Inisialisasi Angka (Membuat Sesi Inventaris Baru)
     */
    public function initAction(Request $request)
    {
        $request->validate([
            'stock_take_name' => 'required|string|max:200'
        ]);

        // Cek jika ada yang masih aktif, matikan dulu atau beri pesan error.
        // Di SLiMS 9, kita cuma bisa punya 1 stock take aktif.
        $activeStockTake = DB::table('stock_take')->where('is_active', 1)->first();
        if ($activeStockTake) {
            return back()->with('error', 'Sesi inventarisasi lain sedang aktif. Harap selesaikan sesi tersebut terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            // 1. Buat sesi stock_take
            $stockTakeId = DB::table('stock_take')->insertGetId([
                'stock_take_name' => $request->stock_take_name,
                'start_date' => Carbon::now(),
                'init_user' => auth()->user()->username ?? 'admin',
                'is_active' => 1,
                'total_item_exists' => 0
            ]);

            // 2. Filter query item (Sesuai SLiMS)
            $itemQuery = DB::table('item')->join('biblio', 'item.biblio_id', '=', 'biblio.biblio_id');

            if ($request->filled('gmd_id')) {
                $itemQuery->where('biblio.gmd_id', $request->gmd_id);
            }
            if ($request->filled('coll_type_id')) {
                $itemQuery->where('item.coll_type_id', $request->coll_type_id);
            }
            if ($request->filled('location_id')) {
                $itemQuery->where('item.location_id', $request->location_id);
            }

            $items = $itemQuery->select(
                'item.item_id', 'item.item_code', 'biblio.title', 
                'biblio.classification', 'item.call_number', 
                'item.location_id', 'item.coll_type_id', 'biblio.gmd_id'
            )->get();

            // 3. Masukkan ke tabel stock_take_item dengan status 'm' (Missing/Hilang)
            // Di SLiMS statusnya: 'e' (Exists), 'm' (Missing), 'l' (Loan)
            $totalItem = 0;
            $totalLoan = 0;
            
            $insertData = [];
            foreach ($items as $itm) {
                // SLiMS mengecek apakah buku sedang dipinjam (loan)
                $isLoan = DB::table('loan')->where('item_code', $itm->item_code)->where('is_return', 0)->exists();
                $status = $isLoan ? 'l' : 'm';
                
                if ($isLoan) $totalLoan++;
                $totalItem++;

                // Ambil text gmd_name, coll_type_name, location_name
                $gmdName = DB::table('mst_gmd')->where('gmd_id', $itm->gmd_id)->value('gmd_name');
                $collName = DB::table('mst_coll_type')->where('coll_type_id', $itm->coll_type_id)->value('coll_type_name');
                $locName = DB::table('mst_location')->where('location_id', $itm->location_id)->value('location_name');

                $insertData[] = [
                    'stock_take_id' => $stockTakeId,
                    'item_id' => $itm->item_id,
                    'item_code' => $itm->item_code,
                    'title' => substr($itm->title, 0, 250),
                    'gmd_name' => substr($gmdName, 0, 30),
                    'classification' => substr($itm->classification, 0, 30),
                    'coll_type_name' => substr($collName, 0, 30),
                    'call_number' => substr($itm->call_number, 0, 50),
                    'location' => substr($locName, 0, 100),
                    'status' => $status,
                    'checked_by' => auth()->user()->username ?? 'admin',
                    'last_update' => Carbon::now()
                ];
                
                // Chunk insert jika besar
                if (count($insertData) >= 500) {
                    DB::table('stock_take_item')->insert($insertData);
                    $insertData = [];
                }
            }
            if (count($insertData) > 0) {
                DB::table('stock_take_item')->insert($insertData);
            }

            // Update total di tabel utama
            DB::table('stock_take')->where('stock_take_id', $stockTakeId)->update([
                'total_item_stock_taked' => $totalItem,
                'total_item_lost' => $totalItem - $totalLoan,
                'total_item_loan' => $totalLoan
            ]);

            DB::commit();

            return redirect()->route('admin.inventarisasi.rekaman')->with('success', "Proses Inisialisasi berhasil. Sesi '{$request->stock_take_name}' dimulai. {$totalItem} Eksemplar berhasil dimuat.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Proses Finish Stock Take
     */
    public function finishAction($id)
    {
        DB::table('stock_take')->where('stock_take_id', $id)->update([
            'is_active' => 0,
            'end_date' => Carbon::now()
        ]);
        
        return back()->with('success', 'Sesi Inventarisasi telah diselesaikan.');
    }

    /**
     * Scan Barcode untuk merekam (Current Stock Take)
     */
    public function scanBarcode(Request $request)
    {
        $request->validate(['item_code' => 'required|string']);
        $itemCode = $request->item_code;

        $activeStockTake = DB::table('stock_take')->where('is_active', 1)->first();
        if (!$activeStockTake) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => 'Tidak ada sesi inventarisasi yang aktif.']);
            return back()->with('error', 'Tidak ada sesi inventarisasi yang aktif.');
        }

        $stItem = DB::table('stock_take_item')
                    ->where('stock_take_id', $activeStockTake->stock_take_id)
                    ->where('item_code', $itemCode)
                    ->first();

        if (!$stItem) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => "Barcode '{$itemCode}' tidak ditemukan dalam daftar inventarisasi sesi ini."]);
            return back()->with('error', "Barcode '{$itemCode}' tidak ditemukan dalam daftar inventarisasi sesi ini.");
        }

        if ($stItem->status == 'e') {
            if ($request->wantsJson()) return response()->json(['success' => true, 'info' => true, 'message' => "Barcode '{$itemCode}' sudah pernah discan sebelumnya.", 'totals' => $this->getTotals($activeStockTake->stock_take_id)]);
            return back()->with('info', "Barcode '{$itemCode}' sudah pernah discan sebelumnya.");
        }

        // Update status jadi e (Exists)
        DB::table('stock_take_item')
            ->where('stock_take_id', $activeStockTake->stock_take_id)
            ->where('item_code', $itemCode)
            ->update([
                'status' => 'e',
                'checked_by' => auth()->user()->username ?? 'admin',
                'last_update' => Carbon::now()
            ]);

        // Recalculate totals
        $totals = $this->getTotals($activeStockTake->stock_take_id);

        DB::table('stock_take')->where('stock_take_id', $activeStockTake->stock_take_id)->update([
            'total_item_exists' => $totals['exists'],
            'total_item_lost' => $totals['missing'],
            'total_item_loan' => $totals['loan']
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'info' => false,
                'message' => "Barcode '{$itemCode}' berhasil ditemukan (Exists).",
                'totals' => $totals
            ]);
        }

        return back()->with('success', "Barcode '{$itemCode}' berhasil ditemukan (Exists).");
    }

    private function getTotals($stockTakeId)
    {
        return [
            'exists' => DB::table('stock_take_item')->where('stock_take_id', $stockTakeId)->where('status', 'e')->count(),
            'loan' => DB::table('stock_take_item')->where('stock_take_id', $stockTakeId)->where('status', 'l')->count(),
            'missing' => DB::table('stock_take_item')->where('stock_take_id', $stockTakeId)->where('status', 'm')->count(),
        ];
    }

    /**
     * Proses Import (Upload file teks barcode)
     */
    public function importUpload(Request $request)
    {
        $request->validate(['file' => 'required|mimes:txt,csv|max:2048']);

        $activeStockTake = DB::table('stock_take')->where('is_active', 1)->first();
        if (!$activeStockTake) {
            return back()->with('error', 'Tidak ada sesi inventarisasi yang aktif.');
        }

        $fileData = file_get_contents($request->file('file'));
        $barcodes = array_filter(array_map('trim', explode("\n", $fileData)));

        $successCount = 0;
        foreach ($barcodes as $code) {
            $updated = DB::table('stock_take_item')
                ->where('stock_take_id', $activeStockTake->stock_take_id)
                ->where('item_code', $code)
                ->where('status', '!=', 'e') // hanya update yg belum exists
                ->update([
                    'status' => 'e',
                    'checked_by' => auth()->user()->username ?? 'admin',
                    'last_update' => Carbon::now()
                ]);
            if ($updated) {
                $successCount++;
            }
        }

        // Recalculate totals
        $totalExists = DB::table('stock_take_item')->where('stock_take_id', $activeStockTake->stock_take_id)->where('status', 'e')->count();
        $totalMissing = DB::table('stock_take_item')->where('stock_take_id', $activeStockTake->stock_take_id)->where('status', 'm')->count();

        DB::table('stock_take')->where('stock_take_id', $activeStockTake->stock_take_id)->update([
            'total_item_exists' => $totalExists,
            'total_item_lost' => $totalMissing,
        ]);

        return back()->with('success', "Proses import selesai. {$successCount} barcode berhasil diperbarui statusnya menjadi 'Exists'.");
    }

    /**
     * Proses Export ke CSV
     */
    public function exportCsv($id, $type)
    {
        $st = DB::table('stock_take')->where('stock_take_id', $id)->first();
        if (!$st) abort(404);

        $query = DB::table('stock_take_item')->where('stock_take_id', $id);
        
        if ($type == 'lost') {
            $query->where('status', 'm');
            $fileName = "lost_items_{$st->stock_take_name}.csv";
        } else if ($type == 'exists') {
            $query->where('status', 'e');
            $fileName = "exists_items_{$st->stock_take_name}.csv";
        } else {
            $fileName = "all_items_{$st->stock_take_name}.csv";
        }

        $items = $query->orderBy('item_code')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"{$fileName}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Item Code', 'Title', 'GMD', 'Collection Type', 'Classification', 'Call Number', 'Location', 'Status', 'Last Update'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $statusStr = '';
                if($item->status == 'e') $statusStr = 'Exists';
                else if($item->status == 'm') $statusStr = 'Missing';
                else if($item->status == 'l') $statusStr = 'Loan';
                
                fputcsv($file, [
                    $item->item_code,
                    $item->title,
                    $item->gmd_name,
                    $item->coll_type_name,
                    $item->classification,
                    $item->call_number,
                    $item->location,
                    $statusStr,
                    $item->last_update
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
