<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
        }
        $suppliers = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:200',
            'contact' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'e_mail' => 'nullable|email|max:80',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:14',
            'account' => 'nullable|string|max:12',
        ]);

        $item = new Supplier();
        $item->fill($validated);
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.supplier.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:200',
            'contact' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'e_mail' => 'nullable|email|max:80',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:14',
            'account' => 'nullable|string|max:12',
        ]);

        $item = Supplier::findOrFail($id);
        $item->fill($validated);
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.supplier.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Supplier::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'supplier_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Supplier::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['supplier_id', 'supplier_name', 'contact', 'phone', 'e_mail', 'address', 'postal_code', 'fax', 'account'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                $row['supplier_id']  = $item->supplier_id;
                $row['supplier_name']    = $item->supplier_name;
                $row['contact']  = $item->contact;
                $row['phone']  = $item->phone;
                $row['e_mail']  = $item->e_mail;
                $row['address']  = $item->address;
                $row['postal_code']  = $item->postal_code;
                $row['fax']  = $item->fax;
                $row['account']  = $item->account;

                fputcsv($file, array($row['supplier_id'], $row['supplier_name'], $row['contact'], $row['phone'], $row['e_mail'], $row['address'], $row['postal_code'], $row['fax'], $row['account']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.supplier.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        
        $header = fgetcsv($handle, 1000, ';');
        if($header && count($header) <= 1) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ',');
            $separator = ',';
        } else {
            $separator = ';';
        }
        
        $insertedCount = 0;
        $updatedCount = 0;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
            $name = $data[1] ?? null;
            if (empty(trim($name))) continue;
            
            $id = $data[0] ?? null;

            if ($id) {
                $item = Supplier::find($id);
            } else {
                $item = null;
            }
            
            if ($item) {
                $item->supplier_name = $name;
                $item->contact = $data[2] ?? null;
                $item->phone = $data[3] ?? null;
                $item->e_mail = $data[4] ?? null;
                $item->address = $data[5] ?? null;
                $item->postal_code = $data[6] ?? null;
                $item->fax = $data[7] ?? null;
                $item->account = $data[8] ?? null;
                $item->last_update = now();
                $item->save();
                $updatedCount++;
            } else {
                $item = new Supplier();
                if ($id) {
                    $item->supplier_id = $id;
                }
                $item->supplier_name = $name;
                $item->contact = $data[2] ?? null;
                $item->phone = $data[3] ?? null;
                $item->e_mail = $data[4] ?? null;
                $item->address = $data[5] ?? null;
                $item->postal_code = $data[6] ?? null;
                $item->fax = $data[7] ?? null;
                $item->account = $data[8] ?? null;
                $item->input_date = now();
                $item->last_update = now();
                $item->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.supplier.index')->with('success', "Import selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}
