<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Biblio;

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

    public function import()
    {
        return view('admin.item.import');
    }

    public function export()
    {
        // Placeholder
        return redirect()->back();
    }

    public function outList()
    {
        // Placeholder for "Daftar Eksemplar Keluar"
        // In real app, this would query loans where return_date is null
        $items = \App\Models\Loan::with(['item', 'member', 'item.biblio'])->where('is_return', 0)->paginate(20);
        return view('admin.item.out', compact('items'));
    }

    public function barcodeIndex()
    {
        $gmds = \App\Models\Gmd::all();
        return view('admin.item.barcode', compact('gmds'));
    }

}
