<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Helpers\SystemLog;
use App\Rules\StrongPassword;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('member_type_id')) {
            $query->where('member_type_id', $request->member_type_id);
        }

        $sort = $request->input('sort', 'last_update');
        $order = $request->input('order', 'desc');

        $allowedSorts = ['member_name', 'member_id', 'last_update'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'last_update';
        }
        $order = $order === 'asc' ? 'asc' : 'desc';

        $members = $query->orderBy($sort, $order)->paginate(15)->appends($request->all());
        $memberTypes = \App\Models\MemberType::all();

        return view('admin.member.index', compact('members', 'memberTypes'));
    }

    public function create()
    {
        return view('admin.member.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|unique:member,member_id',
            'member_name' => 'required',
            'passwd' => ['required', 'min:8', new StrongPassword],
            'member_email' => 'nullable|email|unique:member,member_email',
            'member_phone' => 'nullable|unique:member,member_phone',
            'gender' => 'required',
            'member_type_id' => 'required',
        ]);

        $member = new Member();
        $member->member_id = $validated['member_id'];
        $member->member_name = $validated['member_name'];
        // Password di-hash dengan Bcrypt (standar Laravel yang aman)
        // Login controller sudah mendukung auto-upgrade dari SHA256/MD5 lama
        $member->mpasswd = Hash::make($validated['passwd']);
        $member->gender = $validated['gender'];
        $member->member_type_id = $validated['member_type_id'];
        $member->member_email = $validated['member_email'] ?? null;
        $member->member_phone = $validated['member_phone'] ?? null;
        $member->input_date = now();
        $member->last_update = now();
        $member->save();

        // Catat log aktifitas
        SystemLog::write('insert', 'Menambah Anggota Baru: ' . $member->member_id . ' - ' . $member->member_name, 'Membership', 'Member');

        return redirect()->route('admin.member.index')->with('success', 'Member registered successfully!');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $memberTypes = \App\Models\MemberType::all();
        return view('admin.member.edit', compact('member', 'memberTypes'));
    }

    public function show($id)
    {
        $member = Member::with('memberType')->findOrFail($id);
        return view('admin.member.show', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'member_name' => 'required',
            'birth_date' => 'nullable|date',
            'member_since_date' => 'nullable|date',
            'register_date' => 'nullable|date',
            'expire_date' => 'required|date',
            'inst_name' => 'nullable',
            'member_type_id' => 'required',
            'gender' => 'required',
            'member_address' => 'nullable',
            'postal_code' => 'nullable',
            'member_mail_address' => 'nullable',
            'member_fax' => 'nullable',
            'member_notes' => 'nullable',
            'is_pending' => 'nullable|boolean',
            'member_email' => ['nullable', 'email', \Illuminate\Validation\Rule::unique('member', 'member_email')->ignore($member->member_id, 'member_id')],
            'member_phone' => ['nullable', \Illuminate\Validation\Rule::unique('member', 'member_phone')->ignore($member->member_id, 'member_id')],
            'passwd' => ['nullable', 'min:8', 'confirmed', new StrongPassword],
            'member_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member->member_name = $validated['member_name'];
        $member->birth_date = $validated['birth_date'] ?? null;
        $member->member_since_date = $validated['member_since_date'] ?? null;
        $member->register_date = $validated['register_date'] ?? null;
        $member->expire_date = $validated['expire_date'];
        $member->inst_name = $validated['inst_name'] ?? null;
        $member->member_type_id = $validated['member_type_id'];
        $member->gender = $validated['gender'];
        $member->member_address = $validated['member_address'] ?? null;
        $member->postal_code = $validated['postal_code'] ?? null;
        $member->member_mail_address = $validated['member_mail_address'] ?? null;
        $member->member_phone = $validated['member_phone'] ?? null;
        $member->member_fax = $validated['member_fax'] ?? null;
        $member->member_notes = $validated['member_notes'] ?? null;
        $member->is_pending = $request->has('is_pending') ? 1 : 0;
        $member->member_email = $validated['member_email'] ?? null;
        
        if ($request->hasFile('member_image')) {
            $image = $request->file('member_image');
            $imageName = time() . '_' . $image->hashName();
            $image->move(public_path('images/members'), $imageName);
            // Optionally delete old image if needed
            $member->member_image = $imageName;
        }
        
        if (!empty($validated['passwd'])) {
             $member->mpasswd = Hash::make($validated['passwd']);
        }

        $member->last_update = now();
        $member->save();

        // Catat log aktifitas
        SystemLog::write('update', 'Mengubah Data Anggota: ' . $member->member_id . ' - ' . $member->member_name, 'Membership', 'Member');

        return redirect()->route('admin.member.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if ($member) {
            $memberId = $member->member_id;
            $memberName = $member->member_name;
            $member->delete();
            SystemLog::write('delete', 'Menghapus Anggota: ' . $memberId . ' - ' . $memberName, 'Membership', 'Member');
        }
        return redirect()->route('admin.member.index')->with('success', 'Member deleted successfully!');
    }

    public function export()
    {
        $fileName = 'members_export_' . date('Y-m-d_H-i') . '.csv';
        $members = Member::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['member_id', 'member_name', 'gender', 'member_type_id', 'member_email', 'member_phone', 'member_address'];

        $callback = function() use($members, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); // Use semicolon for better Excel compatibility

            foreach ($members as $member) {
                $row['member_id']  = $member->member_id;
                $row['member_name']    = $member->member_name;
                $row['gender']  = $member->gender;
                $row['member_type_id']  = $member->member_type_id;
                $row['member_email']  = $member->member_email;
                $row['member_phone']  = $member->member_phone;
                $row['member_address']  = $member->member_address;

                fputcsv($file, array($row['member_id'], $row['member_name'], $row['gender'], $row['member_type_id'], $row['member_email'], $row['member_phone'], $row['member_address']), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import()
    {
        return view('admin.member.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');
        
        // Skip header
        $header = fgetcsv($handle, 1000, ';');
        // if separator is comma, handle it
        if(count($header) <= 1) {
            rewind($handle);
            $header = fgetcsv($handle, 1000, ',');
            $separator = ',';
        } else {
            $separator = ';';
        }
        
        $insertedCount = 0;
        $updatedCount = 0;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
            if (!isset($data[0]) || empty(trim($data[0]))) continue;
            
            $memberId = $data[0];
            $memberName = $data[1] ?? 'Unknown';
            $gender = $data[2] ?? '1';
            $memberType = $data[3] ?? '1'; // Default type
            $email = $data[4] ?? null;
            $phone = $data[5] ?? null;
            $address = $data[6] ?? null;

            $member = Member::where('member_id', $memberId)->first();
            
            if ($member) {
                // Update based on user instruction (Duplicate ID updates logic)
                $member->member_name = $memberName;
                $member->gender = $gender;
                $member->member_type_id = $memberType;
                $member->member_email = $email;
                $member->member_phone = $phone;
                $member->member_address = $address;
                $member->last_update = now();
                $member->save();
                $updatedCount++;
            } else {
                // Insert
                $member = new Member();
                $member->member_id = $memberId;
                $member->member_name = $memberName;
                $member->gender = $gender;
                $member->member_type_id = $memberType;
                $member->member_email = $email;
                $member->member_phone = $phone;
                $member->member_address = $address;
                $member->mpasswd = Hash::make('123456'); // Default password
                $member->input_date = now();
                $member->last_update = now();
                $member->save();
                $insertedCount++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.member.index')->with('success', "Import Data Anggota selesai. Ditambahkan: $insertedCount, Diperbarui: $updatedCount.");
    }

    public function barcodeIndex(Request $request)
    {
        $memberTypes = \App\Models\MemberType::all();
        
        $query = Member::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('member_type_id')) {
            $query->where('member_type_id', $request->member_type_id);
        }

        $sort = $request->input('sort', 'last_update');
        $order = $request->input('order', 'desc');

        $allowedSorts = ['member_name', 'member_id', 'last_update'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'last_update';
        }
        $order = $order === 'asc' ? 'asc' : 'desc';

        $members = $query->orderBy($sort, $order)->paginate(20)->appends($request->all());

        return view('admin.member.barcode', compact('memberTypes', 'members'));
    }

    public function printBarcodes(Request $request)
    {
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:member,member_id'
        ]);

        $members = Member::whereIn('member_id', $request->members)->get();

        return view('admin.member.print_barcodes', compact('members'));
    }

    public function printBarcodesByFilter(Request $request)
    {
        $query = Member::query();

        // Date Range (Register Date)
        if ($request->filled('date_start')) {
            $query->whereDate('register_date', '>=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $query->whereDate('register_date', '<=', $request->date_end);
        }

        // Member ID Pattern (e.g. 140102%)
        if ($request->filled('member_id_pattern')) {
            $query->where('member_id', 'like', $request->member_id_pattern . '%');
        }
        
        // Member Type Filter
        if ($request->filled('member_type_id')) {
            $query->where('member_type_id', $request->member_type_id);
        }

        // Limit
        $limit = $request->input('limit', 50);
        $members = $query->orderBy('member_id', 'asc')->limit($limit)->get();

        if ($members->isEmpty()) {
            return back()->with('error', 'Tidak ada anggota yang sesuai dengan kriteria filter.');
        }

        return view('admin.member.print_barcodes', compact('members'));
    }

    public function verifikasiIndex(Request $request)
    {
        $query = Member::where('is_pending', 1);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('member_name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('input_date', 'asc');
        } else {
            $query->orderBy('input_date', 'desc');
        }

        $members = $query->paginate(15)->appends($request->all());
        return view('admin.member.verifikasi', compact('members', 'sort'));
    }

    public function approve($id)
    {
        $member = Member::findOrFail($id);
        $member->is_pending = 0;
        $member->register_date = now();
        $member->member_since_date = now();
        $member->expire_date = now()->addMonths(6); // Default 6 bulan
        $member->last_update = now();
        $member->save();

        SystemLog::write('update', 'Memverifikasi Pendaftaran Anggota: ' . $member->member_id, 'Membership', 'Member');

        return response()->json(['success' => true, 'message' => 'Akun berhasil diverifikasi.']);
    }

    public function reject($id)
    {
        $member = Member::findOrFail($id);
        $memberName = $member->member_name;
        $member->delete();
        
        SystemLog::write('delete', 'Menolak Pendaftaran Anggota: ' . $memberName, 'Membership', 'Member');

        return response()->json(['success' => true, 'message' => 'Akun berhasil ditolak dan dihapus.']);
    }

    public function attendance()
    {
        return view('admin.member.attendance');
    }

    public function checkAttendance(Request $request)
    {
        $member = Member::where('member_id', $request->member_id)->first();
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.']);
        }

        $visitCount = \App\Models\VisitorCount::where('member_id', $member->member_id)->count();
        $memberSince = $member->member_since_date ? \Carbon\Carbon::parse($member->member_since_date)->format('d M Y') : '-';

        return response()->json([
            'success' => true,
            'data' => [
                'member_id' => $member->member_id,
                'member_name' => $member->member_name,
                'visit_count' => $visitCount,
                'member_since' => $memberSince,
                'image' => $member->member_image ? asset('storage/member_images/' . $member->member_image) : null
            ]
        ]);
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'member_id' => 'required'
        ], [
            'member_id.required' => 'Input ID atau Nama Anggota diperlukan.'
        ]);

        $member = Member::where('member_id', $request->member_id)
                        ->orWhere('member_name', $request->member_id)
                        ->first();

        if (!$member) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anggota dengan ID atau Nama tersebut tidak ditemukan.']);
            }
            return back()->withErrors(['member_id' => 'Anggota dengan ID atau Nama tersebut tidak ditemukan.']);
        }

        \App\Models\VisitorCount::create([
            'member_id' => $member->member_id,
            'member_name' => $member->member_name,
            'institution' => $member->inst_name ?? '-',
            'checkin_date' => now()
        ]);

        $totalVisits = \App\Models\VisitorCount::where('member_id', $member->member_id)->count();
        
        $isMerchReward = ($totalVisits > 0 && $totalVisits % 6 === 0);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil.',
                'member' => [
                    'name' => $member->member_name,
                   
                    'visit_count' => $totalVisits
                ],
                'merch_reward' => $isMerchReward
            ]);
        }
        
        if ($isMerchReward) {
            return back()->with('success', 'Selamat datang, ' . $member->member_name . '! Absensi berhasil.')
                         ->with('merch_reward', true)
                         ->with('visit_count', $totalVisits);
        }

        return back()->with('success', 'Selamat datang, ' . $member->member_name . '! Absensi berhasil.');
    }

    public function guestCounter()
    {
        $todayCount = \App\Models\VisitorCount::whereNull('member_id')
            ->whereDate('checkin_date', today())
            ->count();

        $recentGuests = \App\Models\VisitorCount::whereNull('member_id')
            ->orderBy('checkin_date', 'desc')
            ->take(10)
            ->get();

        return view('admin.member.guest_counter', compact('todayCount', 'recentGuests'));
    }

    public function storeGuestVisit(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
        ], [
            'guest_name.required' => 'Nama tamu wajib diisi.',
        ]);

        \App\Models\VisitorCount::create([
            'member_id' => null,
            'member_name' => $request->guest_name,
            'institution' => $request->institution ?? '-',
            'checkin_date' => now(),
        ]);

        $todayCount = \App\Models\VisitorCount::whereNull('member_id')
            ->whereDate('checkin_date', today())
            ->count();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kunjungan tamu berhasil dicatat.',
                'guest_name' => $request->guest_name,
                'today_count' => $todayCount,
            ]);
        }

        return back()->with('success', 'Kunjungan tamu "' . $request->guest_name . '" berhasil dicatat.');
    }
}
