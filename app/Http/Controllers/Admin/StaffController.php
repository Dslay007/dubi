<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\SystemLog;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $users = DB::table('user')->orderBy('user_id')->get();
        $groups = DB::table('user_group')->pluck('group_name', 'group_id');

        foreach ($users as $user) {
            $groupId = is_numeric($user->groups) ? (int)$user->groups : null;
            
            // Antisipasi format serialize bawaan SLiMS (misal: a:1:{i:0;s:1:"1";})
            if (is_string($user->groups) && strpos($user->groups, 'a:') === 0) {
                $unserialized = @unserialize($user->groups);
                if (is_array($unserialized) && count($unserialized) > 0) {
                    $groupId = (int) $unserialized[0];
                }
            }
            
            $user->group_name = $groupId && isset($groups[$groupId]) ? $groups[$groupId] : 'Tidak ada grup';
            $user->is_active = 1; // SLiMS tidak ada is_active, asumsikan selalu aktif
        }

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
            'password' => ['required', 'string', 'min:8', new StrongPassword],
            'groups'   => 'required|integer|exists:user_group,group_id',
            'email'    => 'nullable|email|max:100',
        ]);

        DB::table('user')->insert([
            'username'   => $request->username,
            'realname'   => $request->realname,
            'passwd'     => Hash::make($request->password),
            'groups'     => $request->groups,
            'email'      => $request->email,
            'user_type'  => 1,
            'input_date' => Carbon::now()->toDateString(),
            'last_update' => Carbon::now()->toDateString(),
        ]);

        SystemLog::write('insert', 'Menambah Staff/Admin Baru: ' . $request->username, 'System', 'Staff');

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
            'password' => ['nullable', 'string', 'min:8', new StrongPassword],
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
            $data['passwd'] = Hash::make($request->password);
        }

        DB::table('user')->where('user_id', $id)->update($data);

        // Clear permission cache if role changed
        if ($staff->groups != $request->groups) {
            session()->forget('user_permissions_' . $id);
        }

        SystemLog::write('update', 'Mengubah Data Staff/Admin: ' . $request->username, 'System', 'Staff');

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

        $staff = DB::table('user')->where('user_id', $id)->first();
        if ($staff) {
            DB::table('user')->where('user_id', $id)->delete();
            SystemLog::write('delete', 'Menghapus Staff/Admin: ' . $staff->username, 'System', 'Staff');
        }

        return back()->with('success', 'Akun staff berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        return back()->with('error', 'Maaf, SLiMS tidak mendukung fitur penonaktifan admin. Silakan hapus akun jika tidak diperlukan.');
    }
}
