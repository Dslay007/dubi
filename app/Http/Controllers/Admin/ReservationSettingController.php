<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biblio;

class ReservationSettingController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'title');
        $order = $request->input('order', 'asc');

        $query = Biblio::with('items');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn_issn', 'like', '%' . $request->search . '%')
                  ->orWhereHas('items', function ($subq) use ($request) {
                      $subq->where('item_code', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('filter_status') && $request->filter_status !== '') {
            $query->where('is_reservable', $request->filter_status);
        }

        $biblios = $query->orderBy($sortBy, $order)->paginate(20)->appends($request->all());

        return view('admin.circulation.reservation_settings', compact('biblios', 'sortBy', 'order'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reservable_status' => 'nullable|array',
            'reservable_status.*' => 'boolean',
            'bulk_action' => 'nullable|string'
        ]);
        if ($request->filled('bulk_action')) {
            if ($request->bulk_action === 'enable_all') {
                Biblio::query()->update(['is_reservable' => 1]);
            } elseif ($request->bulk_action === 'disable_all') {
                Biblio::query()->update(['is_reservable' => 0]);
            }
        } else {
            // Hanya update halaman ini jika tidak ada bulk action
            if ($request->has('reservable_status')) {
                foreach ($request->reservable_status as $biblio_id => $status) {
                    Biblio::where('biblio_id', $biblio_id)->update(['is_reservable' => $status]);
                }
            }
        }

        return back()->with('success', 'Pengaturan reservasi berhasil disimpan.');
    }
}
