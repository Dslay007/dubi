<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Biblio;
use App\Helpers\SystemLog;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('biblio'); // Eager load book info

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('item_code', 'like', "%{$search}%")
                  ->orWhereHas('biblio', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
        }

        $items = $query->orderBy('last_update', 'desc')->paginate(20);

        return view('admin.item.index', compact('items'));
    }

    public function printBarcodes(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:item,item_id'
        ]);

        $items = Item::with('biblio')
                     ->whereIn('item_id', $request->items)
                     ->get();

        return view('admin.item.barcodes', compact('items'));
    }

    public function printBarcodesByFilter(Request $request)
    {
        $query = Item::with('biblio');

        // Date Range (Received Date / Input Date)
        if ($request->filled('date_start')) {
            $query->whereDate('input_date', '>=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $query->whereDate('input_date', '<=', $request->date_end);
        }

        // Item Code Pattern (e.g. B001%)
        if ($request->filled('item_code_pattern')) {
            $query->where('item_code', 'like', $request->item_code_pattern . '%');
        }
        
        // Item Code Range
        if ($request->filled('item_code_start')) {
             $query->where('item_code', '>=', $request->item_code_start);
        }
        if ($request->filled('item_code_end')) {
             $query->where('item_code', '<=', $request->item_code_end);
        }

        // GMD Filter (through Biblio)
        if ($request->filled('gmd_id')) {
            $query->whereHas('biblio', function($q) use ($request) {
                $q->where('gmd_id', $request->gmd_id);
            });
        }

        // Limit
        $limit = $request->input('limit', 50);
        $items = $query->orderBy('item_code', 'asc')->limit($limit)->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'No items found matching the criteria.');
        }

        return view('admin.item.barcodes', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'biblio_id' => 'required|exists:biblio,biblio_id',
            'item_code' => 'required|string|max:20|unique:item,item_code',
            'call_number' => 'nullable|string|max:50',
            'inventory_code' => 'nullable|string|max:200',
            'location_id' => 'nullable|string|max:3',
            'coll_type_id' => 'nullable|integer',
            'item_status_id' => 'nullable|string|max:3',
            'price' => 'nullable|integer',
            'price_currency' => 'nullable|string|max:10',
            'invoice' => 'nullable|string|max:20',
            'invoice_date' => 'nullable|date',
            'received_date' => 'nullable|date',
            'source' => 'nullable|integer',
            'supplier_id' => 'nullable|string|max:6',
            'order_no' => 'nullable|string|max:20',
            'order_date' => 'nullable|date',
            'site' => 'nullable|string|max:50',
        ]);

        $item = new Item($validated);
        $item->input_date = now();
        $item->last_update = now();
        $item->uid = auth()->id() ?? 1;
        $item->save();

        // Catat log aktifitas
        SystemLog::write('insert', 'Menambah Eksemplar Baru: ' . $item->item_code, 'Bibliography', 'Item');

        return redirect()->back()->with('success', 'Eksemplar baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Item::with('biblio')->findOrFail($id);
        $locations = \App\Models\Location::all();
        $collTypes = \App\Models\CollType::all();
        $itemStatuses = \App\Models\ItemStatus::all();

        return view('admin.item.edit', compact('item', 'locations', 'collTypes', 'itemStatuses'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'item_code' => 'required|string|max:20|unique:item,item_code,' . $id . ',item_id',
            'call_number' => 'nullable|string|max:50',
            'inventory_code' => 'nullable|string|max:200',
            'location_id' => 'nullable|string|max:3',
            'coll_type_id' => 'nullable|integer',
            'item_status_id' => 'nullable|string|max:3',
            'price' => 'nullable|integer',
            'price_currency' => 'nullable|string|max:10',
            'invoice' => 'nullable|string|max:20',
            'invoice_date' => 'nullable|date',
            'received_date' => 'nullable|date',
            'source' => 'nullable|integer',
            'supplier_id' => 'nullable|string|max:6',
            'order_no' => 'nullable|string|max:20',
            'order_date' => 'nullable|date',
            'site' => 'nullable|string|max:50',
        ]);

        $validated['last_update'] = now();
        $item->update($validated);

        // Catat log aktifitas
        SystemLog::write('update', 'Mengubah Eksemplar: ' . $item->item_code, 'Bibliography', 'Item');

        return redirect()->route('admin.item.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $itemCode = $item->item_code;
        $item->delete();

        // Catat log aktifitas
        SystemLog::write('delete', 'Menghapus Eksemplar: ' . $itemCode, 'Bibliography', 'Item');

        return redirect()->back()->with('success', 'Eksemplar berhasil dihapus.');
    }

    public function import()
    {
        return view('admin.item.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        
        $header = fgetcsv($handle, 1000, ';');
        if(count($header) <= 1) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ',');
            $separator = ',';
        } else {
            $separator = ';';
        }
        
        $insertedCount = 0;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
            if (!isset($data[0]) || empty(trim($data[0]))) continue;
            
            $itemCode = $data[0];
            $biblioId = $data[1] ?? null;
            $callNumber = $data[2] ?? null;
            $statusId = $data[3] ?? null; // Nullable if string empty etc

            $item = Item::where('item_code', $itemCode)->first();
            if (!$item && $biblioId) {
                $item = new Item();
                $item->item_code = $itemCode;
                $item->biblio_id = $biblioId;
                $item->call_number = $callNumber;
                if ($statusId) $item->item_status_id = $statusId;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.item.index')->with('success', "Import Eksemplar berhasil. $insertedCount eksemplar ditambahkan.");
    }

    public function export()
    {
        $fileName = 'items_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Item::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Item_Code', 'Biblio_ID', 'Call_Number', 'Item_Status'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $itm) {
                fputcsv($file, array($itm->item_code, $itm->biblio_id, $itm->call_number, $itm->item_status_id), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function outList(Request $request)
    {
        $query = \App\Models\Loan::with(['item.biblio', 'member'])->where('is_return', 0);

        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->whereHas('member', function($sub) use ($q) {
                $sub->where('member_name', 'like', "%{$q}%")
                    ->orWhere('member_id', 'like', "%{$q}%");
            })->orWhereHas('item.biblio', function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%");
            })->orWhere('item_code', 'like', "%{$q}%");
        }

        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('loan_date', '>=', $request->date_start);
        }

        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('loan_date', '<=', $request->date_end);
        }

        $items = $query->orderBy('loan_date', 'desc')->paginate(20)->withQueryString();
        return view('admin.item.out', compact('items'));
    }

    public function exportOutList(Request $request)
    {
        $query = \App\Models\Loan::with(['item.biblio', 'member'])->where('is_return', 0);

        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->whereHas('member', function($sub) use ($q) {
                $sub->where('member_name', 'like', "%{$q}%")
                    ->orWhere('member_id', 'like', "%{$q}%");
            })->orWhereHas('item.biblio', function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%");
            })->orWhere('item_code', 'like', "%{$q}%");
        }

        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('loan_date', '>=', $request->date_start);
        }

        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('loan_date', '<=', $request->date_end);
        }

        $loans = $query->orderBy('loan_date', 'desc')->get();

        $filename = "daftar_eksemplar_keluar_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($loans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Transaksi', 'ID Member', 'Nama Member', 'Kode Eksemplar', 'Judul Buku', 'Tgl Pinjam', 'Batas Kembali']);

            foreach ($loans as $loan) {
                fputcsv($file, [
                    $loan->loan_id,
                    $loan->member_id,
                    $loan->member->member_name ?? '-',
                    $loan->item_code,
                    $loan->item->biblio->title ?? '-',
                    $loan->loan_date,
                    $loan->due_date
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function barcodeIndex()
    {
        $gmds = \App\Models\Gmd::all();
        return view('admin.item.barcode', compact('gmds'));
    }

}
