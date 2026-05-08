<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $query = Topic::query();

        if ($request->has('search')) {
            $query->where('topic', 'like', "%{$request->search}%");
        }

        $topics = $query->orderBy('last_update', 'desc')->paginate(15);

        return view('admin.topic.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.topic.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:50',
            'topic_type' => 'required|string|in:t,g,n,s,o', 
        ]);

        $topic = new Topic();
        $topic->topic = $request->topic;
        $topic->topic_type = $request->topic_type;
        $topic->auth_list = ''; // Default empty
        $topic->input_date = now();
        $topic->last_update = now();
        $topic->save();

        return redirect()->route('admin.topic.index')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('admin.topic.edit', compact('topic'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:50',
            'topic_type' => 'required|string|in:t,g,n,s,o',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->topic = $request->topic;
        $topic->topic_type = $request->topic_type;
        $topic->last_update = now();
        $topic->save();

        return redirect()->route('admin.topic.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return redirect()->route('admin.topic.index')->with('success', 'Subject deleted successfully.');
    }

    public function import()
    {
        return view('admin.topic.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('file');
        $csvData = file_get_contents($file);
        
        $separator = strpos($csvData, ';') !== false ? ';' : ',';
        $rows = array_map(function($v) use ($separator) { return str_getcsv($v, $separator); }, explode("\n", $csvData));
        $header = array_shift($rows);

        $successCount = 0;
        foreach ($rows as $row) {
            if (count($row) < 2 || empty(trim($row[1]))) continue;

            $id = isset($row[0]) && trim($row[0]) !== '' ? trim($row[0]) : null;
            $topicStr = trim($row[1]);
            $type = isset($row[2]) ? trim($row[2]) : 't';
            $classification = isset($row[3]) ? trim($row[3]) : '';

            $data = [
                'topic' => $topicStr,
                'topic_type' => $type,
                'classification' => $classification,
                'last_update' => now()->toDateString()
            ];

            if ($id) {
                $existing = Topic::find($id);
                if ($existing) {
                    $existing->update($data);
                } else {
                    $data['topic_id'] = $id;
                    $data['input_date'] = now()->toDateString();
                    Topic::create($data);
                }
            } else {
                $data['input_date'] = now()->toDateString();
                Topic::create($data);
            }
            $successCount++;
        }

        return redirect()->route('admin.topic.index')->with('success', "$successCount data berhasil diimpor.");
    }

    public function export()
    {
        $fileName = 'topic_export_' . date('Y-m-d_H-i') . '.csv';
        $items = Topic::orderBy('topic_id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Topic', 'Topic Type', 'Classification'];

        $callback = function() use($items, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($items as $item) {
                fputcsv($file, [$item->topic_id, $item->topic, $item->topic_type, $item->classification], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
