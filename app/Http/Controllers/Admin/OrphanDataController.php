<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrphanDataController extends Controller
{
    public function index($type, Request $request)
    {
        $viewData = [
            'type' => $type,
            'title' => '',
            'data' => null,
            'deleteRoute' => '',
            'deleteAllRoute' => route('admin.orphan.destroyAll', $type)
        ];

        if ($type == 'author') {
            $viewData['title'] = 'Data Pengarang Tak Terpakai';
            $query = DB::table('mst_author')
                       ->whereNotIn('author_id', function($q) {
                           $q->select('author_id')->from('biblio_author');
                       });
            
            if ($request->filled('search')) {
                $query->where('author_name', 'like', '%' . $request->search . '%');
            }
            
            $viewData['data'] = $query->paginate(15)->appends($request->all());
            $viewData['columns'] = ['ID' => 'author_id', 'Nama Pengarang' => 'author_name'];
            $viewData['deleteRoutePrefix'] = 'admin.author.destroy';
            $viewData['idKey'] = 'author_id';

        } elseif ($type == 'topic') {
            $viewData['title'] = 'Data Subjek Tak Terpakai';
            $query = DB::table('mst_topic')
                       ->whereNotIn('topic_id', function($q) {
                           $q->select('topic_id')->from('biblio_topic');
                       });
                       
            if ($request->filled('search')) {
                $query->where('topic', 'like', '%' . $request->search . '%');
            }
            
            $viewData['data'] = $query->paginate(15)->appends($request->all());
            $viewData['columns'] = ['ID' => 'topic_id', 'Subjek' => 'topic'];
            $viewData['deleteRoutePrefix'] = 'admin.topic.destroy';
            $viewData['idKey'] = 'topic_id';

        } elseif ($type == 'publisher') {
            $viewData['title'] = 'Data Penerbit Tak Terpakai';
            $query = DB::table('mst_publisher')
                       ->whereNotIn('publisher_id', function($q) {
                           $q->select('publisher_id')->from('biblio')->whereNotNull('publisher_id');
                       });
                       
            if ($request->filled('search')) {
                $query->where('publisher_name', 'like', '%' . $request->search . '%');
            }
            
            $viewData['data'] = $query->paginate(15)->appends($request->all());
            $viewData['columns'] = ['ID' => 'publisher_id', 'Nama Penerbit' => 'publisher_name'];
            $viewData['deleteRoutePrefix'] = 'admin.publisher.destroy';
            $viewData['idKey'] = 'publisher_id';

        } elseif ($type == 'place') {
            $viewData['title'] = 'Data Tempat Terbit Tak Terpakai';
            $query = DB::table('mst_place')
                       ->whereNotIn('place_id', function($q) {
                           $q->select('publish_place_id')->from('biblio')->whereNotNull('publish_place_id');
                       });
                       
            if ($request->filled('search')) {
                $query->where('place_name', 'like', '%' . $request->search . '%');
            }
            
            $viewData['data'] = $query->paginate(15)->appends($request->all());
            $viewData['columns'] = ['ID' => 'place_id', 'Tempat Terbit' => 'place_name'];
            $viewData['deleteRoutePrefix'] = 'admin.place.destroy';
            $viewData['idKey'] = 'place_id';
        } else {
            abort(404);
        }

        return view('admin.orphan.index', $viewData);
    }

    public function destroyAll($type)
    {
        if ($type == 'author') {
            DB::table('mst_author')
                ->whereNotIn('author_id', function($q) {
                    $q->select('author_id')->from('biblio_author');
                })->delete();
        } elseif ($type == 'topic') {
            DB::table('mst_topic')
                ->whereNotIn('topic_id', function($q) {
                    $q->select('topic_id')->from('biblio_topic');
                })->delete();
        } elseif ($type == 'publisher') {
            DB::table('mst_publisher')
                ->whereNotIn('publisher_id', function($q) {
                    $q->select('publisher_id')->from('biblio')->whereNotNull('publisher_id');
                })->delete();
        } elseif ($type == 'place') {
            DB::table('mst_place')
                ->whereNotIn('place_id', function($q) {
                    $q->select('publish_place_id')->from('biblio')->whereNotNull('publish_place_id');
                })->delete();
        }

        return back()->with('success', 'Berhasil menghapus seluruh data tak terpakai untuk tipe ini.');
    }
}
