<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        $users = DB::table('user')
            ->leftJoin('user_group', 'user.groups', '=', 'user_group.group_id')
            ->select('user.*', 'user_group.group_name')
            ->orderBy('user.user_id')
            ->get();

        return view('admin.sistem.staff.index', compact('users'));
    }

    public function create()
    {
        $roles = DB::table('user_group')->orderBy('group_id')->get();
        return view('admin.sistem.staff.form', ['staff' => null, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:user,username',
            'realname' => 'required|string|max:100',
            'password' => 'required|string|min:4',
            'groups'   => 'required|integer|exists:user_group,group_id',
            'email'    => 'nullable|email|max:100',
        ]);

        DB::table('user')->insert([
            'username'   => $request->username,
            'realname'   => $request->realname,
            'passwd'     => hash('sha256', $request->password),
            'groups'     => $request->groups,
            'email'      => $request->email,
            'user_type'  => 1,
            'is_active'  => 1,
            'input_date' => Carbon::now()->toDateString(),
            'last_update' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('admin.sistem.staff.index')->with('success', 'Akun staff baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $staff = DB::table('user')->where('user_id', $id)->first();
        if (!$staff) abort(404);

        $roles = DB::table('user_group')->orderBy('group_id')->get();
        return view('admin.sistem.staff.form', compact('staff', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $staff = DB::table('user')->where('user_id', $id)->first();
        if (!$staff) abort(404);

        $request->validate([
            'username' => 'required|string|max:50|unique:user,username,' . $id . ',user_id',
            'realname' => 'required|string|max:100',
            'password' => 'nullable|string|min:4',
            'groups'   => 'required|integer|exists:user_group,group_id',
            'email'    => 'nullable|email|max:100',
        ]);

        $data = [
            'username'    => $request->username,
            'realname'    => $request->realname,
            'groups'      => $request->groups,
            'email'       => $request->email,
            'last_update' => Carbon::now()->toDateString(),
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['passwd'] = hash('sha256', $request->password);
        }

        DB::table('user')->where('user_id', $id)->update($data);

        // Clear permission cache if role changed
        if ($staff->groups != $request->groups) {
            session()->forget('user_permissions_' . $id);
        }

        return redirect()->route('admin.sistem.staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cannot delete main admin or self
        if ($id == 1) {
            return back()->with('error', 'Akun Administrator Utama tidak dapat dihapus.');
        }

        if ($id == auth()->guard('admin')->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::table('user')->where('user_id', $id)->delete();

        return back()->with('success', 'Akun staff berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        if ($id == 1 || $id == auth()->guard('admin')->id()) {
            return back()->with('error', 'Tidak dapat mengubah status akun utama atau akun yang sedang digunakan.');
        }

        $user = DB::table('user')->where('user_id', $id)->first();
        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $currentStatus = $user->is_active ?? 1;
        DB::table('user')->where('user_id', $id)->update([
            'is_active' => $currentStatus == 1 ? 0 : 1
        ]);

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }
}
