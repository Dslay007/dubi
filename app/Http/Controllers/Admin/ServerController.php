<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Server;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $query = Server::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('uri', 'like', "%{$search}%");
        }
        $servers = $query->orderBy('last_update', 'desc')->paginate(15)->appends($request->all());
        return view('admin.server.index', compact('servers'));
    }

    public function create()
    {
        return view('admin.server.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'uri' => 'required|string',
            'server_type' => 'required|integer',
        ]);

        $item = new Server();
        $item->name = $validated['name'];
        $item->uri = $validated['uri'];
        $item->server_type = $validated['server_type'];
        $item->input_date = now();
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.server.index')->with('success', 'Server berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $server = Server::findOrFail($id);
        return view('admin.server.edit', compact('server'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'uri' => 'required|string',
            'server_type' => 'required|integer',
        ]);

        $item = Server::findOrFail($id);
        $item->name = $validated['name'];
        $item->uri = $validated['uri'];
        $item->server_type = $validated['server_type'];
        $item->last_update = now();
        $item->save();

        return redirect()->route('admin.server.index')->with('success', 'Server berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Server::destroy($id);
        return back()->with('success', 'Server berhasil dihapus.');
    }
}
