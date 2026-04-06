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
}
