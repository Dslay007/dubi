<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biblio;

class ReservationSettingController extends Controller
{
    public function index(Request $request)
    {
        $max_reservations = \Illuminate\Support\Facades\DB::table('setting')
            ->where('setting_name', 'max_reservations')
            ->value('setting_value') ?? 2;

        $query = Biblio::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn_issn', 'like', '%' . $request->search . '%');
        }

        $biblios = $query->orderBy('title', 'asc')->paginate(20);

        return view('admin.circulation.reservation_settings', compact('biblios', 'max_reservations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_reservations' => 'required|integer|min:1',
            'reservable_status' => 'nullable|array',
            'reservable_status.*' => 'boolean'
        ]);

        \Illuminate\Support\Facades\DB::table('setting')->updateOrInsert(
            ['setting_name' => 'max_reservations'],
            ['setting_value' => $request->max_reservations]
        );

        if ($request->has('reservable_status')) {
            foreach ($request->reservable_status as $biblio_id => $status) {
                Biblio::where('biblio_id', $biblio_id)->update(['is_reservable' => $status]);
            }
        }

        return back()->with('success', 'Pengaturan reservasi berhasil disimpan.');
    }
}
