<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberTypeController extends Controller
{
    public function index()
    {
        $memberTypes = \App\Models\MemberType::latest('last_update')->paginate(10);
        return view('admin.member_type.index', compact('memberTypes'));
    }

    public function create()
    {
         return view('admin.member_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_type_name' => 'required|string|max:100',
            'loan_limit' => 'required|integer|min:0',
            'loan_periode' => 'required|integer|min:0', // in days
            'fine_each_day' => 'required|integer|min:0',
            'grace_period' => 'required|integer|min:0'
        ]);

        \App\Models\MemberType::create([
            'member_type_name' => $request->member_type_name,
            'loan_limit' => $request->loan_limit,
            'loan_periode' => $request->loan_periode,
            'fine_each_day' => $request->fine_each_day,
            'grace_period' => $request->grace_period,
            'input_date' => now(),
            'last_update' => now()
        ]);

        return redirect()->route('admin.member_type.index')->with('success', 'Member Type created successfully.');
    }

    public function edit($id)
    {
        $memberType = \App\Models\MemberType::findOrFail($id);
        return view('admin.member_type.edit', compact('memberType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_type_name' => 'required|string|max:100',
            'loan_limit' => 'required|integer|min:0',
            'loan_periode' => 'required|integer|min:0',
            'fine_each_day' => 'required|integer|min:0',
            'grace_period' => 'required|integer|min:0'
        ]);

        $memberType = \App\Models\MemberType::findOrFail($id);
        $memberType->update([
            'member_type_name' => $request->member_type_name,
            'loan_limit' => $request->loan_limit,
            'loan_periode' => $request->loan_periode,
            'fine_each_day' => $request->fine_each_day,
            'grace_period' => $request->grace_period,
            'last_update' => now()
        ]);

        return redirect()->route('admin.member_type.index')->with('success', 'Member Type updated successfully.');
    }

    public function destroy($id)
    {
        $memberType = \App\Models\MemberType::findOrFail($id);
        // Add check if used by members?
        $memberType->delete();
        return back()->with('success', 'Member Type deleted.');
    }

    public function export()
    {
        $fileName = 'member_types_export_' . date('Y-m-d_H-i') . '.csv';
        $memberTypes = \App\Models\MemberType::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['member_type_id', 'member_type_name', 'loan_limit', 'loan_periode', 'fine_each_day', 'grace_period'];

        $callback = function() use($memberTypes, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($memberTypes as $type) {
                $row['member_type_id']  = $type->member_type_id;
                $row['member_type_name']    = $type->member_type_name;
                $row['loan_limit']  = $type->loan_limit;
                $row['loan_periode']  = $type->loan_periode;
                $row['fine_each_day']  = $type->fine_each_day;
                $row['grace_period']  = $type->grace_period;

                fputcsv($file, array($row['member_type_id'], $row['member_type_name'], $row['loan_limit'], $row['loan_periode'], $row['fine_each_day'], $row['grace_period']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.member_type.import');
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
            $typeName = $data[1] ?? null;
            if (empty(trim($typeName))) continue;
            
            $typeId = $data[0] ?? null;
            $loanLimit = $data[2] ?? 0;
            $loanPeriode = $data[3] ?? 0;
            $fineEachDay = $data[4] ?? 0;
            $gracePeriod = $data[5] ?? 0;

            if ($typeId) {
                $memberType = \App\Models\MemberType::where('member_type_id', $typeId)->first();
            } else {
                $memberType = null;
            }
            
            if ($memberType) {
                $memberType->member_type_name = $typeName;
                $memberType->loan_limit = $loanLimit;
                $memberType->loan_periode = $loanPeriode;
                $memberType->fine_each_day = $fineEachDay;
                $memberType->grace_period = $gracePeriod;
                $memberType->last_update = now();
                $memberType->save();
                $updatedCount++;
            } else {
                $memberType = new \App\Models\MemberType();
                if ($typeId) {
                    $memberType->member_type_id = $typeId;
                }
                $memberType->member_type_name = $typeName;
                $memberType->loan_limit = $loanLimit;
                $memberType->loan_periode = $loanPeriode;
                $memberType->fine_each_day = $fineEachDay;
                $memberType->grace_period = $gracePeriod;
                $memberType->input_date = now();
                $memberType->last_update = now();
                $memberType->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.member_type.index')->with('success', "Import Tipe Anggota selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }
}
