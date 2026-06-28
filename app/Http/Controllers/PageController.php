<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Item;
use App\Models\Agenda;
use App\Models\Event;
use App\Models\Jurnal;
use App\Models\CommunityStructure;

class PageController extends Controller
{
    public function landing()
    {
        $stats = [
            'borrowings' => Loan::count(),
            'members' => Member::count(),
            'books' => Item::count(),
        ];

        $upcomingEvents = Agenda::where('event_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->orderBy('event_date', 'asc')
            ->take(4)
            ->get();

        $pastEvents = Agenda::where('event_date', '<', now()->toDateString())
            ->where('is_active', true)
            ->orderBy('event_date', 'desc')
            ->take(4)
            ->get();
            
        $campaign = Event::where('is_active', true)->first();
        
        $jurnals = Jurnal::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('stats', 'upcomingEvents', 'pastEvents', 'campaign', 'jurnals'));
    }

    public function struktur()
    {
        $founders = CommunityStructure::where('type', 'founder')->get();
        $cores = CommunityStructure::where('type', 'core')->get();
        $divisions = CommunityStructure::where('type', 'division')->get();
        return view('pages.struktur', compact('founders', 'cores', 'divisions'));
    }

    public function jurnal()
    {
        $jurnals = Jurnal::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('pages.jurnal', compact('jurnals'));
    }

    public function jurnalDetail($id)
    {
        $jurnal = Jurnal::where('is_published', true)->findOrFail($id);
        return view('pages.jurnal_detail', compact('jurnal'));
    }
}
