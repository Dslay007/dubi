<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemContentController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('content');

        if ($request->has('search')) {
            $query->where('content_title', 'like', "%{$request->search}%")
                  ->orWhere('content_path', 'like', "%{$request->search}%");
        }

        $contents = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.sistem.konten.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.sistem.konten.form', ['content' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content_title' => 'required|string|max:255',
            'content_path' => 'required|string|max:255|unique:content,content_path',
            'content_desc' => 'required|string',
            'is_news' => 'required|integer',
            'is_concept' => 'required|integer',
            'publish_date' => 'nullable|date'
        ]);

        DB::table('content')->insert([
            'content_title' => $request->content_title,
            'content_path' => $request->content_path,
            'content_desc' => $request->content_desc,
            'is_news' => $request->is_news,
            'content_ownpage' => $request->is_concept == 1 ? '2' : '1', // 2 = Concept/Draft, 1 = Published
            'input_date' => $request->publish_date ?? Carbon::now(),
            'last_update' => Carbon::now()
        ]);

        return redirect()->route('admin.sistem.konten.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $content = DB::table('content')->where('content_path', $id)->first();
        if(!$content) abort(404);
        return view('admin.sistem.konten.form', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content_title' => 'required|string|max:255',
            'content_path' => 'required|string|max:255|unique:content,content_path,'.$id.',content_path',
            'content_desc' => 'required|string',
            'is_news' => 'required|integer',
            'is_concept' => 'required|integer',
            'publish_date' => 'nullable|date'
        ]);

        DB::table('content')->where('content_path', $id)->update([
            'content_title' => $request->content_title,
            'content_path' => $request->content_path,
            'content_desc' => $request->content_desc,
            'is_news' => $request->is_news,
            'content_ownpage' => $request->is_concept == 1 ? '2' : '1',
            'input_date' => $request->publish_date ?? Carbon::now(),
            'last_update' => Carbon::now()
        ]);

        return redirect()->route('admin.sistem.konten.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('content')->where('content_path', $id)->delete();
        return redirect()->route('admin.sistem.konten.index')->with('success', 'Konten berhasil dihapus.');
    }

    // Untuk fitur mass delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if($ids && is_array($ids)){
            DB::table('content')->whereIn('content_path', $ids)->delete();
            return back()->with('success', count($ids) . ' data berhasil dihapus.');
        }
        return back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
